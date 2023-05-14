<template>
    <div v-if="isLoggedin">
        <div class="registrar">
            <form @submit.prevent="updateUser" method="POST" class="formulario-registrar">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2 style="margin: 0;">Mis Datos</h2>
                    <router-link :to="{name: 'posts'}" style="margin-left: auto;">Atrás</router-link>
                </div>
                <hr>
                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" v-model="nombre">

                <label for="apellidos">Apellidos</label>
                <input id="apellidos" type="text" class="form-control" v-model="apellidos">

                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input id="fecha_nacimiento" type="date" v-model="fecha_nacimiento" required>

                <label for="direccion">Direccion</label>
                <input id="direccion" type="text" v-model="direccion" required>

                <label for="telefono">Telefono</label>
                <input id="telefono" type="text" v-model="telefono" required>

                <label for="tipo_suscripcion">Suscripción</label>
                <p>{{ tipo_suscripcion }}</p>

                <label for="duracion" class="col-sm-4 col-form-label text-md-right">Duracion</label>
                <p>{{ duracion }}</p>

                <label for="email" class="col-sm-4 col-form-label text-md-right">Correo electrónico</label>
                <input id="email" type="email" v-model="email" required>

                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                <input id="password" type="password" v-model="password">

                <button type="submit" class="boton-login">Editar usuario</button>
            </form>
<div class="tabla-dashboard">
            <div class="tabla">
                <h4>Pedidos:</h4>
                    <a class="list-group-item list-group-item-action text-dark" v-for="pedido in pedidos" :key="pedido.id" :value="pedido.id">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Pedido {{pedido.id}}</h5>
                            <small>{{pedido.fecha_pedido}}</small>
                        </div>
                        <p class="mb-1">Tipo de pago: {{pedido.tipo_pago}}</p>
                        <p class="mb-1">Precio total: {{pedido.precio_total}}€</p>
                    </a>
            </div>
</div>
        </div>
    </div>
    <div v-else>
        <h2 class="titulo-tienda">Tendrás que iniciar sesión para ver esto ;)</h2>
    </div>
</template>


<script>
export default {
    data() {
        return {
            error: null,
            isLoggedin: false,
            user: window.Laravel.user,
            nombre: '',
            apellidos: '',
            fecha_nacimiento: '',
            direccion: '',
            telefono: '',
            tipo_suscripcion: '',
            duracion: '',
            email: '',
            password: '',
            pedidos: []
        };
    },
    mounted() {
        if (window.Laravel && window.Laravel.isLoggedin) {
            this.isLoggedin = true;

            // Realizamos una petición GET para obtener los datos del usuario y rellenar el formulario
            axios.get(`/api/users/${this.user.id}`)
                .then(response => {
                    const userData = response.data;
                    this.nombre = userData.nombre;
                    this.apellidos = userData.apellidos;
                    this.fecha_nacimiento = userData.fecha_nacimiento;
                    this.direccion = userData.direccion;
                    this.telefono = userData.telefono;
                    this.tipo_suscripcion = userData.tipo_suscripcion;
                    this.duracion = userData.duracion;
                    this.email = userData.email;

                    this.obtenerPedidos(); // Llamar a la función obtenerPedidos() para obtener los pedidos del usuario
                })
                .catch(error => {
                    console.log(error);
                    this.error = 'Error al obtener los datos del usuario';
                });
        }
    },
    methods: {
        updateUser() {
            const datosActualizados = {
                nombre: this.nombre,
                apellidos: this.apellidos,
                fecha_nacimiento: this.fecha_nacimiento,
                direccion: this.direccion,
                telefono: this.telefono,
                email: this.email,
                tipo_suscripcion: this.tipo_suscripcion,
                duracion: this.duracion
            };
            if (this.password !== '') { //verifica si la contraseña no está vacía
                datosActualizados.password = this.password;
            }

            axios.post(`/api/users/${this.user.id}`, datosActualizados)
                .then(response => {
                    // Actualizar los valores del usuario en el frontend
                    const userData = response.data;
                    this.nombre = userData.nombre;
                    this.apellidos = userData.apellidos;
                    this.fecha_nacimiento = userData.fecha_nacimiento;
                    this.direccion = userData.direccion;
                    this.telefono = userData.telefono;
                    this.tipo_suscripcion = userData.tipo_suscripcion;
                    this.duracion = userData.duracion;
                    this.email = userData.email;

                    notie.alert({type: 'success', text: 'Datos Actualizados', time: 3 });
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 3000);
                })
                .catch(error => {
                    console.log(error);
                    this.error = 'Error al actualizar el usuario';
                    notie.alert({type: 'error', text: 'Error al actualizar', time: 3 });
                });
        },
        obtenerPedidos() {
            axios.get(`/api/posts/${this.user.id}`)
                .then(response => {
                    const pedidos = response.data;

                    // Actualizar el array de pedidos con los datos obtenidos
                    this.pedidos = pedidos;
                })
                .catch(error => {
                    console.log(error);
                    this.error = 'Error al obtener los pedidos';
                });
        }

    }
};

</script>
