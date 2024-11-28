<?php

namespace App\Http\Controllers\Mold;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mold\MoldCollection;
use App\Http\Resources\Mold\MoldResource;
use Illuminate\Http\Request;
use App\Models\Mold;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;

class MoldController extends Controller
{
   
    public function index()
    {
        $molds = Mold::orderBy('id', 'asc')->get();
        return new MoldCollection($molds);
    }

    public function store(Request $request)
    {
        $rules = [
            'code_mold' => 'required|unique:molds',
            'name_mold' => 'required|string',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ];
        $message = [
            'code_mold.required' => 'El código del Molde es obligatorio.',
            'code_mold.unique' => 'El código del Molde ya está en uso.',
            'name_mold.required' => 'El nombre del Molde es obligatorio.',
            'width.required' => 'El ancho es obligatorio.',
            'height.required' => 'La altura es obligatoria.',
        ];
        // VALIDAR DATOS
        $request->validate($rules, $message);

        // GUARDAR EL CONDUCTOR
        $mold = Mold::create([
            'code_mold' => $request['code_mold'],
            'name_mold' => $request['name_mold'],
            'width' => $request['width'],
            'height' => $request['height'],
        ]);
        
        // RETORNAR RESPUESTA JSON
        return response()->json([
            "message" => "El tablero fue registrado exitosamente",
            "molds" => new MoldResource($mold)
        ], 201);
    }

   
    public function show(string $id)
    {
        $mold = Mold::find($id);

        if (!$mold) {
            return response()->json([
                "message" => "No se encontró el tablero",
            ], 404);
        }

        return new MoldResource($mold);
    }

    
    public function update(Request $request, string $id)
    {
        $mold = Mold::find($id);

        if (!$mold) {
            return response()->json([
                "message" => "No se encontró el tablero",
            ], 404);
        }

        $rules = [
            'code_mold' => 'required|unique:molds,code_mold,' . $mold->id,
            'name_mold' => 'required|string',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ];

        $messages = [
            'code_mold.required' => 'El código del tablero es obligatorio.',
            'code_mold.unique' => 'El código del tablero ya está en uso.',
            'name_mold.required' => 'La ubicación es obligatoria.',
            'width.required' => 'El ancho es obligatorio.',
            'height.required' => 'La altura es obligatoria.',
        ];

        // VALIDAR DATOS
        $validatedData = $request->validate($rules, $messages);

        // ACTUALIZAR EL CONDUCTOR
        $mold->update($validatedData);

        return response()->json([
            "message" => "El tablero fue actualizado!",
            "molds" => new MoldResource($mold),
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $molds = Mold::find($id);

        if (!$molds) {
            return response()->json([
                "message" => "NO SE ENCONTRO EL CONDUCTOR",
            ], 404);
        }

        $molds->status = $molds->status == 1 ? 0 : 1;
        $molds->save();

        return response()->json([
            "message" => "El estado del tablero fue actualizado!",
            "molds" => $molds
        ], 200);
    }
}
