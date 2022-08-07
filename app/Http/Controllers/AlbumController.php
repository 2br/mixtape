<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

use App\Models\Album;
use App\Http\Controllers\ArtistsController;
use Illuminate\Support\Facades\DB;

class AlbumController extends Controller
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
     * Display a listing of all albums
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $albumList = Album::all();
        $userCanDelete = Auth::user()->role > 0;
        return view('album.index', ['albumList' => $albumList, 'userCanDelete' => $userCanDelete]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateRequest(array $data)
    {
        $artistList = ArtistsController::getRemoteArtists();
        // Failed to retrieve
        if( empty($artistList) ) {
            $validator = Validator::make([], []);
            $validator->errors()->add('artist', 'Error retrieving artist list! Try again later');
            throw new ValidationException($validator);
        }
        
        // Processes list of ids to validate if is in the list
        $idList = ""; 
        foreach( $artistList as $artist ) {
            $idList .= $artist['name'].",";
        }
      
        $validator = Validator::make($data, [
            'artist' => ['required',  'string', 'in:'.$idList],
            'name'   => ['required',  'string', 'min: 3'],
            'year'   => ['required', 'integer', 'between:1900,'. date("Y") ] 
        ]);
        
        return $validator;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artistList = ArtistsController::getRemoteArtists();
        return view('album.create', ['artistList' => $artistList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->validateRequest($data);
        
        if ($validator->fails()) {
            return redirect('album/create')
                        ->withErrors($validator)
                        ->withInput();
        }


        // Check if album already exists for this artist before creating
        $albumExists = DB::table('albums')
            ->where ('artist','=',$data['artist'])
            ->where ('name', '=', $data['name'])
            ->exists();

        if( $albumExists ) {
            $validator->errors()->add('artist', 'This album already exists for this artist.');
            throw new ValidationException($validator);
            return redirect('album/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        Album::create($data);
        return redirect()->route('album.index')
            ->with('success','Album created successfully.');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Album  $album
    * @return \Illuminate\Http\Response
    */
    public function show(Album $album)
    {
        return view('album.show', [ 'album' => $album ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */ 
    public function edit(Album $album)
    {
        $artistList = ArtistsController::getRemoteArtists();
        return view('album.edit', [ 'album' => $album, 'artistList' => $artistList]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        $data = $request->all();
        $validator = $this->validateRequest($data);
        
        if ($validator->fails()) {
            return redirect('album.edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $album->update($data);
        return redirect()->route('album.index')
            ->with('success','Album updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        // Check in case of direct acess
        if( Auth::user()->role == 0 ) { 
            return redirect('album.create')
            ->withErrors('This user cannot delete albums');
        }
        $album->delete();
       
        return redirect()->route('album.index')
                        ->with('success','Album deleted successfully');
    }
}
