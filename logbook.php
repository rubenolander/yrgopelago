<?php
require('vendor/autoload.php');
require('functions.php');
require('hotelFunctions.php');

$logbook = json_decode(file_get_contents(__DIR__ . "/logbook.json"), true);
$bookings = 0;
?>


<head>
    <!DOCTYPE html>
    <html lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="style/pic/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/logbook.css">
    <title>Isla Rublar - YRGOpelago</title>
</head>

<body>
    <header>
        <div class="header-container">
            <h1><a href="./index.php"> Dino Resort Logbook</a></h1>
            <i>Yeah this idea has been tried before but this time it'll work out, promise!</i>
        </div>
        <div class="logbook-links">
            <a href="./index.php">Index</a>
            <a href="./logbook.php">Logbook</a>
        </div>
    </header>
    <Main>
        <section class=cards-container>
            <?php foreach ($logbook as $booking) :

            ?>

                <div class="logbook-card">
                    <h2>Island: <?= $booking["island"] ?></h2>
                    <h3>Hotel: <?= $booking["hotel"] ?></h3>
                    <p>Duration: <?= $booking["arrival_date"] ?> - <?= $booking["departure_date"] ?> </p>
                    <p>Stars: <?= $booking["stars"] ?>
                    <p>Cost: <?= $booking["total_cost"] ?>
                    <h3>Features:</h3>
                    <?php foreach ($booking["features"] as $feature) :
                    ?>

                        <p>Name: <?= $feature["name"] ?></p>
                        <p>Cost: <?= $feature["cost"] ?></p>

                    <?php endforeach ?>
                </div>

            <?php endforeach; ?>
        </section>
    </Main>

    <?php


    $revenue = 0;
    $numberOfBookings = 0;
    $revenuePerBooking = 0;
    $rooms = [0, 1, 2];
    foreach ($rooms as $room) {
        $bookings = fetchBookings($room);
        foreach ($bookings as $booking) {
            $revenue += $booking["cost"];
            $numberOfBookings += 1;
        }
    }
    if ($numberOfBookings !== 0) $revenuePerBooking = ($revenue /  $numberOfBookings)

    ?>

    <h2>Fact Box:</h2>
    <section class="fact-box">

        <p>Total Revenue: <?= $revenue ?></p>
        <p>Revenue Per Booking: <?= number_format($revenuePerBooking, 2, ".") ?></p>
        </p>



    </section>

</body>



<?php
