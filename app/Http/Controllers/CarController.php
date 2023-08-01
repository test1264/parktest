<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    // вставка записи о новом автомобиле
    public function store(Request $request) {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'number' => 'required|unique:cars|regex:/^[a-zA-Z][\d]{3}[a-zA-Z]{2}[\d]{2,3}$/'
        ]);

        // добавление записи об автомобиле в таблицу автомобилей
        DB::insert(
            'INSERT INTO cars 
            (brand, model, color, number, is_parked, parked_at)
            VALUES 
            (:brand, :model, :color, :number, 1, NOW())',
            [
                'brand' => $request->brand,
                'model' => $request->model,
                'color' => $request->color,
                'number' => $request->number
                ] 
        );
        $id_car = DB::getPdo()->lastInsertId();

        // добавление записи об автомобиле в таблицу клиент-автомобиль
        DB::insert(
            'INSERT INTO clientcar 
            (id_client, id_car)
            VALUES 
            (:id_client, :id_car)',
            [
                'id_client' => $request->id_client,
                'id_car' => $id_car
                ] 
        );

        return redirect()
            ->route('client.index');
    }

    // редактирование данных об автомобиле
    public function update(Request $request, $id) {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'number' => 'required|unique:cars|regex:/^[a-zA-Z][\d]{3}[a-zA-Z]{2}[\d]{2,3}$/'
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

    // удаление автомобиля из базы
    public function destroy($id) {
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

    // обновление флага нахождения автомобиля на стоянке, установка нового времени с начала стоянки автомобиля
    public function updateList(Request $request) {

        // если автомобиль убран со стоянки
        if($request->parkCheck == 0) {
            DB::update('UPDATE cars SET parked_at = "0000-01-01 0:00:00", is_parked = 0 WHERE id = ?', [$request->carSelect]);
        }

        // если автомобиль поставлен на стоянку
        if($request->parkCheck == 1) {
            DB::update('UPDATE cars SET parked_at = NOW(), is_parked = 1 WHERE id = ?', [$request->carSelect]);
        }

        return redirect()
            ->route('client.index');
    }

    // получение спика автомобилей, принадлежащих клиенту clientId
    public function getCars($clientId) {
        $cars = DB::table('clientcar')
                ->select('clientcar.id_car', 'cars.brand', 'cars.model', 'cars.is_parked')
                ->join('cars','cars.id','=','clientcar.id_car')
                ->where(['clientcar.id_client' => $clientId])
                ->get();

        echo $cars;
    }
}
