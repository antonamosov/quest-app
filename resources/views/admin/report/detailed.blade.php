@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/report/detailed?sort_type=route&pay_system=all"><h2> Detailed Table <small></small></h2></a>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form id="main_form" method="get" action="">

                <div class="row">
                    <div class="col-md-3">
                        <div class="dataTables_length" id="datatable_length">
                            <label>Show entries
                                <select onchange="sendForm(this.form)" id="datatable_length" name="datatable_length" aria-controls="datatable" class="form-control input-sm">
                                    <option value="10">10</option>
                                    <option selected="selected" value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </label>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <label for="filter" style="float:right; margin-right: 10px;">Filter by:
                            <select name="filter" class="form-control input-sm">
                                <option
                                        @if(\Illuminate\Support\Facades\Input::get('filter') === 'all')
                                            selected="selected"
                                        @endif
                                        value="all">All
                                </option>
                                <option
                                        @if(\Illuminate\Support\Facades\Input::get('filter') === 'route')
                                            selected="selected"
                                        @endif
                                        value="route">Tour
                                </option>
                                <option
                                        @if(\Illuminate\Support\Facades\Input::get('filter') === 'category')
                                            selected="selected"
                                        @endif
                                        value="category">Category
                                </option>
                                @if($manager->hasRole('global'))
                                    <option
                                            @if(\Illuminate\Support\Facades\Input::get('filter') === 'partner')
                                                selected="selected"
                                            @endif
                                            value="partner">Partner
                                    </option>
                                @endif
                            </select>
                        </label>
                    </div>

                    <div class="col-md-2">
                        <label for="search" style="float:right; margin-right: 10px;">Search:
                            <input class="form-control input-sm" value="{{ \Illuminate\Support\Facades\Input::get('search') }}" name="search">
                        </label>
                    </div>

                    <div class="col-md-2">
                        <label><span  style="color:white;">Press me</span>
                            <button class="form-control btn btn-success" type="submit">Submit</button>
                        </label>
                    </div>

                    <div class="col-md-3">
                    <label style="float:right; margin-right: 10px;">Date from ... to</label>
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

                        <th>Code</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Payment method</th>
                        <th>Amount paid</th>
                        <th>Payment ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Partner</th>
                        <th>Category</th>
                        <th>Tour</th>


                    </tr>
                    </thead>

                    <script>
                        function sendForm(form)
                        {
                            form.submit();
                        }


                        var query = window.location.search.substring(1);
                        var vars = query.split("&");
                        for (var i=0;i<vars.length;i++) {
                            var pair = vars[i].split("=");
                            if(pair[0] == 'datatable_length'){
                                if( $('#datatable_length [value="' + pair[1] + '"]').length ) {
                                    document.querySelector('#datatable_length [value="' + pair[1] + '"]').selected = true;
                                }
                            }
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

                    @foreach($codes as $code)
                        <tr>
                            <th scope="row">{{ $nn++ }}</th>
                            <td>{{ $code->name }}</td>
                            <td>{{ date('Y-m-d', strtotime($code->paid_at)) }}</td>
                            <td>{{ date('H:i', strtotime($code->paid_at)) }}</td>
                            <td>{{ $code->pay_type }}</td>
                            <td>$ {{ $code->price() / 100 }}</td>
                            <td>{{ $code->paymentId() }}</td>
                            <td>{{ $code->email() }}</td>
                            <td>{{ $code->phone() }}</td>
                            <td>
                                @if($code->Partner)
                                    {{ $code->Partner->name }}
                                @endif
                            </td>
                            <td>
                                @if($code->Route)
                                    @if($code->Route->Category)
                                        {{ $code->Route->Category->name }}
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($code->Route)
                                    {{ $code->Route->name }}
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    <tr></tr>

                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>$ {{ $sum }}</td>
                    </tr>
                    </tbody>
                </table>

            </form>

            <div class="row">

                <div style="float:left;">
                    <a href="{{ $params->url }}/csv?{{ $params->query_string }}&all_entries=1" class="btn btn-default buttons-csv buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons"><span>CSV</span></a>
                </div>


                @if( ! (\Illuminate\Support\Facades\Input::get('all_entries')))

                    <div style="float:right;">
                        <ul class="pagination">
                            <!-- Previous Page Link -->
                            @if($codes->current != 1)
                                <li>
                                    <a href="{{ $codes->url }}&amp;page={{ $codes->current - 1 }}" rel="next">
                                        «
                                    </a>
                                </li>
                            @else
                                <li class="disabled">
                                    <span>«</span>
                                </li>
                             @endif

                            <!-- Pagination Elements -->
                            <!-- "Three Dots" Separator -->

                            <!-- Array Of Links -->
                            @for($i = 1; $i <= ($codes->countPages); $i++)
                                <li
                                    @if($codes->current == $i)
                                        class="active"
                                    @endif
                                >
                                    @if($codes->current == $i)
                                        <span>{{ $i }}</span>
                                    @endif
                                    @if($codes->current != $i)
                                        <a    href="{{ $codes->url }}&amp;page={{ $i }}">
                                            {{ $i }}
                                        </a>
                                    @endif

                                    </span>
                                </li>
                            @endfor

                            <!-- Next Page Link -->
                            @if($codes->current != $codes->countPages)
                                    <li>
                                        <a href="{{ $codes->url }}&amp;page={{ $codes->current + 1 }}" rel="next">
                                            »
                                        </a>
                                    </li>
                            @else
                                    <li class="disabled">
                                        <span>»</span>
                                    </li>
                            @endif
                        </ul>

                    </div>

                @endif

            </div>


        </div>
    </div>
@endsection