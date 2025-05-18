<?php
// Inclusief header met navigatie
require_once 'includes/header.php';
// Inclusief helper functies als die nog niet zijn geladen
require_once 'includes/functions.php';
?>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-primary mb-2">Competitie Standen</h1>
    <p class="text-gray-600">Bekijk de actuele standen van verschillende voetbalcompetities.</p>
</div>

<!-- Competitie Selector -->
<div class="flex flex-wrap gap-2 mb-6">
    <?php foreach ($availableLeagues as $slug => $name): ?>
        <a href="?league=<?php echo $slug; ?>" 
           class="px-4 py-2 rounded-full text-sm font-medium transition-all <?php echo $selectedLeague === $slug ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'; ?>">
            <?php echo $name; ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Huidige competitie titel -->
<div class="flex items-center mb-6">
    <h2 class="text-2xl font-bold"><?php echo $availableLeagues[$selectedLeague]; ?></h2>
    <div class="ml-3 px-3 py-1 bg-gray-100 rounded-full text-sm text-gray-600">Seizoen 2023/2024</div>
    <div id="last-updated" class="ml-auto text-sm text-gray-500"></div>
</div>

<!-- Loading indicator -->
<div id="loading" class="text-center py-20">
    <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-primary"></div>
    <p class="mt-4 text-gray-600">Bezig met het laden van de competitiestand...</p>
</div>

<!-- Standings table container -->
<div id="standings-container" class="hidden">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Positie</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Club</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">GW</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">W</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">G</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">V</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">DV</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">DT</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">DS</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">PNT</th>
                </tr>
            </thead>
            <tbody id="standings-body" class="bg-white divide-y divide-gray-200">
                <!-- Dynamisch gevuld door JavaScript -->
            </tbody>
        </table>
    </div>
    
    <!-- Legenda -->
    <div class="mt-4 flex flex-wrap gap-x-8 gap-y-2">
        <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
            <span class="text-sm text-gray-600">Champions League</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
            <span class="text-sm text-gray-600">Europa League</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-orange-400 mr-2"></div>
            <span class="text-sm text-gray-600">Conference League</span>
        </div>
        <div class="flex items-center">
            <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
            <span class="text-sm text-gray-600">Degradatiezone</span>
        </div>
    </div>
    
    <!-- Opmerking -->
    <div class="mt-6 bg-gray-50 p-4 rounded-lg text-sm text-gray-600">
        <p>Alle gegevens worden via een publieke API opgehaald en worden regelmatig bijgewerkt. De meest recente bijwerking wordt bovenaan weergegeven.</p>
        <p class="mt-2">De promotie/degradatie en Europese plaatsen kunnen per competitie verschillen.</p>
    </div>
</div>

