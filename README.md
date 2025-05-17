# ManagingBlogs - Real Madrid Fan Community

ManagingBlogs is een blog- en community-platform voor Real Madrid fans, geïnspireerd door [Managing Madrid](https://www.managingmadrid.com). Het platform is gebouwd met PHP, MySQL, Tailwind CSS en Alpine.js.

## Functies

- Responsieve, moderne UI met Tailwind CSS
- Dynamische interacties met Alpine.js
- Volledig functioneel blog systeem
- Gebruikersregistratie en authenticatie
- Reacties op posts
- Categorieën en zoekfunctionaliteit
- Admin dashboard (voor beheerders)

## Technische Vereisten

- PHP 7.4 of hoger
- MySQL 5.7 of hoger
- Webserver (Apache/Nginx)

## Installatie

Volg deze stappen om ManagingBlogs lokaal op te zetten:

### 1. Clone of download de repository

```bash
git clone https://github.com/jouwusername/managingblogs.git
cd managingblogs
```

### 2. Database instellen

1. Maak een nieuwe MySQL database aan genaamd `managingblogs`
2. Importeer `database.sql` in je database:

```bash
mysql -u root -p managingblogs < database.sql
```

Of gebruik een tool zoals phpMyAdmin om het SQL-bestand te importeren.

### 3. Configuratie

1. Controleer de database-instellingen in `config/database.php`:

```php
$db_config = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => 'Naoufal2004!',  // Wijzig dit naar je eigen MySQL wachtwoord
    'database' => 'managingblogs'
];
```

### 4. Mapstructuur

Zorg ervoor dat de volgende mappen schrijfbaar zijn:

- `public/uploads/` (voor het uploaden van afbeeldingen)

```bash
chmod 755 public/uploads
```

### 5. Start de lokale PHP-server

Je kunt de ingebouwde PHP-server gebruiken voor lokale ontwikkeling:

```bash
cd managingblogs
php -S localhost:8000
```

Of gebruik een lokale webserver-oplossing zoals XAMPP, MAMP of Laragon.

### 6. Open de website

Open je browser en navigeer naar:

```
http://localhost:8000
```

## Mappenstructuur

```
managingblogs/
├── config/            # Configuratiebestanden
├── controllers/       # Controller klassen
├── includes/          # Herbruikbare componenten en functies
├── models/            # Model klassen (database interactie)
├── public/            # Publiek toegankelijke bestanden
│   ├── images/        # Afbeeldingen
│   ├── js/            # JavaScript bestanden
│   └── uploads/       # Geüploade bestanden (bijv. thumbnails)
├── views/             # View templates
├── database.sql       # Database schema en voorbeelddata
└── README.md          # Dit bestand
```

## Inloggegevens voor demo

Er zijn twee vooraf geconfigureerde gebruikers voor testdoeleinden:

1. **Administrator**

   - Gebruikersnaam: `admin`
   - E-mail: `admin@managingblogs.nl`
   - Wachtwoord: `welkom123`

2. **Reguliere gebruiker**
   - Gebruikersnaam: `gebruiker`
   - E-mail: `gebruiker@managingblogs.nl`
   - Wachtwoord: `welkom123`

## Ontwikkeling

- Voor het toevoegen van nieuwe functies, maak eerst een nieuwe branch
- Houd je aan de bestaande codeerstijl
- Voeg commentaar toe aan complexe functies

## Licentie

Dit project is alleen bedoeld voor educatieve doeleinden. Gebruik op eigen risico.
