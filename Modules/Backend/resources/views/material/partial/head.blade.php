<head>
    <meta charset="utf-8"/>
    <title>@if(isset($title)) {{$title.' - '}} @endif{{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('')}}assets/themes/material/assets/images/favicon.png">

@yield('custom_css')

<!-- Theme Config Js -->
    <script src="{{asset('')}}assets/themes/material/assets/js/head.js"></script>

    <!-- Bootstrap css -->
    <link href="{{asset('')}}assets/themes/material/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"
          id="app-style"/>

    <!-- App css -->
    <link href="{{asset('')}}assets/themes/material/assets/css/app.min.css" rel="stylesheet" type="text/css"/>

    <!-- Icons css -->
    <link href="{{asset('')}}assets/themes/material/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
</head>
