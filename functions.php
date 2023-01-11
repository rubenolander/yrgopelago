<?php

declare(strict_types=1);
// include('hotelFunctions.php');
require('vendor/autoload.php');

function getRoomPrice(string $roomType): int
{
    $hotelDb = connect('hotel.db');
    $costQuery = 'SELECT cost from rooms WHERE id = :roomtype';
    $stmt = $hotelDb->prepare($costQuery);
    $stmt->bindParam(':roomtype', $roomType, PDO::PARAM_INT);
    $stmt->execute();
    $roomCosts = $stmt->fetch(PDO::FETCH_ASSOC);
    return $roomCosts['cost'];
}


function checkRoomAvailability(object $hotelDb, string $roomType, string $arrivalDate, string $departureDate)
{
    $hotelDb = connect('hotel.db');

    $dateQuery = 'SELECT * FROM bookings 
    WHERE 
    room_id = :roomtype
    AND 
    (arrival_date <= :arrivalDate 
    or arrival_date < :departureDate )
    AND 
    (departure_date > :arrivalDate or
    departure_date >:departureDate)';
    $statement = $hotelDb->prepare($dateQuery);
    $statement->bindParam(':roomtype', $roomType, PDO::PARAM_INT);
    $statement->bindParam(':arrivalDate', $arrivalDate, PDO::PARAM_STR);
    $statement->bindParam(':departureDate', $departureDate, PDO::PARAM_STR);
    $statement->execute();
    $bookings = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $bookings;
}

// Block for filling calendar dates.
function fetchBookings($roomType)
{
    $hotelDb = connect('hotel.db');
    $roomQuery = 'SELECT * from bookings WHERE room_id = :roomtype';
    $stmt = $hotelDb->prepare($roomQuery);
    $stmt->bindParam(':roomtype', $roomType, PDO::PARAM_INT);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $bookings;
}

function outputCalendar($roomType, $calendar)
{
    foreach (fetchBookings($roomType) as $booking) {

        $calendar->addEvent(
            $booking['arrival_date'],
            $booking['departure_date'],
            "",
            true,

        );
    }
    echo $calendar->draw(date('2023-01-01'));
}

//GUZZLE transfercode block, one for checking viability and one for depositing into central bank.
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

function transferCodeCheck($transferCode, $totalCost): bool
{
    $client = new GuzzleHttp\Client();

    $response = [
        'form_params' => [
            'transferCode' => $transferCode,
            'totalcost' => $totalCost
        ]
    ];

    $response = $client->post("https://www.yrgopelago.se/centralbank/transferCode", $response);
    $response = $response->getBody()->getContents();
    $response = json_decode($response, true);
    if (isset($response['error'])) {
        return false;
    } else {
        return true;
    }
}

function transferCodeDeposit($transferCode, $userName): bool
{
    $client = new GuzzleHttp\Client();

    $response = [
        'form_params' => [
            'transferCode' => $transferCode,
            'user' => $userName
        ]
    ];
    $response = $client->post("https://www.yrgopelago.se/centralbank/deposit", $response);
    $response = $response->getBody()->getContents();
    $response = json_decode($response, true);
    if (isset($response['error'])) {
        return false;
    } else {
        return true;
    }
}
