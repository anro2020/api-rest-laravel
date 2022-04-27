@component('mail::message')
# ¡Hola {{$usuario->usu_nombre}}!

Gracias por crear una cuenta. Por favor verificala usando el siguiente boton:

@component('mail::button', ['url' => route('verificar', 'token => $usuario->usu_token_verificacion')])
Confirmar mi cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
