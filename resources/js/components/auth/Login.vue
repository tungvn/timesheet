<template>
    <div class="card">
        <div class="card-body login-card-body">
            <form @submit.prevent="onSubmit">
                <timesheet-field has-icon icon-name="envelope">
                    <input type="text" class="form-control" placeholder="Email" v-model="form.username" />
                </timesheet-field>
                <timesheet-field has-icon icon-name="lock">
                    <input type="password" class="form-control" placeholder="Password" v-model="form.password" />
                </timesheet-field>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ isSubmit ? 'Logging...' : 'Login' }}
                        </button>
                    </div>
                </div>
            </form>

            <p class="mb-1">
                <a href="/password/reset">I forgot my password</a>
            </p>
            <p class="mb-0">
                <RouterLink to="register" class="text-center">Register a new account</RouterLink>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    grant_type: 'password',
                    client_id: process.env.MIX_CLIENT_ID,
                    client_secret: process.env.MIX_CLIENT_SECRET,
                    username: '',
                    password: '',
                }),
                isSubmit: false,
            }
        },

        methods: {
            onSubmit() {
                this.isSubmit = true;
                this.$store.dispatch('login', this.form)
                    .then(() => {
                        this.isSubmit = false;
                        this.$router.push('dashboard');
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
