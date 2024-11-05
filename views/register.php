<!DOCTYPE HTML>
<?php include_once("app/db.php");
      include_once ("app/datacontroller.php");
      if(isset($_SESSION['username'])) header("Location: index.php");
      $controller = new DataController;
      $token = $controller->generateToken();
      $errorMessage = false;

        if(isset($_GET['error'])) {
            $errorMessage = $controller->getErrorMessage($_GET['error']);
            if ($errorMessage === false) {
                $errorMessage = "Váratlan hiba";
            }
}

      ?>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <!-- Stylesheet -->
    <link rel="icon" type="image/png" href="img/tab_logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/jquery.passwordRequirements.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/toastr.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/jquery.passwordRequirements.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/validator.js"></script>
    <!-- Beállítások telefonos megjelenésekhez -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Regisztráció</title>
</head>
<body class="">

<header>
    <div class="container"></div>
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
        <a href="index.php">Főoldal</a>
        <a href="contact.php">Kapcsolat</a>
        <?php if(empty($_SESSION['username']) || empty($_SESSION['role'])): ?>
            <a href="login.php" <?php if(basename(__FILE__) == "login.php"): ?> class="<?php echo "activenav"; ?>"<?php endif;?>>Bejelentkezés</a>
        <?php else: ?>
            <a href="user.php"><?php echo $_SESSION['username'];?></a>
            <a href="app/datacontroller.php?logout=true">Kijelentkezés</a>
        <?php endif; ?>
    </div>
</div>
<br><br>
<div class="form-container">
    <h2>Regisztráció</h2>
    <form action="app/datacontroller.php" method="post">
        <input type="hidden" name="token" value="<?= $token ?>">
        <input type="text" name="username" placeholder="Felhasználónév" required><br>
        <input type="password" name="password" class="pr-password" placeholder="Jelszó" required><br>
        <input type="password" name="password_conf" placeholder="Jelszó megerősítése" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="firstname" placeholder="Keresztnév" required><br>
        <input type="text" name="lastname" placeholder="Vezetéknév" required><br>
        <input type="date" name="szuldatum" id="szuldatum" placeholder="Születési dátum" required><br>
        <select name="nem">
            <option>Férfi</option>
            <option>Nő</option>
        </select>
        <br>
        <input type="text" name="telefonszam" placeholder="Telefonszám" pattern="^[0-9]*$">
        <br>
        <input name="register-btn" type="submit" value="Regisztráció">
    </form>
    <br><br>
    <hr class="separator">
    <br>
    <p>Már rendelkezel fiókkal?<br><br>
        <a href="login.php"><button class="search-button">Jelentkezz be itt!</button></a></p>
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
<div id="error-message" style="display:none;" data-message="<?= htmlspecialchars($errorMessage); ?>"></div>
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
<footer>
    <p>&copy; 2024 Ott a kocsid! kft. Minden jog fenntartva.</p>
    <p class="contact">Kapcsolat: support@ottakocsid.hu | Telefon: +36 1 234 5678</p>
</footer>

</body>
</html>
