<?php

declare(strict_types=1);
require_once('hotelFunctions.php');
require('functions.php');
// $testCode = 'b4184c1a-ebd9-47c4-a1ff-0e25b7a31aa5';

$message = "Please make your reservation above.";

if (isset($_POST['roomtype'], $_POST['arrivalDate'], $_POST['departureDate'], $_POST['transferCode'])) {

    $roomType = $_POST['roomtype'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    $transferCode = htmlspecialchars(trim($_POST['transferCode']));

    $numberOfNights = floor(strtotime($departureDate) / 86400) - floor(strtotime($arrivalDate) / 86400);
    //Got wrong number returned when I multiplied in the above row. Doing it in two steps instead.
    $totalCost = $numberOfNights * getRoomPrice($roomType);

    if ($arrivalDate >= $departureDate) {
        $message = "Your arrival needs to be at least a day before your departure.";
    }

    $roomAvailable = checkRoomAvailability($hotelDb, $roomType, $arrivalDate, $departureDate);

    $validUUID = isValidUuid($transferCode);
    if (count($roomAvailable) === 0) {
        if ($validUUID and transferCodeCheck($transferCode, $totalCost)) {
            $insertQuery =
                'INSERT INTO bookings (room_id, arrival_date, departure_date, transfer_code, cost) 
            VALUES (:roomtype, :arrivalDate, :departureDate, :transferCode, :cost)';
            $statement = $hotelDb->prepare($insertQuery);
            $statement->bindParam(':roomtype', $roomType, PDO::PARAM_INT);
            $statement->bindParam(':arrivalDate', $arrivalDate, PDO::PARAM_STR);
            $statement->bindParam(':departureDate', $departureDate, PDO::PARAM_STR);
            $statement->bindParam(':transferCode', $transferCode, PDO::PARAM_STR);
            $statement->bindParam(':cost', $totalCost, PDO::PARAM_INT);
            $statement->execute();
            $message = "Thanks, we have recieved your reservation.";

            //JSON response with datan som behövs.
            // island
            // hotel
            // arrival_date
            // departure_date
            // total_cost
            // stars
            // features
            // additional_info. 
        } else {
            $message = "Either the transfer code is invalid or you don't have enough money on it, please check again.";
        }
    } else {
        $message = "Sorry that room's already reserved during that time.";
    }
}
