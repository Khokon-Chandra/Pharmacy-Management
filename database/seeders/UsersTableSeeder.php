<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'laurus',
            'email' => 'laurus@ph.net',
            'password' => bcrypt('laurus'),
        ]);
        DB::table('role_user')->insert([
            'role_id' => '1',
            'user_id' => User::get()->last()->id,
        ]);
    }
}
