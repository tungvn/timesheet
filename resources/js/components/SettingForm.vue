<template>
    <div class="col-sm-12">
        <form :key="key" @submit.prevent="submit(form)" class="form mb-3" role="form" v-for="(form, key) in forms">
            <timesheet-field>
                <div class="input-group-prepend">
                    <span class="input-group-text">{{ key }}</span>
                </div>
                <input class="form-control" placeholder="Setting Value" type="text"
                       v-model="forms[key].value"/>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button @click="resetForm(key)" class="btn btn-secondary" type="button"
                            v-if="formHasChanges(form)">Cancel
                    </button>
                </div>
            </timesheet-field>
        </form>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import {ROLE_ADMIN} from "common/constant";
    import request from "common/request";

    export default {
        created() {
            if (this.isAdmin) {
                this.$store.dispatch('getSettings');
            }
        },

        computed: {
            ...mapGetters([
                'account',
                'settings',
            ]),

            isAdmin() {
                return (this.account && this.account.role === ROLE_ADMIN) || false;
            },
        },

        watch: {
            isAdmin(newValue, oldValue) {
                if (newValue && !oldValue) {
                    this.$store.dispatch('getSettings');
                }
            },

            settings(newSettings) {
                if (newSettings && Object.keys(newSettings).length > 0) {
                    const forms = Object.values(newSettings).reduce((forms, setting) => {
                        const key = setting.key;
                        const data = {
                            id: setting.id,
                            key,
                            value: setting.value,
                        };

                        if (!forms.hasOwnProperty(key)) {
                            forms[key] = new Form(data, {
                                http: request,
                            });
                        } else {
                            forms[key].setInitialValues(data);
                            forms[key].populate(data);
                        }

                        return forms;
                    }, {...this.forms});

                    this.forms = {...forms};
                }
            }
        },

        data() {
            return {
                whitelist: [
                    'id',
                    'key',
                    'value',
                ],
                forms: {},
            }
        },

        methods: {
            formHasChanges(form) {
                return !_.isEqual(form.data(), _.pick(form.initial, this.whitelist));
            },

            resetForm(key) {
                this.forms[key].reset();
            },

            submit(form) {
                this.$store.dispatch('updateSetting', {
                    id: form.id,
                    form,
                })
                    .then(() => {
                        this.$toasted.success('The setting is updated');
                    })
            }
        }
    }
</script>

<style scoped>

</style>
