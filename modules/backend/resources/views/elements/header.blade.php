<header>
    {{-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="{{ asset('backend/vendors/images/deskapp-logo.svg') }}" alt="" />
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div> --}}

    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>
            <div
                class="search-toggle-icon bi bi-search"
                data-toggle="header_search"
            ></div>
            {{-- <div class="header-search">
                <form>
                    <div class="form-group mb-0">
                        <i class="dw dw-search2 search-icon"></i>
                        <input
                            type="text"
                            class="form-control search-input"
                            placeholder="Search Here"
                        />
                        <div class="dropdown">
                            <a
                                class="dropdown-toggle no-arrow"
                                href="#"
                                role="button"
                                data-toggle="dropdown"
                            >
                                <i class="ion-arrow-down-c"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label"
                                        >From</label
                                    >
                                    <div class="col-sm-12 col-md-10">
                                        <input
                                            class="form-control form-control-sm form-control-line"
                                            type="text"
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">To</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input
                                            class="form-control form-control-sm form-control-line"
                                            type="text"
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label"
                                        >Subject</label
                                    >
                                    <div class="col-sm-12 col-md-10">
                                        <input
                                            class="form-control form-control-sm form-control-line"
                                            type="text"
                                        />
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> --}}
        </div>
        <div class="header-right">
            <div class="dashboard-setting user-notification">
                <div class="dropdown">
                    <a
                        class="dropdown-toggle no-arrow"
                        href="javascript:;"
                        data-toggle="right-sidebar"
                    >
                        <i class="dw dw-settings2"></i>
                    </a>
                </div>
            </div>
            {{-- <div class="user-notification">
                <div class="dropdown">
                    <a
                        class="dropdown-toggle no-arrow"
                        href="#"
                        role="button"
                        data-toggle="dropdown"
                    >
                        <i class="icon-copy dw dw-notification"></i>
                        <span class="badge notification-active"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="notification-list mx-h-350 customscroll">
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('backend/vendors/images/img.jpg') }}" alt="" />
                                        <h3>John Doe</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing
                                            elit, sed...
                                        </p>
                                    </a>
                                </li>
                                <!-- Các mục thông báo khác -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="user-info-dropdown">
                <div class="dropdown">
                    <a
                        class="dropdown-toggle"
                        href="#"
                        role="button"
                        data-toggle="dropdown"
                    >
                        <span class="user-icon">
                            @if (isset(Auth::user()->avatar))
                                <img src="{{  asset(Auth::user()->picture->image) }}" alt="" />
                            @else
                                <img src="{{ asset('backend/src/images/avatar-clone.svg') }}" alt="" />
                            @endif
                        </span>
                        <span class="user-name">@auth {{Auth::user()->name}} @endauth</span>
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
                    >
                        {{-- <a class="dropdown-item" href="profile.html"
                            ><i class="dw dw-user1"></i> Profile</a
                        > --}}
                        <a class="dropdown-item" href="{{route('admin-store-logout')}}"
                            ><i class="dw dw-logout1"></i> Logout</a
                        >
                        <!-- Các mục menu người dùng khác -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
