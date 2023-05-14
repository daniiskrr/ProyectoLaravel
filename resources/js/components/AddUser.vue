<template>
    <div v-if="isLoggedin && user.role === 'Administrador'" class="container">
                <div class="registrar">
                    <form class="formulario-registrar" @submit.prevent="addUser">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <h2 style="margin: 0;">Crear un nuevo usuario</h2>
                            <router-link :to="{name: 'PanelUsuarios'}" style="margin-left: auto;">Atrás</router-link>
                        </div>
                        <hr>

                        <label for="nombre">Nombre</label>
                        <input id="nombre" type="text" v-model="nombre" required
                               autofocus autocomplete="off"  placeholder="Introduce el nombre">

                        <label for="apellidos" class="col-sm-4 col-form-label text-md-right">Apellidos</label>
                        <input id="apellidos" type="text" v-model="apellidos" required
                               autofocus autocomplete="off" placeholder="Introduce los apellidos">

                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input id="fecha_nacimiento" type="date" v-model="fecha_nacimiento" required
                               autofocus autocomplete="off" placeholder="Introduce la fecha de nacimiento">

                        <label for="direccion">Direccion</label>
                        <input id="direccion" type="text" v-model="direccion" required
                               autofocus autocomplete="off" placeholder="Introduce la direccion">

                        <label for="telefono">Telefono</label>
                        <input id="telefono" type="text" v-model="telefono" required
                               autofocus autocomplete="off" placeholder="Introduce el número de teléfono">

                        <label for="tipo_suscripcion">Suscripción *</label>
                        <select id="tipo_suscripcion" style="background-color: #e7e9ee;" v-model="tipo_suscripcion">
                            <option value="free" selected>No tiene Suscripcion</option>
                            <option value="PsPlus Essential">Playstation Plus Essential</option>
                            <option value="PsPlus Extra">Playstation Plus Extra</option>
                            <option value="PsPlus Premium">Playstation Plus Premium</option>
                        </select>

                        <label for="duracion">Duracion</label>
                        <input id="duracion" type="number" v-model="duracion" required placeholder="Introduce la duración de la suscripción">

                        <label for="email" class="">Correo electrónico</label>
                        <input id="email" type="email" v-model="email" required
                               autofocus autocomplete="off" placeholder="Introduce el correo electrónico">

                        <label for="password" class="">Password</label>
                        <input id="password" type="password" v-model="password"
                               required autocomplete="off" placeholder="Introduce la contraseña">

                        <label for="rol">Rol *</label>
                        <select id="Rol" style="background-color: #e7e9ee;" v-model="rol" required>
                            <option value="2">Usuario</option>
                            <option value="1">Administrador</option>
                        </select>
                        <button type="submit" class="boton-login">Crear Usuario</button>
                    </form>
                </div>
        </div>
    <div v-else>
        <h2 class="titulo-tienda">Buen intento! Prueba de nuevo, quizás lo consigues algún día</h2>
    </div>
</template>


<script>
export default {
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
            error: null,
            isLoggedin: false,
            user: window.Laravel.user
        };
    },
    mounted() {
        if (window.Laravel && window.Laravel.isLoggedin) {
            this.isLoggedin = true;
        }
    },
    methods: {
        //Obtenemos los datos del formulario y llamamos a la api con la ruta correspondiente para poder mandar los datos
        addUser(e) {
            e.preventDefault();
            if (this.password.length > 0) {
                this.$axios.get("/sanctum/csrf-cookie").then(response => {
                    let existObj = this;
                    const formData = new FormData();
                    formData.append('nombre', this.nombre);
                    formData.append('apellidos', this.apellidos);
                    formData.append('fecha_nacimiento', this.fecha_nacimiento);
                    formData.append('direccion', this.direccion);
                    formData.append('telefono', this.telefono);
                    formData.append('tipo_suscripcion', this.tipo_suscripcion);
                    formData.append('duracion', this.duracion);
                    formData.append('email', this.email);
                    formData.append('password', this.password);

                    this.$axios.post("api/users/add", formData)
                        .then(response => {
                            notie.alert({type: 'success', text: response.data.success, time: 3, callback: function() { window.location.href = '/PanelUsuarios';}});
                            existObj.strError = "";
                            existObj.strSuccess = response.data.success;
                            setTimeout(() => {
                                window.location.href = '/panelusuarios';
                            }, 3000);
                        })
                        .catch(function (error){
                            notie.alert({ type: 'error', text: "error.response.data.message" });
                            existObj.strError = error.response.data.message;
                            existObj.strSuccess = "";
                        });
                });
            }
        }
    }

};
</script>

<style scoped>


</style>
