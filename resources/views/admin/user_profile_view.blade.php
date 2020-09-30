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
                        
                                @foreach ($user_profile as $profile)
                                <div class="row">
                                    @include('layouts.messages')
                                    <div class="col-sm-4 col-md-3">
                                        <div class="text-center">
                                            <img src="{{ asset('profile_pics/'.$profile->profile_picture) }}" class="img-circle img-offline img-responsive img-profile" alt="" style="width:100px; height: 100px;"/>
                                            <h4 class="profile-name mb5">{{ $profile->name }}</h4>
                                            <div><i class="fa fa-envelope"></i> {{ $profile->email }}</div>
                                        
                                            <div class="mb20"></div>
                                        
                                            <div class="btn-group">
                                                <button class="btn btn-primary btn-bordered">Referrals</button>
                                                <button class="btn btn-primary btn-bordered">80</button>
                                            </div>
                                        </div><!-- text-center -->
                                        
                                        <br />
                                        <h5 class="md-title">Referral Link</h5>
                                        <ul class="list-unstyled social-list">
                                            <a href="#">{{ asset('') }}{{ $profile->email }}</a></li>
                                        </ul>
                                    </div><!-- col-sm-4 col-md-3 -->
                                    
                                    <div class="col-sm-8 col-md-9">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-line">
                                            <li class="active"><a href="#activities" data-toggle="tab"><strong>Profile</strong></a></li>
                                        </ul>
                                    
                                        <!-- Tab panes -->
                                        <div class="tab-content nopadding noborder">
                                            <div class="tab-pane active" id="activities">
                                                <div class="activity-list">  
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <div class="col-lg-6">
                                                                <label for="name">Name</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ $profile->name }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="email">Email</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ $profile->email }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="phone_number">Phone Number</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ $profile->phone_number }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="country">Country</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ $profile->country }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="earnings">Total Earnings</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ $total_earnings }} {{ $profile->currency }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="withdraws">Withdraws</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ $user_total_withdraws }} {{ $profile->currency }}" readonly>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="account_balance">Total Investments</label>
                                                                <input type="text" name="" id="" class="form-control" value="{{ $user_total_investments }} {{ $profile->currency }}" readonly>
                                                            </div>
                                                            <div class="row"></div>
                                                            <div class="row">
                                                                <div class="col-lg-6"><br>
                                                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm" type="button">Credit Account</button>
                                                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-deb" type="button">Debit Account</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- media -->
                                                </div>
                                            </div><!-- tab-pane -->
                                </div><!-- row -->  
                            </div><!-- contentpanel -->
                        </div><!-- row -->
                            <form action="/credit-user-account/{{ $profile->id }}" method="get">
                                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                                                <h4 class="modal-title">Credit Account</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label for="current_password">Amount</label>
                                                        <input type="text" name="amount" id="" class="form-control">
                                                    </div>
                                                    <div class="col-lg-12"><br>
                                                        <button class="btn btn-sm btn-primary" type="submit">Credit Account</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form action="/debit-user-account/{{ $profile->id }}" method="get">
                                <div class="modal fade bs-example-modal-deb" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                                                <h4 class="modal-title">Debit Account</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label for="current_password">Amount</label>
                                                        <input type="number" name="amount" id="" class="form-control">
                                                    </div>
                                                    <div class="col-lg-12"><br>
                                                        <button class="btn btn-sm btn-primary" type="submit">Debit Account</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div><!-- contentpanel -->
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

        @include('layouts.javascript')
    </body>
</html>
