<?php

/**
 * Generates dummy user data
 *
 * @return array
 */
function generate_dummy_user_data(): array
{
    $faker    = Faker\Factory::create();
    $userData = [
        "user_email"    => $faker->email(),
        "user_password" => "1234567890"
    ];

    return $userData;
}
