<template>
    <timesheet-layout heading="Timesheet Management">
        <template v-slot:header>
            <div class="d-flex justify-content-end">
                <router-link class="btn btn-primary" to="/timesheet">Create Timesheet</router-link>
            </div>
        </template>
        <template v-slot:content>
            <div class="col-12">
                <timesheet-table
                    :api-url="api.timesheet"
                    :delete-func="deleteItem"
                    :fields="fields"
                    :link-to="(id) => `/timesheet/${id}`"
                />
            </div>
        </template>
    </timesheet-layout>
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
                        name: 'author.username',
                        title: 'Created By',
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
