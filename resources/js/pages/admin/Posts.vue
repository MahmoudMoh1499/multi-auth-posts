<template>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4">Posts Management</h1>
            <button @click="createPost" class="btn btn-primary">
                Create New Post
            </button>
        </div>

        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <input v-model="searchQuery" type="text" placeholder="Search posts..." class="form-control" />
            </div>
            <div class="col-md-4">
                <select v-model="statusFilter" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>

        <div class="table-responsive bg-white rounded shadow-sm">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in filteredPosts" :key="post.id">
                        <td>{{ post.title }}</td>
                        <td>{{ post.user.name }}</td>
                        <td>
                            <span :class="{
                                'badge bg-success': post.status === 'published',
                                'badge bg-warning text-dark': post.status === 'draft'
                            }">
                                {{ post.status }}
                            </span>
                        </td>
                        <td>{{ formatDate(post.created_at) }}</td>
                        <td>
                            <button @click="editPost(post)" class="btn btn-sm btn-outline-primary me-2">Edit</button>
                            <button @click="deletePost(post)" class="btn btn-sm btn-outline-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <button class="btn btn-outline-secondary" :disabled="currentPage === 1" @click="prevPage">Previous</button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button class="btn btn-outline-secondary" :disabled="currentPage === totalPages"
                @click="nextPage">Next</button>
        </div>

        <!-- Modal -->
        <PostModal :visible="showModal" :post="selectedPost" @close="closeModal" @created="handleSave"
            @updated="handleSave" />
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import axios from 'axios';
import PostModal from '@/components/PostModal.vue';

const posts = ref([]);
const showModal = ref(false);
const selectedPost = ref(null);
const searchQuery = ref('');
const statusFilter = ref('');
const currentPage = ref(1);
const perPage = ref(10);
const totalPosts = ref(0);

const fetchPosts = async () => {
    try {
        const response = await axios.get('/admin/posts', {
            params: {
                page: currentPage.value,
                per_page: perPage.value,
                search: searchQuery.value,
                status: statusFilter.value
            }
        });

        posts.value = response.data.data;
        totalPosts.value = response.data.meta.total;
        perPage.value = response.data.meta.per_page;
        currentPage.value = response.data.meta.current_page;
    } catch (error) {
        console.error('Error fetching posts:', error);
    }
};

const createPost = () => {
    selectedPost.value = null;
    showModal.value = true;
};

const editPost = (post) => {
    selectedPost.value = { ...post };
    showModal.value = true;
};

const deletePost = async (post) => {
    if (confirm('Are you sure you want to delete this post?')) {
        try {
            await axios.delete(`/admin/posts/${post.id}`);
            await fetchPosts();
        } catch (error) {
            console.error('Error deleting post:', error);
        }
    }
};

const handleSave = async () => {
    await fetchPosts();
    closeModal();
};

const closeModal = () => {
    showModal.value = false;
    selectedPost.value = null;
};

const filteredPosts = computed(() => {
    return posts.value.filter(post => {
        const matchesSearch =
            post.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            post.content.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesStatus = statusFilter.value ? post.status === statusFilter.value : true;
        return matchesSearch && matchesStatus;
    });
});

const totalPages = computed(() => Math.ceil(totalPosts.value / perPage.value));

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        fetchPosts();
    }
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        fetchPosts();
    }
};

const formatDate = (dateString) => new Date(dateString).toLocaleDateString();

onMounted(fetchPosts);

watch([searchQuery, statusFilter], () => {
    currentPage.value = 1;
    fetchPosts();
});
</script>
