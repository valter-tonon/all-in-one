<?php

namespace Tests\Unit\Application\Services;

use App\Application\DTOs\StockDTO;
use App\Application\Services\StockService;
use App\Domain\Entities\Stock;
use App\Domain\Exceptions\StockNotFoundException;
use App\Domain\Repositories\StockRepositoryInterface;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class StockServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_can_get_all_stocks(): void
    {
        // Arrange
        $stocks = new Collection([
            new Stock(['id' => 1, 'name' => 'Camisa', 'quantity' => 10, 'price' => 50.00]),
            new Stock(['id' => 2, 'name' => 'Calça', 'quantity' => 5, 'price' => 100.00]),
        ]);

        $repository = Mockery::mock(StockRepositoryInterface::class);
        $repository->shouldReceive('getAll')->once()->andReturn($stocks);

        $service = new StockService($repository);

        // Act
        $result = $service->getAll();

        // Assert
        $this->assertCount(2, $result);
        $this->assertEquals('Camisa', $result[0]->name);
        $this->assertEquals('Calça', $result[1]->name);
    }

    public function test_can_find_stock_by_id(): void
    {
        // Arrange
        $stock = new Stock(['id' => 1, 'name' => 'Camisa', 'quantity' => 10, 'price' => 50.00]);

        $repository = Mockery::mock(StockRepositoryInterface::class);
        $repository->shouldReceive('findById')->with(1)->once()->andReturn($stock);

        $service = new StockService($repository);

        // Act
        $result = $service->findById(1);

        // Assert
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Camisa', $result->name);
    }

    public function test_throws_exception_when_stock_not_found(): void
    {
        // Arrange
        $repository = Mockery::mock(StockRepositoryInterface::class);
        $repository->shouldReceive('findById')->with(999)->once()->andReturn(null);

        $service = new StockService($repository);

        // Assert
        $this->expectException(StockNotFoundException::class);

        // Act
        $service->findById(999);
    }

    public function test_can_create_stock(): void
    {
        // Arrange
        $dto = new StockDTO(
            name: 'Camisa',
            quantity: 10,
            price: 50.00,
            description: 'Camisa de algodão',
            category: 'Vestuário'
        );

        $stock = new Stock([
            'id' => 1,
            'name' => 'Camisa',
            'quantity' => 10,
            'price' => 50.00,
            'description' => 'Camisa de algodão',
            'sku' => 'VES-CAMIS-ABCDE',
            'category' => 'Vestuário',
            'status' => 'active'
        ]);

        $repository = Mockery::mock(StockRepositoryInterface::class);
        $repository->shouldReceive('create')->once()->andReturn($stock);

        $service = new StockService($repository);

        // Act
        $result = $service->create($dto);

        // Assert
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Camisa', $result->name);
        $this->assertEquals(10, $result->quantity);
        $this->assertEquals(50.00, $result->price);
    }

    public function test_can_update_stock(): void
    {
        // Arrange
        $stock = new Stock([
            'id' => 1,
            'name' => 'Camisa',
            'quantity' => 10,
            'price' => 50.00,
            'description' => 'Camisa de algodão',
            'sku' => 'VES-CAMIS-ABCDE',
            'category' => 'Vestuário',
            'status' => 'active'
        ]);

        $updatedStock = new Stock([
            'id' => 1,
            'name' => 'Camisa Polo',
            'quantity' => 15,
            'price' => 60.00,
            'description' => 'Camisa polo de algodão',
            'sku' => 'VES-CAMIS-ABCDE',
            'category' => 'Vestuário',
            'status' => 'active'
        ]);

        $dto = new StockDTO(
            name: 'Camisa Polo',
            quantity: 15,
            price: 60.00,
            description: 'Camisa polo de algodão',
            sku: 'VES-CAMIS-ABCDE',
            category: 'Vestuário'
        );

        $repository = Mockery::mock(StockRepositoryInterface::class);
        $repository->shouldReceive('findById')->with(1)->once()->andReturn($stock);
        $repository->shouldReceive('update')->once()->andReturn($updatedStock);

        $service = new StockService($repository);

        // Act
        $result = $service->update(1, $dto);

        // Assert
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Camisa Polo', $result->name);
        $this->assertEquals(15, $result->quantity);
        $this->assertEquals(60.00, $result->price);
    }

    public function test_can_delete_stock(): void
    {
        // Arrange
        $stock = new Stock([
            'id' => 1,
            'name' => 'Camisa',
            'quantity' => 10,
            'price' => 50.00
        ]);

        $repository = Mockery::mock(StockRepositoryInterface::class);
        $repository->shouldReceive('findById')->with(1)->once()->andReturn($stock);
        $repository->shouldReceive('delete')->with(1)->once()->andReturn(true);

        $service = new StockService($repository);

        // Act
        $result = $service->delete(1);

        // Assert
        $this->assertTrue($result);
    }

    public function test_can_get_low_stock(): void
    {
        // Arrange
        $stocks = new Collection([
            new Stock(['id' => 1, 'name' => 'Camisa', 'quantity' => 3, 'price' => 50.00]),
            new Stock(['id' => 2, 'name' => 'Calça', 'quantity' => 2, 'price' => 100.00]),
        ]);

        $repository = Mockery::mock(StockRepositoryInterface::class);
        $repository->shouldReceive('getLowStock')->once()->andReturn($stocks);

        $service = new StockService($repository);

        // Act
        $result = $service->getLowStock();

        // Assert
        $this->assertCount(2, $result);
        $this->assertEquals('Camisa', $result[0]->name);
        $this->assertEquals('Calça', $result[1]->name);
    }

    public function test_can_get_out_of_stock(): void
    {
        // Arrange
        $stocks = new Collection([
            new Stock(['id' => 1, 'name' => 'Camisa', 'quantity' => 0, 'price' => 50.00]),
            new Stock(['id' => 2, 'name' => 'Calça', 'quantity' => 0, 'price' => 100.00]),
        ]);

        $repository = Mockery::mock(StockRepositoryInterface::class);
        $repository->shouldReceive('getOutOfStock')->once()->andReturn($stocks);

        $service = new StockService($repository);

        // Act
        $result = $service->getOutOfStock();

        // Assert
        $this->assertCount(2, $result);
        $this->assertEquals('Camisa', $result[0]->name);
        $this->assertEquals('Calça', $result[1]->name);
    }
} 