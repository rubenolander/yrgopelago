<?php
require('form.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/" type="image/x-icon">
  <title>Isla Rublar</title>
</head>

<body>
  <form action="index.php" method="post">
    <label for="roomtype">Choose your room:</label>
    <select name="roomtype">
      <option value="1">Pit</option>
      <option value="2">Standard</option>
      <option value="3">Penthouse</option>
    </select>
    <label for="arrivalDate">Arrival date:</label>
    <input type="date" name="arrivalDate" min="2023-01-01" max="2023-01-31">
    <label for="departureDate">Departure date:</label>
    <input type="date" name="departureDate" min="2023-01-01" max="2023-01-31">
    <label for="transferCode">Transfer code:</label>
    <input type="text" name="transferCode" placeholder="Code here!">
    <button type="submit">Book room</button>
  </form>
</body>

</html>