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
                            :disabled="!isAdmin"
                        />
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
                        {{ isSubmit ? 'Saving...' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import {ROLE_ADMIN} from "common/constant";
    import request from "common/request";

    export default {
        mounted() {
            if (this.account && this.account.id) {
                this.form.setInitialValues(_.pick(this.account, this.whitelist));
                this.form.populate(this.account);
                this.form._method = 'PATCH';
                this.leader = this.account.leader ? {
                    label: this.account.leader.username,
                    value: this.account.leader.id,
                } : null;
                this.avatar = this.account.avatar_url || '';
            }
        },

        computed: {
            ...mapState({
                api: ({api}) => api,
            }),

            ...mapGetters([
                'account',
            ]),

            isAdmin() {
                return (this.account && this.account.role === ROLE_ADMIN) || false;
            },

            extendParams() {
                return {
                    excluded: (this.account && this.account.id) || null,
                };
            },
        },

        watch: {
            account(newValue, oldValue) {
                if (!oldValue && newValue) {
                    this.form.setInitialValues({
                        ..._.pick(newValue, this.whitelist),
                        _method: 'PATCH',
                    });
                }

                this.form.populate(newValue);
                this.form._method = 'PATCH';
                this.leader = newValue.leader ? {
                    label: newValue.leader.username,
                    value: newValue.leader.id,
                } : null;
                this.avatar = this.account.avatar_url || '';
            },

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
                ],
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
                leader: null,
                avatar: '',

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
