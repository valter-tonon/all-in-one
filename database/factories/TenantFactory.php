<?php

namespace Database\Factories;

use App\Domain\Entities\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company();
        $slug = Str::slug($name);
        
        return [
            'name' => $name,
            'database' => 'tenant_' . $slug . '_' . Str::random(5),
            'domain' => $slug . '.' . $this->faker->domainName(),
            'plan' => $this->faker->randomElement(['basic', 'premium', 'enterprise']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }

    /**
     * Indicate that the tenant is active.
     */
    public function active(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the tenant is inactive.
     */
    public function inactive(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the tenant has a premium plan.
     */
    public function premium(): self
    {
        return $this->state(fn (array $attributes) => [
            'plan' => 'premium',
        ]);
    }

    /**
     * Indicate that the tenant has an enterprise plan.
     */
    public function enterprise(): self
    {
        return $this->state(fn (array $attributes) => [
            'plan' => 'enterprise',
        ]);
    }
} 