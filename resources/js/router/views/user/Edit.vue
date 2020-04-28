<template>
    <timesheet-layout :heading="isCreating ? 'Create An User' : 'Update An User'">
        <template v-slot:content>
            <user-form/>
        </template>
    </timesheet-layout>
</template>

<script>
    import UserForm from 'components/user/UserForm';

    export default {
        components: {
            UserForm,
        },

        computed: {
            isCreating() {
                return !(this.$route.params && this.$route.params.id);
            }
        }
    }
</script>
