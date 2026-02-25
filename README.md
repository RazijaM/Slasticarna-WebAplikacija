# 🍰 Slastičarna – Web aplikacija

_Web aplikacija za naručivanje proizvoda slastičarne i upravljanje narudžbama_

---

## Sadržaj

- [Pregled funkcionalnosti](#pregled-funkcionalnosti)
- [Prikaz aplikacije](#prikaz-aplikacije)
- [Tehnologije i arhitektura](#tehnologije-i-arhitektura)
- [Baza podataka](#baza-podataka)
- [REST API integracija](#rest-api-integracija)
- [Instalacija i pokretanje](#instalacija-i-pokretanje-lokalno)
- [Testiranje](#testiranje)
- [Struktura projekta](#struktura-projekta)
- [Sigurnost](#sigurnost)
- [Moguća poboljšanja](#moguća-poboljšanja)
- [Autor](#autor)

---

## 📌 Uvod

Ovaj projekat predstavlja razvoj web aplikacije pod nazivom **Slastičarna "Slatki raj"**, čiji je cilj omogućiti kupcima pregled proizvoda, naručivanje putem korpe i praćenje narudžbi, a administratorima upravljanje proizvodima, narudžbama, lokacijom i statistikom. Aplikacija je izrađena u **Laravel** okruženju s **Breeze** autentifikacijom i **Blade** predlošcima.

---

## Pregled funkcionalnosti

Funkcionalnosti su podijeljene prema ulogama: **registrovani korisnik (kupac)** i **administrator**.

### Registrovani korisnik (kupac)

- **Registracija i prijava** — Registracija putem e-maila i lozinke, verifikacija e-maila (Laravel Breeze), prijava i odjava.
- **Pregled proizvoda** — Lista proizvoda s filterom po kategoriji i pretragom; cijene u KM; vremenska prognoza na lokaciji slastičarne (Open-Meteo); dodavanje u korpu.
- **Korpa** — Pregled stavki, ažuriranje količine, uklanjanje, ukupan iznos u KM; nastavak na checkout.
- **Checkout** — Rezime narudžbe, telefon, adresa dostave, napomena; potvrda narudžbe.
- **Moje narudžbe** — Lista narudžbi s datumom, statusom i iznosom; detalji narudžbe i historija statusa.
- **Lokacija slastičarne** — Karta (Leaflet); podaci iz `/api/location`.
- **Upravljanje profilom** — Ažuriranje imena, prezimena, e-maila; profilna fotografija; promjena lozinke; brisanje računa (Breeze).

### Administrator

- **Upravljanje proizvodima** — CRUD: dodavanje, uređivanje, brisanje (naziv, opis, cijena KM, stanje, slika, kategorija, aktivnost).
- **Upravljanje narudžbama** — Pregled svih narudžbi; promjena statusa (prihvaćena, u pripremi, u dostavi, dostavljena) s napomenom; historija.
- **Statistika** — Ukupni prihod u KM; graf narudžbi po statusu; top 5 proizvoda (Chart.js).
- **Upravljanje lokacijom** — Uređivanje naziva, adrese, lat/lng, telefona, radijusa dostave; koriste stranica Lokacija i `/api/location`, `/api/weather`.
- **Dashboard** — Hero s pozdravom; navigacija na admin stranice.

---

## 🧩 Opis aplikacije

Aplikacija **Slastičarna** je web platforma namijenjena kupcima i administratorima slastičarne. Sistem je osmišljen tako da omogući:

**Kupcima:**

- 🔍 pregled kataloga proizvoda (s pretragom i filterom po kategoriji)
- 🛒 dodavanje proizvoda u korpu i ažuriranje količine
- 📄 dovršetak narudžbe putem checkouta (adresa, telefon, napomena)
- 📋 pregled vlastitih narudžbi i statusa
- 📍 pregled lokacije slastičarne na karti (Leaflet)
- 🌡️ prikaz trenutne temperature na lokaciji slastičarne (Open-Meteo API)

**Administratorima:**

- 📦 upravljanje proizvodima (dodavanje, uređivanje, brisanje, kategorije, cijene u KM)
- 📋 pregled i ažuriranje statusa narudžbi
- 📊 statistika (ukupni prihod, narudžbe po statusu, top proizvodi)
- 📍 uređivanje lokacije slastičarne (naziv, adresa, lat/lng, telefon, radijus dostave)

Cijene su prikazane u **KM** (konvertibilna marka). Lokacija i vremenska prognoza na stranici Proizvodi uvijek se učitavaju iz baze (tablica `restaurant_locations`), tako da promjena lokacije u admin panelu odmah utječe na prikaz.

---

## 🖥️ Prikaz aplikacije

U nastavku je prikazan vizuelni izgled aplikacije kroz osnovne stranice i funkcionalnosti.

---

### 🔐 Prijava na sistem

Stranica za prijavu omogućava registriranim korisnicima pristup aplikaciji unosom e-mail adrese i lozinke.

<p align="center">
  <img src="screenshots/login.png" alt="Prijava na sistem">
</p>

---

### 📝 Registracija korisnika

Stranica za registraciju omogućava kreiranje novog korisničkog računa.

<p align="center">
  <img src="screenshots/register.png" alt="Registracija korisnika">
</p>

---

### 🏠 Dashboard – kupac

Početna stranica nakon prijave prikazuje hero sekciju s pozdravom korisnika (slika kafića, puna visina prozora ispod navigacije).

<p align="center">
  <img src="screenshots/dashKupac.png" alt="Dashboard kupac" width="70%">
</p>

---

### 🏠 Dashboard – admin

Administratorski dashboard s istom hero sekcijom i pozdravom.

<p align="center">
  <img src="screenshots/dashAdmin.png" alt="Dashboard admin" width="70%">
</p>

---

### 📦 Proizvodi – kupac

Stranica s katalogom proizvoda: filter po kategoriji, pretraga, vremenska prognoza na lokaciji slastičarne, cijene u KM i dugme za dodavanje u korpu.

<p align="center">
  <img src="screenshots/proizvodiKupac.png" alt="Proizvodi (kupac)" width="70%">
</p>

---

### 🛒 Korpa

Pregled stavki u korpi, ažuriranje količine, uklanjanje stavki i ukupan iznos u KM.

<p align="center">
  <img src="screenshots/korpaKupac.png" alt="Korpa" width="70%">
</p>

---

### 📄 Rezime narudžbe (checkout)

Stranica za potvrdu narudžbe: rezime stavki, ukupno u KM, unos telefona, adrese dostave i opcionalne napomene.

<p align="center">
  <img src="screenshots/rezimeNarudzbeKupac.png" alt="Rezime narudžbe" width="70%">
</p>

---

### 📋 Moje narudžbe – kupac

Lista narudžbi kupca s datumom, statusom i ukupnim iznosom u KM.

<p align="center">
  <img src="screenshots/MojeNarudzbeKupac.png" alt="Moje narudžbe" width="70%">
</p>

---

### ✅ Potvrđena narudžba – kupac

Detalji pojedinačne narudžbe: status, datum, adresa, stavke i historija promjena statusa.

<p align="center">
  <img src="screenshots/potvrdjenaNarudzbaKupac.png" alt="Potvrđena narudžba" width="70%">
</p>

---

### 📍 Lokacija slastičarne – kupac

Stranica s kartom (Leaflet) koja prikazuje lokaciju slastičarne; podaci se učitavaju iz baze putem API-ja `/api/location`.

<p align="center">
  <img src="screenshots/LokacijaSlasticarneKupac.png" alt="Lokacija slastičarne" width="70%">
</p>

---

### 👤 Profil – kupac

Pregled i uređivanje profila kupca (ime, e-mail, profilna slika).

<p align="center">
  <img src="screenshots/profilKupac.png" alt="Profil kupac" width="70%">
</p>

---

### 📦 Admin – proizvodi

Administratorska lista proizvoda s slikom, nazivom, kategorijom, cijenom (KM), stanjem i akcijama (uredi / obriši).

<p align="center">
  <img src="screenshots/proizvodiAdmin.png" alt="Admin proizvodi" width="70%">
</p>

---

### ➕ Admin – dodavanje proizvoda

Forma za kreiranje novog proizvoda (kategorija, naziv, opis, cijena u KM, stanje, slika, aktivnost).

<p align="center">
  <img src="screenshots/dodajProizvodAdmin.png" alt="Dodavanje proizvoda" width="70%">
</p>

---

### 📋 Admin – narudžbe

Pregled svih narudžbi s korisnikom, datumom, statusom i ukupnim iznosom u KM.

<p align="center">
  <img src="screenshots/narudzbeAdmin.png" alt="Admin narudžbe" width="70%">
</p>

---

### ✏️ Admin – ažurirana narudžba

Detalji narudžbe i forma za promjenu statusa narudžbe (npr. prihvaćena, u pripremi, u dostavi, dostavljena).

<p align="center">
  <img src="screenshots/azuriranaNarudzbaAdmin.png" alt="Ažurirana narudžba" width="70%">
</p>

---

### 📊 Admin – statistika

Ukupni prihod u KM, graf narudžbi po statusu i top 5 proizvoda po prodanoj količini.

<p align="center">
  <img src="screenshots/statistikaAdmin.png" alt="Admin statistika" width="70%">
</p>

---

### 📍 Admin – lokacija

Forma za uređivanje lokacije slastičarne: naziv, adresa, lat/lng, telefon, radijus dostave (km). Ove podatke koriste stranica Lokacija i API-ji `/api/location` te `/api/weather`.

<p align="center">
  <img src="screenshots/lokacijaAdmin.png" alt="Admin lokacija" width="70%">
</p>

---

### 👤 Admin – profil

Profil administratora (uređivanje podataka i profilne slike).

<p align="center">
  <img src="screenshots/profilAdmin.png" alt="Profil admin" width="70%">
</p>

---

## 🛠️ Tehnologije i arhitektura

- **Backend:** PHP 8.2+, Laravel 12
- **Baza podataka:** MySQL / PostgreSQL / SQLite (Laravel Eloquent ORM)
- **Autentifikacija:** Laravel Breeze (Blade), verifikacija e-maila
- **Frontend:** Blade predlošci, Tailwind CSS, Vite, Alpine.js
- **Eksterni API:** Open-Meteo (trenutna temperatura po lat/lng)
- **Karta:** Leaflet (stranica Lokacija)
- **Grafovi:** Chart.js (admin statistika)

### MVC u kontekstu projekta

- **Modeli** (`app/Models`): User, Product, Category, Order, OrderItem, CartItem, RestaurantLocation, OrderStatusLog. Odnosi npr. Order → User, OrderItem → Order i Product.
- **Kontroleri** (`app/Http/Controllers`): primaju zahtjev, koriste modele, validaciju, vraćaju redirect ili view (CartController, CheckoutController, Admin ProductController, OrderController, LocationController, itd.).
- **Pogledi** (`resources/views`): Blade predlošci (dashboard, products, cart, checkout, orders, location, admin, profile); Breeze komponente (x-app-layout, x-nav-link).

### ORM i valuta

Cijene se prikazuju putem globalne funkcije `format_km($amount)` u Blade-u (npr. `{{ format_km($product->price) }}`); u bazi se čuvaju kao broj.

---

## Baza podataka

### Glavne tabele

| Tabela | Opis |
|--------|------|
| **users** | name, surname, email, password, role (CUSTOMER/ADMIN), profile_image, email_verified_at, timestamps |
| **categories** | name, slug, timestamps |
| **products** | category_id (FK), name, slug, description, price, stock, image_path, is_active, timestamps |
| **orders** | user_id (FK), phone, address, note, status, total, timestamps |
| **order_items** | order_id (FK), product_id (FK), quantity, unit_price, line_total, timestamps |
| **order_status_logs** | order_id (FK), changed_by (FK users), old_status, new_status, note, timestamps |
| **cart_items** | user_id (FK), product_id (FK), quantity, timestamps |
| **restaurant_locations** | name, address, lat, lng, phone, delivery_radius_km, timestamps (jedan red) |

### Ključni odnosi

- `orders` → user_id → **users**
- `order_items` → order_id → **orders**, product_id → **products**
- `cart_items` → user_id → **users**, product_id → **products**
- `products` → category_id → **categories**

---

## REST API integracija

- **GET /api/location** — Vraća podatke lokacije slastičarne iz `restaurant_locations` (name, address, lat, lng, phone, delivery_radius_km). Koristi stranica Lokacija (Leaflet). Bez zapisa: 404.
- **GET /api/weather** — Učitava lokaciju iz baze, poziva Open-Meteo s lat/lng, vraća JSON: name, lat, lng, temperature, unit (°C). Koristi stranica Proizvodi (fetch). Bez lokacije: temperature: null.
- **Open-Meteo** se poziva na serveru u `WeatherService::getCurrentTemperatureByCoordinates()`; frontend ne poziva API izravno. Kad admin promijeni lat/lng u `/admin/location`, sljedeći učitani `/api/weather` i badge na Proizvodima odražavaju novu lokaciju.

**Testiranje API-ja:** `GET /api/location` i `GET /api/weather` — provjeriti status 200 i JSON (za weather polja name, temperature, unit).

---

## ⚙️ Instalacija i pokretanje (lokalno)

### Preduslovi

- PHP ≥ 8.2 (proširenja: bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml, curl)
- Composer
- Node.js i npm (Vite, Tailwind)
- MySQL / PostgreSQL / SQLite

### Koraci

1. Kloniraj repozitorij i uđi u folder projekta.
2. Instaliraj PHP ovisnosti:
   ```bash
   composer install
   ```
3. Kopiraj `.env.example` u `.env` i prilagodi bazu i ostale postavke:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Pokreni migracije (i po želji seedere):
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
5. Poveži storage za upload slika (proizvodi, profil):
   ```bash
   php artisan storage:link
   ```
6. Instaliraj NPM ovisnosti i pokreni Vite:
   ```bash
   npm install
   npm run dev
   ```
7. U drugom terminalu pokreni Laravel:
   ```bash
   php artisan serve
   ```

Aplikacija je dostupna na `http://localhost:8000`. Za admin pristup korisniku u bazi treba dodijeliti ulogu `ADMIN` (npr. u polju `role` u tabeli `users`).

---

## Testiranje

- **CRUD i tok:** Registracija, prijava, pregled proizvoda, korpa, checkout, moje narudžbe; za admina: proizvodi, narudžbe, statistika, lokacija. Provjera u bazi.
- **Validacija:** Obavezna polja, format e-maila, pozitivne količine; poruke grešaka (Laravel validation).
- **API:** `GET /api/location` i `GET /api/weather` — status 200, JSON. Na Proizvodima: temperatura ili „Temperatura nije dostupna”.
- **Lokacija:** Promjena lat/lng u `/admin/location`, zatim osvježiti `/products` — badge s temperaturom odražava novu lokaciju.

---

## Struktura projekta

- **routes/** — `web.php` (web, api/location, api/weather, auth, admin), `auth.php` (Breeze).
- **app/Models/** — User, Product, Category, Order, OrderItem, CartItem, RestaurantLocation, OrderStatusLog.
- **app/Http/Controllers/** — ProductController, CartController, CheckoutController, OrderController, ProfileController; Admin: ProductController, OrderController, StatsController, LocationController; Api: WeatherController.
- **app/Http/Middleware/** — Breeze; admin provjera uloge za rute pod `admin`.
- **app/Services/** — WeatherService (Open-Meteo po lat/lng).
- **app/Helpers/helpers.php** — `format_km($amount)` (composer autoload „files”).
- **resources/views/** — dashboard, products, cart, checkout, orders, location, admin, profile, layouts, auth, components.
- **database/migrations/** — users, categories, products, orders, order_items, order_status_logs, cart_items, restaurant_locations.
- **database/seeders/** — DatabaseSeeder, RestaurantLocationSeeder.

---

## Sigurnost

- **Lozinke:** Laravel bcrypt (Hash::make()).
- **Validacija:** $request->validate(...) u kontrolerima.
- **Autorizacija:** auth + verified; admin rute provjera role; korisnik vidi samo svoje narudžbe i korpu.
- **CSRF:** Laravel CSRF za sve state-changing zahtjeve.

---

## Moguća poboljšanja

- **Obavještenja** — E-mail ili in-app nakon narudžbe ili promjene statusa.
- **Statistika** — Grafovi po mjesecu, najprodavaniji po kategoriji.
- **Radijus dostave** — Provjera adrese pri checkoutu, cijena dostave.
- **PDF račun** — Export narudžbe u PDF.
- **Plaćanje** — Online plaćanje (npr. stripe).
- **API dokumentacija** — Dokumentirati /api/location i /api/weather.

---

## Autor

Slastičarna "Slatki raj" — Projekat izrađen u sklopu predmeta Objektno orijentisane baze podataka na Tehničkom fakultetu u Bihaću.

- **Akademska godina:** 2025/2026
- **Autor:** [Razija Merdanić, 1275]

---

## 📁 Važniji dijelovi projekta

- **Rute:** `routes/web.php` (web rute), `routes/auth.php` (Breeze prijava/registracija)
- **Kontroleri:** `app/Http/Controllers/` (ProductController, CartController, CheckoutController, OrderController, ProfileController; admin: Product, Order, Stats, Location)
- **Modeli:** User, Product, Category, Order, OrderItem, CartItem, RestaurantLocation
- **API:** `GET /api/location` (lokacija slastičarne), `GET /api/weather` (vrijeme na lokaciji)
- **Pogledi:** `resources/views/` (dashboard, products, cart, checkout, orders, location, admin, profile)
- **Pomoćnik za valutu:** `app/Helpers/helpers.php` – funkcija `format_km()` za ispis cijena u KM (npr. 3.517,41 KM)

---

## 🎯 Zaključak

Aplikacija **Slastičarna** omogućava kupcima jednostavno pregledavanje proizvoda, naručivanje putem korpe i praćenje narudžbi, a administratorima potpunu kontrolu nad proizvodima, narudžbama, lokacijom i statistikom. Integracija s Open-Meteo i Leafletom osigurava da su lokacija i vrijeme uvijek usklađeni s podacima iz baze koje admin može mijenjati na jednom mjestu.
