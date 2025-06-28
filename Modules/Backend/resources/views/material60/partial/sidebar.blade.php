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

                @if(auth()->user()->hasRole('administrator') || auth()->user()->hasRole('OPD') || auth()->user()->hasRole('Pengaju') || auth()->user()->hasRole('Supervisi'))

                <li>
                    <a href="#sidebarEksternal" data-bs-toggle="collapse">
                        <i class="mdi mdi-newspaper"></i>
                        <span> Sistem Eksternal </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarEksternal">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('form.hasil.create')}}">
                                    Hasil Pemeriksaan Awal Tim
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @endif


                @if(auth()->user()->hasRole('administrator') || auth()->user()->hasRole('Pengaju') || auth()->user()->hasRole('Supervisi'))

                <li>
                    <a href="#sidebarInternal" data-bs-toggle="collapse">
                        <i class="mdi mdi-newspaper"></i>
                        <span> Sistem Internal </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarInternal">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('form.makan.create')}}">
                                    Pengajuan Makan Minum
                                </a>
                            </li>
                            <li>
                                <a href="{{route('form.pelihara.create')}}">
                                    Pengajuan Pemeliharaan BMD
                                </a>
                            </li>
                            <li>
                                <a href="{{route('form.barang.pakai.habis.create')}}">
                                    Pengajuan Agenda Inspektorat
                                </a>
                            </li>
                            <li>
                                <a href="{{route('form.kartu.kendali.create')}}">
                                    Kartu Kendali Kegiatan
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @endif

                @if (auth()->user()->hasRole('administrator'))

                <li>
                    <a href="#pengaturan" data-bs-toggle="collapse">
                        <i class="mdi mdi-cog"></i>
                        <span> Pengaturan </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="pengaturan">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('users')}}">
                                    Users
                                </a>
                            </li>
                            <li>
                                <a href="{{route('users.roles')}}">
                                    Roles
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
