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

        mounted() {
            if (this.$route.params && this.$route.params.id) {
                this.isCreating = false;
            }
        },

        data() {
            return {
                isCreating: true,
            }
        }
    }
</script>
