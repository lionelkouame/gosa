<?php

declare(strict_types=1);

namespace Gosa\UI\Backoffice\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class DashboardController
{
    public function __construct(private readonly Environment $twig) {}

    public function index(): Response
    {
        return new Response(
            $this->twig->render('backoffice/dashboard.html.twig', [
                'stats' => [
                    'applications' => 0,
                    'galaxies' => 0,
                ],
            ]),
        );
    }
}
