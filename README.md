# BabixGO Files - Download Portal

Ein modernes Download-Portal mit Benutzerverwaltung, Kategoriesystem und Admin-Bereich.

## 🚀 Features

- **Download-Verwaltung**: Strukturierte Downloads mit Kategorien
- **Benutzersystem**: Registrierung, Login und Profilverwaltung
- **Admin-Panel**: Vollständige Verwaltung von Downloads, Benutzern und Kommentaren
- **Kommentarfunktion**: Benutzer können Downloads kommentieren und bewerten
- **Responsive Design**: Optimiert für Desktop und Mobile
- **PWA-Support**: Kann als Progressive Web App installiert werden
- **Cookie-Consent**: DSGVO-konformes Cookie-Banner
- **Google Analytics Integration**: Optional aktivierbare Tracking-Funktionen

## 📋 Voraussetzungen

- PHP 7.4 oder höher
- MySQL/MariaDB Datenbank
- Webserver (Apache/Nginx)
- SMTP-Server für E-Mail-Versand (optional)

## 🔧 Installation

### 1. Repository klonen

```bash
git clone https://github.com/Orga-bgo/files-bgo.git
cd files-bgo
```

### 2. Dateien hochladen

Lade den Inhalt des `public` Verzeichnisses auf deinen Webserver hoch.

### 3. Datenbank einrichten

1. Erstelle eine neue MySQL-Datenbank
2. Notiere dir die Zugangsdaten (Host, Datenbankname, Benutzer, Passwort)

### 4. Installation durchführen

1. Öffne `https://deine-domain.de/install.php` im Browser
2. Folge den Installationsschritten
3. Gib die Datenbank-Zugangsdaten ein
4. Erstelle ein Admin-Konto

### 5. Umgebungsvariablen konfigurieren (optional)

Erstelle eine `.env` Datei im Hauptverzeichnis oder im `includes` Verzeichnis:

```env
# Datenbank-Konfiguration
DB_HOST=localhost
DB_NAME=dein_datenbankname
DB_USER=dein_benutzer
DB_PASSWORD=dein_passwort

# SMTP-Konfiguration (optional)
SMTP_HOST=smtp.example.com
SMTP_PORT=587
SMTP_USER=deine@email.de
SMTP_KEY=dein_smtp_passwort
```

## 🎨 Konfiguration

### Site-Einstellungen

Die grundlegenden Site-Einstellungen können in `includes/config.php` angepasst werden:

- **SITE_NAME**: Name der Website
- **SITE_URL**: URL der Website
- **ENABLE_REGISTRATION**: Registrierung aktivieren/deaktivieren
- **ENABLE_COMMENTS**: Kommentarfunktion aktivieren/deaktivieren

### Google Analytics

Tracking-Code kann in `includes/tracking.php` konfiguriert werden.

## 📁 Projektstruktur

```
files-bgo/
├── public/                 # Web-Root (auf Server hochladen)
│   ├── admin/             # Admin-Bereich
│   ├── api/               # API-Endpunkte
│   ├── assets/            # CSS, JS, Icons
│   │   ├── css/          # Stylesheets
│   │   ├── js/           # JavaScript-Dateien
│   │   └── icons/        # Icons für PWA
│   ├── includes/          # PHP-Bibliotheken
│   │   ├── config.php    # Konfiguration
│   │   ├── db.php        # Datenbankverbindung
│   │   ├── auth.php      # Authentifizierung
│   │   └── functions.php # Hilfsfunktionen
│   ├── index.php          # Hauptseite
│   ├── category.php       # Kategorieansicht
│   ├── download.php       # Download-Detailseite
│   ├── login.php          # Login-Seite
│   ├── register.php       # Registrierung
│   └── .htaccess          # Apache-Konfiguration
└── .github/
    └── workflows/
        └── deploy.yml     # Auto-Deploy Workflow
```

## 🚀 Deployment

### Manuelles Deployment

1. Lade den Inhalt des `public` Verzeichnisses per SFTP hoch
2. Stelle sicher, dass alle Dateien die richtigen Berechtigungen haben
3. Konfiguriere die `.env` Datei auf dem Server

### Automatisches Deployment via GitHub Actions

Das Repository enthält einen GitHub Actions Workflow für automatisches Deployment via SFTP.

#### Schnellstart:

1. Gehe zu deinem Repository → Settings → Secrets and variables → Actions
2. Füge folgende Secrets hinzu:

   - `SFTP_SERVER`: Dein Server-Hostname (z.B. `files.babixgo.de`)
   - `SFTP_USERNAME`: Dein SFTP-Benutzername
   - `SFTP_PASSWORD`: Dein SFTP-Passwort
   - `SFTP_REMOTE_DIR`: Zielpfad auf dem Server (z.B. `/var/www/html/`)

3. Bei jedem Push auf den `main` Branch wird die Anwendung automatisch deployed

Alternativ kannst du das Deployment auch manuell über die Actions-Seite auslösen.

📖 **Detaillierte Anleitung**: Siehe [DEPLOYMENT.md](DEPLOYMENT.md) für eine ausführliche Setup-Anleitung und Troubleshooting.

## 👥 Benutzerverwaltung

### Admin-Zugang

Nach der Installation kannst du dich mit deinem Admin-Account unter `/login.php` anmelden.

### Admin-Funktionen

- **Dashboard**: Übersicht über Downloads, Benutzer und Aktivitäten
- **Upload**: Neue Downloads hochladen und kategorisieren
- **Manage Downloads**: Downloads bearbeiten, löschen oder aktualisieren
- **Manage Users**: Benutzerverwaltung, Rollen zuweisen
- **Moderate Comments**: Kommentare moderieren und verwalten

## 🔒 Sicherheit

- Alle Benutzereingaben werden validiert und escaped
- Passwörter werden mit modernen Hash-Algorithmen gespeichert
- Session-Management mit sicheren Cookies
- CSRF-Schutz für Formulare
- SQL-Injection-Schutz durch Prepared Statements

## 🤝 Mitwirken

Beiträge sind willkommen! Bitte erstelle einen Pull Request oder öffne ein Issue.

## 📄 Lizenz

Dieses Projekt ist für die BabixGO Community entwickelt.

## 📞 Support

Bei Fragen oder Problemen erstelle bitte ein Issue im GitHub Repository.

---

Entwickelt mit ❤️ für die BabixGO Community
