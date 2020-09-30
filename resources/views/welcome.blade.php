<!DOCTYPE html>
<html lang="en">
    
@include('layouts.head')
<!-- Material Design Bootstrap -->
@if(auth()->user()->role_id == 2)
<link rel="stylesheet" href="{{ asset('design/charts/css/mdb.min.css')}}">
@endif
<body>
    @include('layouts.header')
    <section>
        <div class="mainwrapper">
            @include('layouts.sidebar')
            <div class="mainpanel">
                @include('layouts.breadcrumb')
                <div class="contentpanel">
                    @include('layouts.cards')
                    <div class="row">
                        @if(auth()->user()->role_id == 2)
                        <canvas id="lineChart"></canvas>
                        @else
                        <div class="contentpanel">
                            <div class="row">
                                <div class="panel panel-primary-head">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">{{ request()->route()->getName() }}</h4>
                                        <p>A table showing the transactions that have been made</p>
                                    </div><!-- panel-heading -->
                                    
                                    <table id="basicTable" class="table table-striped table-bordered responsive">
                                        <thead class="">
                                            <tr>
                                                <th>Phone Number</th>
                                                <th>Amount</th>
                                                <th>Time</th>
                                                {{-- <th>Options</th> --}}
                                            </tr>
                                        </thead>
    
                                        <tbody>
                                            @foreach ($transactions as $transaction_made)
                                                @foreach ($transaction_made as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->phone_number }}</td>
                                                    <td>{{ $transaction->amount }} /=</td>
                                                    <td>{{ $transaction->created_at }}</td>
                                                    {{-- <td>
                                                        <button class="btn btn-sm btn-primary">view</button>
                                                    </td> --}}
                                                </tr>
                                                @endforeach
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div><!-- panel -->
                                
                            </div><!-- row -->
                        </div><!-- contentpanel -->
                        
                        @endif
                    </div><!-- row -->
                </div><!-- contentpanel -->
            </div><!-- mainpanel -->
        </div><!-- mainwrapper -->
    </section>
    @include('layouts.javascript')
</body>

<script type="text/javascript" src="{{ asset('design/charts/js/popper.min.js')}}"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="{{ asset('design/charts/js/mdb.min.js')}}"></script>
<script>
    var ctxL = document.getElementById("lineChart").getContext('2d');
    var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        datasets: [{
            label: "A graph showing the number of earnings made per user in a current week",
                data: [65, 59, 80, 81, 56, 55, 40],
            backgroundColor: [
                'rgba(105, 0, 132, .2)',
            ],
            borderColor: [
                'rgba(200, 99, 132, .7)',
            ],
        borderWidth: 2
        },]
    },
    options: {
        responsive: true
    }
    });
</script>
</html>
