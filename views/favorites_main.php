<?php
use models\Car_Model;
$model = new Car_Model();
?>
<!DOCTYPE HTML>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/ottakocsid/public/img/tab_logo.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?='/ottakocsid/'.$viewData['layout_style']?>">
    <link rel="stylesheet" href="<?='/ottakocsid/'.$viewData['toastr_style']?>">
    <link rel="stylesheet" href="/ottakocsid/public/css/login.css">
    <link rel="stylesheet" href="/ottakocsid/public/css/home.css">
    <link rel="stylesheet" href="/ottakocsid/public/css/listing.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="/ottakocsid/public/js/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Kedvencek </title>
</head>
<body class="">
<header>
    <div class="container2"></div>
</header>
<!-- Loading gif eltüntetése ha betölt az oldal -->
<!-- A betöltő div -->
<div id="betolto">
    <img src="/ottakocsid/public/img/loading.gif" alt="Betöltő animáció">
</div>
<?php echo Menu::getMenu($viewData['selectedItems']) ?>
<br><br>
<!-- kedvencek lista, időpontfoglalás, autó feltöltés -->
<div><h2 class="center">Kedvenc autók</h2>
        <hr class="custom-hr">
        <?php if(empty($viewData['favoritecars'])): ?>
        <br><br><br><br><br>
        <div class="form-container">
            <hr class="separator">
            <br><br><br><br><br><br>
            <h3 class="center">Még egyetlen autót sem vettél fel a kedvencek közé! Itt az ideje :) Kattints <a href="/ottakocsid/home">ide</a> kínálatunk megtekintéséhez</h3>
            <hr class="separator">
            <br><br><br><br><br><br>
        </div>
        <br><br><br><br><br><br><br>
    <?php else: ?>
    <div class="favorites">
            <ul class="list">
                    <?php foreach ($viewData['favoritecars'] as $car): ?>
                        <?php $files = $model->fetchImages($car["VIN"]);?>
                        <li class="list-item">
                            <a href="/ottakocsid/car/<?=$car["VIN"] ?>"><img class="list-itemkep" src="/ottakocsid/public/img/cars/<?=$car["VIN"]?>/<?=$files[0]?>" alt="Kép 3"></a>
                            <div class="list-item-content">
                                <div class="cimpluszkedvenc"><a href="/ottakocsid/car/<?=$car["VIN"] ?>" ><h3><?= $car["brand"]." ".$car["modell"]?></h3></a><div class="star"><a href="/ottakocsid/car/fav/<?= $car['VIN']?>/fromfav"><img src="/ottakocsid/public/img/star_full.png" alt="Eltávolítás a kedvencekből"></a></div></div>
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
                <hr>
            </ul>
        </div>
    </div>
    <!-- Autó hozzáadása -->

<br><br><br>
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