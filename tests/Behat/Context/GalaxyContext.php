<?php

declare(strict_types=1);

namespace Gosa\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

final class GalaxyContext implements Context
{
    /**
     * @Given no galaxy named :name exists
     */
    public function noGalaxyNamedExists(string $name): void
    {
        throw new PendingException('Implement when GalaxyRepository is ready');
    }

    /**
     * @When I create a galaxy named :name
     */
    public function iCreateAGalaxyNamed(string $name): void
    {
        throw new PendingException('Implement when CreateGalaxy command is ready');
    }

    /**
     * @Then the galaxy :name should exist with status :status
     */
    public function theGalaxyShouldExistWithStatus(string $name, string $status): void
    {
        throw new PendingException('Implement when GalaxyRepository is ready');
    }

    /**
     * @Then a :eventName event should have been published
     */
    public function aEventShouldHaveBeenPublished(string $eventName): void
    {
        throw new PendingException('Implement when EventPublisher is ready');
    }

    /**
     * @When I try to create a galaxy with an empty name
     */
    public function iTryToCreateAGalaxyWithAnEmptyName(): void
    {
        throw new PendingException('Implement when CreateGalaxy command is ready');
    }

    /**
     * @Then I should get an error :message
     */
    public function iShouldGetAnError(string $message): void
    {
        throw new PendingException('Implement when domain exceptions are ready');
    }

    /**
     * @Given a galaxy named :name already exists
     */
    public function aGalaxyNamedAlreadyExists(string $name): void
    {
        throw new PendingException('Implement when GalaxyRepository is ready');
    }

    /**
     * @When I try to create another galaxy named :name
     */
    public function iTryToCreateAnotherGalaxyNamed(string $name): void
    {
        throw new PendingException('Implement when CreateGalaxy command is ready');
    }

    /**
     * @Given a published application named :name exists
     */
    public function aPublishedApplicationNamedExists(string $name): void
    {
        throw new PendingException('Implement when ApplicationRepository is ready');
    }

    /**
     * @Then an :eventName event should have been published
     */
    public function anEventShouldHaveBeenPublished(string $eventName): void
    {
        throw new PendingException('Implement when EventPublisher is ready');
    }

    /**
     * @Given a galaxy named :name exists
     */
    public function aGalaxyNamedExists(string $name): void
    {
        throw new PendingException('Implement when GalaxyRepository is ready');
    }

    /**
     * @When I add :appName to the galaxy :galaxyName
     */
    public function iAddToTheGalaxy(string $appName, string $galaxyName): void
    {
        throw new PendingException('Implement when AddApplicationToGalaxy command is ready');
    }

    /**
     * @Then the galaxy :galaxyName should contain :appName
     */
    public function theGalaxyShouldContain(string $galaxyName, string $appName): void
    {
        throw new PendingException('Implement when GalaxyRepository is ready');
    }

    /**
     * @When I try to add a non-existent application to the galaxy :galaxyName
     */
    public function iTryToAddANonExistentApplicationToTheGalaxy(string $galaxyName): void
    {
        throw new PendingException('Implement when AddApplicationToGalaxy command is ready');
    }

    /**
     * @Given the application :appName is already in the galaxy :galaxyName
     */
    public function theApplicationIsAlreadyInTheGalaxy(string $appName, string $galaxyName): void
    {
        throw new PendingException('Implement when GalaxyRepository is ready');
    }

    /**
     * @When I try to add :appName to the galaxy :galaxyName again
     */
    public function iTryToAddToTheGalaxyAgain(string $appName, string $galaxyName): void
    {
        throw new PendingException('Implement when AddApplicationToGalaxy command is ready');
    }
}
