<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use App\Models\CarModel;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // страница со всеми клиентами и автомобилями
    public function index() {   
        $clientcars = ClientModel::index();

        return view('index',[
                'clientcars' => $clientcars
            ]); 
    }

    // страница создания нового клиента с автомобилем
    public function create() {
        return view('create');
    }

    // вставка записи о новом клиенте и его автомобиле в базу
    // происходит вставка в таблицу клиентов, автомобилей и в связующую таблицу клиент-автомобиль
    public function store(Request $request) {
        // $request: name, sex, phone, address, brand, model, color, number

        $request->validate([
            'name' => 'required|min:3',
            'sex' => 'required',
            'phone' => [
                'required', 
                'unique:clients', 
                'regex:/^(8|\+7){1}(8|9){1}[\d]{9}$/'
            ],
            'address' => 'required',

            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'number' => 'required|unique:cars|regex:/^[a-zA-Z][\d]{3}[a-zA-Z]{2}[\d]{2,3}$/'
        ]);

        // добавление записи о клиенте в таблицу клиентов
        $clientData = $request->only(['name', 'sex', 'phone', 'address']);
        $id_client = ClientModel::store($clientData);

        // добавление записи об автомобиле в таблицу автомобилей и добавление записи в таблицу клиент-автомобиль
        $carData = $request->only(['brand', 'model', 'color', 'number']);
        CarModel::store($carData, $id_client);

        return redirect()
            ->route('client.index');
    }

    // страница редактирования записи клиента
    public function edit($id) {
        // получение данных о клиенте и всех его автомобилях
        $clientcars = ClientModel::getClientInfo($id);

        return view('edit',[
            'clientcars' => $clientcars
        ]);
    }

    // редактирование клиента
    public function update(Request $request, $id) {
        //dd($request);
        $request->validate([
            'name' => 'required|min:3',
            'sex' => 'required',
            'phone' => [
                'required', 
                'regex:/^(8|\+7){1}(8|9){1}[\d]{9}$/'
            ],
            'address' => 'required'
        ]);
        
        $data = $request->all();
        ClientModel::update($data, $id);

        return redirect()
            ->route('client.index')
            ->with('success', 'Client updated');
    }

    // страница со списком автомобилей на стоянке
    public function list() {   
        // выборка информации о клиентах и автомобилях на стоянке
        $clientcarspark = ClientModel::getParkedCars();

        // выборка информации обо всех клиентах без повторений для отображения в выпадающем списке
        $clientcars = ClientModel::getAllClients();

        return view('list',[
                'clientcarspark' => $clientcarspark,
                'clientcars' => $clientcars
            ]); 
    }
}
