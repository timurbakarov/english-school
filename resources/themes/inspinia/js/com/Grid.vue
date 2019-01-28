<template>
    <div :class="[lgClass, mdClass, smClass]"><slot></slot></div>
</template>

<script>
    export default {
        props: {
            size: {
                default: 1
            }
        },
        data() {
            return {
                width: 12
            }
        },
        computed: {
            lgClass: function() {
                return 'col-lg-' + this.size * this.width;
            },
            mdClass: function () {
                return 'col-md-' + this.size * this.width;
            },
            smClass: function() {
                return 'col-sm-' + this.size * this.width;
            }
        }
    }

</script>
