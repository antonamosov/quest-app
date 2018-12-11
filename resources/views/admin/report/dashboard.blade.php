@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/report/dashboard">
                <h2> Dashboard<small></small>
                </h2>
            </a>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <style>
                .tile_count .tile_stats_count:before {
                    border-left: none;
                }
            </style>

            <div class="row tile_count">

                <div class="col-md-2 col-md-offset-4 tile_stats_count">
                    <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
                    <div class="count">{{ $statistic->totalUsers }}</div>
                    <p><span class="count_bottom"><i class="{{ $statistic->lastWeekUsersColor }}">{{ $statistic->lastWeekUsers }}% </i> From last Week</span></p>
                    <p><span class="count_bottom"><i class="{{ $statistic->lastMonthUsersColor }}">{{ $statistic->lastMonthUsers }}% </i> From last Month</span></p>
                </div>

                <div class="col-md-2 tile_stats_count">
                    <span class="count_top"><i class="fa fa-dollar"></i> Total Revenue</span>
                    <div class="count">{{ $statistic->totalRevenue }}</div>
                    <p><span class="count_bottom"><i class="{{ $statistic->lastWeekRevenueColor }}">{{ $statistic->lastWeekRevenue }}% </i> From last Week</span></p>
                    <p><span class="count_bottom"><i class="{{ $statistic->lastMonthRevenueColor }}">{{ $statistic->lastMonthRevenue }}% </i> From last Month</span></p>
                </div>

            </div>



            <form id="main_form" method="get" action="">

                <div style="padding-bottom:50px;" class="row">
                    <label style="float:right; margin-right: 10px;">Date from ... to</label>
                    <div class="col-md-4 col-md-offset-8">
                        <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span>September 15, 2016 - October 14, 2016</span> <b class="caret"></b>
                            <input onchange="sendForm(this.form)" type="hidden" id="from" name="day_from" value="{{ \Illuminate\Support\Facades\Input::get('day_from') }}">
                            <input onchange="sendForm(this.form)" type="hidden" id="to" name="day_to" value="{{ \Illuminate\Support\Facades\Input::get('day_to') }}">
                        </div>
                    </div>
                </div>

            </form>

            <script>
                function sendForm(form)
                {
                    form.submit();
                }
            </script>

            <script>
                $(document).ready(function() {
                    var cb = function(start, end, label) {
                        console.log(start.toISOString(), end.toISOString(), label);
                        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    };

                    var optionSet1 = {
                        startDate: moment().subtract(2, 'months'),
                        endDate: moment(),
                        minDate: '01/08/2016',
                        maxDate: '12/31/2025',
                        dateLimit: {
                            days: 60
                        },
                        showDropdowns: true,
                        showWeekNumbers: true,
                        timePicker: false,
                        timePickerIncrement: 1,
                        timePicker12Hour: true,
                        ranges: {
                            'Today': [moment(), moment()],
                            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month': [moment().startOf('month'), moment().endOf('month')],
                            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        opens: 'left',
                        buttonClasses: ['btn btn-default'],
                        applyClass: 'btn-small btn-primary',
                        cancelClass: 'btn-small',
                        format: 'MM/DD/YYYY',
                        separator: ' to ',
                        locale: {
                            applyLabel: 'Submit',
                            cancelLabel: 'Clear',
                            fromLabel: 'From',
                            toLabel: 'To',
                            customRangeLabel: 'Custom',
                            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                            firstDay: 1
                        }
                    };
                    $('#reportrange span').html('<?php echo $params->calendar->from; ?>' + ' - ' + '<?php echo $params->calendar->to; ?>');
                    $('#reportrange').daterangepicker(optionSet1, cb);
                    $('#reportrange').on('show.daterangepicker', function() {
                        console.log("show event fired");
                    });
                    $('#reportrange').on('hide.daterangepicker', function() {
                        console.log("hide event fired");
                    });
                    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
                        console.log(" custom apply event fired, start/end dates are " + picker.startDate.format('YYYY-MM-DD 00:00:00') + " to " + picker.endDate.format('YYYY-MM-DD 23:59:59'));
                        $('#from').val(picker.startDate.format('YYYY-MM-DD 00:00:00'));
                        $('#to').val(picker.endDate.format('YYYY-MM-DD 23:59:59'));
                        sendForm($('#main_form'));
                    });
                    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
                        console.log("cancel event fired");
                    });
                    $('#options1').click(function() {
                        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
                    });
                    $('#options2').click(function() {
                        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
                    });
                    $('#destroy').click(function() {
                        $('#reportrange').data('daterangepicker').remove();
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    $('#single_cal1').daterangepicker({
                        singleDatePicker: true,
                        calender_style: "picker_1"
                    }, function(start, end, label) {
                        console.log(start.toISOString(), end.toISOString(), label);
                    });
                    $('#single_cal2').daterangepicker({
                        singleDatePicker: true,
                        calender_style: "picker_2"
                    }, function(start, end, label) {
                        console.log(start.toISOString(), end.toISOString(), label);
                    });
                    $('#single_cal3').daterangepicker({
                        singleDatePicker: true,
                        calender_style: "picker_3"
                    }, function(start, end, label) {
                        console.log(start.toISOString(), end.toISOString(), label);
                    });
                    $('#single_cal4').daterangepicker({
                        singleDatePicker: true,
                        calender_style: "picker_4"
                    }, function(start, end, label) {
                        console.log(start.toISOString(), end.toISOString(), label);
                    });
                });
            </script>


            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="placeholder33" style="height: 260px; display: none" class="demo-placeholder"></div>
                <div style="width: 100%;">
                    <div id="canvas_dahs" class="demo-placeholder">

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Flot -->
    <script src="/js/flot/jquery.flot.js"></script>
    <script src="/js/flot/jquery.flot.pie.js"></script>
    <script src="/js/flot/jquery.flot.time.js"></script>
    <script src="/js/flot/jquery.flot.stack.js"></script>
    <script src="/js/flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="/js/flot/jquery.flot.orderBars.js"></script>
    <script src="/js/flot/date.js"></script>
    <script src="/js/flot/jquery.flot.spline.js"></script>
    <script src="/js/flot/curvedLines.js"></script>





    <!-- Flot -->
    <script>
        $(document).ready(function() {

            var data1 = '<?php echo $users; ?>';
            var data2 = '<?php echo $revenues; ?>';
            var yInterval = '<?php echo $params->yInterval; ?>';

            data1 = JSON.parse(data1);
            data2 = JSON.parse(data2);

            $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
                { data: data1, label: " Total number of the users per period" },
                { data: data2, label: " Average revenue per period ($)", yaxis: 2 }
            ], {
                series: {
                    lines: {
                        show: false,
                        fill: true
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    points: {
                        radius: 0,
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    verticalLines: true,
                    hoverable: true,
                    clickable: true,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: '#000'
                },
                colors: ["rgba(38, 185, 154, 0.38)", "rgba(176, 30, 71, 1)"],
                xaxis: {
                    tickColor: "rgba(51, 51, 51, 0.06)",
                    mode: "time",
                    tickSize: JSON.parse(yInterval),
                    tickLength: 10,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Verdana, Arial',
                    axisLabelPadding: 10
                },
                xaxes: [ { position: "bottom" } ],
                yaxes: [ { position: "left", min: 0 }, { position: "right", min: 0 } ],
                yaxis: {
                    ticks: 8,
                    tickColor: "rgba(51, 51, 51, 0.06)"
                },
                tooltip: false
            });

            function gd(year, month, day) {
                return new Date(year, month - 1, day).getTime();
            }
        });
    </script>
    <!-- /Flot -->
@endsection