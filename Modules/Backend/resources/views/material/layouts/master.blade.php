<!DOCTYPE html>
<html lang="en">
@include('backend::material.partial.head')
<body>
@yield('content')
<!-- Theme Settings -->
@include('backend::material.partial.theme-settings')
<script>
    var site = "{{ config('app.url') }}";
    var site_backend = "{{ config('app.url').'/'.config('app.backend')  }}";
    var site_flm = "{{ config('app.filemanager')  }}";
    var csrf_token = "{{ csrf_token() }}";
    var gmaps_api_key = "{{config('app.gmaps_api_key')}}";
</script>
<!-- Vendor js -->
<script src="{{asset('assets/themes/material/assets/js/vendor.min.js')}}"></script>
<!-- App js -->
<script src="{{asset('assets/themes/material/assets/js/app.min.js')}}"></script>
@yield('script')
</body>
</html>
