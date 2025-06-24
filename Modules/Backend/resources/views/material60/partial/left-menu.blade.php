<div class="app-menu">

    <!-- Brand Logo -->
    <div class="logo-box">
        <!-- Brand Logo Light -->
        <a href="index.html" class="logo-light">
            <img src="{{asset('')}}assets/themes/material/assets/images/brand-rumah-integritas-dashboard.png" alt="logo" class="logo-lg">
            <img src="{{asset('')}}assets/themes/material/assets/images/brand-rumah-integritas-dashboard.png" alt="small logo"
                 class="logo-sm">
        </a>

        <!-- Brand Logo Dark -->
        <a href="index.html" class="logo-dark">
            <img src="{{asset('')}}assets/themes/material/assets/images/brand-rumah-integritas-dashboard.png" alt="dark logo"
                 class="logo-lg">
            <img src="{{asset('')}}assets/themes/material/assets/images/brand-rumah-integritas-dashboard.png" alt="small logo"
                 class="logo-sm">
        </a>
    </div>

    <!-- menu-left -->
    <div class="scrollbar">

        <!-- User box -->

    @include('backend::material.partial.userbox')
    <!--- Menu -->
        @include('backend::material.partial.sidebar')
        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left menu End ========== -->
