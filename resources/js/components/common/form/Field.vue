<template>
    <div class="input-group mb-3">
        <slot></slot>

        <div v-if="hasIcon" class="input-group-append">
            <div class="input-group-text">
                <icon :icon="iconName" />
            </div>
        </div>

        <div v-if="hasError" class="w-100">
            <span class="text-danger text-sm" v-text="message"></span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Field",

        props: {
            hasError: {
                type: Boolean,
                default: false,
            },
            message: {
                type: String,
            },
            hasIcon: {
                type: Boolean,
                default: false,
            },

            iconName: {
                type: String,
                default: '',
            }
        }
    }
</script>
