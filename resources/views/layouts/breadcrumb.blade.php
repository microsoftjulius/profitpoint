<div class="pageheader">
    <div class="media">
        <div class="pageicon pull-left">
            @if(request()->route()->getName() == "Home")
                <i class="fa fa-home"></i>
            @elseif(request()->route()->getName() == "Make Investment")
                <i class="fa fa-upload"></i>
            @elseif(request()->route()->getName() == "Investments")
                <i class="fa fa-table"></i>
            @elseif(request()->route()->getName() == "Make Withdraw")
                <i class="fa fa-download"></i>
            @elseif(request()->route()->getName() == "Earnings")
                <i class="fa fa-money"></i>
            @elseif(request()->route()->getName() == "Withdraws")
                <i class="fa fa-table"></i>
            @elseif(request()->route()->getName() == "Transactions")
                <i class="fa fa-table"></i>
            @elseif(request()->route()->getName() == "Profile")
                <i class="fa fa-users"></i>
            @elseif(request()->route()->getName() == "Help")
                <i class="glyphicon glyphicon-question-sign"></i>
            @elseif(request()->route()->getName() == "About Company")
                <i class="fa fa-list"></i>
            @elseif(request()->route()->getName() == "Settings")
                <i class="fa fa-cog"></i>
            @endif
        </div>
        <div class="media-body">
            <ul class="breadcrumb">
                <li>{{ app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName() }}</li>
            </ul>
            <h4>{{ request()->route()->getName() }}</h4>
        </div>
    </div><!-- media -->
</div><!-- pageheader -->