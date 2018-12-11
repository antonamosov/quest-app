@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/report/tables?sort_type=route&pay_system=all"><h2> Report Tables <small></small></h2></a>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form id="main_form" method="get" action="">

            <div class="row">
                <div class="col-md-8">
                    <div class="dataTables_length" id="datatable_length">
                        <label>Show entries
                            <select onchange="sendForm(this.form)" id="datatable_length" name="datatable_length" aria-controls="datatable" class="form-control input-sm">
                                <option value="10">10</option>
                                <option  selected="selected" value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </label>
                    </div>
                </div>

                <label style="float:right; margin-right: 10px;">Date from ... to</label>
                <div class="col-md-4">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>September 15, 2016 - October 14, 2016</span> <b class="caret"></b>
                        <input onchange="sendForm(this.form)" type="hidden" id="from" name="day_from" value="{{ \Illuminate\Support\Facades\Input::get('day_from') }}">
                        <input onchange="sendForm(this.form)" type="hidden" id="to" name="day_to" value="{{ \Illuminate\Support\Facades\Input::get('day_to') }}">
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                <tr>

                        <th>#</th>

                        <th>
                            <select onchange="sendForm(this.form)" style="border:none;"  name="sort_type" id="sort_type">
                                @if($manager->hasRole('global'))
                                    <option value="partner">Partner</option>
                                @endif
                                <option value="category">Category</option>
                                <option value="route">Tour</option>
                            </select>
                        </th>

                        <th>
                            <select onchange="sendForm(this.form)" style="border:none;" name="pay_system" id="pay_system">
                                <option id="all" value="all">All</option>
                                <option id="paypal" value="paypal">PayPal</option>
                                <option id="'pin" value="pin">Pin</option>
                            </select>
                        </th>

                        <th>Commission</th>

                        <th>Total</th>


                </tr>
                </thead>

                <script>
                    function sendForm(form)
                    {
                        form.submit();
                    }

                    $(document).ready(function(){

                        var query = window.location.search.substring(1);
                        var vars = query.split("&");
                        for (var i=0;i<vars.length;i++) {
                            var pair = vars[i].split("=");
                            if(pair[0] == 'sort_type'){
                                document.querySelector('#sort_type [value="' + pair[1] + '"]').selected = true;
                            }
                            if(pair[0] == 'pay_system'){
                                document.querySelector('#pay_system [value="' + pair[1] + '"]').selected = true;
                            }
                            if(pair[0] == 'datatable_length'){
                                if( $('#datatable_length [value="' + pair[1] + '"]').length ){
                                    document.querySelector('#datatable_length [value="' + pair[1] + '"]').selected = true;
                                }
                            }
                        }
                    });
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

            <script>

            </script>
            <!-- /bootstrap-daterangepicker -->



            <tbody>

                <?php $nn = 1; ?>


                <style>
                    .td-left {
                        text-align: left;
                    }
                </style>

                @foreach($elements as $el)
                    <tr>
                        <th scope="row">{{ $nn++ }}</th>
                        <td>{{ $el->name }}</td>
                        <td>$ <span class="td-left">{{ $el->sum($params) }}</span></td>
                        <td>$ <span class="td-left">{{ $el->commission($params) }}</span></td>
                        <td>$ <span class="td-left">{{ $el->total($params) }}</span></td>
                    </tr>
                @endforeach

                <tr></tr>

                <tr>
                    <td>Total</td>
                    <td></td>
                    <td>$ <span class="td-left">{{ $el->total_sum($params) }}</span></td>
                    <td>$ <span class="td-left">{{ $el->total_commission($params) }}</span></td>
                    <td>$ <span class="td-left">{{ $el->total_total($params) }}</span></td>
                </tr>
                </tbody>
            </table>

            </form>

            <div class="row">

                <div style="float:left;">
                    <a href="{{ $params->url }}/csv?{{ $params->query_string }}&all_entries=1" class="btn btn-default buttons-csv buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons"><span>CSV</span></a>
                </div>

                <div style="float:right;">
                    {{ $elements->appends(request()->input())->links() }}
                </div>

            </div>


        </div>
    </div>
@endsection