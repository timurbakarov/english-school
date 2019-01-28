import Grid from './components/grid';
import Box from './components/box';
import Table from './components/table';
import Actions from './components/actions';
import Badge from './components/badge';
import CommonComponents from './CommonComponents';

new Vue({
    el: '#app-student-view',
    components: _.merge(CommonComponents,
        Grid,
        Box,
        Table,
        Actions,
        Badge,
        CommonComponents
    ),
    data: data
});
