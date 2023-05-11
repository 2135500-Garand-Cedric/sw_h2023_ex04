<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;

/**
 * Service.
 */
final class UserView
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Sélectionne tous les films.
     *
     * @return array La liste des films
     */
    public function getNewApiKey($codeUsager, $motDePasse): array
    {
        $existe = $this->repository->getNewApiKey($codeUsager, $motDePasse);

        if ($existe) {
            $cleApi = $this->repository->modifyApiKey($codeUsager);
            $resultat = [
                "reponse" => $cleApi
            ];
        } else {
            $resultat = [
                "reponse" => "Code d'utilisateur ou mot de passe invalide"
            ];
        }

        return $resultat;
    }


}
