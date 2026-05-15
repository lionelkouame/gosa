Feature: Register an open source application
  As a contributor
  I want to register an application in the registry
  So that it becomes discoverable in the galaxy

  Scenario: Successfully register a valid application
    Given no application named "OpenCart" exists
    When I register an application with name "OpenCart" and version "4.0.2"
    Then the application "OpenCart" should be in the registry with status "Draft"
    And an "ApplicationRegistered" event should have been published

  Scenario: Reject registration with an empty name
    When I try to register an application with an empty name
    Then I should get an error "ApplicationName cannot be empty"

  Scenario: Reject duplicate application name
    Given an application named "OpenCart" already exists
    When I try to register another application named "OpenCart"
    Then I should get an error "ApplicationName already exists"
