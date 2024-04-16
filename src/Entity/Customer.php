<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Traits\IdentifyTraits;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource(
    operations: [
        new Patch(
            denormalizationContext: ['groups' => ['patch']]
        ),
        new Get(
            normalizationContext: ['groups' => ['read_customer']]
        ),
        new Delete(),
        new GetCollection(
            normalizationContext: ['groups' => ['read_customer']]
        ),
        new Post(),
    ]
)]
class Customer
{
    use TimestampableEntity;
    use BlameableEntity;
    use IdentifyTraits;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    #[Groups(['read_customer', 'read_job'])]
    private ?string $name;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    #[Groups(['read_customer', 'read_job'])]
    private ?string $email;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Groups(['read_customer', 'read_job'])]
    private ?string $phone;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    #[Groups(['read_customer', 'read_job'])]
    private ?string $address;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Job::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    #[Groups(['read_customer'])]
    private Collection $jobs;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
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
     * @return Collection<int, Job>
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): static
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs->add($job);
            $job->setCustomer($this);
        }

        return $this;
    }

    public function removeJob(Job $job): static
    {
        if ($this->jobs->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getCustomer() === $this) {
                $job->setCustomer(null);
            }
        }

        return $this;
    }
}
