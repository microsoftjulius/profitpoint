<!DOCTYPE html>
<html lang="en">
<link href="{{ asset('/design/css/style.default.css')}}" rel="stylesheet">
<link href="{{ asset('/design/css/select2.css')}}" rel="stylesheet" />

    <body>
        
        @include('layouts.header')
        <section>
            <div class="mainwrapper">
                @include('layouts.sidebar')
                <div class="mainpanel">
                    @include('layouts.breadcrumb')
                    <div class="contentpanel">
                        <div class="row">
                            <div class="contentpanel contentpanel-wizard">
                        
                                <div class="row">
                                    @include('layouts.messages')
                                    <div class="col-lg-3"></div>
                                    <div class="col-md-6">
                                        <!-- BASIC WIZARD -->
                                        <form method="get" id="basicWizard" class="panel-wizard" action="/withdraw-to-bitcoin-address">
                                            <ul class="nav nav-justified nav-wizard">
                                                <li><a href="#tab1" data-toggle="tab"> Bitcoin Withdraw</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane" id="tab1">
                                                    <div class="form-group">
                                                        <label class="col-sm-4">Note:</label>
                                                        <div class="col-sm-5">
                                                            Ensure that you send Bitcoin to the right address.
                                                            Kindly note that sending Bitcoin to a wrong address is irreversible.
                                                            
                                                        </div>
                                                    </div><!-- form-group -->
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label for="amount">Amount (in USD)</label>
                                                            <input type="number" name="amount" id="amount" class="form-control" autocomplete="off" required>
                                                        </div><br>
                                                        <div class="col-lg-12">
                                                            <label for="address">Address</label>
                                                            <input type="text" placeholder="Bitcoin Address" name="address" id="address" class="form-control" autocomplete="off" required>
                                                        </div><br>
                                                        <div class="col-lg-12">
                                                            <label for="password">Confirm Password</label>
                                                            <input type="password" placeholder="confirm your password" name="password" id="password" class="form-control" autocomplete="off" required>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="col-lg-4"></div>
                                                            <div class="col-lg-4"><br>
                                                                <button class="btn btn-sm btn-primary" type="submit">Authorize</button>                                                          </div>
                                                            <div class="col-lg-4"></div>
                                                        </div>
                                                    </div>
                                                </div><!-- tab-pane -->
                                            </div><!-- tab-content -->
                        
                                            <ul class="list-unstyled wizard">
                                            </ul>
                                        </form><!-- #basicWizard -->
                                        @if(auth()->user()->role_id == 1)
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-4">
                                                    @if(auth()->user()->getBTCWithdrawStatus() == 'true')
                                                        <a href="/admin-disable-btc-withdraws"><button class="btn btn-danger btn-sm">Block withdraws via coinbase</button></a>
                                                    @else
                                                        <a href='/admin-activate-btc-withdraws'><button class="btn btn-success btn-sm">Activate withdraws via coinbase</button></a>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4"></div>
                                            </div>
                                        </div>
                                        @endif
                                    </div><!-- col-md-6 -->

                                    <div class="col-lg-3"></div>
                                </div><!-- row -->
                            </div><!-- contentpanel -->
                            
                        </div><!-- row -->
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

        
        <script src="{{ asset('design/js/jquery-1.11.1.min.js')}}"></script>
        <script src="{{ asset('design/js/jquery-migrate-1.2.1.min.js')}}"></script>
        <script src="{{ asset('design/js/jquery-ui-1.10.3.min.js')}}"></script>
        <script src="{{ asset('design/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('design/js/modernizr.min.js')}}"></script>
        <script src="{{ asset('design/js/pace.min.js')}}"></script>
        <script src="{{ asset('design/js/retina.min.js')}}"></script>
        <script src="{{ asset('design/js/jquery.cookies.js')}}"></script>
        
        <script src="{{ asset('design/js/bootstrap-wizard.min.js')}}"></script>
        <script src="{{ asset('design/js/jquery.validate.min.js')}}"></script>
        <script src="{{ asset('design/js/select2.min.js')}}"></script>

        <script src="{{ asset('design/js/custom.js')}}"></script>
        <script>
            jQuery(document).ready(function() {
                
                // This will empty first option in select to enable placeholder
                jQuery('select option:first-child').text('');
                
                // Select2
                jQuery("select").select2({
                    minimumResultsForSearch: -1
                });
                
                // Basic Wizard
                jQuery('#basicWizard').bootstrapWizard({
                    onTabShow: function(tab, navigation, index) {
                        tab.prevAll().addClass('done');
                        tab.nextAll().removeClass('done');
                        tab.removeClass('done');
                        
                        var $total = navigation.find('li').length;
                        var $current = index + 1;
                        
                        if($current >= $total) {
                            $('#basicWizard').find('.wizard .next').addClass('hide');
                            $('#basicWizard').find('.wizard .finish').removeClass('hide');
                        } else {
                            $('#basicWizard').find('.wizard .next').removeClass('hide');
                            $('#basicWizard').find('.wizard .finish').addClass('hide');
                        }
                    }
                });
                
                // Progress Wizard
                jQuery('#progressWizard').bootstrapWizard({
                    onTabShow: function(tab, navigation, index) {
                        tab.prevAll().addClass('done');
                        tab.nextAll().removeClass('done');
                        tab.removeClass('done');
                        
                        var $total = navigation.find('li').length;
                        var $current = index + 1;
                        
                        if($current >= $total) {
                            $('#progressWizard').find('.wizard .next').addClass('hide');
                            $('#progressWizard').find('.wizard .finish').removeClass('hide');
                        } else {
                            $('#progressWizard').find('.wizard .next').removeClass('hide');
                            $('#progressWizard').find('.wizard .finish').addClass('hide');
                        }
                        
                        var $percent = ($current/$total) * 100;
                        $('#progressWizard').find('.progress-bar').css('width', $percent+'%');
                    }
                });
                
                // Wizard With Disabled Tab Click
                jQuery('#tabWizard').bootstrapWizard({
                    onTabShow: function(tab, navigation, index) {
                        tab.prevAll().addClass('done');
                        tab.nextAll().removeClass('done');
                        tab.removeClass('done');
                        
                        var $total = navigation.find('li').length;
                        var $current = index + 1;
                        
                        if($current >= $total) {
                            $('#tabWizard').find('.wizard .next').addClass('hide');
                            $('#tabWizard').find('.wizard .finish').removeClass('hide');
                        } else {
                            $('#tabWizard').find('.wizard .next').removeClass('hide');
                            $('#tabWizard').find('.wizard .finish').addClass('hide');
                        }
                    },
                    onTabClick: function(tab, navigation, index) {
                        return false;
                    }
                });
                
                // Wizard With Form Validation
                jQuery('#valWizard').bootstrapWizard({
                    onTabShow: function(tab, navigation, index) {
                        tab.prevAll().addClass('done');
                        tab.nextAll().removeClass('done');
                        tab.removeClass('done');
                        
                        var $total = navigation.find('li').length;
                        var $current = index + 1;
                        
                        if($current >= $total) {
                            $('#valWizard').find('.wizard .next').addClass('hide');
                            $('#valWizard').find('.wizard .finish').removeClass('hide');
                        } else {
                            $('#valWizard').find('.wizard .next').removeClass('hide');
                            $('#valWizard').find('.wizard .finish').addClass('hide');
                        }
                    },
                    onTabClick: function(tab, navigation, index) {
                        return false;
                    },
                    onNext: function(tab, navigation, index) {
                        var $valid = jQuery('#valWizard').valid();
                        if (!$valid) {
                            $validator.focusInvalid();
                            return false;
                        }
                    }
                });
                
                // Wizard With Form Validation
                var $validator = jQuery("#valWizard").validate({
                    highlight: function(element) {
                        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                    },
                    success: function(element) {
                        jQuery(element).closest('.form-group').removeClass('has-error');
                    }
                });
            });
        </script>
    </body>

<!-- Mirrored from themetrace.com/demo/chain/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Mar 2020 04:30:31 GMT -->
</html>
