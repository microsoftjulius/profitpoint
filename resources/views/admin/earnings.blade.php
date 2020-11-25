<!DOCTYPE html>
<html lang="en">

    <link href="{{ asset('design/css/style.default.css')}}" rel="stylesheet">
    <link href="{{ asset('design/css/select2.css')}}" rel="stylesheet" />
    <link href="{{ asset('design/css/style.datatables.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
    <body>
        
        @include('layouts.header')
        <section>
            <div class="mainwrapper">
                @include('layouts.sidebar')
                <div class="mainpanel">
                    @include('layouts.breadcrumb')
                    <div class="contentpanel">
                        <div class="row">
                            <div class="panel panel-primary-head">
                                <div class="panel-heading">
                                    <h4 class="panel-title">{{ request()->route()->getName() }}</h4>
                                    <p>A table showing the Earnings {{ auth()->user()->name }} has made</p>
                                </div><!-- panel-heading -->
                                
                                <table id="basicTable" class="table table-striped table-bordered responsive">
                                    <thead class="">
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>Amount</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($logged_in_user_earnings as $earnings)
                                            <tr>
                                                <td>{{ md5(uniqid(rand(), true)) }}</td>
                                                @if(auth()->user()->currency == "Dollar")
                                                <td>{{ round($earnings->amount,1) }} $</td>
                                                @else
                                                <td>{{ number_format($earnings->amount * $dollar_rate) }} /=</td>
                                                @endif
                                                <td>{{ $earnings->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!-- panel -->
                            
                        </div><!-- row -->
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

        <script src="{{ asset('design/js/jquery-1.11.1.min.js')}}"></script>
        <script src="{{ asset('design/js/jquery-migrate-1.2.1.min.js')}}"></script>
        <script src="{{ asset('design/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('design/js/modernizr.min.js')}}"></script>
        <script src="{{ asset('design/js/pace.min.js')}}"></script>
        <script src="{{ asset('design/js/retina.min.js')}}"></script>
        <script src="{{ asset('design/js/jquery.cookies.js')}}"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('design/js/select2.min.js')}}"></script>

        <script src="{{ asset('design/js/custom.js')}}"></script>
        <script>
            jQuery(document).ready(function(){
                jQuery('#basicTable').DataTable({
                    responsive: true
                });
            });
            
        </script>

    </body>

<!-- Mirrored from themetrace.com/demo/chain/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Mar 2020 04:30:31 GMT -->
</html>
