<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Undangan Zhidan & Suci</title>

  <link rel="stylesheet" href="style.css">

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Dancing+Script:wght@600&family=IM+Fell+English&display=swap" rel="stylesheet">
</head>
<body>

<div class="cover">

  <div class="overlay"></div>

  <div class="content">

    <div class="ornament">❧</div>

    <p class="label">The Wedding of</p>

    <h1 class="names">
      Zhidan
      <span>&</span>
      Suci
    </h1>

    <p class="date">20 · II · 2027</p>

    <div class="line"></div>

    <p class="guest-label">Kepada Yth.</p>

    <?php
      $guestName = "Vramroro";
      echo "<h2 class='guest'>$guestName</h2>";
    ?>

    <a href="/undangan/index.php" class="btn">Buka Undangan</a>

    <div class="ornament bottom">❧</div>

  </div>

  <!-- Vinyl -->
  <div class="vinyl"></div>

</div>

</body>
</html>