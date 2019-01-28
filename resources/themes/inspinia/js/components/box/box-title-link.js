export default {
    props: ['link'],
    template: '<a class="btn btn-primary btn-xs" :href="link.url" v-text="link.label"></a>'
}
