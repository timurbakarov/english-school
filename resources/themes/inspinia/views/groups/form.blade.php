@extends('layout')

@inject('scheduleItemPresentation', 'Presentation\Schedule\ScheduleItemPresentation')

@section('content')

    {{ $errors }}

    {{--
    <div id="app-groups-form">
        <c-row>
            <c-grid>
                <c-box>
                    <c-box-title title="Добавление группы" :size="2"></c-box-title>
                    <c-box-content>
                        <c-form action="{{ url('groups/store') }}">
                            <c-form-field label="Название">
                                <c-form-field-text name="name" value="" />
                            </c-form-field>

                            <c-form-field label="Цена за час">
                                <c-form-field-text name="price_per_hour" value="" />
                            </c-form-field>

                            <c-form-field label="Расписание">
                                <c-form-field-text name="schedule" value="" />
                            </c-form-field>

                            <c-form-field label="Дата добавления">
                                <c-form-field-date name="created_date" value="" default="{{ date('Y-m-d') }}" />
                            </c-form-field>

                            <c-form-field>
                                <c-grid>
                                    <button class="btn btn-white btn-sm" type="submit">Cancel</button>
                                    <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                </c-grid>
                            </c-form-field>
                        </c-form>
                    </c-box-content>
                </c-box>
            </c-grid>
        </c-row>
    </div>
    --}}

    <div class="row" id="app-groups-form">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h2>{{ $group ? 'Редактирование данных группы' : 'Добавление группы' }}</h2>
                </div>
                <div class="ibox-content">
                    <form method="post" action="{{ $group ? url('groups/update', $group->id) : url('groups/store') }}">
                        {{ csrf_field() }}

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Название</label>
                            <div class="col-sm-10"><input type="text" name="name" class="form-control"  value="{{ old('name') ?? $group->name ?? ''}}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Цена за час</label>
                            <div class="col-sm-10"><input type="text" name="price_per_hour" class="form-control" value="{{ old('price_per_hour') ?? $group->price_per_hour ?? '' }}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Расписание</label>
                            <div class="col-sm-10"><input type="text" name="schedule" class="form-control" value="{{ old('schedule') ?? isset($group->schedule) ? $scheduleItemPresentation->displayForForm($group->schedule->toArray()) : '' }}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        @if(!$group)
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Дата добавления</label>
                                <div class="col-sm-10"><input type="date" value="{{ date('Y-m-d') }}" name="created_date" class="form-control" value="{{ old('added_at') ?? $group->added_at ?? '' }}"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif

                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white btn-sm" type="submit">Cancel</button>
                                <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        let data = {
            form: {}
        };
    </script>

    <script src="{{ asset('assets/js/groups-form.js') }}"></script>

@endsection
