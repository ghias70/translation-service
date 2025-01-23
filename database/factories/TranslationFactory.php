<?php
namespace Database\Factories;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition()
    {
        return [
            'key' => 'key_' . $this->faker->unique()->numberBetween(1, 100000),
            'content' => $this->faker->sentence,
            'locale' => $this->faker->randomElement(['en', 'fr', 'es']),
            'tag' => $this->faker->randomElement(['mobile', 'desktop', 'web']),
        ];
    }
}
