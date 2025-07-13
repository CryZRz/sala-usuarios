<?php

namespace App\Http\Controllers;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller implements HasModule
{
    public function hasModule() : string{
        return "ports";
    }

    public function update(Port $port, Request $request) {
        $this->validate($request, [
            "type" => ["required"],
            "amount" => ["required", "numeric"],
        ]);

        $port->type = $request->get("type");
        $port->amount = $request->get("amount");
        $port->save();

        return response(null, 203);
    }

    public function destroy(Port $port){
        $port->delete();
        return response(null, 203);
    }
}
