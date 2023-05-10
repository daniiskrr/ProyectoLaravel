<template>
    <body>
    <div class="titulo-tienda">
        <h1>Catálogo de juegos de PlayStation</h1>
    </div>

    <form action="#" method="get" class="formJuegos">
        <input class="my-0 me-1" type="text" name="busqueda" placeholder="Buscar juegos...">
        <button class="btn btn-outline-success" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
        </button>
    </form>
    <div class="row">
        <div v-for="(post, index) in posts" :key="post.id" class="col-juegos">
            <div v-if="post.image">
                <img alt="post-img" width="100" v-bind:src="'/img/' + post.image">
            </div>
            <h5>{{post.nombre}}</h5>
            <p>PS5</p>
            <p>{{post.precio}}€</p>
            <a href="#" class="boton">Comprar ahora</a>
        </div>
    </div>

    <h5>ofertitas</h5>
    <div class="row row-oferta">
        <div v-for="(post2, index) in ofertas" :key="post2.id" class="col-juegos">
            <div v-if="post2.image">
                <img alt="post-img" width="100" v-bind:src="'/img/' + post2.image">
            </div>
            <h5>{{ post2.nombre }}</h5>
            <p>Precio: {{ calcularPrecio(post2) }}</p>
            <p v-if="post2.precio > 0">Precio original: {{ post2.precio }}</p>
            <p v-else>¡Gratis con PsPlus Premium!</p>
            <a href="#" class="boton">Comprar ahora</a>
        </div>
    </div>

    </body>
</template>

<script>
export default {
    data() {
        return {
            posts: [],
            ofertas: [],
            descuentoporcentaje: 0,
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

        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tienda')
                .then(response => {
                    this.posts = response.data;

                    if (this.user && this.user.role) {
                        const suscripcion = this.user.tipo_suscripcion;

                        if (suscripcion === 'PsPlus Essential') {
                            this.descuentoporcentaje = 20;
                        } else if (suscripcion === 'PsPlus Extra') {
                            console.log("soy extra");
                            this.descuentoporcentaje = 30;
                        } else if (suscripcion === 'PsPlus Premium') {
                            this.descuentoporcentaje = 30;
                            this.posts.forEach(post2 => {
                                if (post2.id_suscripcion === 4) {
                                    post2.descuento = 100;
                                } else {
                                    post2.descuento = this.descuentoporcentaje;
                                }
                            });

                            this.ofertas.forEach(oferta => {
                                if (oferta.id_suscripcion === 4) {
                                    oferta.descuento = 100;
                                } else {
                                    oferta.descuento = this.descuentoporcentaje;
                                }
                            });

                        }
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        });

        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/posts/ofertas')
                .then(response => {
                    this.ofertas = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    },
    methods: {
        calcularPrecio(post2) {

        }
    }
}
</script>
