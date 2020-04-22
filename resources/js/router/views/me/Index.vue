<template>
    <timesheet-layout heading="Account">
        <template v-slot:content>
            <user-form />

            <change-password-form />
        </template>
    </timesheet-layout>
</template>

<script>
    import UserForm from "components/me/UserForm";
    import ChangePasswordForm from "components/me/ChangePasswordForm";

    export default {
        components: {
            UserForm,
            ChangePasswordForm,
        }
    }
</script>
