<?php

namespace App\EventListener;

use App\Entity\Job;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostUpdateEventArgs;

class OfferChangedNotifier
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function postUpdate(PostUpdateEventArgs $event): void
    {
        $entity = $event->getObject();

        if (!$entity instanceof Offer) {
            return;
        }

        if ($entity->getStatus() === Offer::ACCEPTED) {
            $entity->getJob()->setStatus(Job::IN_PROGRESS);
            $this->em->persist($entity);
            $this->em->flush();
        }
    }
}
