<?php

namespace Services;

use App\DTO\PokemonDTO;
use App\ExistingPokemon;
use App\Models\Pokemon;
use App\Repositories\PokemonRepository;
use App\Services\PokemonService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class PokemonServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $pokemonRepositoryMock;
    protected $pokemonService;

    public function setUp(): void
    {
        parent::setUp();

        $this->pokemonRepositoryMock = Mockery::mock(PokemonRepository::class);
        $this->pokemonService = new PokemonService($this->pokemonRepositoryMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetAll()
    {
        $userId = 1;
        $offset = 0;
        $limit = 50;

        $this->pokemonRepositoryMock->shouldReceive('getAll')
            ->with($userId, $offset, $limit)
            ->once()
            ->andReturn(['total' => 10, 'results' => new Collection()]);

        $result = $this->pokemonService->getAll($userId, $offset, $limit);
        $this->assertInstanceOf(Collection::class, $result['results']);
        $this->assertIsInt($result['total']);
    }

    public function testFindByExternalId()
    {
        $externalId = 123;
        $userId = 1;

        $this->pokemonRepositoryMock->shouldReceive('findByExternalId')
            ->with($externalId, $userId)
            ->once()
            ->andReturn(null);

        $result = $this->pokemonService->findByExternalId($externalId, $userId);
        $this->assertNull($result);
    }

    public function testSearch()
    {
        $query = 'Pikachu';
        $userId = 1;

        $this->pokemonRepositoryMock->shouldReceive('search')
            ->with($query, $userId)
            ->once()
            ->andReturn(null);

        $result = $this->pokemonService->search($query, $userId);
        $this->assertNull($result);
    }

    public function testSave()
    {
        $pokemonDTO = new PokemonDTO(
            1,
            'pikachu',
            [['front' => 'front.jpg']],
            1,
            1,
            ["electric"]
        );

        $this->pokemonRepositoryMock->shouldReceive('save')
            ->with($pokemonDTO)
            ->once()
            ->andReturn(new Pokemon());

        $result = $this->pokemonService->save($pokemonDTO);

        $this->assertNotEmpty($result);
    }

    public function testDelete()
    {
        $externalId = 123;
        $userId = 1;

        $this->pokemonRepositoryMock->shouldReceive('delete')
            ->with($externalId, $userId)
            ->once()
            ->andReturn(true);

        $result = $this->pokemonService->delete($externalId, $userId);

        $this->assertTrue($result);
    }
}
