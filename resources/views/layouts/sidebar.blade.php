<div class="leftpanel">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="/my-profile">
            @if(auth()->user()->profile_picture == null)
                <img class="img-circle" src="{{ asset('design/images/profit.png') }}" style="width:50px; height: 50px;" alt="">
            @else
                <img class="img-circle" src="{{ asset('profile_pics/'.auth()->user()->profile_picture) }}" style="width:50px; height: 50px;" alt="">
            @endif
        </a>
        <div class="media-body">
            <h4 class="media-heading">{{ auth()->user()->name }}</h4>
            <small class="text-muted">{{ auth()->user()->email }}</small>
        </div>
    </div><!-- media -->
    
    <ul class="nav nav-pills nav-stacked">
    @if(auth()->user()->role_id == 2)
    <h5 class="leftpanel-title">Dashboard</h5>
        <li @if(request()->route()->getName() == "Home") class="active" @endif><a href="/overview"><i class="fa fa-eye"></i> <span>Overview</span></a></li>
    <h5 class="leftpanel-title">Investment</h5>
        <li @if(request()->route()->getName() == "Make Investment") class="active" @endif><a href="/make-investment-page"><i class="fa fa-upload"></i> <span>Invest</span></a></li>
        <li @if(request()->route()->getName() == "Investments") class="active" @endif><a href="/get-investments"><i class="fa fa-table"></i> <span>Investments</span></a></li>
    <h5 class="leftpanel-title">Account</h5>
        <li @if(request()->route()->getName() == "Make Withdraw") class="active" @endif><a href="/get-withdraws-page"><i class="fa fa-download"></i> <span>Cash out</span></a></li>
        <li @if(request()->route()->getName() == "Earnings") class="active" @endif><a href="/get-earnings"><i class="fa fa-money"></i> <span>Earnings</span></a></li>
        <li @if(request()->route()->getName() == "Withdraws") class="active" @endif><a href="/get-withdraws"><i class="fa fa-table"></i> <span>Withdraws</span></a></li>
        <li @if(request()->route()->getName() == "Transactions") class="active" @endif><a href="/all-transactions"><i class="fa fa-table"></i> <span>All Transactions</span></a></li>
    <h5 class="leftpanel-title">Settings</h5>
        <li @if(request()->route()->getName() == "Profile") class="active" @endif><a href="/my-profile"><i class="fa fa-users"></i> <span>Profile</span></a></li>
        <li @if(request()->route()->getName() == "Help") class="active" @endif><a href="/get-help"><i class="glyphicon glyphicon-question-sign"></i> <span>Help</span></a></li>
        <li @if(request()->route()->getName() == "About Company") class="active" @endif><a href="{{ asset('design/pdf/PROFIT POINT.pdf') }}" target="_blank"><i class="fa fa-info"></i> <span>About the Company</span></a></li>
    @endif
    @if(auth()->user()->role_id == 1)
    <h5 class="leftpanel-title">Admininstration</h5>
        <li @if(request()->route()->getName() == "Home") class="active" @endif><a href="/overview"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
        <li @if(request()->route()->getName() == "Users") class="active" @endif><a href="/all-users"><i class="fa fa-users"></i> <span>Users</span></a></li>
        <li @if(request()->route()->getName() == "Investments") class="active" @endif><a href="/all-investments"><i class="fa fa-upload"></i> <span>Investments</span></a></li>
        <li @if(request()->route()->getName() == "Withdraws") class="active" @endif><a href="/get-all-withdraws"><i class="fa fa-download"></i> <span>Withdraws</span></a></li>
        <li @if(request()->route()->getName() == "Transactions") class="active" @endif><a href="/get-all-transactions"><i class="fa fa-money"></i> <span>Transactions</span></a></li>
    @endif
    </ul>
</div><!-- leftpanel -->
