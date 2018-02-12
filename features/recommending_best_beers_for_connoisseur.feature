@api @recommendation
Feature: Recommending best beers for connoisseur
    In order to make better choices when trying new beer
    As a Connoisseur
    I need an advice from application

    Background:
        Given the "ANTYbiotyk" beer with 7% ABV has been added
        And the "PROpaganda" beer with 6.8% ABV has been added
        And the "Kasztelan Niepasteryzowane" beer with 5.7% ABV has been added
        And there is a "armin@van.kraken" connoisseur
        And there is a "pamile@krawczyk.pl" connoisseur
        And there is a "janke@mops.com" connoisseur
        And there is a "zaleslaw@middleage.com" connoisseur

    Scenario: It is impossible to get a beer recommendation if customer is not logged in
        When I try to ask for a beer recommendation
        Then I should be notified that I'm not allowed to do it

    Scenario: Getting a simple recommendation
        Given the "armin@van.kraken" connoisseur rated the "ANTYbiotyk" beer 4.5
        And the "armin@van.kraken" connoisseur rated the "PROpaganda" beer 4
        And the "armin@van.kraken" connoisseur rated the "Kasztelan Niepasteryzowane" beer 2
        And I registered as "Rick Sanchez" with the "rick@morty.com" email and the "birdperson1" password
        And I am logged in as "rick@morty.com" with "birdperson1" password
        And I rated the "PROpaganda" beer 4
        When I ask for a beer recommendation
        Then the "ANTYbiotyk" beer should be suggested

    Scenario: Getting an advance recommendation
        Given the "armin@van.kraken" connoisseur rated the "ANTYbiotyk" beer 3.5
        And the "armin@van.kraken" connoisseur rated the "PROpaganda" beer 4
        And the "armin@van.kraken" connoisseur rated the "Kasztelan Niepasteryzowane" beer 2
        And the "pamile@krawczyk.pl" connoisseur rated the "ANTYbiotyk" beer 4
        And the "pamile@krawczyk.pl" connoisseur rated the "PROpaganda" beer 4.5
        And the "pamile@krawczyk.pl" connoisseur rated the "Kasztelan Niepasteryzowane" beer 1
        And the "janke@mops.com" connoisseur rated the "ANTYbiotyk" beer 2
        And the "janke@mops.com" connoisseur rated the "PROpaganda" beer 4
        And the "janke@mops.com" connoisseur rated the "Kasztelan Niepasteryzowane" beer 3
        And the "zaleslaw@middleage.com" connoisseur rated the "ANTYbiotyk" beer 4
        And the "zaleslaw@middleage.com" connoisseur rated the "Kasztelan Niepasteryzowane" beer 1
        And I registered as "Rick Sanchez" with the "rick@morty.com" email and the "birdperson1" password
        And I am logged in as "rick@morty.com" with "birdperson1" password
        And I rated the "PROpaganda" beer 4
        When I ask for a beer recommendation
        Then the "ANTYbiotyk" beer should be suggested
