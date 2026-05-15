Feature: Create a galaxy
  As an admin
  I want to create a galaxy
  So that applications can be grouped by theme

  Scenario: Successfully create a galaxy
    Given no galaxy named "Best ecommerce apps" exists
    When I create a galaxy named "Best ecommerce apps"
    Then the galaxy "Best ecommerce apps" should exist with status "Draft"
    And a "GalaxyCreated" event should have been published

  Scenario: Reject creation with an empty name
    When I try to create a galaxy with an empty name
    Then I should get an error "GalaxyName cannot be empty"

  Scenario: Reject duplicate galaxy name
    Given a galaxy named "Best ecommerce apps" already exists
    When I try to create another galaxy named "Best ecommerce apps"
    Then I should get an error "GalaxyName already exists"
