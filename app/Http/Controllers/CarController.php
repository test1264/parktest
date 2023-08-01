<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // вставка записи о новом автомобиле
    public function store(Request $request) {
        // $request: brand, model, color, number, id_client

        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'number' => 'required|unique:cars|regex:/^[a-zA-Z][\d]{3}[a-zA-Z]{2}[\d]{2,3}$/'
        ]);

        $data = $request->all();
        CarModel::store($request);

        return redirect()
            ->route('client.index');
    }

    // редактирование данных об автомобиле
    public function update(Request $request, $id) {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'number' => 'required|regex:/^[a-zA-Z][\d]{3}[a-zA-Z]{2}[\d]{2,3}$/'
        ]);

        $data = $request->all();
        CarModel::update($data, $id);

        return redirect()
            ->route('client.index')
            ->with('success', 'Car updated');
    }

    // удаление автомобиля из базы
    public function destroy(int $id) {
        
        CarModel::destroy($id);

        return redirect()
            ->route('client.index')
            ->with('success','Car deleted');
    }

    // обновление флага нахождения автомобиля на стоянке, установка нового времени с начала стоянки автомобиля
    public function updateList(Request $request) {

        $data = $request->all();
        CarModel::updateList($data);

        return redirect()
            ->route('client.index');
    }

    // получение спика автомобилей, принадлежащих клиенту clientId
    public function getCars($clientId) {

        $cars = CarModel::getCars($clientId);

        echo $cars;
    }
}
