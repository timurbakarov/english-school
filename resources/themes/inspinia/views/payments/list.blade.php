@extends('layout')

@section('content')

    <div class="wrapper wrapper-content" style="margin-left: -15px; padding: 0;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h2>Платежи - {{ money($total) }}</h2>
                    </div>
                    <div class="ibox-content">
                        <div class="full-height-scroll">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5">№</th>
                                            <th>Дата</th>
                                            <th>Ученик</th>
                                            <th>Сумма</th>
                                            <th>Тип платежа</th>
                                            <th>Статус</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($payments as $index => $payment)
                                            <tr>
                                                <td>
                                                    {{ $index + 1}}.
                                                </td>
                                                <td>{{ date_formatted($payment->date) }}</td>
                                                <td>
                                                    <a href="{{ url('students/view', $payment->student->id) }}">
                                                        {{ $payment->student->last_name }} {{ $payment->student->first_name }}
                                                    </a>
                                                </td>
                                                <td style="font-size: 16px;">
                                                    {{ money($payment->amount) }}
                                                </td>
                                                <td>{{ $payment->type }}</td>
                                                <td>
                                                    @include('payments._status', ['payment' => $payment])
                                                </td>
                                                <td>
                                                    <a href="{{ action(\App\Http\Controllers\PaymentViewController::class, $payment->payment_id) }}"><i class="fa fa-eye"></i> </a>
                                                    <a href="{{ action(\App\Http\Controllers\PaymentViewController::class, $payment->payment_id) }}"><i class="fa fa-pencil"></i> </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
