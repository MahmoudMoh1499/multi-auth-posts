<!-- resources/js/Layouts/UserLayout.vue -->
<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <router-link to="/user/dashboard" class="navbar-brand">User Dashboard</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <router-link to="/user/posts" class="nav-link">My Posts</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/user/posts/create" class="nav-link">New Post</router-link>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <button @click="logout" class="btn btn-outline-light">Logout</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import { useRouter } from 'vue-router';

export default {
    setup() {
        const router = useRouter();

        const logout = () => {
            localStorage.removeItem('user_token');
            localStorage.removeItem('user');
            router.push('/user/login');
        };

        return { logout };
    }
};
</script>
