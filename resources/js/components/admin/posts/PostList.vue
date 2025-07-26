<template>
    <div>
        <div v-for="post in posts" :key="post.id" class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">
                    <input v-model="post.title" class="form-control" />
                </h5>
                <textarea v-model="post.content" class="form-control mt-2" />
                <div class="mt-2">
                    <button @click="updatePost(post)" class="btn btn-success btn-sm me-2">Update</button>
                    <button @click="deletePost(post.id)" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
const props = defineProps({ posts: Array });
const emit = defineEmits(['deleted', 'updated']);

const deletePost = async (id) => {
    await axios.delete(`/api/admin/posts/${id}`);
    emit('deleted');
};

const updatePost = async (post) => {
    await axios.put(`/api/admin/posts/${post.id}`, {
        title: post.title,
        content: post.content,
    });
    emit('updated');
};
</script>

