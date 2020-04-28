<template>
    <v-select
        :filterable="false"
        :options="options"
        :value="$attrs.value"
        :disabled="$attrs.disabled || false"
        @search="onSearch"
        @input="emitParent"
    >
        <template slot="no-options">
            {{ !keySearch ? noOptionsPlaceholder : 'No items found' }}
        </template>
        <template slot="selected-option" slot-scope="option">
            {{ option.label }}
        </template>
    </v-select>
</template>

<script>
    import VSelect from 'vue-select';
    import request from "common/request";
    import 'vue-select/dist/vue-select.css';

    export default {
        components: {
            VSelect,
        },

        props: {
            api: {
                type: String,
                required: true,
            },

            params: {
                type: Object,
                default() {
                    return {}
                }
            },

            noOptionsPlaceholder: {
                type: String,
                default: 'Type to search...',
            },
        },

        data() {
            return {
                options: [],
                keySearch: null,
            };
        },

        methods: {
            onSearch(search, loading) {
                loading(true);
                this.keySearch = search;
                this.search(loading, search, this);
            },

            search: _.debounce((loading, search, vm) => {
                request.get(vm.api, {
                    params: {
                        ...vm.params || {},
                        s: search,
                    },
                })
                    .then((response) => {
                        vm.options = response.data.data || [];
                        loading(false);
                    });
            }, 350),

            emitParent(data) {
                this.$emit('input', data || null);
                this.keySearch = null;
            }
        },
    }
</script>
