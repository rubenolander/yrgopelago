<?php

declare(strict_types=1);
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
