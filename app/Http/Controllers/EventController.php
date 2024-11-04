<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function listUsers(Event $event)
    {
        // Recupera todos los usuarios asociados al evento dado
        $users = $event->users;

        // Devuelve una respuesta JSON con la lista de usuarios
        return response()->json(['message' => null, 'data' => $users], 200);
    }

    public function store(Request $request)
    {
        // Validación de los datos de entrada para crear un nuevo evento
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255', // Nombre del evento requerido
            'event_detail' => 'required|string|max:255', // Detalle del evento requerido
            'event_type_id' => 'required|string|max:255',
        ]);

        // Si la validación falla, devuelve un error 400 con los mensajes de validación
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // Crear un nuevo evento en la base de datos
        $event = Event::create([
            'event_name' => $request->get('event_name'), // Obtener el nombre del evento del request
            'event_detail' => $request->get('event_detail'), // Obtener el detalle del evento del request
            'event_type_id' => $request->get('event_type_id'),
        ]);

        // Respuesta exitosa indicando que el evento ha sido creado
        return response()->json(['message' => 'Event created', 'data' => $event], 200);
    }

}
