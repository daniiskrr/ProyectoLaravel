<template>

    <div v-if="isLoggedin && user.role === 'Administrador'" class="card">
        <div class="carrito" style="padding-top: 2.3rem">
            <div class="tabla">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h5 style="margin: 0;">Lista de Usuarios</h5>
                    <button style="margin-left: auto;" type="button" @click="this.$router.push('/adduser')">Nuevo Usuario</button>
            </div>
                <hr style="color: white">
            <table>
                <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nombre y apellidos</th>
                    <th>Correo</th>
                    <th>Datos</th>
                    <th width="1px">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(usuario, index) in users" :key="usuario.id">
                    <td>{{index}}</td>
                    <td>Nombre: {{usuario.nombre}} <br> Apellidos: {{usuario.apellidos}}</td>
                    <td>{{usuario.email}}</td>
                    <td>Fecha Nacimiento: {{usuario.fecha_nacimiento}} <br>
                        Direccion: {{usuario.direccion}} <br>
                        Telefono: {{usuario.telefono}} <br>
                        Suscripción: {{usuario.tipo_suscripcion}} <br>
                        Duración: {{usuario.duracion}}<br>
                        Rol: {{usuario.rol}} </td>
                    <td class="botones-accion">
                        <router-link :to="{ name: 'EditUser', params: { id: usuario.id }}"><button style="margin-bottom: 10%"><img class="editar" src="../../images/boligrafo.svg" Editar/></button></router-link>
                        <button @click="eliminaUsuario(post.id)"><img class="cruzz" src="../../images/cruz.svg" Borrar/></button>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
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
            users: [],
            strSuccess: '',
            strError: '',
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
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            //Llamamos a la api con la ruta correspondiente para poder obtener los datos de los usuarios y mostrarlos en el panel
                this.$axios.get('/api/users')
                    .then(response => {
                        this.users = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        );
    },
    methods: {
        //Método para mandar a la api el id del usuario que hemos seleccionado y eliminarlo.
        eliminaUsuario(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                axios.delete('http://127.0.0.1:8000/api/users/' + id)
                    .then(response => {
                        const index = this.users.findIndex(user => user.id === id);
                        this.users.splice(index, 1);
                        notie.alert({type: 'success', text: 'Usuario eliminado con éxito', time: 3 });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            });
        }
    }
}

</script>

