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
                <div class="col-lg-4 col-xl-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <img src="@if(Auth::user()->avatar != NULL) {{route('profile.avatar',['filename' => Auth::user()->avatar ])}} @else {{route('profile.avatar',['filename' => 'avatar.png' ])}} @endif"
                                 class="rounded-circle avatar-lg img-thumbnail"
                                 alt="profile-image">

                            <h4 class="mb-0">{{$name}}</h4>
                            <p class="text-muted">{{$email}}</p>

                            <button type="button" class="btn btn-success btn-xs waves-effect mb-2 waves-light">
                                {{$role}}</button>

                            <div class="text-start mt-3">
                                <h4 class="font-13 text-uppercase">Bio :</h4>
                                <p class="text-muted font-13 mb-3">
                                    {{$bio}}
                                </p>
                                <p class="text-muted mb-2 font-13"><strong>Nama Lengkap :</strong> <span
                                        class="ms-2">{{$name}}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Ponsel :</strong><span
                                        class="ms-2">{{$phone}}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                        class="ms-2">{{$email}}</span></p>
                            </div>

                            <ul class="social-list list-inline mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="{{$social_facebook}}"
                                       class="social-list-item border-primary text-primary"><i
                                            class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{$social_instagram}}"
                                       class="social-list-item border-danger text-danger"><i
                                            class="mdi mdi-instagram"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{$social_twitter}}"
                                       class="social-list-item border-info text-info"><i
                                            class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{$social_github}}"
                                       class="social-list-item border-secondary text-secondary"><i
                                            class="mdi mdi-github"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div> <!-- end card -->

                </div> <!-- end col-->

                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill navtab-bg">
                                <li class="nav-item">
                                    <a href="#settings" data-bs-toggle="tab" aria-expanded="false"
                                       class="nav-link active">
                                        Profil
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="settings">
                                    <form enctype="multipart/form-data" method="post" action="{{route('profile')}}">
                                        @csrf
                                        <h5 class="mb-4 text-uppercase"><i
                                                class="mdi mdi-account-circle me-1"></i> Informasi Pribadi</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="firstname" class="form-label">Nama
                                                        Lengkap</label>
                                                    <input type="text" class="form-control" id="name"
                                                           name="name" value="{{$name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="lastname" class="form-label">Nomor
                                                        Ponsel</label>
                                                    <input type="text" class="form-control" id="phone"
                                                           name="phone" value="{{$phone}}">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="userbio" class="form-label">Bio</label>
                                                    <textarea class="form-control" id="bio" name="bio" rows="4"
                                                              placeholder="Tulis sesuatu...">{{$bio}}</textarea>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="alamat"
                                                           name="alamat" value="{{$alamat}}">
                                                </div>
                                            </div>
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="useremail" class="form-label">Email
                                                        Address</label>
                                                    <input type="email" class="form-control bg-light" id="useremail"
                                                           name="email" value="{{$email}}" readonly>
                                                    <span class="form-text text-muted"><small>Jika ingin mengganti email <a
                                                                href="javascript: void(0);">klik</a> disini.</small></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="userpassword"
                                                           class="form-label">Password</label>
                                                    <input readonly type="password" class="form-control bg-light"
                                                           id="userpassword" value="******************">
                                                    <span class="form-text text-muted"><small>Jika ingin mengganti password <a
                                                                href="{{route('profile.password')}}">klik</a> disini.</small></span>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="file_attach" class="form-label">Foto Profil</label>
                                                    <input type="file" id="file_attach" name="file_attach" class="form-control">
                                                    <input type="hidden" name="file_lama" value="{{$file_lama}}">
                                                </div>
                                            </div>
                                        </div> <!-- end row -->

                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                                class="mdi mdi-office-building me-1"></i> Info Lembaga</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="companyname" class="form-label">Nama
                                                        Lembaga</label>
                                                    <input type="text" class="form-control" id="companyname" name="company_name" value="{{$company_name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="cwebsite" class="form-label">Website</label>
                                                    <input type="text" class="form-control" id="cwebsite" name="website" value="{{$website}}">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                                class="mdi mdi-earth me-1"></i> Media Sosial</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-fb" class="form-label">Facebook</label>
                                                    <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="fab fa-facebook-square"></i></span>
                                                        <input type="text" class="form-control" id="social-fb"
                                                               placeholder="Url" name="social_facebook" value="{{$social_facebook}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-tw" class="form-label">Twitter</label>
                                                    <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="fab fa-twitter"></i></span>
                                                        <input type="text" class="form-control" id="social-tw"
                                                               placeholder="Username" name="social_twitter" value="{{$social_twitter}}">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-insta"
                                                           class="form-label">Instagram</label>
                                                    <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="fab fa-instagram"></i></span>
                                                        <input type="text" class="form-control"
                                                               id="social-insta" placeholder="Url" name="social_instagram" value="{{$social_instagram}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-lin" class="form-label">Linkedin</label>
                                                    <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="fab fa-linkedin"></i></span>
                                                        <input type="text" class="form-control" id="social-lin" name="social_linkedln" value="{{$social_linkedln}}"
                                                               placeholder="Url">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-sky" class="form-label">Skype</label>
                                                    <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="fab fa-skype"></i></span>
                                                        <input type="text" class="form-control" id="social-sky" name="social_skype" value="{{$social_skype}}"
                                                               placeholder="@username">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="social-gh" class="form-label">Github</label>
                                                    <div class="input-group">
                                                                <span class="input-group-text"><i
                                                                        class="fab fa-github"></i></span>
                                                        <input type="text" class="form-control" id="social-gh" name="social_github" value="{{$social_github}}"
                                                               placeholder="Username">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->

                                        <div class="text-end">
                                            <button type="submit"
                                                    class="btn btn-success waves-effect waves-light mt-2"><i
                                                    class="mdi mdi-content-save"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- end settings content-->

                            </div> <!-- end tab-content -->
                        </div>
                    </div> <!-- end card-->

                </div> <!-- end col -->
            </div>
            <!-- end row-->

        </div> <!-- container -->

    </div> <!-- content -->
@endsection
@section('script')
    <!-- Plugins js-->
    <!-- Sweet Alerts js -->
    <script src="{{asset('')}}assets/themes/material60/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

    <script src="{{asset('')}}modules/num-users/app.js?v=1.3"></script>
@endsection
