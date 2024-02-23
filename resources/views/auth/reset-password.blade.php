<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee attendance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    body {
        width: 100%;
        height: 100vh;
        background: linear-gradient(90deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 1) 50%, rgba(234, 238, 250, 1) 50%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-page .login-box .card {
        box-shadow: none;
    }

    .login-page .login-box {
        box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    }

    .login-page .login-card-body form .col-12 {
        padding-left: 0px;
        padding-right: 0px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-size: 13px;
        line-height: 1;
        vertical-align: top;
        /* margin-bottom: 0.5rem; */
    }

    .form-control {
        display: block;
        width: 100%;
        height: 46px;
        padding: 10px 12px;
        font-size: 13px;
        line-height: 1;
        color: #495057;
        border: 1px solid #ddd;
        border-radius: 0.28571429rem;
        outline: none;
        box-shadow: none;
        border-left: none;
    }
</style>

<body>
    <div class="container">
        <div class="login-panal">
            <div class="hold-transition login-page ">
                <div class="login-box">
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! session('success') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {!! session('error') !!}
                            <button type="button" class="close" id="alert" data-dismiss="alert"
                                aria-label="Close">
                                <span style="float:right; cursor:pointer" onclick="$('#alert').hide()"
                                    aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body login-card-body ">
                            <h3 class="login-box-msg">Reset password</h3>

                            <form method="POST" id="login-form" action="{{ route('reset-password-post') }}">
                                @csrf
                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">
                                <div class="form-group">
                                    <label>New Password<span class="required">*</span></label>
                                    <div class="form-group-field ">
                                        <input id="new_password" type="password"
                                            class="md-6 form-control @error('password') is-invalid @enderror"
                                            name="password" value="{{ old('password') }}" autocomplete="password"
                                            autofocus required>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group ">
                                    <label>Confirm New Password<span class="required">*</span></label>
                                    <div class="form-group-field ">
                                        <input id="password_confirmation" type="password"
                                            class=" form-control @error('password') is-invalid @enderror"
                                            name="password_confirmation" autocomplete="current-password">
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <br>
                                <div class="row row-padding">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block" style="float: center;"
                                            ;>Change
                                            Password</button>
                                    </div>
                                </div>

                            </form>

                            <!-- <p class="mb-0">
                            <a href="#" class="text-center">Create an Account</a>
                          </p> -->
                        </div>
                        <!-- /.login-card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
