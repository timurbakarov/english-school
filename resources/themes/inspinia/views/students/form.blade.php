@extends('layout')

@section('content')

    {{ $errors }}

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h2>{{ $student ? 'Редактирование данных ученника' : 'Добавление ученика' }}</h2>
                </div>
                <div class="ibox-content">
                    <form method="post" action="{{ $student
                    ? url('123', $student->id)
                    : action(\App\Http\Controllers\Student\StudentAcceptController::class) }}">
                        {{ csrf_field() }}

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Фамилия</label>
                            <div class="col-sm-10"><input type="text" name="last_name" class="form-control"  value="{{ old('last_name') ?? $student->last_name ?? ''}}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Имя</label>
                            <div class="col-sm-10"><input type="text" name="first_name" class="form-control" value="{{ old('first_name') ?? $student->first_name ?? '' }}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Принят</label>
                            <div class="col-sm-10"><input type="date" name="accepted_date" class="form-control"  value="{{ old('accepted_date') ?? $student->accepted_at ?? date('Y-m-d')}}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Группа</label>
                            <div class="col-sm-10">
                                <select name="group_id" class="form-control">
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10"><input type="text" name="email" class="form-control" value="{{ old('email') ?? $student->email ?? '' }}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Телефон</label>
                            <div class="col-sm-10"><input type="text" name="phone" class="form-control" value="{{ old('phone') ?? $student->phone ?? '' }}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label">Родители</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="parents"></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

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
