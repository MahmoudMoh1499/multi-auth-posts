<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Users Management</h1>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posts
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in users" :key="user.id">
                        <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ user.posts_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ formatDate(user.created_at) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button @click="editUser(user)" class="text-blue-600 hover:text-blue-900 mr-2">
                                Edit
                            </button>
                            <button @click="deleteUser(user)" class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination would go here similar to Posts page -->
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const users = ref([]);

const fetchUsers = async () => {
    try {
        const response = await axios.get('/admin/users');
        users.value = response.data;
    } catch (error) {
        console.error('Error fetching users:', error);
    }
};

const editUser = (user) => {
    // Implement edit functionality
    console.log('Edit user:', user);
};

const deleteUser = async (user) => {
    if (confirm(`Are you sure you want to delete ${user.name}?`)) {
        try {
            await axios.delete(`/admin/users/${user.id}`);
            await fetchUsers();
        } catch (error) {
            console.error('Error deleting user:', error);
        }
    }
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString();
};

onMounted(fetchUsers);
</script>
