<?php
require('hotelFunctions.php');

if (!isset($_POST['roomtype'], $_POST['arrivalDate'], $_POST['departureDate'], $_POST['transferCode'])) {
    echo "Please input your reservation information below:";
} else {

    $roomType = $_POST['roomtype'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    $transferCode = htmlspecialchars(trim($_POST['transferCode']));
    $numberOfNights = floor(strtotime($departureDate) / 86400) - floor(strtotime($arrivalDate) / 86400);
    //Got wrong number returned when I multiplied in the above row. Doing it in two steps instead.
    $totalCost = $numberOfNights * $roomType;
    print_r($_POST);

    $query = 'INSERT INTO bookings (room_id, arrival_date, departure_date, transfer_code, cost) VALUES (:roomtype, :arrivalDate, :departureDate, :transferCode, :cost)';
    $statement = $hotelDb->prepare($query);
    $statement->bindParam(':roomtype', $roomType, PDO::PARAM_INT);
    $statement->bindParam(':arrivalDate', $arrivalDate, PDO::PARAM_STR);
    $statement->bindParam(':departureDate', $departureDate, PDO::PARAM_STR);
    $statement->bindParam(':transferCode', $transferCode, PDO::PARAM_STR);
    $statement->bindParam(':cost', $totalCost, PDO::PARAM_INT);
    $statement->execute();
}
