@application @api
Feature: Adding a new beer
    In order to share details about the beer with the community
    As a Community Member
    I want to add a beer to catalogue

    Scenario: Adding a new beer
        When I add a new "King of Hop" beer which has 5% ABV
        And the "King of Hop" beer should be available in the catalogue
