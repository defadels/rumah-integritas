@extends('backend::material60.layouts.master')

@section('custom_css')
    <!-- Plugins css -->
    <link href="{{asset('')}}assets/themes/material60/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            @include('backend::material60.partial.breadcrumb')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-lg-8">
                                    <form class="d-flex flex-wrap align-items-center" action="{{route('users.logs')}}">
                                        <label for="inputPassword2" class="visually-hidden">Cari</label>
                                        <div class="me-3">
                                            <input type="search" name="s" value="{{ $s }}" class="form-control my-1 my-lg-0" id="inputPassword2" placeholder="Cari...">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="listdata" class="table  table-nowrap table-hover mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 20%;">Name</th>
                                        <th style="width: 20%;">Message</th>
                                        <th style="width: 20%;">Level</th>
                                        <th style="width: 10%;">Date</th>
                                        <th style="width: 5%;">IP Address</th>
                                        <th style="width: 5%;">Env</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listdata as $row)
                                        @php
                                            $id = $row->id;
                                        @endphp
                                        <tr id="data_{{ $row->id }}">
                                            <td>{{isset($row->user['name']) ? $row->user['name'] : ''}}</td>
                                            <td>{{$row->message}}</td>
                                            <td>{{ $row->level }}</td>
                                            <td>{{ ($row->created_at != null ? date('d/m/Y @H:i', strtotime($row->created_at)) : $row->created_at)  }}</td>
                                            <td>{{ $row->ip_address }}</td>
                                            <td>{{ $row->env }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $listdata->appends($append_src)->links() !!}
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection
@section('script')
    <!-- Plugins js-->
    <!-- Sweet Alerts js -->
    <script src="{{asset('')}}assets/themes/material60/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

    <script src="{{asset('')}}modules/num-users/app.js?v=1.3"></script>
@endsection
