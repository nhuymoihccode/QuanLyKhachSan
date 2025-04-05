<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('quantity', '>', 0)
            ->get();

        Log::info('Promotions retrieved: ' . $promotions->count() . ' records');
        foreach ($promotions as $promotion) {
            Log::info('Promotion: ' . json_encode($promotion));
        }

        return view('promotions.index', compact('promotions'));
    }

    public function claimPromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để nhận mã!');
        }

        if ($promotion->quantity <= 0) {
            return redirect()->back()->with('error', 'Mã khuyến mãi đã hết!');
        }

        // Kiểm tra xem người dùng đã nhận mã này chưa
        if ($user->promotions()->where('promotion_id', $promotion->id)->exists()) {
            return redirect()->back()->with('error', 'Bạn đã nhận mã này rồi!');
        }

        // Giảm quantity và lưu mã cho người dùng
        $promotion->decrement('quantity');
        $user->promotions()->attach($promotion->id, ['claimed_at' => now()]);

        return redirect()->back()->with('success', 'Bạn đã nhận mã khuyến mãi thành công: ' . $promotion->code);
    }
    public function view()
    {
        $promotions = Promotion::paginate(5);
        return view('promotion.view', compact('promotions'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $promotions = Promotion::where(function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('code', 'like', '%' . $searchTerm . '%')
                ->orWhere('discount_percentage', 'like', '%' . $searchTerm . '%')
                ->orWhere('min_amount', 'like', '%' . $searchTerm . '%')
                ->orWhere('start_date', 'like', '%' . $searchTerm . '%')
                ->orWhere('end_date', 'like', '%' . $searchTerm . '%')
                ->orWhere('quantity', 'like', '%' . $searchTerm . '%');
        })->paginate(5);

        return view('promotion.view', compact('promotions'));
    }

    public function create()
    {
        return view('promotion.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:promotions',
            'name' => 'nullable|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'min_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:0',
        ]);

        Promotion::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'discount_percentage' => $request->input('discount_percentage'),
            'min_amount' => $request->input('min_amount'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'quantity' => $request->input('quantity'),
        ]);

        return redirect()->route('promotion.view')->with('success', 'Khuyến mãi đã được tạo thành công!');
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        return view('promotion.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:promotions,code,' . $id,
            'name' => 'nullable|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'min_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'quantity' => 'required|integer|min:0',
        ]);

        $promotion = Promotion::findOrFail($id);

        $promotion->update([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'discount_percentage' => $request->input('discount_percentage'),
            'min_amount' => $request->input('min_amount'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'quantity' => $request->input('quantity'),
        ]);

        return redirect()->route('promotion.view')->with('success', 'Khuyến mãi đã được cập nhật thành công!');
    }

    public function delete(Request $request, $id)
    {
        $promotion = Promotion::find($id);
        if ($promotion) {
            $promotion->delete();
            return redirect()->route('promotion.view')->with('success', 'Khuyến mãi đã được xóa thành công!');
        }

        return redirect()->route('promotion.view')->with('error', 'Khuyến mãi không tồn tại!');
    }
}