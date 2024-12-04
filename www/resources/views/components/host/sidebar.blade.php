<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            @if(Auth::check())
                <li class="nav-item nav-link">
                    <h4>{{ Auth::user()->email }}</h4>
                </li>
            @endif
            @if (Route::has('login'))
                <li class="nav-item">
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                        @auth
                            <a class="nav-link @if(request()->routeIs('host.index')) active @endif" aria-current="page"
                               href="{{ route('host.index') }}">
                                <span data-feather="home" class="align-text-bottom">
                                    Добавить ПЭВМ
                                </span>
                            </a>
                        @else
                            <div class="nav-link">
                                <a href="{{ route('login') }}"
                                   class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                                    in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                                @endif
                            </div>
                        @endauth
                    </div>
                </li>
            @endif
            {{--            <li class="nav-item">--}}
            {{--                <a class="nav-link @if(request()->routeIs('host.index')) active @endif" aria-current="page"--}}
            {{--                   href="{{ route('host.index') }}">--}}
            {{--                    <span data-feather="home" class="align-text-bottom"></span>--}}
            {{--                    Добавить ПЭВМ--}}
            {{--                </a>--}}
            {{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('index')) active @endif" href="{{ route('index') }}">
                    <span data-feather="folder" class="align-text-bottom">
                        Главная страница
                    </span>
                </a>
            </li>
            @if(Auth::check())
                <li class="nav-item">
                    <div class="navbar-nav">
                        <div class="nav-item text-nowrap">
                            <a class="nav-link px-3" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Выход') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</nav>
