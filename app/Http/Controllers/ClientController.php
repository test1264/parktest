<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index() {   
        $clientcars = DB::table('clientcar')
            ->select('clientcar.id_client','clientcar.id_car','clients.name','cars.brand','cars.model','cars.number')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            ->paginate(2);

        return view('index',[
                'clientcars' => $clientcars
            ]); 

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
}
