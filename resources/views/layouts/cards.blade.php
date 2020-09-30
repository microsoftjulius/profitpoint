
<div class="row row-stat">
    @if(auth()->user()->role_id == 2)
    <div class="col-md-3">
    @else
    <div class="col-md-4">
    @endif
        <div class="panel panel-primary noborder">
            <div class="panel-heading noborder">
                <div class="panel-icon"><i class="fa fa-bank"></i></div>
                <div class="media-body">
                    <h5 class="md-title nomargin">Account Balance</h5>
                    @if(auth()->user()->role_id == 2)
                        <h1 class="mt5">{{ number_format($user_total_balance) }}{{ auth()->user()->currency }}</h1>
                    @else
                        <h1 class="mt5">{{ number_format($total_account_balance_to_admin) }}{{ auth()->user()->currency }}</h1>
                    @endif
                </div><!-- media-body -->
                <hr>
                @if(auth()->user()->role_id == 2)
                <div class="clearfix mt20">
                    <div class="pull-left">
                        <h5 class="md-title nomargin">Today</h5>
                        <h4 class="nomargin">{{ number_format($todays_balance) }}{{ auth()->user()->currency }}</h4>
                    </div>
                    <div class="pull-right">
                        <h5 class="md-title nomargin">This Month</h5>
                        <h4 class="nomargin">{{ number_format($months_balance) }}{{ auth()->user()->currency }}</h4>
                    </div>
                </div>
                @endif
            </div><!-- panel-body -->
        </div><!-- panel -->
    </div><!-- col-md-4 -->
    @if(auth()->user()->role_id == 2)
    <div class="col-md-3">
    @else
    <div class="col-md-4">
    @endif
        <div class="panel panel-warning-alt noborder">
            <div class="panel-heading noborder">
                <div class="panel-icon"><i class="fa fa-upload"></i></div>
                <div class="media-body">
                    <h5 class="md-title nomargin">Investments</h5>
                    @if(auth()->user()->role_id == 2)
                        <h1 class="mt5">{{ number_format($user_total_investments) }}{{ auth()->user()->currency }}</h1>
                    @else
                        <h1 class="mt5">{{ number_format($total_investments_to_admin) }}{{ auth()->user()->currency }}</h1>
                    @endif
                </div><!-- media-body -->
                <hr>
                @if(auth()->user()->role_id == 2)
                <div class="clearfix mt20">
                    <div class="pull-left">
                        <h5 class="md-title nomargin">Today</h5>
                        <h4 class="nomargin">{{ number_format($today_investment) }}{{ auth()->user()->currency }}</h4>
                    </div>
                    <div class="pull-right">
                        <h5 class="md-title nomargin">This Months</h5>
                        <h4 class="nomargin">{{ number_format($monthly_investment) }}{{ auth()->user()->currency }}</h4>
                    </div>
                </div>
                @endif
            </div><!-- panel-body -->
        </div><!-- panel -->
    </div><!-- col-md-4 -->
    
    @if(auth()->user()->role_id == 2)
    <div class="col-md-3">
    @else
    <div class="col-md-4">
    @endif
        <div class="panel panel-success-alt noborder">
            <div class="panel-heading noborder">
                <div class="panel-icon"><i class="fa fa-download"></i></div>
                <div class="media-body">
                    <h5 class="md-title nomargin">Withdraws</h5>
                    @if(auth()->user()->role_id == 2)
                        <h1 class="mt5">{{ number_format($user_total_withdraws) }}{{ auth()->user()->currency }}</h1>
                    @else
                        <h1 class="mt5">{{ number_format($total_withdraws) }}{{ auth()->user()->currency }}</h1>
                    @endif
                </div><!-- media-body -->
                <hr>
                @if(auth()->user()->role_id == 2)
                <div class="clearfix mt20">
                    <div class="pull-left">
                        <h5 class="md-title nomargin">Today</h5>
                        <h4 class="nomargin">{{ number_format($todays_withdraws) }}{{ auth()->user()->currency }}</h4>
                    </div>
                    <div class="pull-right">
                        <h5 class="md-title nomargin">This Months</h5>
                        <h4 class="nomargin">{{ number_format($months_withdraws) }}{{ auth()->user()->currency }}</h4>
                    </div>
                </div>
                @endif
            </div><!-- panel-body -->
        </div><!-- panel -->
    </div><!-- col-md-4 -->
    @if(auth()->user()->role_id == 2)
    <div class="col-md-3">
        <div class="panel panel-danger-alt noborder">
            <div class="panel-heading noborder">
                <div class="panel-icon"><i class="fa fa-gift"></i></div>
                <div class="media-body">
                    <h5 class="md-title nomargin">Total Earnings</h5>
                    <h1 class="mt5">{{ number_format($total_earnings) }}{{ auth()->user()->currency }}</h1>
                </div><!-- media-body -->
                <hr>
                <div class="clearfix mt20">
                    <div class="pull-left">
                        <h5 class="md-title nomargin">Today</h5>
                        <h4 class="nomargin">{{ number_format($todays_earnings) }}{{ auth()->user()->currency }}</h4>
                    </div>
                    <div class="pull-right">
                        <h5 class="md-title nomargin">This Months</h5>
                        <h4 class="nomargin">{{ number_format($this_months_earnings) }}{{ auth()->user()->currency }}</h4>
                    </div>
                </div>
                
            </div><!-- panel-body -->
        </div><!-- panel -->
    </div><!-- col-md-4 -->
    @endif
</div><!-- row -->
