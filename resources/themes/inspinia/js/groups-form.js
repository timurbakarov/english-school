import Grid from './components/grid';
import Box from './components/box';
import Form from './components/form';

let components = Object.assign(
    Grid,
    Box,
    Form
);

new Vue({
    el: '#app-groups-form',
    components: components,
    data: data
});
