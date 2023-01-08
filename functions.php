<?php

declare(strict_types=1);
// include('hotelFunctions.php');
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
