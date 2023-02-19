<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

use App\Events\ProductCreated;

class ProductController extends Controller
{

    public function index(Request $request): ProductCollection
    {
        $name = $request->input('name');
        $user = $request->input('user');
        
        $products = Product::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%'.$name.'%');
        })
        ->when($user, function ($query) use ($user) {
            return $query->whereHas('user',function($query) use ($user) {
                $query->where('name','like', '%'.$user.'%');
            });
        })
        ->get();
        
        return new ProductCollection($products);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,unavailable',
            'type' => 'required|in:item,service',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        try {
            $user = auth()->user();
            $product = $user->products()->create($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        event(new ProductCreated($product));
        return new ProductResource($product);
    }

    public function show(Product $product) {
        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    
        return new ProductResource($product);
    }


    public function update(Request $request, Product $product) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:available,unavailable',
            'type' => 'required|in:item,service',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $product->update($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    
      
        return new ProductResource($product);
    }

    public function destroy(Product $product){
        try {
            $product->delete();
            return response()->json([
                'status' => true,
                'message' => 'Product deleted successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
}
