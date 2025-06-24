<!DOCTYPE html>
<html lang="en">
@include('backend::material60.partial.head')
<!-- body start -->
<body data-layout-mode="default" data-theme="light" data-topbar-color="dark" data-menu-position="fixed"
      data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>
<!-- Begin page -->
<div id="wrapper">
@include('backend::material60.partial.topbar')
@include('backend::material60.partial.sidebar')

<!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        @yield('content')
        @include('backend::material60.partial.footer')
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->
{{--@include('backend::material60.partial.right-sidebar')--}}
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<script>
    var site = "{{ config('app.url') }}";
    var site_backend = "{{ config('app.url').'/'.config('app.backend')  }}";
    var site_flm = "{{ config('app.filemanager')  }}";
    var csrf_token = "{{ csrf_token() }}";
    var gmaps_api_key = "{{config('app.gmaps_api_key')}}";
</script>

<!-- Vendor js -->
<script src="{{asset('')}}assets/themes/material60/assets/js/vendor.min.js"></script>
@yield('script')
<!-- App js-->
<script src="{{asset('')}}assets/themes/material60/assets/js/app.min.js"></script>
</body>
</html>
