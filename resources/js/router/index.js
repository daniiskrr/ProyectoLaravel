import {createWebHistory, createRouter} from "vue-router";

import Home from '../components/Home.vue';
import Register from '../components/Register.vue';
import Login from '../components/Login.vue';
import Dashboard from '../components/Dashboard.vue';
import Posts from '../components/Posts.vue';
import AddPost from '../components/AddPost.vue';
import EditPost from '../components/EditPost.vue';

export const routes = [
   {
       name: 'home',
       path: '/',
       component: Home
   },
   {
       name: 'register',
       path: '/register',
       component: Register
   },
   {
       name: 'login',
       path: '/login',
       component: Login
   },
   {
       name: 'dashboard',
       path: '/dashboard',
       component: Dashboard
   },
   {
        name: 'posts',
        path: '/posts',
        component: Posts
    },
    {
        name: 'addposts',
        path: '/posts/add',
        component: AddPost
    },
    {
        name: 'editpost',
        path: '/posts/edit',
        component: EditPost
    },
];

const router = createRouter({
  history:createWebHistory(),
  routes: routes,
});

export default router;