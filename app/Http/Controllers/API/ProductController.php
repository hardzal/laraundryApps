<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\LaundryPrice;
use App\LaundryType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = LaundryPrice::with(['type', 'user'])->orderBy('created_at', 'DESC');

        if (request()->q != '') {
            $products = $products->where('name', 'LIKE', '%' . request()->q . '%');
        }

        $products = $products->paginate(10);
        return new ProductCollection($products);
    }

    public function getLaundryType()
    {
        $type = LaundryType::orderBy('name', 'ASC')->get();
        return response()->json([
            'status' => 'success', 'data' => $type
        ], 200);
    }

    public function storeLaundryType(Request $request)
    {
        $this->validate($request, [
            'name_laundry_type' => 'required|unique:laundry_types, name'
        ]);

        LaundryType::create([
            'name' => $request->name_laundry_type,
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'unit_type' => 'required',
            'price' => 'required|integer',
            'laundry_type' => 'required'
        ]);

        try {
            LaundryPrice::create([
                'name' => $request->name,
                'unit_type' => $request->unit_type,
                'laundry_type_id' => $request->laundry_type,
                'price' => $request->price,
                'user_id' => auth()->user()->id
            ]);
            return response()->json([
                'status' => 'success'
            ], 200);
        } catch (\Exception $er) {
            return response()->json([
                'status' => 'failed'
            ]);
        }
    }

    public function edit($id)
    {
        $laundry = LaundryPrice::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $laundry
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $laundry = LaundryPrice::find($id);
        $laundry->update([
            'name' => $request->name,
            'unit_type' => $request->unit_type,
            'laundry_type_id' => $request->laundry_type,
            'price' => $request->price
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $laundry = LaundryPrice::find($id);
        $laundry->delete();
        return response()->json(['status' => 'success']);
    }
}
