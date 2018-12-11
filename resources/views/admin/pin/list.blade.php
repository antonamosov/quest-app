@extends('admin.layout')

@section('content')
    <div class="x_panel">
        <div class="x_title">
            <a href="/admin/paypal"><h2>PIN Payment transactions <small>
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
                        <a href="/admin/pin/csv?{{ $params->query_string }}" class="btn btn-default buttons-csv buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons"><span>CSV</span></a>
                    </div>
                @endif
            </div>

            <table class="table table-striped">
                <thead>

                <?php $nn = 1; ?>

                <tr>
                    <th>#</th>
                    <th>Token</th>
                    <th>Description</th>
                    <th>IP address</th>
                    <th>Status message</th>
                    <th>Date<th>
                </tr>
                </thead>
                <tbody>

                @foreach($transactions as $transaction)
                    <tr>
                        <th scope="row">{{ $nn++ }}</th>

                        <td>{{ $transaction->token }}</td>

                        <td>
                            {{ $transaction->description }}
                        </td>

                        <td>{{ $transaction->ip_address }}</td>

                        <td>
                            {{ $transaction->status_message }}
                        </td>

                        <td>
                            {{ $transaction->created_at }}
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
                        <a href="/admin/pin/csv?{{ $params->query_string }}" class="btn btn-default buttons-csv buttons-html5 btn-sm" tabindex="0" aria-controls="datatable-buttons"><span>CSV</span></a>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection