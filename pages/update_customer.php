<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$customer = null;
$error = null;
$success = false;

$customer_id = $_GET['id'] ?? $_POST['customer_id'] ?? null;

// 2. Obsługa formularza (metoda POST) - AKTUALIZACJA DANYCH
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($customer_id)) {
    $imie = $_POST['imie'] ?? '';
    $nazwisko = $_POST['nazwisko'] ?? '';
    $email = $_POST['email'] ?? '';

    try {
        // Używamy $dao do aktualizacji
        $dao->updateCustomer($customer_id, $imie, $nazwisko, $email);
        
        // Przekieruj z powrotem na tę samą stronę z informacją o sukcesie
        header('Location: index.php?page=update_customer&id=' . urlencode($customer_id) . '&success=1');
        exit;
        
    } catch (Exception $e) {
        $error = "Wystąpił błąd podczas aktualizacji: " . $e->getMessage();
    }
}

// 3. Sprawdź, czy jest komunikat o sukcesie (z przekierowania)
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $success = true;
}

// 4. Pobieranie danych do formularza (metoda GET lub po błędzie POST)
if (!empty($customer_id)) {
    try {
        // Używamy $dao do pobrania aktualnych danych klienta
        $customer = $dao->retrieveCustomer($customer_id);
    } catch (Exception $e) {
        $error = "Nie można wczytać danych klienta: " . $e->getMessage();
        $customer = null; // Upewnij się, że formularz się nie wyświetli, jeśli był błąd
    }
}

// 5. Pomocnik do rozdzielenia imienia i nazwiska w formularzu
$form_imie = '';
$form_nazwisko = '';
if ($customer && $customer->name) {
    $parts = explode(' ', $customer->name, 2);
    $form_imie = $parts[0] ?? '';
    $form_nazwisko = $parts[1] ?? '';
}
?>

<h3>Aktualizacja klienta</h3>

<?php if ($success): ?>
    <div class="alert alert-success">
        ✓ Klient został pomyślnie zaktualizowany!
    </div>
<?php endif; ?>




<?php if ($customer): ?>
    <form action="index.php?page=update_customer" method="POST">
    
        <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer->id); ?>">
        
        <fieldset>
            <legend>Edytuj dane klienta (ID: <?php echo htmlspecialchars($customer->id); ?>)</legend>
            <div>
                <label for="imie">Imię:</label>
                <input type="text" name="imie" id="imie"
                       value="<?php echo htmlspecialchars($form_imie); ?>" required>
            </div>
            <div>
                <label for="nazwisko">Nazwisko:</label>
                <input type="text" name="nazwisko" id="nazwisko"
                       value="<?php echo htmlspecialchars($form_nazwisko); ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email"
                       value="<?php echo htmlspecialchars($customer->email ?? ''); ?>" required>
            </div>
            <div>
                <button type="submit">Aktualizuj dane</button>
            </div>
        </fieldset>
    </form>

<?php else: ?>
    <form action="index.php" method="GET">
        <input type="hidden" name="page" value="update_customer">
        <fieldset>
            <legend>Wyszukaj klienta do edycji</legend>
             <div>
                <label for="customer_id_search">ID klienta:</label>
                <input type="text" name="id" id="customer_id_search" 
                       placeholder="Podaj ID klienta (np. cus_...)">
             </div>
             <button type="submit">Wczytaj klienta</button>
        </fieldset>
    </form>
    
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <strong>Błąd:</strong> <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>