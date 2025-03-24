<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\DTOs\TenantDTO;
use App\Application\Services\TenantService;
use App\Domain\Exceptions\TenantNotFoundException;
use App\Interfaces\Http\Resources\TenantResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    public function __construct(
        private TenantService $tenantService
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        $tenants = $this->tenantService->getAll();
        return TenantResource::collection($tenants);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $tenant = $this->tenantService->findById($id);
            return response()->json(new TenantResource($tenant));
        } catch (TenantNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
            'plan' => 'nullable|string|in:basic,premium,enterprise',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dto = TenantDTO::fromArray($request->all());
        $tenant = $this->tenantService->create($dto);

        return response()->json(new TenantResource($tenant), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
            'plan' => 'nullable|string|in:basic,premium,enterprise',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $dto = TenantDTO::fromArray($request->all());
            $tenant = $this->tenantService->update($id, $dto);
            return response()->json(new TenantResource($tenant));
        } catch (TenantNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->tenantService->delete($id);
            return response()->json(['success' => $result]);
        } catch (TenantNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function search(Request $request): AnonymousResourceCollection
    {
        $term = $request->get('q', '');
        $tenants = $this->tenantService->search($term);
        return TenantResource::collection($tenants);
    }
} 