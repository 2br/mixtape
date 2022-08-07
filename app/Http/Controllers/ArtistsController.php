<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class ArtistsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Retrieves the artist list
        $artistList = ArtistsController::getRemoteArtists();
        if( empty($artistList) ) { 
            return redirect()->route('home');
        }       
        return view('artists', ['artistList' => $artistList ]);
    }

    /**
     * Returns an artist list to populate selection
     * @return {array} => array( 'id', 'name', 'twitter' )
     */
    public static function getRemoteArtists()
    {
        // Configs
        $endpoint = env('ARTISTS_ENDPOINT','https://www.moat.ai/api/task/');
        $headers = array('Basic' => 'ZGV2ZWxvcGVyOlpHVjJaV3h2Y0dWeQ==');
        
        // Request the list
        $client = new \GuzzleHttp\Client([ 'headers' => $headers]) ;
        $response = $client->request( 'GET', $endpoint );

        // Response
        $statusCode = $response->getStatusCode();
        if( $statusCode != '200' ) { 
            return array();
        }

        $content = $response->getBody();
        $list = json_decode($content);

        // Extracts to array
        foreach( $list as $key => $artist ) {
            $artistList[$key] = (array)$artist[0];
            // Retrieve informations
            $artistList[$key]['twitterInfo'] = ArtistsController::getTwitterInformation($artist[0]->twitter);
        }
        return $artistList;
    }

    /**
     * Get Twitter information
     * @return {array} => { 'profile_image_url',  'description'}
     */
    private static function getTwitterInformation($twitterUser)
    {
        // Return array
        $twitterInfo = array( 
            'profile_image_url' => asset('images/default.jpg'),
            'description' => ''
        );

        $bearer_token = env('TWITTER_BEARER_TOKEN');
        if( !$bearer_token ) {
            return $twitterInfo;
        }

        // Removes @ if exists, to store in cache and user in request
        $twitterUser = str_replace("@","",$twitterUser); 

        if (Cache::has($twitterUser)) {
            return Cache::get($twitterUser);
        }
        $endpoint = "https://api.twitter.com/2/users/by/username/". $twitterUser . "?user.fields=description,profile_image_url";
        $headers = array('Authorization' => 'Bearer '.$bearer_token);
    
        $client = new \GuzzleHttp\Client([ 'headers' => $headers]) ;
        $response = $client->request( 'GET', $endpoint );

         // Response
        $statusCode = $response->getStatusCode();
        if( $statusCode != '200' ) { 
            return $twitterInfo;
        }

        $content = $response->getBody();
        $content = json_decode($content);
        if( isset($content->errors) ) {
            return $twitterInfo;
        }
         // Adjusts the size of image
        $imgUrl = str_replace("_normal.", "_400x400.", $content->data->profile_image_url);
        $twitterInfo['profile_image_url'] = $imgUrl;
        $twitterInfo['description'] = $content->data->description;

        Cache::add( $twitterUser, $imgUrl,  Carbon::now()->addMinutes(120 + rand(120))  ); // Random to prevent all requests at once
        return $twitterInfo;
    }

}
