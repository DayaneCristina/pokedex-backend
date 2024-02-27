<?php

namespace App\DTO;

class PokemonDTO
{
    private int $externalId;
    private string $name;
    private array $images;
    private int $userId;
    private int $order;

    private array $types;

    public function __construct(
        int $externalId,
        string $name,
        array $images,
        int $userId,
        int $order,
        array $types
    )
    {
        $this->externalId = $externalId;
        $this->name = $name;
        $this->images = $images;
        $this->userId = $userId;
        $this->order = $order;
        $this->types = $types;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setTypes(array $types): void
    {
        $this->types = $types;
    }

    public function getTypes(): array
    {
        return $this->types;
    }
}
