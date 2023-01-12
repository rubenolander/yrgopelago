<?php
require('form.php');
include('calendar.php');
require('vendor/autoload.php');
?>


<head>
  <!DOCTYPE html>
  <html lang="en">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="style/pic/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="style/style.css">
  <title>Isla Rublar - YRGOpelago</title>
</head>

<body>
  <header>
    <div class="header-container">
      <h1> Welcome to Dino Resort on Isla Rublar!</h1>
      <i>Yeah this idea has been tried before but this time it'll work out, promise!</i>
    </div>
    <!-- <h2> Our rooms:</h2> -->
  </header>

  <Main>
    <section>
      <img src="style/pic/pit.jpg" alt="a man looking at a tent in a jungle">
      <h2>Pit - $1/night</h2>
      <p>A budget option for the bold and adventurous!
        Some would call you cheap for choosing this option.
        We call you fearless! </p>
      <p>This option gives you a tent spot in our vast reserve (tenting restricted to pre-assigned area).
        It has been <del>13</del> <del>5</del> 0 days since the last accident.
      </p>
    </section>

    <section>
      <img src="style/pic/standard.jpg" alt="a view from a hotel window with a broken down car and two large dinosaurs outsite">
      <h2>Standard - $3/night</h2>
      <p>You are probably here for the dinosaurs and aren't looking for either adventure nor excess, just a place to rest your weary head.</p>
      <p>Our standard option boasts two comfy beds, a warm water shower and naturally lit wood flooring. </p>
    </section>

    <section>
      <img src="style/pic/penthouse.jpg" alt="">
      <h2>Penthouse - $5/night</h2>
      <p>You flew here first class and you've already got your premium pass ready to go. Of course you'll be falling asleep to the best view.</p>
      <p>Please tell us when you want your breakfast served.</p>
    </section>
  </Main>

  <section class="calendar-container">
    <?= outputCalendar(1, $pitCalendar); ?>
    <?= outputCalendar(2, $standardCalendar); ?>
    <?= outputCalendar(3, $penthouseCalendar); ?>
  </section>

  <div class="form-container">
    <form action="index.php" method="post">
      <label for="roomtype">Choose your room:</label>
      <select name="roomtype">
        <option value="1">Pit ($1/night)</option>
        <option value="2">Standard ($3/night)</option>
        <option value="3">Penthouse ($5/night)</option>
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
      <p><?= $message; ?></p>
    </form>
  </div>

  <h2>JSON:</h2>
  <section class="JSON">
    <!-- <button onclick="copyJSON()" class="copyButton" data-value="trend">Copy JSON-string to clipboard</button> -->
    <p class="JSONfield"><?= $bookingResponse ?></p>
  </section>

  <script src="script.js"></script>
</body>

</html>