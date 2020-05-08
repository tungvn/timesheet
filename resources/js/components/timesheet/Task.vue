<template>
    <div class="pl-4 mb-3">
        <timesheet-field
            :key="key"
            class="input-group-sm"
            v-for="(task, key) in inlineTasks"
        >
            <div class="input-group-prepend">
                <span class="input-group-text">Task {{ key + 1 }}</span>
            </div>
            <input class="form-control" placeholder="Task ID" type="text"
                   v-model="inlineTasks[key].task_id"/>
            <input class="form-control" placeholder="Task Content" type="text"
                   v-model="inlineTasks[key].content"/>
            <input class="form-control" placeholder="Time Spend (hour)" type="text"
                   v-model="inlineTasks[key].spend_time"/>
            <div class="input-group-append">
                <button @click="deleteTask(key)" class="btn btn-outline-secondary" type="button">
                    <icon icon="trash"/>
                </button>
            </div>
        </timesheet-field>

        <button
            type="button"
            class="btn btn-sm btn-outline-secondary"
            @click="addTask"
        >Add New Task</button>
    </div>
</template>

<script>
    const defaultTask = {
        task_id: 'N/A',
        content: '',
        spend_time: '',
    };

    export default {
        props: {
            tasks: {
                type: Array,
                default() {
                    return [];
                }
            },
        },

        watch: {
            tasks(newValue, oldValue) {
                this.inlineTasks = newValue;
            }
        },

        data() {
            return {
                inlineTasks: this.tasks || [],
            };
        },

        methods: {
            addTask() {
                this.$emit('update:tasks', [
                    ...this.inlineTasks,
                    {...defaultTask},
                ]);
            },

            deleteTask(key) {
                this.inlineTasks.splice(key, 1);
                this.$emit('update:tasks', [...this.inlineTasks]);
            },
        }
    }
</script>
