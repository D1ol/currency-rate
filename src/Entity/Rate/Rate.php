<?php

namespace App\Entity\Rate;

use App\Entity\Currency\Currency;
use App\Repository\Rate\RateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RateRepository::class)]
class Rate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $currency = null;

    #[ORM\Column(type: 'date_immutable')]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column]
    private ?float $bid = null;

    #[ORM\Column]
    private ?float $ask = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getBid(): ?float
    {
        return $this->bid;
    }

    public function setBid(?float $bid): Rate
    {
        $this->bid = $bid;

        return $this;
    }

    public function getAsk(): ?float
    {
        return $this->ask;
    }

    public function setAsk(?float $ask): Rate
    {
        $this->ask = $ask;

        return $this;
    }
}
