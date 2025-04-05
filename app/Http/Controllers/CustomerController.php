<?php

namespace App\Http\Controllers;

use App\Events\CustomerCreated;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        $customers = Customer::with('user')->paginate(5);
        return view("customer.index")->with('customers', $customers);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $customers = Customer::where(function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('phone', 'like', '%' . $searchTerm . '%');
        })->paginate(5);

        return view("customer.index")->with('customers', $customers);
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {

        $customer = Customer::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ]);

        broadcast(new CustomerCreated($customer))->toOthers();
        return redirect()->route('customer.index');
    }


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit')->with('customer', $customer);
    }

    public function update(Request $request)
    {
        // dd('cdbik');
        // validation
        $customer = Customer::findOrFail($request->id);

        $customer->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ]);

        return redirect()->route('customer.index');
    }
    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->delete();
            return redirect()->route('customer.index')->with('success', 'Khách hàng đã được xóa thành công!');
        }

        return redirect()->route('customer.index')->with('error', 'Khách hàng không tồn tại!');
    }
}
