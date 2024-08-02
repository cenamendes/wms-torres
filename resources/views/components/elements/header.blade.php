<style>
    span.ml-2:hover {
        color: #000000 !important;
    }

    .dropdown-menu .dropdown-item:hover {
        color: #000000;
    }
    .header-right .header-profile .dropdown-menu a:hover, .header-right .header-profile .dropdown-menu a:focus, .header-right .header-profile .dropdown-menu a.active {
    color: #000000;
}
</style>
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                </div>
                <ul class="navbar-nav header-right">

                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                            @if (Auth::user()->photo == null)
                                <img src="{!! global_asset('assets/resources/images/avatar/1.png') !!}" width="20" alt="">
                            @else
                                {{-- <img src="{!! global_asset('cl/'.Auth::user()->photo.'') !!}" width="20" alt=""> --}}
                                <img src="{!! global_tenancy_asset('/app/public/profile/' . Auth::user()->photo . '') !!}" width="20" alt="">
                            @endif
                            <div class="header-info">
                                <span class="text-black"><strong>{{ Auth::user()->name }}</strong></span>
                                @if (Auth::user()->type_user == '2')
                                    <p class="fs-12 mb-0">Admin</p>
                                @endif
                                @if (Auth::user()->type_user == '1')
                                    <p class="fs-12 mb-0">Colaborador</p>
                                @endif
                                @isset(Auth::user()->users->job)
                                    <p class="fs-12 mb-0">{{ Auth::user()->users->job }}</p>
                                @endisset
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item ai-icon" href="{{ route('tenant.profile.index') }}">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                    width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" style="color: #000000 !important;">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ml-2">{{ __('Profile') }} </span>
                            </a>
                            <a href="#" class="dropdown-item ai-icon d-none">
                                <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success"
                                    width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <span class="ml-2">{{ __('Inbox') }} </span>
                            </a>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                        width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg><span class="ml-2">{{ __('Logout') }}</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
