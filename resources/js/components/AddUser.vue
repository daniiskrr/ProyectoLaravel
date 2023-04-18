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
                    <div class="card-header"><h5>Crear Usuario</h5></div>
                    <div class="card-body">
                        <form>
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
 
 
                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="register">
                                        Crear Usuario
                                    </button>
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
              password: this.password
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