<ul class="menu">

    <li class="menu-title">Navigation</li>

    <li class="menu-item">
        <a href="{{route('app.backend')}}" class="menu-link">
            <span class="menu-icon"><i class="mdi mdi-home"></i></span>
            <span class="menu-text"> Home </span>
        </a>
    </li>

    <li class="menu-item">
        <a href="#menuUsers" data-bs-toggle="collapse" class="menu-link">
            <span class="menu-icon"><i class="mdi mdi-database"></i></span>
            <span class="menu-text"> Data Pokok </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse" id="menuUsers">
            <ul class="sub-menu">
                <li class="menu-item">
                    <a href="{{route('dapodik.kepala-sekolah')}}" class="menu-link">
                        <span class="menu-text">Kepala Sekolah</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('dapodik.guru')}}" class="menu-link">
                        <span class="menu-text">Guru</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('dapodik.non-guru')}}" class="menu-link">
                        <span class="menu-text">Non Guru</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('dapodik.peserta-didik')}}" class="menu-link">
                        <span class="menu-text">Peserta Didik</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('dapodik.sekolah')}}" class="menu-link">
                        <span class="menu-text">Sekolah</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    @can('view users')
        <li class="menu-item">
            <a href="#menuUsers" data-bs-toggle="collapse" class="menu-link">
                <span class="menu-icon"><i class="mdi mdi-account"></i></span>
                <span class="menu-text"> Users </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="menuUsers">
                <ul class="sub-menu">
                    <li class="menu-item">
                        <a href="{{route('users')}}" class="menu-link">
                            <span class="menu-text">Data Users</span>
                        </a>
                    </li>
                    @can('create users')
                        <li class="menu-item">
                            <a href="{{route('users.create')}}" class="menu-link">
                                <span class="menu-text">Register User</span>
                            </a>
                        </li>
                    @endcan
                    @can('view roles')
                        <li class="menu-item">
                            <a href="{{route('users.roles')}}" class="menu-link">
                                <span class="menu-text">Role User</span>
                            </a>
                        </li>
                    @endcan
                    @can('view logs')
                        <li class="menu-item">
                            <a href="{{route('users.logs')}}" class="menu-link">
                                <span class="menu-text">Logs</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>
    @endcan
</ul>
<!--- End Menu -->
