<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\DTOs\StockDTO;
use App\Application\Services\StockService;
use App\Domain\Exceptions\StockNotFoundException;
use App\Interfaces\Http\Resources\StockResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function __construct(
        private StockService $stockService
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        $stocks = $this->stockService->getAll();
        return StockResource::collection($stocks);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $stock = $this->stockService->findById($id);
            return response()->json(new StockResource($stock));
        } catch (StockNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dto = StockDTO::fromArray($request->all());
        $stock = $this->stockService->create($dto);

        return response()->json(new StockResource($stock), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sku' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $dto = StockDTO::fromArray($request->all());
            $stock = $this->stockService->update($id, $dto);
            return response()->json(new StockResource($stock));
        } catch (StockNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->stockService->delete($id);
            return response()->json(['success' => $result]);
        } catch (StockNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function search(Request $request): AnonymousResourceCollection
    {
        $term = $request->get('q', '');
        $stocks = $this->stockService->search($term);
        return StockResource::collection($stocks);
    }

    public function lowStock(): AnonymousResourceCollection
    {
        $stocks = $this->stockService->getLowStock();
        return StockResource::collection($stocks);
    }

    public function outOfStock(): AnonymousResourceCollection
    {
        $stocks = $this->stockService->getOutOfStock();
        return StockResource::collection($stocks);
    }
} 