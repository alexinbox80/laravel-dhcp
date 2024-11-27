<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item nav-link">
{{--                <h4>Здравствуйте, {{ //Auth::user()->name }}!</h4>--}}
                <h4>Здравствуйте!</h4>
            </li>
{{--            @isset(Auth::user()->avatar)--}}
                <li class="nav-item nav-link">
                    <br>
{{--                    <img style="width: 200px;" src="{{ Auth::user()->avatar }}" alt="avatar">--}}
                    <br>
                </li>
{{--            @endisset--}}
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('host.index')) active @endif" aria-current="page" href="{{ route('host.index') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Добавить ПЭВМ
                </a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link @if(request()->routeIs('admin.categories.*')) active @endif" href="{{ route('admin.categories.index') }}">--}}
{{--                    <span data-feather="folder" class="align-text-bottom"></span>--}}
{{--                    Категории--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link @if(request()->routeIs('admin.news.*')) active @endif" href="{{ route('admin.news.index') }}">--}}
{{--                    <span data-feather="file" class="align-text-bottom"></span>--}}
{{--                    Новости--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link @if(request()->routeIs('admin.order.*')) active @endif" href="{{ route('admin.order.index') }}">--}}
{{--                    <span data-feather="file" class="align-text-bottom"></span>--}}
{{--                    Заказы--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link @if(request()->routeIs('admin.feedback.*')) active @endif" href="{{ route('admin.feedback.index') }}">--}}
{{--                    <span data-feather="file" class="align-text-bottom"></span>--}}
{{--                    Отзывы--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link @if(request()->routeIs('admin.profiles.*')) active @endif" href="{{ route('admin.profiles.index') }}">--}}
{{--                    <span data-feather="file" class="align-text-bottom"></span>--}}
{{--                    Пользователи--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
    </div>
</nav>
