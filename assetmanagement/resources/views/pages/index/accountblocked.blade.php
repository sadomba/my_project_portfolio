
@extends('layouts.info')
@section('content')
<div class="container">
    <div class="my-4 text-center p-4 card-4">
        <i class="material-icons mi-lg text-danger">block</i>
        <div class="h4 text-bold text-danger my-3">
            Your account has been blocked
        </div>
        <div class="text-muted">
            Please contact the system administrator for more information
        </div>
        <hr class="my-md" />
        <a href="{{ url('/') }}" class="btn btn-primary"><i class="material-icons">home</i> Continue</a>
    </div>
</div>
@endsection