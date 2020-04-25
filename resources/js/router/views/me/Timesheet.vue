<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">My Timesheet</h3>
            </div>
            <div class="card-body p-0">
                <timesheet-table
                    :api-url="api.myTimesheet"
                    :delete-func="deleteItem"
                    :fields="fields"
                    :link-to="(id) => `/me/timesheet/${id}`"
                />
            </div>
        </div>
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
                        name: 'approved_at',
                        title: 'Approved',
                        formatter: (value) => {
                            return value ? 'Approved' : '';
                        },
                    },
                    {
                        name: 'created_at',
                        title: 'Created At',
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
