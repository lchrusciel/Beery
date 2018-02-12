@beer @api
Feature: Adding a beer
    In order to share details about the beer with the community
    As a Community Member
    I want to add a beer to catalogue

    @application
    Scenario: Adding a new beer
        Given I registered as "Rick Sanchez" with the "rick@morty.com" email and the "birdperson1" password
        And I am logged in as "rick@morty.com" with "birdperson1" password
        When I add a new "King of Hop" beer which has 5% ABV
        Then the "King of Hop" beer should be available in the catalogue

    Scenario: It is impossible to add a new beer if customer is not logged in
        When I try to add a new "King of Hop" beer which has 5% ABV
        Then I should be notified that I'm not allowed to do it
