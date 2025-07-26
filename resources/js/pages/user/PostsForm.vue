<template>
    <div class="card">
        <div class="card-header">
            <h4>{{ postId ? 'Edit' : 'Create' }} Post</h4>
        </div>
        <div class="card-body">
            <form @submit.prevent="submitForm">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" v-model="form.title"
                        :class="{ 'is-invalid': errors.title }">
                    <div class="invalid-feedback" v-if="errors.title">
                        {{ errors.title[0] }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" rows="5" v-model="form.content"
                        :class="{ 'is-invalid': errors.content }"></textarea>
                    <div class="invalid-feedback" v-if="errors.content">
                        {{ errors.content[0] }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="published" value="published"
                            v-model="form.status">
                        <label class="form-check-label" for="published">
                            Published
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="draft" value="draft" v-model="form.status">
                        <label class="form-check-label" for="draft">
                            Draft
                        </label>
                    </div>
                    <div class="invalid-feedback d-block" v-if="errors.status">
                        {{ errors.status[0] }}
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <router-link to="/user/posts" class="btn btn-secondary">
                        Cancel
                    </router-link>
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status"></span>
                        {{ postId ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { reactive, ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

export default {
    props: {
        postId: {
            type: [String, Number],
            default: null
        }
    },
    setup(props) {
        const route = useRoute();
        const router = useRouter();
        const loading = ref(false);
        const errors = ref({});

        const form = reactive({
            title: '',
            content: '',
            status: 'draft'
        });

        const fetchPost = async () => {
            console.log(`Fetching post with ID: ${props.postId}`);

            if (!props.postId) return;

            try {
                loading.value = true;
                const response = await axios.get(`/user/posts/${props.postId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('user_token')}`
                    }
                });
                Object.assign(form, response.data.data);
            } catch (error) {
                console.error(error);
                if (error.response?.status === 404) {
                    router.push('/user/posts');
                }
            } finally {
                loading.value = false;
            }
        };

        const submitForm = async () => {
            try {
                loading.value = true;
                errors.value = {};

                const url = props.postId
                    ? `/user/posts/${props.postId}`
                    : '/user/posts';

                const method = props.postId ? 'put' : 'post';

                await axios[method](url, form, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('user_token')}`
                    }
                });

                router.push('/user/posts');
            } catch (error) {
                if (error.response?.status === 422) {
                    errors.value = error.response.data.errors;
                } else {
                    console.error(error);
                }
            } finally {
                loading.value = false;
            }
        };

        onMounted(() => {
            fetchPost();
        });

        return { form, errors, loading, submitForm };
    }
};
</script>
