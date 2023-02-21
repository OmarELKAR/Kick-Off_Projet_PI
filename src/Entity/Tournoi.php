<?php

namespace App\Entity;

use http\Exception\InvalidArgumentException;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\TournoiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use function PHPUnit\Framework\throwException;

#[ORM\Entity(repositoryClass: TournoiRepository::class)]
class Tournoi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min:3, max:20)]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\GreaterThan(2)]
    #[Assert\LessThanOrEqual(32)]
    #[Assert\DivisibleBy(2)]
    private ?int $nbr_equipe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    #[Assert\GreaterThan('today')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    private ?string $etat = null;

    #[ORM\OneToMany(mappedBy: 'tournoi', targetEntity: Matche::class, cascade: array("remove"))]
    private Collection $matches;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\GreaterThan(6)]
    #[Assert\LessThanOrEqual(16)]
    private ?int $nbr_Jequipe = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\NotBlank]
    private ?int $nbrTerrains = null;

    public function __construct()
    {
        $this->matches = new ArrayCollection();
    }

    #[ORM\PostPersist]
    public function tournament_matches(ManagerRegistry $doctrine)
    {
        $nRounds = ceil(log($this->nbr_equipe) / log(2));
        $nMatches = $this->nbr_equipe - 1;
        $int = new \DateInterval('PT45M');
        $matchN = 0;

        $StTime = new \DateTime("14:00:00");
        $MatchAtT = 0;



        for($round = 0; $round < $nRounds; $round++)
        {
            $matchesInRound = floor($nMatches / pow(2, $round + 1));
            for($match = 0; $match < $matchesInRound; $match++)
            {
                if($MatchAtT >= $this->nbrTerrains)
                {
                    $StTime->add($int);
                    $MatchAtT = 0;
                }
                $MatchAtT++;
                $matchN++;
                $m = new Matche();
                $m->setName("{$this->name}/Match {$matchN}");
                $m->setDate($this->date);
                $m->setTime($StTime);
                $m->setJmax($this->nbr_Jequipe);
                $m->setEtat("Tournoi");
                $m->setTournoi($this);
                $this->addMatch($m);
                $em = $doctrine->getManager();
                $em->persist($m);
                $em->flush();
            }
            $StTime->add($int);
            $MatchAtT = 0;
        }
    }



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

    public function getNbrEquipe(): ?int
    {
        return $this->nbr_equipe;
    }

    public function setNbrEquipe(int $nbr_equipe): self
    {
        $this->nbr_equipe = $nbr_equipe;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    /**
     * @return Collection<int, Matche>
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Matche $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches->add($match);
            $match->setTournoi($this);
        }

        return $this;
    }

    public function removeMatch(Matche $match): self
    {
        if ($this->matches->removeElement($match)) {
            // set the owning side to null (unless already changed)
            if ($match->getTournoi() === $this) {
                $match->setTournoi(null);
            }
        }

        return $this;
    }

    public function getNbrJequipe(): ?int
    {
        return $this->nbr_Jequipe;
    }

    public function setNbrJequipe(int $nbr_Jequipe): self
    {
        $this->nbr_Jequipe = $nbr_Jequipe;

        return $this;
    }

    public function getNbrTerrains(): ?int
    {
        return $this->nbrTerrains;
    }

    public function setNbrTerrains(int $nbrTerrains): self
    {
        $this->nbrTerrains = $nbrTerrains;

        return $this;
    }

}
