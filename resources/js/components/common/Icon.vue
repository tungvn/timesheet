<template>
    <span :class="`fas fa-${name}`"></span>
</template>

<script>
    export default {
        name: "Icon",

        props: {
            name: {
                type: String,
                require: true,
            }
        },
    }
</script>
