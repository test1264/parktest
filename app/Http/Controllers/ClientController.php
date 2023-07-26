<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {   
        $clients = DB::table('clientcar')
            ->select('clientcar.id_client','clientcar.id_car','clients.name','cars.brand','cars.model','cars.number')
            ->join('clients','clients.id','=','clientcar.id_client')
            ->join('cars','cars.id','=','clientcar.id_car')
            //->get();
            ->paginate(2);


        // return view('index',[
        //     'clients' => DB::table('clients')
        //     ->get()
        // ]); 

        return view('index',[
                'clients' => $clients
            ]); 

//         DB::table('users')
// ->select('users.id','users.name','profiles.photo')
// ->join('profiles','profiles.id','=','users.id')
// ->where(['something' => 'something', 'otherThing' => 'otherThing'])
// ->get();
    }
}
