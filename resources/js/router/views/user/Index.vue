<template>
    <timesheet-layout heading="User Management">
        <template v-slot:header>
            <div class="d-flex justify-content-end">
                <router-link to="/user" class="btn btn-primary">Create User</router-link>
            </div>
        </template>
        <template v-slot:content>
            <div class="col-12">
                <timesheet-table
                    :fields="fields"
                    :api-url="api.user"
                    :link-to="(id) => `/user/${id}`"
                    :delete-func="deleteItem"
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
                        name: 'username',
                    },
                    {
                        name: 'email',
                    },
                    {
                        name: 'description',
                    },
                    {
                        name: 'submit_times',
                        title: 'Submit Times',
                        formatter: (value) => {
                            return value || 0;
                        },
                    },
                    {
                        name: 'late_submit_times',
                        title: 'Late',
                        formatter: (value) => {
                            return value || 0;
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
                return this.$store.dispatch('deleteUser', id);
            }
        }
    }
</script>
