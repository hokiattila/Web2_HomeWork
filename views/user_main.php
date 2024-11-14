<?php
    include_once("app/datacontroller.php");
    $controller = new DataController;
    if(empty($_SESSION['username']) || empty($_SESSION['role'])) header("Location: error.php?msg=nologon");
    $favorite_cars = $controller->fetchFavoriteCarController();
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
?>
<!DOCTYPE HTML>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/tab_logo.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/fooldal.css">
    <link rel="stylesheet" href="css/listazas.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/toastr.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION['username'];?></title>
</head>
<body class="">
<header>
    <div class="container2"></div>
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
        <a href="home.php"><img src="img/logo.png" alt="Logó"></a>
    </div>
    <!-- Menüpontok -->
    <div class="menu">
        <a href="home.php">Főoldal</a>
        <a href="contact.php">Kapcsolat</a>
        <?php if(empty($_SESSION['username']) || empty($_SESSION['role'])): ?>
            <a href="login.php" <?php if(basename(__FILE__) == "postlogin.php"): ?> class="<?php echo "activenav"; ?>"<?php endif;?>>Bejelentkezés</a>
        <?php else: ?>
            <a href="user.php" <?php if(basename(__FILE__) == "user.php"): ?> class="<?php echo "activenav"; ?>"<?php endif;?>><?php echo $_SESSION['username'];?></a>
            <a href="app/datacontroller.php?logout=true">Kijelentkezés</a>
        <?php endif; ?>
    </div>
</div>
<br><br>
<!-- kedvencek lista, időpontfoglalás, autó feltöltés -->
<?php if($_SESSION["role"] == "user"): ?>
<div><h2 class="center">Kedvenc autók</h2>
    <?php else: ?>
    <div><h2 class="center">Admin felület</h2>
<?php endif; ?>
        <hr class="custom-hr">
    <?php if($_SESSION['role'] == "user"): ?>
    <!-- favorites div megjelenítése ha a kedvencek menüpont az aktív -->
    <?php if(empty($favorite_cars)): ?>
	<br><br><br><br><br>
	<div class="form-container">
    <hr class="separator">
	<br><br><br><br><br><br>
    <h3 class="center">Még egyetlen autót sem vettél fel a kedvencek közé! Itt az ideje :) Kattints <a href="home.php">ide</a> kínálatunk megtekintéséhez</h3>
	    <hr class="separator">
	<br><br><br><br><br><br>
	</div>
	<br><br><br><br><br><br><br>
    <div class="favorites">
        <ul class="list">
            <?php else: ?>
            <?php foreach ($favorite_cars as $car): ?>
                <?php $files = $controller->fetchImages($car["VIN"]);?>
                <li class="list-item">
                <a href="car.php?VIN=<?=$car["VIN"] ?>"><img class="list-itemkep" src="img/cars/<?=$car["VIN"]?>/<?=$files[0]?>" alt="Kép 3"></a>
                <div class="list-item-content">
                    <div class="cimpluszkedvenc"><a href="car.php?VIN=<?=$car["VIN"] ?>" ><h3><?= $car["brand"]." ".$car["modell"]?></h3></a><div class="star"><a href="app/datacontroller.php?VIN=<?= $car['VIN']?>&favorite=remove&target=user"><img src="img/star_full.png" alt="Eltávolítás a kedvencekből"></a></div></div>
                    <p><i class="tag1"><?= $car["build_year"]?></i>&nbsp&nbsp<i class="tag1"><?= $car["door_count"] ?> ajtós</i>&nbsp&nbsp<i class="tag1"><?=$car["color"] ?></i></p>
                    <p><i class="tag2"><?= $car["power"]?> LE</i>&nbsp&nbsp<i class="tag2"><?= $car["fuel_type"]?></i></p>
                    <p><i class="tag3">Újszerű</i></p>
                    <p>Alvázszám: <?=$car["VIN"] ?></p>
                    <hr>
                    <p><b>Ár: <?=$car["price"] ?> Ft</b></p>
                </div>

            </li>
            <hr class="separator2">
            <?php endforeach;?>
            <?php endif;?>
                <hr>
        </ul>
    </div>
