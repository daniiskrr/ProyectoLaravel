<template>
    <html>
    <body>
    <section class="row d-flex justify-content-center align-content-center">
        <div class="carrito">
            <div class="titulo_carrito">
                <h1>Carrito</h1>
                <hr style="color: #060b53">
            </div>
            <div v-if="numProductos === 0">
                <h2 class="titulo-tienda">Añade algo al carrito y lo verás reflejado aquí!</h2>
            </div>
            <div v-else>
            <div class="row">
                <div class="col-1 d-flex justify-content-end">

                </div>
                <div class="col-7" style="padding-top: 1.5rem">
                    <div v-if="numProductos === 1" class="barra_carrito">
                        {{numProductos}} elemento
                    </div>
                    <div v-else class="barra_carrito">
                        {{numProductos}} elementos
                    </div>

                    <div v-for="producto in productos" :key="producto.id">
                        <a href="" @click="eliminarProducto(producto)"><img class="cruz" src="../../images/cruz.svg" width="45px" height="46px" alt="Eliminar un juego"></a>
                        <div v-if="'tipo' in producto">
                            <div class="row juegoCarrito">
                                <div class="col-2 d-fl
                                ex">
                                    <img alt="post-img" width="100" :src="'/img/' + producto.id + '.webp'">
                                </div>
                                <div class="col info">
                                    <h2>{{ producto.nombre_suscripcion }}</h2>
                                    <p class="infoJuego">PS5</p>
                                </div>
                                <div class="col info">
                                    <div class="d-flex justify-content-end"><p>Suscripcion</p></div>
                                    <div class="d-flex justify-content-end align-items-end"><p class="precio"> {{ producto.precio_suscripcion }} €</p></div>

                                </div>
                            </div>
                            <hr>
                        </div>

                        <div v-else >
                            <div class="row juegoCarrito">
                                <div class="col-2 d-flex">
                                    <img alt="post-img" width="100" :src="'/img/' + producto.image">
                                </div>
                                <div class="col info">
                                    <h2>{{ producto.nombre }}</h2>
                                    <p class="infoJuego">PS5</p>
                                </div>
                                <div class="col info">
                                    <div class="d-flex justify-content-end"><p>Juego Completo</p></div>
                                    <div class="d-flex justify-content-end align-items-end"><p class="precio">{{ producto.precio }} €</p></div>
                                </div>

                        </div>
                            <hr>
                    </div>
                    </div>
                </div>

                <div class="col precios">
                    <div class="row">
                        <div v-if="numProductos === 1" class="col" style="text-align: left;">Subtotal: {{numProductos}} elemento a pagar</div>
                        <div v-else class="col" style="text-align: left;">Subtotal: {{numProductos}} elementos a pagar</div>
                    </div>
                    <hr>
                    <div class="row nuevoTotal">
                        <div class="col" style="text-align: left;">Total a pagar</div>
                        <div class="col" style="text-align: right;">{{ precioTotal }} €</div>
                    </div>
                    <hr>
                    <button class="finalizarCompra" @click="finalizarPedido(precioTotal)">Finalizar compra</button>
                </div>
                <div class="col-1"></div>
            </div>
            </div>
        </div>
    </section>
    </body>
    </html>
</template>
<script>
export default {
    data() {
        return {
            productos: JSON.parse(localStorage.getItem('productos')),
            numProductos: JSON.parse(localStorage.getItem('productos')).length,
            isLoggedin: false,
            user: window.Laravel.user
        }
    },
    mounted() {
        if (window.Laravel && window.Laravel.isLoggedin) {
            this.isLoggedin = true;
        }
    },
    computed: {
        precioTotal() {
            let total = 0;
            for (let i = 0; i < this.productos.length; i++) {
                total += parseFloat(this.productos[i].precio);
            }
            return total.toFixed(2);
        }
    },
    methods: {
        eliminarProducto(producto) {
            const productosEnLocalStorage = JSON.parse(localStorage.getItem('productos'));
            const productoAEliminar = productosEnLocalStorage.find(item => item.id === producto.id);
            const indiceDelProductoAEliminar = productosEnLocalStorage.indexOf(productoAEliminar);
            productosEnLocalStorage.splice(indiceDelProductoAEliminar, 1);
            localStorage.setItem('productos', JSON.stringify(productosEnLocalStorage));
            this.productos = productosEnLocalStorage;
        },
        finalizarPedido() {
            const precioTotal = this.precioTotal;

            axios.post('/api/posts/finalizarPedido', {
                precioTotal: precioTotal
            })
                .then(response => {
                    // Se ha completado la petición correctamente
                    notie.alert({type: 'success', text: "Compra Realizada con éxito", time: 3 });
                    setTimeout(() => {
                        window.location.href = '/'; //
                    }, 3000); //

                })
                .catch(error => {
                    // Se ha producido un error
                    console.log(error.response.data);
                });
            localStorage.removeItem('productos');
        }
    }
}
</script>
