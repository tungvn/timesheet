<template>
    <timesheet-layout heading="Settings">
        <template v-slot:content>
            <setting-form/>
        </template>
    </timesheet-layout>
</template>

<script>
    import SettingForm from "components/SettingForm";

    export default {
        components: {
            SettingForm,
        },
    }
</script>
