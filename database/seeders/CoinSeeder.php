<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('/json/coin.json');
        $coins = json_decode($json, true);

        foreach ($coins as $value) {
            Coin::query()->updateOrCreate([
                'name' => $value['name'],
                'coin_id' => $value['id'],
                'symbol' => $value['symbol'],
                'image' => $value['image'],
            ]);
        }
    }
}
