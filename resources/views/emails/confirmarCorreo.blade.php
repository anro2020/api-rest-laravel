@component('mail::message')
# ¡Hola {{$usuario->usu_nombre}}!

Haz cambiado tu direccion de correo electronico, Por favor verificala usando el siguiente boton:

@component('mail::button', ['url' => route('verificar', $usuario->usu_token_verificacion)])
Confirmar mi cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent

