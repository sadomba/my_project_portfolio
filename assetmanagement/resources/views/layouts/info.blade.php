<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
		<meta name="author" content="" />
		<meta name="keyword" content="" />
		<meta name="description" content="" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="{{ asset('css/material-icons.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
<link rel="stylesheet" href="{{ asset('css/bootstrap-theme-darkly.css') }}" />
		<link rel="stylesheet" href="{{ asset('css/custom-style.css') }}" />
		<script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
		@yield('pagecss')
	</head>
	<body>
		<div id="topbar" class="navbar navbar-expand-md fixed-top navbar-dark bg-primary">
			<div class="container-fluid">
				<a class="navbar-brand" href="{{ url('/home') }}">
					<img class="img-fluid" src="{{ asset('images/logo.png') }}" /> {{ config('app.name') }}
				</a>
	<?php
	if (Auth::check()) {
	?>
		<button type="button" class="navbar-toggler dropdown-toggle" data-bs-toggle="collapse"
			data-bs-target=".navbar-responsive-collapse">
		</button>
		<div class="navbar-collapse collapse navbar-responsive-collapse">
			<div class="me-auto"></div>
			<ul class="navbar-nav ms-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
						<span class="avatar-icon"><i class="material-icons">account_box</i></span>
						<span>Hi <?php echo $user->UserName(); ?></span>
					</a>
					<ul class="dropdown-menu">
						<a class="dropdown-item" href="<?php print_link('account') ?>"><i class="material-icons">account_box</i> My Account</a>
						<a class="dropdown-item" href="<?php print_link('auth/logout') ?>"><i class="material-icons">exit_to_app</i> Logout</a>
					</ul>
				</li>
			</ul>
		</div>
	<?php
	}
	?>
			</div>
		</div>
		<div id="main-content">
			<div id="page-content">
				@yield('content')
			</div>
			@include('appfooter')
		</div>
		@if(Session::has('success'))
		<div data-show-duration="5000" id="flashmsgholder" class="toast-alert row alert bg-success bounce text-white animated fixed-alert" role="alert">
			<div><i class="material-icons">check_circle</i></div>
			<div class="msg">{{ Session::get('success') }}</div>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		@endif
		@if(Session::has('danger'))
		<div data-show-duration="5000" id="flashmsgholder" class="toast-alert row alert bg-danger shake text-white animated fixed-alert" role="alert">
			<div><i class="material-icons">error</i></div>
			<div class="msg">{{ Session::get('danger') }}</div>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		@endif
		<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
		@yield('pagejs')
	</body>
</html>