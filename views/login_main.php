
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?=$viewData['layout_style']?>">
    <?php if($viewData['style']): ?>
        <link rel="stylesheet" href="<?=$viewData['style']?>">
    <?php endif; ?>
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

    </style>
</head>
<body class="">

<header>
    <div class="container"></div>
</header>
<!-- Loading gif eltüntetése ha betölt az oldal -->
<!-- A betöltő div -->
<div id="betolto">
    <img src="public/img/loading.gif" alt="Betöltő animáció">
</div>
<?php echo Menu::getMenu($viewData['selectedItems']); ?>
<br><br><br><br><br>
<div class="form-container">
    <h2>Bejelentkezés</h2>
    <form action="post" method="post">
        <input type="text" name="username" placeholder="Felhasználónév" required><br>
        <input type="password" name="password" placeholder="Jelszó" required><br>
        <input type="submit" value="Bejelentkezés">
    </form>
    <br><br><br>
    <hr class="separator">
    <br>
    <p>Nincs még fiókod?<br><br>
        <a href="register.html"><button class="search-button">Regisztrálj az oldalunkra!</button></a></p>
</div>

<br><br><br><br><br>


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