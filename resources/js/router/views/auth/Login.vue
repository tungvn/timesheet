<template>
    <sign-in-out-wrapper>
        <login />
    </sign-in-out-wrapper>
</template>

<script>
    import SignInOutWrapper from 'components/auth/SignInOutWrapper';
    import Login from 'components/auth/Login';

    export default {
        components: {
            SignInOutWrapper,
            Login,
        },
    }
</script>
