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
    <title><?php echo htmlspecialchars($translations['title-events-page']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/navbar.js"></script>
    <link rel="stylesheet" href="styles/main.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/img/favicos/favicon-48x48.png" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="/img/favicos/favicon.svg" />
    <link rel="shortcut icon" href="/img/favicos/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicos/apple-touch-icon.png" />
    <link rel="manifest" href="/img/favicos/site.webmanifest" />

    <link rel="stylesheet" href="styles/projects.css">
</head>
<nav>
    <ul class="topnav" id="nav-menu">
        <div class="logo" onclick="window.location.replace('/index.php?lang=<?php echo htmlspecialchars($lang); ?>')">
          <img src="/img/logos/logo-white.png" alt="KN ALGO">
        </div>
        <li><a href="/index.php?lang=<?php echo htmlspecialchars($lang); ?>" ><?php echo htmlspecialchars($translations['main-page']); ?></a></li>
        <li><a href="about.php?lang=<?php echo htmlspecialchars($lang); ?>"><?php echo htmlspecialchars($translations['team']); ?></a></li>
        <li><a href="projects.php?lang=<?php echo htmlspecialchars($lang); ?>"><?php echo htmlspecialchars($translations['projects']); ?></a></li>
        <li><a href="" class="active-nav"><?php echo htmlspecialchars($translations['events']); ?></a></li>
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
    <div id="projects-container">
    </div>
</body>
<script>

    window.onload = function() {

        let eventsFile = 'src/content/events-<?php echo htmlspecialchars($lang)?>.json';

        fetch(eventsFile)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const projectsContainer = document.getElementById('projects-container');
                data.events.forEach(event => {
                    const record = document.createElement('div');
                    record.className = 'record';

                    //Create h3 element with project name
                    const name = document.createElement('h3');
                    name.textContent = event.name;
                    record.appendChild(name);

                    //Create p element with short description
                    const shortDescription = document.createElement('p');
                    shortDescription.textContent = event.shortDescription;
                    record.appendChild(shortDescription);

                    //Create div element with hidden content
                    const hiddenDiv = document.createElement('div');
                    hiddenDiv.className = 'hidden';

                    //Create p element with long description
                    const longDescription = document.createElement('p');
                    longDescription.textContent = event.longDescription;
                    hiddenDiv.appendChild(longDescription);

                    //Loop over images array and create img elements
                    event.images.forEach(image => {
                        const img = document.createElement('img');
                        img.src = `img/events/${image.src}`;
                        img.alt = image.alt;
                        img.className = 'hidden-img';
                        hiddenDiv.appendChild(img);
                    });

                    //Append hiddenDiv to record
                    record.appendChild(hiddenDiv);
                    projectsContainer.appendChild(record);

                    record.addEventListener('click', function() {
                        hiddenDiv.classList.toggle('hidden');
                    });
                })
            })
            .catch(error => console.error(error));
    };
</script>
<?php
include(__DIR__ . '/includes/footer.php');
?>

