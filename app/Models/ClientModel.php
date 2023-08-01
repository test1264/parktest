<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ClientModel
{
    // получение информации обо всех клиентах и их автомобилях
    public static function index() {
        $clientcars = DB::table('clientcar')
            ->select('clientcar.id_client','clientcar.id_car','clients.name','cars.brand','cars.model','cars.number')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            ->paginate(4);

        return $clientcars;
    }

    // добавление нового клиента
    public static function store(array $data) {
        DB::insert(
            'INSERT INTO clients 
            (name, sex, phone, address)
            VALUES 
            (:name, :sex, :phone, :address)',
            [
                'name' => $data['name'],
                'sex' => $data['sex'],
                'phone' => $data['phone'],
                'address' => $data['address']
                ] 
        );
        $id = DB::getPdo()->lastInsertId();

        return $id;
    }

    // получение информации о клиенте и его автомобилях
    public static function getClientInfo($id) {
        $clientcars = DB::table('clientcar')
        ->select('clientcar.id_client', 'clientcar.id_car',
            'clients.name', 'clients.sex', 'clients.phone', 'clients.address',
            'cars.brand', 'cars.model', 'cars.color', 'cars.number')
        ->join('clients', 'clients.id', '=', 'clientcar.id_client')
        ->join('cars', 'cars.id', '=', 'clientcar.id_car')
        ->where(['clients.id' => $id])
        ->get();

        return $clientcars;
    }

    // редактирование информации о клиенте
    public static function update(array $data, $id) {
        DB::table('clients')
                ->where('id', $id)
                ->update([
                    'name' => $data['name'],
                    'sex' => $data['sex'],
                    'phone' => $data['phone'],
                    'address' => $data['address']
                ]);

        $curPhone = self::getPhone($id);

        if($curPhone !== $data['phone']) {
            DB::table('clients')
                ->where('id', $id)
                ->update([
                    'phone' => $data['phone']
                ]);
        }

    }

    // получение информации об автомобилях на стоянке и их владельцах
    public static function getParkedCars() {
        $clientcarspark = DB::table('clientcar')
            ->select('clientcar.id_client','clientcar.id_car','clients.name','cars.brand','cars.model','cars.number', 'cars.color', 'cars.is_parked', 'cars.parked_at')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            ->where('cars.is_parked', '1')
            ->paginate(4);

        return $clientcarspark;
    }

    // выборка информации обо всех клиентах без повторений
    public static function getAllClients() {
        $clientcars = DB::table('clientcar')
            ->select('clientcar.id_client','clients.name')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            ->groupBy('clientcar.id_client')
            ->get();

        return $clientcars;
    }

    // получение номера клиента
    public static function getPhone($id) {
        $phone = DB::table('clients')
                ->select('clients.phone')
                ->where(['clients.id' => $id])
                ->get();

        return $phone;
    }
}