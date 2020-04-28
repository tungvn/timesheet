<template>
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="avatar" v-on:change="handleSelectFile">
            <label class="custom-file-label" for="avatar">Choose file</label>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            handleSelectFile(event) {
                this.$emit('input', event.target.files[0]);
            },
        }
    }
</script>
