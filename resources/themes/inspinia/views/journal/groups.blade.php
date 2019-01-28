@extends('layout')

@section('content')

    <div class="wrapper wrapper-content" style="margin-left: -15px; padding: 0;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h2>Журнал</h2>
                    </div>
                    <div class="ibox-content">
                        @if($groups->count())
                            <div class="full-height-scroll">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>Название</th>
                                            <th>Кол-во учеников</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($groups as $index => $group)
                                            <tr>
                                                <td>
                                                    <a href="{{ url('journal', $group->id) }}">
                                                        {{ $group->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $group->students_count }}</td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <p>Нет групп</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
