<template>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Inicio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link href="app.css" rel="stylesheet" type="text/css">


    </head>
    <header class="menuEstatico">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <router-link to="/"> <img class="logo" src="../images/PsGames.svg" alt="Logo de PsGames"></router-link>
                <div v-if="!isLoggedin" class="navbar-nav-botones">
                    <router-link to="/login"><button class="boton-login movil">Iniciar sesión</button></router-link>
                    <router-link to="/register"><button class="boton-login movil">Registrarse</button></router-link>
                </div>
                <div v-if="isLoggedin" class="navbar-nav-botones">
                    <router-link to="/dashboard"><button class="boton-login movil">Hola, {{ user.nombre}}!</button></router-link>
                    <router-link to="/"><button class="boton-login movil" @click="logout">Cerrar Sesión</button></router-link>

                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link to="/" aria-current="page" class="nav-link">Inicio</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/psplus" class="nav-item nav-link">PsPlus</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/tienda" class="nav-link">Tienda</router-link>
                        </li>
                        <li v-if="isLoggedin && user.role == 'Administrador'" class="nav-item">
                            <router-link to="/posts" class="nav-item nav-link">Productos</router-link>
                        </li>
                        <li v-if="isLoggedin && user.role == 'Administrador'" class="nav-item">
                            <router-link to="/panelusuarios" class="nav-item nav-link">Usuarios</router-link>
                        </li>
                    </ul>
                    <div v-if="isLoggedin" class="navbar-nav">
                        <router-link to="/dashboard"><button class="boton-login ordenador">Hola, {{ user.nombre }}!</button></router-link>
                        <router-link to="/"><button class="boton-login ordenador" @click="logout">Cerrar Sesión</button></router-link>
                        <router-link to="/carrito"><img class="logo-carrito" src="../images/carrito.svg" alt="Carrito de la compra"></router-link>
                    </div>
                    <div v-else class="navbar-nav">
                        <router-link to="/login"><button class="boton-login ordenador">Iniciar sesión</button></router-link>
                        <router-link to="/register"><button class="boton-login ordenador">Registrarse</button></router-link>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <body>
    <router-view></router-view>
    </body>
    </html>

    <footer>
        <div class="logoFooter">
            <img src="../images/logoFooter.png" alt="logoBlanco">
        </div>
        <hr>
        <div class="row">
            <div class="col-lg col-12">
                <h5>Acerca de</h5>
                <p>Sobre SIE</p>
                <p>Trabajos</p>
                <p>PlayStation Studios</p>
                <p>Empresa</p>
            </div>
            <hr class="movil">
            <div class="col-lg col-12">
                <h5>Productos</h5>
                <p>PS5</p>
                <p>PS4</p>
                <p>PSVR2</p>
                <p>PsPlus</p>
            </div>
            <hr class="movil">
            <div class="col-lg col-12">
                <h5>Valores</h5>
                <p>Medioambiente</p>
                <p>Accesibilidad</p>
                <p>Seguridad online</p>
                <p>Diversidad, equidad e inclusión.</p>
            </div>
            <hr class="movil">
            <div class="col-lg col-12">
                <h5>Atención al cliente</h5>
                <p>Conectar</p>
                <p>Seguridad en PlayStation</p>
                <p>Estado de PSN</p>
                <p>Reparaciones de PlayStation</p>
            </div>
            <hr class="movil">
            <div class="col-lg col-12">
                <h5>Recursos</h5>
                <p>Centro de atención al cliente</p>
                <p>Política de cancelación</p>
                <p>Clasificaciones por edad</p>
                <p>Aviso de salud</p>
            </div>
            <hr class="movil">
            <div class="col-lg col-12">
                <h5>Conectar</h5>
                <p>Términos de servicio de PSN</p>
                <p>Aplicación de iOS</p>
                <p>Aplicación de Android</p>
                <p>Términos de uso de la web</p>
            </div>
        </div>
        <hr>
    </footer>

</template>
<script>
var elemento = document.querySelector('header');
window.addEventListener("scroll", function() {
    if (window.pageYOffset > 100) {
        elemento.classList.remove("menuEstatico");
        elemento.classList.add("menuFijo");
    } else {
        elemento.classList.remove("menuFijo");
        elemento.classList.add("menuEstatico");
    }
});

export default {
    name: "App",
    data() {
        return {
            isLoggedin: false,
            user: {}
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedin = true;
            this.user = window.Laravel.user;
        }
    },
    methods: {
        logout(e) {
            e.preventDefault();
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/logout')
                    .then(response => {
                        if (response.data.success) {
                            localStorage.removeItem('productos');
                            window.location.href = "/"
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    }
}
</script>

