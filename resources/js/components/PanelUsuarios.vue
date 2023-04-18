<template>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">All Users Data</h5>
                <div>
                    <button class="btn btn-success" type="button" @click="this.$router.push('/adduser')">New User</button>
                </div>
            </div>
 
 
            <table class="table table-hover table-sm">
                <thead class="bg-dark text-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Nombre y apellidos</th>
                    <th>Correo</th>
                    <th>Datos</th>
                    <th class="text-center" width="200">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(usuario, index) in users" :key="usuario.id">
                    <td class="text-center">{{index}}</td>
                    <td>{{usuario.nombre}}</td>
                    <td>{{usuario.apellidos}}</td>
                    <td>{{usuario.fecha_nacimiento}}</td>
                    <td>{{usuario.direccion}}</td>
                    <td>{{usuario.telefono}}</td>
                    <td>{{usuario.tipo_suscripcion}}</td>
                    <td>{{usuario.duracion}}</td>
                    <td>{{usuario.email}}</td>
                    <td>{{usuario.apellidos}}</td>
                    <td class="text-center">
                        <router-link :to="{name:'edituser'}" class="btn btn-warning">Edit</router-link>
                        <button class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
 
 
 
 
        </div>
    </div>
 
 
 
 
 </template>
 
 
 <script>
 export default {
    data() {
        return {
            posts: [],
            strSuccess: '',
            strError: ''
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/posts')
                .then(response => {
                    this.posts = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        );
    },
    methods: {
 
 
    }
 }
 
 
 </script>
 
