
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gallery.css">
    <link rel="stylesheet" href="css/fooldal.css">
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>

    </style>
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
        <a href="index.html"><img src="img/logo.png" alt="Logó"></a>
    </div>
    <!-- Menüpontok -->
    <div class="menu">
        <a href="index.html">Főoldal</a>
        <a href="contact.html">Kapcsolat</a>
        <!-- mindenkepp dinamikus btn legyen -->
        <a href="login.html">Bejelentkezés</a>
    </div>
</div>


<div class="container2">
    <div class="grid second-nav">
        <div class="column-xs-12">
            <nav>
                <ol class="breadcrumb-list">
                    <li class="breadcrumb-item"><a href="#">Gepjarmu</a></li>
                    <li class="breadcrumb-item"><a href="#">Mercedes-Benz</a></li>
                    <li class="breadcrumb-item active">CLA</li>
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
                            <img class="active" src="img/cars/cla/cla1.jpg">
                        </div>
                        <!-- Itt vannak listázva a galléria képek az autóról -->
                        <ul class="image-list">
                            <li class="image-item"><img src="img/cars/cla/cla1.jpg"></li>
                            <li class="image-item"><img src="img/cars/cla/cla2.webp"></li>
                            <li class="image-item"><img src="img/cars/cla/cla3.jpeg"></li>
                            <li class="image-item"><img src="img/cars/cla/cla4.webp"></li>
                        </ul>
                        <table>
                            <tr>
                                <th>Paraméter</th>
                                <th>Érték</th>
                            </tr>
                            <tr>
                                <td>Gyártási év</td>
                                <td>2016</td>
                            </tr>
                            <tr>
                                <td>Kivitel</td>
                                <td>4 ajtós</td>
                            </tr>
                            <tr>
                                <td>Szín</td>
                                <td>Fekete</td>
                            </tr>
                            <tr>
                                <td>Teljesítmény</td>
                                <td>180 Le</td>
                            </tr>
                            <tr>
                                <td>Üzemanyag</td>
                                <td>Benzin</td>
                            </tr>
                            <tr>
                                <td>Állapot</td>
                                <td>Újszerű</td>
                            </tr>
                        </table>
                    </div>
                </div></div>
        </div>
        <div class="egyikoldal">
            <div class="column-xs-12 column-md-5">
                <h1>Mercedes-Benz CLA-200</h1>

                <h2><b>13,000,000 FT</b></h2>
                <div class="description">
                    <p>The purposes of bonsai are primarily contemplation for the viewer, and the pleasant exercise of effort and ingenuity for the grower.</p>
                    <p>By contrast with other plant cultivation practices, bonsai is not intended for production of food or for medicine. Instead, bonsai practice focuses on long-term cultivation and shaping of one or more small trees growing in a container.</p>
                </div>

            </div>

            <h2 class="description">Eladó elérhetősége</h2>
            <p>Telefonszám: <b>+36301234567</b></p>
            <p>Email cím: <b>joskapista@gmail.com</b></p>
            <br><br>
            <button class="add-to-favorites">Kedvencekhez adás</button><button class="add-to-cart">Vásárlás</button>
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