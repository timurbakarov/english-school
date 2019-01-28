<template>
    <div>
        <div v-for="(item, key) in payload">
            <strong>{{ key }}:</strong> {{ item }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['payload']
    }
</script>
