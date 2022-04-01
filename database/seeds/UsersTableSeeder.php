<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Автор не известен',
                'email' => 'author_unknown@gmail.com',
                'password' => bcrypt(str_random(16))
            ],
            [
                'name' => 'Антон Ивашкин',
                'email' => 'author@gmail.com',
                'password' => bcrypt(123456)
            ],
        ];
        DB::table('users')->insert($data);
    }
}
