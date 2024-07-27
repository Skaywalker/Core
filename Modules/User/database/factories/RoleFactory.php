<?php

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\User\Models\Role::class;

    private static string $slug = '';
    private static string $label = '';

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'slug' => static::$slug ??=$this->faker->slug,
            'label' => static::$label ??$this->faker->name,
        ];
    }
    public function withName($name):static
    {
        return $this->state(fn(array $attributes) => ['name'=>$name]);
    }
    public function withLabel($label):static
    {
        return $this->state(fn(array $attributes) => ['label'=>$label]);
    }

}

