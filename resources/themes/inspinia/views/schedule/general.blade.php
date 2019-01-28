@extends('layout')

@section('content')
    <div class="wrapper wrapper-content" style="margin-left: -15px; padding: 0;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h2>Общее расписание</h2>
                    </div>
                    <div class="ibox-content">
                        <div class="full-height-scroll">
                            <div class="table-responsive ">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="5%" style="border-top: none; border-left: none;"></td>
                                        @foreach($scheduleGeneralTable->daysOfWeek()->days() as $day)
                                            <th style="text-align: center; width: {{ (int)(95/7) }}%; visibility: hidden;"></th>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td width="5%" style="padding: 0; padding-top: 50px; border-left: none;">
                                            <div style="
                                                text-align: right;
                                                height: {{ count($scheduleGeneralTable->availableTimeInterval()) * 50 }}px;
                                                font-weight: bold;
                                                position: relative;
                                            ">

                                                @foreach($scheduleGeneralTable->availableTimeInterval() as $index => $hour)

                                                    <span style="
                                                        position: absolute;
                                                        top: {{ $index * 50 - 10 }}px;
                                                        right: 15px;
                                                    ">
                                                        {{ $hour }}:00
                                                    </span>

                                                    <div style="
                                                        top: {{ $index * 50 }}px;
                                                        position: absolute;
                                                        border-top: 1px solid #ccc;
                                                        width: 10px;
                                                        right: 0;
                                                        ">&nbsp;</div>

                                                    <div style="
                                                            top: {{ $index * 50 + 25 }}px;
                                                            position: absolute;
                                                            border-top: 1px solid #ddd;
                                                            width: 5px;
                                                            right: 0;
                                                        ">&nbsp;</div>

                                                @endforeach

                                            </div>
                                        </td>

                                        @foreach($scheduleGeneralTable->daysOfWeek()->days() as $day)
                                            <td style="padding: 0;">
                                                <div style="
                                                        height: 50px;
                                                        text-align: center;
                                                        line-height: 40px;
                                                        font-weight: bold;
                                                        position: relative;
                                                    ">
                                                    {{ $day->name() }}
                                                </div>

                                                <div style="
                                                    text-align: right;
                                                    height: {{ count($scheduleGeneralTable->availableTimeInterval()) * 50 }}px;
                                                    font-weight: bold;
                                                    position: relative;
                                                    ">

                                                    @foreach($scheduleGeneralTable->availableTimeInterval() as $index => $hour)
                                                        <div style="
                                                            top: {{ $index * 50 }}px;
                                                            position: absolute;
                                                            border-top: 1px solid #ccc;
                                                            width: 100%;
                                                            right: 0;
                                                            ">&nbsp;</div>

                                                        <div style="
                                                            top: {{ $index * 50 + 25 }}px;
                                                            position: absolute;
                                                            border-top: 1px solid #eee;
                                                            width: 100%;
                                                            right: 0;
                                                            ">&nbsp;</div>

                                                    @endforeach

                                                    @foreach($scheduleGeneralTable->dataByDayOfWeek($day->number()) as $item)
                                                        <div
                                                            data-group-id="{{ $item->groupId() }}"
                                                            style="
                                                                top: {{ $scheduleGeneralTable->blockPosition($item) }}px;
                                                                position: absolute;
                                                                width: 100%;
                                                                text-align: center;
                                                                border: 1px solid #ccc;
                                                                height: {{ $scheduleGeneralTable->blockHeight($item) }}px;
                                                                background: #c5f9c0;
                                                                line-height: {{ $scheduleGeneralTable->blockHeight($item) }}px;
                                                            "
                                                        >
                                                            <span class="begin-time label label-default">
                                                                {{ $item->timeInterval()->beginTime() }}
                                                                -
                                                                {{ $item->timeInterval()->endTime() }}
                                                            </span>

                                                            {{ $item->groupName() }}
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="no-margins">{{ $totalHours }}</h1>
                                <div class="font-bold text-navy">Часов</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="no-margins">{{ $totalClasses }}</h1>
                                <div class="font-bold text-navy">Занятий</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="no-margins">{{ $totalIncome }}</h1>
                                <div class="font-bold text-navy">Доход за неделю</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .begin-time {
            position: absolute;
            left: 25%;
            top: -25px;
            display: none;
            font-size: 16px !important;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $("[data-group-id]").hover(function() {
            $("[data-group-id=" + $(this).data('group-id') + "]").css('background-color', '#ff798f');
            $('.begin-time', this).show();
        }, function() {
            $("[data-group-id=" + $(this).data('group-id') + "]").css('background-color', '#c5f9c0');
            $('.begin-time', this).hide();
        });
    </script>
@endsection
