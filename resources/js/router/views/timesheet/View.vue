<template>
    <timesheet-layout heading="Review Timesheet">
        <template v-slot:content>
            <view-timesheet/>
        </template>
    </timesheet-layout>
</template>

<script>
    import ViewTimesheet from 'components/timesheet/ViewTimesheet';

    export default {
        components: {
            ViewTimesheet,
        },
    }
</script>
