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
                <router-link to="/Home"> <img class="logo" src="PsGames.svg" alt="Logo de PsGames"></router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link to="/" aria-current="page" class="nav-link">Inicio</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/tienda" class="nav-link">Tienda</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/psplus" class="nav-item nav-link">PsPlus</router-link>
                        </li>
                    </ul>
                    <div v-if="isLoggedin" class="navbar-nav">
                        <router-link to="/posts" class="nav-item nav-link">Panel Productos</router-link>
                        <router-link to="/panelusuarios" class="nav-item nav-link">Panel Usuarios</router-link>
                        <router-link to="/dashboard" class="nav-item nav-link">Pedidos</router-link>
                        <button class="btn boton-login">Daniel Rayo</button>
                        <a href="carrito.html"><img class="logo-carrito" src="carrito.svg" alt="Carrito de la compra"></a>
                        <a class="btn boton-login" style="cursor: pointer;" @click="logout">Logout</a>
                    </div>
                    <div v-else class="navbar-nav">
                        <button class="btn boton-login">Iniciar sesión</button>
                        <router-link to="/login" class="btn boton-login nav-link">Login</router-link>
                        <router-link to="/register" class="btn boton-login nav-link">Register</router-link>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <body>
    <router-view></router-view>
    </body>
    </html>
</template>
<script>
 export default {
    variable: "A",
    name: "App",
    data() {
        return {
            isLoggedin: false,
        }
    },
    created() {
        if(window.Laravel.isLoggedin){
            this.isLoggedin =true;
        }
    },
    methods: {
        logout(e) {
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/logout')
                    .then(response => {
                        if (response.data.success) {
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
    },
 }
 </script>
