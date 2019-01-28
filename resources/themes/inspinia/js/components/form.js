import Axios from "axios/index";

export default {
    'c-form': {
        props: ['action'],
        template: '<form method="POST" :action="action" @submit.prevent="onSubmit($event)"><slot></slot></form>',
        methods: {
            onSubmit(event) {
                let data = [];

                for(let i=0; i<event.target.elements.length; i++) {
                    let name = event.target.elements[i].name;
                    let value = event.target.elements[i].value;

                    if(!name) {
                        continue;
                    }

                    data[name] = value;
                }

                Axios.post(this.action, data)
                    .then(function() {
                        alert('success');
                    })
                    .catch(function() {
                        alert('catch');
                    });
            }
        }
    },
    'c-form-field': {
        props: ['label'],
        template:
            '<div class="form-group row">' +
                '<label class="col-sm-2 col-form-label">{{ label }}</label>' +
                '<div class="col-sm-10">' +
                    '<slot></slot>' +
                '</div>' +
            '</div>'
    },
    'c-form-field-text': {
        props: ['name', 'value', 'default', 'placeholder'],
        template: '<input type="text" :name="name" :value="fieldValue" :placeholder="placeholder" class="form-control">',
        computed: {
            fieldValue() {
                return this.value ? this.value : this.default;
            }
        }
    },
    'c-form-field-date': {
        props: ['name', 'value', 'default'],
        template: '<input type="date" :name="name" :value="fieldValue" class="form-control">',
        computed: {
            fieldValue() {
                return this.value ? this.value : this.default;
            }
        }
    },
}
