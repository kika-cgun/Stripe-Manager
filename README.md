# Panel Zarządzania Klientami Stripe

Prosta aplikacja PHP (oparta na wzorcu Front Controller) służąca do wykonywania podstawowych operacji CRUD (Create, Read, Update, Delete) na klientach (Customers) za pomocą Stripe API.

**Link do repozytorium:** [https://github.com/kika-cgun/Stripe-Manager.git](https://github.com/kika-cgun/Stripe-Manager.git)

## Podgląd Strony Głównej

![Podgląd strony głównej](./screenshots/Stripe-Management-Home.jpeg)

---

## O Projekcie

Aplikacja ta została stworzona jako panel administracyjny do zarządzania bazą klientów w serwisie Stripe. Pozwala na centralne zarządzanie danymi klientów bez konieczności logowania się do panelu Stripe.

Logika biznesowa (operacje na API) została oddzielona od warstwy prezentacji (HTML/CSS) za pomocą obiektu `dao.php` (Data Access Object) oraz wzorca Front Controller (`index.php`), który zarządza ładowaniem odpowiednich podstron.

### Główne Funkcje

* **Kokpit:** Strona główna wyświetlająca proste statystyki (łączna liczba klientów) oraz listę ostatnio dodanych osób.
* **Pełny CRUD:**
    * **Create:** Dodawanie nowych klientów za pomocą formularza.
    * **Read:** Wyszukiwanie i wyświetlanie szczegółowych danych klienta (w tym pełnej odpowiedzi JSON z API).
    * **Update:** Edycja danych istniejących klientów.
    * **Delete:** Trwałe usuwanie klientów.
* **Lista Klientów:** Przejrzysta, tabelaryczna lista wszystkich klientów na koncie.
* **Zarządzanie Kluczem API:** Dedykowana strona "Ustawienia" pozwalająca na dynamiczne, tymczasowe nadpisanie klucza API (klucz jest przechowywany w `$_SESSION`).
* **Obsługa błędów:** Aplikacja przekierowuje na stronę ustawień, jeśli nie wykryje żadnego klucza API (ani w sesji, ani w pliku konfiguracyjnym).

---

## Instalacja i Uruchomienie

Aplikacja wymaga serwera PHP (np. XAMPP, MAMP) oraz menedżera zależności Composer.

### 1. Wymagania

* PHP 7.4 lub nowszy
* Composer

### 2. Kroki instalacji

1.  Sklonuj repozytorium na swój lokalny serwer:
    ```bash
    git clone [https://github.com/kika-cgun/Stripe-Manager.git](https://github.com/kika-cgun/Stripe-Manager.git)
    cd Stripe-Manager
    ```

2.  Zainstaluj zależności (w tym oficjalną bibliotekę Stripe):
    ```bash
    composer install
    ```

3.  **Konfiguracja Klucza API (Najważniejszy krok)**

    > ### ⚠️ BARDZO WAŻNE: ZMIEŃ KLUCZ API
    >
    > Plik konfiguracyjny `.config.php` **znajduje się w tym repozytorium**, ale jest przeznaczony tylko jako szablon.
    >
    > **MUSISZ** otworzyć ten plik i zastąpić istniejącą wartość `api_key` swoim własnym, tajnym kluczem API Stripe.
    >
    > **NIGDY nie przesyłaj (commit) swojego prawdziwego, działającego klucza API z powrotem na GitHub!** Jest to poważne zagrożenie bezpieczeństwa. Zaleca się dodanie pliku `.config.php` do `.gitignore` po wprowadzeniu zmian.

    Otwórz plik `.config.php` i wstaw swój klucz:

    ```php
    <?php
    // plik: .config.php
    return [
        'api_key' => 'WPISZ_TUTAJ_SWOJ_KLUCZ_API_STRIPE (np. sk_test_...)'
    ];
    ```

4.  Uruchom aplikację, otwierając plik `index.php` w przeglądarce (np. `http://localhost/Stripe-Manager/`).