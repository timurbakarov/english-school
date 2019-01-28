import Grid from './components/grid';
import Box from './components/box';
import Table from './components/table';
import ScheduleCompact from './components/student-group/schedules-compact';
import Actions from './components/actions';

let components = Object.assign(
    Grid,
    Box,
    Table,
    Actions,
    {
        'c-schedule-compact': ScheduleCompact
    }
);

new Vue({
    el: '#app-groups-list',
    components: components,
    data: data
});
