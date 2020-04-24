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
                    :api-url="api.listUsers"
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
                        name: '__slot:actions',
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
