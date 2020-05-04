<template>
    <sign-in-out-wrapper :is-login-page="false">
        <register />
    </sign-in-out-wrapper>
</template>

<script>
    import SignInOutWrapper from 'components/auth/SignInOutWrapper';
    import Register from 'components/auth/Register';

    export default {
        components: {
            SignInOutWrapper,
            Register,
        },
    }
</script>
