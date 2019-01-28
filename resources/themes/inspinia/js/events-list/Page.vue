<template>
    <row :show-wrapper="true">
        <grid>
            <box title="Events">
                <c-table v-bind="table" selectable-rows="true"></c-table>
            </box>
        </grid>
    </row>
</template>

<script>
    import data from './data';
    import components from './components';

    export default {
        el: '#app',
        components: components,
        data: data
    }
</script>
