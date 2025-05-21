# Bibliotheksverwaltungs-Webanwendung

Dieses Projekt ist ein webbasiertes Bibliotheksverwaltungssystem, das mit PHP und MySQL erstellt wurde. Es ermöglicht die Verwaltung von Autoren, Büchern und Mitgliedern sowie die Ausleihe und Rückgabe von Büchern. Die Benutzeroberfläche verwendet CSS für ein modernes, dunkles Design.

## Funktionen

- **Hinzufügen, Bearbeiten und Archivieren** von Autoren, Büchern und Mitgliedern.
- **Bücher ausleihen und zurückgeben** mit Datumserfassung.
- **Dunkles Design** für ein modernes Erscheinungsbild.
- **Responsives Design** mit einer festen Seitenleiste zur Navigation.

## Voraussetzungen

Stelle sicher, dass die folgenden Softwarekomponenten installiert sind:

- **PHP** (Version 7.0 oder höher)
- **MySQL** oder **MariaDB**
- **Ein Webserver** wie Apache (z.B. XAMPP, WAMP oder LAMP)

## Nutzung

- **Einträge hinzufügen**: Neue Autoren, Bücher und Mitglieder können über die jeweiligen Formulare in der Seitenleiste hinzugefügt werden.
- **Einträge bearbeiten**: Klicke auf den "Bearbeiten"-Button neben einem Eintrag, um seine Details zu ändern.
- **Einträge archivieren**: Verwende den "Archivieren"-Button, um einen Eintrag als archiviert zu markieren (der Eintrag wird nicht gelöscht, bleibt also in der Datenbank).
- **Bücher ausleihen/zurückgeben**: Navigiere zu den Bereichen "Buch ausleihen" oder "Buch zurückgeben", um Ausleihen zu verwalten.

## Stile und Benutzeroberfläche

Die Anwendung verwendet ein dunkles Design mit einer festen Seitenleiste zur Navigation. Die CSS-Stile befinden sich in der Datei `styles.css`, die für ein sauberes und responsives Design sorgt.

### Einige wichtige Elemente aus der CSS-Datei:

- **Dunkles Design** mit kontrastierenden Text- und Hintergrundfarben für ein modernes Erscheinungsbild.
- **Buttons**: Angepasste Stile für primäre, Warn- und Gefahren-Buttons.
- **Tabellen**: Gestaltet mit abwechselnden Zeilenfarben für eine bessere Lesbarkeit bei dunklem Hintergrund.
