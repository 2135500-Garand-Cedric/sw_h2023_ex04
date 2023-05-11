<?php

namespace App\Domain\Pokemon\Service;

use App\Domain\Pokemon\Repository\PokemonRepository;

/**
 * Service.
 */
final class PokemonView
{
    /**
     * @var PokemonRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param PokemonRepository $repository
     */
    public function __construct(PokemonRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Sélectionne tous les films.
     *
     * @return array La liste des films
     */
    public function viewAllPokemon(): array
    {

        $pokemons = $this->repository->selectAllPokemon();

        // Tableau qui contient la réponse à retourner à l'usager
        $resultat = [
            "pokemons" => $pokemons
        ];

        return $resultat;
    }

    /**
     * Sélectionne tous les films.
     *
     * @return array La liste des films
     */
    public function addPokemon(array $data, $apiKey): array
    {
        $valide = $this->repository->verifyApiKey($apiKey);
        if ($valide)
        {
            $id = $this->repository->addPokemon($data);
        } else {
            $id = 0;
        }

        // Tableau qui contient la réponse à retourner à l'usager
        $resultat = [
            "id" => $id,
            "nom" => $data['nom'],
            "type" => $data['type'],
            "pv" => $data['pv']
        ];

        return $resultat;
    }

    /**
     * Sélectionne tous les films.
     *
     * @return array La liste des films
     */
    public function deletePokemon(int $id, $apiKey): array
    {
        $valide = $this->repository->verifyApiKey($apiKey);
        if ($valide) {
            $pokemon = $this->repository->selectOnePokemon($id);
            $this->repository->deletePokemon($id);
            $resultat = [
                "pokemon" => $pokemon
            ];
        } else {
            $resultat = [
                "pokemon" => 0
            ];
        }
        return $resultat;
    }

    /**
     * Sélectionne tous les films.
     *
     * @return array La liste des films
     */
    public function modifyPokemon(int $id, array $data, $apiKey): array
    {
        $valide = $this->repository->verifyApiKey($apiKey);
        if ($valide) {
            $this->repository->modifyPokemon($id, $data);
            $pokemon = $this->repository->selectOnePokemon($id);
            $resultat = [
                "pokemon" => $pokemon
            ];
        } else {
            $resultat = [
                "pokemon" => 0
            ];
        }
        return $resultat;
    }


}
