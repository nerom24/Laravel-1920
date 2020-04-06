@component('mail::message')
# Proyecto Laravel Curso 19/20 
# DWES 19/20 - ieslosremedios.org 

Estimado {{$user->name}}:

Gracias por haberse registrado en nuestra aplicación. Ha sido incluido
en nuestra lista de usuarios con perfil de usuario registrado o genérico.

Sus datos de acceso son:

@component('mail::table')
| Usuario               | Email                |Perfil                 |
| --------------------- |--------------------- |---------------------  |
| {{$user->name}}       |  {{$user->email}}    | Usuario Registrado    |

@endcomponent

{{-- @component('mail::panel') Este es el contenido de mi panel @endcomponent --}}

{{-- @component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
@endcomponent --}}

Ahora deberá activar su cuenta mediante el siguiente enlace
@component('mail::button', ['url' => ''])
Button Text
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
