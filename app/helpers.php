<?php 

use App\User;
use Illuminate\Support\Facades\Hash;


function createAdminAccount(){
    User::create([
        'name' => 'Ashbee Morgado',
        'email' => 'ashbee.morgado@icloud.com',
        'password' => Hash::make('sv9h4pld'),
        'is_admin' => true,
    ]);
}
?>