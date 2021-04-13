
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
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <h4 class="text-center mb-4">Forgot Password</h4>
                                <form method="post" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email"><strong>Email</strong></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="hello@example.com">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox ml-1">
                                            <input type="checkbox" name="nifty" class="custom-control-input" id="basic_checkbox_1">
                                            <label class="custom-control-label" for="basic_checkbox_1">
                                               Is this a Nifty's Account?
                                            </label>
                                        </div>
                                    </div>
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
