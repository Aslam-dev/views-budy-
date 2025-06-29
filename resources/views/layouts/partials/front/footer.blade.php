
<footer id="site-footer" class="site-footer border-top">

    <div class="site-footer__content">

            <nav class="footer-nav">
                <ul class="footer-nav-menu">
                    <li class="footer-nav-menu-item">
                        <a href="{{ route('about') }}" class="footer-nav-menu-link"><span class="nav-primary__menu-title">{{ trans('about') }}</span></a>
                    </li>
                    <li class="footer-nav-menu-item">
                        <a href="{{ route('privacy') }}" class="footer-nav-menu-link"><span class="nav-primary__menu-title">{{ trans('privacy_policy') }}</span></a>
                    </li>
                    <li class="footer-nav-menu-item">
                        <a href="{{ route('terms') }}" class="footer-nav-menu-link"><span class="nav-primary__menu-title">{{ trans('terms_&_conditions') }}</span></a>
                    </li>
                    <li class="footer-nav-menu-item">
                        <a href="{{ route('cookie') }}" class="footer-nav-menu-link"><span class="nav-primary__menu-title">{{ trans('cookie_policy') }}</span></a>
                    </li>
                </ul>
            </nav>

        <div class="footer-socials">
            <div class="socials">
                <a href="{{ get_setting('facebook') }}" class="socials__link" target="_blank"><i class="bi bi-facebook"></i></a>
                <a href="{{ get_setting('instagram') }}" class="socials__link" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="{{ get_setting('twitter') }}" class="socials__link" target="_blank"><i class="bi bi-twitter"></i></a>
                <a href="{{ get_setting('tiktok') }}" class="socials__link" target="_blank"><i class="bi bi-tiktok"></i></a>
                <a href="{{ get_setting('linkedin') }}" class="socials__link" target="_blank"><i class="bi bi-linkedin"></i></a>
                <a href="{{ get_setting('youtube') }}" class="socials__link" target="_blank"><i class="bi bi-youtube"></i></a>
            </div>
        </div>

        <p class="footer-copyright">© {{ date('Y') }} {{ get_setting('site_name') }}</p>

    </div>

</footer>