</div>
<?php endif; ?>
<!-- Autó hozzáadása -->
<?php if($_SESSION['role'] == "admin"): ?>
<form class="form-container" action="app/datacontroller.php" method="post" enctype="multipart/form-data">
    <div class="form-left">
        <div class="centeredupload">
            <label class="form-label" for="image" >Kép(ek) kiválasztása:</label>
            <input class="file-input" type="file" id="image" name="image[]" accept="image/*" multiple></div>
        <div class="dropdown">
            <button style="display: none" onclick="ClickedOnButton1('dropdownUzemanyag')" class="dropbtn" type="button">Üzemanyag</button>
            <div id="dropdownUzemanyag" class="dropdown-content">
                <input type="text" placeholder="Keresés..." id="inputUzemanyag" onkeyup="filterFunction('inputUzemanyag','dropdownUzemanyag')">
                <a href="#benzin">Benzin</a>
                <a href="#dizel">Dízel</a>
                <a href="#gaz">Gáz</a>
                <a href="#hidrogen">Hidrogén</a>
                <a href="#elektromos">Elektromos</a>
            </div>
        </div>
        <div class="dropdown">
            <button style="display: none" onclick="ClickedOnButton1('dropdownAllapot')" class="dropbtn" type="button">Állapot</button>
            <div id="dropdownAllapot" class="dropdown-content">
                <input type="text" placeholder="Keresés..." id="inputAllapot" onkeyup="filterFunction('inputAllapot','dropdownAllapot')">
                <a href="#uj">Új</a>
                <a href="#ujszeru">Újszerű</a>
                <a href="#viseletes">Viseletes</a>
                <a href="#totalkar">Totálkár</a>
            </div>
        </div>
    </div>
    <div class="form-right">
        <label class="form-label" for="marka">Márka:</label>
        <input style="text-align-last: center" class="form-input" type="text" id="marka" name="brand" required>

        <label class="form-label" for="tipus">Típus</label>
        <input style="text-align-last: center" class="form-input" type="text" id="tipus" name="modell" required>

        <label class="form-label" for="VIN">Alvázszám</label>
        <input style="text-align-last: center" class="form-input" id="VIN" name="VIN" required/>

        <label class="form-label" for="wear">Állapot:</label>
        <select class="form-input" name="con" id="con">
            <option style="text-align-last: center">Új</option>
            <option>Újszerű</option>
            <option>Viseltes</option>
            <option>Totálkár</option>
        </select>
            <label class="form-label" for="fuel_type">Meghajtás:</label>
            <select style="text-align-last: center" name="fuel_type" id="fuel_type">
                <option>Benzin</option>
                <option>Diesel</option>
                <option>Elektromos</option>
                <option>Gázüzem</option>
                <option>Hidrogén</option>
            </select>
            <label class="form-label" for="weight">Tömeg (tonna):</label>
            <input style="text-align-last: center" class="form-input" type="number" id="weight" name="weight" max="4" min="1"/>
            <label class="form-label" for="power">Lóerő:</label>
            <input style="text-align-last: center" class="form-input" type="number" id="power" name="power" max="5000" min="1"/>
              <label class="form-label" for="door_count">Ajtók száma:</label>
                <input style="text-align-last: center" class="form-input" type="number" id="door_count" name="door_count" max="5" min="0"/>
            <label class="form-label" for="build_year">Gyártási év:</label>
            <input style="text-align-last: center" class="form-input" type="date" id="build_year" name="build_year"/>
        <label class="form-label" for="color">Szín:</label>
        <input style="text-align-last: center" class="form-input" id="color" name="color" pattern="^[^\d]*$" required/>
        <label class="form-label" for="price">Ár (Ft)</label>
            <input style="text-align-last: center" type="text" pattern="^[0-9]*$" id="price" name="price" required><br>
            <input name="add-btn" type="submit" value="Feltöltés">
        </form>
    </div>
<br><br><br>

