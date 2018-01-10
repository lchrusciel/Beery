@rate @application @api
Feature: Rating a beer
    In order to share my opinion about a beer with the community
    As a Community Member
    I want to rate a beer

    Scenario: Rate from single customer
        Given the "King of Hop" beer with 5% ABV has been added
        And I registered as "Rick Sanchez" with the "rick@morty.com" email and the "birdperson1" password
        And I am logged in as "rick@morty.com" with "birdperson1" password
        When I rate the "King of Hop" beer 5
        Then the "King of Hop" beer should have average rate 5

    Scenario: Multiple rates from single customer
        Given the "King of Hop" beer with 5% ABV has been added
        And the "Primátor Exkluziv 16°" beer with 7.5% ABV has been added
        And I registered as "Rick Sanchez" with the "rick@morty.com" email and the "birdperson1" password
        And I am logged in as "rick@morty.com" with "birdperson1" password
        When I rate the "King of Hop" beer 5
        And I rate the "Primátor Exkluziv 16°" beer 3
        Then the "King of Hop" beer should have average rate 5
        And the "Primátor Exkluziv 16°" beer should have average rate 3

    Scenario: Rates from multiple customers
        Given the "King of Hop" beer with 5% ABV has been added
        And there is a "Rick Sanchez" connoisseur
        And the "Rick Sanchez" connoisseur rated the "King of Hop" beer 5
        And I registered as "Mr Meeseeks" with the "mr@meeseeks.com" email and the "lookatme" password
        And I am logged in as "mr@meeseeks.com" with "lookatme" password
        When I rate the "King of Hop" beer 4
        Then the "King of Hop" beer should have average rate 4.5
