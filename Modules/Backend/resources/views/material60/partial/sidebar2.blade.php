<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('')}}assets/themes/material60/assets/images/users/user-1.jpg" alt="user-img"
                 title="Mat Helme"
                 class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                   data-bs-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li>
                    <a href="{{route('app.backend')}}">
                        <i class="mdi mdi-home"></i>
                        <span> Home </span>
                    </a>
                </li>

                <li>
                    <a href="#sidebarPosts" data-bs-toggle="collapse">
                        <i class="mdi mdi-newspaper"></i>
                        <span> Posts </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarPosts">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Daftar Post
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Baru
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Kategori
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tag
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarInfografis" data-bs-toggle="collapse">
                        <i class="mdi mdi-image-multiple"></i>
                        <span> Infografis </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarInfografis">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Daftar Infografis
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Baru
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarFoto" data-bs-toggle="collapse">
                        <i class="mdi mdi-image"></i>
                        <span> Foto </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarFoto">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Daftar Foto
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Baru
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarVideo" data-bs-toggle="collapse">
                        <i class="mdi mdi-video"></i>
                        <span> Video </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarVideo">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Daftar Video
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Baru
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarPengumuman" data-bs-toggle="collapse">
                        <i class="mdi mdi-information"></i>
                        <span> Pengumuman </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarPengumuman">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Daftar Pengumuman
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Baru
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarAgenda" data-bs-toggle="collapse">
                        <i class="mdi mdi-calendar"></i>
                        <span> Agenda </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAgenda">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Daftar Agenda
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Baru
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarStatis" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-document"></i>
                        <span> Halaman Statis </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarStatis">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Daftar Halaman
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Baru
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarLanding" data-bs-toggle="collapse">
                        <i class="mdi mdi-airplane-landing"></i>
                        <span> Landing Page </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarLanding">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Daftar Landing Page
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Baru
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarPlugins" data-bs-toggle="collapse">
                        <i class="mdi mdi-assistant"></i>
                        <span> Plugins </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarPlugins">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Slider
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarMicrosite" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-document"></i>
                        <span> Microsite </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMicrosite">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Daftar Microsite
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Baru
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarAds" data-bs-toggle="collapse">
                        <i class="mdi mdi-adjust"></i>
                        <span> Ads Manager </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAds">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Banner
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Tambah Banner
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Posisi Banner
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarRedaksi" data-bs-toggle="collapse">
                        <i class="mdi mdi-doctor"></i>
                        <span> Redaksi </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarRedaksi">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Writer
                                </a>
                            </li>
                            <li>
                                <a href="{{route('dapodik.kepala-sekolah')}}">
                                    Editor
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @can('view users')
                    <li>
                        <a href="#sidebarUsers" data-bs-toggle="collapse">
                            <i class="mdi mdi-account"></i>
                            <span> Users </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarUsers">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{route('users')}}">
                                        Data Users
                                    </a>
                                </li>
                                @can('create users')
                                    <li class="menu-item">
                                        <a href="{{route('users.create')}}">
                                            Register User
                                        </a>
                                    </li>
                                @endcan
                                @can('view roles')
                                    <li>
                                        <a href="{{route('users.roles')}}">
                                            Role User
                                        </a>
                                    </li>
                                @endcan
                                @can('view logs')
                                    <li>
                                        <a href="{{route('users.logs')}}">
                                            Logs
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
