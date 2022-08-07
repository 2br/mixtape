@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="p-2">{{ __('All albums') }}</div>
                    <a href="/album/create" class="btn btn-primary">
                        <i class="fa fa-plus"></i>  Add Album
                    </a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Artist</th>
                            <th scope="col">Year</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                    <tbody>
                    @foreach( $albumList as $album )
                    <tr>
                        <td>{{$album['id']}}</td>
                        <td>{{$album['name']}}</td>
                        <td>{{$album['artist']}}</td>
                        <td>{{$album['year']}}</td>
                        <td class="col-md-3">
                            <form action="{{ route('album.destroy',$album->id) }}" method="POST">
                                <a class="btn btn-sm btn-success" href="{{ route('album.edit',$album->id) }}">
                                    <i class="fa fa-edit"></i>  {{ __("Edit") }}
                                </a>
                            
                              @if( $userCanDelete === true )               
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onClick="return window.confirm('Are you sure want to delete this album?');">
                                    <i class="fa fa-trash"></i>  {{ __("Delete") }}
                                </button>
                              @endif

                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
