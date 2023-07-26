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


        // return view('index',[
        //     'clients' => DB::table('clients')
        //     ->get()
        // ]); 

        return view('index',[
                'clientcars' => $clientcars
            ]); 

//         DB::table('users')
// ->select('users.id','users.name','profiles.photo')
// ->join('profiles','profiles.id','=','users.id')
// ->where(['something' => 'something', 'otherThing' => 'otherThing'])
// ->get();
    }

    public function edit($id) {
        //$clientcars = DB::table('countries')->find($id);
        $clientcars = DB::table('clientcar')
            ->select('clientcar.id_client','clientcar.id_car','clients.name','cars.brand','cars.model','cars.number')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            ->where(['clients.id' => $id])
            ->get();

        return view('edit',[
            'clientcars' => $clientcars
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required'
        ]);

        DB::table('countries')
                ->where('id',$id)
                ->update([
                    'name' => $request->name
                ]);

        return redirect()
            ->route('country.index')
            ->with('success','Country updated');
    }
}
