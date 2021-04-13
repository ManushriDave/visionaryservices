
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Password Reset - {{ config('app.name') }}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/common/images/favicon.png">
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
                                <h4 class="text-center mb-4">Forgot Password</h4>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form method="post" action="{{ route('password.reset', $token) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="password"><strong>New Password</strong></label>
                                        <input type="password" id="password" class="form-control" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><strong>Confirm Password</strong></label>
                                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                                    </div>
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
                                    </div>
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

</body>

</html>
