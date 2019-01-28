@extends('layout')

@section('content')

    <div class="wrapper wrapper-content" style="margin-left: -15px; padding: 0;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h1>Статистика за 2018</h1>
                    </div>
                </div>
            </div>
        </div>

        @foreach($statsByMonth as $item)

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h2 style="text-transform: capitalize">{{ monthLabel($item->month) }}</h2>
                        </div>

                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-4">
                                    <small class="stats-label">Заработано</small>
                                    <h2>{{ money($item->income) }}</h2>
                                </div>

                                <div class="col-4">
                                    <small class="stats-label">Отработано в руб.</small>
                                    <h2>{{ money($item->money_worked) }}</h2>
                                </div>

                                <div class="col-4">
                                    <small class="stats-label">Отработано часов</small>
                                    <h2>{{ $item->hours_worked }}/{{ $item->hours_student_worked }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="ibox-content">
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    @if(isset($statsByWeek[$item->month]))
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Неделя</th>
                                                    <th>Заработано</th>
                                                    <th>Отработано в руб.</th>
                                                    <th>Отработано часов</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($statsByWeek[$item->month] as $row)
                                                    <tr>
                                                        <td>{{ $row['week'] }}</td>
                                                        <td>{{ $row['income'] }}</td>
                                                        <td>
                                                            {{ $row['money_worked'] }}
                                                        </td>
                                                        <td>
                                                            @if(isset($row['hours_worked']))
                                                                {{ $row['hours_worked'] }}/{{ $row['hours_student_worked'] }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>


@endsection
