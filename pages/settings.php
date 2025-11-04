<?php
$success_message = null;
$error_message = null;

// Funkcja do maskowania klucza (pokazuje tylko 4 ostatnie znaki)
function mask_api_key($key) {
    if (strlen($key) > 8) {
        return substr($key, 0, 8) . '...' . substr($key, -4);
    }
    return $key;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['api_key'])) {
        $new_key = trim($_POST['api_key']);
        
        // Walidacja, czy klucz wygląda jak klucz Stripe
        if (strpos($new_key, 'sk_') === 0 || empty($new_key)) {
            $_SESSION['stripe_api_key'] = $new_key;
            $dao->resetStripeClient();
            $success_message = "Klucz API został zaktualizowany w tej sesji.";
            
            // Jeśli klucz jest pusty, usuwamy go z sesji, aby wrócić do domyślnego
            if (empty($new_key)) {
                 unset($_SESSION['stripe_api_key']);
                 $dao->resetStripeClient();
                 $success_message = "Klucz API został usunięty z sesji.";
            }

        } else {
            $error_message = "To nie wygląda na poprawny klucz API Stripe (powinien zaczynać się od 'sk_').";
        }
    }
}

$current_key = null;
$key_source_text = '';

if (isset($_SESSION['stripe_api_key']) && !empty($_SESSION['stripe_api_key'])) {
    $current_key = $_SESSION['stripe_api_key'];
    $key_source_text = "(z Twojej bieżącej sesji): <strong>" . htmlspecialchars(mask_api_key($current_key)) . "</strong>";

} else if ($dao->apiKeyExists()) {
    $current_key = null;
    $key_source_text = "Domyślny (z pliku konfiguracyjnego)";

} else {
    $current_key = null;
    $key_source_text = "Brak";
}

?>

<h3>Ustawienia Klucza API Stripe</h3>
<p>
    W tym miejscu możesz tymczasowo nadpisać klucz API Stripe używany przez aplikację.
    Klucz będzie przechowywany w Twojej sesji i zostanie usunięty po wylogowaniu lub zamknięciu przeglądarki.
</p><br>

<?php if ($success_message): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
<?php endif; ?>
<?php if ($error_message): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
<?php endif; ?>


<form action="index.php?page=settings" method="POST">
    <fieldset>
        <legend>Klucz API Stripe</legend>
        
        <?php if ($current_key): ?>
            <p style="margin-bottom: 15px;">
                Aktualnie używany klucz (z sesji): <strong><?php echo htmlspecialchars(mask_api_key($current_key)); ?></strong>
            </p>
            <?php else: ?>
            <p style="margin-bottom: 15px;">
                Aktualnie używany klucz: <strong><?php echo htmlspecialchars($key_source_text); ?></strong>
            </p>
        <?php endif; ?>

        <div>
            <label for="api_key">Nowy klucz API (np. sk_test_...):</label>
            <input type="text" name="api_key" id="api_key"
                   value="<?php echo htmlspecialchars($current_key ?? ''); ?>"
                   placeholder="Wprowadź klucz lub zostaw puste, aby użyć domyślnego">
            <small style="color: #666; margin-top: -10px; display: block;">
                Pozostaw to pole puste i kliknij 'Zapisz', aby powrócić do używania domyślnego klucza z pliku konfiguracyjnego.
            </small>
        </div>
        
    </fieldset>
    <button type="submit">Zapisz klucz w sesji</button>
</form>