<?php
use models\Car_Model;
$model = new Car_Model();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Ott a kocsid! - Főoldal</title>
    <link rel="icon" type="image/png" href="/ottakocsid/public/img/tab_logo.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?='/ottakocsid/'. $viewData['layout_style']?>">
    <link rel="stylesheet" href="<?='/ottakocsid/'. $viewData['style']?>">
    <link rel="stylesheet" href="<?='/ottakocsid/'.$viewData['toastr_style']?>">
    <link rel="stylesheet" href="/ottakocsid/public/css/listing.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<!-- Loading gif eltüntetése ha betölt az oldal -->
<!-- A betöltő div -->
<div id="betolto">
    <img src="/ottakocsid/public/img/loading.gif" alt="Betöltő animáció">
</div>
<!-- Navigációs menü -->
<?php echo Menu::getMenu($viewData['selectedItems']); ?>
<div class="mainimage-container">
    <img src="/ottakocsid/public/img/carstore.jpg" >

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
    <div class="centercontainer" >
        <hr>
        <ul class="list">
            <?php foreach ($viewData['cars'] as $car): ?>
            <?php $files = $model->fetchImages($car["VIN"])?>
            <li class="list-item">
                <a href="/ottakocsid/car/<?=$car["VIN"] ?>"><img class="list-itemkep" src="/ottakocsid/public/img/cars/<?=$car["VIN"]?>/<?=$files[0]?>" alt="Kép 3"></a>
                <div class="list-item-content">
                    <div class="cimpluszkedvenc"><a href="/ottakocsid/car/<?=$car["VIN"] ?>" ><h3><?= $car["brand"]." ".$car["modell"]?></h3></a>
                        <?php if($_SESSION['username'] == "unknown"  || $_SESSION['userlevel'] == "__1"): ?>
                        <div class="star"><img src="" alt=""></div></div>
                    <?php endif; ?>
                    <?php if($viewData['favorite_cars'] !== false && ($_SESSION['username'] != "unknown") && isset($_SESSION['userlevel']) && $_SESSION['userlevel'] == "_1_"): ?>
                    <?php
                    $isFavorite = false;
                    foreach ($viewData['favorite_cars'] as $favcar) {
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
    Showing <?php echo $viewData['current']; ?> of <?php echo $viewData['page'] ?>
</div>

<div class="pagination">
    <a href="/ottakocsid/home" style="margin-right: 5px">Első oldal</a>
    <div class="page-numbers">
        <?php for($i = 1; $i<=$viewData['page']; $i++): ?>
            <a href="/ottakocsid/home/<?php echo $i;?>"><?php echo $i; ?></a>
        <?php endfor;?>
    </div>
    <a href="/ottakocsid/home/<?php echo $viewData['page'] ?>" style="margin-left: 5px">Utolsó oldal</a>
</div>
<!-- Ha lesz elég content ez majd törlendő! -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php if(isset($_SESSION['login-try']) && isset($_SESSION['userfirstname'])): ?>
<div id="login-try" style="display:none;" data-message="Üdvözlünk újra itt <?=$_SESSION['userfirstname']?>"></div>
<?php endif; ?>


<?php if(isset($_SESSION['logged-out'])): ?>
<div id="logged-out" style="display:none;" data-message="Sikeresen kijelentkeztél, várunk vissza!"></div>
<?php endif; ?>

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
<?php if(isset($_SESSION['login-try'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessageDiv = document.getElementById('login-try');
        var message = errorMessageDiv.getAttribute('data-message');
        if (message) {
            toastr.options.positionClass ="toast-top-left";
            toastr.success(message);
        }
        <?php unset($_SESSION['login-try']) ?>
    });
</script>
<?php endif; ?>
<?php if(isset($_SESSION['logged-out'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorMessageDiv = document.getElementById('logged-out');
            var message = errorMessageDiv.getAttribute('data-message');
            if (message) {
                toastr.options.positionClass ="toast-top-left";
                toastr.error(message);
            }
            <?php unset($_SESSION['logged-out']) ?>
        });
    </script>
<?php endif; ?>
<footer>
    <p>&copy; 2024 Ott a kocsid! kft. Minden jog fenntartva.</p>
    <p class="contact">Kapcsolat: support@ottakocsid.hu | Telefon: +36 1 234 5678</p>
</footer>
</body>
</html>