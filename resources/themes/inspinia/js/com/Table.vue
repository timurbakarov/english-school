<template>
    <div>
        <row>
            <grid :size="1/3">
                <div style="margin-bottom: 10px;" v-if="hasMassActions() && hasData()">
                    <span v-for="action in massActions"
                          class="btn btn-xs btn-secondary btn-disabled"
                          :class="massActionBtnClass"
                          @click="massAction(action)"
                    >
                        {{ action.label }}
                    </span>
                </div>
            </grid>

            <grid :size="1/3">
                Filter
            </grid>

            <grid :size="1/3">
                <form>
                    <div class="input-group">
                        <input placeholder="Search" name="search" type="text" v-model="search.query" class="form-control form-control-sm">
                        <span class="input-group-append">
                        <button type="submit" class="btn btn-sm btn-primary">Go!</button>
                        <a href="#" class="btn btn-sm btn-secondary" @click.prevent="search.query = ''">Clear</a>
                    </span>
                    </div>
                </form>
            </grid>
        </row>

        <div class="full-height-scroll">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead v-if="columns && hasData()">
                        <tr>
                            <th v-if="selectableRows" width="1">
                                <checkbox @checkbox-changed="triggerRowSelection()" />
                            </th>
                            <th v-for="column in columns">{{ column.label }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="row in rows">
                            <td v-if="selectableRows">
                                <label class="container">
                                    <input v-model="checkboxes"
                                           type="checkbox"
                                           :value="row.id"
                                    />
                                    <span class="checkmark"></span>
                                </label>
                            </td>

                            <td v-for="column in columns">
                                <template v-if="hasComponent(column)">
                                    <component :is="column.component.name" v-bind="column.component.data(column, row)" />
                                </template>

                                <template v-else-if="hasPresenter(column)">
                                    <div v-html="column.presenter(column, row)"></div>
                                </template>

                                <template v-else>
                                    {{ row[column.id] }}
                                </template>
                            </td>
                        </tr>

                        <div v-if="!hasData()">Нет данных</div>
                    </tbody>

                    <tfoot v-if="$slots.footer">
                    <slot name="footer"></slot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import Checkbox from './Checkbox';
    import ajax from './../com/ajax';
    import {Layout} from './../Components';

    export default {
        props: [
            'columns',
            'data',
            'selectableRows',
            'massActions',
            'search'
        ],
        components: _.assignIn(Layout, {
            Checkbox
        }),
        data() {
            return {
                checkboxes: [],
                rows: [],
                search: ''
            };
        },
        created() {
            this.rows = this.data;
        },
        computed: {
            massActionBtnClass() {
                return this.checkboxes.length ? [] : ['btn-outline'];
            }
        },
        methods: {
            hasData() {
                return this.rows.length;
            },
            hasComponent(column) {
                return column.hasOwnProperty('component')
            },
            hasPresenter(column) {
                return column.hasOwnProperty('presenter')
            },
            triggerRowSelection() {
                this.allRowsSelected = !this.allRowsSelected;

                let self = this;

                _.forIn(this.data, (row, key) => {
                    if (self.allRowsSelected) {
                        self.checkboxes.push(row.id);
                    } else {
                        self.checkboxes = [];
                    }
                });
            },
            hasMassActions() {
                return this.massActions.length;
            },
            massAction(action) {
                if(!this.checkboxes.length) {
                    return;
                }

                let self = this;

                ajax.post(action.url, {
                    ids: this.checkboxes
                }).then(() => {
                    action.onAction(self, self.checkboxes);
                }).catch(() => {

                });
            },
            hasRowSelected() {
                if(!this.$el) {
                    return false;
                }

                let elements = this.$el.getElementsByClassName('mass-action-checkbox');

                for (let index in elements) {
                    if(elements[index].checked) {
                        return true;
                    }
                }

                return false;
            }
        }
    }
</script>
