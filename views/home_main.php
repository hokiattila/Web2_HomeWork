
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Ott a kocsid! - Főoldal</title>
    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?=$viewData['layout_style']?>">
    <?php if($viewData['style']): ?>
        <link rel="stylesheet" href="<?=$viewData['style']?>">
    <?php endif; ?>
    <link rel="stylesheet" href="pub/css/listing.css">
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    </style>
</head>
<body class="">

<header>
</header>
<!-- Loading gif eltüntetése ha betölt az oldal -->
<!-- A betöltő div -->
<div id="betolto">
    <img src="img/loading.gif" alt="Betöltő animáció">
</div>
<!-- Navigációs menü -->
<?php echo Menu::getMenu($viewData['selectedItems']); ?>
<div class="mainimage-container">
    <img src="public/img/carstore.jpg" >

    <div class="imageonimage">
        <div class="hatterkocka">
            <h1>Üdvözlünk az oldalunkon!</h1>
            <p>Találd meg a számodra megfelelő autót még ma!</p>
        </div>
    </div>

    <div class="button-container">
        <a href="#filters"><button>Ismerd meg kínálatunkat!</button></a>
    </div>
</div>

<!-- 3 box -->
<div class="container">
    <div class="box">
        <div class="box-tartalom">
            <div class="box-icon">⚙️</div>
            <div class="box-text">Csapj le az új autókkal érkező akcióra és garanciára! Mi garantáljuk neked a minőséget!</div>
        </div>
    </div>
    <div class="box">
        <div class="box-tartalom">
            <div class="box-icon">📁</div>
            <div class="box-text">Jelentkezz be az oldalunkon, és mentsd el a kedvenc autóidat, hogy később megtaláld őket!</div>
        </div>
    </div>
    <div class="box">
        <div class="box-tartalom">
            <div class="box-icon">🔍</div>
            <div class="box-text">Állítsd be a számodra fontos preferenciákat, és találd meg a legjobban tetsző autót!</div>
        </div>
    </div>

</div>
<!-- Lapozható galéria -->

<!--
<div class="mySlides fade">
    <img src="img/carpic2.jpg" style="width:100%">
</div>

<div class="mySlides fade">
    <img src="img/auto3.jpeg" style="width:100%">
</div>
-->


<!-- Lapozó gombok -->
<!--
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>
-->
</div>
</div>
<!-- Kategória kiválasztás a kereséshez -->
<div><h1 class="center">Találd meg a számodra megfelelő autót!</h1><hr class="custom-hr"></div>
<div>
    <div class="centercontainer" id="filters">
        <form>
            <div class="input-container">
                <div class="dropdown">
                    <button onclick="ClickedOnButton1('dropdownMarka')" class="dropbtn" type="button">Márka</button>
                    <div id="dropdownMarka" class="dropdown-content">
                        <input type="text" placeholder="Keresés.." id="inputMarka" onkeyup="filterFunction('inputMarka','dropdownMarka')">
                        <a href="#mercedes-benz">Mercedes-Benz</a>
                        <a href="#audi">Audi</a>
                        <a href="#ford">Ford</a>
                        <a href="#bmw">BMW</a>
                        <a href="#peugeot">Peugeot</a>
                        <a href="#suzuki">Suzuki</a>
                        <a href="#toyota">Toyota</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button onclick="ClickedOnButton1('dropdownTipus')" class="dropbtn" type="button">Modell</button>
                    <div id="dropdownTipus" class="dropdown-content">
                        <input type="text" placeholder="Keresés..." id="inputTipus" onkeyup="filterFunction('inputTipus','dropdownTipus')">
                        <a href="#cclass">C osztály</a>
                        <a href="#cla">cla</a>
                        <a href="#sclass">S osztály</a>
                        <a href="#eqb">EQB</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button onclick="ClickedOnButton1('dropdownAllapot')" class="dropbtn" type="button">Állapot</button>
                    <div id="dropdownAllapot" class="dropdown-content">
                        <input type="text" placeholder="Keresés..." id="inputAllapot" onkeyup="filterFunction('inputAllapot','dropdownAllapot')">
                        <a href="#uj">Új</a>
                        <a href="#ujszeru">Újszerű</a>
                        <a href="#viseletes">Viseletes</a>
                        <a href="#totalkar">Totálkár</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button onclick="ClickedOnButton1('dropdownUzemanyag')" class="dropbtn" type="button">Üzemanyag</button>
                    <div id="dropdownUzemanyag" class="dropdown-content">
                        <input type="text" placeholder="Keresés..." id="inputUzemanyag" onkeyup="filterFunction('inputUzemanyag','dropdownUzemanyag')">
                        <a href="#benzin">Benzin</a>
                        <a href="#dizel">Dízel</a>
                        <a href="#gaz">Gáz</a>
                        <a href="#hidrogen">Hidrogén</a>
                        <a href="#elektromos">Elektromos</a>
                    </div>
                </div>

                <input type="text" placeholder="Kezdő ár">
                <input type="text" placeholder="Vég ár">
            </div>
            <div align="right">
                <button class="search-button" type="submit">Szűrés</button></div>
        </form>
    </div>
</div>

