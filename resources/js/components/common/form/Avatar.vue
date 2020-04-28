<template>
    <div class="input-group align-items-center">
        <div class="pull-left image mr-3" v-if="showUrl">
            <img :src="showUrl" class="img-size-64" alt="Avatar">
        </div>
        <input type="file" class="d-none" :id="inputId" v-on:change="handleSelectFile">
        <label class="btn btn-sm btn-outline-secondary" :for="inputId">Choose file</label>
        <button v-if="!!$attrs.value" class="btn btn-sm btn-outline-danger mb-2 ml-2" @click="removeAvatar">Remove</button>
    </div>
</template>

<script>
    export default {
        props: {
            inputId: {
                type: String,
                required: true,
            },

            url: {
                type: String,
                required: true,
            },
        },

        computed: {
            showUrl() {
                return this.$attrs.value ? this.inlineUrl : null;
            },

            inlineUrl: {
                get() {
                    return this.inline || this.url;
                },
                set(url) {
                    this.inline = url;
                }
            }
        },

        data() {
            return {
                inline: '',
            }
        },

        methods: {
            handleSelectFile(event) {
                const file = event.target.files[0];
                this.$emit('input', file);

                const reader = new FileReader();
                reader.onload = (e) => {
                    this.inline = e.target.result;
                };

                reader.readAsDataURL(file);
            },

            removeAvatar() {
                this.inlineUrl = null;
                this.$emit('input', null);
            },
        }
    }
</script>
