<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = [
            'Москва',
            'Санкт-Петербург',
            'Новосибирск',
            'Екатеринбург',
            'Казань',
            'Нижний Новгород',
            'Челябинск',
            'Самара',
            'Уфа',
            'Ростов-на-Дону',
            'Краснодар',
            'Воронеж',
            'Пермь',
            'Волгоград',
            'Саратов',
            'Тюмень',
            'Тольятти',
            'Ижевск',
            'Барнаул',
            'Ульяновск',
            'Иркутск',
            'Хабаровск',
            'Ярославль',
            'Владивосток',
            'Махачкала',
            'Томск',
            'Оренбург',
            'Кемерово',
            'Новокузнецк',
            'Рязань',
            'Астрахань',
            'Набережные Челны',
            'Пенза',
            'Липецк',
            'Киров',
            'Чебоксары',
            'Тула',
            'Калининград',
            'Курск',
            'Улан-Удэ',
            'Ставрополь',
            'Магнитогорск',
            'Брянск',
            'Иваново',
            'Архангельск',
            'Сочи'
        ];

        return [
            'name' => fake()->randomElement($cities),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the city is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
