<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Admin Login</h1>
                        </div>

                        <form class="user" @submit.prevent="login">
                            <div class="form-group mb-3">
                                <input v-model="form.email" type="email" class="form-control form-control-user"
                                    placeholder="Enter Email Address..." required>
                            </div>
                            <div class="form-group mb-3">
                                <input v-model="form.password" type="password" class="form-control form-control-user"
                                    placeholder="Password" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const form = ref({
    email: '',
    password: ''
})

const login = async () => {
    try {
        const response = await axios.post('/admin/login', form.value)
        localStorage.setItem('admin_token', response.data.token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`
        router.push('/admin/dashboard')
    } catch (error) {
        console.error('Login failed:', error)
    }
}

</script>

<style scoped>
.card {
    border: none;
    border-radius: 10px;
}

.btn-user {
    border-radius: 50px;
    padding: 0.75rem 1rem;
}

.form-control-user {
    border-radius: 50px;
    padding: 1rem 1.5rem;
}
</style>
