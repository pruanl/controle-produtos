<?php

namespace App\Repositories\Api;


use App\Models\Api\Image;
use App\Models\Models\Api\Product;
use Illuminate\Http\Request;

class ProductRepository
{
    public function all(Request $request)
    {
        $query = Product::query();

        // Aplicar filtros se fornecidos
        if ($request->has('name') &&  $request->name != null) {
            $query->where('name', 'like', '%' . $request->query('name') . '%');
        }

        if ($request->has('category_id') && $request->category_id != null) {
            $query->where('category_id', $request->query('category_id'));
        }

        if ($request->has('price_min') && is_numeric($request->query('price_min')) && $request->price_min) {
            $query->where('price', '>=', $request->query('price_min'));
        }

        if ($request->has('price_max') && is_numeric($request->query('price_max')) && $request->price_max) {
            $query->where('price', '<=', $request->query('price_max'));
        }


        if ($request->has('situation')  && $request->situation != null) {
            $query->where('situation', $request->query('situation') == true);
        }

        $perPage = $request->query('per_page', 3); // Número de itens por página, padrão para 10
        return $query->with('category')->paginate($perPage);
    }

    public function find(int $id)
    {
        return Product::findOrFail($id);
    }
}
