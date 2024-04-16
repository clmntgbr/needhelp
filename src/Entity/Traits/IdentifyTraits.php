<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

trait IdentifyTraits
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column]
    #[Groups(['read_customer', 'read_job', 'read_offer', 'read_jobber'])]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
