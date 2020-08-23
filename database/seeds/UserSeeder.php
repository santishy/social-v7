<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Status;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Status::truncate();
        factory(User::class)->create([
                                      'email' => 'santi_shy@hotmail.com',
                                      'name' => 'SantiagoMartin'
                                    ]);
        factory(Status::class,10)->create();
    }
}
