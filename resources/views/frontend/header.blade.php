<!-- Sidebar -->
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15" style="padding-top: 8px !important;">
            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r"
                        data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a href="{{ config('app.main_url') }}">
                        <img class="pt-3 w-100" src="/assets/common/images/1logo.png"  alt=""/>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li>
                    <a href="{{ route('frontend.index') }}"><i class="si si-cup"></i><span
                            class="sidebar-mini-hide">Dashboard</span></a>
                </li>

                <li>
                    <a href="{{ route('frontend.bookings.index') }}">
                        <i class="si si-users"></i><span class="sidebar-mini-hide">Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.invoices.index') }}">
                        <i class="si si-docs"></i><span class="sidebar-mini-hide">Invoices</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="{{ route('frontend.nifty-wallet.index') }}">
                        <i class="si si-wallet"></i><span class="sidebar-mini-hide">Nifty Wallet</span>
                    </a>
                </li> -->
                <li>
                    <a href="{{ route('frontend.payments.index') }}">
                        <i class="fa fa-money"></i><span class="sidebar-mini-hide">Payments</span>
                    </a>
                </li>
                <li class="nav-main-heading"><span class="sidebar-mini-visible">ST</span><span
                        class="sidebar-mini-hidden">Settings</span></li>
                <li>
                    <a href="{{ route('frontend.profile.index') }}">
                        <i class="si si-notebook"></i>
                        <span class="sidebar-mini-hide">Profile</span>
                    </a>
                </li>
                @if(auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <i class="si si-user"></i><span class="sidebar-mini-hide">Admin</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>
<!-- END Sidebar -->

<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="content-header-section">
            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout"
                    data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
            <!-- END Toggle Sidebar -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="content-header-section">
            <!-- User Dropdown -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ auth()->user()->name }}
                    <i class="fa fa-angle-down ml-5"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-150"
                     aria-labelledby="page-header-user-dropdown">
                    <a class="dropdown-item" href="{{ route('frontend.profile.index') }}">
                        <i class="si si-user mr-5"></i> Profile
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="post" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="si si-logout mr-5"></i> Sign Out
                        </button>
                    </form>
                </div>
            </div>
            <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Search -->
    <div id="page-header-search" class="overlay-header">
        <div class="content-header content-header-fullrow">
            <form>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <!-- Close Search Section -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-secondary px-15" data-toggle="layout"
                                data-action="header_search_off">
                            <i class="fa fa-times"></i>
                        </button>
                        <!-- END Close Search Section -->
                    </div>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.."
                           id="page-header-search-input" name="page-header-search-input">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary px-15">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Header Search -->

    <!-- Header Loader -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
<!-- END Header -->
