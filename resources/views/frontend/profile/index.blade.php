@extends('layouts.frontend')

@section('title', $user->name.' - Profile')

@section('head')
    @include('frontend.head.datatable')
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- User Info -->
    <div class="bg-image bg-image-bottom" style="background-image: url('/assets/frontend/assets/media/photos/photo13@2x.jpg');">
        <div class="bg-black-op-75 py-30">
            <div class="content content-full text-center">
                <!-- Avatar -->
                <div class="mb-15">
                    <a class="img-link" href="">
                        <img class="img-avatar img-avatar96 img-avatar-thumb" src="/assets/frontend/assets/media/avatars/avatar15.jpg" alt="">
                    </a>
                </div>
                <!-- END Avatar -->

                <!-- Personal -->
                <h1 class="h3 text-white font-w700 mb-10">{{ $user->name }}</h1>
                <!-- END Personal -->

                <!-- Actions -->
                <a href="{{ route('frontend.index') }}" class="btn btn-rounded btn-hero btn-sm btn-alt-secondary mb-5">
                    <i class="fa fa-arrow-left mr-5"></i> Back to Dashboard
                </a>
                <!-- END Actions -->
            </div>
        </div>
    </div>
    <!-- END User Info -->

    <!-- Main Content -->
    <div class="content">
        <!-- User Profile -->
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-user-circle mr-5 text-muted"></i> User Profile
                </h3>
            </div>
            <div class="block-content">
                <form action="{{ route('frontend.profile.update') }}" method="post" enctype="multipart/form-data">
                    @method('patch')
                    @csrf
                    <div class="row items-push">
                        <div class="col-lg-3">
                            <p class="text-muted">
                                Your account’s vital info. Your Name will be visible to our Assistants.
                            </p>
                        </div>
                        <div class="col-lg-7 offset-lg-1">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-name">Name</label>
                                    <input type="text" class="form-control form-control-lg" id="profile-settings-name" placeholder="Enter your name.." name="name" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-email">Email Address</label>
                                    <input type="email" class="form-control form-control-lg" id="profile-settings-email" placeholder="Enter your email.." name="email" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-10 col-xl-6">
                                    <div class="push">
                                        <img class="img-avatar" src="{{ (!$user->avatar) ? '/assets/frontend/assets/media/avatars/avatar15.jpg' : $user->avatar }}" alt="">
                                    </div>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" id="profile-settings-avatar" name="avatar_file" data-toggle="custom-file-input">
                                        <label class="custom-file-label" for="profile-settings-avatar">Choose new avatar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button name="{{ \App\Enums\Updater::updateProfileBasic }}" type="submit" class="btn btn-alt-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END User Profile -->

        <!-- Change Password -->
        <div class="block" id="change_password">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-lock mr-5 text-muted"></i> Change Password
                </h3>
            </div>
            <div class="block-content">
                <form action="{{ route('frontend.profile.update') }}" method="post">
                    @method('patch')
                    @csrf
                    <div class="row items-push">
                        <div class="col-lg-3">
                            <p class="text-muted">
                                Changing your sign in password is an easy way to keep your account secure.
                            </p>
                        </div>
                        <div class="col-lg-7 offset-lg-1">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-password">Current Password</label>
                                    <input type="password" class="form-control form-control-lg" id="profile-settings-password" name="password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-password-new">New Password</label>
                                    <input type="password" class="form-control form-control-lg" id="profile-settings-password-new" name="new_password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-password-new-confirm">Confirm New Password</label>
                                    <input type="password" class="form-control form-control-lg" id="profile-settings-password-new-confirm" name="new_password_confirmation">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" name="{{ \App\Enums\Updater::updateProfilePassword }}" class="btn btn-alt-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Change Password -->

        <!-- Billing Information -->
        <div class="block" id="billing">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-credit-card mr-5 text-muted"></i> Billing Information
                </h3>
            </div>
            <div class="block-content">
                <form action="{{ route('frontend.profile.update') }}" method="post">
                    @method('patch')
                    @csrf
                    <div class="row items-push">
                        <div class="col-lg-3">
                            <p class="text-muted">
                                Your billing information is never shown to other users and only used for creating your invoices.
                            </p>
                        </div>
                        <div class="col-lg-7 offset-lg-1">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="profile-settings-firstname">Firstname</label>
                                    <input type="text" class="form-control form-control-lg" value="{{ (!$user->billing) ? '' : $user->billing->first_name }}" id="profile-settings-firstname" name="first_name">
                                </div>
                                <div class="col-6">
                                    <label for="profile-settings-lastname">Lastname</label>
                                    <input type="text" class="form-control form-control-lg" value="{{ (!$user->billing) ? '' : $user->billing->last_name }}" id="profile-settings-lastname" name="last_name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-street-1">Street Address 1</label>
                                    <input type="text" class="form-control form-control-lg" value="{{ (!$user->billing) ? '' : $user->billing->street_address_1 }}" id="profile-settings-street-1" name="street_address_1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-street-2">Street Address 2</label>
                                    <input type="text" class="form-control form-control-lg" value="{{ (!$user->billing) ? '' : $user->billing->street_address_2 }}" id="profile-settings-street-2" name="street_address_2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="profile-settings-city">City</label>
                                    <input type="text" class="form-control form-control-lg" value="{{ (!$user->billing) ? '' : $user->billing->city }}" id="profile-settings-city" name="city">
                                </div>
                                <div class="col-6">
                                    <label for="profile-settings-phone">Phone</label>
                                    <input type="text" class="form-control form-control-lg" value="{{ (!$user->billing) ? '' : $user->billing->phone }}" id="profile-settings-phone" name="phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="profile-settings-postal">Postal code</label>
                                    <input type="text" class="form-control form-control-lg" value="{{ (!$user->billing) ? '' : $user->billing->postal_code }}" id="profile-settings-postal" name="postal_code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" name="{{ \App\Enums\Updater::updateProfileBilling }}" class="btn btn-alt-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Billing Information -->
    </div>
    <!-- END Main Content -->
    <!-- END Page Content -->
@endsection
