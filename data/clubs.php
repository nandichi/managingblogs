<?php
/**
 * clubs.php - Bevat alle clubs van verschillende competities voor handmatige invoer
 * 
 * Dit bestand bevat arrays met clubs per competitie om handmatig standen te kunnen bijwerken
 * wanneer de API niet beschikbaar is of wanneer aangepaste data nodig is.
 */

// Array met alle beschikbare competities
$availableLeagues = [
    'premier-league' => 'Premier League',
    'la-liga' => 'La Liga',
    'eredivisie' => 'Eredivisie',
    'bundesliga' => 'Bundesliga',
    'serie-a' => 'Serie A',
    'ligue-1' => 'Ligue 1'
];

// Premier League (Engeland) clubs
$clubs['premier-league'] = [
    ['id' => 1, 'name' => 'Arsenal'],
    ['id' => 2, 'name' => 'Aston Villa'],
    ['id' => 3, 'name' => 'Bournemouth'],
    ['id' => 4, 'name' => 'Brentford'],
    ['id' => 5, 'name' => 'Brighton & Hove Albion'],
    ['id' => 6, 'name' => 'Chelsea'],
    ['id' => 7, 'name' => 'Crystal Palace'],
    ['id' => 8, 'name' => 'Everton'],
    ['id' => 9, 'name' => 'Fulham'],
    ['id' => 10, 'name' => 'Liverpool'],
    ['id' => 11, 'name' => 'Manchester City'],
    ['id' => 12, 'name' => 'Manchester United'],
    ['id' => 13, 'name' => 'Newcastle United'],
    ['id' => 14, 'name' => 'Nottingham Forest'],
    ['id' => 15, 'name' => 'Southampton'],
    ['id' => 16, 'name' => 'Tottenham Hotspur'],
    ['id' => 17, 'name' => 'West Ham United'],
    ['id' => 18, 'name' => 'Wolverhampton Wanderers'],
    ['id' => 19, 'name' => 'Ipswich Town'],
    ['id' => 20, 'name' => 'Leicester City']
];

// La Liga (Spanje) clubs
$clubs['la-liga'] = [
    ['id' => 1, 'name' => 'Atlético Madrid'],
    ['id' => 2, 'name' => 'Athletic Club'],
    ['id' => 3, 'name' => 'Barcelona'],
    ['id' => 4, 'name' => 'Celta Vigo'],
    ['id' => 5, 'name' => 'Espanyol'],
    ['id' => 6, 'name' => 'Getafe'],
    ['id' => 7, 'name' => 'Granada'],
    ['id' => 8, 'name' => 'Mallorca'],
    ['id' => 9, 'name' => 'Osasuna'],
    ['id' => 10, 'name' => 'Rayo Vallecano'],
    ['id' => 11, 'name' => 'Real Betis'],
    ['id' => 12, 'name' => 'Real Madrid'],
    ['id' => 13, 'name' => 'Real Sociedad'],
    ['id' => 14, 'name' => 'Sevilla'],
    ['id' => 15, 'name' => 'Valencia'],
    ['id' => 16, 'name' => 'Villarreal'],
    ['id' => 17, 'name' => 'Alavés'],
    ['id' => 18, 'name' => 'Las Palmas'],
    ['id' => 19, 'name' => 'Girona'],
    ['id' => 20, 'name' => 'Valladolid']
];

// Eredivisie (Nederland) clubs
$clubs['eredivisie'] = [
    ['id' => 1, 'name' => 'Ajax'],
    ['id' => 2, 'name' => 'AZ'],
    ['id' => 3, 'name' => 'FC Groningen'],
    ['id' => 4, 'name' => 'FC Twente'],
    ['id' => 5, 'name' => 'FC Utrecht'],
    ['id' => 6, 'name' => 'Feyenoord'],
    ['id' => 7, 'name' => 'Fortuna Sittard'],
    ['id' => 8, 'name' => 'Go Ahead Eagles'],
    ['id' => 9, 'name' => 'NEC'],
    ['id' => 10, 'name' => 'PEC Zwolle'],
    ['id' => 11, 'name' => 'PSV'],
    ['id' => 12, 'name' => 'RKC Waalwijk'],
    ['id' => 13, 'name' => 'SC Heerenveen'],
    ['id' => 14, 'name' => 'Sparta Rotterdam'],
    ['id' => 15, 'name' => 'Vitesse'],
    ['id' => 16, 'name' => 'Willem II'],
    ['id' => 17, 'name' => 'FC Volendam'],
    ['id' => 18, 'name' => 'Excelsior']
];