<div class="centercontainer" >
    <hr>
    <ul class="list">
        <!-- listaelemeket php-val megjeleníteni dinamikusan a dobott találatok alapján -->

        <li class="list-item">

            <a href="car.html"><img class="list-itemkep" src="public/img/cars/cla/cla1.jpg" alt="Kép 3"></a>
            <div class="list-item-content">
                <div class="cimpluszkedvenc"><a href="car.html" ><h3>Mercedes-Benz CLA-180</h3> <!-- brand + modell típus --></a><div class="star"><img src="img/star_empty.png" alt="Kedvencekhez adás"></div></div>
                <p><i class="tag1">2016</i>&nbsp&nbsp<i class="tag1">4 ajtós</i>&nbsp&nbsp<i class="tag1">Fekete</i></p>
                <p><i class="tag2">180 LE</i>&nbsp&nbsp<i class="tag2">Benzin</i></p>
                <p><i class="tag3">Újszerű</i></p>

                <p>Rövid leírás 3.</p>
                <hr>
                <p><b>Ár: 13,000,000 Ft</b></p>
            </div>

        </li>
        <hr class="separator2">
        <a href="car.html">
            <li class="list-item">

                <a href="car.html"><img class="list-itemkep" src="public/img/cars/cla/cla2.webp" alt="Kép 3"></a>
                <div class="list-item-content">
                    <div class="cimpluszkedvenc"><a href="car.html" ><h3>Mercedes-Benz CLA-180</h3> <!-- brand + modell típus --></a><div class="star"><img src="img/star_empty.png" alt="Kedvencekhez adás"></div></div>
                    <p><i class="tag1">2016</i>&nbsp&nbsp<i class="tag1">4 ajtós</i>&nbsp&nbsp<i class="tag1">Fekete</i></p>
                    <p><i class="tag2">180 LE</i>&nbsp&nbsp<i class="tag2">Benzin</i></p>
                    <p><i class="tag3">Újszerű</i></p>

                    <p>Rövid leírás 3.</p>
                    <hr>
                    <p><b>Ár: 13,000,000 Ft</b></p>
                </div>

            </li>
            <hr class="separator2">
            <li class="list-item">

                <a href="car.html"><img class="list-itemkep" src="public/img/cars/cla/cla4.webp" alt="Kép 3"></a>
                <div class="list-item-content">
                    <div class="cimpluszkedvenc"><a href="car.html" ><h3>Mercedes-Benz CLA-180</h3> <!-- brand + modell típus --></a><div class="star"><img src="img/star_empty.png" alt="Kedvencekhez adás"></div></div>
                    <p><i class="tag1">2016</i>&nbsp&nbsp<i class="tag1">4 ajtós</i>&nbsp&nbsp<i class="tag1">Fekete</i></p>
                    <p><i class="tag2">180 LE</i>&nbsp&nbsp<i class="tag2">Benzin</i></p>
                    <p><i class="tag3">Újszerű</i></p>

                    <p>Rövid leírás 3.</p>
                    <hr>
                    <p><b>Ár: 13,000,000 Ft</b></p>
                </div>

            </li>
            <hr>
            <!-- Majd itt jöhet a matek, a lényeg a design -->
            <div class="pagination">
                <button >Előző</button>
                <button >1</button>
                <button >2</button>
                <button >3</button>
                <button >4</button>
                <button >5</button>
                <button >6</button>
                <button >7</button>
                <button >8</button>
                <button >9</button>
                <button >10</button>
                <button >Következő</button>
            </div>
    </ul>
</div>
<!-- Ha lesz elég content ez majd törlendő! -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<script>
    window.addEventListener('load', function() {
        var betoltoDiv = document.getElementById('betolto');
        var tartalomDiv = document.getElementById('tartalom');
        betoltoDiv.style.display = 'none'; // A betöltő div elrejtése
        tartalomDiv.style.display = 'block'; // A tartalom megjelenítése
    });
</script>
<!-- Gallériához javascript -->
<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    // Következő/Előző dia megjelenítése
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Aktuális dia megjelenítése
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex-1].style.display = "block";
    }
</script>
<!-- Dropdown menuhoz javascript -->
<script>
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function ClickedOnButton1(id) {
        document.getElementById(id).classList.toggle("show");
    }


    function filterFunction(inputid,dropdownid) {
        var input, filter, ul, li, a, i;
        input = document.getElementById(inputid);
        filter = input.value.toUpperCase();
        div = document.getElementById(dropdownid);
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }


</script>
<!-- Lefele görgetés gombra kattintva -->
<script>
    function scrollToBottom() {
        window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth'
        });
    }
</script>
<!-- Esemenyfigyelo a dropdown lezárására -->
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("dropdownMarka");
        dropdown.classList.toggle("show");
    }

    function selectOption(option) {
        // Ide teheted a kiválasztott opcióval kapcsolatos műveleteket
        console.log("Kiválasztott opció:", option);
        closeDropdown();
    }

    function closeDropdown() {
        var dropdown = document.getElementById("dropdownMarka");
        dropdown.classList.remove("show");
    }

    // Eseményfigyelő az oldal többi részére
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
<footer>
    <p>&copy; 2024 Ott a kocsid! kft. Minden jog fenntartva.</p>
    <p class="contact">Kapcsolat: support@ottakocsid.hu | Telefon: +36 1 234 5678</p>
</footer>
</body>
</html>