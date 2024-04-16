<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Traits\IdentifyTraits;
use App\Repository\JobberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: JobberRepository::class)]
#[ApiResource(
    operations: [
        new Patch(
            denormalizationContext: ['groups' => ['patch']]
        ),
        new Get(
            normalizationContext: ['groups' => ['read_jobber']]
        ),
        new Delete(),
        new GetCollection(
            normalizationContext: ['groups' => ['read_jobber']]
        ),
        new Post(),
    ]
)]
class Jobber
{
    use TimestampableEntity;
    use BlameableEntity;
    use IdentifyTraits;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    #[Groups(['read_jobber'])]
    private ?string $name;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    #[Groups(['read_jobber'])]
    private ?string $email;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['read_jobber'])]
    private ?string $phone;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    #[Groups(['read_jobber'])]
    private ?string $address;

    #[ORM\OneToMany(mappedBy: 'jobber', targetEntity: Offer::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    #[Groups(['read_jobber'])]
    private Collection $offers;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('%s - %s', $this->id, $this->name);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): static
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
            $offer->setJobber($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): static
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getJobber() === $this) {
                $offer->setJobber(null);
            }
        }

        return $this;
    }
}
