@beer @api
Feature: Showing beer details
    In order to check more information about the beer
    As a Community Member
    I want to see beer details

    Scenario: Checking details of newly created beer
        Given the "King of Hop" beer with 5% ABV has been added
        When I check the "King of Hop" details
        Then I should see that the "King of Hop" beer has 5% ABV, 0 rates and its average rate is 0

    Scenario: Checking details of beer with rates
        Given the "King of Hop" beer with 5% ABV has been added
        And there is a "Rick Sanchez" connoisseur
        And the "Rick Sanchez" connoisseur rated the "King of Hop" beer 5
        And there is a "Mr Meeseeks" connoisseur
        And the "Mr Meeseeks" connoisseur rated the "King of Hop" beer 4
        When I check the "King of Hop" details
        Then I should see that the "King of Hop" beer has 5% ABV, 2 rates and its average rate is 4.5
