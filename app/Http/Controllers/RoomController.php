<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(){
        $rooms = Room::with('hotel')->paginate(5);
        return view("room.index")->with('rooms', $rooms);
    }
    public function search(Request $request){
        $searchTerm = $request->input('search');

        $rooms = Room::where(function($query) use ($searchTerm) {
            $query->where('room_number', 'like', '%' . $searchTerm . '%')
                  ->orWhere('status', 'like', '%' . $searchTerm . '%')
                  ->orWhere('type', 'like', '%' . $searchTerm . '%')
                  ->orWhere('price', 'like', '%' . $searchTerm . '%');
        })->paginate(5);

        return view("room.index")->with('rooms', $rooms);
    }

    public function create(){
        return view('room.create');
    }

    public function store(Request $request){
        
        Room::create([
            'hotel_id'=> $request->input('hotel_id'),
            'room_number'=> $request->input('room_number'),
            'type' => $request->input('type'),
            'price' => $request->input('price'),
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('room.index');
    }

    public function edit($id){
        $room = Room::findOrFail($id);
        return view('room.edit')->with('room', $room);
    }

    public function update(Request $request){
        $room = Room::findOrFail($request->id);
        
        $room->update([
            'hotel_id'=> $request->input('hotel_id'),
            'room_number'=> $request->input('room_number'),
            'type' => $request->input('type'),
            'price' => $request->input('price'),
            'status'=>$request->input('status'),
        ]);
        return redirect()->route('room.index');
    }
    public function delete($id) {
        $room = Room::find($id);
        if ($room) {
            $room->delete();
            return redirect()->route('room.index')->with('success', 'Phòng đã được xóa thành công!');
        }
        // return redirect()->route('room.index')->with('error', 'Phòng không tồn tại!');
    }
}
