@extends('layout')

@section('content')

    <div class="wrapper wrapper-content" style="margin-left: -15px; padding: 0;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h2>Ученики - {{ $students->count() }}</h2>
                        <div class="ibox-tools">
                            <a href="{{ url('students/create') }}" class="btn btn-primary btn-xs">Принять ученика</a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="btn-group btn-group-toggle">
                                    <a class="btn btn-sm @if($filter->active()) btn-primary active @else btn-white @endif" href="{{ action(\App\Http\Controllers\StudentsList::class) }}?active=1">
                                        Активные
                                    </a>
                                    <a class="btn btn-sm  @if(!$filter->active()) btn-primary active @else btn-white @endif" href="{{ action(\App\Http\Controllers\StudentsList::class) }}?active=0">
                                        Выбывшие
                                    </a>
                                </div>
                            </div>
                        </div>

                        <br/>

                        <div class="full-height-scroll">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="5"></th>
                                            <th>Имя</th>
                                            <th style="width: 5%; text-align: right;">Баланс</th>
                                            <th>Группа</th>
                                            <th>Телефон</th>
                                            <th>Родители</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($students as $index => $student)
                                            <tr>
                                                <td>{{ $index + 1 }}.</td>
                                                <td>
                                                    <a href="{{ url('students/view', $student->id) }}" class="client-link">
                                                        {{ $student->last_name }} {{ $student->first_name }}
                                                    </a>
                                                </td>
                                                <td style="text-align: right;">
                                                    @if($student->balance > 0)
                                                        <span class="badge badge-primary">{{ money($student->balance) }}</span>
                                                    @elseif($student->balance < 0)
                                                        <span class="badge badge-danger">{{ money($student->balance) }}</span>
                                                    @else
                                                        <span class="badge badge-default">{{ money($student->balance) }}</span>
                                                    @endif
                                                <td>
                                                    @if($student->group)
                                                        <a href="{{ url('groups/edit', $student->group->id) }}">{{ $student->group->name }}</a>
                                                    @else
                                                        <span class="label label-danger">Без группы</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $student->phone }}
                                                </td>
                                                <td>
                                                    {{ $student->parents }}
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
