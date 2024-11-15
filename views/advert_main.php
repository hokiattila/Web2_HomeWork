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
    <title>Új hirdetés</title>
</head>
<body class="">
<header>
    <div class="container2"></div>
</header>
<?php echo Menu::getMenu($viewData['selectedItems']); ?>
<br><br>
    <!-- Autó hozzáadása -->
    <form class="form-container" action="/ottakocsid/advert" method="post" enctype="multipart/form-data">
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
            <label class="form-label" for="marka">Márka:</label><br>
            <input style="text-align-last: center" class="form-input" type="text" id="marka" name="brand" required><br><br>

            <label class="form-label" for="tipus">Típus:</label><br>
            <input style="text-align-last: center" class="form-input" type="text" id="tipus" name="modell" required><br><br>

            <label class="form-label" for="VIN">Alvázszám:</label><br>
            <input style="text-align-last: center" class="form-input" id="VIN" name="VIN" required/><br><br>

            <label class="form-label" for="wear">Állapot:</label><br>
            <select class="form-input" name="con" id="con"><br><br>
                <option style="text-align-last: center">Új</option>
                <option>Újszerű</option>
                <option>Viseltes</option>
                <option>Totálkár</option>
            </select>
            <label class="form-label" for="fuel_type">Meghajtás:</label><br>
            <select style="text-align-last: center" name="fuel_type" id="fuel_type"><br><br>
                <option>Benzin</option>
                <option>Diesel</option>
                <option>Elektromos</option>
                <option>Gázüzem</option>
                <option>Hidrogén</option>
            </select><br><br>
            <label class="form-label" for="weight">Tömeg (tonna):</label><br><br>
            <input style="text-align-last: center" class="form-input" type="number" id="weight" name="weight" max="4" min="1"/><br><br>
            <label class="form-label" for="power">Lóerő:</label><br><br>
            <input style="text-align-last: center" class="form-input" type="number" id="power" name="power" max="5000" min="1"/><br><br>
            <label class="form-label" for="door_count">Ajtók száma:</label><br><br>
            <input style="text-align-last: center" class="form-input" type="number" id="door_count" name="door_count" max="5" min="0"/><br><br>
            <label class="form-label" for="build_year">Gyártási év:</label><br>
            <input style="text-align-last: center" class="form-input" type="date" id="build_year" name="build_year"/><br><br>
            <label class="form-label" for="color">Szín:</label><br>
            <input style="text-align-last: center" class="form-input" id="color" name="color" pattern="^[^\d]*$" required/><br><br>
            <label class="form-label" for="price">Ár (Ft)</label><br>
            <input style="text-align-last: center" type="text" pattern="^[0-9]*$" id="price" name="price" required><br><br>
            <input name="add-btn" type="submit" value="Feltöltés">
    </form>
</div>
<br><br><br>
<?php if(isset($viewData['error'])): ?>
    <div id="error-message" style="display:none;" data-message="<?= htmlspecialchars($viewData['error']); ?>"></div>
<?php endif; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessageDiv = document.getElementById('error-message');
        var message = errorMessageDiv.getAttribute('data-message');
        if (message) {
            toastr.options.positionClass ="toast-top-left";
            toastr.error(message);
        }
    });
</script>
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