<?php

namespace App\Domain\User\Repository;

use PDO;
use function FastRoute\TestFixtures\empty_options_cached;

/**
 * Repository.
 */
class UserRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Sélectionne la liste de tous les films
     *
     * @return Bool
     */
    public function getNewApiKey($codeUsager, $motDePasse)
    {
        $sql = "Select * From usagers where code_usager = '$codeUsager' and mot_de_passe = '$motDePasse';";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return !empty($result);
    }

    /**
     * Sélectionne la liste de tous les films
     *
     * @return String
     */
    public function modifyApiKey($codeUsager)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cle_api = substr(str_shuffle($permitted_chars), 0, 8);

        $params = [
            "cle_api" => $cle_api
        ];

        $sql = "Update usagers SET cle_api = :cle_api where code_usager = '$codeUsager';";

        $query = $this->connection->prepare($sql);
        $query->execute($params);
        return $cle_api;
    }
}

