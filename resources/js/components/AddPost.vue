<template>
    <div v-if="isLoggedin && user.role === 'Administrador'" class="card">
        <div class="registrar">
            <form @submit.prevent="addPost" enctype="multipart/form-data" class="formulario-registrar">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2 style="margin: 0;">Crear Nuevo Producto</h2>
                    <router-link :to="{name: 'posts'}" style="margin-left: auto;">Atrás</router-link>
                </div>
                <hr>
                <label>Nombre *</label>
                <input type="text" class="form-control" v-model="nombre" placeholder="Introduce el nombre">

                <label>Descripcion *</label>
                <textarea class="form-control" rows="3" v-model="descripcion" placeholder="Introduce la descripcion"></textarea>

                <label for="suscripcion">Suscripción *</label>
                <select style="background-color: #e7e9ee;" v-model="id_suscripcion" id="suscripcion">
                    <option value="1">No tiene Suscripcion</option>
                    <option value="2">Playstation Plus Essential</option>
                    <option value="3">Playstation Plus Extra</option>
                    <option value="4">Playstation Plus Premium</option>
                </select>

                <label>Precio *</label>
                <textarea rows="3" v-model="precio" placeholder="Introduce el precio" style="background-color: #e7e9ee;"></textarea>

                <label>Imagen *</label>
                <input type="file" v-on:change="onChangeImg">

                <div v-if="img">
                    <img v-bind:src="imgPreview" width="100" height="100"/><br><br>
                </div>

                <button type="submit" class="boton-login">Crear Producto</button>
            </form>
        </div>
    </div>
    <div v-else>
        <h2 class="titulo-tienda">Buen intento! Prueba de nuevo, quizás lo consigues</h2>
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
            imgPreview: null,
            isLoggedin: false,
            user: window.Laravel.user
        }
    },
    mounted() {
        if (window.Laravel && window.Laravel.isLoggedin) {
            this.isLoggedin = true;
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
                            notie.alert({type: 'success', text: response.data.success, time: 3});
                            existObj.strError = "";
                            existObj.strSuccess = response.data.success;
                        setTimeout(() => {
                            window.location.href = '/posts';
                        }, 3000);
                        }
                    )
                    .catch(function (error){
                            existObj.strError = error.response.data.message;
                            existObj.strSuccess = "";
                            notie.alert({ type: 'error', text: "Revisa bien los campos, por favor" });
                        }
                    );
            });
        }

    }
}


</script>
