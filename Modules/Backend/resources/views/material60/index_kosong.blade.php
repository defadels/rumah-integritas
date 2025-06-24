@extends('backend::material60.layouts.master')
@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material60/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('')}}assets/themes/material60/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex align-items-center mb-3">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control border-0" id="dash-daterange">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                                    <i class="mdi mdi-calendar-range"></i>
                                                </span>
                                </div>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-2">
                                    <i class="mdi mdi-autorenew"></i>
                                </a>
                                <a href="javascript: void(0);" class="btn btn-blue btn-sm ms-1">
                                    <i class="mdi mdi-filter-variant"></i>
                                </a>
                            </form>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection
@section('script')
    <!-- Plugins js-->
    <script src="{{asset('')}}assets/themes/material60/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="{{asset('')}}assets/themes/material60/assets/libs/apexcharts/apexcharts.min.js"></script>

    <script src="{{asset('')}}assets/themes/material60/assets/libs/selectize/js/standalone/selectize.min.js"></script>

    <!-- Dashboar 1 init js-->
    <script src="{{asset('')}}assets/themes/material60/assets/js/pages/dashboard-1.init.js"></script>
@endsection
