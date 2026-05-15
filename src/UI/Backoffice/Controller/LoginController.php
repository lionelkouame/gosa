<?php

declare(strict_types=1);

namespace Gosa\UI\Backoffice\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

final class LoginController
{
    public function __construct(
        private readonly Environment $twig,
        private readonly AuthenticationUtils $authenticationUtils,
    ) {}

    public function index(): Response
    {
        return new Response(
            $this->twig->render('security/login.html.twig', [
                'last_username' => $this->authenticationUtils->getLastUsername(),
                'error' => $this->authenticationUtils->getLastAuthenticationError(),
            ])
        );
    }
}
