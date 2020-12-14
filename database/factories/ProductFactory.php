<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $sex = array("Male", "Female");
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dog.ceo/api/breeds/image/random',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Cookie: __cfduid=df6a8cbc8e344fe1c964f5064d9f40e121607909477'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response,true);
        return [
            //
            'name' => $this->faker->name,
            'price' => strval(random_int(2, 5) * 50000),
            'detail' => $this->faker->paragraph(random_int(3, 5)),
            'image' => $data['message'],
            'sex' => $this->sex[random_int(0, 1)],
        ];
    }
}
