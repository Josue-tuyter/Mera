<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegistroDeAtividades>
 */
class RegistroDeAtividadesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => $this->faker->date(),
            'hora' => $this->faker->time('H:i'),
            'tipo_actividad' => $this->faker->randomElement(['poda', 'riego', 'fertilizacion', 'control_plagas', 'inspeccion']),
            'descripcion' => $this->faker->optional()->paragraph(),
            'duracion_minutos' => $this->faker->optional()->numberBetween(5, 480),
            'materiales_usados' => null,
            'producto_aplicado' => $this->faker->optional()->word(),
            'cantidad_producto' => $this->faker->optional()->randomFloat(2, 0, 100),
            'unidad' => $this->faker->optional()->randomElement(['kg', 'L', 'g']),
            'encargado_id' => null,
            'organizacion_id' => null,
            'estado_id' => null,
            'parcela' => $this->faker->optional()->word(),
        ];
    }
}
