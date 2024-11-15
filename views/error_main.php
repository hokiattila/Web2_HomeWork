
<!DOCTYPE HTML>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/ottakocsid/public/img/tab_logo.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href=<?= '/ottakocsid/'.$viewData['layout_style']?>>
    <link rel="stylesheet" href="/ottakocsid/public/css/login.css">
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
    <img src="/ottakocsid/public/img/loading.gif" alt="Betöltő animáció">
</div>
<!-- Navigációs menü -->
<?php echo Menu::getMenu($viewData['selectedItems']); ?>
</div>
<br><br><br><br><br><br><br><br>
<div class="form-container">
    <h1>Hiba!</h1><h2><br>Nem létező hivatkozásra kattintottál!</h2>
    <p>Pár másodpercen belül automatikusan visszairányítunk a <a href="/ottakocsid/home"></a>főoldalra.</p>
    <button class="search-button2" onclick="window.location.href = '/ottakocsid/home';">Kattints ide hogy visszatérj a főoldalra</button>
</div>
<br><br><br><br><br><br><br><br>
<script>
    setTimeout(function() {
        window.location.href = "/ottakocsid/home";
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