<?php

namespace App\Entity;

use App\Repository\LinkPairsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: LinkPairsRepository::class)]
#[Broadcast]
class LinkPairs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $lp_url = null;

    #[ORM\Column(length: 12)]
    private ?string $lp_key = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLpUrl(): ?string
    {
        return $this->lp_url;
    }

    public function setLpUrl(string $lp_url): static
    {
        $this->lp_url = $lp_url;

        return $this;
    }

    public function getLpKey(): ?string
    {
        return $this->lp_key;
    }

    public function setLpKey(string $lp_key): static
    {
        $this->lp_key = $lp_key;

        return $this;
    }
}
