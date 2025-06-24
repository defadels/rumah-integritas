<div class="user-box text-center">
    <img src="@if(Auth::user()->avatar != NULL) {{route('profile.avatar',['filename' => Auth::user()->avatar ])}} @else {{route('profile.avatar',['filename' => 'avatar.png' ])}} @endif" alt="user-img"
         title="Mat Helme" class="rounded-circle avatar-md">
    <div class="dropdown">
        <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block" data-bs-toggle="dropdown">{{Auth::user()->name}}</a>
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
    <p class="text-muted mb-0">{{Auth::user()->email}}</p>
</div>
