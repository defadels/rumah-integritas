<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | Web Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Selamat datang di Web Admin" name="description" />
    <meta content="Mantara" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('')}}assets/themes/material60/assets/images/favicon.png">

    <!-- Theme Config Js -->
    <script src="{{asset('')}}assets/themes/material60/assets/js/head.js"></script>

    <!-- Bootstrap css -->
    <link href="{{asset('')}}assets/themes/material60/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- App css -->
    <link href="{{asset('')}}assets/themes/material60/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Icons css -->
    <link href="{{asset('')}}assets/themes/material60/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <style>
        .authentication-bg-pattern{
            background-image: url("{{asset('assets/themes/material/assets/images/bg-rumah-integritas.png')}}") !important;
        }
        .posisi-center{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .posisi-center > img{
            display: inline-block;
        }
    </style>
</head>

<body class="authentication-bg authentication-bg-pattern">

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7 col-xl-5">
                <div class="card bg-pattern">

                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <img src="{{asset('assets/themes/material/assets/images/logo-rumah-integritas-removebg-preview.png')}}" alt="" width="72">
                                    <h5 class="text-muted">Rumah Integritas</h5>
                            {{-- <div class="auth-brand">
                                <a href="index.html" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="assets/images/logo-dark.png" alt="" height="22">
                                            </span>
                                </a>

                                <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="assets/images/logo-light.png" alt="" height="22">
                                            </span>
                                </a>
                            </div> --}}
                            <p class="text-muted mb-4 mt-3">Ruang Urai Masalah Akuntabilitas Kompetensi dan Attitude dengan Tuntas</p>
                        </div>

                            <form method="post" action="{{ route('app.login') }}">
                                @csrf
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Email</label>
                                <input autofocus class="form-control" type="email" id="emailaddress" name="email" required="" placeholder="Masukan email anda">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi Anda">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye" onclick="showPassword()"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input name="remember" type="checkbox" class="form-check-input form-check-blue bg-blue" id="checkbox-signin" checked>
                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>

                            <div class="text-center d-grid">
                                <button class="btn btn-primary" type="submit"> Log In </button>
                            </div>

                        </form>

                        {{--<div class="text-center">
                            <h5 class="mt-3 text-muted">Sign in with</h5>
                            <ul class="social-list list-inline mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                </li>
                            </ul>
                        </div>--}}

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                {{--<div class="row mt-3">
                    <div class="col-12 text-center">
                        <p> <a href="auth-recoverpw.html" class="text-white-50 ms-1">Forgot your password?</a></p>
                        <p class="text-white-50">Don't have an account? <a href="auth-register.html" class="text-white ms-1"><b>Sign Up</b></a></p>
                    </div> <!-- end col -->
                </div>--}}
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<footer class="footer footer-alt">
    <script>document.write(new Date().getFullYear())</script> &copy; Inspektorat Kota Balikpapan
</footer>

<!-- Authentication js -->
{{--<script src="assets/js/pages/authentication.init.js"></script>--}}

<!-- Vendor js -->
<script src="{{asset('')}}assets/themes/material60/assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="{{asset('')}}assets/themes/material60/assets/js/app.min.js"></script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('success', (message) => {
            toastr.success(message);
        });
        Livewire.on('error', (message) => {
            toastr.error(message);
        });

        Livewire.on('swal', (message, icon, confirmButtonText) => {
            if (typeof icon === 'undefined') {
                icon = 'success';
            }
            if (typeof confirmButtonText === 'undefined') {
                confirmButtonText = 'Ok, got it!';
            }
            Swal.fire({
                text: message,
                icon: icon,
                buttonsStyling: false,
                confirmButtonText: confirmButtonText,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        });
    });
</script>

</body>
</html>
