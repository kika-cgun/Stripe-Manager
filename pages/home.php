<?php

$totalCustomers = 0;
$recentCustomers = [];
$error = null;

try {
    $allCustomers = $dao->listCustomers(100);
    $totalCustomers = count($allCustomers->data);

    $recentCustomersList = $dao->listCustomers(3);
    $recentCustomers = $recentCustomersList->data;

} catch (Exception $e) {
    $error = "Nie udało się załadować statystyk: " . $e->getMessage();
}

?>

<h2>Stripe Customer Management</h2>
<p>Witaj w panelu zarządzania klientami Stripe. Wybierz opcję z menu lub skorzystaj z szybkich akcji poniżej.</p>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<hr class="home-divider">

<h3>Szybkie Akcje</h3>
<div class="home-actions-container">
    
    <a href="index.php?page=add_customer" class="home-action-btn primary">
       + Dodaj nowego klienta
    </a>
    
    <a href="index.php?page=list_customers" class="home-action-btn secondary">
       Zobacz wszystkich klientów
    </a>

</div>

<div class="home-content-container">

    <div class="home-stats-col">
        <h3>Statystyki</h3>
        <div class="home-card">
            <div class="home-stats-title">Łączna liczba klientów</div>
            <div class="home-stats-number">
                <?php echo $totalCustomers; ?>
            </div>
        </div>
    </div>

    <div class="home-recent-col">
        <h3>Ostatnio dodani klienci</h3>
        <?php if (empty($recentCustomers) && !$error): ?>
            <div class="alert alert-warning">Brak klientów.</div>
        <?php else: ?>
            <ul class="home-card home-recent-list">
                <?php foreach ($recentCustomers as $customer): ?>
                    <li class="home-recent-item">
                        <div>
                            <strong><?php echo htmlspecialchars($customer->name ?? 'Brak nazwy'); ?></strong><br>
                            <small class="home-recent-email"><?php echo htmlspecialchars($customer->email ?? 'Brak emaila'); ?></small>
                        </div>
                        <div>
                            <a href="index.php?page=retrieve_customer&id=<?php echo urlencode($customer->id); ?>" class="link-primary">Podgląd</a>
                            <a href="index.php?page=update_customer&id=<?php echo urlencode($customer->id); ?>" class="link-secondary">Edytuj</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

</div>