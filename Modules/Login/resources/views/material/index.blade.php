<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | VPZ HRD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Selamat datang di Daposba" name="description" />
    <meta content="Mantara" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('')}}assets/themes/material/assets/images/favicon.png">

    <!-- Theme Config Js -->
    <script src="{{asset('')}}assets/themes/material/assets/js/head.js"></script>

    <!-- Bootstrap css -->
    <link href="{{asset('')}}assets/themes/material/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- App css -->
    <link href="{{asset('')}}assets/themes/material/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Icons css -->
    <link href="{{asset('')}}assets/themes/material/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="auth-fluid-pages pb-0">

<div class="auth-fluid">
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="p-3">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <div class="auth-brand">
                        <a href="{{ route('login') }}" class="logo logo-dark text-center">
                                    <span class="logo-lg">
                                        <img src="{{asset('')}}assets/themes/material/assets/images/logo-balikpapan.png" alt="">
                                    </span>
                        </a>

                        <a href="{{ route('login') }}" class="logo logo-light text-center">
                                    <span class="logo-lg">
                                        <img src="{{asset('')}}assets/themes/material/assets/images/logo-balikpapan.png" alt="">
                                    </span>
                        </a>
                    </div>
                </div>

                <!-- title-->
                <h4 class="mt-0">Masuk</h4>
                <p class="text-muted mb-4">Masukkan alamat email dan kata sandi Anda untuk mengakses akun.</p>

                <!-- form -->
                <form method="post" action="{{ route('app.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="emailaddress" class="form-label">Email</label>
                        <input autofocus class="form-control" type="email" name="email" id="emailaddress" required="" placeholder="Masukkan email Anda">
                    </div>
                    <div class="mb-3">
                        @if (Route::has('password.request'))<a href="#" class="text-muted float-end"><small>Lupa password?</small></a>@endif
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
                            <input name="remember" type="checkbox" class="form-check-input" id="checkbox-signin">
                            <label class="form-check-label" for="checkbox-signin">Ingat saya</label>
                        </div>
                    </div>
                    <div class="text-center d-grid">
                        <button class="btn btn-info" type="submit">Log In </button>
                    </div>
                </form>
                <!-- end form-->

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Belum punya akun? <a href="auth-register-2.html" class="text-muted ms-1"><b>Hubungi Kami</b></a></p>
                </footer>

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
            <h2 class="mb-3 text-white">Setiap orang menjadi guru, setiap rumah menjadi sekolah.</h2>
            <p class="lead"><i class="mdi mdi-format-quote-open"></i> Setiap orang bisa menjadi sumber ilmu dan inspirasi, dan setiap tempat bisa menjadi ruang belajar. Dengan demikian, pendidikan menjadi sebuah proses yang holistik dan berlangsung sepanjang hayat, melibatkan lingkungan keluarga, masyarakat, dan berbagai pengalaman hidup sehari-hari <i class="mdi mdi-format-quote-close"></i>
            </p>
            <h5 class="text-white">
                - Ki Hajar Dewantara
            </h5>
        </div> <!-- end auth-user-testimonial-->
    </div>
    <!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->

<!-- Authentication js -->
<script src="{{asset('')}}assets/themes/material/assets/js/pages/authentication.init.js"></script>
<script type="application/javascript">
    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
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

@livewireScripts

</body>
</html>
