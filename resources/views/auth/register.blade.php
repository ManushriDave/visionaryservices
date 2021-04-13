<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Registration - {{ config('app.name') }}</title>
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://niftyassistance.com/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://niftyassistance.com/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://niftyassistance.com/images/favicon/favicon-16x16.png">
    <link href="/assets/common/css/style.css" rel="stylesheet">

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
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <h4 class="text-center mb-4">Sign up your account</h4>
                                <form method="post" action="{{ route('auth.register_post') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name" class="mb-1"><strong>Name</strong></label>
                                        <input id="name" type="text" class="form-control" placeholder="Name" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="mb-1"><strong>Email</strong></label>
                                        <input id="email" type="email" class="form-control" placeholder="hello@example.com" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="mb-1"><strong>Password</strong></label>
                                        <input id="password" type="password" class="form-control" name="password">
                                    </div>
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                    </div>
                                </form>
                                <div class="new-account mt-3">
                                    <p>Already have an account? <a class="text-primary" href="{{ route('auth.login') }}">Sign in</a></p>
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

</body>

</html>
