<?php

namespace App\Services\Api;
use App\Repositories\Api\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductServices
{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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

    public function invalidateProductCache()
    {
        Cache::flush();
    }

    // Método para gerar chave de cache
    protected function generateCacheKey($filters)
    {
        ksort($filters); // Ordenar os filtros para garantir a consistência da chave
        return 'products_' . http_build_query($filters);
    }


}
