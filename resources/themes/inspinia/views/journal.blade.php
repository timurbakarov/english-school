@extends('layout')

@section('content')
    <div class="wrapper wrapper-content" style="margin-left: -15px; padding: 0;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <a href="{{ url($journalTable->prevUrl()) }}" class="pull-left btn-default btn"><< </a>

                        @if(!$journalTable->isCurrentMonth())
                            <a
                                href="{{ url($journalTable->currentWeekUrl()) }}"
                                class="pull-right btn btn-success text-white"
                                style="margin-right: 45px;"
                            >
                                Текущий месяц
                            </a>
                        @endif

                        <h2 style="text-align: center;">
                            Журнал за {{ $journalTable->weekName() }}
                        </h2>

                        <a href="{{ url($journalTable->nextUrl()) }}" class="pull-right btn btn-default">>> </a>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h2 style="text-align: center;">
                            Группа {{ $group->name }}, {{ money($group->price_per_hour) }}
                        </h2>
                    </div>
                    <div class="ibox-content">
                        <div class="full-height-scroll">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">

                                    <tr>
                                        <th style="width: 20%;">
                                        </th>
                                        @foreach($journalTable->days() as $day)
                                            <th style="vertical-align: middle;
                                                text-align: center;
                                                font-size: 20px;
                                                width: {{ floor(80/$journalTable->daysCount()) }}%;
                                                font-weight: normal;

                                                @if($day['is_past'])
                                                    opacity: 0.3;
                                                @endif

                                                @if($day['is_today'])
                                                    background: #c5f9c0;
                                                @endif

                                                "

                                            >
                                                {{ $day['label'] }}, {{ $day['day_of_week'] }}
                                            </th>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <th style="text-align: center;">
                                        </th>

                                        @foreach($journalTable->days() as $index => $day)
                                            <td style="
                                                    @if($day['is_past'])
                                                        opacity: 0.3;
                                                    @endif

                                                    font-size: 14px;
                                                    text-align: center;

                                                    @if(!isset($classesGroupByDate[$day['date']]))
                                                        font-weight: bold;
                                                        cursor: pointer;
                                                    @endif
                                                "
                                                @if(!isset($classesGroupByDate[$day['date']]))
                                                    onclick="openModal('group-{{ $group->id }}', '{{ $day['date'] }}')"
                                                @endif
                                            >

                                                {{ timePeriod($day['hour'], $day['minutes'], $day['duration']) }}

                                            </td>
                                        @endforeach
                                    </tr>

                                    @if($students)
                                        @foreach($students as $student)
                                            <tr>
                                                <td>
                                                    <a href="{{ url('students/view', $student->id) }}">
                                                        {{ $student->last_name }} {{ $student->first_name }}
                                                    </a>

                                                    @if($student->balance > 0)
                                                        <span class="label label-primary pull-right">{{ $student->balance }}</span>
                                                    @elseif($student->balance < 0)
                                                        <span class="label label-danger pull-right">{{ $student->balance }}</span>
                                                    @else
                                                        <span class="pull-right label label-default">0</span>
                                                    @endif
                                                </td>

                                                @foreach($journalTable->days() as $index => $day)
                                                    <?php $studentLesson = $studentClasses[$day['date']][$day['hour'] . $day['minutes']][$student->id] ?? false?>

                                                    <td style="
                                                        text-align: center;
                                                        @if($studentLesson)
                                                            @if($studentLesson['status'] == 'attended')
                                                                background: #c5f9c0;
                                                            @else
                                                                background: #fbbaa3;
                                                            @endif
                                                        @endif
                                                    "
                                                    >
                                                        @if($studentLesson)
                                                            @if($studentLesson['status'] == 'attended')
                                                                @if($studentLesson['is_payed'])
                                                                    <span class="" style="line-height: 0; font-size: 18px;">
                                                                        +{{ $studentLesson['payment'] }}
                                                                    </span>
                                                                @else
                                                                    <span class="text text-danger">не оплачено</span>
                                                                @endif
                                                            @else
                                                                Н
                                                            @endif
                                                        @else
                                                            @if(!$day['is_future'])
                                                                <div class="hidden-actions">
                                                                    <a href=""
                                                                       class="btn btn-primary btn-xs send-study-class"
                                                                       style="padding: 0 12px; line-height: 13px;"
                                                                       data-student-id="{{ $student->id }}"
                                                                       data-date="{{ $day['date'] }}"
                                                                       data-time="{{ $day['hour'] }}:{{ $day['minutes'] }}"
                                                                       data-duration="{{ $day['duration'] }}"
                                                                       data-status="attended"
                                                                    >был</a>

                                                                    <a href=""
                                                                       class="btn btn-warning btn-xs send-study-class"
                                                                       data-student-id="{{ $student->id }}"
                                                                       data-date="{{ $day['date'] }}"
                                                                       data-time="{{ $day['hour'] }}:{{ $day['minutes'] }}"
                                                                       data-duration="{{ $day['duration'] }}"
                                                                       data-status="missed"
                                                                       style="padding: 0 12px; line-height: 13px;"
                                                                    >не был</a>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content" style="margin-left: -15px; padding: 0;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h2>Занятия</h2>
                    </div>
                    <div class="ibox-content">
                        <div class="full-height-scroll">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>Цена за час</th>
                                        <th>Часов</th>
                                        <th>Оплата</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($classes as $class)
                                        <tr>
                                            <td>
                                                {{ date_formatted($class->date) }}
                                            </td>
                                            <td>
                                                {{ $class->price_per_hour }}
                                            </td>
                                            <td>
                                                {{ $class->duration }}
                                            </td>
                                            <td style="font-size: 16px;">
                                                {{ $class->price_per_hour * $class->duration * $class->students_count }}
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

    <div class="modal inmodal fade" id="group-{{ $group->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('lesson/give') }}" method="post">
                    <div class="modal-body">
                        <h2>Занятие</h2>

                        Количество часов
                        <select name="hours" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>

                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                        <input type="hidden" name="date">

                        <br />

                        {{ csrf_field() }}

                        <table class="table table">
                            <tr>
                                <th>Ученик</th>
                                <th>Был на занятии</th>
                                <th>Причина отсутствия</th>
                            </tr>
                            @foreach($group->students as $index => $student)
                                <tr>
                                    <td>
                                        {{ $student->last_name }} {{ $student->first_name }}
                                        <input type="hidden" name="student[{{ $index }}][id]" value="{{ $student->id }}">
                                    </td>
                                    <td style="text-align: center;"><input type="checkbox" name="student[{{ $index }}][was]"  /></td>
                                    <td><input type="text" name="student[{{ $index }}][message]" class="form-control" /></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="modal-footer">
                        <input type="submit" value="Отметить" name="submit" class="btn btn-success">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .hidden-actions {
            /*display: none;*/
        }
    </style>

@endsection

@section('scripts')

    <script>
        function openModal(modal, date) {
            $('#' + modal + " [name=date]").val(date);
            $('#' + modal).modal();
        }

        $(function() {
            $(".send-study-class").click(function() {
                var data = {
                    student_id: $(this).data('student-id'),
                    date: $(this).data('date'),
                    time: $(this).data('time'),
                    duration: $(this).data('duration'),
                    group_id: '{{ $group->id }}',
                    status: $(this).data('status')
                };

                var form = $("<form style='display: none;'></form>");
                form.prop('method', 'POST');
                form.prop('action', '{{ action(\App\Http\Controllers\Lesson\LessonGiveController::class) }}');

                form.append('{{ csrf_field() }}');

                for(key in data) {
                    form.append('<input type="hidden" name="' + key + '" value="' + data[key] + '"/>');
                }

                $('body').append(form);
                form.submit();



                return false;
            });

            // $("td:has(.hidden-actions)").hover(function() {
            //     $('.hidden-actions', this).show();
            // }, function() {
            //     $('.hidden-actions', this).hide();
            // });
        });
    </script>

@endsection
