<template>
    <div class="modal fade" :class="show ? 'show' : ''" :style="{display: show ? 'flex' : 'none'}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer justify-content-between">
                    <button v-if="showCloseButton" type="button" class="btn btn-outline-secondary" data-dismiss="modal"
                            v-text="closeLabel" @click="handleClose"></button>
                    <button type="button" class="btn btn-outline-primary" v-text="okLabel" @click="handleOk"></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            show: {
                type: Boolean,
                default: false,
            },
            title: {
                type: String,
                require: true,
            },
            showCloseButton: {
                type: Boolean,
                default: true,
            },
            closeLabel: {
                type: String,
                default: 'Close',
            },
            okLabel: {
                type: String,
                default: 'OK',
            },
        },

        methods: {
            handleOk() {
                this.$emit('ok');
            },
            handleClose() {
                this.$emit('close');
            }
        }
    }
</script>
