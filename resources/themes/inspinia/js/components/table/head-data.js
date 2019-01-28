export default {
    props: {
        width: {
            type: String,
            default: null
        }
    },
    template: '<th :width="width"><slot></slot></th>',
    computed: {}
}
