@extends('layouts.info')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-body my-5">
                    <h4>Email verification completed.</h4>
                    <hr />
                    <div class="">
                        <a href="{{ route('home') }}" class="btn btn-primary">Continue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
