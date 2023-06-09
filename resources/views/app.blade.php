<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{env('APP_NAME')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/notie/dist/notie.min.css">
    @vite(['resources/js/app.js','resources/css/app.css'])
</head>
<body>
@if (Auth::check())
    <script>
        window.Laravel = {
            isLoggedin: true,
            user: {
                id: {{ Auth::user()->id }},
                nombre: "{{ Auth::user()->nombre }}",
                tipo_suscripcion: "{{ Auth::user()->tipo_suscripcion}}",
                duracion: "{{ Auth::user()->duracion}}",
                email: "{{ Auth::user()->email }}",
                role: "{{ Auth::user()->roles()->first()->nombre }}"
            }
        }
    </script>
@else
    <script>
        window.Laravel = {
            isLoggedin: false
        }
    </script>
@endif
<div id="app"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js"></script>
</body>
</html>


<script>
    export default {
        name: "App",
        data() {
            return {

            }
        },
        created() {
        },
        methods: {

        },
    }
</script>

