<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verify Email - {{ config('app.name') }}</title>
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
                                @include('flash::message')
                                <h4 class="text-center mb-4">Verify Email</h4>
                                <div class="alert alert-info text-center">
                                    Please verify your email first.
                                </div>
                                <form method="post" class="text-center" action="{{ route('verification.send') }}">
                                    @csrf
                                    <button class="btn btn-success btn-sm" type="submit">
                                        Resend Verification Email
                                    </button>
                                </form>
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

