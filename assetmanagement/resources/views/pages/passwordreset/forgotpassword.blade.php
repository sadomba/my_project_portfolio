@extends('layouts.info')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card card-body mt-5">
                    <div>
                        <h3>Password Reset </h3>
                        <div class="text-muted">
                            Please provide the valid email address you used to register
                        </div>
                    </div>
                    <hr />
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="row">
                            <div class="col-10">
                                <input required type="text" class="form-control" id="email" name="email" placeholder="Email" />
                            </div>
                            <div class="col-2">
                                <button class="btn btn-success" type="submit">
                                    Send
                                    <i class="material-icons">email</i>
                                </button>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <div class="alert alert-danger animated bounce">{{ $errors->first('email') }}</div>
                        @endif
                    </form>

                    <div class="text-info p-3">
                        A link will be sent to your email containing the information you need for your password
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
