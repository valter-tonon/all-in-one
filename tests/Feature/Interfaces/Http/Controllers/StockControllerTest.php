<?php

namespace Tests\Feature\Interfaces\Http\Controllers;

use App\Domain\Entities\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_stocks(): void
    {
        // Arrange
        Stock::factory()->count(3)->create();

        // Act
        $response = $this->getJson('/api/stocks');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_show_stock(): void
    {
        // Arrange
        $stock = Stock::factory()->create([
            'name' => 'Camisa Polo',
            'quantity' => 10,
            'price' => 50.00
        ]);

        // Act
        $response = $this->getJson("/api/stocks/{$stock->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $stock->id,
                    'name' => 'Camisa Polo',
                    'quantity' => 10,
                    'price' => 50.00
                ]
            ]);
    }

    public function test_returns_404_when_stock_not_found(): void
    {
        // Act
        $response = $this->getJson('/api/stocks/999');

        // Assert
        $response->assertStatus(404);
    }

    public function test_can_create_stock(): void
    {
        // Arrange
        $stockData = [
            'name' => 'Camisa Polo',
            'description' => 'Camisa polo de algodão',
            'quantity' => 10,
            'price' => 50.00,
            'category' => 'Vestuário'
        ];

        // Act
        $response = $this->postJson('/api/stocks', $stockData);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'Camisa Polo',
                    'description' => 'Camisa polo de algodão',
                    'quantity' => 10,
                    'price' => 50.00,
                    'category' => 'Vestuário'
                ]
            ]);

        $this->assertDatabaseHas('stocks', [
            'name' => 'Camisa Polo',
            'quantity' => 10,
            'price' => 50.00
        ]);
    }

    public function test_can_update_stock(): void
    {
        // Arrange
        $stock = Stock::factory()->create([
            'name' => 'Camisa',
            'quantity' => 10,
            'price' => 50.00
        ]);

        $updatedData = [
            'name' => 'Camisa Polo',
            'description' => 'Camisa polo de algodão',
            'quantity' => 15,
            'price' => 60.00,
            'category' => 'Vestuário'
        ];

        // Act
        $response = $this->putJson("/api/stocks/{$stock->id}", $updatedData);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $stock->id,
                    'name' => 'Camisa Polo',
                    'quantity' => 15,
                    'price' => 60.00
                ]
            ]);

        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
            'name' => 'Camisa Polo',
            'quantity' => 15,
            'price' => 60.00
        ]);
    }

    public function test_can_delete_stock(): void
    {
        // Arrange
        $stock = Stock::factory()->create();

        // Act
        $response = $this->deleteJson("/api/stocks/{$stock->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseMissing('stocks', [
            'id' => $stock->id
        ]);
    }

    public function test_can_get_low_stock(): void
    {
        // Arrange
        Stock::factory()->create(['name' => 'Produto Normal', 'quantity' => 10]);
        Stock::factory()->create(['name' => 'Produto Baixo Estoque 1', 'quantity' => 3]);
        Stock::factory()->create(['name' => 'Produto Baixo Estoque 2', 'quantity' => 2]);

        // Act
        $response = $this->getJson('/api/stocks/low-stock');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['name' => 'Produto Baixo Estoque 1'])
            ->assertJsonFragment(['name' => 'Produto Baixo Estoque 2']);
    }

    public function test_can_get_out_of_stock(): void
    {
        // Arrange
        Stock::factory()->create(['name' => 'Produto Normal', 'quantity' => 10]);
        Stock::factory()->create(['name' => 'Produto Sem Estoque 1', 'quantity' => 0]);
        Stock::factory()->create(['name' => 'Produto Sem Estoque 2', 'quantity' => 0]);

        // Act
        $response = $this->getJson('/api/stocks/out-of-stock');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonFragment(['name' => 'Produto Sem Estoque 1'])
            ->assertJsonFragment(['name' => 'Produto Sem Estoque 2']);
    }
} 