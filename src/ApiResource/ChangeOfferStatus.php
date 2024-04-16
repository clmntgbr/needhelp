<?php

namespace App\ApiResource;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ChangeOfferStatus extends AbstractController
{
    public static string $operationName = 'change_address_status';

    public function __construct(
    )
    {
    }

    public function __invoke(Request $request)
    {
        dd($request);
    }
}
