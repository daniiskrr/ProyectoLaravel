<template>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Lista de Usuarios</h5>
                <div>
                    <button class="btn btn-success" type="button" @click="this.$router.push('/adduser')">Nuevo Usuario</button>
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
                    <td>Nombre: {{usuario.nombre}} <br> Apellidos: {{usuario.apellidos}}</td>
                    <td>Correo: {{usuario.email}}</td>
                    <td>Fecha Nacimiento: {{usuario.fecha_nacimiento}} <br>
                        Direccion: {{usuario.direccion}} <br>
                        Telefono: {{usuario.telefono}} <br>
                        Suscripción: {{usuario.tipo_suscripcion}} <br>
                        Duración: {{usuario.duracion}}<br>
                        Rol: {{usuario.rol}} </td>
                    <td class="text-center">
                        <router-link :to="{ name: 'EditUser', params: { id: usuario.id }}" class="btn btn-warning">Edit</router-link>
                        <button class="btn btn-danger" @click="eliminaUsuario(usuario.id)">Delete</button>
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
            users: [],
            strSuccess: '',
            strError: ''
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/users')
                .then(response => {
                    this.users = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        );
    },
    methods: {
        eliminaUsuario(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                axios.delete('http://127.0.0.1:8000/api/users/' + id)
                    .then(response => {
                        const index = this.users.findIndex(user => user.id === id);
                        this.users.splice(index, 1);
                        notie.alert({type: 'success', text: 'Usuario eliminado con éxito', time: 3 });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            });
        }
    }
 }


 </script>

