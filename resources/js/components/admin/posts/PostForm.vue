<template>
    <form @submit.prevent="submitPost" class="mb-4">
        <div class="form-group">
            <input v-model="title" class="form-control" placeholder="Title" required />
        </div>
        <div class="form-group mt-2">
            <textarea v-model="content" class="form-control" placeholder="Content" required />
        </div>
        <button class="btn btn-primary mt-2">Create Post</button>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
const emit = defineEmits(['created']);

const title = ref('');
const content = ref('');

const submitPost = async () => {
    await axios.post('/api/admin/posts', {
        title: title.value,
        content: content.value
    });
    title.value = '';
    content.value = '';
    emit('created');
};
</script>

