@extends('layout')

@section('content')
    <div class="wrapper wrapper-content" style="margin-left: -15px; padding: 0;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h2>Текущее расписание</h2>
                    </div>
                    <div class="ibox-content">
                        <div class="full-height-scroll">
                            <div class="table-responsive ">
                                <table class="table table-bordered">
                                    <tr>
                                        @foreach($scheduleCurrentTable->daysOfWeek()->days() as $day)
                                            <th style="text-align: center; width: {{ (int)(100/7) }}%;">
                                                {{ $day->name() }}
                                            </th>
                                        @endforeach
                                    </tr>

                                    @for($i=0; $i<$scheduleCurrentTable->maxDataInDay(); $i++)
                                        <tr>
                                            @foreach($scheduleCurrentTable->daysOfWeek()->days() as $index => $day)
                                                <td style="font-size: 16px; text-align: center;">
                                                    @if($item = $scheduleCurrentTable->dataByDayNumberAndIndex($day->number(), $i))

                                                        <strong>{{ $item->timePeriod() }}</strong>
                                                        <br />
                                                        <a href="{{ url('journal', $item->groupId()) }}">
                                                            {{ $item->groupName() }}
                                                        </a>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endfor

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
