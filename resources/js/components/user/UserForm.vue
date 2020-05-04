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
                        :has-error="form.hasError('role')"
                        :message="form.getError('role')"
                    >
                        <label>Role</label>
                        <select
                            id="role"
                            name="role"
                            class="custom-select"
                            v-model="form.role"
                        >
                            <option
                                v-for="(displayRole, role) in roles"
                                :key="role"
                                :value="role"
                                :selected="form.role === role"
                                v-text="displayRole"
                            />
                        </select>
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('avatar')"
                        :message="form.getError('avatar')"
                    >
                        <label>Avatar</label>
                        <timesheet-avatar input-id="avatar" v-model="form.avatar" :url="avatar" />
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
    import {ROLE_ADMIN, ROLES} from "common/constant";
    import request from "common/request";

    export default {
        async mounted() {
            if (this.isUpdating) {
                const user = await this.$store.dispatch('getUser', this.$route.params.id);
                if (!user) {
                    return;
                }

                this.initialize(user);
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
                whitelist: [
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
                avatar: '',
                roles: {...ROLES},

                isSubmit: false,
            }
        },

        methods: {
            initialize(user) {
                this.form.setInitialValues({
                    _method: 'PATCH',
                    ..._.pick(user, this.whitelist),
                    password: null,
                    password_confirmation: null,
                });
                this.form.populate(user);
                this.form._method = 'PATCH';

                this.leader = user.leader ? {
                    label: user.leader.username,
                    value: user.leader.id,
                } : null;
                this.avatar = user.avatar_url || '';
            },

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
                        this.initialize(response);

                        this.$toasted.success(this.isUpdating ? 'Update successful' : 'Create successful');

                        const id = response.id;
                        if (!this.isUpdating && id) {
                            this.$router.push(`/user/${id}`, () => {
                                this.this.initialize(response);
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
