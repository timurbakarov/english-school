<template>
    <a :href="url" @click="confirmation($event)" class="btn btn-white btn-sm">
        <i class="fa fa-trash" style="color: red;"></i>
    </a>
</template>

<script>
    export default {
        props: ['url'],
        methods: {
            confirmation: function(event) {
                event.preventDefault();

                let component = this;

                if(confirm('Удалить?')) {
                    let form = $('<form></form>');
                    form.attr('action', component.url);
                    form.attr('method', 'POST');
                    form.append('<input type="hidden" name="_token" value="' + APP.csrf.token + '" />');
                    $('body').append(form);
                    form.submit();
                }
            }
        }
    }
</script>
