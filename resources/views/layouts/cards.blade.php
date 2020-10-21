
<div class="row row-stat">
    @if(auth()->user()->role_id == 2)
    <div class="col-md-3">
    @else
    <div class="col-md-4">
    @endif
        <div class="panel panel-primary noborder">
            <div class="panel-heading noborder">
                <div class="media-body">
                    <h5 class="md-title nomargin">Account Balance</h5>
                    @if(auth()->user()->role_id == 2)
                        <h1 class="mt5">{{ number_format(round($user_total_investments + $total_earnings),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h1>
                    @else
                        <h1 class="mt5">{{ number_format($total_account_balance_to_admin) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h1>
                    @endif
                </div><!-- media-body -->
                <hr>
                @if(auth()->user()->role_id == 2)
                <div class="clearfix mt20">
                    <div class="pull-left">
                        <h5 class="md-title nomargin">Today</h5>
                        <h4 class="nomargin">{{ number_format(round($today_investment + $todays_earnings),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h4>
                    </div>
                    <div class="pull-right">
                        <h5 class="md-title nomargin">This Month</h5>
                        <h4 class="nomargin">{{ number_format(round($this_months_earnings + $monthly_investment),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h4>
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
                <div class="media-body">
                    <h5 class="md-title nomargin">Investments</h5>
                    @if(auth()->user()->role_id == 2)
                        <h1 class="mt5">{{ number_format(round($user_total_investments),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h1>
                    @else
                        <h1 class="mt5">{{ number_format(round($total_investments_to_admin),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h1>
                    @endif
                </div><!-- media-body -->
                <hr>
                @if(auth()->user()->role_id == 2)
                <div class="clearfix mt20">
                    <div class="pull-left">
                        <h5 class="md-title nomargin">Today</h5>
                        <h4 class="nomargin">{{ number_format(round($today_investment),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h4>
                    </div>
                    <div class="pull-right">
                        <h5 class="md-title nomargin">This Months</h5>
                        <h4 class="nomargin">{{ number_format(round($monthly_investment),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h4>
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
                <div class="media-body">
                    <h5 class="md-title nomargin">Withdraws</h5>
                    @if(auth()->user()->role_id == 2)
                        <h1 class="mt5">{{ number_format(round($user_total_withdraws),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h1>
                    @else
                        <h1 class="mt5">{{ number_format(round($total_withdraws),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h1>
                    @endif
                </div><!-- media-body -->
                <hr>
                @if(auth()->user()->role_id == 2)
                <div class="clearfix mt20">
                    <div class="pull-left">
                        <h5 class="md-title nomargin">Today</h5>
                        <h4 class="nomargin">{{ number_format(round($todays_withdraws),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h4>
                    </div>
                    <div class="pull-right">
                        <h5 class="md-title nomargin">This Months</h5>
                        <h4 class="nomargin">{{ number_format(round($months_withdraws),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h4>
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
                    <h1 class="mt5">{{ number_format(round($total_earnings - $user_total_withdraws),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h1>
                </div><!-- media-body -->
                <hr>
                <div class="clearfix mt20">
                    <div class="pull-left">
                        <h5 class="md-title nomargin">Today</h5>
                        <h4 class="nomargin">{{ number_format(round($todays_earnings),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h4>
                    </div>
                    <div class="pull-right">
                        <h5 class="md-title nomargin">This Months</h5>
                        <h4 class="nomargin">{{ number_format(round($this_months_earnings),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h4>
                    </div>
                </div>
                
            </div><!-- panel-body -->
        </div><!-- panel -->
    </div><!-- col-md-4 -->
    @else
        <div class="col-md-4">
        <div class="panel panel-danger-alt noborder">
            <div class="panel-heading noborder">
                <div class="panel-icon"><i class="fa fa-gift"></i></div>
                <div class="media-body">
                    <h5 class="md-title nomargin">Total Earnings</h5>
                    <h1 class="mt5">{{ number_format(round($over_all_earnings - $total_withdraws),2) }}@if(auth()->user()->currency == 'Dollar')$ @else {{ auth()->user()->currency }} @endif</h1>
                </div><!-- media-body -->
                <hr>
            </div><!-- panel-body -->
        </div><!-- panel -->
    </div><!-- col-md-4 -->
    @endif
</div><!-- row -->
