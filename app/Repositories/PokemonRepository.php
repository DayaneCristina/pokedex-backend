<?php

namespace App\Repositories;

use App\DTO\PokemonDTO;
use App\ExistingPokemon;
use App\Models\Pokemon;
use App\Models\PokemonImage;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

class PokemonRepository
{
    public function getAll(int $userId, int $offset = 0, int $limit = 50)
    {
        $count = Pokemon::where('user_id', $userId)->count();

        return [
            'total' => $count,
            'results' => Pokemon::with('images')
            ->where('user_id', $userId)
            ->orderBy('order')
            ->offset($offset)
            ->limit($limit)
            ->get(),
        ];
    }

    public function findByExternalId(int $externalId, int $userId) : ?Model
    {
        return Pokemon::with('images')
            ->where('external_id', $externalId)
            ->where('user_id', $userId)
            ->first();
    }

    public function search(string $query, int $userId) : ?Model
    {
        return Pokemon::with('images')
            ->where('user_id', $userId)
            ->where('name', 'like', '%' . $query . '%')
            ->first();
    }

    /**
     * @throws ExistingPokemon
     */
    public function save(PokemonDTO $pokemonDTO) : ?Model
    {
        $existingPokemon = $this->findByExternalId($pokemonDTO->getExternalId(), $pokemonDTO->getUserId());

        if (!empty($existingPokemon)) {
            throw new ExistingPokemon('Pokemon já importado');
        }

        $types = array_map(function($type) {
            return $type['type']['name'];
        }, $pokemonDTO->getTypes());

        $pokemon = new Pokemon();
        $pokemon->external_id = $pokemonDTO->getExternalId();
        $pokemon->name = $pokemonDTO->getName();
        $pokemon->order = $pokemonDTO->getOrder();
        $pokemon->user()->associate(User::findOrFail($pokemonDTO->getUserId()));

        $pokemon->types = json_encode($types);

        $pokemon->save();

        foreach ($pokemonDTO->getImages() as $images) {
            foreach($images as $description => $image) {
                PokemonImage::create([
                    'url'         => $image,
                    'description' => $description,
                    'pokemon_id'  => $pokemon->id,
                ]);
            }
        }

        return $pokemon;
    }

    public function delete(int $externalId, int $userId) : bool
    {
        $pokemon = $this->findByExternalId($externalId, $userId);

        if (!empty($pokemon)) {
            $pokemon->delete();
            return true;
        }

        return false;
    }
}
