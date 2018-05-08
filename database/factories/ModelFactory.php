<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\CoporateClient::class, function (Faker\Generator $faker) {
    return [
        'business_name' => $faker->name,
        'email' => $faker->safeEmail,
        'contact_no' => (str_random(10)),
        'pointof_fname_and_lastname' => $faker->lastName,
        'pointof_email' =>  $faker->safeEmail,
        'prefix_code' => $faker->postcode,
        'isage' => str_random(3),
        'agreement_text' => str_random(10),
        'logo' => str_random(10),
        'header_color' => str_random(10),
        'footer_color' => str_random(10),
    ];
});