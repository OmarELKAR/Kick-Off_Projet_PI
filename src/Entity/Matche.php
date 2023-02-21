<?php

namespace App\Entity;

use App\Repository\MatcheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MatcheRepository::class)]
class Matche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min:3, max:20)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan('today')]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    private ?string $etat = null;

    #[ORM\Column]
    #[Assert\LessThanOrEqual(22)]
    #[Assert\DivisibleBy(2)]
    #[Assert\GreaterThanOrEqual(10)]
    private ?int $Jmax = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $time = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    private ?Tournoi $tournoi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getJmax(): ?int
    {
        return $this->Jmax;
    }

    public function setJmax(int $Jmax): self
    {
        $this->Jmax = $Jmax;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getTournoi(): ?Tournoi
    {
        return $this->tournoi;
    }

    public function setTournoi(?Tournoi $tournoi): self
    {
        $this->tournoi = $tournoi;

        return $this;
    }

}
