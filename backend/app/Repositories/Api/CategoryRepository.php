<?php

namespace App\Repositories\Api;

use Illuminate\Http\Request;
use App\Models\Models\Api\Category;

class CategoryRepository
{
    public function all(Request $request)
    {
        $query = Category::query();

        if ($request->has('situation')  && $request->situation != null) {
            $query->where('situation', $request->query('situation') == true);
        }

        return $query->get();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function find(int $id)
    {
        return Category::findOrFail($id);
    }
}
