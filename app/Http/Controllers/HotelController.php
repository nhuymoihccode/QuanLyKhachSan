<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::paginate(5);
        return view("hotel.index")->with('hotels', $hotels);
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $hotels = Hotel::where(function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%');
        })->paginate(5);

        return view("hotel.index")->with('hotels', $hotels);
    }

    public function create()
    {
        return view('hotel.create');
    }

    public function store(Request $request)
    {

        Hotel::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);
        return redirect()->route('hotel.index');
    }

    public function edit($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('hotel.edit')->with('hotel', $hotel);
    }

    public function update(Request $request)
    {
        $hotel = Hotel::findOrFail($request->id);

        $hotel->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);
        return redirect()->route('hotel.index');
    }
    public function delete($id)
    {
        $hotel = Hotel::find($id);
        if ($hotel) {
            $hotel->delete();
            return redirect()->route('hotel.index')->with('success', 'Khách sạn đã được xóa thành công!');
        }
        // return redirect()->route('hotel.index')->with('error', 'Khách sạn không tồn tại!');
    }
}
