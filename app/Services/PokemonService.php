<?php

namespace App\Services;

use App\DTO\PokemonDTO;
use App\ExistingPokemon;
use App\Repositories\PokemonRepository;
use Illuminate\Database\Eloquent\Model;

class PokemonService
{
    private PokemonRepository $repository;

    public function __construct(PokemonRepository $pokemonRepository)
    {
        $this->repository = $pokemonRepository;
    }

    public function getAll(int $userId, int $offset = 0, int $limit = 50)
    {
        return $this->repository->getAll($userId, $offset, $limit);
    }

    public function findByExternalId(int $externalId, int $userId) : ?Model
    {
        return $this->repository->findByExternalId($externalId, $userId);
    }

    public function search(string $query, int $userId) : ?Model
    {
        return $this->repository->search($query, $userId);
    }

    /**
     * @throws ExistingPokemon
     */
    public function save(PokemonDTO $pokemonDTO) : ?Model
    {
        return $this->repository->save($pokemonDTO);
    }

    public function delete(int $externalId, int $userId) : bool
    {
        return $this->repository->delete($externalId, $userId);
    }
}
