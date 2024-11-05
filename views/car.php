<?php
    include_once("app/datacontroller.php");
    $controller = new DataController;
    if(empty($_GET["VIN"])) header("Location: index.php");
    $exist = $controller->validVIN($_GET["VIN"]);
    if(!$exist) header("Location: error.php");
    $car = $controller->indCarData($_GET["VIN"]);
    $carImg = $controller->fetchImages($_GET["VIN"]);
?>
<!DOCTYPE HTML>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/tab_logo.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gallery.css">
    <link rel="stylesheet" href="css/fooldal.css">
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$car[0]["brand"]." ".$car[0]["modell"]?></title>
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
    <div class="container2">
        <div class="grid second-nav">
            <div class="column-xs-12">
                <nav>
                    <ol class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="#">Gepjarmu</a></li>
                        <li class="breadcrumb-item"><a href="#"><?=$car[0]["brand"]?></a></li>
                        <li class="breadcrumb-item active"><?= $car[0]["modell"] ?></li>
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
                        <img class="active" src="<?="/img/cars/".$_GET["VIN"]."/".$carImg[0]?>">
                    </div>
                    <!-- Itt vannak listázva a galléria képek az autóról -->
                    <ul class="image-list">
                        <?php for($i=0; $i<sizeof($carImg); $i++): ?>
                        <li class="image-item"><img src="<?="/img/cars/".$_GET["VIN"]."/".$carImg[$i]?>"></li>
                        <?php endfor;?>
                    </ul>
                    <table>
                        <tr>
                            <th>Paraméter</th>
                            <th>Érték</th>
                        </tr>
                        <tr>
                            <td>Gyártási év</td>
                            <td><?= $car[0]["build_year"]?></td>
                        </tr>
                        <tr>
                            <td>Kivitel</td>
                            <td><?=$car[0]["door_count"] ?></td>
                        </tr>
                        <tr>
                            <td>Szín</td>
                            <td><?=$car[0]["color"]?></td>
                        </tr>
                        <tr>
                            <td>Teljesítmény</td>
                            <td><?=$car[0]["power"]?> Le</td>
                        </tr>
                        <tr>
                            <td>Üzemanyag</td>
                            <td><?=$car[0]["fuel_type"]?></td>
                        </tr>
                        <tr>
                            <td>Állapot</td>
                            <td><?=$car[0]["con"] ?></td>
                        </tr>
                    </table>
                </div>
            </div></div>
            </div>
                <div class="egyikoldal">
            <div class="column-xs-12 column-md-5">
                <h1><?=$car[0]["brand"]." ".$car[0]["modell"]?></h1>

                <h2><b><?=$car[0]["price"] ?> FT</b></h2>
                <div class="description">
                    <p>The purposes of bonsai are primarily contemplation for the viewer, and the pleasant exercise of effort and ingenuity for the grower.</p>
                    <p>By contrast with other plant cultivation practices, bonsai is not intended for production of food or for medicine. Instead, bonsai practice focuses on long-term cultivation and shaping of one or more small trees growing in a container.</p>
                </div>

            </div>

                    <h2 class="description">Eladó elérhetősége</h2>
                    <p>Telefonszám: <b>+36301234567</b></p>
                    <p>Email cím: <b>joskapista@gmail.com</b></p>
                    <br><br>
                    <?php if(isset($_SESSION["username"])): ?>
                        <?php if($_SESSION['role'] == "user"): ?>
                        <?php $favorites = $controller->favoriteFetchController();
                            $alreadyfavored = false;
                            foreach ($favorites as $fav) {
                                if($fav["car_VIN"] == $_GET["VIN"]) $alreadyfavored = true;
                            }
                        ?>
                    <form method="post" action="app/datacontroller.php">
                        <input type="hidden" name="vin" value="<?=$car[0]["VIN"]?>"/>
                        <?php if($alreadyfavored): ?>
                            <button name="delete-favorite-btn" class="add-to-cart">Eltávolítás a kedvencek közül</button>
                            <?php else: ?>
                    <button name="favorite-btn" class="add-to-favorites">Kedvencekhez adás</button>
                            <?php endif; ?>
                    </form>
                        <?php endif; ?>
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