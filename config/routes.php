<?php

use Slim\App;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

return function (App $app) {

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    // Voir la liste des pokemons
    $app->get('/pokemon', \App\Action\Pokemon\PokemonViewAction::class);

    // Ajouter un pokemon
    $app->post('/pokemon', \App\Action\Pokemon\PokemonAddAction::class);

    // Supprimer un pokemon
    $app->delete('/pokemon/{id}', \App\Action\Pokemon\PokemonDeleteAction::class);

    // Modifier un pokemon
    $app->put('/pokemon/{id}', \App\Action\Pokemon\PokemonModifyAction::class);

    // Generer une nouvelle cle api pour un utilisateur
    $app->put('/users', \App\Action\Users\UserModifyApiKeyAction::class);

};

