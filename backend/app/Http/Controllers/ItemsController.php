<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\ItemTransaction;
use Exception;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    public function getItems()
    {
        $items = Item::all();
        return $items;
    }

    public function createItem(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'title' => 'required|string',
                'unit' => 'required',
            ], [], [
                'title' => 'Título',
                'unit' => 'Unidad de medida',
            ]);

            if($validation->fails()){
                return response()->json(['status' => false, 'message' => $validation->errors()->first()]);
            }

            $item = Item::create([
                'title' => $request->title,
                'quantity' => 0,
                'unit' => $request->unit
            ]);

            if (!$item) {
                throw new Exception("error al añadir ítem.");
            }

            $allItems = Item::all();
            
            return response()->json(['status' => true, 'message' => 'el ítem se ha añadido correctamente', 'items' => $allItems]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
        
    }

    public function deleteItem($idItem){
        try {
            if (!$idItem) {
                throw new Exception("No se ha seleccionado ningún ítem a borrar.");
            }

            $response = Item::find($idItem)->delete();

            if (!$response) {
                throw new Exception("Error al borrar el ítem.");
            }

            $allItems = Item::all();

            return response()->json(['status' => true, 'message' => 'el ítem se ha borrado correctamente', 'items' => $allItems]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    public function addStock(Request $request, $idItem){
        try {
            if ($request->quantity == 0) {
                throw new Exception("Error, la cantidad ingresada es 0.");
            }

            $validation = Validator::make($request->all(), [
                'quantity' => 'required|numeric',
            ], [], [
                'quantity' => 'Cantidad',
            ]);

            if($validation->fails()){
                return response()->json(['status' => false, 'message' => $validation->errors()->first()]);
            }

            if (!$idItem) {
                throw new Exception("No se ha encontrado el ítem a modificar.");
            }

            $item = Item::find($idItem);

            $oldValue = $item->quantity;
            $newValue = $oldValue + $request->quantity;

            if($item->quantity == $newValue){
                throw new Exception("La cantidad ingresada es la misma que la actual.");
            }
            
            $response = $item->update([
                'quantity' => $newValue
            ]);

            if (!$response) {
                throw new Exception("Ha ocurrido un error, no se modificó el ítem.");
            }

            $transaction = ItemTransaction::create([
                'id_item' => $item->id,
                'quantity' => abs($request->quantity),
                'details' => [
                    'from' => $oldValue,
                    'to' => $newValue
                ]
            ]);

            if (!$transaction) {
                throw new Exception("Ha ocurrido un error, no se ha creado la transacción.");
            }

            $allItems = Item::all();

            return response()->json(['status' => true, 'message' => 'La cantidad del ítem se ha modificado correctamente', 'items' => $allItems]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    public function getTransactions($idItem){
        try {
            if (!$idItem) {
                throw new Exception("Error, no se ha enviado el ítem.");
            }
            
            $transactions = ItemTransaction::where('id_item', $idItem)->desc()->get();

            if (!$transactions) {
                throw new Exception("Error, no se han obtenido las transacciones.");
            }

            return response()->json(['status' => true, 'message' => 'Transacciones obtenidas', 'transactions' => $transactions]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }
}
