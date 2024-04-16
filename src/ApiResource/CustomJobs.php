<?php

namespace App\ApiResource;

use App\Entity\Job;
use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CustomJobs extends AbstractController
{
    public static string $operationName = 'custom_jobs';

    public function __construct(
        private readonly JobRepository $jobRepository
    )
    {
    }

    public function __invoke(Request $request): array
    {
        return $this->jobRepository->findBy(['status' => Job::IN_PROGRESS]);
    }
}
