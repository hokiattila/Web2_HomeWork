<!DOCTYPE HTML>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/public/ottakocsid/img/tab_logo.png">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?='/ottakocsid/'. $viewData['layout_style']?>">
    <link rel="stylesheet" href="/ottakocsid/public/css/admin.css">
    <link rel="stylesheet" href="/ottakocsid/public/css/home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin felület</title>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">
            <!-- Logo -->
        </div>
        <nav class="navbar">
            <?php echo Menu::getMenu($viewData['selectedItems']); ?>
        </nav>
    </div>
</header>

<div class="main-container">
    <h1 class="admin-title">Admin felület</h1>

    <h2 class="section-title">Regisztrált felhasználók</h2>

    <!-- Felhasználók táblázat -->
    <div class="table-container">
        <table class="user-table">
            <thead>
            <tr>
                <th>Felhasználónév</th>
                <th>Keresztnév</th>
                <th>Vezetéknév</th>
                <th>Születési dátum</th>
                <th>Nem</th>
                <th>Csatlakozás dátuma</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($viewData['users'] as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['first_name']) ?></td>
                    <td><?= htmlspecialchars($user['last_name']) ?></td>
                    <td><?= htmlspecialchars($user['birth_date']) ?></td>
                    <td><?= htmlspecialchars($user['gender']) ?></td>
                    <td><?= htmlspecialchars($user['join_date']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2 class="section-title">Beküldött Üzenetek</h2>

    <!-- Exportálás gombok -->
    <div class="export-buttons">
        <form method="post" action="/ottakocsid/admin/export/excel">
            <button type="submit" class="btn export-btn">Exportálás Excelbe</button>
        </form>
        <form method="post" action="/ottakocsid/admin/export/pdf">
            <button type="submit" class="btn export-btn">Exportálás PDF-be</button>
        </form>
    </div>

    <!-- Üzenetek táblázat -->
    <div class="table-container">
        <?php if (empty($viewData['messages'])): ?>
            <p>Nincs beérkezett üzenet.</p> <!-- Ha üres az üzenet tömb, ezt jelenítjük meg -->
        <?php else: ?>
            <table class="message-table">
                <thead>
                <tr>
                    <th>Név</th>
                    <th>Email</th>
                    <th>Üzenet</th>
                    <th>Dátum</th>
                    <th>Akció</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($viewData['messages'] as $message): ?>
                    <tr>
                        <td><?= htmlspecialchars($message['name']) ?></td>
                        <td><?= htmlspecialchars($message['email']) ?></td>
                        <td class="message-cell"><?= nl2br(htmlspecialchars($message['message'])) ?></td>
                        <td><?= htmlspecialchars($message['created_at']) ?></td>
                        <td>
                            <!-- Törlés gomb -->
                            <form method="post" action="/ottakocsid/admin/delete_message/<?= $message['id'] ?>" style="display:inline;">
                                <button type="submit" class="btn delete-btn">Törlés</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>


</div>

<footer>
    <div class="footer-container">
        <p>&copy; 2024 Ott a kocsid! kft. Minden jog fenntartva.</p>
        <p class="contact">Kapcsolat: support@ottakocsid.hu | Telefon: +36 1 234 5678</p>
    </div>
</footer>

</body>
</html>
