<?php

namespace Database\Factories;

use App\Domain\Entities\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Stock>
 */
class StockFactory extends Factory
{
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->productName ?? $this->faker->words(3, true);
        $category = $this->faker->randomElement(['Vestuário', 'Eletrônicos', 'Alimentos', 'Móveis', 'Livros']);
        $prefix = strtoupper(substr($category, 0, 3));
        $namePart = strtoupper(substr(Str::slug($name), 0, 5));
        $random = strtoupper(Str::random(5));
        
        return [
            'name' => $name,
            'description' => $this->faker->paragraph(1),
            'quantity' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'sku' => "{$prefix}-{$namePart}-{$random}",
            'category' => $category,
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Indicate that the stock is active.
     */
    public function active(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the stock is inactive.
     */
    public function inactive(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the stock is low.
     */
    public function lowStock(): self
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => $this->faker->numberBetween(1, 5),
        ]);
    }

    /**
     * Indicate that the stock is out of stock.
     */
    public function outOfStock(): self
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
        ]);
    }
} 