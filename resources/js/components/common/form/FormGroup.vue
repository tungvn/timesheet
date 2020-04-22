<template>
    <div class="form-group">
        <slot></slot>

        <div v-if="hasError" class="w-100">
            <span class="text-danger text-sm" v-text="message"></span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            hasError: {
                type: Boolean,
                default: false,
            },
            message: {
                type: String,
            },
        }
    }
</script>
