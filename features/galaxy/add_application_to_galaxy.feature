Feature: Add an application to a galaxy
  As a contributor
  I want to add an application to a galaxy
  So that users can discover it in a thematic collection

  Scenario: Successfully add an application to a galaxy
    Given a galaxy named "Best ecommerce apps" exists
    And a published application named "OpenCart" exists
    When I add "OpenCart" to the galaxy "Best ecommerce apps"
    Then the galaxy "Best ecommerce apps" should contain "OpenCart"
    And an "ApplicationAddedToGalaxy" event should have been published

  Scenario: Cannot add a non-existent application
    Given a galaxy named "Best ecommerce apps" exists
    When I try to add a non-existent application to the galaxy "Best ecommerce apps"
    Then I should get an error "Application does not exist"

  Scenario: Cannot add the same application twice
    Given a galaxy named "Best ecommerce apps" exists
    And the application "OpenCart" is already in the galaxy "Best ecommerce apps"
    When I try to add "OpenCart" to the galaxy "Best ecommerce apps" again
    Then I should get an error "ApplicationAlreadyInGalaxy"
