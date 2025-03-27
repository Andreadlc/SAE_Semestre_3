<?php
include("includes/header.html");
include("includes/nav_bar.php");

// Vérification si l'utilisateur est connecté en tant qu'administrateur système
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header('Location: acces_refuser.php');
    exit();
}

// Récupération de la date choisie (par défaut, aujourd'hui)
$date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : date('Y-m-d');
$log_file = "logs/$date_filter.json";

// Initialisation de la recherche
$search_filter = isset($_POST['search_filter']) ? $_POST['search_filter'] : '';

// Pagination
$logs_per_page = 10;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($current_page - 1) * $logs_per_page;

// Lecture du fichier JSON
$logs = [];
if (file_exists($log_file)) {
    $json_content = file_get_contents($log_file);
    $logs = json_decode($json_content, true);
    if (!is_array($logs)) {
        $logs = []; // Sécurité contre un fichier corrompu
    }
} else {
    $logs = [];
}

// Appliquer le filtre de recherche
if ($search_filter) {
    $logs = array_filter($logs, function ($log) use ($search_filter) {
        return stripos(json_encode($log), $search_filter) !== false;
    });
}

// Trier du plus récent au plus ancien
$logs = array_reverse($logs);

// Tranche de logs à afficher
$logs_to_display = array_slice($logs, $start_from, $logs_per_page);
$total_logs = count($logs);
$total_pages = ceil($total_logs / $logs_per_page);
?>

<div class="login-container">
    <fieldset>
        <legend>Journal d'activités</legend>

        <form method="POST" action="">
            <label for="date_filter">Sélectionner une date :</label>
            <input type="date" id="date_filter" name="date_filter" value="<?php echo htmlspecialchars($date_filter); ?>">

            <br>

            <label for="search_filter">Rechercher :</label>
            <input type="text" id="search_filter" name="search_filter" value="<?php echo htmlspecialchars($search_filter); ?>" placeholder="Mot-clé">

            <button type="submit">Filtrer</button>
        </form>

        <div class="log-container">
            <?php if (!empty($logs_to_display)) : ?>
                <?php foreach ($logs_to_display as $log) : ?>
                    <p><?php echo "[{$log['date']} {$log['heure']}] IP: {$log['ip']} | Login: {$log['login']} | Statut: {$log['status']}"; ?></p>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun log pour cette date.</p>
            <?php endif; ?>
        </div>

        <div class="pagination">
            <?php if ($current_page > 1) : ?>
                <a href="?page=<?php echo $current_page - 1; ?>&date_filter=<?php echo $date_filter; ?>">Précédent</a>
            <?php endif; ?>

            <span>Page <?php echo $current_page; ?> sur <?php echo $total_pages; ?></span>

            <?php if ($current_page < $total_pages) : ?>
                <a href="?page=<?php echo $current_page + 1; ?>&date_filter=<?php echo $date_filter; ?>">Suivant</a>
            <?php endif; ?>
        </div>

        <a href="telecharger_logs.php?file=<?php echo $log_file; ?>" class="btn">Télécharger les logs</a>
        <a href="supprimer_logs.php?file=<?php echo $log_file; ?>" class="btn btn-danger">Supprimer les logs</a>
    </fieldset>
</div>

<?php include("includes/footer.html"); ?>
