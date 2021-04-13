<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://niftyassistance.com/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://niftyassistance.com/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://niftyassistance.com/images/favicon/favicon-16x16.png">
    <link href="/assets/common/css/style.css" rel="stylesheet">
    <style>
        #togglePassword {
            float: right;
            margin-left: -20px;
            margin-top: -25px;
            padding-right: 15px;
            cursor: pointer;
            position: relative;
        }
    </style>
</head>
<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center">
                                        <img class="w-75 pb-2" src="/assets/common/images/1logo.png" />
                                    </div>
                                    @include('flash::message')
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <form method="post" action="{{ route('auth.login_post') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" id="password" class="form-control" name="password">
                                            <i class="fa fa-eye" id="togglePassword"></i>
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox ml-1">
                                                    <input type="checkbox" name="remember" class="custom-control-input" id="basic_checkbox_1">
                                                    <label class="custom-control-label" for="basic_checkbox_1">
                                                        Remember my preference
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success btn-block">Sign In as Customer</button>
                                            <h5 class="mt-2">------ OR ------</h5>
                                        </div>
                                        <button name="niftyassistant" type="submit" class="btn btn-info btn-block mt-2">Sign in as Nifty Assistant</button>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Don't have an account?
                                            <a class="text-primary" href="{{ route('auth.register') }}">Sign up</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="/assets/common/vendor/global/global.min.js"></script>
    <script src="/assets/common/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="/assets/common/js/custom.min.js"></script>
    <script src="/assets/common/js/deznav-init.js"></script>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>

