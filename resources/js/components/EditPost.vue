<template>
    <div v-if="isLoggedin && user.role === 'Administrador'" class="card">
        <div class="registrar">
            <form @submit.prevent="updatePost" enctype="multipart/form-data" method="PUT" class="formulario-registrar">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2 style="margin: 0;">Editar Producto</h2>
                    <router-link :to="{name: 'posts'}" style="margin-left: auto;">Atrás</router-link>
                </div>
                <hr>
                <label>Nombre </label>
                <input type="text" class="form-control" v-model="nombre">

                <label>Descripcion</label>
                <textarea class="form-control" rows="3" v-model="descripcion"></textarea>

                <label for="suscripcion">Suscripción </label>
                <select style="background-color: #e7e9ee;" id="suscripcion" v-model="id_suscripcion">
                    <option value="1">No tiene Suscripcion</option>
                    <option value="2">Playstation Plus Essential</option>
                    <option value="3">Playstation Plus Extra</option>
                    <option value="4">Playstation Plus Premium</option>
                </select>

                <label>Precio</label>
                <input type="text" v-model="precio">

                <label>Imagen</label>
                <input type="file" v-on:change="onChange">
                <img v-bind:src="imgPreview" width="200" height="200"/> <br><br>

                <button type="submit" class="boton-login">Editar Producto</button>
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
        //Llamamos a la api con la ruta correspondiente para poder obtener los datos del producto y mostrarlos en el formulario
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
                        setTimeout(() => {
                            window.location.href = '/posts';
                        }, 3000);
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
                        setTimeout(() => {
                            window.location.href = '/posts';
                        }, 3000);
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
