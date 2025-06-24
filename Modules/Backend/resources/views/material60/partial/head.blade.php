<head>

    <meta charset="utf-8"/>
    <title>@if(isset($title)) {{$title.' - '}} @endif{{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('')}}assets/themes/material60/assets/images/favicon.png">
@yield('custom_css')
<!-- Bootstrap css -->
    <link href="{{asset('')}}assets/themes/material60/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- App css -->
    <link href="{{asset('')}}assets/themes/material60/assets/css/app.min.css" rel="stylesheet" type="text/css"
          id="app-style"/>
    <!-- icons -->
    <link href="{{asset('')}}assets/themes/material60/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Head js -->
    <script src="{{asset('')}}assets/themes/material60/assets/js/head.js"></script>
    <style>
        body[data-leftbar-size=condensed] .left-side-menu #sidebar-menu>ul>li:hover>a{
            width: calc(220px + 70px);
        }
        body[data-leftbar-size=condensed] .left-side-menu #sidebar-menu>ul>li:hover>.collapse>ul, body[data-leftbar-size=condensed] .left-side-menu #sidebar-menu>ul>li:hover>.collapsing>ul{
            width: 220px !important;
        }
    </style>
</head>
