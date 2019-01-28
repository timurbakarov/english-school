export default {
    props: {
        title: {
            type: String
        },
        size: {
            default: 5,
            type: Number
        }
    },
    template: '<div class="ibox-title"><div v-html="content"></div><div class="ibox-tools"><slot></slot></div></div>',
    computed: {
        content: function() {
            return '<h' + this.size + '>' +this.title + '</h' + this.size + '>';
        }
    }
}
