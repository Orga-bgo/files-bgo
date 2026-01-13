# SFTP Deployment Setup Guide

Diese Anleitung erklärt, wie du das automatische Deployment via SFTP mit GitHub Actions einrichtest.

## 🔐 Erforderliche GitHub Secrets

Um das automatische Deployment zu nutzen, musst du folgende Secrets in deinem GitHub Repository konfigurieren:

### 1. Secrets hinzufügen

1. Gehe zu deinem GitHub Repository
2. Klicke auf **Settings** (Einstellungen)
3. Navigiere zu **Secrets and variables** → **Actions**
4. Klicke auf **New repository secret**

### 2. Benötigte Secrets

Füge folgende Secrets hinzu:

| Secret Name | Beschreibung | Beispiel |
|-------------|--------------|----------|
| `SFTP_SERVER` | Hostname oder IP-Adresse deines Servers | `files.babixgo.de` oder `192.168.1.100` |
| `SFTP_USERNAME` | Dein SFTP-Benutzername | `webuser` |
| `SFTP_PASSWORD` | Dein SFTP-Passwort | `dein-sicheres-passwort` |
| `SFTP_REMOTE_DIR` | Zielpfad auf dem Server | `/var/www/html/` oder `/home/user/public_html/` |

⚠️ **Wichtig**: Achte darauf, dass der `SFTP_REMOTE_DIR` mit einem `/` endet!

## 🚀 Deployment-Optionen

### Automatisches Deployment

Das Deployment wird automatisch ausgelöst bei:

- **Push auf den `main` Branch**: Jede Änderung, die auf `main` gepusht wird, löst ein Deployment aus

### Manuelles Deployment

Du kannst das Deployment auch manuell auslösen:

1. Gehe zu deinem Repository auf GitHub
2. Klicke auf **Actions**
3. Wähle den Workflow **Deploy via SFTP**
4. Klicke auf **Run workflow**
5. Wähle den Branch aus und klicke auf **Run workflow**

## 📁 Was wird deployed?

Der Workflow deployed den gesamten Inhalt des `public/` Verzeichnisses auf deinen Server.

⚠️ **Hinweis**: Der SFTP-Workflow synchronisiert alle Dateien. Stelle sicher, dass sensible Dateien wie `.env` nicht im `public/` Verzeichnis liegen.

## 🔧 Workflow anpassen

Du kannst den Workflow in `.github/workflows/deploy.yml` nach deinen Bedürfnissen anpassen.

### Branch ändern

Um auf einen anderen Branch zu deployen, ändere:

```yaml
on:
  push:
    branches:
      - main  # Ändere dies zu deinem gewünschten Branch
```

### Deployment-Verzeichnis ändern

Um nur einen bestimmten Unterordner zu deployen, ändere `local_path`:

```yaml
local_path: ./public/*     # Standardwert
# oder
local_path: ./dist/*       # Beispiel: dist Verzeichnis
```

## 🔍 Deployment überprüfen

### In GitHub Actions

1. Gehe zu **Actions** in deinem Repository
2. Klicke auf den neuesten Workflow-Run
3. Überprüfe die Logs für Details

### Auf dem Server

1. Verbinde dich per SSH/SFTP mit deinem Server
2. Navigiere zum konfigurierten `SFTP_REMOTE_DIR`
3. Überprüfe, ob die Dateien aktualisiert wurden

## ⚠️ Troubleshooting

### "Permission denied" Fehler

- Überprüfe, ob der SFTP-Benutzer Schreibrechte auf den Zielpfad hat
- Stelle sicher, dass der Pfad existiert
- Prüfe die Dateiberechtigungen auf dem Server

### "Host key verification failed"

- Der Workflow verwendet standardmäßig keinen Host-Key-Check
- Falls nötig, kann dies in der Workflow-Datei angepasst werden

### "Connection timeout"

- Überprüfe, ob der SFTP-Port korrekt ist
- Stelle sicher, dass der Server von GitHub Actions erreichbar ist
- Prüfe Firewall-Einstellungen

### Dateien werden nicht aktualisiert

- Überprüfe die Logs in GitHub Actions für Details
- Stelle sicher, dass der Zielpfad korrekt ist
- Prüfe die Dateiberechtigungen auf dem Server

## 🔒 Sicherheitshinweise

- **Niemals** Secrets in den Code oder in Commit-Messages einfügen
- Verwende **starke Passwörter** für SFTP-Zugänge
- Beschränke die **SFTP-Berechtigungen** auf das notwendige Minimum
- Erwäge die Verwendung von **SSH-Keys** statt Passwörtern (erfordert Workflow-Anpassung)
- **Überwache** die Deployment-Logs regelmäßig

## 📚 Weitere Ressourcen

- [GitHub Actions Dokumentation](https://docs.github.com/en/actions)
- [SFTP-Deploy-Action Dokumentation](https://github.com/wlixcc/SFTP-Deploy-Action)
- [GitHub Secrets verwalten](https://docs.github.com/en/actions/security-guides/encrypted-secrets)

## 💡 Tipps

1. **Teste das Deployment** zuerst mit einem Test-Server
2. **Erstelle Backups** vor dem ersten automatischen Deployment
3. **Verwende separate Umgebungen** für Entwicklung, Test und Produktion
4. **Dokumentiere** alle Server-spezifischen Konfigurationen
5. **Überprüfe** die Deployment-Logs nach jedem Push

---

Bei Fragen oder Problemen erstelle bitte ein Issue im GitHub Repository.
