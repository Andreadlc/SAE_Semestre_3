<?php
include("includes/header.html");
include("includes/nav_bar.php");

// Vérification si l'utilisateur est connecté en tant qu'administrateur système
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header('Location: acces_refuser.php');
    exit();
}

// Chemin du fichier de logs
$log_file = 'logs/suppressions.log';

// Initialisation des filtres et de la recherche
$date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : '';
$search_filter = isset($_POST['search_filter']) ? $_POST['search_filter'] : '';

// Pagination
$logs_per_page = 10;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($current_page - 1) * $logs_per_page;

// Lecture du fichier de logs
$logs = [];
if (file_exists($log_file)) {
    // Lire le fichier sans ignorer les retours à la ligne
    $logs = file($log_file, FILE_SKIP_EMPTY_LINES);
} else {
    $error_message = "Aucun fichier de journal trouvé.";
}

// Appliquer le filtrage par date et par action
if ($date_filter || $search_filter) {
    $logs = array_filter($logs, function ($log) use ($date_filter, $search_filter) {
        $matches_date = true;
        $matches_search = true;

        // Filtrer par date
        if ($date_filter && strpos($log, $date_filter) === false) {
            $matches_date = false;
        }

        // Recherche par mot-clé
        if ($search_filter && stripos($log, $search_filter) === false) {
            $matches_search = false;
        }

        return $matches_date && $matches_search;
    });
}

// Tranche de logs à afficher
$logs_to_display = array_slice($logs, $start_from, $logs_per_page);

// Calculer le nombre total de pages
$total_logs = count($logs);
$total_pages = ceil($total_logs / $logs_per_page);
?>

<div class="login-container">
    <fieldset>
        <legend>Journal d'activités</legend>

        <?php if (isset($error_message)) : ?>
            <p class="error_message"><?php echo $error_message; ?></p>
        <?php else : ?>
            <!-- Formulaire de filtrage -->
            <form method="POST" action="">
                <label for="date_filter">Filtrer par date :</label>
                <input type="date" id="date_filter" name="date_filter" value="<?php echo htmlspecialchars($date_filter); ?>">

                <br>

                <label for="search_filter">Rechercher :</label>
                <input type="text" id="search_filter" name="search_filter" value="<?php echo htmlspecialchars($search_filter); ?>" placeholder="Mot-clé">

                <button type="submit">Filtrer</button>
            </form>
            <div class="log-container">


                <!-- Affichage des logs -->
                <?php
                foreach ($logs_to_display as $log) :
                    echo nl2br(htmlspecialchars($log));
                    echo '<br><br>';
                endforeach;
                ?>

                <!-- Pagination -->
                <div class="pagination">
                    <?php if ($current_page > 1) : ?>
                        <a href="?page=<?php echo $current_page - 1; ?>">Précédent</a>
                    <?php endif; ?>

                    <span>Page <?php echo $current_page; ?> sur <?php echo $total_pages; ?></span>

                    <?php if ($current_page < $total_pages) : ?>
                        <a href="?page=<?php echo $current_page + 1; ?>">Suivant</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </fieldset>
</div>

<?php include("includes/footer.html"); ?>
