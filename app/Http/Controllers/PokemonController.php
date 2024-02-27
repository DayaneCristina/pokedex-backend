<?php

namespace App\Http\Controllers;

use App\DTO\PokemonDTO;
use App\ExistingPokemon;
use App\Services\PokemonService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PokemonController extends Controller
{
    private PokemonService $service;
    private ?int $userId;

    public function __construct(PokemonService $service)
    {
        $this->service = $service;
        $this->userId = auth()->id();
    }

    public function getAll(Request $request) : Response
    {
        $offset = $request->query('offset', 0);
        $limit = $request->query('limit', 50);
        $pokemons = $this->service->getAll($this->userId, $offset, $limit);

        $next = $offset <= $pokemons['total'] ? $offset + $limit : null;
        $previous = $offset > 0 ? $offset - $limit : null;

        $results = [];

        foreach ($pokemons['results'] as $pokemon) {

            $results[] = [
                'id' => $pokemon->external_id,
                'name' => $pokemon->name,
                'order' => $pokemon->order,
                'sprites' => $this->transformSprites($pokemon->images),
                'types' => $this->transformTypes($pokemon->types),
            ];
        }

        return response()->json([
            'count'    => $pokemons['total'],
            'next'     => $next,
            'previous' => $previous,
            'results'  => $results
        ]);
    }

    public function getByExternalId(int $id) : Response
    {
        return response()->json($this->service->findByExternalId($id, $this->userId));
    }

    public function search(string $name) : Response
    {
        $pokemon = $this->service->search($name, $this->userId);

        return response()->json([
            'id' => $pokemon->external_id,
            'name' => $pokemon->name,
            'order' => $pokemon->order,
            'sprites' => $this->transformSprites($pokemon->images),
            'types' => $this->transformTypes($pokemon->types),
        ]);
    }

    public function save(Request $request) : Response
    {
        try {
            $data = $request->all();

            $pokemonDTO = new PokemonDTO(
                $data['id'],
                $data['name'],
                $data['sprites'],
                $this->userId,
                $data['order'],
                $data['types']
            );

            $this->service->save($pokemonDTO);

            return response()->json([
                'message' => 'save',
                'body'    => $request->all(),
            ], 204);
        } catch (ExistingPokemon $e) {
            return response()->json(['message' => $e->getMessage()], 409);
        }
    }

    public function delete(int $externalId) : Response
    {
        $this->service->delete($externalId, $this->userId);

        return response()->json([], 204);
    }

    private function transformTypes(string $types): array
    {
        return array_map(function ($type) {
            return ['type' => ['name' => $type]];
        }, json_decode($types, true));
    }

    private function transformSprites($sprites): array
    {
        $return = [];
        foreach($sprites as $sprite) {
            $return[$sprite->description] = $sprite->url;
        }

        return $return;
    }
}
