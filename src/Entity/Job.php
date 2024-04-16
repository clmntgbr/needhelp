<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Traits\IdentifyTraits;
use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: JobRepository::class)]
#[ApiResource(
    operations: [
        new Patch(
            denormalizationContext: ['groups' => ['patch']]
        ),
        new Get(
            normalizationContext: ['groups' => ['read_job']]
        ),
        new Delete(),
        new GetCollection(
            normalizationContext: ['groups' => ['read_job']]
        ),
        new Post(),
    ]
)]
class Job
{
    const PENDING = 'PENDING';
    const IN_PROGRESS = 'IN_PROGRESS';
    const COMPLETED = 'COMPLETED';

    use TimestampableEntity;
    use BlameableEntity;
    use IdentifyTraits;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    #[Groups(['read_customer', 'read_job'])]
    private ?string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read_customer', 'read_job'])]
    private ?string $description;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['read_customer', 'read_job'])]
    private ?string $status;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups(['read_customer', 'read_job'])]
    private ?array $statuses = [];

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'jobs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_job'])]
    private Customer $customer;

    #[ORM\OneToMany(mappedBy: 'job', targetEntity: Offer::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    #[Groups(['read_job'])]
    private Collection $offers;

    public function __construct()
    {
        $this->statuses = [self::PENDING];
        $this->status = self::PENDING;
        $this->offers = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('%s - %s', $this->id, $this->title);
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;
        $this->statuses[] = $status;

        return $this;
    }

    public function getStatuses(): ?array
    {
        return $this->statuses;
    }

    public function setStatuses(?array $statuses): static
    {
        $this->statuses = $statuses;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

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
            $offer->setJob($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): static
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getJob() === $this) {
                $offer->setJob(null);
            }
        }

        return $this;
    }
}
