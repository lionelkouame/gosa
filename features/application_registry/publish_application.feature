Feature: Publish an application
  As an admin
  I want to publish a draft application
  So that contributors can discover it in the galaxy

  Scenario: Successfully publish a draft application
    Given a draft application named "OpenCart" exists
    When I publish the application "OpenCart"
    Then the application "OpenCart" should have status "Published"
    And an "ApplicationPublished" event should have been published

  Scenario: Cannot publish an already published application
    Given a published application named "OpenCart" exists
    When I try to publish the application "OpenCart"
    Then I should get an error "InvalidStatusTransition"

  Scenario: Cannot publish an archived application
    Given an archived application named "OpenCart" exists
    When I try to publish the application "OpenCart"
    Then I should get an error "InvalidStatusTransition"
