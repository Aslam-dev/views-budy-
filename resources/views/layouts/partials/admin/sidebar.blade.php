

<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('home') }}">
  <span class="align-middle">{{ get_setting('site_name') }}</span>
</a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">{{ trans('overview') }}</li>
            <li class="sidebar-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">{{ trans('dashboard') }}</span>
                </a>
            </li>
            <li class="sidebar-item  {{ Route::is('admin.categories.list') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.categories.list') }}">
                <i class="align-middle" data-feather="aperture"></i> <span class="align-middle">{{ trans('categories') }}</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.videos.list') ? 'active' : '' }}
            {{ Route::is('admin.videos.edit') ? 'active' : '' }}
            {{ Route::is('admin.videos.view') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.videos.list') }}">
                <i class="align-middle" data-feather="youtube"></i> <span class="align-middle">{{ trans('videos') }}</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.viewers') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.viewers') }}">
                <i class="align-middle" data-feather="eye"></i> <span class="align-middle">{{ trans('viewers') }}</span>
                </a>
            </li>

            <li class="sidebar-header">{{ trans('account') }}</li>
            <li class="sidebar-item {{ Route::is('admin.profile') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.profile') }}">
                <i class="align-middle" data-feather="user"></i> <span class="align-middle">{{ trans('profile') }}</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.users.list') ? 'active' : '' }}
                {{ Route::is('admin.users.view') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.users.list') }}">
                 <i class="align-middle" data-feather="users"></i> <span class="align-middle">{{ trans('users') }}</span>
                </a>
            </li>

            <li class="sidebar-header">{{ trans('payments') }}</li>
            <li class="sidebar-item {{ Route::is('admin.deposits') ? 'active' : '' }}
              {{ Route::is('admin.deposits.view') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.deposits') }}">
                <i class="align-middle" data-feather="list"></i> <span class="align-middle">{{ trans('deposits') }}</span>
                </a>
            </li>
            <li class="sidebar-item  {{ Route::is('admin.earnings') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.earnings') }}">
                <i class="align-middle" data-feather="align-justify"></i> <span class="align-middle">{{ trans('earnings') }}</span>
                </a>
            </li>
            <li class="sidebar-item  {{ Route::is('admin.withdrawals') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.withdrawals') }}">
                <i class="align-middle" data-feather="send"></i> <span class="align-middle">{{ trans('withdrawals') }}</span>
                </a>
            </li>

            <li class="sidebar-header">CMS</li>
            <li class="sidebar-item
                {{ Route::is('admin.pages.list') ? 'active' : '' }}
                {{ Route::is('admin.pages.add') ? 'active' : '' }}
                {{ Route::is('admin.pages.edit') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.pages.list') }}">
                <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">{{ trans('pages') }}</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.faqs.list') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.faqs.list') }}">
                <i class="align-middle" data-feather="list"></i> <span class="align-middle">{{ trans('faqs') }}</span>
                </a>
            </li>

            <li class="sidebar-header">{{ trans('settings') }}</li>
            <li class="sidebar-item
                {{ Route::is('admin.settings.site') ? 'active' : '' }}
                {{ Route::is('admin.settings.home') ? 'active' : '' }}
                {{ Route::is('admin.settings.currency') ? 'active' : '' }}
                {{ Route::is('admin.settings.payments') ? 'active' : '' }}
                {{ Route::is('admin.settings.ads') ? 'active' : '' }}
                {{ Route::is('admin.settings.analytics') ? 'active' : '' }}
                {{ Route::is('admin.settings.adsense') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.settings.site') }}">
                <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">{{ trans('site') }} {{ trans('settings') }}</span>
                </a>
            </li>
            <li class="sidebar-item
                {{ Route::is('admin.gateways.paypal') ? 'active' : '' }}
                {{ Route::is('admin.gateways.stripe') ? 'active' : '' }}
                {{ Route::is('admin.gateways.razorpay') ? 'active' : '' }}
                {{ Route::is('admin.gateways.paystack') ? 'active' : '' }}
                {{ Route::is('admin.gateways.mollie') ? 'active' : '' }}
                {{ Route::is('admin.gateways.flutterwave') ? 'active' : '' }}
                {{ Route::is('admin.gateways.bank') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.gateways.paypal') }}">
                <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">{{ trans('payment_gateways') }}</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.payouts.list') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.payouts.list') }}">
                <i class="align-middle" data-feather="command"></i> <span class="align-middle">{{ trans('payout_settings') }}</span>
                </a>
            </li>
            <li class="sidebar-item
                {{ Route::is('admin.auth.google') ? 'active' : '' }}
                {{ Route::is('admin.auth.facebook') ? 'active' : '' }}
                {{ Route::is('admin.auth.email') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.auth.google') }}">
                  <i class="align-middle" data-feather="key"></i> <span class="align-middle">{{ trans('auth') }} {{ trans('settings') }}</span>
                </a>
            </li>
            <li class="sidebar-item
                {{ Route::is('admin.languages.index') ? 'active' : '' }}
                {{ Route::is('admin.languages.edit') ? 'active' : '' }}
                {{ Route::is('admin.languages.default') ? 'active' : '' }}
                {{ Route::is('admin.languages.dates') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.languages.index') }}">
                <i class="align-middle" data-feather="globe"></i> <span class="align-middle">{{ trans('languages') }} {{ trans('settings') }}</span>
                </a>
            </li>
            <li class="sidebar-item {{ Route::is('admin.settings.mail') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.settings.mail') }}">
                <i class="align-middle" data-feather="mail"></i> <span class="align-middle">{{ trans('mail') }} {{ trans('settings') }}</span>
                </a>
            </li>
            <li class="sidebar-item
                {{ Route::is('admin.email.list') ? 'active' : '' }}
                {{ Route::is('admin.email.edit') ? 'active' : '' }}
                {{ Route::is('admin.email.add') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.email.list') }}">
                <i class="align-middle" data-feather="send"></i> <span class="align-middle">{{ trans('email_templates') }}</span>
                </a>
            </li>
        </ul>

    </div>
</nav>