<!-- sajat feltoltesek. Szerkeszteni nem lehet csak levenni es ujra feltenni. -->
<div class="favorites">
    <ul class="list">
        <!-- listaelemeket php-val megjeleníteni dinamikusan a dobott találatok alapján -->
        <?php foreach ($all as $car): ?>
            <?php $files = $controller->fetchImages($car["VIN"]);?>
            <li class="list-item">
            <a href="car.php?VIN=<?=$car["VIN"] ?>"><img class="list-itemkep" src="img/cars/<?=$car["VIN"]?>/<?=$files[0]?>" alt="Kép 3"></a>
            <div class="list-item-content">
                <div class="cimpluszkedvenc"><a href="car.php?VIN=<?=$car["VIN"] ?>" ><h3><?= $car["brand"]." ".$car["modell"]?></h3></a><div class="star"><a href="app/datacontroller.php?VIN=<?= $car['VIN']?>&delete=true" ><img src="img/x_button.png" alt="Eltávolítás"/></a></div></div>
                <p><i class="tag1"><?=$car["build_year"]?></i>&nbsp&nbsp<i class="tag1"><?= $car["door_count"]." ajtós"?></i>&nbsp&nbsp<i class="tag1"><?= $car["color"]?></i></p>
                <p><i class="tag2"><?= $car["power"]." LE"?></i>&nbsp&nbsp<i class="tag2"><?=$car["fuel_type"]?></i></p>
                <p><i class="tag3"><?= $car["con"] ?></i></p>
                <p>Alvázszám: <?=$car['VIN'] ?></p>
                <hr>
                <p><b>Ár: <?php echo $car["price"]; ?> Ft</b></p>
            </div>

        </li>
        <?php endforeach; ?>
        <hr class="separator2">
        <!-- Majd itt jöhet a matek, a lényeg a design -->
        <div class="pagination">
            <a href="?page-nr=1" style="margin-right: 5px">Első oldal</a>
            <div class="page-numbers">
                <?php for($i = 1; $i<=$pages; $i++): ?>
                    <a href="?page-nr=<?php echo $i;?>"><?php echo $i; ?></a>
                <?php endfor;?>
            </div>
            <a href="?page-nr=<?php echo $pages ?>" style="margin-left: 5px">Utolsó oldal</a>
        </div>
        <br>
    </ul>
</div>
</div>
<?php endif; ?>


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
<script>
    window.addEventListener('load', function() {
        var betoltoDiv = document.getElementById('betolto');
        var tartalomDiv = document.getElementById('tartalom');
        betoltoDiv.style.display = 'none'; // A betöltő div elrejtése
        tartalomDiv.style.display = 'block'; // A tartalom megjelenítése
    });
</script>
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

<?php if($_SESSION['role'] == "user"): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Feltevéssel, hogy a `.star` osztályú div közvetlenül tartalmazza az `<a>` elemet
        document.querySelectorAll('.star a').forEach(starLink => {
            starLink.addEventListener('click', function(event) {
                event.preventDefault(); // Megakadályozza az alapértelmezett link kattintási műveletet
                const carHref = this.getAttribute('href'); // Az `<a>` elem href attribútumának lekérése
                if (confirm(`Eltávolítja az autót a kedvencei közül?`)) {
                    window.location.href = carHref; // Ha a felhasználó igent mond, akkor továbbítja az eredeti linkre
                }
            });
        });
    });

</script>
<?php endif; ?>
<?php if($_SESSION['role'] == "admin"): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.star a').forEach(starLink => {
            starLink.addEventListener('click', function(event) {
                event.preventDefault();
                const carHref = this.getAttribute('href');
                if (confirm(`Eltávolítja az autót?`)) {
                    window.location.href = carHref;
                }
            });
        });
    });
    <?php endif; ?>
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['delete-car'])) { ?>
        toastr.options.positionClass = "toast-top-left";
        toastr.success("Az autót sikeresen töröltük.");
        <?php unset($_SESSION['delete-car']);?>
        <?php } ?>
    });
</script>
<footer>
    <p>&copy; 2024 Ott a kocsid! kft. Minden jog fenntartva.</p>
    <p class="contact">Kapcsolat: support@ottakocsid.hu | Telefon: +36 1 234 5678</p>
</footer>
</body>
</html>