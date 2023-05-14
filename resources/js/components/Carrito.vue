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
                                    <img alt="{{ producto.nombre_suscripcion }}" width="100" :src="'/img/' + producto.id + '.webp'">
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
                                    <img alt="{{producto.nombre}}" width="100" :src="'/img/' + producto.image">
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
            numProductos: JSON.parse(localStorage.getItem('productos')) ? JSON.parse(localStorage.getItem('productos')).length : 0,
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
            if (this.productos !== null) {
                for (let i = 0; i < this.productos.length; i++) {
                    if ('precio' in this.productos[i]) {
                        total += parseFloat(this.productos[i].precio);
                    } else if ('precio_suscripcion' in this.productos[i]) {
                        total += parseFloat(this.productos[i].precio_suscripcion);
                    }
                }
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

            // Actualiza la suscripción en la base de datos si el usuario tiene una suscripción en el carrito
            const tieneSuscripcion = this.productos.some(producto => producto.tipo === 'suscripcion');

            if (tieneSuscripcion && this.isLoggedin) {
                const suscripcion = this.productos.find(producto => producto.tipo === 'suscripcion');
                const nombreSuscripcion = suscripcion.nombre_suscripcion;
                axios.post('/api/posts/actualizarSuscripciones', {
                    usuarioId: this.user.id,
                    suscripcion: {
                        id: suscripcion.id,
                        nombre_suscripcion: nombreSuscripcion
                    }
                })
                    .then(response => {
                        // La suscripción se ha actualizado correctamente
                        console.log(response.data);
                    })
                    .catch(error => {
                        // Se ha producido un error al actualizar la suscripción
                        console.log(error.response.data);
                    });
            }

            // Finaliza el pedido y redirige al usuario a la página principal
            axios.post('/api/posts/finalizarPedido', { precioTotal })
                .then(response => {
                    // Se ha completado la petición correctamente
                    notie.alert({type: 'success', text: "Compra Realizada con éxito", time: 3 });
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 3000);
                })
                .catch(error => {
                    // Se ha producido un error
                    console.log(error.response.data);
                });
            //Eliminados los datos del localstorage para vaciar el carrito
            localStorage.removeItem('productos');
        }

    }
}
</script>
