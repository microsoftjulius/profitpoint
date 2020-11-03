<!DOCTYPE html>
<html lang="en">
    <link href="{{ asset('/design/css/style.default.css')}}" rel="stylesheet">
    <link href="{{ asset('/design/css/select2.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <style> 
        .qr-code { 
        max-width: 200px; 
        margin: 10px; 
        } 
    </style>
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
                                        <form method="get" id="basicWizard" class="panel-wizard" action="/make-investment">
                                            <ul class="nav nav-justified nav-wizard">
                                                <li><a href="#tab1" data-toggle="tab"> Mobile Money </a></li>
                                                <li><a href="#tab2" data-toggle="tab"> Bitcoin </a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane" id="tab1">
                                                    <div class="form-group">
                                                        <label class="col-sm-4">Amount</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" name="amount" class="form-control" value="{{ old('amount') }}"/>
                                                        </div>
                                                    </div>
                                                    <!-- form-group -->
                                                    <div class="form-group">
                                                        <label class="col-sm-4">Phone Number</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}"/>
                                                        </div>
                                                    </div>
                                                    <!-- form-group -->
                                                    <div class="row">
                                                        <div class="col-lg-4"></div>
                                                        <div class="col-lg-4">
                                                            <button class="btn btn-sm btn-primary">Invest</button>
                                                        </div>
                                                        <div class="col-lg-4"></div>
                                                    </div>
                                                </div>
                                                <!-- tab-pane -->
                                                <div class="tab-pane" id="tab2">
                                                    <div class="form-group">
                                                        <label class="col-sm-4">Note:</label>
                                                        <div class="col-sm-5">
                                                            Ensure that you send Bitcoin to the right address.
                                                            Kindly note that sending Bitcoin to a wrong address is irreversible.
                                                        </div>
                                                    </div>
                                                    <!-- form-group -->
                                                    <div class="row">
                                                        <div class="col-lg-4"></div>
                                                        <div class="col-lg-4">
                                                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#exampleModal">I Understand</button>
                                                        </div>
                                                        <div class="col-lg-4"></div>
                                                        <input type="radio" name="type" value="bitcoin" hidden>
                                                    </div>
                                                </div>
                                                <!-- tab-pane -->
                                            </div>
                                            <!-- tab-content -->
                                            <ul class="list-unstyled wizard">
                                            </ul>
                                        </form>
                                        <!-- #basicWizard -->
                                    </div>
                                    <!-- col-md-6 -->
                                    <div class="col-lg-3"></div>
                                </div>
                                <!-- row -->
                            </div>
                            <!-- contentpanel -->
                        </div>
                        <!-- row -->
                    </div>
                    <!-- contentpanel -->
                </div>
                <!-- mainpanel -->
            </div>
            <!-- mainwrapper -->
        </section>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="text-center">
                                <!-- Get a Placeholder image initially, 
                                    this will change according to the 
                                    data entered later -->
                                <img src="https://chart.googleapis.com/chart?cht=qr&chl={{ $coinbase_address }}&chs=160x160&chld=L|0" class="qr-code img-thumbnail img-responsive" /> 
                            </div>
                            <br>
                            <div class="row form-horizontal">
                                <div class="col-lg-12">
                                    <div class="col-lg-4 text-right">
                                        Address:
                                    </div>
                                    <div class="col-lg-5">
                                        {{ $coinbase_address }}
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-lg-12">
                                <div class="col-lg-4 text-right">
                                    Currency:
                                </div>
                                <div class="col-lg-5">
                                    BTC Wallet
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script> 
            // Function to HTML encode the text 
            // This creates a new hidden element, 
            // inserts the given text into it  
            // and outputs it out as HTML 
            function htmlEncode(value) { 
              return $('<div/>').text(value) 
                .html(); 
            } 
            
            $(function () { 
            
              // Specify an onclick function 
              // for the generate button 
              $('#generate').click(function () { 
            
                // Generate the link that would be 
                // used to generate the QR Code 
                // with the given data  
                let finalURL = 
            'https://chart.googleapis.com/chart?cht=qr&chl=' + 
                htmlEncode($('#content').val()) + 
                '&chs=160x160&chld=L|0' 
            
                // Replace the src of the image with 
                // the QR code image 
                $('.qr-code').attr('src', finalURL); 
              }); 
            }); 
        </script> 
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