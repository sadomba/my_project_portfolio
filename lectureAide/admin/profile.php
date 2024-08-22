<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
</head>

<body class="bg-gradient-primary">
<div id="wrapper">
<?php include("includes/leftbar.php");?>
    <div class="container">

        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                   
                    <div class="container">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Profile</h4>
                            </div>
                            <form class="user">
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="First Name" name="first_name" value="First name :"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="exampleLastName" placeholder="Last Name" name="last_name" value="Last name : "></div>
                                </div>
                                <div class="mb-3"><input class="form-control form-control-user" type="text" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email Address" name="email" value="email : "></div>
                                <div class="mb-3"> <select class="form-control form-control-user" name="email" placeholder="Email">

                                <option value="select role" selected="">select role</option>
                                <option value="lecturer" >lecturer</option>
                                <option value="admin">admin</option>
                                <option value="other">other</option>


                                    </select>  
</div>

                                <div class="mb-3">
                                    <div class="mb-3"><input class="form-control form-control-user" type="password" id="examplePasswordInput" placeholder="Password : " name="password"></div>
                                   
                                </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Update </button>
                               
                            </form>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>