<?php

namespace App\Action\Pokemon;

use App\Domain\Pokemon\Service\PokemonView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PokemonViewAction
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

        $resultat = $this->pokemonView->viewAllPokemon();
        $code = 200;
        if (empty($resultat)) {
            $code = 404;
        }
        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($resultat));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($code);
    }
}
