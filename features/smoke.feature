Feature: Application health
  As a developer
  I want to verify the application boots correctly
  So that I know the environment is ready

  Scenario: The Symfony kernel boots in test environment
    Given the application is running
    Then the environment should be "test"
    And the application name should be "GOSA"
