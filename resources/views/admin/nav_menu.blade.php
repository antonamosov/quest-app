<div class="nav_menu">
    <nav class="" role="navigation">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="/images/img.jpg" alt="">{{ \Illuminate\Support\Facades\Auth::User()->name }}
                    <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                </ul>
            </li>

            <li role="presentation" class="dropdown">

                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                        <a>
                            <span class="image"><img src="/images/img.jpg" alt="Profile Image"></span>
                        <span>
                          <span>{{ \Illuminate\Support\Facades\Auth::User()->name }}</span>
                        </span>

                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </nav>
</div>