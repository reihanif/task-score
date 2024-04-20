<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => '9bd58171-49e6-48ef-87ee-af18521e1dca',
            'manage_user' => '1',
            'manage_department' => '1',
            'manage_position' => '1',
        ];
    }
}
