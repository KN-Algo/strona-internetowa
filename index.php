<?php
// Ustawienie domyślnego języka
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'pl';

// Ścieżka do pliku tłumaczeń
$translationFile = __DIR__ . "/translations/{$lang}.php";

// Wczytaj tłumaczenia, jeśli plik istnieje, inaczej użyj polskiego
if (file_exists($translationFile)) {
    $translations = include($translationFile);
} else {
    $translations = include(__DIR__ . "/translations/pl.php");
}
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KN ALGO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/navbar.js"></script>
    <link rel="stylesheet" href="styles/main.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/img/favicos/favicon-48x48.png" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="/img/favicos/favicon.svg" />
    <link rel="shortcut icon" href="/img/favicos/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicos/apple-touch-icon.png" />
    <link rel="manifest" href="/img/favicos/site.webmanifest" />

</head>
<nav>
    <ul class="topnav" id="nav-menu">
        <div class="logo">
          <img src="/img/logos/logo-white.png" alt="KN ALGO">
        </div>
        <li><a href="" class="active-nav"><?php echo htmlspecialchars($translations['main-page']); ?></a></li>
        <li><a href="about.php?lang=<?php echo htmlspecialchars($lang); ?>"><?php echo htmlspecialchars($translations['team']); ?></a></li>
        <li><a href="projects.php?lang=<?php echo htmlspecialchars($lang); ?>"><?php echo htmlspecialchars($translations['projects']); ?></a></li>
        <li><a href="events.php?lang=<?php echo htmlspecialchars($lang); ?>"><?php echo htmlspecialchars($translations['events']); ?></a></li>
        <li><a href="join-us.php?lang=<?php echo htmlspecialchars($lang); ?>"><?php echo htmlspecialchars($translations['recruitment']); ?></a></li>
        <li class="icon" >
            <a href="javascript:void(0);" onclick="toggleMenu()" id="hamburger">
                <i class="fa fa-bars"></i>
            </a>
        </li>
        <li class="flags">
          <div>
            <a href="?lang=pl"><img src="/img/flags/poland.png"></img></a>
            <a href="?lang=en"><img src="/img/flags/briish.png"></img></a>
            <a href="?lang=de"><img src="/img/flags/german.png"></img></a>
          </div>
        </li>
    </ul>
</nav>
<body>
  <div class="main-content">
    <h1>KN ALGO</h1>
    <p>
        <?php echo htmlspecialchars($translations['main-content-1']); ?>
    </p>
    <br/>
    <p>
        <?php echo htmlspecialchars($translations['main-content-2']); ?>
    </p>
    <br/>
    <p>
        <?php echo htmlspecialchars($translations['main-content-3']); ?>
    </p>
  </div>
</body>
<?php
include(__DIR__ . '/includes/footer.php');
?>
