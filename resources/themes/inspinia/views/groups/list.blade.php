@extends('layout')

@inject('scheduleItemPresentation', 'Presentation\Schedule\ScheduleItemPresentation')

@section('content')

    <div id="app-groups-list">
        <c-row>
            <c-grid>
                <c-box>
                    <c-box-title :title="header" :size="2">
                        <c-box-title-link :link="links.createGroup"></c-box-title-link>
                    </c-box-title>
                    <c-box-content>
                        <c-table>
                            <c-table-head>
                                <c-table-head-data :width="5"></c-table-head-data>
                                <c-table-head-data>Название</c-table-head-data>
                                <c-table-head-data>Кол-во учеников</c-table-head-data>
                                <c-table-head-data>Стоимость часа</c-table-head-data>
                                <c-table-head-data>Расписание</c-table-head-data>
                                <c-table-head-data>Действия</c-table-head-data>
                            </c-table-head>
                            <c-table-body>
                                <c-table-body-row v-for="group in groups">
                                    <c-table-body-data>@{{ group.index }}.</c-table-body-data>
                                    <c-table-body-data>@{{ group.name }}</c-table-body-data>
                                    <c-table-body-data>@{{ group.students_count }}</c-table-body-data>
                                    <c-table-body-data>@{{ group.price_per_hour }}</c-table-body-data>
                                    <c-table-body-data>
                                        <c-schedule-compact :schedules="group.schedule"></c-schedule-compact>
                                    </c-table-body-data>
                                    <c-table-body-data>
                                        <c-action-view :url="group.view_url"></c-action-view>
                                        <c-action-edit :url="group.edit_url"></c-action-edit>
                                    </c-table-body-data>
                                </c-table-body-row>
                            </c-table-body>
                        </c-table>
                    </c-box-content>
                </c-box>
            </c-grid>
        </c-row>
    </div>

@endsection

@section('scripts')

    <script>
        let data = {
            header: 'Группы - ' + '{{ $groupsCount }}',
            links: {
                createGroup: {
                    label: 'Создать группу',
                    url: '{{ url('groups/create') }}'
                }
            },
            groups: {!! json_encode($groupsTable['rows']) !!}
        };
    </script>

    <script src="{{ asset('assets/js/groups-list.js') }}"></script>

@endsection
