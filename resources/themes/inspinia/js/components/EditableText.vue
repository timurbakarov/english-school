<template>
    <span>
        <span
            class="editable-text"
            :class="editableTextStyleClass"
            v-if="!isEditableMode"
            @mouseover="editIconVisible = true"
            @mouseout="editIconVisible = false"
        >
            {{ originText }}

            <span @click="edit()" v-show="isEditIconVisible">
                <icon class="editable-text-icon" type="pencil" />
            </span>
        </span>

        <span v-else >
            <input ref="editabletext"
                   class="editable-text-input"
                   :class="inputStyleClass"
                   v-model="newText" type="text"
                   @blur="cancelForBlur()"
                   @focus="onFocus()"
            />

            <span @click.stop="save()">
                <icon class="editable-text-icon" type="check" />
            </span>

            <span @click.stop="cancel()">
                <icon class="editable-text-icon" type="times"/>
            </span>
        </span>

    </span>
</template>

<script>
    import Icon from './Icon';
    import notify from "./notify";
    import ajax from "./ajax";

    export default {
        name: 'EditableText',
        props: ['text', 'url', 'field'],
        data() {
            return {
                textChangedWarn: false,
                isEditableMode: false,
                editIconVisible: false,
                originText: null,
                newText: null,
                oldText: null,
                saving: false
            };
        },
        mounted() {
            this.originText = this.text;
        },
        components: {
            Icon
        },
        created() {
            this.newText = this.text;
        },
        computed: {
            inputStyleClass() {
                return this.textChangedWarn ? ['editable-text-input-warn'] : [];
            },
            isEditIconVisible() {
                return this.editIconVisible && !this.saving;
            },
            editableTextStyleClass() {
                return this.saving ? ['editable-text-while-saving'] : [];
            }
        },
        methods: {
            edit() {
                this.isEditableMode = true;
                this.textChangedWarn = false;
                this.oldText = this.originText;

                this.$nextTick(() => {
                    this.$refs.editabletext.focus();
                });
            },
            save() {
                if(!this.textChanged()) {
                    return;
                }

                if(this.newTextEmpty()) {
                    return;
                }

                let self = this;
                let data = {};

                this.saving = true;
                this.isEditableMode = false;
                this.updateText();

                data[this.field] = this.newText;

                ajax.post(this.url, data)
                    .then(() => {
                        notify.success('Изменения сохранены');

                        if(this.originText) {
                            this.editIconVisible = false;
                        }

                        self.saving = false;
                    })
                    .catch((error) => {
                        let errorsString = [];

                        if(error.response.data.hasOwnProperty('errors')) {
                            _.forIn(error.response.data.errors, function(value, key) {
                                errorsString.push(value);
                            });
                        }

                        notify.error('Ошибка', errorsString.join('<br />'));

                        self.revertText();
                        self.isEditableMode = false;
                        self.editIconVisible = false;
                        self.saving = false;
                    });
            },
            cancel() {
                this.isEditableMode = false;

                if(this.originText) {
                    this.editIconVisible = false;
                }

                this.revertText();
            },
            cancelForBlur() {
                if(this.textChanged()) {
                    this.textChangedWarn = true;
                    return;
                }

                this.cancel();
            },
            revertText() {
                this.originText = this.oldText;
                this.newText = this.oldText;
            },
            updateText() {
                this.oldText = this.originText;
                this.originText = this.newText;
            },
            textChanged() {
                return this.originText !== this.newText;
            },
            onFocus() {
                this.textChangedWarn = false;
            },
            newTextEmpty() {
                return this.newText === '';
            }
        }
    }
</script>

<style>
    .editable-text-icon {
        cursor: pointer;
    }
    .editable-text-input {
        outline: none;
        width: 100%;
        border: 1px solid gray;
        border-radius: unset;
    }
    .editable-text-input-warn {
        border-color: red;
    }
    .editable-text-while-saving {
        opacity: 0.5;
    }
</style>
