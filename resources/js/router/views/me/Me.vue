<template>
    <div>
        <user-form/>
        <change-password-form/>
    </div>
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
