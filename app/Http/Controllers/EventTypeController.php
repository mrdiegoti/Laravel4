<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EventTypeController extends Controller
{
    public function listEvents(EventType $type){
        $events = $type->events;
        return response()->json(['message'=>null,'data'=>$events],200);
}
    public function store(Request $request)
    {
        // Validación de los datos de entrada del registro de usuario
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
        ]);

        // Si la validación falla, devuelve un error 400 con los mensajes de validación
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // Crear un nuevo tipo de evento en la base de datos
        $type = EventType::create([
            'description' => $request->get('description')
        ]);

        // Respuesta exitosa indicando que el tipo de evento ha sido creado
        return response()->json(['message' => 'Event type created', 'data' => $type], 200);
    }

}

