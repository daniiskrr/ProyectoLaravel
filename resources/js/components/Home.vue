<template>
    <html>
    <body>
    <div class="slide">
        <div class="slide-inner">
            <input class="slide-open" type="radio" id="slide-1"
                   name="slide" aria-hidden="true" hidden="" checked="checked">
            <div class="slide-item">
                <img src="../../images/Ofertas.webp">
                <div class="row">
                    <div class="col-lg-12 d-flex flex-column align-items-center ofertas">
                        <img src="../../images/Texto-rebajas.webp" alt="rebajas">
                        <h2>Paga menos. Juega mas.</h2>
                        <p>Hemos añadido muchos más juegos a las increíbles rebajas de PlayStation Store. No te los pierdas.</p>
                        <a href="" class="boton-blanco">Descubre las ofertas</a>
                    </div>
                </div>
            </div>
            <input class="slide-open" type="radio" id="slide-2"
                   name="slide" aria-hidden="true" hidden="">
            <div class="slide-item">
                <img src="../../images/horizon.webp">
                <div class="row">
                    <div class="col-lg-1 d-none d-lg-block"></div>
                    <div class="col-lg-4 col-12 d-flex flex-column horizon">
                        <img src="../../images/Lletra-Horizon.webp" alt="horizon">
                        <h2 style="text-align: left;">Viaja más allá del Oeste Prohibido.</h2>
                        <p style="text-align: left;">Experimenta el siguiente capítulo de Horizon Forbidden West, donde Aloy se enfrenta a una siniestra nueva amenaza en el DLC Burning Shores, ya disponible para PS5.</p>
                        <a href="" class="boton-blanco">Obten mas información</a>
                    </div>
                </div>
            </div>
            <input class="slide-open" type="radio" id="slide-3"
                   name="slide" aria-hidden="true" hidden="">
            <div class="slide-item">
                <img src="../../images/jedi.webp">
                <div class="row">
                    <div class="col-lg-1 d-none d-lg-block"></div>
                    <div class="col-lg-4 col-12 d-flex flex-column jedi">
                        <img src="../../images/Lletra-Star-Wars.webp" alt="jedi"/>
                        <h2 style="text-align: left;">Enfréntate al Imperio</h2>
                        <p style="text-align: left;">Regresa a una galaxia muy, muy lejana y sigue a Cal Kestis en su lucha contra la oscuridad en STAR WARS Jedi: Survivor™, ya disponible para PS5.</p>
                        <a href="" class="boton-blanco">Obten mas información</a>
                    </div>
                </div>
            </div>
            <label for="slide-3" class="slide-control prev control-1">‹</label>
            <label for="slide-2" class="slide-control next control-1">›</label>
            <label for="slide-1" class="slide-control prev control-2">‹</label>
            <label for="slide-3" class="slide-control next control-2">›</label>
            <label for="slide-2" class="slide-control prev control-3">‹</label>
            <label for="slide-1" class="slide-control next control-3">›</label>
            <ol class="slide-indicador">
                <li>
                    <label for="slide-1" class="slide-circulo">•</label>
                </li>
                <li>
                    <label for="slide-2" class="slide-circulo">•</label>
                </li>
                <li>
                    <label for="slide-3" class="slide-circulo">•</label>
                </li>
            </ol>
        </div>
    </div>

    <section class="info-section">
        <div class="info-text">
            <h2>Consola PlayStation 5</h2>
            <p>Descubre una nueva generación de juegos increíbles para PlayStation.</p>
            <a href="#" class="boton">Más información</a>
        </div>
        <div class="info-image">
            <img src="../../images/ps5.webp" alt="Imagen de información">
        </div>
    </section>

    <section class="banner">

        <img class="ordenador" src="../../images/god-of-war.webp" alt="Juego Destacado">
        <img class="movil" src="../../images/god-of-war-movil.webp" alt="Juego Destacado">
        <div class="row">
            <div class="col-lg-1 d-none d-lg-block"></div>
            <div class="col-lg-4 col-12 d-flex flex-column god">
                <img src="../../images/god-of-war-lletra.webp" alt="god-of-war">
                <div class="fondoMovil">
                    <h2>La saga nórdica continúa</h2>
                    <p>Emprende un viaje épico y conmovedor en el que ayudarás a Kratos y Atreus a permanecer unidos, disponible para PS4 y PS5</p>
                    <div class="d-flex"><a href="" class="boton-naranja">Comprar Ahora</a></div>

                </div>
            </div>
        </div>
    </section>

    <div class="titulo-seccion-ps4">
        <h2>Explora PlayStation®4</h2>
        <p>Juegos increíbles, entretenimiento sin fin. Es el mejor momento para disfrutar de PS4.</p>
    </div>

    <section class="seccion-ps4">
        <div class="row">
            <div class="col">
                <div class="ps4">
                    <img src="../../images/ps4.webp" alt="Consola Ps4">
                    <h3>PlayStation 4</h3>
                    <p>Dispones de juegos increíbles para PS4 con 1 TB de almacenamiento.</p>
                    <a href="#" class="boton">Más información</a>
                </div>
            </div>
            <div class="col">
                <div class="ps4">
                    <img src="../../images/psvr.webp" alt="Gafas de realidad virtual Ps4">
                    <h3>PlayStation VR</h3>
                    <p>Más de 500 juegos y experiencias, y subiendo. Verlos todos.</p>
                    <a href="#" class="boton">Más información</a>
                </div>
            </div>
            <div class="col">
                <div class="ps4">
                    <img src="../../images/accesorios.webp" alt="Accesorios Ps4">
                    <h3>Accesorios</h3>
                    <p>Mejora tu experiencia PS4 con una variedad de accesorios oficiales.</p>
                    <a href="#" class="boton">Más información</a>
                </div>
            </div>
        </div>
    </section>
    </body>
</html>
</template>

<script>
export default{
    name: "Home"
}
</script>

<style scoped>
</style>
