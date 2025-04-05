<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        $services = Service::paginate(5);
        return view("service.index")->with('services', $services);
    }
    public function search(Request $request){
        $searchTerm = $request->input('search');

        $services = Service::where(function($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('price', 'like', '%' . $searchTerm . '%');
        })->paginate(5);

        return view("service.index")->with('services', $services);
    }

    public function create(){
        return view('service.create');
    }

    public function store(Request $request){
        
        Service::create([
            'name'=> $request->input('name'),
            'description' => $request->input('description'),
            'price'=>$request->input('price'),
        ]);
        return redirect()->route('service.index');
    }

    public function edit($id){
        $service = Service::findOrFail($id);
        return view('service.edit')->with('service', $service);
    }

    public function update(Request $request){
        $service = Service::findOrFail($request->id);
        
        $service->update([
            'name'=> $request->input('name'),
            'description' => $request->input('description'),
            'price'=>$request->input('price'),
        ]);
        return redirect()->route('service.index');
    }
    public function delete($id) {
        $service = Service::find($id);
        if ($service) {
            $service->delete();
            return redirect()->route('service.index')->with('success', 'Dịch vụ đã được xóa thành công!');
        }
        // return redirect()->route('service.index')->with('error', 'Dịch vụ không tồn tại!');
    }
}
