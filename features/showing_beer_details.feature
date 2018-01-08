@beer @api
Feature: Showing beer details
    In order to check more information about the beer
    As a Community Member
    I want to see beer details

    Scenario: Adding a new beer
        Given the "King of Hop" beer with 5% ABV has been added
        When I check the "King of Hop" details
        Then I should see that the "King of Hop" beer has 5% ABV, 0 rates and its average rate is 0
