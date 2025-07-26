<!-- resources/js/Pages/User/Login.vue -->
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0">User Login</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="handleLogin">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input id="email" v-model="form.email" type="email" class="form-control"
                                    :class="{ 'is-invalid': errors.email }" required>
                                <div class="invalid-feedback" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" v-model="form.password" type="password" class="form-control"
                                    :class="{ 'is-invalid': errors.password }" required>
                                <div class="invalid-feedback" v-if="errors.password">
                                    {{ errors.password[0] }}
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" :disabled="loading">
                                    <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const loading = ref(false);
const errors = ref({});

const form = reactive({
    email: '',
    password: ''
});

const handleLogin = async () => {
    loading.value = true;
    errors.value = {};

    try {
        const response = await axios.post('/user/login', form);

        localStorage.setItem('user_token', response.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.user));

        router.push('/user/dashboard');
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors;
        } else if (error.response?.status === 401) {
            errors.value = { email: ['Invalid credentials'] };
        }
    } finally {
        loading.value = false;
    }
};
</script>
