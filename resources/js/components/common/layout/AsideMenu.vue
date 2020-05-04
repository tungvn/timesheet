<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <router-link to="/" class="brand-link">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </router-link>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link to="/me" class="nav-link" exact exact-active-class="active">
                            <icon icon="user"/>
                            <span>Account</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/me/timesheets" exact exact-active-class="active">
                            <icon icon="calendar-alt"/>
                            <span>My Timesheets</span>
                        </router-link>
                    </li>
                </ul>
            </div>

            <nav class="mt-2 mb-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link to="/dashboard" class="nav-link" exact exact-active-class="active">
                            <icon icon="tachometer-alt"/>
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="isAdmin">
                        <router-link to="/users" class="nav-link" exact exact-active-class="active">
                            <icon icon="users"/>
                            <span>User Management</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" exact exact-active-class="active" to="/timesheets">
                            <icon icon="calendar-alt"/>
                            <span>Timesheet Management</span>
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="isAdmin">
                        <router-link class="nav-link" exact exact-active-class="active" to="/settings">
                            <icon icon="cogs"/>
                            <span>Settings</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="btn btn-outline-secondary btn-block"
                            @click="openModal"
                        >
                            Logout
                        </button>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->

        <transition name="fade">
            <timesheet-modal
                :show="showConfirmModal"
                @close="closeModal"
                @ok="logout"
                id="modal-delete"
                title="Delete Item?"
                v-if="showConfirmModal"
            >
                <p>Are you sure to log out?</p>
            </timesheet-modal>
        </transition>
    </aside>
</template>

<script>
    import {mapGetters} from "vuex";
    import {ROLE_ADMIN} from "common/constant";

    export default {
        computed: {
            ...mapGetters([
                'account',
            ]),

            isAdmin() {
                return (this.account && this.account.role === ROLE_ADMIN) || false;
            },
        },

        data() {
            return {
                showConfirmModal: false,
            }
        },

        methods: {
            openModal() {
                this.showConfirmModal = true;
            },

            closeModal() {
                this.showConfirmModal = false;
            },

            logout() {
                this.$store.dispatch('logout')
                    .then(response => (this.$router.push('/')));
            },
        },
    }
</script>
