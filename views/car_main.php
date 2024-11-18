<?php
use models\Car_Model;
$model = new Car_Model();
?>
<!DOCTYPE HTML>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/public/ottakocsid/img/tab_logo.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?='/ottakocsid/'. $viewData['layout_style']?>">
    <link rel="stylesheet" href="/ottakocsid/public/css/gallery.css">
    <link rel="stylesheet" href="/ottakocsid/public/css/home.css">
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$viewData["car"][0]["brand"]." ".$viewData["car"][0]["modell"]?></title>
</head>
<body class="">

<header>
    <div class="container2"></div>
</header>
<!-- Loading gif eltüntetése ha betölt az oldal -->
<!-- A betöltő div -->
<div id="betolto">
    <img src="ottakocsid/public/img/loading.gif" alt="Betöltő animáció">
</div>
<!-- Navigációs menü -->
<!-- Navigációs menü -->

<?php echo Menu::getMenu($viewData['selectedItems']); ?>
<div class="container2">

    <div class="grid second-nav">
        <div class="column-xs-12">
            <nav>
                <ol class="breadcrumb-list">
                    <li class="breadcrumb-item"><a href="#">Gepjarmu</a></li>
                    <li class="breadcrumb-item"><a href="#"><?=$viewData["car"][0]["brand"]?></a></li>
                    <li class="breadcrumb-item active"><?= $viewData["car"][0]["modell"] ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="ketoldal">
        <div class="egyikoldal">
            <div class="grid product">
                <div class="column-xs-12 column-md-7">
                    <div class="product-gallery">
                        <div class="product-image">
                            <!-- aktív kép -->
                            <img class="active" src="<?="/ottakocsid/public/img/cars/".$viewData["VIN"]."/".$viewData["carIMG"][0]?>">
                        </div>
                        <!-- Itt vannak listázva a galléria képek az autóról -->
                        <ul class="image-list">
                            <?php for($i=0; $i<sizeof($viewData["carIMG"]); $i++): ?>
                                <li class="image-item"><img src="<?="/ottakocsid/public/img/cars/".$viewData["VIN"]."/".$viewData["carIMG"][$i]?>"></li>
                            <?php endfor;?>
                        </ul>
                        <table>
                            <tr>
                                <th>Paraméter</th>
                                <th>Érték</th>
                            </tr>
                            <tr>
                                <td>Gyártási év</td>
                                <td><?= $viewData["car"][0]["build_year"]?></td>
                            </tr>
                            <tr>
                                <td>Kivitel</td>
                                <td><?=$viewData["car"][0]["door_count"] ?></td>
                            </tr>
                            <tr>
                                <td>Szín</td>
                                <td><?=$viewData["car"][0]["color"]?></td>
                            </tr>
                            <tr>
                                <td>Teljesítmény</td>
                                <td><?=$viewData["car"][0]["power"]?> Le</td>
                            </tr>
                            <tr>
                                <td>Üzemanyag</td>
                                <td><?=$viewData["car"][0]["fuel_type"]?></td>
                            </tr>
                            <tr>
                                <td>Állapot</td>
                                <td><?=$viewData["car"][0]["con"] ?></td>
                            </tr>
                        </table>
                    </div>
                </div></div>
        </div>
        <div class="egyikoldal">
            <div class="column-xs-12 column-md-5">
                <h1><?=$viewData['car'][0]['brand']." ".$viewData['car'][0]['modell']?></h1>

                <h2><b><?=$viewData["car"][0]["price"] ?> FT</b></h2>
                <div class="description">
                    <p>The purposes of bonsai are primarily contemplation for the viewer, and the pleasant exercise of effort and ingenuity for the grower.</p>
                    <p>By contrast with other plant cultivation practices, bonsai is not intended for production of food or for medicine. Instead, bonsai practice focuses on long-term cultivation and shaping of one or more small trees growing in a container.</p>
                </div>

            </div>

            <h2 class="description">Eladó elérhetősége</h2>
            <p>Telefonszám: <b>+36301234567</b></p>
            <p>Email cím: <b>joskapista@gmail.com</b></p>
            <br><br>
            <?php if(isset($_SESSION["username"]) && $_SESSION["username"] != "unknown"): ?>
                <?php if($_SESSION['userlevel'] == "_1_"): ?>
                    <?php $favorites = $viewData['favoritecars'];
                    $alreadyfavored = false;
                    foreach ($favorites as $fav) {
                        if($fav["car_VIN"] == $viewData["VIN"]) $alreadyfavored = true;
                    }
                    ?>
                    <form method="post" action="/ottakocsid/car/fav/<?=$viewData["car"][0]["VIN"]?>">
                        <input type="hidden" name="vin" value="<?=$viewData["car"][0]["VIN"]?>"/>
                        <?php if($alreadyfavored): ?>
                            <button name="delete-favorite-btn" class="add-to-cart">Eltávolítás a kedvencek közül</button>
                        <?php else: ?>
                            <button name="favorite-btn" class="add-to-favorites">Kedvencekhez adás</button>
                        <?php endif; ?>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(isset($_SESSION["username"]) && $_SESSION["userlevel"] == "__1"): ?>
                <form method="post" action="/ottakocsid/car/delete/<?=$viewData["car"][0]["VIN"]?>">
                    <input type="hidden" name="vin" value="<?=$viewData["car"][0]["VIN"]?>"/>
                    <button style="background-color: #811331" name="delete-btn" class="add-to-cart">Hirdetés törlése</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<br><br><br>

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