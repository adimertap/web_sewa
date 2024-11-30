@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
$containerNav = ($configData['contentLayout'] === 'compact') ? 'container-xl' : 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
$configData = Helper::appClasses();
$user = Auth::user();
@endphp
<!-- Navbar -->
<style>
  /* Hide the element on larger screens (desktops) */
  #device-mobile-only {
    display: none;
  }

  /* Show the element on smaller screens (mobile devices) */
  @media (max-width: 768px) {
    #device-mobile-only {
      display: block;
    }
  }
</style>
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav
  class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme"
  id="layout-navbar">
  @else
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif
      {{-- <a class="navbar-brand" href="{{ url('/') }}">Selamat Datang</a> --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="dropdown-menu dropdown-menu-end navbar-nav p-3 bg-menu-theme" id="device-mobile-only">
          @foreach ($menuData[0]->menu as $menu)
          @if (!isset($menu->roles) || in_array($user->role, $menu->roles))
          {{-- menu headers --}}
          @if (isset($menu->menuHeader))
          <li class="menu-header mt-3">
            <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
          </li>
          @else
          @php
          $activeClass = null;
          $currentRouteName = Route::currentRouteName();
          if ($currentRouteName === $menu->slug) {
          $activeClass = 'active';
          } elseif (isset($menu->submenu)) {
          if (is_array($menu->slug)) {
          foreach ($menu->slug as $slug) {
          if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
          $activeClass = 'active open';
          }
          }
          } else {
          if (str_contains($currentRouteName, $menu->slug) && strpos($currentRouteName, $menu->slug) === 0) {
          $activeClass = 'active open';
          }
          }
          }
          @endphp

          {{-- main menu --}}
          <li class="menu-item {{ $activeClass }} mt-3">
            <a href="{{ isset($menu->route) ? route($menu->route) : 'javascript:void(0);' }}"
              class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) &&
              !empty($menu->target)) target="_blank" @endif>
              @isset($menu->icon)
              <i class="{{ $menu->icon }}"></i>
              @endisset
              <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
              @isset($menu->badge)
              <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
              @endisset
            </a>
            @isset($menu->submenu)
            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
            @endisset
          </li>
          @endif
          @endif
          @endforeach
        </ul>
      </div>
      {{-- <div class="collapse navbar-collapse" id="navbarNav"> --}}
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
          <ul class="navbar-nav flex-row align-items-center ms-auto">
            {{-- @if($configData['hasCustomizer'] == true)
            <li class="nav-item dropdown-style-switcher dropdown me-1 me-xl-0">
              <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class='ri-22px'></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                <li>
                  <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                    <span class="align-middle"><i class='ri-sun-line ri-22px me-3'></i>Light</span>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                    <span class="align-middle"><i class="ri-moon-clear-line ri-22px me-3"></i>Dark</span>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                    <span class="align-middle"><i class="ri-computer-line ri-22px me-3"></i>System</span>
                  </a>
                </li>
              </ul>
            </li>
            @endif --}}

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                  <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="rounded-circle">
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item"
                    href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-2">
                        <div class="avatar avatar-online">
                          <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <span class="fw-medium d-block small">
                          @if (Auth::check())
                          {{ Auth::user()->name }}
                          @else
                          John Doe
                          @endif
                        </span>
                        <small class="text-muted">Admin</small>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                </li>
                @if (Auth::check())
                <li>
                  <div class="d-grid px-4 pt-2 pb-1">
                    <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}"
                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <small class="align-middle">Logout</small>
                      <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                    </a>
                  </div>
                </li>
                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                  @csrf
                </form>
                @else
                <li>
                  <div class="d-grid px-4 pt-2 pb-1">
                    <a class="btn btn-sm btn-danger d-flex"
                      href="{{ Route::has('login') ? route('login') : url('auth/login-basic') }}">
                      <small class="align-middle">Login</small>
                      <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                    </a>
                  </div>
                </li>
                @endif
              </ul>
            </li>
            <!--/ User -->
          </ul>
        </div>
        {{--
      </div> --}}
  </nav>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>