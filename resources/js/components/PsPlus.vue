<template>
    <html>
    <body>
    <div class="banner-psplus">
        <img class="ordenador" src="../../images/banner-plus.webp" alt="banner-plus">
        <img class="movil" src="../../images/banner-plus-movil.webp" alt="banner-plus">
        <div class="row contenido">
            <div class="col-lg-1 d-none d-lg-block"></div>
            <div class="col-lg-4 col-12 d-flex flex-column" style="z-index: 1">
                <img src="../../images/logo-ps-plus.webp" alt="Logo PsPlus">
                <div class="fondoMovil">
                    <h2>Bienvenido a PlayStation Plus</h2>
                    <p>Disfruta de cientos de juegos de PS5, PS4 y juegos clásicos de PlayStation, además de las ventajas de los tres planes de suscripción que desatan el poder de tu PlayStation.</p>
                    <div class="d-flex"><router-link to="/tienda"><a href="" class="boton">Ver todos los planes de suscripción</a></router-link></div>
                </div>
            </div>
        </div>
    </div>

    <section class="info-section-horizon">
        <div class="info-image-horizon">
            <img src="../../images/horizon-plus.webp" alt="Imagen de información">
        </div>
        <div class="info-text-horizon">
            <h2>Horizon Forbidden West</h2>
            <p>Acompaña a Aloy en su aventura por las peligrosas y fantásticas tierras del Oeste Prohibido y enfréntate a nuevas y misteriosas amenazas.</p>
            <p>Explora páramos remotos, enfréntate a máquinas más grandes e imponentes y descubre increíbles tribus en tu regreso a un futuro lejano en el mundo posapocalíptico de Horizon.</p>
            <p>Descarga y juega ya a los títulos del catálogo de juegos de PlayStation Plus.</p>
            <router-link to="/tienda"><a href="#" class="boton">Añadir a tu biblioteca</a></router-link>
        </div>
    </section>

    <div class="titulo-seccion-psplus">
        <h1>ELIGE TU PLAN DE SUSCRIPCIÓN</h1>
        <p>Explora los beneficios disponibles con suscripción de PlayStation Plus Essential, Extra o Premium.</p>
    </div>

    <section class="subscription-plans">
        <div class="row">
            <div class="col">
                <div class="plan">
                    <img src="../../images/essential.webp" alt="Essential Plan">
                    <h3>Plan Esencial</h3>
                    <p>Disfruta de los beneficios principales de PlayStation Plus: únete a tus amigos en multijugador online, añade nuevos juegos a tu colección cada mes, consigue ofertas increíbles para PlayStation Store y más.</p>
                    <p class="precio">59,99€/ 12 meses</p>
                    <router-link to="/tienda"><a href="#" class="boton">Más información</a></router-link>
                </div>
            </div>
            <div class="col">
                <div class="plan">
                    <img src="../../images/extra.webp" alt="Extra Plan">
                    <h3>Plan Extra</h3>
                    <p>Consigue todos los beneficios geniales incluidos en el plan PlayStation Plus Essential, así como acceso al catálogo de juegos, que incluye cientos de juegos desde superventas triple A a indies.</p>
                    <p class="precio">99,99€/ 12 meses</p>
                    <router-link to="/tienda"><a href="#" class="boton">Más información</a></router-link>
                </div>
            </div>
            <div class="col">
                <div class="plan">
                    <img src="../../images/premium.webp" alt="Premium Plan">
                    <h3>Plan Premium</h3>
                    <p>Disfruta de todos los beneficios principales de PlayStation Plus, cientos de juegos de catálogo de juegos, así como beneficios exclusivos como pruebas de juegos y streaming en la nube.</p>
                    <p class="precio">119,99€/ 12 meses</p>
                    <router-link to="/tienda"><a href="#" class="boton">Más información</a></router-link>
                </div>
            </div>
        </div>
    </section>
    </body>
    </html>
</template>

<script>
export default {
    name: "PsPlus.vue"
}
</script>

<style scoped>
</style>
