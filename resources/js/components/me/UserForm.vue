<template>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">User Information</h3>
            </div>
            <form role="form" @submit.prevent="submit">
                <div class="card-body">
                    <timesheet-form-group
                        :has-error="form.hasError('username')"
                        :message="form.getError('username')"
                    >
                        <label for="username">Username</label>
                        <input type="username" class="form-control" id="username" :disabled="!isAdmin" v-model="form.username">
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('email')"
                        :message="form.getError('email')"
                    >
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" :disabled="!isAdmin" v-model="form.email">
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('description')"
                        :message="form.getError('description')"
                    >
                        <label for="description">Description</label>
                        <textarea class="form-control" rows="3" id="description" name="description" v-model="form.description"/>
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('avatar')"
                        :message="form.getError('avatar')"
                    >
                        <label for="avatar">Avatar</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="avatar">
                                <label class="custom-file-label" for="avatar">Choose file</label>
                            </div>
                        </div>
                    </timesheet-form-group>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="isSubmit">
                        {{ isSubmit ? 'Saving...' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import {ROLE_ADMIN} from "common/constant";
    import request from "common/request";

    export default {
        mounted() {
            if (this.account && this.account.id) {
                this.form.setInitialValues(this.account);
                this.form.populate(this.account);
            }
        },

        computed: {
            ...mapGetters([
                'account',
            ]),

            isAdmin() {
                return (this.account && this.account.role === ROLE_ADMIN) || false;
            },
        },

        watch: {
            account(newValue, oldValue) {
                if (!oldValue && newValue) {
                    this.form.setInitialValues(newValue);
                }

                this.form.populate(newValue);
            }
        },

        data() {
            return {
                form: new Form({
                    username: null,
                    email: null,
                    role: null,
                    leader_id: null,
                    avatar: null,
                    description: null,
                }, {
                    http: request,
                }),

                isSubmit: false,
            }
        },

        methods: {
            submit() {
                this.isSubmit = true;

                this.$store.dispatch('updateMe', this.form)
                    .then(() => {
                        this.$toasted.success('Update successful');
                    })
                    .finally(() => {
                        this.isSubmit = false;
                    })
            }
        }
    }
</script>
