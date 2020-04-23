<template>
    <timesheet-layout :heading="isCreating ? 'Create An User' : 'Update An User'">
        <template v-slot:content>
            abc
        </template>
    </timesheet-layout>
</template>

<script>
    export default {
        mounted() {
            if (this.$route.params && this.$route.params.id) {
                this.isCreating = false;
            }
        },

        data() {
            return {
                isCreating: true,
            }
        }
    }
</script>
