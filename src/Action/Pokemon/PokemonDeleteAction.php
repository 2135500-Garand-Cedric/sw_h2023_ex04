<?php

namespace App\Action\Pokemon;

use App\Domain\Pokemon\Service\PokemonView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PokemonDeleteAction
{
    private $pokemonView;

    public function __construct(PokemonView $pokemonView)
    {
        $this->pokemonView = $pokemonView;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        $valeurAuth = $request->getHeaderLine('Authorization');
        $token = explode(' ', $valeurAuth)[1];
        $apiKey = base64_decode($token);
        // Récupération des parametres
        $id = $request->getAttribute('id', 0);

        $resultat = $this->pokemonView->deletePokemon($id, $apiKey);
        $code = 200;
        if($resultat['pokemon'] == 0) {
            $code = 403;
        }

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
