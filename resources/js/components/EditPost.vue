<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Editar Producto</h5>
                <div>
                    <router-link :to="{name: 'posts'}" class="btn btn-success">Go Back</router-link>
                </div>
            </div>

            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{strSuccess}}</strong>
            </div>

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{strError}}</strong>
            </div>

            <form @submit.prevent="editarProducto" enctype="multipart/form-data">

                <input type="hidden" name="id" v-model="postData.id" />
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="postData.nombre">
                </div>

                <div class="form-group mb-2">
                    <label>Descripcion</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="postData.descripcion"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label for="suscripcion">Suscripción</label><span class="text-danger"> *</span>
                    <select class="form-control" v-model="postData.id_suscripcion" id="suscripcion">
                        <option value="1">No tiene Suscripcion</option>
                        <option value="2">Playstation Plus Essential</option>
                        <option value="3">Playstation Plus Extra</option>
                        <option value="4">Playstation Plus Premium</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label>Precio</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="postData.precio">
                </div>

                <div class="form-group mb-2">
                    <label>Image</label><span class="text-danger"> *</span>
                    <input type="file" class="form-control mb-2" v-on:change="onChangeImg" name="file">

                    <div v-if="imgPreview">
                        <img v-bind:src="imgPreview" width="100" height="100"/>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4">Editar publicación</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            postData: {
                id: '',
                nombre: '',
                descripcion: '',
                id_suscripcion: '',
                image: '',
                precio: ''
            },
            strSuccess: '',
            strError: ''
        }
    },
    created() {
        // Obtener el id del producto desde la URL
        const id = this.$route.params.id;
        this.obtenerProducto(id);
    },
    methods: {
        obtenerProducto(id) {
            // Hacer la petición al servidor para obtener los datos del producto
                this.$axios.get('http://127.0.0.1:8000/posts/' + id).then(response => {
                    // Asignar los datos del producto al objeto postData
                    this.postData.id = response.data.id;
                    this.postData.nombre = response.data.nombre;
                    this.postData.descripcion = response.data.descripcion;
                    this.postData.id_suscripcion = response.data.id_suscripcion;
                    this.postData.image = response.data.image;
                    this.postData.precio = response.data.precio;
                    console.log(this.postData.id);
                    console.log(this.postData.nombre);
                    console.log(this.postData.descripcion);
                }).catch(error => {
                    console.log(error);
                });
        },
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                this.postData.image = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
}
</script>






