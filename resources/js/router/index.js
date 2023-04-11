import {createWebHistory, createRouter} from "vue-router";

import Home from '../components/Home.vue'; //
import Register from '../components/Register.vue'; //Página de Registro
import Login from '../components/Login.vue'; //Página para iniciar sesión
import Dashboard from '../components/Dashboard.vue'; //Al iniciar sesión, será la página con los datos del usuario
import Posts from '../components/Posts.vue'; //Nuestra Tienda
import AddPost from '../components/AddPost.vue'; //Añadir Producto
import EditPost from '../components/EditPost.vue'; //Editar Producto
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