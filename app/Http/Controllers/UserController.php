<?php

namespace App\Http\Controllers;

use App\Events\CustomerCreated;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $users = Customer::paginate(5);
        return view("user.index")->with('users', $users);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = Customer::where(function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('phone', 'like', '%' . $searchTerm . '%');
        })->paginate(5);

        return view("user.index")->with('users', $users);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {

        $user = Customer::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ]);

        broadcast(new CustomerCreated($user))->toOthers();
        return redirect()->route('user.index');
    }


    public function edit($id)
    {
        $user = Customer::findOrFail($id);
        return view('user.edit')->with('user', $user);
    }

    public function update(Request $request)
    {
        // dd('cdbik');
        // validation
        $user = Customer::findOrFail($request->id);

        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ]);

        return redirect()->route('user.index');
    }
    public function delete($id)
    {
        $user = Customer::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Khách hàng đã được xóa thành công!');
        }

        return redirect()->route('user.index')->with('error', 'Khách hàng không tồn tại!');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }
}
