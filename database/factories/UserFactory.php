<?php

namespace Kasl\KaslFw\Database\Factories;

use Kasl\KaslFw\Models\User; // Reference the User model
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    // Specify the model associated with the factory
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => password_hash('password', PASSWORD_BCRYPT),
        ];
    }
}
