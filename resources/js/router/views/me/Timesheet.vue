<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex">
                <div class="row w-100">
                    <div class="col-md-6 d-flex align-items-center">
                        <h3 class="card-title">My Timesheet</h3>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <router-link class="btn btn-primary" to="/me/timesheet">Create Timesheet</router-link>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <timesheet-table
                    :api-url="api.myTimesheet"
                    :delete-func="deleteItem"
                    :fields="fields"
                    :link-to="(id) => `/me/timesheet/${id}`"
                >
                    <template v-slot:filter="slotProps">
                        <div class="col-12 mt-3">
                            <date-range-filter :params="slotProps.params" :filter="slotProps.filter" />
                        </div>
                    </template>
                </timesheet-table>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    import {STATUS_APPROVED, STATUS_CHANGED} from "common/constant";
    import DateRangeFilter from "components/common/table/DateRangeFilter";

    export default {
        components: {
            DateRangeFilter,
        },

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
                        name: 'status',
                        formatter: (value) => {
                            switch (value) {
                                case STATUS_APPROVED: return 'Approved';
                                case STATUS_CHANGED: return 'Changed';
                                default: return '';
                            }
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
                return this.$store.dispatch('deleteMyTimesheet', id);
            }
        }
    }
</script>
