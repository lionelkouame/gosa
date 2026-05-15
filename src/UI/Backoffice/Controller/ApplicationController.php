<?php

declare(strict_types=1);

namespace Gosa\UI\Backoffice\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class ApplicationController
{
    public function __construct(private readonly Environment $twig) {}

    public function index(): Response
    {
        return new Response(
            $this->twig->render('backoffice/applications.html.twig', [
                'applications' => [],
            ]),
        );
    }
}
