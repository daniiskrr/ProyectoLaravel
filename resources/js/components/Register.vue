<template>
    <html>
    <body>
    {{name}}
    <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{error}}</strong>
    </div>

    <div class="registrar">
        <form class="formulario-registrar">
            <h2>Crea una nueva cuenta</h2>
            <hr style="color: #060b53">
            <label for="nombre">Nombre</label>
            <input id="nombre" type="text" v-model="nombre" required
                   autofocus autocomplete="off" placeholder="Introduce tu nombre">

            <label for="apellidos">Apellidos</label>
            <input id="apellidos" type="text" v-model="apellidos" required
                   autofocus autocomplete="off" placeholder="Introduce tus apellidos">

            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input id="fecha_nacimiento" type="date" v-model="fecha_nacimiento" required
                   autofocus autocomplete="off" placeholder="Introduce tu fecha de nacimiento">

            <label for="direccion">Direccion</label>
            <input id="direccion" type="text" v-model="direccion" required
                   autofocus autocomplete="off" placeholder="Introduce tu direccion">

            <label for="telefono">Telefono</label>
            <input id="telefono" type="text" v-model="telefono" required
                   autofocus autocomplete="off" placeholder="Introduce tu número de teléfono">

            <label for="email">Correo electrónico</label>
            <input id="email" type="email" v-model="email" required
                   autofocus autocomplete="off" placeholder="Introduce tu correo electrónico">


            <label for="password">Password</label>
            <input id="password" type="password" v-model="password"
                   required autocomplete="off" placeholder="Introduce tu contraseña">

            <button class="boton-login" type="submit" @click="register">
                Registrarse
            </button>
            <br>
            <br>
            <small>
                Ya tienes cuenta? Haz clic en
                <router-link to="/login">Iniciar sesión</router-link>
            </small>
        </form>
    </div>
    </body>
    </html>
</template>


<script>
export default {
    name: "Register",
    data() {
        return {
            nombre: "",
            apellidos: "",
            fecha_nacimiento: "",
            direccion: "",
            telefono: "",
            tipo_suscripcion: "",
            duracion: "",
            email: "",
            password: "",
            //rol: "",
            error: null
        };
    },
    methods: {
        register(e) {
            e.preventDefault();
            if (this.password.length > 0) {
                this.$axios.get("/sanctum/csrf-cookie").then(response => {
                    this.$axios
                        .post("api/register", {
                            nombre: this.nombre,
                            apellidos: this.apellidos,
                            fecha_nacimiento: this.fecha_nacimiento,
                            direccion: this.direccion,
                            telefono: this.telefono,
                            tipo_suscripcion: this.tipo_suscripcion,
                            duracion: this.duracion,
                            email: this.email,
                            password: this.password,
                            //rol: "cliente"
                        })
                        .then(response => {
                            if (response.data.success) {
                                window.location.href = "/login";
                            } else {
                                this.error = response.data.message;
                            }
                        })
                        .catch(function(error) {
                            console.error(error);
                        });
                });
            }
        }
    }
};
</script>

<style scoped>


</style>
