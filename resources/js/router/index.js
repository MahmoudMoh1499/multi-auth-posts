import { createRouter, createWebHistory } from 'vue-router'
import GuestLayout from '@/layouts/GuestLayout.vue'
import UserLayout from '@/layouts/UserLayout.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import axios from 'axios'

const routes = [
    // Guest routes
    {
        path: '/',
        component: GuestLayout,
        children: [
            {
                path: 'user/login',
                name: 'UserLogin',
                component: () => import('@/pages/auth/UserLogin.vue'),
            },
            {
                path: 'admin/login',
                name: 'AdminLogin',
                component: () => import('@/pages/auth/AdminLogin.vue'),
            },
        ],
    },

    // User routes
    {
        path: '/user',
        component: UserLayout,
        meta: { requiresAuth: true, role: 'user' },
        children: [
            {
                path: 'dashboard',
                name: 'UserDashboard',
                component: () => import('@/pages/user/Dashboard.vue'),
            },
            {
                path: 'posts',
                name: 'UserPosts',
                component: () => import('@/pages/user/Posts.vue'),
            },
            {
                path: 'posts/create',
                name: 'user.posts.create',
                component: () => import('@/Pages/user/PostsForm.vue'),
            },
            {
                path: 'posts/:id/edit',
                name: 'user.posts.edit',
                component: () => import('@/Pages/user/PostsForm.vue'),
                props: route => ({ postId: route.params.id })
            },
        ],
    },

    // Admin routes
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true, role: 'admin' },
        children: [
            {
                path: 'dashboard',
                name: 'AdminDashboard',
                component: () => import('@/pages/admin/Dashboard.vue'),
            },
            {
                path: 'posts',
                name: 'AdminPosts',
                component: () => import('@/pages/admin/Posts.vue'),
            },
            {
                path: 'users',
                name: 'AdminUsers',
                component: () => import('@/pages/admin/Users.vue'),
            },
        ],
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
    const requiredRole = to.meta.role

    if (!requiresAuth) return next()

    const tokenKey = requiredRole === 'admin' ? 'admin_token' : 'user_token'
    const token = localStorage.getItem(tokenKey)

    if (!token) return next(`/${requiredRole}/login`)

    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

    try {
        const meEndpoint = requiredRole === 'admin' ? '/admin/me' : '/user/me'
        const response = await axios.get(meEndpoint)
        const user = response.data

        // Extra safety: check role if your /me returns it
        if (requiredRole && user.role !== requiredRole) {
            return next(`/${requiredRole}/login`)
        }

        return next()
    } catch (error) {
        console.error('Auth check failed:', error)
        return next(`/${requiredRole}/login`)
    }
})

export default router
