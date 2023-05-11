<?php

namespace App\Action\Pokemon;

use App\Domain\Pokemon\Service\PokemonView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PokemonAddAction
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
        $data = (array)$request->getParsedBody();

        $resultat = $this->pokemonView->addPokemon($data, $apiKey);
        $code = 201;
        // Construit la réponse HTTP
        if ($resultat['id'] == 0) {
            $code = 403;
        }
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
