<?php
require('form.php');
include('calendar.php');
require('vendor/autoload.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <title>Isla Rublar</title>
</head>

<body>
  <h1> Welcome to Dino Resort on Isla Rublar!</h1>
  <h2> Info about our rooms below:</h2>

  <Main>
    <section>
      <h2>Pit</h2>
      <?= outputCalendar(1, $pitCalendar); ?>
    </section>
    <section>
      <h2>Standard</h2>
      <?= outputCalendar(2, $standardCalendar); ?>

    </section>
    <section>
      <h2>Penthouse</h2>
      <?= outputCalendar(3, $penthouseCalendar); ?>

    </section>
  </Main>
  <form action="index.php" method="post">
    <label for="roomtype">Choose your room:</label>
    <select name="roomtype">
      <option value="1">Pit</option>
      <option value="2">Standard</option>
      <option value="3">Penthouse</option>
    </select>
    <label for="user">Visitor name:</label>
    <input type="text" name="user" placeholder="Your username" required>
    <label for="arrivalDate">Arrival date:</label>
    <input type="date" name="arrivalDate" min="2023-01-01" max="2023-01-31" required>
    <label for="departureDate">Departure date:</label>
    <input type="date" name="departureDate" min="2023-01-01" max="2023-01-31" required>
    <label for="transferCode">Transfer code:</label>
    <input type="text" name="transferCode" placeholder="Code here!">
    <button type="submit">Make reservation</button>
    <?= $message; ?>
  </form>

  <section class="JSON">
    <h2>JSON:</h2>
    <p> <?= $bookingResponse ?> </p>
  </section>
</body>

</html>