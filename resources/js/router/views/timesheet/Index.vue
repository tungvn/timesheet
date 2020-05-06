<template>
    <timesheet-layout heading="Timesheet Management">
        <template v-slot:content>
            <div class="col-12">
                <timesheet-table
                    :api-url="api.timesheet"
                    :delete-func="deleteItem"
                    :fields="fields"
                    :link-to="(id) => `/timesheet/${id}`"
                >
                    <template v-slot:filter="slotProps">
                        <date-range-filter :params="slotProps.params" :filter="slotProps.filter" />
                    </template>
                </timesheet-table>
            </div>
        </template>
    </timesheet-layout>
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
                        name: 'author.username',
                        title: 'Created By',
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
                return this.$store.dispatch('deleteTimesheet', id);
            }
        }
    }
</script>
