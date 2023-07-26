<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Datetime;

class ClientController extends Controller
{
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

    public function create() {
        return view('create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'sex' => 'required',
            'phone' => 'required',
            'address' => 'required',

            'brand' => 'required',
            'model' => 'required',
            'color' => 'required',
            'number' => 'required'
        ]);

        $id_client = DB::table('clients')->insertGetId([
            'name' => $request->name,
            'sex' => $request->sex,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        $now = new DateTime();
        echo $now->format('Y-m-d H:i:s');
        echo $now->getTimestamp(); 

        $id_car = DB::table('cars')->insertGetId([
            'brand' => $request->brand,
            'model' => $request->model,
            'color' => $request->color,
            'number' => $request->number,
            'is_parked' => 1,
            'parked_at' => $now
        ]);

        DB::table('clientcar')->insert([
            'id_client' => $id_client,
            'id_car' => $id_car
        ]);

        return redirect()
            ->route('client.index');
    }

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

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'sex' => 'required',
            'phone' => 'required',
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

    public function list() {   
        $clientcarspark = DB::table('clientcar')
            ->select('clientcar.id_client','clientcar.id_car','clients.name','cars.brand','cars.model','cars.number', 'cars.color', 'cars.is_parked', 'cars.parked_at')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            ->where('cars.is_parked', '1')
            ->paginate(4);

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
