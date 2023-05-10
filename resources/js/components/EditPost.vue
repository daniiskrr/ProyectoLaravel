<template>
    <div v-if="isLoggedin && user.role === 'Administrador'" class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Editar Producto</h5>
                <div>
                    <router-link :to="{name: 'PanelUsuarios'}" class="btn btn-success">Atrás</router-link>
                </div>
            </div>

            <form @submit.prevent="updatePost" enctype="multipart/form-data" method="PUT">
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" v-model="nombre">
                </div>

                <div class="form-group mb-2">
                    <label>Descripcion</label><span class="text-danger" > *</span>
                    <textarea class="form-control" rows="3" v-model="descripcion"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label for="suscripcion">Suscripción</label><span class="text-danger" > *</span>
                    <select class="form-control" id="suscripcion" v-model="id_suscripcion">
                        <option value="1">No tiene Suscripcion</option>
                        <option value="2">Playstation Plus Essential</option>
                        <option value="3">Playstation Plus Extra</option>
                        <option value="4">Playstation Plus Premium</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label>Precio</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="precio">
                </div>

                <div class="form-group mb-2">
                    <label>Image</label><span class="text-danger"> *</span>
                    <input type="file" class="form-control mb-2" v-on:change="onChange">
                    <img v-bind:src="imgPreview" width="200" height="200"/>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Editar Producto</button>
            </form>
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
            descripcion: "",
            id_suscripcion: "",
            img: "",
            precio: "",
            strSuccess: "",
            strError: "",
            imgPreview: "",
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
        this.$axios
            .get(`/api/posts/edit/${id}`)
            .then((response) => {
                const post = response.data;
                this.id = post.id;
                this.nombre = post.nombre;
                this.descripcion = post.descripcion;
                this.id_suscripcion = post.id_suscripcion;
                this.precio = post.precio;
                this.imgPreview = post.image;
            })
            .catch((error) => {
                console.log(error);
            });
    },
    methods: {
        onChange(e) {
            this.img = e.target.files[0];
            let reader = new FileReader();
            reader.addEventListener(
                "load",
                function () {
                    this.imgPreview = reader.result;
                }.bind(this),
                false
            );

            if (this.img) {
                if (/\.(jpe?g|png|gif|webp)$/i.test(this.img.name)) {
                    reader.readAsDataURL(this.img);
                }
            }
        },
        updatePost(e) {
            // Comprueba si el usuario ha seleccionado una nueva imagen
            const id = this.$route.params.id;
            if (this.img) {
                // Si se ha seleccionado una nueva imagen, envía la solicitud con la nueva imagen
                const formData = new FormData();
                formData.append('nombre', this.nombre);
                formData.append('descripcion', this.descripcion);
                formData.append('id_suscripcion', this.id_suscripcion);
                formData.append('precio', this.precio);
                formData.append('file', this.img);
                this.$axios.post(`/api/posts/update/${id}`, formData)
                    .then((response) => {
                        notie.alert({type: 'success', text: response.data.success, time: 3 });
                        this.strError = "";
                        this.strSuccess = response.data.success;
                    })
                    .catch((error) => {
                        this.strSuccess = "";
                        this.strError = error.response.data.message;
                    });
            } else {
                // Si no se ha seleccionado una nueva imagen, envía la solicitud sin la imagen
                this.$axios.post(`/api/posts/update/${id}`, {
                    nombre: this.nombre,
                    descripcion: this.descripcion,
                    id_suscripcion: this.id_suscripcion,
                    precio: this.precio,
                })
                    .then((response) => {
                        notie.alert({type: 'success', text: response.data.success, time: 3 });
                        this.strError = "";
                        this.strSuccess = response.data.success;
                    })
                    .catch((error) => {
                        this.strSuccess = "";
                        this.strError = error.response.data.message;
                    });
            }
        },
        beforeRouteEnter(to, from, next) {
            if (!window.Laravel.isLoggedin) {
                window.location.href = "/";
            }
            next();
        },
    },
};
</script>
