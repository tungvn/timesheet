<template>
    <div class="col-12">
        <timesheet-table
            :api-url="api.myTimesheet"
            :delete-func="deleteItem"
            :fields="fields"
            :link-to="(id) => `/timesheet/${id}`"
        />
    </div>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        computed: {
            ...mapState({
                api: (state) => state.api,
            }),
        },

        data() {
            return {
                fields: [
                    {
                        name: 'date',
                    },
                    {
                        name: 'created_at',
                        title: 'Created At',
                    },
                    {
                        name: 'approved_at',
                        title: 'Approved',
                        formatter: (value) => {
                            return value ? 'Approved' : '';
                        },
                    },
                    {
                        name: 'actions',
                        title: '',
                        titleClass: 'text-right',
                        dataClass: 'action-buttons text-right',
                        width: '120px',
                    },
                ],
            }
        },

        methods: {
            deleteItem(id) {
                return this.$store.dispatch('deleteTimesheet', id);
            }
        }
    }
</script>
