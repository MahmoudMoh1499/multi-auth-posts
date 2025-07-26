<template>
    <div class="space-y-4">
        <div v-for="post in posts" :key="post.id" class="p-4 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold">{{ post.title }}</h3>
            <p class="text-gray-600">{{ post.content }}</p>
            <span class="inline-block px-2 py-1 text-xs text-white bg-blue-500 rounded-full">
                {{ post.status }}
            </span>
            <div v-if="canEdit(post)" class="mt-2 space-x-2">
                <button @click="editPost(post)" class="px-3 py-1 text-sm text-white bg-green-600 rounded">Edit</button>
                <button @click="deletePost(post)"
                    class="px-3 py-1 text-sm text-white bg-red-600 rounded">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        posts: Array,
        canEdit: Function,
    },
    emits: ['edit', 'delete'],
    methods: {
        editPost(post) {
            this.$emit('edit', post);
        },
        deletePost(post) {
            this.$emit('delete', post);
        },
    },
};
</script>
