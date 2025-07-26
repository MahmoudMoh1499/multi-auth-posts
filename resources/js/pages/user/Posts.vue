<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Posts</h2>
            <router-link to="/user/posts/create" class="btn btn-success">
                Create New Post
            </router-link>
        </div>

        <div v-if="loading" class="text-center my-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="post in posts" :key="post.id">
                            <td>{{ post.title }}</td>
                            <td>
                                <span :class="`badge bg-${post.status === 'published' ? 'success' : 'warning'}`">
                                    {{ post.status }}
                                </span>
                            </td>
                            <td>{{ formatDate(post.created_at) }}</td>
                            <td>
                                <router-link :to="`/user/posts/${post.id}/edit`" class="btn btn-sm btn-primary me-2">
                                    Edit
                                </router-link>
                                <button @click="deletePost(post.id)" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <nav v-if="pagination.last_page > 1" aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item" :class="{ disabled: pagination.current_page === 1 }">
                        <button class="page-link" @click="fetchPosts(pagination.current_page - 1)">Previous</button>
                    </li>
                    <li v-for="page in pagination.last_page" :key="page" class="page-item"
                        :class="{ active: pagination.current_page === page }">
                        <button class="page-link" @click="fetchPosts(page)">{{ page }}</button>
                    </li>
                    <li class="page-item" :class="{ disabled: pagination.current_page === pagination.last_page }">
                        <button class="page-link" @click="fetchPosts(pagination.current_page + 1)">Next</button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    setup() {
        const posts = ref([]);
        const loading = ref(true);
        const pagination = ref({
            current_page: 1,
            last_page: 1,
        });
        const router = useRouter();

        const fetchPosts = async (page = 1) => {
            try {
                loading.value = true;
                const response = await axios.get(`/user/posts?page=${page}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('user_token')}`
                    }
                });
                posts.value = response.data.data;
                pagination.value = {
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                };
            } catch (error) {
                console.error(error);
                if (error.response?.status === 401) {
                    router.push('/user/login');
                }
            } finally {
                loading.value = false;
            }
        };

        const deletePost = async (id) => {
            if (confirm('Are you sure you want to delete this post?')) {
                try {
                    await axios.delete(`/user/posts/${id}`, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('user_token')}`
                        }
                    });
                    fetchPosts(pagination.value.current_page);
                } catch (error) {
                    console.error(error);
                }
            }
        };

        const formatDate = (dateString) => {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        };

        onMounted(() => {
            fetchPosts();
        });

        return { posts, loading, pagination, fetchPosts, deletePost, formatDate };
    }
};
</script>
