<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Api\Image;
use App\Models\Models\Api\Product;
use App\Repositories\Api\ProductRepository;
use App\Services\Api\ProductServices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $productService;

    public function __construct(ProductServices $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->all($request);
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request  $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'situation' =>'required|boolean',
            'category_id' => 'required|integer|exists:categories,id'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors();
            return response()->json($message , Response::HTTP_BAD_REQUEST);
        }

        if ($request->has('imagem_uuid')) {
            $image = Image::find($request->imagem_uuid);
            if (!$image) {
                return response()->json(['imagem_uuid' => 'The selected imagem uuid is invalid.'], 400);
            }
        }

        $product = $this->productService->create($request->all());
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(['message' => 'Method not allowed'], 405);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json(['message' => 'Method not allowed'], 405);
    }
}
