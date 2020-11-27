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
                             @include('layouts.messages')
                            <div class="panel panel-primary-head">
                                <div class="panel-heading">
                                    <h4 class="panel-title">{{ request()->route()->getName() }}</h4>
                                    <p>A table showing the Users of the system</p>
                                </div><!-- panel-heading -->
                                
                                <table id="basicTable" class="table table-striped table-bordered responsive">
                                    <thead class="">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Date Of Joining</th>
                                            <th>Phone Number</th>
                                            <th>Country</th>
                                            <th>Currency Currently Used</th>
                                            <th>Options</th>
                                            <th>Withdraw Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($all_users as $users)
                                            <tr>
                                                <td>{{ $users->name }}</td>
                                                <td>{{ $users->email }}</td>
                                                <td>{{ $users->created_at }}</td>
                                                <td>{{ $users->phone_number }}</td>
                                                <td>{{ $users->country }}</td>
                                                <td>
                                                    @if($users->currency == '/=')
                                                        {{ "UGX" }}
                                                    @else
                                                        {{ $users->currency }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="/view-user-profile/{{ $users->id }}"><button class="btn btn-sm btn-primary">view user</button></a>
                                                    @if($users->status == "active")
                                                        <a href="/suspend-user/{{ $users->id }}"><button class="btn btn-sm btn-warning">Suspend user</button></a>
                                                    @else
                                                        <a href="/activate-user/{{ $users->id }}"><button class="btn btn-sm btn-success">Activate user</button></a>
                                                    @endif
                                                </td>
                                                @if($users->withdraw_status == 'allowed')
                                                <td>
                                                    <a href="/block-user-from-withdrawing/{{ $users->id }}"><button class="btn btn-sm btn-primary">Block</button></a>
                                                </td>
                                                @else
                                                <td>
                                                    <a href="/activate-user-to-withdrawing/{{ $users->id }}"><button class="btn btn-sm btn-success">Activate</button></a>
                                                </td>
                                                @endif
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
