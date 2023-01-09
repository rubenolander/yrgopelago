<?php

declare(strict_types=1);
require_once('hotelFunctions.php');
require('functions.php');

//Set message below submit button.
$message = "Please make your reservation above.";
$bookingResponse = "Your JSON will arrive here upon sucessful reservation.";
//First check if all the form variables have been put in.
if (isset($_POST['user'], $_POST['roomtype'], $_POST['arrivalDate'], $_POST['departureDate'], $_POST['transferCode'])) {

    $visitorName = htmlspecialchars(trim($_POST['user']));
    $roomType = $_POST['roomtype'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    $transferCode = htmlspecialchars(trim($_POST['transferCode']));

    //This calculation needs work if I'm to add features.
    $numberOfNights = floor(strtotime($departureDate) / 86400) - floor(strtotime($arrivalDate) / 86400);

    //Got wrong number returned when I multiplied in the above row. Doing it in two steps instead.
    $totalCost = $numberOfNights * getRoomPrice($roomType);

    //This is for checking dates directly in the form/POST.
    if ($arrivalDate >= $departureDate) {
        $message = "Your arrival needs to be at least a day before your departure.";
    }

    //Run the query that checks if the chosen room is available.
    $roomAvailable = checkRoomAvailability($hotelDb, $roomType, $arrivalDate, $departureDate);
    //If it adds upp so far. Start checking the transfercode.
    $validUUID = isValidUuid($transferCode);


    if (count($roomAvailable) === 0) {
        if ($validUUID and transferCodeCheck($transferCode, $totalCost)) {

            transferCodeDeposit($transferCode, "Ruben");

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

            $message = "Thanks $visitorName, we have recieved your reservation.";

            $jsonResponse = [
                "island" => "Isla Rublar",
                "hotel" => "Dino Resort",
                "arrival_date" => "$arrivalDate",
                "departure_date" => "$departureDate",
                "total_cost" => "$totalCost",
                "stars" => "0",
                "addtional_info" => "At least Ruben, the hotel owner, had a blast this Christmas."
            ];
            $bookingResponse = json_encode($jsonResponse);
        } else {
            $message = "Either the transfer code is invalid or you don't have enough money on it, please check again.";
        }
    } else {
        $message = "Sorry that room's already reserved during that time.";
    }
}
