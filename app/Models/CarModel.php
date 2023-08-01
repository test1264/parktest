<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarModel
{
    public static function store(Request $request, $id_client = 0) {
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

        // $id_client используется в случах, когда $request не содержит значения $id_client
        // если в store не было передано значение $id_client, то используется значение из $request
        if($id_client === 0) {
            $id_client = $request->id_client;
        }

        // добавление записи об автомобиле в таблицу клиент-автомобиль
        DB::insert(
            'INSERT INTO clientcar 
            (id_client, id_car)
            VALUES 
            (:id_client, :id_car)',
            [
                'id_client' => $id_client,
                'id_car' => $id_car
                ] 
        );
    }

    // редактирование данных об автомобиле
    public static function update(Request $request, $id) {
        DB::table('cars')
                ->where('id', $id)
                ->update([
                    'brand' => $request->brand,
                    'model' => $request->model,
                    'color' => $request->color,
                ]);

        $curNumber = self::getNumber($id);

        if($curNumber !== $request->number) {
            DB::table('cars')
                ->where('id', $id)
                ->update([
                    'number' => $request->number
                ]);
        }
    }

    // удаление автомобиля из базы
    public static function destroy(int $id) {
        // получение списка автомобилей клиента
        // если удаляется единственный автомобиль - удалить клиента

        // получение id клиента удаляемого авто
        $clientId = DB::table('clientcar')
            ->select('clientcar.id_client')
            ->where('clientcar.id_car', $id)
            ->get();
   
        $clientId = $clientId[0]->id_client;

        // получение списка авто клиента
        $cars = self::getCars($clientId);

        // удаление записи клиент-автомобиль
        DB::table('clientcar')->where('id_car', $id)->delete();

        // удаление записи клиента, если автомобиль единственный
        if(count($cars) === 1) {
            DB::table('clients')->where('id', $clientId)->delete();
        }

        // удаление автомобиля
        DB::table('cars')->where('id', $id)->delete();
    }

    // получение спика автомобилей, принадлежащих клиенту clientId
    public static function getCars(int $clientId) {
        $cars = DB::table('clientcar')
                ->select('clientcar.id_car', 'cars.brand', 'cars.model', 'cars.is_parked')
                ->join('cars','cars.id','=','clientcar.id_car')
                ->where(['clientcar.id_client' => $clientId])
                ->get();

        return $cars;
    }

    // обновление флага нахождения автомобиля на стоянке, установка нового времени с начала стоянки автомобиля
    public static function updateList(Request $request) {

        // если автомобиль убран со стоянки
        if($request->parkCheck == 0) {
            DB::update('UPDATE cars SET parked_at = "0000-01-01 0:00:00", is_parked = 0 WHERE id = ?', [$request->carSelect]);
        }

        // если автомобиль поставлен на стоянку
        if($request->parkCheck == 1) {
            DB::update('UPDATE cars SET parked_at = NOW(), is_parked = 1 WHERE id = ?', [$request->carSelect]);
        }
    }

    // получение номера автомобиля
    public static function getNumber($id) {
        $number = DB::table('cars')
                ->select('cars.number')
                ->where(['cars.id' => $id])
                ->get();

        return $number;
    }
}
