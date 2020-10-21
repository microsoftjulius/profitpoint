<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from themetrace.com/demo/chain/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Mar 2020 04:30:31 GMT -->
@include('layouts.head')

    <body>
        
        @include('layouts.header')
        <section>
            <div class="mainwrapper">
                @include('layouts.sidebar')
                <div class="mainpanel">
                    @include('layouts.breadcrumb')
                    <div class="contentpanel">
                        <div class="row">
                            <div class="contentpanel">
                        
                                <div class="row">
                                    @include('layouts.messages')
                                    <div class="col-sm-4 col-md-3">
                                        <div class="text-center">
                                            <img src="{{ asset('profile_pics/'.auth()->user()->profile_picture) }}" class="img-circle img-offline img-responsive img-profile" alt="" style="width:100px; height: 100px;"/>
                                            <h4 class="profile-name mb5">{{ auth()->user()->name }}</h4>
                                            <div><i class="fa fa-envelope"></i> {{ auth()->user()->email }}</div>
                                        
                                            <div class="mb20"></div>
                                            <form action="/update-user-currency/{{auth()->user()->id}}" method="get">
                                                <select class="form-control" name="currency">
                                                    <option></option>
                                                    <option value="/=">UGX</option>
                                                    <option value="Dollar">USD</option>
                                                </select><br>
                                                <button type="submit" class="btn btn-sm btn-primary">Convert</button>
                                            </form>
                                            <!--<div class="btn-group">-->
                                            <!--    <button class="btn btn-primary btn-bordered">Referrals</button>-->
                                            <!--    <button class="btn btn-primary btn-bordered">80</button>-->
                                            <!--</div>-->
                                        </div><!-- text-center -->
                                        
                                        <br />
                                        
                                    </div><!-- col-sm-4 col-md-3 -->
                                    
                                    <div class="col-sm-8 col-md-9">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-line">
                                            <li class="active"><a href="#activities" data-toggle="tab"><strong>Profile</strong></a></li>
                                            <li><a href="#followers" data-toggle="tab"><strong>Referrals</strong></a></li>
                                        </ul>
                                    
                                        <!-- Tab panes -->
                                        <div class="tab-content nopadding noborder">
                                            <div class="tab-pane active" id="activities">
                                                <div class="activity-list">  
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <div class="col-lg-6">
                                                                <label for="name">Name</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="email">Email</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="phone_number">Phone Number</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ auth()->user()->phone_number }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="country">Country</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ auth()->user()->country }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="earnings">Total Earnings</label>
                                                                @if(auth()->user()->currency == "Dollar")
                                                                    <input type="text" name="" id="" class="form-control"  value="{{ $total_earnings/3710 }}$" readonly>
                                                                @else
                                                                    <input type="text" name="" id="" class="form-control"  value="{{ $total_earnings }} {{ auth()->user()->currency }}" readonly>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="withdraws">Withdraws</label>
                                                                @if(auth()->user()->currency == "Dollar")
                                                                    <input type="text" name="" id="" class="form-control" value="{{ $user_total_withdraws/3710 }}$" readonly>
                                                                @else
                                                                    <input type="text" name="" id="" class="form-control" value="{{ $user_total_withdraws }} {{ auth()->user()->currency }}" readonly>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="account_balance">Account Balance</label>
                                                                @if(auth()->user()->currency == "Dollar")
                                                                    <input type="text" name="" id="" class="form-control" value="{{ $user_total_balance/3710 }}$" readonly>
                                                                @else
                                                                    <input type="text" name="" id="" class="form-control" value="{{ $user_total_balance }} {{ auth()->user()->currency }}" readonly>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="account_balance">Total Investments</label>
                                                                @if(auth()->user()->currency == "Dollar")
                                                                    <input type="text" name="" id="" class="form-control" value="{{ $user_total_investments/3710 }}$" readonly>
                                                                @else
                                                                    <input type="text" name="" id="" class="form-control" value="{{ $user_total_investments }} {{ auth()->user()->currency }}" readonly>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="account_balance">Referral Link</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ asset('/sponsor') }}/{{ auth()->user()->email }}" readonly>
                                                            </div>
                                                            <form action="/update-profile-picture" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="col-lg-6">
                                                                    <label for="account_balance">Update Profile Picture</label>
                                                                    <input type="file" name="profile_pic" id="" class="form-control" accept="image/*">
                                                                </div>
                                                                <div class="col-lg-6"><br>
                                                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm" type="button">Change Password</button>
                                                                </div>
                                                                <div class="col-lg-6"></div>
                                                                <div class="col-lg-12"><br>
                                                                    <button class="btn btn-sm btn-success" type="submit">Update Profile Picture</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div><!-- media -->
                                                </div>
                                            </div><!-- tab-pane -->
                                            
                                            <div class="tab-pane" id="followers">
                                                <div class="follower-list">
                                                    <div class="media">
                                                        <a class="pull-left" href="#">
                                                            <img class="media-object img-circle" src="holder.js/100x100.html" alt="" />
                                                        </a>
                                                        <div class="media-body">
                                                            <div class="panel panel-primary-head">
                                                                <div class="panel-heading">
                                                                    <p>A table showing the referrals that joined using the link generated by {{ auth()->user()->name }}</p>
                                                                </div><!-- panel-heading -->
                                                                
                                                                <table id="basicTable" class="table table-striped table-bordered responsive">
                                                                    <thead class="">
                                                                        <tr>
                                                                            <th>Referral Name</th>
                                                                            <th>Bonus</th>
                                                                            <th>Time</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </thead>
                                
                                                                    <tbody>
                                                                        @foreach($users_referrals as $referrals)
                                                                        <tr>
                                                                            <td>{{$referrals->name}}</td>
                                                                            <td>{{$referrals->amount}}</td>
                                                                            <td>{{$referrals->created_at}}</td>
                                                                            <td>{{$referrals->status}}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div><!-- panel -->                                
                                                        </div><!-- media-body -->
                                                    </div><!-- media -->
                                    </div><!-- tab-content -->
                                    </div><!-- col-sm-9 -->
                                </div><!-- row -->  
                            </div><!-- contentpanel -->
                        </div><!-- row -->
                    </div><!-- contentpanel -->
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

        @include('layouts.javascript')
        <form action="/update-user-password" method="get">
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                            <h4 class="modal-title">Change Password</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" name="current_password" id="" class="form-control">
                                </div>
                                <div class="col-lg-12">
                                    <label for="new_password">New Password</label>
                                    <input type="password" name="npassword" id="" class="form-control">
                                </div>
                                <div class="col-lg-12">
                                    <label for="confirm_new_password">Confirm Password</label>
                                    <input type="password" name="cpassword" id="" class="form-control">
                                </div>
                                <div class="col-lg-12"><br>
                                    <button class="btn btn-sm btn-primary" type="submit">Change Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>

<!-- Mirrored from themetrace.com/demo/chain/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Mar 2020 04:30:31 GMT -->
</html>
