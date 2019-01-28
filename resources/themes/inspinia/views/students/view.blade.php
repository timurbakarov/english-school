@extends('layout')

@section('content')

    <div class="wrapper wrapper-content" id="app-student-view">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-lg-2">
                                <h2>
                                    <editable-text
                                        url="{{ url('students/update/name', $student->id) }}"
                                        text="{{ $student->last_name }} {{ $student->first_name }}"
                                        field="name"
                                    />
                                </h2>
                            </div>
                            <div class="col-lg-2">
                                <h1 class="no-margins @if($student->balance < 0) text-danger @elseif($student->balance > 0) text-success @endif ">{{ $student->balance }}</h1>
                                <div class="font-bold text-navy">Баланс</div>
                            </div>
                            <div class="col-md-2">
                                <h1 class="no-margins">{{ $stat->payments ?? 'N/A' }}</h1>
                                <div class="font-bold text-navy">Оплачено</div>
                            </div>
                            <div class="col-md-2">
                                <h1 class="no-margins">{{ $stat->visited_classes_in_money ?? 'N/A' }}</h1>
                                <div class="font-bold text-navy">Получено</div>
                            </div>
                            <div class="col-md-2">
                                <h1 class="no-margins">{{ $stat->visited_classes ?? 'N/A' }}</h1>
                                <div class="font-bold text-navy">Посещено</div>
                            </div>
                            <div class="col-md-2">
                                <h1 class="no-margins">{{ $stat->missed_classes ?? 'N/A' }}</h1>
                                <div class="font-bold text-danger">Пропущено</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-content" style="font-size: 16px;">
                                <dl class="row mb-0">
                                    <div class="col-sm-3 text-sm-left"><dt>Телефон:</dt> </div>
                                    <div class="col-sm-9 text-sm-left">
                                        <dd class="mb-1">
                                            <editable-text
                                                url="{{ url('students/update', $student->id) }}"
                                                text="{{ $student->phone }}"
                                                field="phone"
                                            />
                                        </dd>
                                    </div>
                                </dl>

                                @if($student->email)
                                    <dl class="row mb-0">
                                        <div class="col-sm-3 text-sm-left"><dt>Email:</dt> </div>
                                        <div class="col-sm-9 text-sm-left"> <dd class="mb-1"> {{ $student->email }}</dd></div>
                                    </dl>
                                @endif

                                @if($student->parents)
                                    <dl class="row mb-0">
                                        <div class="col-sm-3 text-sm-left"><dt>Родители:</dt> </div>
                                        <div class="col-sm-9 text-sm-left"> <dd class="mb-1"> <editable-text text="{{ $student->parents }}" /></dd></div>
                                    </dl>
                                @endif

                                <dl class="row mb-0">
                                    <div class="col-sm-3 text-sm-left"><dt>Группа:</dt> </div>
                                    <div class="col-sm-9 text-sm-left">
                                        <dd class="mb-1">
                                            @if($student->group)
                                                группа {{ $student->group->name }}, {{ $student->group->price_per_hour }}
                                            @else
                                                нет
                                            @endif
                                        </dd>
                                    </div>
                                </dl>

                                <dl class="row mb-0">
                                    <div class="col-sm-3 text-sm-left"><dt>Принят:</dt> </div>
                                    <div class="col-sm-9 text-sm-left">
                                        <dd class="mb-1">
                                            {{ date_formatted($student->accepted_date) }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                @if($student->is_active)
                    <div class="ibox selected">
                        <div class="ibox-content">
                            <h2>Внести оплату</h2>

                            @if($student->group)
                                <form method="post" action="{{ action(\App\Http\Controllers\Student\StudentMakePaymentController::class, ['id' => $student->id]) }}">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <input type="number" value="{{ $student->group ? $student->group->price_per_hour : '' }}" name="amount" class="form-control" placeholder="Сумма">
                                        </div>
                                        <div class="col-lg-4">
                                            <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                        </div>
                                        <div class="col-lg-2">
                                            <button class="btn btn-success" name="type" value="{{ \Domain\Finance\Student\PaymentType::TYPE_CASH }}"
                                                style="width: 100%;"
                                            >
                                                <i class="fa fa-money"></i> Наличка
                                            </button>
                                        </div>
                                        <div class="col-lg-2">
                                            <button class="btn btn-success" name="type" value="{{ \Domain\Finance\Student\PaymentType::TYPE_ACCOUNT }}"
                                                style="width: 100%;"
                                            >
                                                <i class="fa fa-credit-card"></i> Счет
                                            </button>
                                        </div>

                                    </div>

                                </form>
                            @else
                                <p class="text-warning">Ученик не в группе</p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($student->is_active)
                    <div class="ibox selected">
                        <div class="ibox-content">
                            <h2>Перевести в группу</h2>
                            <form method="post" action="{{ url('students/move-to-group', $student->id) }}">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-lg-5">
                                        <select name="group_id" class="form-control">
                                            @foreach($groups as $group)
                                                @if($student->group AND $group->id == $student->group->id)
                                                    @continue
                                                @endif

                                                <option value="{{ $group->id }}">
                                                    {{ $group->name }}, {{ $group->price_per_hour }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="date" value="{{ date('Y-m-d') }}" name="assigned_on" class="form-control">
                                    </div>

                                    <div class="col-lg-2">
                                        <input type="submit" value="Перевести" class="btn btn-success">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                @if($student->is_active AND $student->balance == 0)
                    <div class="ibox selected">
                        <div class="ibox-content">
                            <h2>Выбыл</h2>
                            <form method="post" action="{{ url('students/dismiss', $student->id) }}">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-lg-7">
                                        <input type="text" value="" name="reason" class="form-control" placeholder="Причина">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="date" value="{{ date('Y-m-d') }}" name="dismissed_on" class="form-control">
                                    </div>

                                    <div class="col-lg-2">
                                        <input type="submit" value="Подтвердить" class="btn btn-success">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif(!$student->is_active)
                    <div class="ibox selected">
                        <div class="ibox-content">
                            <h2>Принять</h2>
                            <form method="post" action="{{ url('students/reaccept', $student->id) }}">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-lg-6">
                                        <select name="group_id" class="form-control">
                                            @foreach($groups as $group)
                                                <option value="{{ $group->id }}">
                                                    {{ $group->name }}, {{ $group->price_per_hour }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <input type="date" value="{{ date('Y-m-d') }}" name="date" class="form-control">
                                    </div>

                                    <div class="col-lg-2">
                                        <input style="width: 100%;" type="submit" value="Подтвердить" class="btn btn-success">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                </div>

            <c-grid>
                <c-box>
                    <c-box-content>
                        <h2>Платежи</h2>

                        @if($payments)
                            <table class="table table-striped">
                                @foreach($payments as $payment)
                                    <tr>
                                        <td width="1">
                                            <a href="{{ url('payment/view', $payment->payment_id) }}">
                                                {{ $payment->order_number }}.
                                            </a>
                                        </td>
                                        <td>{{ date_formatted($payment->date) }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td class="text-warning">
                                            {{ $payment->type }}
                                        </td>
                                        <td>
                                            @include('payments._status', ['payment' => $payment])
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </c-box-content>
                </c-box>

                <c-box>
                    <c-box-content>
                        <h2>Занятия</h2>
                        <c-table>
                            <c-table-body>
                                <c-table-body-row v-for="lesson in lessons" :key="lesson.id">
                                    <c-table-body-data>
                                        <div v-if="lesson.status == 'attended'">
                                            <c-badge-primary>был</c-badge-primary>
                                        </div>
                                        <div v-if="lesson.status == 'missed'">
                                            <c-badge-danger>пропустил</c-badge-danger>
                                        </div>
                                    </c-table-body-data>
                                    <c-table-body-data>
                                        @{{ lesson.date }}
                                    </c-table-body-data>
                                    <c-table-body-data>
                                        Группа @{{ lesson.group_name }}
                                    </c-table-body-data>
                                    <c-table-body-data>
                                        <div v-if="lesson.status === 'attended'" >
                                            <div v-if="lesson.is_payed"></div>
                                            <div v-else>
                                                <c-badge-danger>долг - @{{ lesson.payment }}</c-badge-danger>
                                            </div>
                                        </div>
                                    </c-table-body-data>
                                </c-table-body-row>
                            </c-table-body>
                        </c-table>
                    </c-box-content>
                </c-box>
            </c-grid>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let data = {
            lessons: {!! json_encode($lessons) !!}
        };
    </script>

    <script src="{{ asset('assets/js/student-view.js') }}"></script>
@endsection
