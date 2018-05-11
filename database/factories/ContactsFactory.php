<?php

use Faker\Generator as Faker;

$factory->define(\App\Contacts::class, function (Faker $faker) {
    return [
        'content' => '<p style="text-align:center;">GitHub: <a href="https://github.com/TSmulkys" class="router-link subheading teal--text text--accent-2" target="_blank" rel="noreferrer noopener">Tomas Smulkys</a></p><p style="text-align:center;">LinkedIn: <a href="https://www.linkedin.com/in/tsmulkys" class="router-link subheading teal--text text--accent-2" target="_blank" rel="noreferrer noopener">Tomas Smulkys</a></p><p style="text-align:center;">Facebook: <a href="http://facebook.com/Tsmulkys" target="_blank" class="router-link subheading teal--text text--accent-2" rel="noreferrer noopener">Tomas Smulkys</a></p><p style="text-align:center;">El. Paštas: <span style="color:rgb(100,255,218);font-size:16px;">TSmulkys@gmail.com</span></p>'
    ];
});
