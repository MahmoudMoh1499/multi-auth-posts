<template>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark border-right" id="sidebar-wrapper">
            <div class="sidebar-heading text-white">Admin Panel</div>
            <div class="list-group list-group-flush">
                <router-link to="/admin/dashboard" class="list-group-item list-group-item-action bg-dark text-white"
                    active-class="active">
                    Dashboard
                </router-link>
                <router-link to="/admin/posts" class="list-group-item list-group-item-action bg-dark text-white"
                    active-class="active">
                    Posts Management
                </router-link>
                <!-- Add more menu items here -->
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <AdminNavbar />

            <div class="container-fluid px-4">
                <router-view />
            </div>
        </div>
    </div>
</template>

<script setup>
import AdminNavbar from '@/components/admin/AdminNavbar.vue'
</script>

<style scoped>
#wrapper {
    min-height: 100vh;
}

#sidebar-wrapper {
    min-width: 250px;
    transition: margin 0.25s ease-out;
}

#page-content-wrapper {
    min-width: 0;
    width: 100%;
}

.sidebar-heading {
    padding: 0.875rem 1.25rem;
    font-size: 1.2rem;
}

.list-group-item {
    border: none;
    border-radius: 0;
}

.list-group-item.active {
    background-color: #4e73df;
    border-color: #4e73df;
}
</style>
