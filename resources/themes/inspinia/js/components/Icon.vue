<template>
    <i class="c-icon" :class="iconClass"></i>
</template>

<script>
    export default {
        name: 'Icon',
        props: ['type'],
        computed: {
            iconClass() {
                return ['fa', 'fa-' + (this.type ? this.type : 'pencil')];
            }
        }
    }
</script>
