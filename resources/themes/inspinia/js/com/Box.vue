<template>
    <div class="ibox">

        <div class="ibox-title" v-if="title">
            <div v-html="renderTitle" ></div>

            <div class="ibox-tools" v-if="hasTools">
                <slot name="tools"></slot>
            </div>
        </div>

        <div class="ibox-content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String
            },
            titleImportance: {
                type: Number,
                default: 2
            }
        },
        computed: {
            hasTools() {
                return this.$slots.tools;
            },
            renderTitle() {
                return this.renderHeaderTag(this.title, this.titleImportance);
            }
        },
        methods: {
            renderHeaderTag(content, importance) {
                return '<h' + importance + '>' + content + '</h' + importance + '>';
            }
        }
    }
</script>
