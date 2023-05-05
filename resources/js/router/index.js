import {createWebHistory, createRouter} from "vue-router";

import Home from '../components/Home.vue'; //
import Register from '../components/Register.vue'; //Página de Registro
import Login from '../components/Login.vue'; //Página para iniciar sesión
import Dashboard from '../components/Dashboard.vue'; //Al iniciar sesión, será la página con los datos del usuario
import Posts from '../components/Posts.vue'; //Nuestra Tienda
import AddPost from '../components/AddPost.vue'; //Añadir Producto
import EditPost from '../components/EditPost.vue'; //Editar Producto
import PanelUsuarios from '../components/PanelUsuarios.vue'; //Editar Producto
import AddUser from '../components/AddUser.vue'; //Añadir Usuario desde panel de usuarios
import EditUser from '../components/EditUser.vue'; //Editar Usuario
import Tienda from '../components/Tienda.vue'; //Tienda de productos
import PsPlus from '../components/PsPlus.vue'; //Mostrar Información sobre psplus
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
        name: 'EditPost',
        path: '/posts/edit/:id',
        component: EditPost,
    },
    {
        name: 'PanelUsuarios',
        path: '/panelusuarios',
        component: PanelUsuarios
    },
    {
        name: 'AddUser',
        path: '/adduser',
        component: AddUser
    },
    {
        name: 'EditUser',
        path: '/users/edit',
        component: EditUser
    },
    {
        name: 'Tienda',
        path: '/tienda',
        component: Tienda
    },
    {
        name: 'PsPlus',
        path: '/PsPlus',
        component: PsPlus
    },


];

const router = createRouter({
  history:createWebHistory(),
  routes: routes,
});

export default router;
