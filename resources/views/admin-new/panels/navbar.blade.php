@if($configData["mainLayoutType"] == 'horizontal' && isset($configData["mainLayoutType"]))
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu {{ $configData['navbarColor'] }} navbar-fixed">
        <div class="navbar-header d-xl-block d-none">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item"><a class="navbar-brand" href="dashboard-analytics">
                        <div class="brand-logo"></div>
                    </a></li>
            </ul>
        </div>
        @else
            <nav
                class="header-navbar navbar-expand-lg navbar navbar-with-menu {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }}">
                @endif
                <div class="navbar-wrapper">
                    <div class="navbar-container content">
                        <div class="navbar-collapse" id="navbar-mobile">
                            <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                                <ul class="nav navbar-nav">
                                    <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                            class="nav-link nav-menu-main menu-toggle hidden-xs"
                                            href="#"><i class="ficon feather icon-menu"></i></a></li>
                                </ul>
                                <ul class="nav navbar-nav bookmark-icons">
                                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top" title="Todo"><i
                                                class="ficon feather icon-check-square"></i></a></li>
                                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top" title="Chat"><i
                                                class="ficon feather icon-message-square"></i></a></li>
                                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top" title="Email"><i
                                                class="ficon feather icon-mail"></i></a></li>
                                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calender"
                                                                              data-toggle="tooltip"
                                                                              data-placement="top" title="Calendar"><i
                                                class="ficon feather icon-calendar"></i></a></li>
                                </ul>
                                <ul class="nav navbar-nav">
                                    <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i
                                                class="ficon feather icon-star warning"></i></a>
                                        <div class="bookmark-input search-input">
                                            <div class="bookmark-input-icon"><i class="feather icon-search primary"></i>
                                            </div>
                                            <input class="form-control input" type="text" placeholder="Explore Vuexy..."
                                                   tabindex="0"
                                                   data-search="laravel-search-list"/>
                                            <ul class="search-list search-list-bookmark"></ul>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                            <ul class="nav navbar-nav float-right">
                                <li class="dropdown dropdown-user nav-item"><a
                                        class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                        data-toggle="dropdown">
                                        <div class="user-nav d-sm-flex d-none">
                                            <span class="user-name text-bold-600">John                    Doe</span>
                                            <span class="user-status">Available</span>
                                        </div>
                                        <span>
                                    <img class="round"
                                         src="{{ asset('admin/images/portrait/small/avatar-s-11.jpg') }}"
                                         alt="avatar" height="40"
                                         width="40"/></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item"
                                           href="page-user-profile">
                                            <i class="feather icon-user"></i> Edit Profile</a>
                                        <a class="dropdown-item"
                                           href="app-email">
                                            <i class="feather icon-mail"></i> My
                                            Inbox</a>
                                        <a class="dropdown-item" href="app-todo"><i
                                                class="feather icon-check-square"></i> Task</a>
                                        <a
                                            class="dropdown-item" href="app-chat"><i
                                                class="feather icon-message-square"></i> Chats</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="auth-login"><i
                                                class="feather icon-power"></i> Logout</a>
                                        <form id="logout-form" action="login" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Search Start Here --}}
            <ul class="main-search-list-defaultlist d-none">
                <li class="d-flex align-items-center">
                    <a class="pb-25" href="#">
                        <h6 class="text-primary mb-0">Files</h6>
                    </a>
                </li>
                <li class="auto-suggestion d-flex align-items-center cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="#">
                        <div class="d-flex">
                            <div class="ml-0 mr-50"><img src="{{ asset('admin/images/icons/xls.png') }}" alt="png"
                                                         height="32"/>
                            </div>
                            <div class="search-data">
                                <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing
                                    Manager</small>
                            </div>
                        </div>
                        <small class="search-data-size mr-50 text-muted">&apos;17kb</small>
                    </a>
                </li>
                <li class="auto-suggestion d-flex align-items-center cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="#">
                        <div class="d-flex">
                            <div class="ml-0 mr-50"><img src="{{ asset('admin/images/icons/jpg.png') }}" alt="png"
                                                         height="32"/>
                            </div>
                            <div class="search-data">
                                <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd
                                    Developer</small>
                            </div>
                        </div>
                        <small class="search-data-size mr-50 text-muted">&apos;11kb</small>
                    </a>
                </li>
                <li class="auto-suggestion d-flex align-items-center cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="#">
                        <div class="d-flex">
                            <div class="ml-0 mr-50"><img src="{{ asset('admin/images/icons/pdf.png') }}" alt="png"
                                                         height="32"/>
                            </div>
                            <div class="search-data">
                                <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital
                                    Marketing Manager</small>
                            </div>
                        </div>
                        <small class="search-data-size mr-50 text-muted">&apos;150kb</small>
                    </a>
                </li>
                <li class="auto-suggestion d-flex align-items-center cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100" href="#">
                        <div class="d-flex">
                            <div class="ml-0 mr-50"><img src="{{ asset('admin/images/icons/doc.png') }}" alt="png"
                                                         height="32"/>
                            </div>
                            <div class="search-data">
                                <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web
                                    Designer</small>
                            </div>
                        </div>
                        <small class="search-data-size mr-50 text-muted">&apos;256kb</small>
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <a class="pb-25" href="#">
                        <h6 class="text-primary mb-0">Members</h6>
                    </a>
                </li>
                <li class="auto-suggestion d-flex align-items-center cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                        <div class="d-flex align-items-center">
                            <div class="avatar mr-50"><img
                                    src="{{ asset('admin/images/portrait/small/avatar-s-8.jpg') }}" alt="png"
                                    height="32"/></div>
                            <div class="search-data">
                                <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI
                                    designer</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="auto-suggestion d-flex align-items-center cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                        <div class="d-flex align-items-center">
                            <div class="avatar mr-50"><img
                                    src="{{ asset('admin/images/portrait/small/avatar-s-1.jpg') }}" alt="png"
                                    height="32"/></div>
                            <div class="search-data">
                                <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd
                                    Developer</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="auto-suggestion d-flex align-items-center cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                        <div class="d-flex align-items-center">
                            <div class="avatar mr-50"><img
                                    src="{{ asset('admin/images/portrait/small/avatar-s-14.jpg') }}" alt="png"
                                    height="32"/></div>
                            <div class="search-data">
                                <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital
                                    Marketing
                                    Manager</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="auto-suggestion d-flex align-items-center cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                        <div class="d-flex align-items-center">
                            <div class="avatar mr-50"><img
                                    src="{{ asset('admin/images/portrait/small/avatar-s-6.jpg') }}" alt="png"
                                    height="32"/></div>
                            <div class="search-data">
                                <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web
                                    Designer</small>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="main-search-list-defaultlist-other-list d-none">
                <li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer">
                    <a class="d-flex align-items-center justify-content-between w-100 py-50">
                        <div class="d-flex justify-content-start"><span
                                class="mr-75 feather icon-alert-circle"></span><span>No
    results found.</span></div>
                    </a>
                </li>
            </ul>
        {{-- Search Ends --}}
        <!-- END: Header-->
