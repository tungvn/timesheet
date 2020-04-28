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
                        <input type="username" class="form-control" id="username" :disabled="isUpdating"
                               v-model="form.username">
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('email')"
                        :message="form.getError('email')"
                    >
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" :disabled="isUpdating" v-model="form.email">
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('password')"
                        :message="form.getError('password')"
                    >
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </timesheet-form-group>
                    <timesheet-form-group>
                        <label for="password_confirmation">Confirmation</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               v-model="form.password_confirmation">
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('description')"
                        :message="form.getError('description')"
                    >
                        <label for="description">Description</label>
                        <textarea class="form-control" rows="3" id="description" name="description"
                                  v-model="form.description"/>
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('leader_id')"
                        :message="form.getError('leader_id')"
                    >
                        <label>Leader</label>
                        <timesheet-ajax-select
                            id="leader_id"
                            name="leader_id"
                            v-model="leader"
                            :api="api.getUserSelection"
                            :params="extendParams"
                        />
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
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    import {ROLE_ADMIN} from "common/constant";
    import request from "common/request";

    export default {
        async mounted() {
            if (this.isUpdating) {
                const user = await this.$store.dispatch('getUser', this.$route.params.id);
                if (!user) {
                    return;
                }

                this.form.setInitialValues({
                    ..._.pick(user, this.keys),
                    password: null,
                    password_confirmation: null,
                });
                this.form.populate(user);
                this.leader = user.leader ? {
                    label: user.leader.username,
                    value: user.leader.id,
                } : null;
            }
        },

        computed: {
            ...mapState({
                api: ({api}) => api,
            }),

            isUpdating() {
                return !!(this.$route.params && this.$route.params.id);
            },

            isAdmin() {
                return (this.form && this.form.role === ROLE_ADMIN) || false;
            },

            extendParams() {
                return {
                    excluded: (this.$route.params && this.$route.params.id) || null,
                };
            },
        },

        watch: {
            leader(newValue) {
                this.form.leader_id = (newValue && newValue.value) || null;
            },
        },

        data() {
            return {
                keys: [
                    'username',
                    'email',
                    'role',
                    'leader_id',
                    'avatar',
                    'description',
                    'password',
                    'password_confirmation',
                ],
                form: new Form({
                    username: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    role: null,
                    leader_id: null,
                    avatar: null,
                    description: null,
                }, {
                    http: request,
                }),
                leader: null,

                isSubmit: false,
            }
        },

        methods: {
            getSubmitHandler() {
                if (this.isUpdating) {
                    return this.$store.dispatch('updateUser', {
                        id: this.$route.params.id,
                        form: this.form,
                    });
                }

                return this.$store.dispatch('createUser', this.form);
            },

            submit() {
                this.isSubmit = true;

                this.getSubmitHandler()
                    .then((response) => {
                        this.form.setInitialValues({
                            ..._.pick(response, this.keys),
                            password: null,
                            password_confirmation: null,
                        });
                        this.form.populate(response);

                        this.$toasted.success(this.isUpdating ? 'Update successful' : 'Create successful');

                        const id = response.id;
                        if (!this.isUpdating && id) {
                            this.$router.push(`/user/${id}`, () => {
                                this.form.setInitialValues(response);
                                this.form.populate(response);
                                this.leader = response.leader ? {
                                    label: response.leader.username,
                                    value: response.leader.id,
                                } : null;
                                this.isSubmit = false;
                            });
                        }
                    })
                    .finally(() => {
                        this.isSubmit = false;
                    })
            }
        }
    }
</script>
