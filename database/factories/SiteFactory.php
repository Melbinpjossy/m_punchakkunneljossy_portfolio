<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Site;

class SiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Site::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'logo' => $this->faker->text,
            'favicon' => $this->faker->text,
            'smallText' => $this->faker->word,
            'title' => $this->faker->sentence(4),
            'countary' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'address' => $this->faker->word,
        ];
    }
}
