<template>
    <div class="input-group mb-3">
        <slot></slot>

        <div v-if="hasIcon" class="input-group-append">
            <div class="input-group-text">
                <timesheet-icon :name="iconName" />
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Field",

        props: {
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
