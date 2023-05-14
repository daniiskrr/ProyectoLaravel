<template>

    <div v-if="isLoggedin && user.role === 'Administrador'" class="card">
        <div class="carrito" style="padding-top: 2.3rem">
            <div class="tabla">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h5 style="margin: 0;">Lista de Productos</h5>
                    <button style="margin-left: auto;" type="button" @click="this.$router.push('/posts/add')">Nuevo Producto</button>
                </div>
                <hr style="color: white">

            <table>
                <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Suscripcion</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(post, index) in posts" :key="post.id">
                    <td>{{index}}</td>
                    <td>{{post.nombre}}</td>
                    <td>{{post.descripcion}}</td>
                    <td>{{ nombreSuscripcion(post.id_suscripcion) }}</td>
                    <td>{{post.precio}}€</td>
                    <td>
                        <div v-if="post.image">
                            <img alt="post-img" width="100" v-bind:src="'/img/' + post.image">
                        </div>
                    </td>
                    <td class="botones-accion">
                        <router-link :to="{ name: 'EditPost', params: { id: post.id }}"><button style="margin-bottom: 10%"><img class="editar" src="../../images/boligrafo.svg" Editar/></button></router-link>
                        <button @click="eliminaProducto(post.id)"><img class="cruzz" src="../../images/cruz.svg" Borrar/></button>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <div v-else>
        <h2 class="titulo-tienda">Buen intento! Prueba de nuevo, quizás lo consigues algún día</h2>
    </div>



</template>


<script>
export default {
    data() {
        return {
            posts: [],
            strSuccess: '',
            strError: '',
            isLoggedin: false,
            user: window.Laravel.user
        };
    },
    mounted() {
        if (window.Laravel && window.Laravel.isLoggedin) {
            this.isLoggedin = true;
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            //Llamamos a la api con la ruta correspondiente para poder obtener los datos de los productos y mostrarlos en el panel
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
        //Método para mandar a la api el id del producto que hemos seleccionado y eliminarlo.
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
                    });
            })
        },
        //Switch para que al mostrar la suscripción en el form, no sea tan "soso" de ver
        nombreSuscripcion(idSus) {
            switch (idSus) {
                case 1:
                    return 'No tiene suscripción';
                case 2:
                    return 'PlayStation Plus Essential';
                case 3:
                    return 'PlayStation Plus Extra';
                case 4:
                    return 'PlayStation Plus Premium';
                default:
                    return '';
            }
        }
    }
}
</script>
