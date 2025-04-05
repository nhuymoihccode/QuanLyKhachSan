<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index(){
        $shifts = Shift::paginate(5);
        return view("shift.index")->with('shifts', $shifts);
    }
    public function search(Request $request){
        $searchTerm = $request->input('search');

        $shifts = Shift::where(function($query) use ($searchTerm) {
            $query->where('start_time', 'like', '%' . $searchTerm . '%')
                  ->orWhere('date', 'like', '%' . $searchTerm . '%');
        })->paginate(5);

        return view("shift.index")->with('shifts', $shifts);
    }

    public function create(){
        return view('shift.create');
    }

    public function store(Request $request){
        
        Shift::create([
            'employee_id'=> $request->input('employee_id'),
            'start_time'=> $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'date'=>$request->input('date'),
        ]);
        return redirect()->route('shift.index');
    }

    public function edit($id){
        $shift = Shift::findOrFail($id);
        return view('shift.edit')->with('shift', $shift);
    }

    public function update(Request $request){
        $shift = Shift::findOrFail($request->id);
        
        $shift->update([
            'employee_id'=> $request->input('employee_id'),
            'start_time'=> $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'date'=>$request->input('date'),
        ]);
        return redirect()->route('shift.index');
    }
    public function delete($id) {
        $shift = Shift::find($id);
        if ($shift) {
            $shift->delete();
            return redirect()->route('shift.index')->with('success', 'Ca làm đã được xóa thành công!');
        }
        // return redirect()->route('shift.index')->with('error', 'Ca làm không tồn tại!');
    }
}
