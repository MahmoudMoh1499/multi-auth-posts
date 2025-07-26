<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-sm" @click="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown">
                        Admin User
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><button class="dropdown-item" @click="logout">Logout</button></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

const toggleSidebar = () => {
    document.getElementById('wrapper').classList.toggle('toggled')
}

const logout = async () => {
    try {
        await axios.post('/admin/logout')
        localStorage.removeItem('')
        router.push('/admin/login')
    } catch (error) {
        console.error('Logout failed:', error)
    }
}
</script>
