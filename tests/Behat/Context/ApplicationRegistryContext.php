<?php

declare(strict_types=1);

namespace Gosa\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

final class ApplicationRegistryContext implements Context
{
    /**
     * @Given no application named :name exists
     */
    public function noApplicationNamedExists(string $name): void
    {
        throw new PendingException('Implement when ApplicationRegistry domain is ready');
    }

    /**
     * @When I register an application with name :name and version :version
     */
    public function iRegisterAnApplicationWithNameAndVersion(string $name, string $version): void
    {
        throw new PendingException('Implement when RegisterApplication command is ready');
    }

    /**
     * @Then the application :name should be in the registry with status :status
     */
    public function theApplicationShouldBeInTheRegistryWithStatus(string $name, string $status): void
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
     * @When I try to register an application with an empty name
     */
    public function iTryToRegisterAnApplicationWithAnEmptyName(): void
    {
        throw new PendingException('Implement when RegisterApplication command is ready');
    }

    /**
     * @Then I should get an error :message
     */
    public function iShouldGetAnError(string $message): void
    {
        throw new PendingException('Implement when domain exceptions are ready');
    }

    /**
     * @Given an application named :name already exists
     */
    public function anApplicationNamedAlreadyExists(string $name): void
    {
        throw new PendingException('Implement when ApplicationRepository is ready');
    }

    /**
     * @When I try to register another application named :name
     */
    public function iTryToRegisterAnotherApplicationNamed(string $name): void
    {
        throw new PendingException('Implement when RegisterApplication command is ready');
    }

    /**
     * @Given a draft application named :name exists
     */
    public function aDraftApplicationNamedExists(string $name): void
    {
        throw new PendingException('Implement when ApplicationRepository is ready');
    }

    /**
     * @When I publish the application :name
     */
    public function iPublishTheApplication(string $name): void
    {
        throw new PendingException('Implement when PublishApplication command is ready');
    }

    /**
     * @Then the application :name should have status :status
     */
    public function theApplicationShouldHaveStatus(string $name, string $status): void
    {
        throw new PendingException('Implement when ApplicationRepository is ready');
    }

    /**
     * @When I try to publish the application :name
     */
    public function iTryToPublishTheApplication(string $name): void
    {
        throw new PendingException('Implement when PublishApplication command is ready');
    }

    /**
     * @Given a published application named :name exists
     */
    public function aPublishedApplicationNamedExists(string $name): void
    {
        throw new PendingException('Implement when ApplicationRepository is ready');
    }

    /**
     * @Given an archived application named :name exists
     */
    public function anArchivedApplicationNamedExists(string $name): void
    {
        throw new PendingException('Implement when ApplicationRepository is ready');
    }
}