<!-- Error message -->
<div id="error-message" class="hidden bg-red-50 border-l-4 border-red-500 p-4 my-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">Er is een fout opgetreden bij het ophalen van de competitiegegevens. Probeer het later opnieuw.</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const leagueMap = {
            'premier-league': 'england',
            'la-liga': 'spain',
            'eredivisie': 'netherlands',
            'bundesliga': 'germany',
            'serie-a': 'italy',
            'ligue-1': 'france'
        };
        
        // Huidige competitie
        const urlParams = new URLSearchParams(window.location.search);
        const selectedLeague = urlParams.get('league') || 'premier-league';
        const apiCountry = leagueMap[selectedLeague];
        
        // UI elementen
        const loadingElement = document.getElementById('loading');
        const standingsContainer = document.getElementById('standings-container');
        const standingsBody = document.getElementById('standings-body');
        const errorMessage = document.getElementById('error-message');
        const lastUpdatedElement = document.getElementById('last-updated');
        
        // Open Football Data API - GitHub repository met JSON bestanden - geen API key nodig
        const openFootballDataUrl = `https://raw.githubusercontent.com/openfootball/football.json/master/2023-24/${apiCountry}.1.standings.json`;
        
        // Extra backup bronnen als de eerste bron niet werkt
        const footballDataOrgMockUrl = `https://raw.githack.com/openfootball/football.json/master/2022-23/${apiCountry}.1.standings.json`;
        
        // Haal de competitiestand op
        fetchStandings();
        
        async function fetchStandings() {
            try {
                // Gebruik de Open Football Data repository (geen API key nodig)
                const response = await fetch(openFootballDataUrl);
                
                if (!response.ok) {
                    throw new Error('Kon de competitiegegevens niet ophalen');
                }
                
                const data = await response.json();
                
                // Update laatste bijgewerkt tijdstip
                const now = new Date();
                lastUpdatedElement.textContent = `Laatst bijgewerkt: ${formatDate(now)}`;
                
                // Render de competitiestand
                renderStandings(data);
                
                // Toon de resultaten, verberg de loading
                loadingElement.classList.add('hidden');
                standingsContainer.classList.remove('hidden');
                
            } catch (error) {
                console.error('Error fetching standings from primary source:', error);
                
                // Probeer de backup bron
                try {
                    const backupResponse = await fetch(footballDataOrgMockUrl);
                    
                    if (!backupResponse.ok) {
                        throw new Error('Kon de backup competitiegegevens niet ophalen');
                    }
                    
                    const backupData = await backupResponse.json();
                    const now = new Date();
                    lastUpdatedElement.textContent = `Laatst bijgewerkt: ${formatDate(now)} (van backup bron)`;
                    
                    // Render de competitiestand van de backup bron
                    renderStandings(backupData);
                    
                    // Toon de resultaten, verberg de loading
                    loadingElement.classList.add('hidden');
                    standingsContainer.classList.remove('hidden');
                    
                    // Voeg een waarschuwing toe dat dit van een backup bron komt
                    const warningElement = document.createElement('div');
                    warningElement.className = 'bg-yellow-50 border-l-4 border-yellow-400 p-4 my-4';
                    warningElement.innerHTML = `
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Opmerking: We tonen momenteel data van een backup bron omdat we geen verbinding konden maken met de primaire databron.
                                </p>
                            </div>
                        </div>
                    `;
                    
                    standingsContainer.parentNode.insertBefore(warningElement, standingsContainer);
                    
                } catch (backupError) {
                    console.error('Error fetching standings from backup source:', backupError);
                    loadingElement.classList.add('hidden');
                    errorMessage.classList.remove('hidden');
                    
                    // Toon fallback data als beide API's falen
                    showFallbackData();
                }
            }
        }
        
        function renderStandings(data) {
            // Clear previous standings
            standingsBody.innerHTML = '';
            
            // Open Football Data GitHub repository format
            if (data.standings) {
                data.standings.forEach((team, index) => {
                    const row = createTableRow(
                        team.rank || (index + 1),
                        team.team.name,
                        team.matches_played || team.played,
                        team.wins || team.won,
                        team.draws || team.drawn,
                        team.losses || team.lost,
                        team.goals_for || (team.goals && team.goals.for),
                        team.goals_against || (team.goals && team.goals.against),
                        (team.goals_for || (team.goals && team.goals.for)) - (team.goals_against || (team.goals && team.goals.against)),
                        team.points,
                        getRowClass(team.rank || (index + 1), selectedLeague)
                    );
                    standingsBody.appendChild(row);
                });
            } 
            // Football-data.org formaat (als backup)
            else if (data.table) {
                data.table.forEach((team, index) => {
                    const row = createTableRow(
                        team.position || (index + 1),
                        team.team.name,
                        team.playedGames,
                        team.won,
                        team.draw,
                        team.lost,
                        team.goalsFor,
                        team.goalsAgainst,
                        team.goalDifference,
                        team.points,
                        getRowClass(team.position || (index + 1), selectedLeague)
                    );
                    standingsBody.appendChild(row);
                });
            }
            // Geen herkenbaar formaat
            else {
                showFallbackData();
            }
        }
        
        function createTableRow(position, club, played, wins, draws, losses, goalsFor, goalsAgainst, goalDiff, points, rowClass) {
            const row = document.createElement('tr');
            row.className = rowClass;
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${position}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${club}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="text-sm text-gray-900">${played}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="text-sm text-gray-900">${wins}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="text-sm text-gray-900">${draws}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="text-sm text-gray-900">${losses}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="text-sm text-gray-900">${goalsFor}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="text-sm text-gray-900">${goalsAgainst}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="text-sm text-gray-900">${goalDiff}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="text-sm font-bold text-gray-900">${points}</div>
                </td>
            `;
            
            return row;
        }
        
        function getRowClass(position, league) {
            let baseClass = "hover:bg-gray-50";
            
            // Verschillende kleurcodes afhankelijk van de competitie
            switch(league) {
                case 'premier-league':
                    if (position <= 4) return baseClass + " bg-green-50";
                    if (position == 5) return baseClass + " bg-blue-50";
                    if (position == 6) return baseClass + " bg-orange-50";
                    if (position >= 18) return baseClass + " bg-red-50";
                    return baseClass;
                
                case 'la-liga':
                    if (position <= 4) return baseClass + " bg-green-50";
                    if (position <= 6) return baseClass + " bg-blue-50";
                    if (position == 7) return baseClass + " bg-orange-50";
                    if (position >= 18) return baseClass + " bg-red-50";
                    return baseClass;
                
                case 'eredivisie':
                    if (position <= 2) return baseClass + " bg-green-50";
                    if (position == 3) return baseClass + " bg-blue-50";
                    if (position <= 5) return baseClass + " bg-orange-50";
                    if (position >= 16) return baseClass + " bg-red-50";
                    return baseClass;
                
                case 'bundesliga':
                    if (position <= 4) return baseClass + " bg-green-50";
                    if (position == 5) return baseClass + " bg-blue-50";
                    if (position == 6) return baseClass + " bg-orange-50";
                    if (position >= 16) return baseClass + " bg-red-50";
                    return baseClass;
                
                default:
                    if (position <= 4) return baseClass + " bg-green-50";
                    if (position == 5) return baseClass + " bg-blue-50";
                    if (position == 6) return baseClass + " bg-orange-50";
                    if (position >= 18) return baseClass + " bg-red-50";
                    return baseClass;
            }
        }
        
        function showFallbackData() {
            // Toon een fallback tabel als beide API's niet werken
            const fallbackData = {
                standings: [
                    { rank: 1, team: { name: "Team A" }, matches_played: 10, wins: 8, draws: 1, losses: 1, goals_for: 22, goals_against: 8, points: 25 },
                    { rank: 2, team: { name: "Team B" }, matches_played: 10, wins: 7, draws: 2, losses: 1, goals_for: 20, goals_against: 10, points: 23 },
                    { rank: 3, team: { name: "Team C" }, matches_played: 10, wins: 6, draws: 2, losses: 2, goals_for: 18, goals_against: 12, points: 20 },
                    { rank: 4, team: { name: "Team D" }, matches_played: 10, wins: 5, draws: 3, losses: 2, goals_for: 15, goals_against: 10, points: 18 },
                    { rank: 5, team: { name: "Team E" }, matches_played: 10, wins: 5, draws: 2, losses: 3, goals_for: 14, goals_against: 12, points: 17 },
                    { rank: 6, team: { name: "Team F" }, matches_played: 10, wins: 4, draws: 4, losses: 2, goals_for: 13, goals_against: 11, points: 16 },
                    { rank: 7, team: { name: "Team G" }, matches_played: 10, wins: 4, draws: 3, losses: 3, goals_for: 13, goals_against: 13, points: 15 },
                    { rank: 8, team: { name: "Team H" }, matches_played: 10, wins: 4, draws: 2, losses: 4, goals_for: 12, goals_against: 14, points: 14 },
                    { rank: 9, team: { name: "Team I" }, matches_played: 10, wins: 3, draws: 4, losses: 3, goals_for: 11, goals_against: 12, points: 13 },
                    { rank: 10, team: { name: "Team J" }, matches_played: 10, wins: 3, draws: 3, losses: 4, goals_for: 10, goals_against: 12, points: 12 },
                    { rank: 11, team: { name: "Team K" }, matches_played: 10, wins: 3, draws: 2, losses: 5, goals_for: 9, goals_against: 13, points: 11 },
                    { rank: 12, team: { name: "Team L" }, matches_played: 10, wins: 2, draws: 4, losses: 4, goals_for: 10, goals_against: 14, points: 10 },
                    { rank: 13, team: { name: "Team M" }, matches_played: 10, wins: 2, draws: 3, losses: 5, goals_for: 9, goals_against: 15, points: 9 },
                    { rank: 14, team: { name: "Team N" }, matches_played: 10, wins: 2, draws: 2, losses: 6, goals_for: 8, goals_against: 16, points: 8 },
                    { rank: 15, team: { name: "Team O" }, matches_played: 10, wins: 1, draws: 4, losses: 5, goals_for: 7, goals_against: 15, points: 7 },
                    { rank: 16, team: { name: "Team P" }, matches_played: 10, wins: 1, draws: 3, losses: 6, goals_for: 6, goals_against: 16, points: 6 },
                    { rank: 17, team: { name: "Team Q" }, matches_played: 10, wins: 1, draws: 2, losses: 7, goals_for: 5, goals_against: 17, points: 5 },
                    { rank: 18, team: { name: "Team R" }, matches_played: 10, wins: 0, draws: 4, losses: 6, goals_for: 4, goals_against: 18, points: 4 },
                    { rank: 19, team: { name: "Team S" }, matches_played: 10, wins: 0, draws: 3, losses: 7, goals_for: 3, goals_against: 19, points: 3 },
                    { rank: 20, team: { name: "Team T" }, matches_played: 10, wins: 0, draws: 1, losses: 9, goals_for: 2, goals_against: 20, points: 1 }
                ]
            };
            
            renderStandings(fallbackData);
            
            // Toon de resultaten, verberg de loading
            loadingElement.classList.add('hidden');
            standingsContainer.classList.remove('hidden');
            
            // Toon een waarschuwing dat dit demodata is
            const warningElement = document.createElement('div');
            warningElement.className = 'bg-yellow-50 border-l-4 border-yellow-400 p-4 my-4';
            warningElement.innerHTML = `
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Opmerking: We tonen momenteel demodata omdat we geen verbinding konden maken met de externe API's.
                        </p>
                    </div>
                </div>
            `;
            
            standingsContainer.parentNode.insertBefore(warningElement, standingsContainer);
        }
        
        function formatDate(date) {
            return date.toLocaleString('nl-NL', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    });
</script>

<?php
// Inclusief de footer
require_once 'includes/footer.php';
?> 