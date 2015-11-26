@extends('master')

@section('title', 'Product overview')

@section('content')

<div class="container-fluid">
    <h2 class="text-center">This week performance</h2>
    <h3 class="text-center">Sales vs Purchases</h3>
    <div class="col-md-6" id="chart_div" style="width: 100%; height: 500px;">

    </div>
    <h3 style="margin-top: 100px;" class="text-center">Expense vs Revenue vs Profit</h3>
    <div class="col-md-6 col-md-offset-3" id="columnchart_material" style="width: 50%; height: 500px;">

    </div>
</div>

<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['This week', 'Sales (units)', 'Purchases (units)'],
            ['Mon Nov 23',  1000,      400],
            ['Tue Nov 24',  1170,      460],
            ['Wed Nov 25',  660,       1120],
            ['Thu Nov 26',  1030,      540],
            ['Fri Nov 27',  1890,      0]
        ]);

        var options = {
            title: '',
            hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }


    google.load("visualization", "1.1", {packages:["bar"]});
    google.setOnLoadCallback(drawChart2);
    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Sales', 'Expenses', 'Profit'],
            ['2014', 1000, 400, 200],
            ['2015', 1170, 460, 250],
            ['2016', 660, 1120, 300],
            ['2017', 1030, 540, 350]
        ]);

        var options = {
            chart: {
                title: 'Company Performance',
                subtitle: 'Sales, Expenses, and Profit: Mon Nov 23 - Fri Nov 27'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, options);
    }
</script>
@endsection