<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $arfn = ['Иван', 'Петр', 'Алексей', 'Дмитрий', 'Сергей'];
        $fn = Arr::random($arfn);
        $arln = ['Иванов', 'Петров', 'Алексеев', 'Дмитриев', 'Сергеев'];
        $ln = Arr::random($arln);

        $arsex = ['Мужской', 'Женский'];
        $sex = Arr::random($arsex);

        $arbrand = ['Toyota', 'Ford', 'BMW', 'Audi', 'VW'];
        $brand = Arr::random($arbrand);
        $armodel = ['Supra', 'Focus', 'M3', 'Q5', 'Polo'];
        $model = Arr::random($armodel);

        $arcolor = ['черный', 'белый', 'серый', 'синий', 'красный'];
        $color = Arr::random($arcolor);

        // добавление записи о клиенте в таблицу клиентов и получение id-записи
        DB::insert(
            'INSERT INTO clients 
            (name, sex, phone, address)
            VALUES 
            (:name, :sex, :phone, :address)',
            [
                'name' =>  $fn . ' ' . $ln,
                'sex' => $sex,
                'phone' => '89' . rand(100000000, 999999999),
                'address' => Str::random(15)
                ] 
        );
        $id_client = DB::getPdo()->lastInsertId();

        // добавление записи об автомобиле в таблицу автомобилей и получение id-записи
        DB::insert(
            'INSERT INTO cars 
            (brand, model, color, number, is_parked, parked_at)
            VALUES 
            (:brand, :model, :color, :number, 1, NOW())',
            [
                'brand' => $brand,
                'model' => $model,
                'color' => $color,
                'number' => Str::random(1) . rand(100, 999) . Str::random(2) . rand(10, 999),
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
                'id_client' => $id_client,
                'id_car' => $id_car
                ] 
        );
    }
}
