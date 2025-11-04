<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer = $dao->createCustomer($_POST['imie'], $_POST['nazwisko'], $_POST['email']);
    
    if ($customer) {
        $success = true;
        header('Location: index.php?page=add_customer&success=1');
        exit;
    }
}

if (isset($_GET['success']) && $_GET['success'] == '1') {
    $success = true;
}
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h3>Dodawanie klienta:</h3>

<?php if ($success): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border: 1px solid #c3e6cb; border-radius: 4px;">
        ✓ Klient został pomyślnie dodany!
    </div>
<?php endif; ?>

<form action="index.php?page=add_customer" method="POST">
    <fieldset>
        <legend>Dane podstawowe</legend>
        <div>
            <label for="imie">Imię:</label>
            <input type="text" name="imie" id="imie"
                   value=""
                   placeholder="Podaj imię"
                   required>
        </div>
        <div>
            <label for="nazwisko">Nazwisko:</label>
            <input type="text" name="nazwisko" id="nazwisko"
                   value=""
                   placeholder="Podaj nazwisko"
                   required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email"
                   value=""
                   placeholder="Podaj email"
                   required>
        </div>
        <div>
            <input type="submit" value="Dalej">
        </div>
    </fieldset>
</form>
</body>
</html>