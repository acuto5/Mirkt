<?php

use Faker\Generator as Faker;

$factory->define(\App\WebsiteInfo::class, function (Faker $faker) {
    return [
        'content' => '<p><span class="ma-0">Galima išbandyti Admin/Moderator galimybes, sukūrus paskyrą ir profilio redagavimo puslapyje pasirinkti Admin/Moderator privilegija.</span>

<br><sub>Kiekvienas sukurtas straipsnis, žymė, kategorija ar sub-kategorija, bus ištrinta po '. env('DELETE_AFTER_MINUTES', 5) .'min.</sub></p><h3>Taip pat galima prisijungti:</h3><ul class="medium-list"><li class="pl-2"><span class="teal--text text--accent-2"><b>admin@mirkt.lt</b></span> <span class="blue--text text--lighten-2">password</span></li>

<li class="pl-2"><span class="teal--text text--accent-2"><b>moderator@mirkt.lt</b></span> <span class="blue--text text--lighten-2">password</span></li>

</ul><h3>Panaudota:</h3><ul class="medium-list"><li class="pl-2">

<a href="https://laravel.com" class="router-link subheading teal--text text--accent-2">Laravel</a>

</li>

<li class="pl-4">

<ul class="medium-list inline"><li><a href="https://laravel.com/docs/5.5/scout" class="body-1 router-link blue--text text--lighten-2">Scout</a>, </li>

<li><a href="https://www.algolia.com" class="body-1 blue--text text--lighten-2 router-link">Algolia</a>, </li>

<li><a href="https://github.com/mewebstudio/Purifier" class="body-1 blue--text text--lighten-2 router-link">Purifier</a></li>

</ul></li>

<li class="pl-2">

<a href="https://vuejs.org" class="router-link subheading teal--text text--accent-2">Vuejs</a>

</li>

<li class="pl-4">

<ul class="medium-list inline"><li><a href="https://lodash.com/" class="body-1 blue--text text--lighten-2 router-link">Lodash</a>, </li>

<li><a href="https://vuetifyjs.com/en/" class="body-1 blue--text text--lighten-2 router-link">Vuetifyjs</a>, </li>

<li><a href="https://github.com/FranzSkuffka/vue-medium-editor" class="body-1 blue--text text--lighten-2 router-link">Vue2-medium-editor</a>,</li>

<li>

<a href="https://github.com/JeffreyWay/laravel-mix" class="body-1 blue--text text--lighten-2 router-link">Laravel-mix</a>

</li>

</ul></li></ul>'
    ];
});
