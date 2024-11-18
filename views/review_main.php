<?php
// Feltételezve, hogy a review_controller.php már betöltötte a szükséges adatokat
?>

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/public/ottakocsid/img/tab_logo.png">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?='/ottakocsid/'. $viewData['layout_style']?>">
    <link rel="stylesheet" href="/ottakocsid/public/css/review.css">
    <link rel="stylesheet" href="/ottakocsid/public/css/home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin felület</title>
    <style>

    </style>
</head>

<body>

<!-- Loading gif eltüntetése ha betölt az oldal -->
<!-- A betöltő div -->
<?php echo Menu::getMenu($viewData['selectedItems']); ?>

<h2 align="center">Új értékelés hozzáadása</h2>
<?php if($_SESSION['username'] != "unknown"){ ?>
<form action="/ottakocsid/review/submitReview" method="post">
    <label for="stars">Értékelés (csillagok):</label>
    <div class="star-rating" id="star-rating-new">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>
    </div><br><br>

    <!-- Hidden input a kiválasztott csillagok számához -->
    <input type="hidden" name="stars" id="stars" value="0"> <!-- Default érték 0 (üres csillagok) -->

    <label for="title">Cím:</label>
    <input type="text" id="title" name="title" required><br><br>

    <label for="message">Üzenet:</label>
    <textarea id="message" name="message" required></textarea><br><br>

    <input type="submit" value="Értékelés beküldése">
</form>
<?php }
else { ?>
    <hr class="separator">
    <br>
    <div class="center">
    <p>Kérlek jelentkezz be az értékelés írásához!<br><br>
        <a href="/ottakocsid/login"><button class="search-button">Jelentkezz be itt!</button></a></p>
    </div>
    <hr class="separator">
<?php } ?>


<h2 align="center">Értékelések</h2>

<?php if (!empty($viewData['reviews'])): ?>
    <div class="reviews-container"> <!-- Az értékelések konténerének osztálya -->
        <?php foreach ($viewData['reviews'] as $review): ?>
            <div class="review">
                <strong><?php echo htmlspecialchars($review['name']); ?> (<?php echo $review['stars']; ?> csillag)</strong><br>
                <?php echo nl2br(htmlspecialchars($review['created_at'])); ?><br>
                <!-- Csillagok megjelenítése a review alapján -->
                <div class="star-rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="<?php echo $i <= $review['stars'] ? 'star' : 'starempty'; ?>">&#9733;</span>
                    <?php endfor; ?>
                </div>

                <strong> <?php echo htmlspecialchars($review['title']); ?></strong><br>
                 <?php echo nl2br(htmlspecialchars($review['message'])); ?><br>


                <br>
                <?php if (!empty($viewData['responses'])): ?>
                    <?php foreach ($viewData['responses'] as $response): ?>
                        <?php if ($response['review_id'] == $review['id']){ ?>
                            <div class="response">
                                <strong><?php echo htmlspecialchars($response['name']); ?> válasza:</strong><br>
                                <?php echo nl2br(htmlspecialchars($response['message'])); ?><br><br>
                            </div>
                        <?php } ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-response">Nincs válasz.</p>
                <?php endif; ?>

                <?php if($_SESSION['username'] != "unknown"){ ?>
                <form action="/ottakocsid/review/submitResponse" method="post">
                    <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">

                    <label for="response_message_<?php echo $review['id']; ?>">Válasz üzenet:</label>
                    <textarea id="response_message_<?php echo $review['id']; ?>" name="message" required></textarea><br><br>

                    <input type="submit" value="Válasz küldése">
                </form>
                <?php } ?>
            </div>
        <?php endforeach; ?>
    </div> <!-- A reviews-container lezárása -->
<?php else: ?>
    <p>Még nincs vélemény.</p>
<?php endif; ?>




<footer>
    <div class="footer-container">
        <p>&copy; 2024 Ott a kocsid! kft. Minden jog fenntartva.</p>
        <p class="contact">Kapcsolat: support@ottakocsid.hu | Telefon: +36 1 234 5678</p>
    </div>
</footer>

<script>
    // Frissítjük a csillagokat a kiválasztott érték szerint
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            document.getElementById('stars').value = value; // Frissítjük a hidden input értékét
            updateStars(value); // Frissítjük a csillagok megjelenését
        });
    });

    // Hover csak az új értékelés formnál (csillagok frissítése)
    if (document.getElementById('star-rating-new')) {
        document.querySelectorAll('#star-rating-new .star').forEach(star => {
            star.addEventListener('mouseover', function() {
                const value = this.getAttribute('data-value');
                updateStars(value); // Hover állapotban frissítjük a csillagok vizuális megjelenését
            });

            star.addEventListener('mouseout', function() {
                const value = document.getElementById('stars').value; // Alapértelmezett érték a kiválasztott csillagok szerint
                updateStars(value); // Frissítjük a csillagokat a kiválasztott érték szerint
            });
        });
    }

    // Csillagok frissítése a vizuális állapot szerint
    function updateStars(value) {
        document.querySelectorAll('#star-rating-new .star').forEach(star => {
            if (star.getAttribute('data-value') <= value) {
                star.classList.add('filled');
            } else {
                star.classList.remove('filled');
            }
        });
    }
</script>
</body>
</html>
