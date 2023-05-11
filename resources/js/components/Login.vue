<template>
    <html>
    <body>
    <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>{{error}}</strong>
    </div>
    <div class="login">
        <form class="formulario-registrar">
            <h2>Iniciar sesión</h2>
            <hr style="color: #060b53">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" v-model="email" required
                   autofocus autocomplete="off" placeholder="Introduce tu dirección de correo">

            <label for="password">Contraseña</label>
            <input id="password" type="password" v-model="password"
                   required autocomplete="off" placeholder="Introduce tu contraseña">

            <button class="boton-login" type="submit" @click="doLogin">
                Iniciar sesión
            </button>
            <br>
            <br>
            <small class="text-muted">
                No tienes cuenta aún? Por favor
                <router-link to="/register" >Registrate</router-link>
            </small>
        </form>
    </div>
    </body>
    </html>
</template>


<script>
export default {
    data() {
        return {
            email: "",
            password: "",
            error: null
        }
    },
    methods: {
        doLogin(e) {
            e.preventDefault()
            if(this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/login', {
                        email: this.email,
                        password: this.password
                    })
                        .then(response => {
                            if (response.data.success) {
                                console.error('OK');
                                this.$router.go('/login')
                            } else {
                                console.error('No login');
                                this.error = response.data.message
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                })
            }
        }
    },
    beforeRouteEnter(to, from, next){
        if(window.Laravel.isLoggedin){
            return next('dashboard');
        }
        next();
    }
}
</script>
