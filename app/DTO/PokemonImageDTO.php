<?php

namespace App\DTO;

class PokemonImageDTO
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
