<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$customer = null;
$error = null;
$customer_id_from_url = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
}
else{
    $customer_id = $customer_id_from_url;
}

if(!empty($customer_id)) {
    try {
        $customer = $dao->retrieveCustomer($customer_id);
        if ($customer) {
        } else {
            $error = "Nie znaleziono klienta o podanym ID.";
        }
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $error = "Błąd API Stripe: " . $e->getMessage();
    } catch (Exception $e) {
        $error = "Wystąpił błąd podczas wczytywania klienta: " . $e->getMessage();
    }
}
?>

<h3>Wczytywanie klienta:</h3>

<form action="index.php?page=retrieve_customer" method="POST">
    <fieldset>
        <legend>Wyszukaj klienta</legend>
        <div>
            <label for="customer_id">ID klienta:</label>
            <input type="text" name="customer_id" id="customer_id"
                   value="<?php echo htmlspecialchars($customer_id ?? ''); ?>"
                   placeholder="Podaj ID klienta (np. cus_...)"
                   required>
        </div>
    </fieldset>
    <button type="submit">Wyszukaj klienta</button>
</form>

<?php if($customer): ?>
    <h4>Dane pobranego klienta:</h4>

    <div style="background-color: #f4f4f4; padding: 15px; border-radius: 5px; border: 1px solid #ddd; line-height: 1.6;">
        <strong>ID:</strong> <?php echo htmlspecialchars($customer->id); ?><br>
        <strong>Imię i nazwisko:</strong> <?php echo htmlspecialchars($customer->name ?? 'Brak danych'); ?><br>
        <strong>Email:</strong> <?php echo htmlspecialchars($customer->email ?? 'Brak danych'); ?><br>
        <strong>Data utworzenia:</strong> <?php echo date('Y-m-d H:i:s', $customer->created); ?><br>
    </div>

    <h4 style="margin-top: 20px;">Wszystkie dane (JSON)</h4>
    <pre style="background-color: #333; color: #fff; padding: 10px; border-radius: 4px; overflow-x: auto;"><?php
        // Używamy JSON_PRETTY_PRINT dla ładnego formatowania
        echo json_encode($customer, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    ?></pre>

<?php elseif($error): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border: 1px solid #f5c6cb; border-radius: 4px;">
        <strong>Błąd:</strong> <?php echo $error; ?>
    </div>
<?php elseif (!empty($customer_id)): ?>
     <p>Nie znaleziono klienta o podanym ID.</p>
<?php endif; ?>