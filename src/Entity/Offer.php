<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Traits\IdentifyTraits;
use App\Repository\OfferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
#[ApiResource(
    operations: [
        new Patch(
            denormalizationContext: ['groups' => ['patch']]
        ),
        new Get(
            normalizationContext: ['groups' => ['read_offer']]
        ),
        new Delete(),
        new GetCollection(
            normalizationContext: ['groups' => ['read_offer']]
        ),
        new Post(),
    ]
)]
class Offer
{
    const ACCEPTED = 'ACCEPTED';
    const DENIED = 'DENIED';

    use TimestampableEntity;
    use BlameableEntity;
    use IdentifyTraits;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['patch', 'read_job', 'read_jobber', 'read_offer'])]
    private ?string $status;

    #[ORM\Column(type: Types::FLOAT, nullable: true)]
    #[Groups(['patch', 'read_job', 'read_jobber', 'read_offer'])]
    private ?float $price;

    #[ORM\ManyToOne(targetEntity: Jobber::class, inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_offer'])]
    private Jobber $jobber;

    #[ORM\ManyToOne(targetEntity: Job::class, cascade: ['persist', 'remove'], inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_offer'])]
    private Job $job;

    public function __toString(): string
    {
        return sprintf('%s - %s', $this->id, $this->price);
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getJobber(): ?Jobber
    {
        return $this->jobber;
    }

    public function setJobber(?Jobber $jobber): static
    {
        $this->jobber = $jobber;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): static
    {
        $this->job = $job;

        return $this;
    }
}
