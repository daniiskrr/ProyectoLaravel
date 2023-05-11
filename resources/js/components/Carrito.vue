<template>
    <html>
    <body>
    <section class="row d-flex justify-content-center align-content-center">
        <div class="carrito">
            <div class="titulo_carrito">
                <h1>Carrito</h1>
                <hr style="color: #060b53">
            </div>
            <div class="row">
                <div class="col-1 d-flex justify-content-end">

                </div>
                <div class="col-7" style="padding-top: 1.5rem">
                    <div class="barra_carrito">
                        1 elemento
                    </div>
                    <a style="appearance: none;" href=""><img class="cruz" src="../../images/cruz.svg" width="45px" height="46px" alt="Eliminar un juego"></a>
                    <div class="row juegoCarrito">
                        <div class="col-2 d-flex">
                            <img src="../../images/j9.webp" alt="god-of-war">
                        </div>
                        <div class="col info">
                            <h2>Dani Marica</h2>
                            <p class="infoJuego">PS5</p>
                        </div>
                        <div class="col info">
                            <div class="d-flex justify-content-end"><p>Juego Completo</p></div>
                            <div class="d-flex justify-content-end align-items-end"><p class="precio">50€</p></div>
                        </div>
                    </div>
                    <hr>
                </div>

                <div class="col precios">
                    <div class="row">
                        <div class="col" style="text-align: left;">Subtotal</div>
                        <div class="col" style="text-align: right;">24.99€</div>
                    </div>
                    <div class="row">
                        <div class="col" style="text-align: left;">Descuento</div>
                        <div class="col" style="text-align: right;">-12.50€</div>
                    </div>
                    <hr>
                    <div class="row nuevoTotal">
                        <div class="col" style="text-align: left;">Nuevo Total</div>
                        <div class="col" style="text-align: right;">12.49€</div>
                    </div>
                    <hr>
                    <button class="finalizarCompra">Finalizar compra</button>
                </div>
                <div class="col-1"></div>

            </div>
        </div>
    </section>
    </body>
    </html>
</template>
<script>

</script>
