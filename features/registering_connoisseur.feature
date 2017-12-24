@connoisseur @application @api
Feature: Registering a connoisseur
    In order to be able to use application fully
    As a Connoisseur
    I want to register

    Scenario: Registering a connoisseur
        When I register the "Rick Sanchez" connoisseur with the "rick@morty.com" email and the "birdperson1" password
        Then I should be able to log in as "rick@morty.com" with "birdperson1" password
