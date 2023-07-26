<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
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
