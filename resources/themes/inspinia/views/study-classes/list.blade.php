@extends('layout')

@section('content')

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
                                        <th>Группа</th>
                                        <th>Учеников пришло</th>
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
                                                    {{ $class->group->name }}
                                                </td>
                                                <td>
                                                    {{ $class->students_count ?? 0 }}
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


@endsection
