<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'user_id' => User::all()->random()->id,//lấy danh sách user rồi chọn ngẫu nhiên id để thêm vào bảng articles
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph(random_int(3, 5)),
            'status' => random_int(0, 2)
        ];
    }
}
