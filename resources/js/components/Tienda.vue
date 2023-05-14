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

    <!-- Si el usuario no está logueado o está logueado y no tiene suscripción -->
    <div v-if="!isLoggedin || (isLoggedin && user.tipo_suscripcion === 'free')" class="row">
        <div v-for="(post, index) in Juegosfiltrados3" :key="post.id" class="col-juegos">
            <div v-if="post.image">
                <img alt="{{post.nombre}}" width="100" :src="'/img/' + post.image">
            </div>
            <h5>{{ post.nombre }}</h5>
            <p>PS5</p>
            <p>{{ post.precio }}€</p>
            <a v-if="isLoggedin" href="#" class="boton" @click="agregarProducto(post)">Comprar ahora</a>
            <router-link to="/login"><a v-if="!isLoggedin" href="#" class="boton">Inicia sesión para comprar</a></router-link>
        </div>
    </div>
    <!-- Si el usuario no está logueado o está logueado y no tiene suscripción -->
        <div v-if="isLoggedin && (user.tipo_suscripcion === 'PsPlus Premium' || user.tipo_suscripcion === 'PsPlus Essential' || user.tipo_suscripcion === 'PsPlus Extra')" class="row">
            <div v-for="(post, index) in Juegosfiltrados" :key="post.id" class="col-juegos">
                <div v-if="post.image">
                    <img alt="{{post.nombre}}" width="100" v-bind:src="'/img/' + post.image">
                </div>
                <h5>{{post.nombre}}</h5>
                <p>PS5</p>
                <p>{{post.precio}}€</p>
                <a v-if="isLoggedin" href="#" class="boton" @click="agregarProducto(post)">Comprar ahora</a>
                <router-link to="/login"><a v-if="!isLoggedin" href="#" class="boton">Inicia sesión para comprar</a></router-link>
            </div>
        </div>
    <!-- Si el usuario está logueado o está logueado y tiene alguna suscripción -->
        <div v-if="isLoggedin && (user.tipo_suscripcion === 'PsPlus Premium' || user.tipo_suscripcion === 'PsPlus Essential' || user.tipo_suscripcion === 'PsPlus Extra')">
            <h2 class="titulo-tienda">Ofertas</h2>
            <div  style="margin-bottom: 2%" class="row row-oferta">
                <div v-for="(post, index) in Juegosfiltrados2" :key="post.id" class="col-juegos">
                    <div v-if="post.image">
                        <img alt="{{post.nombre}}" width="100" :src="'/img/' + post.image">
                    </div>
                    <h5>{{ post.nombre }}</h5>
                    <p>PS5</p>
                    <p>{{ post.precio}}€</p>
                    <a href="#" class="boton" @click="agregarProducto(post)">Comprar ahora</a>
                </div>
            </div>
        </div>
    <!-- Si el usuario no está logueado o está logueado y no tiene suscripción -->
    <div v-if="!isLoggedin || (isLoggedin && user.tipo_suscripcion === 'free')" class="row">
        <h2 class="titulo-tienda">Suscripciones</h2>
        <div class="row">
        <div v-for="(susc, index) in Juegosfiltrados4" :key="susc.id" class="col-juegos">
            <img alt="{{susc.nombre_suscripcion}}" width="100" :src="'/img/' + susc.id + '.webp'">
            <h5>{{ susc.nombre_suscripcion }}</h5>
            <p>PS5</p>
            <p>{{ susc.precio_suscripcion }}€</p>
            <a v-if="isLoggedin" href="#" class="boton" @click="agregarSusc(susc)">Comprar ahora</a>
            <router-link to="/login"><a v-if="!isLoggedin" href="#" class="boton">Inicia sesión para comprar</a></router-link>
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
            productos: [],
            posts: [],
            ofertas: [],
            susc: [],
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
            //Llamamos a la api con la ruta correspondiente para poder obtener los datos de los productos y mostrarlos en la tienda
            axios.get('/api/tiendaall')
                .then(response => {
                    this.productos = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        });
        //Llamamos a la api con la ruta correspondiente para poder obtener los datos de los juegos que no están asignados a ninguna suscripción.
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/tienda')
                .then(response => {
                    this.posts = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
        //Llamamos a la api con la ruta correspondiente para poder obtener los datos de los juegos que están asignados a cualquier suscripción.
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/posts/ofertas')
                .then(response => {
                    this.ofertas = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
        //Llamamos a la api con la ruta correspondiente para poder obtener los datos de las suscripciones.
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            axios.get('/api/suscripciones')
                .then(response => {
                    this.susc= response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        });
    },
    computed: {
        Juegosfiltrados() {
            return this.posts.filter(post => {
                return post.nombre.toLowerCase().includes(this.busqueda.toLowerCase()); //filtro para productos sin oferta para usuarios Essential, Extra y Premium
            });
        },
        Juegosfiltrados2(){
            return this.ofertas.filter(post => {
                return post.nombre.toLowerCase().includes(this.busqueda.toLowerCase()); //filtro para productos en oferta para usuarios Essential, Extra y Premium
            });
        },
        Juegosfiltrados3(){
            return this.productos.filter(post => {
                return post.nombre.toLowerCase().includes(this.busqueda.toLowerCase());//filtro para tienda sin login y usuarios free
            });
        },
        Juegosfiltrados4() {
            return this.susc.filter(susc => {
                return susc.nombre_suscripcion.toLowerCase().includes(this.busqueda.toLowerCase()); //filtro para suscripciones
            });
        },
    },
    methods: {
        //Función para añadir los productos al carrito gracias al localstorage
        agregarProducto(producto) {
            const productosEnCarrito = JSON.parse(localStorage.getItem('productos')) || [];
            const productoExistente = productosEnCarrito.find(p => parseInt(p.id) === parseInt(producto.id));

            if (productoExistente) {
                // El producto ya está en el carrito
                notie.alert({type: 'error', text: 'Ya existe este producto en tu carrito', time: 3 });
                return;
            }

            // Agregar el producto al carrito
            productosEnCarrito.push({
                id: producto.id,
                nombre: producto.nombre,
                image: producto.image,
                precio: producto.precio
            });

            localStorage.setItem('productos', JSON.stringify(productosEnCarrito));

            console.log(JSON.parse(localStorage.getItem('productos')));

            // Mostrar mensaje de éxito
            notie.alert({type: 'success', text: 'Producto agregado al carrito', time: 3 });
        },
        //Función para añadir las suscripciones al carrito gracias al localstorage
        agregarSusc(producto) {
            const productosEnCarrito = JSON.parse(localStorage.getItem('productos')) || [];
            const suscripcionesEnCarrito = productosEnCarrito.filter(p => p.tipo === 'suscripcion');

            if (suscripcionesEnCarrito.length > 0) {
                // Ya existe una suscripción en el carrito
                notie.alert({type: 'error', text: 'Ya tienes una suscripción en tu carrito', time: 3 });
                return;
            }

            // Agregar la suscripción al carrito
            productosEnCarrito.push({
                id: producto.id,
                tipo: 'suscripcion',
                nombre_suscripcion: producto.nombre_suscripcion,
                precio_suscripcion: producto.precio_suscripcion
            });

            localStorage.setItem('productos', JSON.stringify(productosEnCarrito));

            console.log(JSON.parse(localStorage.getItem('productos')));

            // Mostrar mensaje de éxito
            notie.alert({type: 'success', text: 'Suscripción agregada al carrito', time: 3 });
        }
    }
};
</script>


