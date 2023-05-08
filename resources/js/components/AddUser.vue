<template>
    <div class="container">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                {{name}}
                <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>{{error}}</strong>
                </div>


                <div class="card card-default">
                    <div class="card-header d-flex justify-content-between pb-2 mb-2">
                        <h5>Crear Nuevo Usuario</h5>
                        <div>
                            <router-link :to="{name: 'PanelUsuarios'}" class="btn btn-success">Atrás</router-link>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="addUser">
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-4 col-form-label text-md-right">Nombre</label>
                                <div class="col-md-8">
                                    <input id="nombre" type="text" class="form-control" v-model="nombre" required
                                        autofocus autocomplete="off"  placeholder="Introduce el nombre">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="apellidos" class="col-sm-4 col-form-label text-md-right">Apellidos</label>
                                <div class="col-md-8">
                                    <input id="apellidos" type="text" class="form-control" v-model="apellidos" required
                                           autofocus autocomplete="off" placeholder="Introduce los apellidos">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="fecha_nacimiento" class="col-sm-4 col-form-label text-md-right">Fecha de nacimiento</label>
                                <div class="col-md-8">
                                    <input id="fecha_nacimiento" type="date" class="form-control" v-model="fecha_nacimiento" required
                                           autofocus autocomplete="off" placeholder="Introduce la fecha de nacimiento">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="direccion" class="col-sm-4 col-form-label text-md-right">Direccion</label>
                                <div class="col-md-8">
                                    <input id="direccion" type="text" class="form-control" v-model="direccion" required
                                           autofocus autocomplete="off" placeholder="Introduce la direccion">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="telefono" class="col-sm-4 col-form-label text-md-right">Telefono</label>
                                <div class="col-md-8">
                                    <input id="telefono" type="text" class="form-control" v-model="telefono" required
                                           autofocus autocomplete="off" placeholder="Introduce el número de teléfono">
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
                                    <input id="duracion" type="text" class="form-control" v-model="duracion" required placeholder="Introduce la duración de la suscripción">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">Correo electrónico</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="email" required
                                           autofocus autocomplete="off" placeholder="Introduce el correo electrónico">
                                </div>
                            </div>

                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           required autocomplete="off" placeholder="Introduce la contraseña">
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="rol">Rol</label><span class="text-danger" > *</span>
                                <select class="form-control" id="Rol" v-model="rol" required>
                                    <option value="2">Usuario</option>
                                    <option value="1">Administrador</option>
                                </select>
                            </div>

                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success">Crear Usuario</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
            error: null
        };
    },
    methods: {
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
                        })
                        .catch(function (error){
                            notie.alert({ type: 'error', text: error.response.data.message });
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
