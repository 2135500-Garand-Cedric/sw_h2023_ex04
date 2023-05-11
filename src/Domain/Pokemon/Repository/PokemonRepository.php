<?php

namespace App\Domain\Pokemon\Repository;

use PDO;

/**
 * Repository.
 */
class PokemonRepository
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
     * @return DataResponse
     */
    public function selectAllPokemon(): array
    {
        $sql = "SELECT * FROM pokemon;";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Sélectionne la liste de tous les films
     *
     * @return DataResponse
     */
    public function selectOnePokemon(int $id): array
    {
        $sql = "SELECT * FROM pokemon where id = '$id';";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Sélectionne la liste de tous les films
     *
     * @return DataResponse
     */
    public function addPokemon(array $data): int
    {

        $params = [
            "nom" => $data['nom'],
            "type" => $data['type'],
            "pv" => $data['pv']
        ];

        $sql = "INSERT INTO pokemon (nom, type, pv) VALUES (:nom, :type, :pv);";

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * Sélectionne la liste de tous les films
     *
     * @return DataResponse
     */
    public function deletePokemon(int $id)
    {
        $sql = "DELETE FROM pokemon WHERE id = '$id';";
        $query = $this->connection->prepare($sql);
        $query->execute();
    }

    /**
     * Sélectionne la liste de tous les films
     *
     * @return DataResponse
     */
    public function modifyPokemon(int $id, array $data)
    {

        $params = [
            "nom" => $data['nom'],
            "type" => $data['type'],
            "pv" => $data['pv']
        ];

        $sql = "Update pokemon SET nom = :nom, type = :type, pv = :pv where id = '$id';";

        $query = $this->connection->prepare($sql);
        $query->execute($params);
    }

    /**
     * Sélectionne la liste de tous les films
     *
     * @return Bool
     */
    public function verifyApiKey($apiKey)
    {
        $sql = "Select * from usagers where cle_api = '$apiKey';";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return !empty($result);
    }
}

