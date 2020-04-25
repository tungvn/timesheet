<template>
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Information</h3>
            </div>
            <form @submit.prevent="submit" role="form">
                <div class="card-body">
                    <timesheet-form-group
                        :has-error="form.hasError('date')"
                        :message="form.getError('date')"
                    >
                        <label for="date">Date</label>
                        <timesheet-field>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <icon icon="calendar-alt"/>
                                </span>
                            </div>
                            <cleave :options="{date: true, datePattern: ['Y', 'm', 'd'], delimiter: '-'}" :raw="false"
                                    class="form-control" id="date" placeholder="yyyy-mm-dd"
                                    type="text"
                                    v-model="form.date"/>
                        </timesheet-field>
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('doing')"
                        :message="form.getError('doing')"
                    >
                        <label>Doing Tasks</label>
                    </timesheet-form-group>

                    <div class="pl-4 mb-3">
                        <timesheet-field
                            :key="key"
                            class="input-group-sm"
                            v-for="(task, key) in form.doing"
                        >
                            <div class="input-group-prepend">
                                <span class="input-group-text">Task {{ key + 1 }}</span>
                            </div>
                            <input class="form-control" placeholder="Task ID" type="text"
                                   v-model="form.doing[key].task_id"/>
                            <input class="form-control" placeholder="Task Content" type="text"
                                   v-model="form.doing[key].content"/>
                            <input class="form-control" placeholder="Time Spend (hour)" type="text"
                                   v-model="form.doing[key].spend_time"/>
                            <div class="input-group-append">
                                <button @click="deleteTask(key)" class="btn btn-outline-secondary" type="button">
                                    <icon icon="trash"/>
                                </button>
                            </div>
                        </timesheet-field>

                        <button @click="addTask" class="btn btn-sm btn-outline-secondary" type="button">Add New Task
                        </button>
                    </div>
                    <timesheet-form-group
                        :has-error="form.hasError('problem')"
                        :message="form.getError('problem')"
                    >
                        <label for="problem">Description</label>
                        <textarea class="form-control" id="problem" name="problem" rows="3"
                                  v-model="form.problem"/>
                    </timesheet-form-group>
                    <timesheet-form-group
                        :has-error="form.hasError('plan')"
                        :message="form.getError('plan')"
                    >
                        <label for="plan">Next Plan</label>
                        <textarea class="form-control" id="plan" name="plan" rows="3"
                                  v-model="form.plan"/>
                    </timesheet-form-group>
                </div>

                <div class="card-footer">
                    <button :disabled="isSubmit" class="btn btn-primary" type="submit">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Cleave from 'vue-cleave-component';
    import request from "common/request";

    const defaultTask = {
        task_id: 'N/A',
        content: '',
        spend_time: '',
    };

    export default {
        components: {
            Cleave,
        },

        async mounted() {
            if (this.isUpdating) {
                const timesheet = _.pick(await this.$store.dispatch('getMyTimesheet', this.$route.params.id), this.keys);
                if (!timesheet) {
                    return;
                }

                this.form.setInitialValues(timesheet);
                this.form.populate(timesheet);
            }
        },

        computed: {
            isUpdating() {
                return !!(this.$route.params && this.$route.params.id);
            },
        },

        data() {
            return {
                keys: [
                    'date',
                    'doing',
                    'problem',
                    'plan',
                ],
                form: new Form({
                    date: null,
                    doing: [{...defaultTask}],
                    problem: null,
                    plan: null,
                }, {
                    http: request,
                }),

                isSubmit: false,
            }
        },

        methods: {
            getSubmitHandler() {
                if (this.isUpdating) {
                    return this.$store.dispatch('updateMyTimesheet', {
                        id: this.$route.params.id,
                        form: this.form,
                    });
                }

                return this.$store.dispatch('createMyTimesheet', this.form);
            },

            submit() {
                this.isSubmit = true;

                this.getSubmitHandler()
                    .then((response) => {
                        this.form.setInitialValues(response);
                        this.form.populate(response);

                        this.$toasted.success(this.isUpdating ? 'Update successful' : 'Create successful');

                        const id = response.id;
                        if (!this.isUpdating && id) {
                            this.$router.push(`/me/timesheet/${id}`, () => {
                                this.form.setInitialValues(response);
                                this.form.populate(response);
                                this.isSubmit = false;
                            });
                        }
                    })
                    .finally(() => {
                        this.isSubmit = false;
                    })
            },

            addTask() {
                this.form.doing.push({...defaultTask});
            },

            deleteTask(key) {
                this.form.doing.splice(key, 1);
            },
        }
    }
</script>
