<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function update(Request $request, $id) {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'number' => 'required'
        ]);

        DB::table('cars')
                ->where('id', $id)
                ->update([
                    'brand' => $request->brand,
                    'model' => $request->model,
                    'color' => $request->color,
                    'number' => $request->number
                ]);

        return redirect()
            ->route('client.index')
            ->with('success', 'Car updated');
    }

    public function destroy($id)
    {
        // получение списка автомобилей клиента
        // если удаляется единственный автомобиль - удалить клиента

        // получение id клиента удаляемого авто
        $clientId = DB::table('clientcar')
            ->select('clientcar.id_client')
            ->where('clientcar.id_car', $id)
            ->get();
   
        $clientId = $clientId[0]->id_client;

        // получение списка авто клиента
        $cars = DB::table('clientcar')
                ->select('clientcar.id_car')
                ->where(['clientcar.id_client' => $clientId])
                ->get();


        // удаление записи клиент-автомобиль
        DB::table('clientcar')->where('id_car', $id)->delete();

        // удаление записи клиента, если автомобиль единственный
        if(count($cars) === 1) {
            DB::table('clients')->where('id', $clientId)->delete();
        }

        // удаление автомобиля
        DB::table('cars')->where('id', $id)->delete();

        return redirect()
            ->route('client.index')
            ->with('success','Car deleted');
    }
}
