@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Albums') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('album.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="artist" class="col-md-4 col-form-label text-md-end">{{ __('Artist:') }}</label>
                            <div class="col-md-6">
                                <select class="form-select @error('artist') is-invalid @enderror" name="artist" id="artist">
                                @foreach ($artistList as $key => $artist )
                                    @if( old('artist') == $artist['name'] )
                                        <option value="{{$artist['name']}}" selected>{{$artist['name']}}</option>
                                    @else
                                        <option value="{{$artist['name']}}">{{$artist['name']}}</option>
                                    @endif
                                @endforeach
                                </select>
                                @error('artist')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="year" class="col-md-4 col-form-label text-md-end">{{ __('Album Year') }}</label>

                            <div class="col-md-6">
                                <input id="year" type="number" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}" required autocomplete="year">

                                @error('year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register Album') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
