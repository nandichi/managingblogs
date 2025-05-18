<?php
// Inclusief benodigde bestanden
require_once '../includes/header.php';
require_once '../includes/functions.php';
require_once '../data/clubs.php';

// Controleer of er een POST-verzoek is gedaan om de standen op te slaan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_standings'])) {
    $league = $_POST['league'];
    $standings = [];
    
    // Loop door alle teamgegevens in het formulier
    foreach ($_POST['team'] as $teamId => $teamData) {
        $standings[$teamId] = [
            'team' => $clubs[$league][$teamId-1]['name'],
            'rank' => intval($teamData['rank']),
            'matches_played' => intval($teamData['matches_played']),
            'wins' => intval($teamData['wins']),
            'draws' => intval($teamData['draws']),
            'losses' => intval($teamData['losses']),
            'goals_for' => intval($teamData['goals_for']),
            'goals_against' => intval($teamData['goals_against']),
            'goal_difference' => intval($teamData['goals_for']) - intval($teamData['goals_against']),
            'points' => intval($teamData['points'])
        ];
    }
    
    // Sla de standen op
    if (saveManualStandings($league, $standings)) {
        $successMessage = "De standen zijn succesvol opgeslagen!";
    } else {
        $errorMessage = "Er is een fout opgetreden bij het opslaan van de standen.";
    }
}

// Haal de geselecteerde competitie op uit GET of standaardwaarde
$selectedLeague = isset($_GET['league']) ? $_GET['league'] : 'premier-league';

// Controleer of de geselecteerde competitie geldig is
if (!isset($availableLeagues[$selectedLeague])) {
    $selectedLeague = 'premier-league'; // Standaard als de competitie niet bestaat
}

// Haal de huidige standen op (of maak nieuwe)
$currentStandings = getManualStandings($selectedLeague);

// Sorteer de teams op basis van huidige ranking (als die er is)
usort($currentStandings, function($a, $b) {
    if ($a['rank'] === $b['rank']) {
        return 0;
    }
    // Als rank 0 is, zet deze team achteraan
    if ($a['rank'] === 0) return 1;
    if ($b['rank'] === 0) return -1;
    
    return ($a['rank'] < $b['rank']) ? -1 : 1;
});
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary mb-2">Handmatige Standenbeheer</h1>
        <p class="text-gray-600">Hier kunt u de competitiestanden handmatig aanpassen wanneer de API niet beschikbaar is.</p>
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
    </div>
    
    <!-- Succes of foutmelding -->
    <?php if (isset($successMessage)): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700"><?php echo $successMessage; ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (isset($errorMessage)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700"><?php echo $errorMessage; ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Formulier voor het bewerken van competitiestanden -->
    <form method="POST" action="" class="mb-6">
        <input type="hidden" name="league" value="<?php echo $selectedLeague; ?>">
        
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
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
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($clubs[$selectedLeague] as $club): ?>
                        <?php 
                        $teamData = isset($currentStandings[$club['id']]) ? $currentStandings[$club['id']] : [
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
                        
                        // Bereken doelsaldo automatisch
                        $goalDiff = $teamData['goals_for'] - $teamData['goals_against'];
                        ?>
                        <tr>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <input type="number" name="team[<?php echo $club['id']; ?>][rank]" 
                                       value="<?php echo $teamData['rank']; ?>" 
                                       class="w-16 border border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                       min="1" max="<?php echo count($clubs[$selectedLeague]); ?>">
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo $club['name']; ?></div>
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <input type="number" name="team[<?php echo $club['id']; ?>][matches_played]" 
                                       value="<?php echo $teamData['matches_played']; ?>" 
                                       class="w-16 border border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                       min="0">
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <input type="number" name="team[<?php echo $club['id']; ?>][wins]" 
                                       value="<?php echo $teamData['wins']; ?>" 
                                       class="w-16 border border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                       min="0">
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <input type="number" name="team[<?php echo $club['id']; ?>][draws]" 
                                       value="<?php echo $teamData['draws']; ?>" 
                                       class="w-16 border border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                       min="0">
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <input type="number" name="team[<?php echo $club['id']; ?>][losses]" 
                                       value="<?php echo $teamData['losses']; ?>" 
                                       class="w-16 border border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                       min="0">
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <input type="number" name="team[<?php echo $club['id']; ?>][goals_for]" 
                                       value="<?php echo $teamData['goals_for']; ?>" 
                                       class="w-16 border border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                       min="0">
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <input type="number" name="team[<?php echo $club['id']; ?>][goals_against]" 
                                       value="<?php echo $teamData['goals_against']; ?>" 
                                       class="w-16 border border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                       min="0">
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo $goalDiff; ?></div>
                            </td>
                            <td class="px-2 py-4 whitespace-nowrap">
                                <input type="number" name="team[<?php echo $club['id']; ?>][points]" 
                                       value="<?php echo $teamData['points']; ?>" 
                                       class="w-16 border border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                       min="0">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 flex justify-between">
            <button type="button" id="calculate-btn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Bereken punten automatisch
            </button>
            
            <button type="submit" name="save_standings" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                Standen opslaan
            </button>
        </div>
    </form>
    
    <!-- Instructies -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="font-bold text-lg mb-2">Instructies</h3>
        <ul class="list-disc pl-5 space-y-1 text-sm text-gray-600">
            <li>Vul de positie, aantal gespeelde wedstrijden, overwinningen, gelijkspelen, nederlagen, doelpunten voor, doelpunten tegen en punten in voor elk team.</li>
            <li>Het doelsaldo wordt automatisch berekend als het verschil tussen doelpunten voor en tegen.</li>
            <li>Gebruik de knop "Bereken punten automatisch" om de punten te berekenen op basis van overwinningen (3 punten) en gelijkspelen (1 punt).</li>
            <li>Klik op "Standen opslaan" om de gegevens op te slaan.</li>
            <li>De opgeslagen gegevens worden gebruikt wanneer de externe API's niet beschikbaar zijn.</li>
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Knop om punten automatisch te berekenen
        const calculateBtn = document.getElementById('calculate-btn');
        
        calculateBtn.addEventListener('click', function() {
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const wins = parseInt(row.querySelector('input[name*="[wins]"]').value) || 0;
                const draws = parseInt(row.querySelector('input[name*="[draws]"]').value) || 0;
                
                // Bereken punten (3 voor winst, 1 voor gelijkspel)
                const points = (wins * 3) + draws;
                
                // Update het puntenveld
                row.querySelector('input[name*="[points]"]').value = points;
            });
        });
    });
</script>

<?php require_once '../includes/footer.php'; ?> 