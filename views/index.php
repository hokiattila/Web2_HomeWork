<?php
        include_once("app/datacontroller.php");
        include_once("app/db.php");
        $db = new DatabaseInteractions;
        $db->dbInit();
        $controller = new DataController;
        $pages = $controller->pageCount();
        if(isset($_GET['page-nr']) && $_GET['page-nr'] > 0 && $_GET['page-nr'] <= $pages){
            $current = (int) $_GET['page-nr'];
            $page = $current - 1;
            $start = $page * $controller->getLimit();
        } else {
            $current = 1;
            $start = 0;
             $page = 0;
        }
        $all = $controller->carData($start);
        $brands = $controller->listBrands();
        $favorite_cars = $controller->fetchFavoriteCarController();
?>
<!DOCTYPE HTML>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/tab_logo.png">
    <!-- Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/fooldal.css">
    <link rel="stylesheet" href="css/listazas.css">
    <!-- JS -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ott a kocsid!</title>
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
<div class="mainimage-container">
    <img src="img/carstore.jpg" >

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
</div>
</div>
<!-- Kategória kiválasztás a kereséshez -->
<div><h1 class="center">Találd meg a számodra megfelelő autót!</h1><hr class="custom-hr"></div>
<div>
    <div class="centercontainer" id="filters">
        <form>
            <div class="input-container">
                <div style="display: none" class="dropdown">
                    <button onclick="ClickedOnButton1('dropdownMarka')" class="dropbtn" type="button">Márka</button>
                    <div id="dropdownMarka" class="dropdown-content">
                        <input type="text" placeholder="Keresés.." id="inputMarka" onkeyup="filterFunction('inputMarka','dropdownMarka')">
                       <?php foreach ($brands as $brand): ?>
                        <a href="<?= '?brand='.strtolower($brand['brand']) ?>"><?= $brand['brand'] ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div style="display: none" class="dropdown">
                    <button onclick="ClickedOnButton1('dropdownTipus')" class="dropbtn" type="button">Modell</button>
                    <div id="dropdownTipus" class="dropdown-content">
                        <input type="text" placeholder="Keresés..." id="inputTipus" onkeyup="filterFunction('inputTipus','dropdownTipus')">
                        <a href="#cclass">C osztály</a>
                        <a href="#cla">cla</a>
                        <a href="#sclass">S osztály</a>
                        <a href="#eqb">EQB</a>
                    </div>
                </div>
                <div style="display: none" class="dropdown">
                    <button onclick="ClickedOnButton1('dropdownAllapot')" class="dropbtn" type="button">Állapot</button>
                    <div id="dropdownAllapot" class="dropdown-content">
                        <input type="text" placeholder="Keresés..." id="inputAllapot" onkeyup="filterFunction('inputAllapot','dropdownAllapot')">
                        <a href="#uj">Új</a>
                        <a href="#ujszeru">Újszerű</a>
                        <a href="#viseletes">Viseletes</a>
                        <a href="#totalkar">Totálkár</a>
                    </div>
                </div>
                <div style="display: none" class="dropdown">
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

                <input style="display: none" type="text" placeholder="Kezdő ár">
                <input style="display: none" type="text" placeholder="Vég ár">
            </div>
            <div align="right">
                <button  style="display: none" class="search-button" type="submit">Szűrés</button></div>
        </form>
    </div>
</div>

