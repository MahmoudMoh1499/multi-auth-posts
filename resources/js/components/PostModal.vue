<template>
    <div v-show="visible" class="modal fade show" tabindex="-1" role="dialog" @keydown.esc="closeModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ isEditMode ? 'Edit Post' : 'Create Post' }}</h5>
                    <button type="button" class="btn-close ml-auto" @click="closeModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form @submit.prevent="submitForm">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" v-model.trim="form.title" type="text" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content" v-model.trim="form.content" class="form-control" rows="5"
                                required></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                {{ isEditMode ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        post: {
            type: Object,
            default: null,
        },
        visible: {
            type: Boolean,
            required: true,
        },
    },
    emits: ['close', 'created', 'updated'],
    data() {
        return {
            form: {
                title: this.post?.title || '',
                content: this.post?.content || '',
            },
        };
    },
    computed: {
        isEditMode() {
            return !!this.post;
        },
    },
    watch: {
        post: {
            immediate: true,
            handler(newPost) {
                this.form = {
                    title: newPost?.title || '',
                    content: newPost?.content || '',
                };
            },
        },
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        async submitForm() {
            try {
                const url = this.isEditMode
                    ? `/admin/posts/${this.post.id}`
                    : '/admin/posts';

                const method = this.isEditMode ? 'put' : 'post';

                const { data } = await axios[method](url, this.form);

                this.$emit(this.isEditMode ? 'updated' : 'created', data);
                this.closeModal();
            } catch (error) {
                console.error(error);
                alert('Something went wrong while saving the post.');
            }
        },
    },
};
</script>

<style scoped>
.modal {
    display: block;
    background-color: rgba(0, 0, 0, 0.6);
    overflow-y: auto;
}

.modal-dialog {
    max-width: 600px;
}
</style>

