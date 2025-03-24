<?php

namespace Tests\Unit\Application\Services;

use App\Application\DTOs\TenantDTO;
use App\Application\Services\TenantService;
use App\Domain\Entities\Tenant;
use App\Domain\Exceptions\TenantNotFoundException;
use App\Domain\Repositories\TenantRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class TenantServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_can_get_all_tenants(): void
    {
        // Arrange
        $tenants = new Collection([
            new Tenant(['id' => 1, 'name' => 'Empresa A', 'database' => 'tenant_empresa_a']),
            new Tenant(['id' => 2, 'name' => 'Empresa B', 'database' => 'tenant_empresa_b']),
        ]);

        $repository = Mockery::mock(TenantRepositoryInterface::class);
        $repository->shouldReceive('getAll')->once()->andReturn($tenants);

        $service = new TenantService($repository);

        // Act
        $result = $service->getAll();

        // Assert
        $this->assertCount(2, $result);
        $this->assertEquals('Empresa A', $result[0]->name);
        $this->assertEquals('Empresa B', $result[1]->name);
    }

    public function test_can_find_tenant_by_id(): void
    {
        // Arrange
        $tenant = new Tenant(['id' => 1, 'name' => 'Empresa A', 'database' => 'tenant_empresa_a']);

        $repository = Mockery::mock(TenantRepositoryInterface::class);
        $repository->shouldReceive('findById')->with(1)->once()->andReturn($tenant);

        $service = new TenantService($repository);

        // Act
        $result = $service->findById(1);

        // Assert
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Empresa A', $result->name);
    }

    public function test_throws_exception_when_tenant_not_found(): void
    {
        // Arrange
        $repository = Mockery::mock(TenantRepositoryInterface::class);
        $repository->shouldReceive('findById')->with(999)->once()->andReturn(null);

        $service = new TenantService($repository);

        // Assert
        $this->expectException(TenantNotFoundException::class);

        // Act
        $service->findById(999);
    }

    public function test_can_create_tenant(): void
    {
        // Arrange
        $dto = new TenantDTO(
            name: 'Empresa A',
            database: 'tenant_empresa_a',
            domain: 'empresa-a.example.com',
            plan: 'premium',
            status: 'active'
        );

        $tenant = new Tenant([
            'id' => 1,
            'name' => 'Empresa A',
            'database' => 'tenant_empresa_a_12345',
            'domain' => 'empresa-a.example.com',
            'plan' => 'premium',
            'status' => 'active'
        ]);

        $repository = Mockery::mock(TenantRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andReturn($tenant);

        // Mock DB facade
        DB::shouldReceive('statement')->once()->with(Mockery::pattern('/CREATE DATABASE IF NOT EXISTS/'));

        $service = new TenantService($repository);

        // Act
        $result = $service->create($dto);

        // Assert
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Empresa A', $result->name);
        $this->assertEquals('premium', $result->plan);
    }

    public function test_can_update_tenant(): void
    {
        // Arrange
        $tenant = new Tenant([
            'id' => 1,
            'name' => 'Empresa A',
            'database' => 'tenant_empresa_a',
            'domain' => 'empresa-a.example.com',
            'plan' => 'basic',
            'status' => 'active'
        ]);

        $updatedTenant = new Tenant([
            'id' => 1,
            'name' => 'Empresa A Atualizada',
            'database' => 'tenant_empresa_a',
            'domain' => 'empresa-a-nova.example.com',
            'plan' => 'premium',
            'status' => 'active'
        ]);

        $dto = new TenantDTO(
            name: 'Empresa A Atualizada',
            database: 'tenant_empresa_a',
            domain: 'empresa-a-nova.example.com',
            plan: 'premium',
            status: 'active'
        );

        $repository = Mockery::mock(TenantRepositoryInterface::class);
        $repository->shouldReceive('findById')->with(1)->once()->andReturn($tenant);
        $repository->shouldReceive('update')->once()->andReturn($updatedTenant);

        $service = new TenantService($repository);

        // Act
        $result = $service->update(1, $dto);

        // Assert
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Empresa A Atualizada', $result->name);
        $this->assertEquals('premium', $result->plan);
    }

    public function test_can_delete_tenant(): void
    {
        // Arrange
        $tenant = new Tenant([
            'id' => 1,
            'name' => 'Empresa A',
            'database' => 'tenant_empresa_a',
            'status' => 'active'
        ]);

        $repository = Mockery::mock(TenantRepositoryInterface::class);
        $repository->shouldReceive('findById')->with(1)->once()->andReturn($tenant);
        $repository->shouldReceive('delete')->with(1)->once()->andReturn(true);

        // Mock DB facade
        DB::shouldReceive('statement')->once()->with(Mockery::pattern('/DROP DATABASE IF EXISTS/'));

        $service = new TenantService($repository);

        // Act
        $result = $service->delete(1);

        // Assert
        $this->assertTrue($result);
    }
} 