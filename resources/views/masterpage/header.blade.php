
<header class="app-header" style='background-color:#000000'>
    <nav class="navbar navbar-expand-lg navbar-light" >
        <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)" style='color:#ffffff'>
            <i class="ti ti-menu-2"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
            <i class="ti ti-bell-ringing" style='color:#ffffff'></i>
            <div class="notification bg-danger rounded-circle"></div>
            </a>
        </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            {{--<a href="{{url('#')}}" class="btn btn-light">---</a>--}}
            <li class="nav-item dropdown">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="@if(Auth::user()->avatar=='') {{url('assets/img/user.png?v=e3')}} @else {{Auth::user()->avatar}} @endif" alt="" width="35" height="35" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                <div class="message-body">
                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-user fs-6"></i>
                    <p class="mb-0 fs-3">Mi Perfil</p>
                </a>
                <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-mail fs-6"></i>
                    <p class="mb-0 fs-3">Configuraci&oacute;n</p>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-dark mx-3 mt-2 d-block ">Cerrar sesi&oacute;n</button>
                </form>
                </div>
            </div>
            </li>
        </ul>
        </div>
    </nav>
</header>