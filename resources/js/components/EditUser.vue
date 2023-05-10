<template>
    <div v-if="isLoggedin && user.role === 'Administrador'" class="container">
        <div class="row jutify-content-center">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Editar Producto</h5>
                        <div>
                            <router-link :to="{name: 'posts'}" class="btn btn-success">Atrás</router-link>
                        </div>
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="updateUser" method="POST">
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-4 col-form-label text-md-right">Nombre</label>
                                <div class="col-md-8">
                                    <input id="nombre" type="text" class="form-control" v-model="nombre">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="apellidos" class="col-sm-4 col-form-label text-md-right">Apellidos</label>
                                <div class="col-md-8">
                                    <input id="apellidos" type="text" class="form-control" v-model="apellidos">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="fecha_nacimiento" class="col-sm-4 col-form-label text-md-right">Fecha de nacimiento</label>
                                <div class="col-md-8">
                                    <input id="fecha_nacimiento" type="date" class="form-control" v-model="fecha_nacimiento" required>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="direccion" class="col-sm-4 col-form-label text-md-right">Direccion</label>
                                <div class="col-md-8">
                                    <input id="direccion" type="text" class="form-control" v-model="direccion" required>
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="telefono" class="col-sm-4 col-form-label text-md-right">Telefono</label>
                                <div class="col-md-8">
                                    <input id="telefono" type="text" class="form-control" v-model="telefono" required>
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="tipo_suscripcion">Suscripción</label><span class="text-danger" > *</span>
                                <select class="form-control" id="tipo_suscripcion" v-model="tipo_suscripcion">
                                    <option value="free" selected>No tiene Suscripcion</option>
                                    <option value="PsPlus Essential">Playstation Plus Essential</option>
                                    <option value="PsPlus Extra">Playstation Plus Extra</option>
                                    <option value="PsPlus Premium">Playstation Plus Premium</option>
                                </select>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="duracion" class="col-sm-4 col-form-label text-md-right">Duracion</label>
                                <div class="col-md-8">
                                    <input id="duracion" type="text" class="form-control" v-model="duracion">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">Correo electrónico</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="email" required>
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" v-model="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="rol">Rol</label>
                                <select class="form-control" id="rol" v-model="rol">
                                    <option>Selecciona un rol</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Usuario">Usuario</option>
                                </select>
                            </div>

                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary mt-4 mb-4">Editar Usuario</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div v-else>
        <p>No tienes permisos para acceder a esta página.</p>
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
            this.$axios.post(`/api/users/update/${id}`, formData)
                .then(response => {
                    notie.alert({type: 'success', text: response.data.success, time: 3 });
                    this.strError = "";
                    this.strSuccess = response.data.success;
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
