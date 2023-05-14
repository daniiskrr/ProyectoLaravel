<template>
    <div v-if="isLoggedin && user.role === 'Administrador'">
        <div class="registrar">
            <form @submit.prevent="updateUser" method="POST" class="formulario-registrar">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2 style="margin: 0;">Editar Usuario</h2>
                    <router-link :to="{name: 'PanelUsuarios'}" style="margin-left: auto;">Atrás</router-link>
                </div>
                <hr>
                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" v-model="nombre">

                <label for="apellidos">Apellidos</label>
                <input id="apellidos" type="text" class="form-control" v-model="apellidos">

                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input id="fecha_nacimiento" type="date" v-model="fecha_nacimiento" required>

                <label for="direccion">Direccion</label>
                <input id="direccion" type="text" v-model="direccion" required>

                <label for="telefono">Telefono</label>
                <input id="telefono" type="text" v-model="telefono" required>

                <label for="tipo_suscripcion">Suscripción</label>
                <select class="form-control" id="tipo_suscripcion" style="background-color: #e7e9ee;" v-model="tipo_suscripcion">
                    <option value="free" selected>No tiene Suscripcion</option>
                    <option value="PsPlus Essential">Playstation Plus Essential</option>
                    <option value="PsPlus Extra">Playstation Plus Extra</option>
                    <option value="PsPlus Premium">Playstation Plus Premium</option>
                </select>

                <label>Duracion</label>
                <input id="duracion" type="text" v-model="duracion">

                <label for="email" class="col-sm-4 col-form-label text-md-right">Correo electrónico</label>
                <input id="email" type="email" v-model="email" required>

                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <input id="password" type="password" v-model="password">

                <label for="rol">Rol</label>
                <select id="rol" style="background-color: #e7e9ee;" v-model="rol">
                    <option>Selecciona un rol</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Usuario">Usuario</option>
                </select>
                <button type="submit" class="boton-login">Editar usuario</button>
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
            id: "",
            nombre: "",
            apellidos: "",
            fecha_nacimiento: "",
            direccion: "",
            telefono: "",
            tipo_suscripcion: "",
            duracion: "",
            email: "",
            password: "",
            rol: "",
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
    created() {
        //Llamamos a la api con la ruta correspondiente para poder obtener los datos del usuario y mostrarlos en el formulario
        const id = this.$route.params.id;
        this.$axios.get(`/api/users/edit/${id}`)
            .then((response) => {
                const usuario = response.data;
                this.id = usuario.id;
                this.nombre = usuario.nombre;
                this.apellidos = usuario.apellidos;
                this.fecha_nacimiento = usuario.fecha_nacimiento;
                this.direccion = usuario.direccion;
                this.telefono = usuario.telefono;
                this.tipo_suscripcion = usuario.tipo_suscripcion;
                this.duracion = usuario.duracion;
                this.email = usuario.email;
                this.password = usuario.password;
                this.rol = usuario.rol;
            })
            .catch((error) => {
                console.log(error);
            });
    },
    methods: {
        updateUser(e) {
            const id = this.$route.params.id;
            this.error = null;
            const formData = new FormData();
            formData.append('nombre', this.nombre);
            formData.append('apellidos', this.apellidos);
            formData.append('fecha_nacimiento', this.fecha_nacimiento);
            formData.append('direccion', this.direccion);
            formData.append('telefono', this.telefono);
            formData.append('tipo_suscripcion', this.tipo_suscripcion);
            formData.append('duracion', this.duracion);
            formData.append('email', this.email);
            if (this.password) { // Verifica si this.password tiene un valor antes de agregarlo al formulario
                formData.append('password', this.password);
            }
            formData.append('rol', this.rol);
            //Llamamos a la api con la ruta correspondiente para poder enviar los datos del usuario y actualizarlos en la BBDD
            this.$axios.post(`/api/users/update/${id}`, formData)
                .then(response => {
                    notie.alert({type: 'success', text: response.data.success, time: 3 });
                    this.strError = "";
                    this.strSuccess = response.data.success;
                    setTimeout(() => {
                        window.location.href = '/panelusuarios';
                    }, 3000);
                })
                .catch(error => {
                    this.strSuccess = "";
                    this.strError = error.response.data.message;
                    console.log(error);
                });
        }


    }
};
</script>

<style scoped>


</style>
