<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$customers = $dao->listCustomers();
?>

<h3>Lista klientów</h3>

<?php if (empty($customers->data)): ?>
    <div class="alert alert-warning">
        Brak klientów w bazie danych.
    </div>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Imię i nazwisko</th>
                <th>Email</th>
                <th>Data utworzenia</th>
                <th class="table-actions">Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers->data as $customer): ?>
                <tr>
                    <td class="table-id"><?php echo htmlspecialchars($customer->id); ?></td>
                    <td><?php echo htmlspecialchars($customer->name ?? 'Brak danych'); ?></td>
                    <td><?php echo htmlspecialchars($customer->email ?? 'Brak danych'); ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $customer->created); ?></td>
                    <td class="table-actions">
                        <a href="index.php?page=retrieve_customer&id=<?php echo urlencode($customer->id); ?>" 
                           class="link-primary">Podgląd</a>
                        <a href="index.php?page=update_customer&id=<?php echo urlencode($customer->id); ?>" 
                           class="link-secondary">Edytuj</a>
                        <a href="index.php?page=delete_customer&id=<?php echo urlencode($customer->id); ?>" 
                           class="link-danger"
                           onclick="return confirm('Czy na pewno chcesz usunąć tego klienta?');">Usuń</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <p class="stats">
        Łącznie klientów: <strong><?php echo count($customers->data); ?></strong>
    </p>
<?php endif; ?>