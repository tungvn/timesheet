<template>
    <div :class="isLoginPage ? 'login-page' : 'register-page'">
        <div :class="isLoginPage ? 'login-box' : 'register-box'">
            <div :class="isLoginPage ? 'login-logo' : 'register-logo'">
                Timesheet
            </div>

            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            isLoginPage: {
                type: Boolean,
                default: true,
            }
        }
    }
</script>
