

<div class="dash-sidebar position-sticky"

@if (get_setting('site_direction') == 'ltr')
    data-aos="fade-right" data-aos-easing="ease-in-sine"
@elseif (get_setting('site_direction') == 'rtl')
    data-aos="fade-left" data-aos-easing="ease-in-sine"
@endif>

    <div class="ps-3 d-flex align-items-center">
      <div class="media align-items-center">
          <div class="media-head me-2">
              <div class="avatar avatar-lg">
                  <img src="{{ my_asset('uploads/users/'.Auth::user()->image) }}" alt="user" class="avatar-img rounded-circle">
              </div>
          </div>
          <div class="media-body">
              <h5>{{ Auth::user()->name }}
                @if(Auth::user()->verified == 1)
                    <span class="verified-badge" data-bs-toggle="tooltip" aria-label="Verified User" data-bs-original-title="Verified User">
                    <i class="bi bi-patch-check"></i>
                    </span>
                @endif
              </h5>
              <p class="small mb-0">{{ trans('member_since') }} {{ Auth::user()->created_at->format('Y') }}</p>
          </div>
      </div>

      <!-- Responsive navbar toggler -->
      <button class="navbar-toggler ms-auto d-block d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav2"
          aria-controls="navbarNav2" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-animation user-backend">
              <span></span>
              <span></span>
              <span></span>
          </span>
      </button>
    </div>

  <div class="navbar-collapse d-xl-block collapse" id="navbarNav2">
    <ul class="navbar-nav flex-column">
     <li class="nav-info">{{ trans('dashboard') }} </li>
     <li class="nav-item {{ Route::is('user.videos.list') ? 'active' : '' }}
      {{ Route::is('user.videos.edit') ? 'active' : '' }}
        {{ Route::is('user.videos.add') ? 'active' : '' }}
        {{ Route::is('user.videos.topup') ? 'active' : '' }}
        {{ Route::is('user.videos.view') ? 'active' : '' }}">
       <a class="nav-link" href="{{ route('user.videos.list') }}">
         <span class="nav-icon-wrap"><i class="bi bi-youtube"></i></span>
         <span class="nav-link-text">{{ trans('videos') }}</span>
       </a>
     </li>
     <li class="nav-item {{ Route::is('user.viewers') ? 'active' : '' }}">
       <a class="nav-link" href="{{ route('user.viewers') }}">
         <span class="nav-icon-wrap"><i class="bi bi-eye"></i></span>
         <span class="nav-link-text">{{ trans('viewers') }}</span>
       </a>
     </li>
     <li class="nav-info">{{ trans('account') }} </li>
     <li class="nav-item {{ Route::is('user.profile') ? 'active' : '' }}
        {{ Route::is('user.password') ? 'active' : '' }}
        {{ Route::is('user.email.notifications') ? 'active' : '' }}">
       <a class="nav-link" href="{{ route('user.profile') }}">
         <span class="nav-icon-wrap"><i class="bi bi-gear"></i></span>
         <span class="nav-link-text">{{ trans('settings') }}</span>
       </a>
     </li>

     <li class="nav-item {{ Route::is('user.wallet') ? 'active' : '' }}">
       <a class="nav-link" href="{{ route('user.wallet') }}">
         <span class="nav-icon-wrap"><i class="bi bi-wallet2"></i></span>
         <span class="nav-link-text">{{ trans('wallet') }}</span>
       </a>
     </li>
     <li class="nav-item {{ Route::is('user.payments') ? 'active' : '' }}">
       <a class="nav-link" href="{{ route('user.payments') }}">
         <span class="nav-icon-wrap"><i class="bi bi-credit-card-2-front"></i></span>
         <span class="nav-link-text">{{ trans('payments') }}</span>
       </a>
     </li>
     <li class="nav-item {{ Route::is('user.earnings') ? 'active' : '' }}">
       <a class="nav-link" href="{{ route('user.earnings') }}">
         <span class="nav-icon-wrap"><i class="bi bi-currency-dollar"></i></span>
         <span class="nav-link-text">{{ trans('earnings') }}</span>
       </a>
     </li>
     <li class="nav-item {{ Route::is('user.withdrawals') ? 'active' : '' }}">
       <a class="nav-link" href="{{ route('user.withdrawals') }}">
         <span class="nav-icon-wrap"><i class="bi bi-piggy-bank"></i></span>
         <span class="nav-link-text">{{ trans('withdrawals') }}</span>
       </a>
     </li>


    </ul>
  </div>


</div>
