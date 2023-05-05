<template>


    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Add New Post Data</h5>
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




            <form @submit.prevent="addPost" enctype="multipart/form-data">
                <div class="form-group mb-2">
                    <label>Nombre</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="nombre" placeholder="Introduce el nombre">
                </div>


                <div class="form-group mb-2">
                    <label>Descripcion</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="descripcion" placeholder="Introduce la descripcion"></textarea>
                </div>

                <div class="form-group mb-2">
                    <label for="suscripcion">Suscripción</label><span class="text-danger"> *</span>
                    <select class="form-control" v-model="id_suscripcion" id="suscripcion">
                        <option value="1">No tiene Suscripcion</option>
                        <option value="2">Playstation Plus Essential</option>
                        <option value="3">Playstation Plus Extra</option>
                        <option value="4">Playstation Plus Premium</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label>Precio</label><span class="text-danger"> *</span>
                    <textarea class="form-control" rows="3" v-model="precio" placeholder="Introduce el precio"></textarea>
                </div>


                <div class="form-group mb-2">
                    <label>Image</label><span class="text-danger"> *</span>
                    <input type="file" class="form-control mb-2" v-on:change="onChangeImg">


                    <div v-if="img">
                        <img v-bind:src="imgPreview" width="100" height="100"/>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary mt-4 mb-4"> Add Post</button>


            </form>


        </div>
    </div>
 </template>


 <script>
 export default {
    data() {
        return {
            nombre: '',
            descripcion: '',
            id_suscripcion: '',
            img: '',
            precio: '',
            strSuccess: '',
            strError: '',
            imgPreview: null
        }
    },
    methods: {
        onChangeImg(e) {
            this.img = e.target.files[0];
            let reader = new FileReader();
            reader.addEventListener("load", function () {
                this.imgPreview = reader.result;
            }.bind(this), false);


            if (this.img) {
                if ( /\.(jpe?g|png|gif|webp)$/i.test( this.img.name ) ) {
                    reader.readAsDataURL( this.img );
                }
            }
        },




        /*Inicio*/
        addPost(e) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                let existObj = this;
                const config = {
                    headers:{
                        'content-type': 'multipart/form-data'
                    }
                }


                const formData = new FormData();
                formData.append('nombre', this.nombre);
                formData.append('descripcion', this.descripcion);
                formData.append('id_suscripcion', this.id_suscripcion);
                formData.append('precio', this.precio);
                formData.append('file', this.img);



                this.$axios.post('/api/posts/add', formData, config)
                    .then(response => {
                        existObj.strError = "";
                        existObj.strSuccess = response.data.success;
                        }
                    )
                    .catch(function (error){
                        existObj.strError = error.response.data.message;
                        existObj.strSuccess = "";
                        }
                    );
            });
        }

    }
 }


 </script>
