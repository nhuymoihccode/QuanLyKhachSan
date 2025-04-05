<?php

namespace App\Http\Controllers;

use App\Events\StaffCreated;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::paginate(5);
        return view("staff.index")->with('staffs', $staffs);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $staffs = Staff::where(function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('position', 'like', '%' . $searchTerm . '%')
                ->orWhere('phone', 'like', '%' . $searchTerm . '%');
        })->paginate(5);

        return view("staff.index")->with('staffs', $staffs);
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $staff = Staff::create([
            'hotel_id' => $request->input('hotel_id'),
            'name' => $request->input('name'),
            'position' => $request->input('position'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'salary' => $request->input('salary'),
            'started_at' => now(),
        ]);

        broadcast(new StaffCreated($staff))->toOthers();
        return redirect()->route('staff.index');
    }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('staff.edit')->with('staff', $staff);
    }

    public function update(Request $request)
    {
        $staff = Staff::findOrFail($request->id);

        $staff->update([
            'hotel_id' => $request->input('hotel_id'),
            'name' => $request->input('name'),
            'position' => $request->input('position'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'salary' => $request->input('salary'),
        ]);
        return redirect()->route('staff.index');
    }

    public function delete($id)
    {
        $staff = Staff::find($id);
        if ($staff) {
            $staff->delete();
            return redirect()->route('staff.index')->with('success', 'Nhân viên đã được xóa thành công!');
        }
        return redirect()->route('staff.index')->with('error', 'Nhân viên không tồn tại!');
    }
}