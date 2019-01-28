<template>
    <label class="container">
        <input :name="name" type="checkbox" @change="trigger()" v-model="checked">
        <span class="checkmark"></span>
    </label>
</template>

<script>
    /**
     * Usage:
     *
     * <checkbox :default="true" :name="field_name" />
     *
     * Default - default checkbox state
     * Name - field name
     *
     * When checked throws `checkbox-changed` event
     */
    export default {
        props: ['name', 'default'],
        data() {
            return {
                checked: this.default
            };
        },
        methods: {
            trigger() {
                this.$emit('checkbox-changed');
            }
        }
    }
</script>

<style>
    .container {
        display: block;
        position: relative;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #ccc;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
        background-color: #aaa;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
        left: 8px;
        top: 4px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>
