<template>
    <html>
    <body>
    <div class="titulo-tienda">
        <h1>Catálogo de juegos de PlayStation</h1>
    </div>
        <form class="formJuegos" method="GET">
            <input class="my-0 me-1" type="text" v-model="busqueda" placeholder="Buscar juegos...">
            <button class="btn btn-outline-success" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </form>

        <div class="row">
            <div v-for="(post, index) in Juegosfiltrados" :key="post.id" class="col-juegos">
                <div v-if="post.image">
                    <img alt="post-img" width="100" v-bind:src="'/img/' + post.image">
                </div>
                <h5>{{post.nombre}}</h5>
                <p>PS5</p>
                <p>{{post.precio}}€</p>
                <a href="#" class="boton">Comprar ahora</a>
            </div>
        </div>

        <div v-if="isLoggedin && (user.tipo_suscripcion === 'PsPlus Premium' || user.tipo_suscripcion === 'PsPlus Essential' || user.tipo_suscripcion === 'PsPlus Extra')">
            <h2 class="titulo-tienda">Ofertas</h2>
            <div class="row row-oferta">
                <div v-for="(post, index) in Juegosfiltrados2" :key="post.id" class="col-juegos">
                    <div v-if="post.image">
                        <img alt="post-img" width="100" :src="'/img/' + post.image">
                    </div>
                    <h5>{{ post.nombre }}</h5>
                    <p>PS5</p>
                    <p>{{ post.precio_descuento ? post.precio_descuento.toFixed(2) + '€' : post.precio.toFixed(2) + '€' }}</p>
                    <a href="#" class="boton">Comprar ahora</a>
                </div>
            </div>
        </div>

    </body>
    </html>
</template>

<script>
export default {
    data() {
        return {
            posts: [],
            ofertas: [],
            strSuccess: '',
            strError: '',
            isLoggedin: false,
            user: window.Laravel.user,
            busqueda: ''
        };
    },
    mounted() {
        if (window.Laravel && window.Laravel.isLoggedin) {
            this.isLoggedin = true;
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tienda')
                .then(response => {
                    this.posts = response.data;
                    this.filteredPosts = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/posts/ofertas')
                .then(response => {
                    this.ofertas = response.data;
                    this.filteredPosts = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    },
    computed: {
        Juegosfiltrados() {
            return this.posts.filter(post => {
                return post.nombre.toLowerCase().includes(this.busqueda.toLowerCase());
            });
        },
        Juegosfiltrados2(){
            return this.ofertas.filter(post => {
                return post.nombre.toLowerCase().includes(this.busqueda.toLowerCase());
            });
        }
    }

}
</script>


