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
    User::create([
        'name' => 'Greggy C. Canja',
        'email' => 'greggy.canja@light.org.ph',
        'password' => Hash::make('lightmfi123'),
        'is_admin' => 0,
    ]);

    User::create([
        'name' => 'Annalie Concepcion',
        'email' => 'annalie.concepcion@light.org.ph',
        'password' => Hash::make('lightmfi123'),
        'is_admin' => 0,
    ]);
}
?>