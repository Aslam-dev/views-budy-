

		<!-- ==============================================
		 Navbar
		=============================================== -->
		<header class="vine-navbar fixed-top">
			<nav class="navbar navbar-expand-lg">
				<div class="container align-items-center">
					<div class="logo">
						<a class="navbar-brand" href="{{ route('home') }}">
							<img class="logo-dark" src="{{ my_asset('uploads/settings/'.get_setting('logo')) }}" alt="Logo">
						</a>
					</div>
					<div class="offcanvas nav-offcanvas offcanvas-start" tabindex="-1" id="offcanvas_Header_01" aria-labelledby="offcanvas_Header_01">
						<div class="offcanvas-header flex-wrap border-bottom border-gray-200">
							<div class="offcanvas-title">

                                @if (Auth::check())
								<div class="d-flex align-items-center">
									<div class="avatar"><img class="avatar-img rounded-circle" src="{{ my_asset('uploads/users/'.Auth::user()->image) }}" alt="User"></div>
									<div class="col ps-3">
										<h6 class="mb-0">{{ Auth::user()->name }}</h6></div>
								</div>
                                @else
								<div class="d-flex align-items-center">
									<div class="avatar"><img class="avatar-img rounded-circle" src="{{ my_asset('uploads/settings/'.get_setting('favicon')) }}" alt="User"></div>
									<div class="col ps-3">
										<h6 class="mb-0">{{ get_setting('site_name') }}</h6><span class="small">{{ get_setting('site_title') }}</span></div>
								</div>
                                @endif
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_Header_01" aria-label="Close"></button>
						</div>
						<div class="offcanvas-body">

                            <!-- Nav Search START -->
                            <div class="col-xl-5">
                                <div class="nav mt-3 mt-lg-0 px-lg-4 flex-nowrap align-items-center">
                                    <div class="search-form nav-item w-100">
                                        <form class="rounded position-relative">
                                            <input class="bg-opacity-10 border-0" data-toggle="search" type="search" placeholder="Search" aria-label="Search">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Nav Search END -->

							<ul class="navbar-nav">

								<li class="nav-item dropdown mega-dropdown-md">
									<a id="MegaMenu" class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="bi bi-collection me-2"></i>Pages
									</a>
									<div class="dropdown-menu p-0">
										<div class="d-lg-flex">
										  <div class="mega-dropdown-column pt-lg-3 pb-lg-4 px-3">
											<h6 class="mega-menu-title">Platform</h6>
											<ul class="list-unstyled mb-0 ps-2">
											  <li><a href="{{ route('home') }}" class="dropdown-item"><i class="bi bi-house-door me-2"></i> {{ trans('home') }}</a></li>
											  <li><a href="{{ route('users') }}" class="dropdown-item"><i class="bi bi-people me-2"></i> {{ trans('users') }}</a></li>
											  <li><a href="{{ route('categories') }}" class="dropdown-item"><i class="bi bi-back me-2"></i> {{ trans('categories') }}</a></li>
                                              <li><a href="{{ route('leaderboard') }}" class="dropdown-item"><i class="bi bi-list-stars me-2"></i>{{ trans('leaderboard') }}</a></li>
											</ul>
										  </div>
										  <div class="mega-dropdown-column pt-lg-3 pb-lg-4 px-3">
											<h6 class="mega-menu-title">Pages</h6>
											<ul class="list-unstyled mb-0 ps-2">
                                                <li><a href="{{ route('about') }}" class="dropdown-item"><i class="bi bi-list me-2"></i>{{ trans('about') }}</a></li>
											  <li><a href="{{ route('faqs') }}" class="dropdown-item"><i class="bi bi-list me-2"></i>{{ trans('faqs') }}</a></li>
											  <li><a href="{{ route('privacy') }}" class="dropdown-item"><i class="bi bi-list me-2"></i>{{ trans('privacy_policy') }}</a></li>
											  <li><a href="{{ route('terms') }}" class="dropdown-item"><i class="bi bi-list me-2"></i>{{ trans('terms_&_conditions') }}</a></li>
											</ul>
										  </div>
										</div>
									</div>
								</li>


							</ul>


						</div>
					</div>
					<div class="header-end d-flex justify-content-end">

						<!--  Add Post Start -->
						<div class="h-col h-plus-toggle h-btn d-none d-sm-block">
							<a class="btn btn-mint rounded-circle" href="{{ route('user.videos.add') }}">
								<i class="bi bi-plus-lg"></i>
							</a>
						</div>
						<!-- Add Post END -->

						<!-- Translate dropdown START -->
						<div class="h-col h-plus-toggle">
							<a class="h-icon has-popup" href="#trans-dialog">
								<i class="bi bi-translate"></i>
							</a>
						</div>
						<!-- Translate dropdown END -->

                    @if (Auth::user())



						<!-- Notification dropdown START -->
						<div class="nav-item dropdown h-col d-none d-lg-block">

							<a class="h-notification-icon h-icon" href="javascript:void(0);" onclick="markAsRead()" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
								<i class="bi bi-bell"></i> <sup id="notify">{{ Auth::user()->viewers_count() }}</sup>
							</a>

							<!-- Notification dropdown menu START -->
							<div class="dropdown-menu dropdown-animation dropdown-menu-end dropdown-menu-size-md p-0 shadow-lg border-0">
								<div class="card bg-transparent border-0">
									<div class="card-header bg-transparent py-4 d-flex justify-content-between align-items-center">
										<h6 class="m-0">{{ trans('viewers') }}
                                            <span class="badge bg-danger bg-opacity-10 text-danger ms-2">{{ Auth::user()->viewers_count() }}</span>
                                        </h6>
									</div>
									<div data-simplebar
                                    @if (get_setting('site_direction') == 'rtl')
                                        data-simplebar-direction='rtl'
                                    @endif class="card-body p-0 dropdown-body">
										<ul class="list-group list-unstyled list-group-flush">

                                            @forelse(Auth::user()->viewers() as $views)

                                                <li>
                                                    <a href="{{ route('user.videos.view', ['id' => $views->video_id]) }}" class="list-group-item-action border-0 d-flex p-3">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md">
                                                                <img class="avatar-img rounded-circle"
                                                                src="{{ my_asset('uploads/users/'.App\Models\User::find($views->user_id)->image) }}" alt="avatar">
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">{{ App\Models\User::find($views->user_id)->name }} {{ trans('watched_your_video') }}</h6>
                                                            <p class="small m-0">{{ App\Models\Video::find($views->video_id)->title }}</p>
                                                            <small class="text-muted fs-xs">{{ $views->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                </li><!-- Notif item -->

                                            @empty

                                                <li>
                                                    <a href="#" class="list-group-item-action border-0 d-flex p-3">
                                                        <div class="me-3">
                                                            <div class="avatar avatar-md"></div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1">{{ trans('no_notifications_available') }}</h6>
                                                        </div>
                                                    </a>
                                                </li><!-- Notif item -->
                                            @endforelse

										</ul>
									</div>
									<!-- Button -->
									<div class="card-footer bg-transparent border-0 py-3 text-center position-relative">
										<a href="{{ route('user.viewers') }}" class="stretched-link">{{ trans('view_all_notifications') }}</a>
									</div>
								</div>
							</div>
							<!-- Notification dropdown menu END -->
						</div>
						<!-- Notification dropdown END -->

						<!-- Account -->
						<div class="nav-item ms-3 dropdown h-col">
							<a href="#" id="navbarShoppingCartDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
							<div class="d-flex">
							<img class="avatar-sm avatar-img rounded-circle" src="{{ my_asset('uploads/users/'.Auth::user()->image) }}" alt="Image Description">
							<div class="profile-text d-none d-sm-block">
								<div class="profile-head text-muted">{{ trans('hello') }},</div>
								<div class="text-nowrap">{{ Auth::user()->name }} </div>
							</div>
							</div>
							</a>

							<div class="dropdown-menu dropdown-animation dropdown-menu-end dropdown-menu-size-md p-2 shadow-lg border-0" aria-labelledby="navbarShoppingCartDropdown" style="min-width: 16rem;">


                                <a class="dropdown-item" href="{{ route('user.wallet') }}"><span class="dropdown-item-icon">
                                    <i class="bi-wallet2"></i></span> {{ trans('wallet') }} : {{ get_setting('currency_symbol') }}{{ Auth::user()->wallet }}</a>
                                <a class="dropdown-item" href="{{ route('user.earnings') }}"><span class="dropdown-item-icon">
                                    <i class="bi bi-currency-dollar"></i></span> {{ trans('earnings') }} : {{ get_setting('currency_symbol') }}{{ Auth::user()->earnings }}</a>

                                    <div class="dropdown-divider my-3"></div>

                                @if(Auth::user()->role === "Admin" || Auth::user()->role === "Moderator")
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}"><span class="dropdown-item-icon"><i class="bi-person"></i></span>{{ trans('admin') }} {{ trans('dashboard') }}</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('user.videos.list') }}"><span class="dropdown-item-icon"><i class="bi-house-door"></i></span> {{ trans('user') }} {{ trans('dashboard') }}</a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="dropdown-item-icon"><i class="bi-box-arrow-right"></i></span> {{ trans('logout') }}</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
							</div>
						</div><!-- End Account -->

                    @else

                      <div class="nav-item">
                        <a href="{{ route('auth.login') }}" class="btn btn-mint rounded-5 px-4 py-2 ms-3">{{ trans('login') }}</a>
                        <a href="{{ route('auth.register') }}" class="btn btn-red rounded-5 px-4 py-2">{{ trans('register') }}</a>
                      </div>

                    @endif

						<!-- Mobile Toggle -->
						<div class="h-col h-toggler d-xl-none">
							<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_Header_01" aria-controls="offcanvas_Header_01">
							 <span class="px-navbar-toggler-icon"></span>
							</button>
						</div>
					</div>
				</div>
			</nav>
		</header>


        <!-- start search block -->
        <div class="search-overlay" data-toggle="search-close"></div>
        <div data-simplebar class="search-block overflow-auto bg-body">
            <div data-toggle="search-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </div>

            <div class="is-hidden">
                <input type="text" id="search" placeholder="Search users, categories & posts ..." aria-label="search-query">
            </div>
            <div id="searchResults">

                <div class="mt-4 pt-2 is-hidden popular-people">
                    <div class="search-meta">
                        <div class="section-title mb-3">
                            <p class="title h4 mb-0">{{ trans('popular_users') }}</p>
                        </div>

                        <div class="people-grid">

                            @foreach (\App\Models\User::withCount('search_videos')->orderBy('search_videos_count', 'desc')->limit(5)->get() as $user)
                                <a href="{{ route('user', ['id' => $user->id, 'slug' => $user->slug]) }}" class="people-grid-item">
                                    <div class="people-grid-image">
                                    <img src="{{ my_asset('uploads/users/'.$user->image) }}" alt="Image">
                                    </div>
                                    <p class="people-grid-title">{{ $user->name }}</p>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-2 is-hidden popular-tags">
                    <div class="search-meta">
                        <div class="section-title mb-3">
                            <p class="title h4 mb-0">{{ trans('popular_categories') }}</p>
                        </div>
                        <div class="tags">
                            <a href="{{ route('categories') }}" class="tag-link green">{{ trans('all_categories') }} <i class="bi bi-arrow-right"></i></a>
                            @foreach (\App\Models\Admin\Category::withCount('search_videos')->orderBy('search_videos_count', 'desc')->limit(10)->get() as $category)
                                <a href="{{ route('category', ['slug' => $category->slug]) }}" class="tag-link">{{ $category->name }} ({{ $category->videos()->count() }})</a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-2 is-hidden">
                    <div class="search-meta">
                        <div class="section-title mb-3 pb-1">
                            <p class="title h4 mb-0">{{ trans('popular_videos') }}</p>
                        </div>
                        <div class="row">

                            @foreach (\App\Models\Video::where('status', 1)->where('hidden', 1)->withCount('search_views')->orderBy('search_views_count', 'desc')->limit(6)->get() as $video)
                                <div class="col-lg-4 mb-3">

                                    <div class="video-post">
                                        <a href="{{ route('video', ['video_id' => $video->video_id, 'slug' => $video->slug]) }}">
                                            <!-- Blog Post Thumbnail -->
                                            <div class="video-post-thumbnail">
                                                <span class="video-post-count">{{ get_setting('currency_symbol'). round($video->amount) }}</span>
                                                <span class="video-post-time">{{ $video->video_duration }}</span>
                                                <div class="video-overlay"> </div>
                                                <span class="play-btn-trigger"></span>
                                                <!-- option menu -->
                                                <span class="btn-option" aria-expanded="false">
                                                    <i class="icon-feather-more-vertical"></i>
                                                </span>
                                                <img src="{{ ytThumbnail($video->video_id) }}" alt="Thumbnail">

                                            </div>

                                            <!-- Blog Post Content -->
                                            <div class="video-post-content">
                                                <h3>{{ $video->title }}</h3>
                                                <div class="media align-items-center">
                                                    <div class="media-head me-2">
                                                        <div class="avatar avatar-xs">
                                                            <img src="{{ my_asset('uploads/users/'.$video->user->image) }}" alt="user" class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6>{{ $video->user->name }}</h6>
                                                        <div class="fn__meta">
                                                            <p>
                                                                <span class="meta_item">{{ $video->created_at->diffForHumans() }}</span>
                                                                <span class="meta_sep"></span>
                                                                <span class="meta_item">{{ short($video->views()->count()) }} {{ trans('views') }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </a>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- end search block -->


        <div id="trans-dialog" class="white-popup zoom-anim-dialog mfp-hide">
			<div class="d-flex justify-content-between align-items-center mb-4">
				<h4 class="modal-title" id="langaugeModalLabel">{{ trans('choose_a_language') }}</h4>
			  </div>
			<div class="row row-cols-2 row-cols-lg-3 g-1 g-lg-1">

                @php
                    $languages = get_all_languages();
                    $current_locale = App::currentLocale();
                @endphp
                @foreach($languages as $lang)
                    @if($lang == $current_locale)
				        <a class="text-lang fw-semibold active">{{ ucfirst($lang) }} <span class="badge bg-red-mint ms-1">{{ trans('active') }}</span></a>
                    @else
				        <a class="text-lang fw-semibold" href="{{ route('language.change', ['locale' => $lang]) }}">{{ ucfirst($lang) }}</a>
                    @endif
                @endforeach
			  </div>
		</div>
