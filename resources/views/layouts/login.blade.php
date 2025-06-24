<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | VPZ HRD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Selamat datang di Viewpoint Zone HRD, solusi terdepan untuk kebutuhan manajemen sumber daya manusia (HRD) Anda. Dibangun dengan fokus pada kenyamanan, efisiensi, dan inovasi, Viewpoint Zone HRD menyediakan platform yang dapat disesuaikan dengan kebutuhan unik perusahaan Anda." name="description" />
    <meta content="Numesa" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('')}}assets/themes/material/assets/images/favicon.ico">

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

{{$slot}}

</body>
</html>
