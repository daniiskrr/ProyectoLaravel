<template>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Lista de Productos</h5>
                <div>
                    <button class="btn btn-success" type="button" @click="this.$router.push('/posts/add')">Nuevo Producto</button>
                </div>
            </div>


            <table class="table table-hover table-sm">
                <thead class="bg-dark text-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Suscripcion</th>
                    <th>Precio</th>
                    <th class="text-center" width="120">Imagen</th>
                    <th class="text-center" width="200">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(post, index) in posts" :key="post.id">
                    <td class="text-center">{{index}}</td>
                    <td>{{post.nombre}}</td>
                    <td>{{post.descripcion}}</td>
                    <td>{{post.id_suscripcion}}</td>
                    <td>{{post.precio}}€</td>
                    <td class="text-center">
                        <div v-if="post.image">
                            <img alt="post-img" width="100" v-bind:src="'/img/' + post.image">
                        </div>
                    </td>
                    <td class="text-center">
                        <router-link :to="{ name: 'EditPost', params: { id: post.id }}" class="btn btn-warning">Edit</router-link>
                        <button class="btn btn-danger" @click="eliminaProducto(post.id)">Delete</button>
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
    eliminaProducto(id) {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            axios.delete('http://127.0.0.1:8000/api/posts/' + id)
            .then(response => {
                const index = this.posts.findIndex(post => post.id === id);
                this.posts.splice(index, 1);
                notie.alert({type: 'success', text: 'Producto eliminado con éxito', time: 3 });
            })
            .catch(error => {
                console.log(error);
                // Aquí puedes mostrar un mensaje de error si lo deseas
            });
        })
    }
 }
}
 </script>
