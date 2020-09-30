<header>
    <div class="headerwrapper">
        <div class="header-left">
            <a href="/" class="logo">
                <img src="{{ asset('design/images/logo.png')}}" alt="" /> 
            </a>
            <div class="pull-right">
                <a href="#" class="menu-collapse">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div><!-- header-left -->
        
        <div class="header-right">
            
            <div class="pull-right">
                <div class="btn-group btn-group-option">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="/my-profile"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                        {{-- <li><a href="/settings"><i class="glyphicon glyphicon-cog"></i> Account Settings</a></li> --}}
                        <li><a href="/get-help"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
                        <li class="divider"></li>
                        <li><a href="/logout"><i class="glyphicon glyphicon-log-out"></i>Sign Out</a></li>
                    </ul>
                </div><!-- btn-group -->
                
            </div><!-- pull-right -->
            
        </div><!-- header-right -->
        
    </div><!-- headerwrapper -->
</header>
