@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Artists') }}</div>
                <div class="card-body row d-flex justify-content-center">
                  <div id="artistsCarousel" class="carousel slide w-75" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                      <button type="button" data-bs-target="#artistsCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                      @foreach( $artistList as $key => $artist)
                        <button type="button" data-bs-target="#artistsCarousel" data-bs-slide-to="{{$key}}" aria-label="Slide {{$key+1}}"></button>
                      @endforeach
                    </div>
                    <div class="carousel-inner">
                      @foreach( $artistList as $key => $artist)
                      <div class="carousel-item @if( !$key  ) active @endif">
                        <div class="d-block w-100 carousel-overlay">
                          <img src="{{$artist['twitterInfo']['profile_image_url']}}" class="d-block w-100" alt="...">
                        </div>
                        
                        <div class="carousel-caption d-none d-md-block">
                          <h5>
                              {{$artist['name']}}                             
                              <a href="https://twitter.com/{{$artist['twitter']}}" target="_blank">
                                <i class="fa fa-twitter"></i>
                              </a>
                          </h5>
                          <p>{{$artist['twitterInfo']['description']}}.</p>
                        </div>
                      </div>
                      @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#artistsCarousel" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#artistsCarousel" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
