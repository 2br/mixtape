@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ config('app.name') }}</div>

                <div class="card-body text-center">
                    <img src="{{ asset('images/logo.png')}}" width="20%" height="20%" class="img-responsive"  />
                    <h1 class="text-center">{{ config('app.name') }}</h1>

                    <div>
                        Welcome, please register or login to access the APP
                    </div>
                </div>
              
            </div>
        </div>
    </div>
</div>
@endsection
