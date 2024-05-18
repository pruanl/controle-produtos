<?php

namespace App\Services\Api;

use App\Repositories\Api\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryServices
{

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function all(Request $request)
    {
        $cacheKey = $this->generateCacheKey($request->all());
        $products = Cache::remember($cacheKey, 3600, function () use ($request) {
            return $this->productRepository->getFilteredProducts($request);
        });

        return response()->json($products);
    }

    public function create(array $data)
    {
        $this->invalidateProductCache();
        return $this->productRepository->create($data);
    }

    // Método para gerar chave de cache
    protected function generateCacheKey($filters)
    {
        ksort($filters); // Ordenar os filtros para garantir a consistência da chave
        return 'categories_' . http_build_query($filters);
    }

    public function invalidateProductCache()
    {
        Cache::flush();
    }


}