<div class="centercontainer" >
    <hr>
    <ul class="list">
        <!-- listaelemeket php-val megjeleníteni dinamikusan a dobott találatok alapján -->
        <?php foreach ($all as $car): ?>
        <?php $files = $controller->fetchImages($car["VIN"]);?>
        <li class="list-item">
            <a href="car.php?VIN=<?=$car["VIN"] ?>"><img class="list-itemkep" src="img/cars/<?=$car["VIN"]?>/<?=$files[0]?>" alt="Kép 3"></a>
            <div class="list-item-content">
                <div class="cimpluszkedvenc"><a href="car.php?VIN=<?=$car["VIN"] ?>" ><h3><?= $car["brand"]." ".$car["modell"]?></h3></a>
                        <?php if(empty($_SESSION['username']) || empty($_SESSION['role']) || $_SESSION['role'] == "admin"): ?>
                    <div class="star"><img src="" alt=""></div></div>
                        <?php endif; ?>
                        <?php if($favorite_cars !== false && ($_SESSION['username']) && isset($_SESSION['role']) && $_SESSION['role'] == "user"): ?>
                            <?php
                                $isFavorite = false;
                                foreach ($favorite_cars as $favcar) {
                                    if($favcar['VIN'] == $car['VIN']) $isFavorite = true;
                                }
                            ?>
                            <?php if(!$isFavorite): ?>
                <div class="star"><a href="app/datacontroller.php?VIN=<?= $car['VIN']?>&favorite=add&target=index"><img src="img/star_empty.png" alt="Kedvencekhez adás"></a></div></div>
                            <?php else: ?>
            <div class="deletestar"><a href="app/datacontroller.php?VIN=<?= $car['VIN']?>&favorite=remove&target=index"><img src="img/star_full.png" alt="Kedvenc eltávolítása"></a></div></div>
                            <?php endif; ?>
                        <?php endif;?>
                <p><i class="tag1"><?=$car["build_year"]?></i>&nbsp&nbsp<i class="tag1"><?= $car["door_count"]." ajtós"?></i>&nbsp&nbsp<i class="tag1"><?= $car["color"]?></i></p>
                <p><i class="tag2"><?= $car["power"]." LE"?></i>&nbsp&nbsp<i class="tag2"><?=$car["fuel_type"]?></i></p>
                <p><i class="tag3"><?= $car["con"] ?></i></p>
                <p>Alvázszám: <?=$car['VIN'] ?></p>
                <hr>
                <p><b>Ár: <?php echo $car["price"]; ?> Ft</b></p>
            </div>

        </li>
        <hr class="separator2">
            <?php endforeach; ?>
            <div class="page-info">
                Showing <?php echo $current; ?> of <?php echo $pages ?>
            </div>

            <div class="pagination">
                <a href="?page-nr=1" style="margin-right: 5px">Első oldal</a>
                <div class="page-numbers">
                    <?php for($i = 1; $i<=$pages; $i++): ?>
                        <a href="?page-nr=<?php echo $i;?>"><?php echo $i; ?></a>
                    <?php endfor;?>
                </div>
                <a href="?page-nr=<?php echo $pages ?>" style="margin-left: 5px">Utolsó oldal</a>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['login-try'])) { ?>
        toastr.options.positionClass = "toast-top-left";
        toastr.success("Üdv újra, <?php echo $_SESSION['username']; ?>");
        <?php unset($_SESSION['login-try']);?>
        <?php } ?>
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['car-insert'])) { ?>
        toastr.options.positionClass = "toast-top-left";
        toastr.success("A hirdetést sikeresen rögzítettük.");
        <?php unset($_SESSION['car-insert']);?>
        <?php } ?>
    });
</script>
<?php if(isset($_SESSION['role']) && $_SESSION['role'] == "user"): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.deletestar a').forEach(starLink => {
            starLink.addEventListener('click', function(event) {
                event.preventDefault();
                const carHref = this.getAttribute('href');
                if (confirm(`Eltávolítja az autót a kedvencei közül?`)) {
                    window.location.href = carHref;
                }
            });
        });
    });
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.star a').forEach(starLink => {
                starLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    const carHref = this.getAttribute('href');
                    if (confirm(`Hozzáadja az autót a kedvencekhez?`)) {
                        window.location.href = carHref;
                    }
                });
            });
        });
    </script>
<?php endif; ?>

<footer>
    <p>&copy; 2024 Ott a kocsid! kft. Minden jog fenntartva.</p>
    <p class="contact">Kapcsolat: support@ottakocsid.hu | Telefon: +36 1 234 5678</p>
</footer>
</body>
</html>