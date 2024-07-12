<?php
session_start();
if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0){
    header("Location:./");
    exit;
}
require_once('DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | Student Quarterly Grading System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="templates/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="templates/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="templates/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="templates/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="templates/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="templates/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="templates/assets/vendor/js/helpers.js"></script>
    <script src="templates/assets/js/config.js"></script>

    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>
<body>
    
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                            <div class="app-brand justify-content-center">
    <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">
            <img src="image/logo.png" alt="Logo" width="50">
        </span>
        
    </a>
</div>

                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome Back! 👋</h4>
                        
                        
                       <form id="login-form">
    <center><small>Please enter your credentials.</small></center>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" id="username" autofocus name="username" class="form-control form-control-sm rounded-0" required>
    </div>
    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password">Password</label>
        </div>
        <div class="input-group input-group-merge">
            <input type="password" id="password" name="password" class="form-control" aria-describedby="password" required>
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
    </div>
    <div class="mb-3">
        <label for="account_type" class="form-label">Account Type</label>
        <select id="account_type" name="account_type" class="form-control" required>
            <option value="student">Student</option>
            <option value="instructor">Instructor</option>
        </select>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
    </div>
</form>


                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>

   <script>
    $(function(){
        $('#login-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            _this.find('button').attr('disabled',true)
            _this.find('button[type="submit"]').text('Logging in templates')
            $.ajax({
                url:'./Actions.php?a=login',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                    _this.find('button').attr('disabled',false)
                    _this.find('button[type="submit"]').text('Login')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                        setTimeout(() => {
                            location.replace('./');
                        }, 2000);
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)
                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                    _this.find('button').attr('disabled',false)
                    _this.find('button[type="submit"]').text('Login')
                }
            })
        })
    })
</script>


    <!-- Core JS -->
    <script src="templates/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="templates/assets/vendor/libs/popper/popper.js"></script>
    <script src="templates/assets/vendor/js/bootstrap.js"></script>
    <script src="templates/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="templates/assets/vendor/js/menu.js"></script>

    <!-- Main JS -->
    <script src="templates/assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
