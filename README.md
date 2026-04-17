# rienarnoutsonepage

Portfolio website met een admin-dashboard om portfoliofoto's te beheren.

## Nieuw toegevoegd

- Login systeem (`loginuser` tabel)
- Dashboard met foto CRUD (`toevoegen`, `bewerken`, `verwijderen`)
- Foto metadata: `id`, `foto`, `category`, `titel`, `afmeting_hoogte`
- Publieke portfolio op `index.php` leest nu dynamisch uit MySQL

## Bestanden

- `admin/login.php` - inlogpagina
- `admin/dashboard.php` - beheerpagina voor portfoliofoto's
- `admin/logout.php` - uitloggen
- `config.php` - centrale database connectie (PDO)
- `config.local.example.php` - voorbeeld lokale DB-config
- `db/schema.sql` - SQL schema

## Database setup

1. Maak `config.local.php` op basis van het voorbeeldbestand.
2. Vul jouw MySQL gegevens in.
3. Importeer `db/schema.sql` in je bestaande database.

## Eerste admin gebruiker aanmaken

Genereer eerst een password hash in PHP:

```powershell
php -r "echo password_hash('KiesEenSterkWachtwoord', PASSWORD_DEFAULT), PHP_EOL;"
```

Gebruik de output in deze SQL:

```sql
INSERT INTO loginuser (username, password_hash)
VALUES ('admin', 'PLAATS_HIER_DE_HASH');
```

## Gebruik

- Login via: `/admin/login.php`
- Beheer foto's in het dashboard
- Nieuwe uploads komen in `uploads/portfolio/`
- Publieke website toont foto's per categorie (`brons`, `keramiek`)

## Seedscript (admin + originele foto's)

Er is een script toegevoegd op `db/seed_initial_data.php`.

Dit script doet het volgende:

- maakt of update een admin gebruiker in `loginuser`
- zet `foto_data` terug naar de originele set foto's van de oude site

Voorbeeld met eigen inloggegevens:

```powershell
php db/seed_initial_data.php --username=admin --password="JouwSterkWachtwoord123!"
```

Zonder `--password` wordt automatisch een sterk wachtwoord gegenereerd en in de output getoond.

### Als directe DB-verbinding lokaal niet werkt

Sommige hostingproviders blokkeren externe MySQL verbindingen. In dat geval kun je een SQL-bestand genereren en importeren via phpMyAdmin:

```powershell
php db/generate_seed_sql.php --username=admin --password="JouwSterkWachtwoord123!" --output="db/seed_generated.sql"
```

Importeer daarna `db/seed_generated.sql` in phpMyAdmin op je hostingdatabase.

## Let op

- `config.local.php` staat in `.gitignore` (lokale secrets)
- Geuploade bestanden in `uploads/portfolio/` staan in `.gitignore`
- Toegestane fotoformaten: `jpg`, `jpeg`, `png`, `webp`