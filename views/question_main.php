<!DOCTYPE HTML>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/public/ottakocsid/img/tab_logo.png">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?='/ottakocsid/'. $viewData['layout_style']?>">
    <link rel="stylesheet" href="/ottakocsid/public/css/question.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vedd fel velünk a kapcsolatot!</title>
</head>
<body>
<?php echo Menu::getMenu($viewData['selectedItems']); ?>

<div class="main-container">
    <h1 class="page-title">Kérdőív kitöltése</h1>

    <!-- Sikeres üzenet -->
    <?php if (!empty($viewData['successMessage'])): ?>
        <div class="alert success">
            <?= htmlspecialchars($viewData['successMessage']) ?>
        </div>
    <?php endif; ?>

    <!-- Hibaüzenetek -->
    <?php if (!empty($viewData['errors'])): ?>
        <div class="alert error">
            <?php foreach ($viewData['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Űrlap -->
    <form action="/ottakocsid/question" method="POST" class="question-form">
        <div class="form-group">
            <label for="name">Név:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($viewData['name'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($viewData['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="phone">Telefonszám (opcionális):</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($viewData['phone'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="message">Üzenet (min. 10 karakter):</label>
            <textarea id="message" name="message" rows="5" required><?= htmlspecialchars($viewData['message'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn submit-btn">Küldés</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.question-form');
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const messageInput = document.getElementById('message');

            form.addEventListener('submit', function(event) {
                let isValid = true;
                let errorMessage = '';

                // Név validáció
                if (nameInput.value.trim() === '') {
                    errorMessage += 'A név megadása kötelező.\n';
                    isValid = false;
                }

                // Email validáció
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(emailInput.value.trim())) {
                    errorMessage += 'Érvényes email cím megadása kötelező.\n';
                    isValid = false;
                }

                // Telefonszám validáció (magyar formátum ellenőrzés)
                const phonePattern = /^(\+36|06)[0-9]{9}$/;
                if (phoneInput.value.trim() && !phonePattern.test(phoneInput.value.trim())) {
                    errorMessage += 'Érvényes telefonszámot adjon meg (pl. +36 30 123 4567).\n';
                    isValid = false;
                }

                // Üzenet validáció (min 10 karakter)
                if (messageInput.value.trim().length < 10) {
                    errorMessage += 'Az üzenetnek legalább 10 karakter hosszúnak kell lennie.\n';
                    isValid = false;
                }

                // Ha van hiba, megakadályozzuk a form elküldését és kiírjuk a hibákat
                if (!isValid) {
                    event.preventDefault();
                    alert(errorMessage);
                }
            });
        });
    </script>

</div>

<footer>
    <div class="footer-container">
        <p>&copy; 2024 Ott a kocsid! kft. Minden jog fenntartva.</p>
        <p class="contact">Kapcsolat: support@ottakocsid.hu | Telefon: +36 1 234 5678</p>
    </div>
</footer>

</body>
</html>
