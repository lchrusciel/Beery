@beer @application @api
Feature: Adding a beer
    In order to share details about the beer with the community
    As a Community Member
    I want to add a beer to catalogue

    Background:
        Given I registered as "Rick Sanchez" with the "rick@morty.com" email and the "birdperson1" password
        And I am logged in as "rick@morty.com" with "birdperson1" password

    Scenario: Adding a new beer
        When I add a new "King of Hop" beer which has 5% ABV
        Then the "King of Hop" beer should be available in the catalogue
