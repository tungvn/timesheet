<template>
    <div class="col-12">
        <div class="alert alert-success mt-2 mb-5" role="alert" v-if="isApproved">
            The timesheet is approved
        </div>
        <div class="mb-3">
            <button :disabled="isSubmit" @click="confirmApprove" class="btn btn-primary mr-2" type="button"
                    v-if="!isApproved">
                Approve
            </button>
            <button @click="goBack" class="btn btn-secondary" type="button">
                Close
            </button>
        </div>
        <div class="card card-secondary">
            <div class="card-header">
                <h4 class="card-title">Doing Tasks</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li :key="key" class="list-group-item" v-for="(doing, key) in timesheet.doing">
                        {{ doing.task_id }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="card card-secondary">
            <div class="card-header">
                <h4 class="card-title">Problem</h4>
            </div>
            <div class="card-body">
                <div v-text="timesheet.problem"></div>
            </div>
        </div>
        <div class="card card-secondary">
            <div class="card-header">
                <h4 class="card-title">Next Plan</h4>
            </div>
            <div class="card-body">
                <div v-text="timesheet.plan"></div>
            </div>
        </div>
        <div class="mb-3">
            <button :disabled="isSubmit" @click="confirmApprove" class="btn btn-primary mr-2" type="button"
                    v-if="!isApproved">
                Approve
            </button>
            <button @click="goBack" class="btn btn-secondary" type="button">
                Close
            </button>
        </div>

        <transition name="fade">
            <timesheet-modal
                :show="showConfirmModal"
                @close="closeModal"
                @ok="approve"
                id="modal-delete"
                title="Delete Item?"
                v-if="showConfirmModal"
            >
                <p>Are you sure to approve this timesheet?</p>
            </timesheet-modal>
        </transition>
    </div>
</template>

<script>
    import {STATUS_APPROVED, STATUS_CREATED} from 'common/constant';

    export default {
        async mounted() {
            if (this.id) {
                this.timesheet = _.pick(await this.$store.dispatch('getTimesheet', this.id), this.whitelist);
            }
        },

        computed: {
            isApproved() {
                return this.timesheet.status === STATUS_APPROVED;
            }
        },

        data() {
            return {
                id: (this.$route.params && this.$route.params.id) || null,
                whitelist: [
                    'date',
                    'doing',
                    'problem',
                    'plan',
                    'status',
                ],
                timesheet: {
                    date: null,
                    doing: [],
                    problem: null,
                    plan: null,
                    status: STATUS_CREATED,
                },
                showConfirmModal: false,
                isSubmit: false,
            }
        },

        methods: {
            confirmApprove() {
                if (this.isApproved) {
                    return;
                }

                this.showConfirmModal = true;
            },

            closeModal() {
                this.showConfirmModal = false;
            },

            approve() {
                this.isSubmit = true;

                this.$store.dispatch('approveTimesheet', this.id)
                    .then((response) => {
                        this.$toasted.success(response.message);
                        this.timesheet.status = STATUS_APPROVED;
                    })
                    .finally(() => {
                        this.showConfirmModal = false;
                        this.isSubmit = true;
                    })
            },

            goBack() {
                this.$router.back();
            },
        }
    }
</script>

<style scoped>

</style>
