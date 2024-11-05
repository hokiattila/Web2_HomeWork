
<!DOCTYPE HTML>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/tab_logo.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hiba</title>
</head>
<body class="">

<header>
    <div class="container"></div>
</header>
<!-- Loading gif eltüntetése ha betölt az oldal -->
<!-- A betöltő div -->
<div id="betolto">
    <img src="img/loading.gif" alt="Betöltő animáció">
</div>
<!-- Navigációs menü -->
<div class="navbar">
    <!-- Logó -->
    <div class="logo">
        <a href="index.php"><img src="img/logo.png" alt="Logó"></a>
    </div>
    <!-- Menüpontok -->
    <div class="menu">
        <a href="index.php" class="activenav">Főoldal</a>
        <a href="contact.php">Kapcsolat</a>
        <?php if(empty($_SESSION['username']) || empty($_SESSION['role'])): ?>
            <a href="login.php" <?php if(basename(__FILE__) == "login.php"): ?> class="<?php echo "activenav"; ?>"<?php endif;?>>Bejelentkezés</a>
        <?php else: ?>
            <a href="user.php"><?php echo $_SESSION['username'];?></a>
            <a href="app/datacontroller.php?logout=true">Kijelentkezés</a>
        <?php endif; ?>
    </div>
</div>
</div>
<br><br><br><br><br><br><br><br>
<div class="form-container">
    <h1>Hiba!</h1><h2><br>Nem létező hivatkozásra kattintottál!</h2>
    <p>Pár másodpercen belül automatikusan visszairányítunk a <a href="index.html"></a>főoldalra.</p>
    <button class="search-button2" onclick="window.location.href = 'index.php';">Kattints ide hogy visszatérj a főoldalra</button>
</div>
<br><br><br><br><br><br><br><br>
<script>
    setTimeout(function() {
        window.location.href = "index.php";
    }, 5000); // 5 másodperc után visszairányítás az index.html-re
</script>

<script>
    window.addEventListener('load', function() {
        var betoltoDiv = document.getElementById('betolto');
        var tartalomDiv = document.getElementById('tartalom');
        betoltoDiv.style.display = 'none'; // A betöltő div elrejtése
        tartalomDiv.style.display = 'block'; // A tartalom megjelenítése
    });
</script>

<!-- Galléria aktív kép -->
<script>
    const activeImage = document.querySelector(".product-image .active");
    const productImages = document.querySelectorAll(".image-list img");
    const navItem = document.querySelector('a.toggle-nav');

    function changeImage(e) {
        activeImage.src = e.target.src;
    }

    function toggleNavigation(){
        this.nextElementSibling.classList.toggle('active');
    }

    productImages.forEach(image => image.addEventListener("click", changeImage));
    navItem.addEventListener('click', toggleNavigation);
</script>
<footer>
    <p>&copy; 2024 Ott a kocsid! kft. Minden jog fenntartva.</p>
    <p class="contact">Kapcsolat: support@ottakocsid.hu | Telefon: +36 1 234 5678</p>
</footer>
</body>
</html>