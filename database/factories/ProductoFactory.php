<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_producto' => fake()->name(),
            'precio' => rand(1000, 100000),
            'ruta_imagen_producto' => $this->faker->randomElement(['sihay','nohay'])
        ];
    }
}
