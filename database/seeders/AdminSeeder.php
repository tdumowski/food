<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        $admin->name = "Admin";
        $admin->email = "admin@food.com";
        // $admin->password = bcrypt("qmbaya123");
        $admin->password = Hash::make("qmbaya123");
        $admin->save();
    }
}
