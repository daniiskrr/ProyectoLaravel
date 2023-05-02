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
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="post.nombre">
                </div>

                <div class="form-group mb-2">
                    <label>Descripcion</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="post.descripcion" placeholder="Introduce la descripcion"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label for="suscripcion">Suscripción</label><span class="text-danger"> *</span>
                    <select class="form-control" v-model="post.id_suscripcion" id="suscripcion">
                        <option value="1">No tiene Suscripcion</option>
                        <option value="2">Playstation Plus Essential</option>
                        <option value="3">Playstation Plus Extra</option>
                        <option value="4">Playstation Plus Premium</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label>Precio</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="post.precio" placeholder="Introduce el precio">
                </div>

                <div class="form-group mb-2">
                    <label>Image</label><span class="text-danger"> *</span>
                    <input type="file" class="form-control mb-2" v-on:change="onChangeImg">

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
            post: {},
            image: null,
            imgPreview: null,
            strSuccess: '',
            strError: ''
        }
    },
    methods: {
        onChangeImg(e) {
            this.image = e.target.files[0];
            this.imgPreview = URL.createObjectURL(this.image);
        },
        editarProducto() {
            let formData = new FormData();
            formData.append('nombre', this.post.nombre);
            formData.append('descripcion', this.post.descripcion);
            formData.append('id_suscripcion', this.post.id_suscripcion);
            formData.append('precio', this.post.precio);
            formData.append('file', this.image);

            this.$axios.post(`/api/posts/${this.$route.params.id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    this.strSuccess = response.data.success;
                })
                .catch(error => {
                    this.strError = error.response.data.errors;
                });
        },
        loadPost() {
            this.$axios.get(`/api/posts/${this.$route.params.id}`)
                .then(response => {
                    this.post = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        this.loadPost();
    }
}
</script>
