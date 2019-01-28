@extends('layout')

@section('content')

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2>
                                    Платеж №{{ $payment->order_number }} от {{ date_formatted($payment->date) }},
                                    {{ $payment->student->last_name }} {{ $payment->student->first_name }}

                                    @include('payments._status', ['payment' => $payment])
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($payment->status == \Domain\Finance\Student\PaymentStatus::STATUS_CREATED)

            <div class="col-lg-12">
                <div class="row">
                    @if(false)
                        <div class="col-lg-6">
                            <div class="ibox selected">
                                <div class="ibox-content">
                                    <h2>Возврат</h2>

                                    <form method="post" action="{{ action(\App\Http\Controllers\PaymentCorrectionController::class . '@returnPayment', $payment->payment_id) }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="student_id" value="{{ $payment->student_id }}">

                                        <div class="row">
                                            <div class="col-lg-9">
                                                <input type="text" value="" name="comment" class="form-control" placeholder="Комментарий">
                                            </div>
                                            <div class="col-lg-3">
                                                <button class="btn btn-success" name="submit" value=""
                                                        style="width: 100%;"
                                                >
                                                    Вернуть
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-lg-6">
                        <div class="ibox selected">
                            <div class="ibox-content">
                                <h2>Отменить</h2>
                                <form method="post" action="{{ action(\App\Http\Controllers\PaymentCorrectionController::class . '@cancelPayment', $payment->payment_id) }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="student_id" value="{{ $payment->student_id }}">

                                    <div class="row">
                                        <div class="col-lg-9">
                                            <input type="text" value="" name="comment" class="form-control" placeholder="Комментарий">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="submit" value="Отменить" class="btn btn-success" style="width: 100%;">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>

@endsection
