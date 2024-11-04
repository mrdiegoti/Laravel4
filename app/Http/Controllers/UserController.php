<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validación de los datos de entrada del registro de usuario
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Nombre requerido, cadena, máximo 255 caracteres
            'email' => 'required|string|email|max:255|unique:users', // Email requerido, único en la tabla de usuarios
            'password' => 'required|string|min:6', // Contraseña requerida, mínimo 6 caracteres
            'c_password' => 'required|same:password', // Confirmación de contraseña debe coincidir
        ]);

        // Si la validación falla, devuelve un error 400 con los mensajes de validación
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // Crear un nuevo usuario en la base de datos
        $user = User::create([
            'name' => $request->get('name'), // Obtener el nombre del request
            'email' => $request->get('email'), // Obtener el email del request
            'password' => Hash::make($request->get('password')), // Hashear la contraseña
        ]);

        // Respuesta exitosa indicando que el usuario ha sido creado
        return response()->json(['message' => 'User Created', 'data' => $user], 200);
    }

    public function show(User $user)
    {
        // Devuelve la información del usuario solicitado
        return response()->json(['message' => '', 'data' => $user], 200);
    }

    public function bookEvent(Request $request, User $user, Event $event)
    {   // Se crea una variable note y se inicializa vacía
        $note = '';
        // Si hay una nota en el request, se guarda
        if ($request->get('note')) {
            $note = $request->get('note');
        }

        // Asocia el evento al usuario, guardando la nota si está presente
        if ($user->events()->save($event, ['note' => $note])) {
            return response()->json(['message' => 'User Event Created', 'data' => $event], 200); // Respuesta exitosa
        }
        return response()->json(['message' => 'Error', 'data' => null], 400); // Respuesta de error
    }

    public function listEvents(User $user)
    {
        // Recupera todos los eventos asociados al usuario
        $events = $user->events;
        return response()->json(['message' => null, 'data' => $events], 200); // Devuelve la lista de eventos
    }



}
