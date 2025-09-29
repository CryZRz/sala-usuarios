<?php

namespace App\Http\Controllers;

use App\Http\Utils\Interfaces\HasModule;
use App\Models\Computer;
use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller implements HasModule
{
    public function hasModule() : string{
        return "ports";
    }

    public function store(Request $request){
        $this->validate($request, [
           "type" => "required",
           "amount" => ["required", "numeric"],
           "computer" => ["required", "numeric" ,"exists:computers,id"]
        ]);

        $type = $request->input("type");
        $amount = $request->input("amount");
        $computer = $request->input("computer");

        $port = Port::create([
            "type" => strtoupper($type),
            "amount" => $amount,
            "computer_id" => $computer
        ]);

        return response($port, 200);
    }

    public function update(Port $port, Request $request) {
        $this->validate($request, [
            "type" => ["required"],
            "amount" => ["required", "numeric"],
        ]);

        $port->type = $request->get("type");
        $port->amount = $request->get("amount");
        $port->save();

        return response($port, 200);
    }

    public function destroy(Port $port){
        $port->delete();
        return response(null, 203);
    }

    public function showByComputer(Computer $computer, Request $request){
        $find = $request->get("find");

        if ($find) {
            $ports = $computer->ports()->where("type","LIKE","%$find%")->paginate(10);

            return response()->json($ports, 200);
        }

        $ports =$computer->ports()->paginate(10);

        return response()->json($ports, 200);
    }
}
