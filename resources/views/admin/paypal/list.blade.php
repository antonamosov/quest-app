@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/paypal"><h2>Paypal transactions <small>
                    </small></h2></a>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <div class="row">

                <div class="col-md-2">
                    {{ $transactions->links() }}
                </div>

                @if($manager->hasRole('global'))
                    <div class="col-md-1 col-md-offset-9">
                        <a href="/admin/paypal/csv?{{ $params->query_string }}" class="btn btn-default buttons-csv buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons"><span>CSV</span></a>
                    </div>
                @endif

            </div>



            <table class="table table-striped">
                <thead>

                <?php $nn = 1; ?>

                <tr>
                    <th>#</th>
                    <th>TXN ID</th>
                    <th>SUM</th>
                    <th>Payment Status</th>
                    <th>Receiver Email</th>
                    <th>Date<th>
                    <th>Tour name</th>
                    <th>Code</th>
                </tr>
                </thead>
                <tbody>

                @foreach($transactions as $transaction)
                    <tr>
                        <th scope="row">{{ $nn++ }}</th>

                        <td>{{ $transaction->txn_id }}</td>

                        <td>
                            {{ $transaction->mc_gross }}
                        </td>

                        <td>{{ $transaction->payment_status }}</td>

                        <td>
                            {{ $transaction->receiver_email }}
                        </td>

                        <td>
                            {{ $transaction->payment_date }}
                        </td>

                        <td></td>

                        <td>
                            @if($transaction->Route)
                                {{ $transaction->Route->name }}
                            @endif
                        </td>

                        <td>
                            @if($transaction->Code)
                                {{ $transaction->Code->name }}
                            @endif
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="row">

                <div class="col-md-2">
                    {{ $transactions->links() }}
                </div>

                @if($manager->hasRole('global'))
                    <div class="col-md-1 col-md-offset-9">
                        <a href="/admin/paypal/csv?{{ $params->query_string }}" class="btn btn-default buttons-csv buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons"><span>CSV</span></a>
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection