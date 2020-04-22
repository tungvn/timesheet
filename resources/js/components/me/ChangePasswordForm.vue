<template>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Change Password</h3>
            </div>
            <form role="form" @submit.prevent="submit">
                <div class="card-body">
                    <timesheet-form-group
                        :has-error="form.hasError('password')"
                        :message="form.getError('password')"
                    >
                        <label for="password">Old Password</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('new_password')"
                        :message="form.getError('new_password')"
                    >
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" v-model="form.new_password">
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('new_password_confirmation')"
                        :message="form.getError('new_password_confirmation')"
                    >
                        <label for="new_password_confirmation">Confirmation</label>
                        <input type="password" class="form-control" id="new_password_confirmation" v-model="form.new_password_confirmation">
                    </timesheet-form-group>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="isSubmit">
                        {{ isSubmit ? 'Changing...' : 'Change Password' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import request from "common/request";

    export default {
        data() {
            return {
                form: new Form({
                    password: '',
                    new_password: '',
                    new_password_confirmation: '',
                }, {
                    http: request,
                }),

                isSubmit: false,
            }
        },

        methods: {
            submit() {
                this.isSubmit = true;

                this.$store.dispatch('changePassword', this.form)
                    .then(() => {
                        this.$toasted.success('Password changed');
                        this.form.reset();
                    })
                    .finally(() => {
                        this.isSubmit = false;
                    });
            }
        }
    }
</script>
