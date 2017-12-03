@connoisseur @application
Feature: Registering a connoisseur
    In order to be able to use application fully
    As a Connoisseur
    I want to register

    Scenario: Registering a connoisseur
        When I register the "Rick Sanchez" connoisseur with the "rick@morty.com" email and the "birdperson1" password
        Then the "Rick Sanchez" connoisseur should be created
