@extends('layouts.info')
@section('content')
<div class="container">
    <div class="my-4 text-center p-4 card-4">
        <i class="material-icons mi-lg text-success">check_circle</i>
        <div class="h2 text-bold text-success my-md">
            Congratulations!
        </div>
        <div class="h4">
            Your account has been created.
        </div>
        
        <hr class="my-md" />
        <a href="{{ url('/home') }}" class="btn btn-primary"><i class="material-icons">home</i> Continue</a>
    </div>
</div>
@endsection