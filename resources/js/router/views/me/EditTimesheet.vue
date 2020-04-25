<template>
    <timesheet-form/>
</template>

<script>
    import TimesheetForm from 'components/timesheet/TimesheetForm';

    export default {
        components: {
            TimesheetForm,
        },

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
