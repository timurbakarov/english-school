export default {
    props: {
        lg: {
            default: 12,
            type: Number
        },
        md: {
            default: 12,
            type: Number
        },
        sm: {
            default: 12,
            type: Number
        }
    },
    template: '<div :class="[lgClass, mdClass, smClass]"><slot></slot></div>',
    computed: {
        lgClass: function() {
            return 'col-lg-' + this.lg;
        },
        mdClass: function () {
            return 'col-md-' + this.md;
        },
        smClass: function() {
            return 'col-sm-' + this.sm;
        }
    }
}
