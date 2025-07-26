<!-- resources/js/Pages/User/Dashboard.vue -->
<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Published Posts</h5>
                        <p class="card-text display-4">{{ stats.published_posts }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Draft Posts</h5>
                        <p class="card-text display-4">{{ stats.draft_posts }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Posts</h5>
                        <p class="card-text display-4">{{ stats.total_posts }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Recent Posts</h5>
            </div>
            <div class="card-body">
                <ul class="list-group" v-if="recentPosts.length">
                    <li v-for="post in recentPosts" :key="post.id"
                        class="list-group-item d-flex justify-content-between align-items-center">
                        {{ post.title }}
                        <span :class="`badge bg-${post.status === 'published' ? 'success' : 'warning'}`">
                            {{ post.status }}
                        </span>
                    </li>
                </ul>
                <p v-else class="text-muted">No posts yet</p>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const stats = ref({
            published_posts: 0,
            draft_posts: 0,
            total_posts: 0
        });
        const recentPosts = ref([]);
        const loading = ref(true);

        const fetchDashboardData = async () => {
            try {
                const response = await axios.get('/user/dashboard');
                stats.value = response.data.stats;
                recentPosts.value = response.data.recent_posts;
            } catch (error) {
                console.error(error);
            } finally {
                loading.value = false;
            }
        };

        onMounted(() => {
            fetchDashboardData();
        });

        return { stats, recentPosts, loading };
    }
};
</script>
