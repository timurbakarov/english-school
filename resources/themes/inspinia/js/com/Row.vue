<template>
        <div class="wrapper wrapper-content" v-if="showWrapper">
            <div class="row">
                <slot></slot>
            </div>
        </div>

        <div class="row" v-else>
            <slot></slot>
        </div>
</template>

<script>
    export default {
        props: ['showWrapper']
    }
</script>
