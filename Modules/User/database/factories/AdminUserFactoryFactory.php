<?php

namespace Modules\User\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\User\Actions\Fortify\PasswordValidationRules;
use Modules\User\Models\User;

class AdminUserFactoryFactory extends Factory
{
    private static string $password;
    private static string $email = 'admin@mail.com';
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'=>'Super Admin',
            'email'=>static::$email ??= '',
            'password'=>static::$password ??= Hash::make('password'),
            'email_verified_at'=>now(),
            'remember_token'=>Str::random(10),
        ];
    }
    public function withPassword($password):static
    {
        return $this->state(fn(array $attributes) => ['password'=>Hash::make($password)]);
    }
    public function withEmail(string $email):static
    {
        static::$email = $email;
        return $this;
    }

}

