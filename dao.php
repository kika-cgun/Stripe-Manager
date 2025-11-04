<?php
    require_once __DIR__ . '/vendor/autoload.php';

class dao{
    private $stripe = null;
    private $apiKey = null;

    // public function __construct() {
    //     $config = include __DIR__ . '/.config.php';
    //     $this->stripe = new \Stripe\StripeClient($config['api_key']);
    // }

    // public function __construct() {
    //     require_once __DIR__ . '/vendor/autoload.php';
        
    //     // 1. Wczytaj domyślną konfigurację z pliku .config.php
    //     $config = include __DIR__ . '/.config.php';
    //     $apiKey = $config['api_key'] ?? null; // Klucz domyślny

    //     // 2. Sprawdź, czy użytkownik ustawił własny klucz w sesji
    //     if (isset($_SESSION['stripe_api_key']) && !empty($_SESSION['stripe_api_key'])) {
    //         // Jeśli tak, nadpisz klucz domyślny tym z sesji
    //         $apiKey = $_SESSION['stripe_api_key'];
    //     }

    //     // 3. Sprawdź, czy w ogóle mamy jakikolwiek klucz
    //     if (empty($apiKey)) {
    //         // Rzuć błąd, który zostanie wyświetlony, jeśli żaden klucz nie jest dostępny
    //         throw new Exception("Brak klucza API Stripe. Ustaw go w pliku .config.php lub na stronie Ustawień.");
    //     }
        
    //     // 4. Utwórz klienta Stripe z wybranym kluczem (z sesji lub z pliku)
    //     $this->stripe = new \Stripe\StripeClient($apiKey);
    // }

    public function __construct() {
        $config = include __DIR__ . '/.config.php';
        $defaultApiKey = $config['api_key'] ?? null; // Klucz domyślny

        $this->apiKey = $_SESSION['stripe_api_key'] ?? $defaultApiKey;

        if (!empty($this->apiKey)) {
            $this->stripe = new \Stripe\StripeClient($this->apiKey);
        }
    }

    private function checkClient() {
        if (!$this->stripe) {
            throw new Exception("Brak klucza API Stripe. Ustaw go w pliku .config.php lub na stronie Ustawień.");
        }
    }

    public function createCustomer($imie, $nazwisko, $email) {
        $this->checkClient();
        return $this->stripe->customers->create([
            'name' => $imie . ' ' . $nazwisko,
            'email' => $email,
        ]);
    }

    public function deleteCustomer($customer_id) {
        $this->checkClient();
        return $this->stripe->customers->delete($customer_id, []);
    }

    public function updateCustomer($customer_id, $imie, $nazwisko, $email) {
        $this->checkClient();
        return $this->stripe->customers->update(
            $customer_id,
            [
                'name' => $imie . ' ' . $nazwisko,
                'email' => $email,
            ]
        );
    }

    public function retrieveCustomer($customer_id){
        $this->checkClient();
        return $this->stripe->customers->retrieve($customer_id, []);
    }

    public function listCustomers($limit = 100){
        $this->checkClient();
        return $this->stripe->customers->all(['limit' => $limit]);
    }

    public function apiKeyExists() {
        return !empty($this->stripe);
    }

    public function resetStripeClient() {
        $config = include __DIR__ . '/.config.php';
        $defaultApiKey = $config['api_key'] ?? null; 

        $this->apiKey = $_SESSION['stripe_api_key'] ?? $defaultApiKey;

        if (empty($this->apiKey)) {
            $this->stripe = null;
        } else {
            $this->stripe = new \Stripe\StripeClient($this->apiKey);
        }
    }

}