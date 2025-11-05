<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" type="image/x-icon" href="style/favicon.ico">
    <title><?php echo $pageTitle ?? 'Stripe Customer Management'; ?></title>
</head>
<body>
<nav>
    <ul>
        <li><a href="index.php?page=home">Strona główna</a></li>
        <li><a href="index.php?page=add_customer">Utwórz klienta</a></li>
        <li><a href="index.php?page=retrieve_customer">Pobierz klienta</a></li>
        <li><a href="index.php?page=update_customer">Aktualizuj klienta</a></li>
        <li><a href="index.php?page=delete_customer">Usuń klienta</a></li>
        <li><a href="index.php?page=list_customers">Lista klientów</a></li>

        <li style="border-left: 2px solid #0a2540;"><a href="index.php?page=settings">Ustawienia</a></li>
    </ul>
</nav>
<div class="container">