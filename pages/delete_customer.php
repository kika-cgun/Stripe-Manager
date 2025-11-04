<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$customer = null;
$error = null;
$customer_id_from_url = $_GET['id'] ?? null;

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
} else {
    $customer_id = $customer_id_from_url;
}

if(!empty($customer_id)) {
    try {
        $deleted = $dao->deleteCustomer($customer_id);
        if ($deleted->deleted) {
            $success = true;
            header('Location: index.php?page=delete_customer&success=1');
            exit;
        } else {
            $error = "Nie udało się usunąć klienta.";
        }
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $error = "Błąd API Stripe: " . $e->getMessage();
    } catch (Exception $e) {
        $error = "Wystąpił błąd podczas usuwania klienta: " . $e->getMessage();
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
<h3>Usuwanie klienta:</h3>

<?php if ($success): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border: 1px solid #c3e6cb; border-radius: 4px;">
        ✓ Klient został pomyślnie usunięty!
    </div>
<?php endif; ?>

<form action="index.php?page=delete_customer" method="POST">
    <fieldset>
        <legend>Usuń klienta</legend>
        <div>
            <label for="customer_id">ID klienta:</label>
            <input type="text" name="customer_id" id="customer_id"
                   value="<?php echo htmlspecialchars($customer_id_from_url ?? ''); ?>"
                   placeholder="Podaj ID klienta (np. cus_...)"
                   required>
        </div>
    </fieldset>
    <button type="submit" onclick="return confirm('Czy na pewno chcesz usunąć tego klienta?');">Usuń klienta</button>
</form>
</body>
</html>

<?php if ($error): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border: 1px solid #f5c6cb; border-radius: 4px;">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>
