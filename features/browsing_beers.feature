@beer @api
Feature: Browsing beers
    In order to being aware of current beers catalogue
    As a Community Member
    I want to browse all available beers

    Scenario: Browsing beers
        Given the "King of Hop" beer with 5% ABV has been added
        When I browse the beers catalogue
        Then I should see the "King of Hop" beer
