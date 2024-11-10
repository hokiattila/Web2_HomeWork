<!DOCTYPE HTML>
<html lang="hu">
<head>
    <title></title>
    <meta charset="utf-8">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?=$viewData['layout_style']?>">
    <?php if($viewData['style']): ?>
    <link rel="stylesheet" href="<?=$viewData['style']?>">
    <?php endif; ?>
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="">

<header>
    <div class="container"></div>
</header>
<!-- Loading gif eltüntetése ha betölt az oldal -->
<!-- A betöltő div -->
<div id="betolto">
    <img src="<?=IMG.'loading.gif'?>" alt="Betöltő animáció">
</div>
<!-- Navigációs menü -->
<?php echo Menu::getMenu($viewData['selectedItems']); ?>
<br><br>
<div><h1 class="center">Az autókereskedésünkről</h1><hr class="custom-hr"></div>
<div class="intro-container">
    <p class="intro-text">Üdvözöljük az Autókereskedésünkben! Cégünk a legjobb minőségű új és használt autók értékesítésével foglalkozik. Ügyfeleink elégedettsége és bizalma számunkra az elsődleges fontosságú, és mindent megteszünk annak érdekében, hogy az ügyfeleink elégedettek legyenek. Kínálatunkban megtalálhatók a legnépszerűbb márka és modell autók, és minden autót alaposan átvizsgálunk, hogy biztosítsuk a kiváló minőséget és megbízhatóságot. Csapatunk minden igényét teljesíteni fogja, és szívesen segítünk Önnek megtalálni az álmai autóját. Várjuk Önt szeretettel!</p>
</div>
<div><h1 class="center">Hol találsz meg minket</h1><hr class="custom-hr"></div>
<div class="map-container">
    <div class="map-text">
        <p><br>Kecskemét, 6000 <br><br> Felsőcsalános tanya 5</p>
    </div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d87255.86412013738!2d19.521612190404035!3d46.888050138025406!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x4743d1c02cb3bf07%3A0xc4e7da17a52cdd39!2zS2Vjc2tlbcOpdCwgRmVsc8WRY3NhbMOhbm9zIHRhbnlhIDUsIDYwMDA!3m2!1d46.8880797!2d19.6040127!5e0!3m2!1shu!2shu!4v1713968802048!5m2!1shu!2shu" width="900" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<div><h1 class="center">Nézd meg a bemutató videónkat</h1><hr class="custom-hr"></div>
<div class="center">
    <iframe width="1000px" height="500px" src="https://www.youtube.com/embed/YuzClM_OAO0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
<div><h1 class="center">Vásárlóink mondták</h1><hr class="custom-hr"></div>
<div class="review-container">
    <div class="review">
        <p class="name">Kiss József</p>
        <span class="rating">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
        <p class="comment">Nagyon elégedett vagyok az autókereskedéssel, kiváló kiszolgálást kaptam, és az autó is kiváló állapotban van.</p>
    </div>
    <hr>
    <div class="review">
        <p class="name">Lakatos Géza</p>
        <span class="rating">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
        <p class="comment">Fantasztikus élmény volt az autóvásárlás! A kereskedés személyzete nagyon segítőkész és profi volt.</p>
    </div>
    <hr>
    <div class="review">
        <p class="name">Nagy János</p>
        <span class="rating">&#9733;&#9733;&#9733;&#9734;&#9734;</span>
        <p class="comment">Egy kicsit több figyelmet vártam volna az ügyintézéstől, de összességében elégedett vagyok az autóval.</p>
    </div>
</div>
<br><br>


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