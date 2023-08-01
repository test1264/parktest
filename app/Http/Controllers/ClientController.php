<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Datetime;
use \DateTimeZone;

class ClientController extends Controller
{
    // страница со всеми клиентами и автомобилями
    public function index() {   
        $clientcars = DB::table('clientcar')
            ->select('clientcar.id_client','clientcar.id_car','clients.name','cars.brand','cars.model','cars.number')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            ->paginate(4);

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

        // вставка в таблицу клиентов, с получением id-записи
        $id_client = DB::table('clients')->insertGetId([
            'name' => $request->name,
            'sex' => $request->sex,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        $now = new DateTime();
        $now->format('Y-m-d H:i:s');

        $timezone = new DateTimeZone('Europe/Moscow');
        $now->setTimezone($timezone);

        $now->getTimestamp(); 

        // вставка в таблицу автомобилей, с получением id-записи
        $id_car = DB::table('cars')->insertGetId([
            'brand' => $request->brand,
            'model' => $request->model,
            'color' => $request->color,
            'number' => $request->number,
            'is_parked' => 1,
            'parked_at' => $now
        ]);

        // вставка в таблицу связующую клиент-автомобиль id новый записей
        DB::table('clientcar')->insert([
            'id_client' => $id_client,
            'id_car' => $id_car
        ]);

        return redirect()
            ->route('client.index');
    }

    // страница редактирования записи клиента
    public function edit($id) {
        $clientcars = DB::table('clientcar')
            ->select('clientcar.id_client', 'clientcar.id_car',
                'clients.name', 'clients.sex', 'clients.phone', 'clients.address',
                'cars.brand', 'cars.model', 'cars.color', 'cars.number')
            ->join('clients', 'clients.id', '=', 'clientcar.id_client')
            ->join('cars', 'cars.id', '=', 'clientcar.id_car')
            ->where(['clients.id' => $id])
            ->get();

        return view('edit',[
            'clientcars' => $clientcars
        ]);
    }

    // редактирование клиента
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|min:3',
            'sex' => 'required',
            'phone' => [
                'required', 
                'unique:clients', 
                'regex:/^(8|\+7){1}(8|9){1}[\d]{9}$/'
            ],
            'address' => 'required'
        ]);

        DB::table('clients')
                ->where('id', $id)
                ->update([
                    'name' => $request->name,
                    'sex' => $request->sex,
                    'phone' => $request->phone,
                    'address' => $request->address
                ]);

        return redirect()
            ->route('client.index')
            ->with('success', 'Client updated');
    }

    // страница со списком автомобилей на стоянке
    public function list() {   
        // выборка информации о клиентах и автомобилях на стоянке
        $clientcarspark = DB::table('clientcar')
            ->select('clientcar.id_client','clientcar.id_car','clients.name','cars.brand','cars.model','cars.number', 'cars.color', 'cars.is_parked', 'cars.parked_at')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            ->where('cars.is_parked', '1')
            ->paginate(4);

        // выборка информации обо всех клиентах без повторений для отображения в выпадающем списке
        $clientcars = DB::table('clientcar')
            ->select('clientcar.id_client','clients.name')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            ->groupBy('clientcar.id_client')
            ->get();

        return view('list',[
                'clientcarspark' => $clientcarspark,
                'clientcars' => $clientcars
            ]); 
    }
}
