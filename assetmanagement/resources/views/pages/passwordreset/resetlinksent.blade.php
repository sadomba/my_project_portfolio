@extends('layouts.info')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-body my-5">
                    <h4><i class="material-icons">email</i> Password Reset </h4>
                    <hr />
                    <div class="">
                        <h5 class="text-info">
                            A message has been sent to your email. Kindly follow the link to reset your password
                        </h5>
                        <hr />
                        <div class="text-center">
                            <a href="<?php print_link('/'); ?>" class="btn btn-info">Click here to login</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
