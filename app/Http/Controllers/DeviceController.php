<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(){
        $devices = Device::paginate(5);
        return view("device.index")->with('devices', $devices);
    }
    public function search(Request $request){
        $searchTerm = $request->input('search');

        $devices = Device::where(function($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                  ->orwhere('quantity', 'like', '%' . $searchTerm . '%');
        })->paginate(5);

        return view("device.index")->with('devices', $devices);
    }

    public function create(){
        return view('device.create');
    }

    public function store(Request $request){
        
        Device::create([
            'room_id'=> $request->input('room_id'),
            'name'=> $request->input('name'),
            'type' => $request->input('type'),
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('device.index');
    }

    public function edit($id){
        $device = Device::findOrFail($id);
        return view('device.edit')->with('device', $device);
    }

    public function update(Request $request){
        $device = Device::findOrFail($request->id);
        
        $device->update([
            'room_id'=> $request->input('room_id'),
            'name'=> $request->input('name'),
            'type' => $request->input('type'),
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('device.index');
    }
    public function delete($id) {
        $device = Device::find($id);
        if ($device) {
            $device->delete();
            return redirect()->route('device.index')->with('success', 'Thiết bị đã được xóa thành công!');
        }
        // return redirect()->route('device.index')->with('error', 'Thiết bị không tồn tại!');
    }
}
