<!--**********************************
          Nav header start
      ***********************************-->
<div class="nav-header bg-white" >
    <a href="{{ config('app.main_url') }}" class="brand-logo">
        <img class="w-100" src="http://visionaryservices.test/assets/common/images/1logo.png" alt="">
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<!--**********************************
      Nav header end
  ***********************************-->

<!--**********************************
      Header start
  ***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left"></div>

                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown header-profile">
                        <a
                            class="nav-link"
                            href="#"
                            role="button"
                            data-toggle="dropdown"
                        >
                            <div class="header-info">
                                <span>
                                    Hey, <strong>{{ auth()->guard('niftyassistant')->user()->getName() }}</strong>
                                </span>
                                <small>Assistant Profile</small>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('niftyassistant.profile.index') }}" class="dropdown-item ai-icon">
                                <svg
                                    id="icon-user1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="text-primary"
                                    width="18"
                                    height="18"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"
                                    ></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ml-2">Profile </span>
                            </a>
                            <form method="post" action="{{ route('auth.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    <span class="ml-2">Logout </span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!--**********************************
      Header end ti-comment-alt
  ***********************************-->

<!--**********************************
            Sidebar start
        ***********************************-->
<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li>
                <a class="ai-icon" href="{{ route('niftyassistant.index') }}" aria-expanded="false">
                    <svg
                        id="icon-home1"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-home"
                    >
                        <path
                            d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"
                            style="stroke-dasharray: 66px, 86px; stroke-dashoffset: 0px"
                        ></path>
                        <path
                            d="M9,22L9,12L15,12L15,22"
                            style="stroke-dasharray: 26px, 46px; stroke-dashoffset: 0px"
                        ></path>
                    </svg>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <li>
                <a class="ai-icon" href="{{ route('niftyassistant.profile.index') }}" aria-expanded="false">
                    <svg id="icon-apps" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span class="nav-text">Manage Profile</span>
                </a>
            </li>

            <li>
                <a class="ai-icon" href="{{ route('niftyassistant.services.index') }}" aria-expanded="false">
                    <svg id="icon-table" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>
                    <span class="nav-text">My Services</span>
                </a>
            </li>

            <li>
                <a class="ai-icon" href="{{ route('niftyassistant.tasks.index') }}" aria-expanded="false">
                    <svg
                        id="icon-forms"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-file-text"
                    >
                        <path
                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                            style="stroke-dasharray: 66px, 86px; stroke-dashoffset: 0px"
                        ></path>
                        <path
                            d="M14,2L14,8L20,8"
                            style="stroke-dasharray: 12px, 32px; stroke-dashoffset: 0px"
                        ></path>
                        <path
                            d="M16,13L8,13"
                            style="stroke-dasharray: 8px, 28px; stroke-dashoffset: 0px"
                        ></path>
                        <path
                            d="M16,17L8,17"
                            style="stroke-dasharray: 8px, 28px; stroke-dashoffset: 0px"
                        ></path>
                        <path
                            d="M10,9L9,9L8,9"
                            style="stroke-dasharray: 2px, 22px; stroke-dashoffset: 0px"
                        ></path>
                    </svg>
                    <span class="nav-text">Tasks</span>
                </a>
            </li>

            <li>
                <a class="ai-icon" href="{{ route('niftyassistant.support.index') }}" aria-expanded="false">
                    <svg id="icon-bootstrap" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    <span class="nav-text">Support</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--**********************************
      Sidebar end
  ***********************************-->
