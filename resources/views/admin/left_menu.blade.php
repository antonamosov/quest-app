<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="/admin" class="site_title"><i class="fa fa-paw"></i> <span>Sydney Quest</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ \Illuminate\Support\Facades\Auth::User()->name }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br>

        @if($manager->Role->name === 'global')

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                    <h3>GENERAL</h3>
                    <ul class="nav side-menu">
                        <li><a><i class="fa fa-home"></i> Sub Domains <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/domain">All Sub Domains</a></li>
                                <li><a href="/admin/domain/create">Create Sub Domain</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-home"></i> Partners <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/partner">All Partners</a></li>
                                <li><a href="/admin/partner/create">Create Partner</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-edit"></i> Partner's Admins <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/admin">All Admins</a></li>
                                <li><a href="/admin/admin/create">Create Admin</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-home"></i> Contributors <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/contributor">All Contributors</a></li>
                                <li><a href="/admin/contributor/create">Create Contributor</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-desktop"></i> Categories <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/category">All Categories</a></li>
                                <li><a href="/admin/category/create">Create Category</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-desktop"></i> Tours <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/route">All Tours</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-table"></i> Codes <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/code">All Codes</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-table"></i> Landings <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/landing">All Landings</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-table"></i> Paypal transactions <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/paypal">All transactions</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-table"></i> PIN Payment transactions <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/pin">All transactions</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-desktop"></i> Reports <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/report/dashboard">Dashboard</a></li>
                                <li><a href="/admin/report/tables?sort_type=route&pay_system=all">General Table</a></li>
                                <li><a href="/admin/report/detailed?filter=all">Detailed Table</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-desktop"></i> API <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/api">Documentation</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>

        @endif
        <!-- /sidebar menu -->

        @if($manager->Role->name === 'admin')

                <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-table"></i> Tours <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/admin/route">All Tours</a></li>
                            <li><a href="/admin/route/create">Create Tour</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-home"></i> Contributors <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/admin/contributor">All Contributors</a></li>
                            <li><a href="/admin/contributor/create">Create Contributor</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-table"></i> Codes <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/admin/code">All Codes</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-edit"></i> Landing Page <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/admin/landing/preview">Edit page</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-desktop"></i> Reports <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/admin/report/dashboard">Dashboard</a></li>
                            <li><a href="/admin/report/tables?sort_type=route&pay_system=all">General Table</a></li>
                            <li><a href="/admin/report/detailed?filter=all">Detailed Table</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        @endif
                <!-- /sidebar menu -->

        @if($manager->Role->name === 'contributor')

                <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-table"></i> Tours <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/admin/route">All Tours</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-table"></i> Codes <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="/admin/code">All Codes</a></li>
                        </ul>
                    </li>

                </ul>
            </div>

        </div>

        @endif


        @if($manager->Role->name === 'api')

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                    <h3>General</h3>
                    <ul class="nav side-menu">
                        <li><a><i class="fa fa-desktop"></i> API <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/api">Documentation</a></li>
                            </ul>
                        </li>
                        <li><a><i class="fa fa-table"></i> Codes <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/admin/code">All Codes</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>

            </div>

        @endif
                <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">

            <a  href="/logout" data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>