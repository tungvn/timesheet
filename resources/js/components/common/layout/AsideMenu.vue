<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <router-link to="/" class="brand-link">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </router-link>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <router-link to="/me" class="d-block nav-link">
                    <icon icon="user"/>
                    <span>Account</span>
                </router-link>
            </div>

            <nav class="mt-2 mb-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link">
                            <icon icon="tachometer-alt"/>
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/users" class="nav-link">
                            <icon icon="users"/>
                            <span>User Management</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/timesheet" class="nav-link">
                            <icon icon="calendar-alt"/>
                            <span>Timesheet Management</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="btn btn-outline-secondary btn-block"
                            @click="logout"
                        >
                            Logout
                        </button>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    export default {
        methods: {
            logout() {
                this.$store.dispatch('logout')
                    .then(response => (this.$router.push('/')));
            },
        },
    }
</script>
