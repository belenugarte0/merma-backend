<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Http\Resources\Board\BoardCollection;
use App\Http\Resources\Board\BoardResource;
use Illuminate\Http\Request;
use App\Models\Board;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;

class BoardController extends Controller
{
   
    public function index()
    {
        $boards = Board::orderBy('id', 'asc')->get();
        return new BoardCollection($boards);
    }

    public function store(Request $request)
    {
        $rules = [
            'code_board' => 'required|unique:boards',
            'location' => 'required|string',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ];
        $message = [
            'code_board.required' => 'El código del tablero es obligatorio.',
            'code_board.unique' => 'El código del tablero ya está en uso.',
            'location.required' => 'La ubicación es obligatoria.',
            'width.required' => 'El ancho es obligatorio.',
            'height.required' => 'La altura es obligatoria.',
        ];
        // VALIDAR DATOS
        $request->validate($rules, $message);

        // GUARDAR EL CONDUCTOR
        $board = Board::create([
            'code_board' => $request['code_board'],
            'location' => $request['location'],
            'width' => $request['width'],
            'height' => $request['height'],
        ]);
        
        // RETORNAR RESPUESTA JSON
        return response()->json([
            "message" => "El tablero fue registrado exitosamente",
            "boards" => new BoardResource($board)
        ], 201);
    }

   
    public function show(string $id)
    {
        $board = Board::find($id);

        if (!$board) {
            return response()->json([
                "message" => "No se encontró el tablero",
            ], 404);
        }

        return new BoardResource($board);
    }

    
    public function update(Request $request, string $id)
    {
        $board = Board::find($id);

        if (!$board) {
            return response()->json([
                "message" => "No se encontró el tablero",
            ], 404);
        }

        $rules = [
            'code_board' => 'required|unique:boards,code_board,' . $board->id,
            'location' => 'required|string',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ];

        $messages = [
            'code_board.required' => 'El código del tablero es obligatorio.',
            'code_board.unique' => 'El código del tablero ya está en uso.',
            'location.required' => 'La ubicación es obligatoria.',
            'width.required' => 'El ancho es obligatorio.',
            'height.required' => 'La altura es obligatoria.',
        ];

        // VALIDAR DATOS
        $validatedData = $request->validate($rules, $messages);

        // ACTUALIZAR EL CONDUCTOR
        $board->update($validatedData);

        return response()->json([
            "message" => "El tablero fue actualizado!",
            "boards" => new BoardResource($board),
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $boards = Board::find($id);

        if (!$boards) {
            return response()->json([
                "message" => "NO SE ENCONTRO EL CONDUCTOR",
            ], 404);
        }

        $boards->status = $boards->status == 1 ? 0 : 1;
        $boards->save();

        return response()->json([
            "message" => "El estado del tablero fue actualizado!",
            "boards" => $boards
        ], 200);
    }
}