// Bundesliga (Duitsland) clubs
$clubs['bundesliga'] = [
    ['id' => 1, 'name' => 'Bayern München'],
    ['id' => 2, 'name' => 'Bayer Leverkusen'],
    ['id' => 3, 'name' => 'Borussia Dortmund'],
    ['id' => 4, 'name' => 'Borussia Mönchengladbach'],
    ['id' => 5, 'name' => 'Eintracht Frankfurt'],
    ['id' => 6, 'name' => 'FC Augsburg'],
    ['id' => 7, 'name' => 'FC Köln'],
    ['id' => 8, 'name' => 'FSV Mainz 05'],
    ['id' => 9, 'name' => 'Hertha BSC'],
    ['id' => 10, 'name' => 'RB Leipzig'],
    ['id' => 11, 'name' => 'SC Freiburg'],
    ['id' => 12, 'name' => 'TSG Hoffenheim'],
    ['id' => 13, 'name' => 'Union Berlin'],
    ['id' => 14, 'name' => 'VfB Stuttgart'],
    ['id' => 15, 'name' => 'VfL Bochum'],
    ['id' => 16, 'name' => 'VfL Wolfsburg'],
    ['id' => 17, 'name' => 'Werder Bremen'],
    ['id' => 18, 'name' => 'Holstein Kiel']
];

// Serie A (Italië) clubs
$clubs['serie-a'] = [
    ['id' => 1, 'name' => 'AC Milan'],
    ['id' => 2, 'name' => 'AS Roma'],
    ['id' => 3, 'name' => 'Atalanta'],
    ['id' => 4, 'name' => 'Bologna'],
    ['id' => 5, 'name' => 'Cagliari'],
    ['id' => 6, 'name' => 'Empoli'],
    ['id' => 7, 'name' => 'Fiorentina'],
    ['id' => 8, 'name' => 'Genoa'],
    ['id' => 9, 'name' => 'Inter'],
    ['id' => 10, 'name' => 'Juventus'],
    ['id' => 11, 'name' => 'Lazio'],
    ['id' => 12, 'name' => 'Lecce'],
    ['id' => 13, 'name' => 'Monza'],
    ['id' => 14, 'name' => 'Napoli'],
    ['id' => 15, 'name' => 'Parma'],
    ['id' => 16, 'name' => 'Sassuolo'],
    ['id' => 17, 'name' => 'Torino'],
    ['id' => 18, 'name' => 'Udinese'],
    ['id' => 19, 'name' => 'Venezia'],
    ['id' => 20, 'name' => 'Hellas Verona']
];

// Ligue 1 (Frankrijk) clubs
$clubs['ligue-1'] = [
    ['id' => 1, 'name' => 'AS Monaco'],
    ['id' => 2, 'name' => 'AJ Auxerre'],
    ['id' => 3, 'name' => 'Lille OSC'],
    ['id' => 4, 'name' => 'Montpellier HSC'],
    ['id' => 5, 'name' => 'Nantes'],
    ['id' => 6, 'name' => 'Nice'],
    ['id' => 7, 'name' => 'Olympique Lyonnais'],
    ['id' => 8, 'name' => 'Olympique de Marseille'],
    ['id' => 9, 'name' => 'Paris Saint-Germain'],
    ['id' => 10, 'name' => 'RC Lens'],
    ['id' => 11, 'name' => 'RC Strasbourg'],
    ['id' => 12, 'name' => 'Rennes'],
    ['id' => 13, 'name' => 'Toulouse'],
    ['id' => 14, 'name' => 'Angers'],
    ['id' => 15, 'name' => 'Brest'],
    ['id' => 16, 'name' => 'Clermont Foot'],
    ['id' => 17, 'name' => 'Reims'],
    ['id' => 18, 'name' => 'Saint-Étienne'],
    ['id' => 19, 'name' => 'Le Havre'],
    ['id' => 20, 'name' => 'Metz']
];

// Standaard structuur voor handmatige invoer van teamgegevens
$standingsTemplate = [
    'rank' => 0,
    'matches_played' => 0,
    'wins' => 0,
    'draws' => 0,
    'losses' => 0,
    'goals_for' => 0,
    'goals_against' => 0,
    'goal_difference' => 0,
    'points' => 0
];

// Functie om de huidige handmatige standen op te halen (of lege standen te maken)
function getManualStandings($league) {
    global $clubs, $standingsTemplate;
    
    // Gebruik het volledige pad vanaf de rootdirectory
    $rootDir = dirname(dirname(__FILE__)); // Ga één niveau omhoog vanaf de data directory
    $standingsFile = $rootDir . '/data/manual_standings_' . $league . '.json';
    
    if (file_exists($standingsFile)) {
        $standings = json_decode(file_get_contents($standingsFile), true);
    } else {
        // Maak lege standen als het bestand niet bestaat
        $standings = [];
        foreach ($clubs[$league] as $club) {
            $standings[$club['id']] = array_merge(['team' => $club['name']], $standingsTemplate);
        }
    }
    
    return $standings;
}

// Functie om handmatige standen op te slaan
function saveManualStandings($league, $standings) {
    // Gebruik het volledige pad vanaf de rootdirectory
    $rootDir = dirname(dirname(__FILE__)); // Ga één niveau omhoog vanaf de data directory
    $standingsFile = $rootDir . '/data/manual_standings_' . $league . '.json';
    
    // Controleer of de directory bestaat, zo niet maak deze aan
    $dir = dirname($standingsFile);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    return file_put_contents($standingsFile, json_encode($standings, JSON_PRETTY_PRINT));
} 