<?php

namespace App\Http\Controllers\Produccion;

use App\Http\Controllers\Controller;
use App\Http\Resources\Produccion\ProduccionCollection;
use App\Http\Resources\Produccion\ProduccionResource;
use Illuminate\Http\Request;
use App\Models\Produccion;

class ProduccionController extends Controller
{
   
    public function index(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $produccionQuery = Produccion::orderBy('id', 'asc');

        if ($start_date) {
            $produccionQuery->whereDate('created_at', '>=', $start_date);
        }

        if ($end_date) {
            $produccionQuery->whereDate('created_at', '<=', $end_date);
        }

        $produccion = $produccionQuery->get();

        return new ProduccionCollection($produccion);
    }

    public function store(Request $request)
    {
        $rules = [
            'cod_order' => 'required',
            'merma' => 'required',
            'espacio_usado' => 'required',
            'imagen' => 'required',
        ];
        $messages = [
            'cod_order.required' => 'El código de orden es obligatorio.',
            'merma.required' => 'La merma es obligatoria.',
            'espacio_usado.required' => 'El espacio es obligatorio.',
            'imagen.required' => 'La imagen es obligatoria.',
        ];
        
        // Validar datos
        $request->validate($rules, $messages);
    
        $lastCodProduccion = Produccion::max('cod_produccion');
        $newCodNumber = $lastCodProduccion ? (int)$lastCodProduccion + 1 : 1;
        $newCodProduccion = str_pad($newCodNumber, 4, '0', STR_PAD_LEFT); 
    
        $produccion = Produccion::create([
            'cod_produccion' => $newCodProduccion,
            'cod_order' => $request['cod_order'],
            'merma' => $request['merma'],
            'espacio_usado' => $request['espacio_usado'],
            'imagen' => $request['imagen'],
        ]);
        
        // Retornar respuesta JSON
        return response()->json([
            "message" => "LA PRODUCCION FUE REGISTRADO EXITOSAMENTEE",
            "produccion" => new ProduccionResource($produccion)
        ], 201);
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
