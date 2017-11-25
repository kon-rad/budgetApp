Feature: Handle user registration via the RESTful API

  In order to allow a user to sign up
  As a client software developer
  I need to be able to handle registration

  Background:
    Given there are Users with the following details:
      | id | username | email          | password |
      | 1  | peter    | peter@test.com | testpass |
    And I set header "Content-Type" with value "application/json"

  Scenario: Can register with valid data
    When I send a "POST" request to "/register" with body:
      """
      {
        "email": "test@testing.com",
        "username": "tom",
        "plainPassword": {
          "first": "abc123",
          "second": "abc123"
        }
      }
      """
    Then the response code should be 201
    And the response should contain "The user has been created successfully"
    And I follow the link in the Location response header
    And the response should contain json:
      """
      {
        "id": "2",
        "username": "tom",
        "email": "test@testing.com"
      }
      """

  Scenario: Cannot register with existing user name
    When I send a "POST" request to "/register" with body:
      """
      {
        "email": "peter@some-different-domain.com",
        "username": "peter",
        "plainPassword": {
          "first": "abc123",
          "second": "abc123"
        }
      }
      """
    Then the response code should be 400
    And the response should contain "The username is already used"

  Scenario: Cannot register with an existing email address
    When I send a "POST" request to "/register" with body:
      """
      {
        "email": "peter@test.com",
        "username": "different_peter",
        "plainPassword": {
          "first": "abc123",
          "second": "abc123"
        }
      }
      """
    Then the response code should be 400
    And the response should contain "The email is already used"

  Scenario: Cannot register with an mismatched password
    When I send a "POST" request to "/register" with body:
      """
      {
        "email": "frodo@test.com",
        "username": "frodo",
        "plainPassword": {
          "first": "precious",
          "second": "precious"
        }
      }
      """
    Then the response code should be 400
    And the response should contain "The entered passwords don't match"