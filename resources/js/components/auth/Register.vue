<template>
    <div class="card">
        <div class="card-body register-card-body">
            <form @submit.prevent="onSubmit" class="mb-3">
                <timesheet-field has-icon icon-name="user">
                    <input type="text" class="form-control" placeholder="Username" v-model="form.username"/>
                </timesheet-field>
                <timesheet-field has-icon icon-name="envelope">
                    <input type="email" class="form-control" placeholder="Email" v-model="form.email"/>
                </timesheet-field>
                <timesheet-field has-icon icon-name="lock">
                    <input type="password" class="form-control" placeholder="Password" v-model="form.password"/>
                </timesheet-field>
                <timesheet-field has-icon icon-name="lock">
                    <input type="password" class="form-control" placeholder="Password Confirmation" v-model="form.password_confirmation"/>
                </timesheet-field>
                <div class="row">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ isSubmit ? 'Waiting...' : 'Register' }}
                    </button>
                </div>
            </form>

            <p class="mb-0 text-center">
                <RouterLink to="/" class="text-center">Go to Login</RouterLink>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                }),
                isSubmit: false,
            }
        },

        methods: {
            onSubmit() {
                this.isSubmit = true;

                this.$store.dispatch('register', this.form)
                    .then((response) => {
                        this.$toasted.show(response.data.message);
                    })
                    .catch((error) => {
                        this.isSubmit = false;

                        if (error && error.response && error.response.status === 422) {
                            return Promise.reject(error);
                        }

                        const message = error && error.response && error.response.data && error.response.data.message || null;
                        if (message) {
                            this.$toasted.error(message);
                        }
                    });
            },
        }
    }
</script>
