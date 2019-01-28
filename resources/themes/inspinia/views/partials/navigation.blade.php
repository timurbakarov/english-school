<ul class="nav metismenu" id="side-menu">
    <li @if(Request::is('schedule/current')) class="active" @endif>
        <a href="{{ url('schedule/current') }}"><i class="fa fa-calendar"></i> <span class="nav-label">Расписание текущее</span></a>
    </li>

    <li @if(Request::is('schedule/general')) class="active" @endif>
        <a href="{{ url('schedule/general') }}"><i class="fa fa-calendar-check-o"></i> <span class="nav-label">Расписание общее</span></a>
    </li>

    <li @if(Request::is('journal*')) class="active" @endif>
        <a href="{{ url('journal') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Журнал</span></a>
    </li>

    <li @if(Request::is('payments*')) class="active" @endif>
        <a href="{{ url('payments') }}"><i class="fa fa-money"></i> <span class="nav-label">Платежи</span></a>
    </li>

    <li @if(Request::is('classes*')) class="active" @endif>
        <a href="{{ url('classes') }}"><i class="fa fa-mortar-board"></i> <span class="nav-label">Занятия</span></a>
    </li>

    <li @if(Request::is('students*')) class="active" @endif>
        <a href="{{ url('students') }}"><i class="fa fa-user"></i> <span class="nav-label">Ученики</span></a>
    </li>

    <li @if(Request::is('groups*')) class="active" @endif>
        <a href="{{ url('groups') }}"><i class="fa fa-group"></i> <span class="nav-label">Группы</span></a>
    </li>

    <li @if(Request::is('stats*')) class="active" @endif>
        <a href="{{ url('stats') }}"><i class="fa fa-percent"></i> <span class="nav-label">Статистика</span></a>
    </li>
</ul>
