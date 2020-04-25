<template>
    <div class="col-12">
        <div class="row">
            <user-form/>
            <change-password-form/>
        </div>
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
