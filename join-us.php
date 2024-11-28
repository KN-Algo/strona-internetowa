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
    <title><?php echo htmlspecialchars($translations['title-join-us-page']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/navbar.js"></script>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/join-us.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/img/favicos/favicon-48x48.png" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="/img/favicos/favicon.svg" />
    <link rel="shortcut icon" href="/img/favicos/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicos/apple-touch-icon.png" />
    <link rel="manifest" href="/img/favicos/site.webmanifest" />

</head>
<nav>
    <ul class="topnav" id="nav-menu">
        <div class="logo" onclick="window.location.replace('/index.php?lang=<?php echo htmlspecialchars($lang); ?>')">
          <img src="/img/logos/logo-white.png" alt="KN ALGO">
        </div>
        <li><a href="/index.php?lang=<?php echo htmlspecialchars($lang); ?>" ><?php echo htmlspecialchars($translations['main-page']); ?></a></li>
        <li><a href="about.php?lang=<?php echo htmlspecialchars($lang); ?>"><?php echo htmlspecialchars($translations['team']); ?></a></li>
        <li><a href="projects.php?lang=<?php echo htmlspecialchars($lang); ?>"><?php echo htmlspecialchars($translations['projects']); ?></a></li>
        <li><a href="events.php?lang=<?php echo htmlspecialchars($lang); ?>"><?php echo htmlspecialchars($translations['events']); ?></a></li>
        <li><a href="#" class="active-nav"><?php echo htmlspecialchars($translations['recruitment']); ?></a></li>
        <li class="icon" >
            <a href="javascript:void(0);" onclick="toggleMenu()" id="hamburger">
                <i class="fa fa-bars"></i>
            </a>
        </li>
        <li class="idk-what-im-doing"></li>
    </ul>
</nav>
<body>
    <h1><?php echo htmlspecialchars($translations['recrutation-contact']); ?></h1>
    <p><?php echo htmlspecialchars($translations['description-recrutation']); ?></p>
    <form id="contact-form">
        <input type="hidden" name="lang" value="<?php echo htmlspecialchars($lang); ?>">
        <label for="name"><?php echo htmlspecialchars($translations['name']); ?>:</label>
        <input type="text" id="name" name="name" required>
        <label for="email"><?php echo htmlspecialchars($translations['email']); ?>:</label>
        <input type="email" id="email" name="email" required>
        <label for="subject"><?php echo htmlspecialchars($translations['subject']); ?>:</label>
        <input type="text" id="subject" name="subject" required>
        <label for="message"><?php echo htmlspecialchars($translations['message']); ?>:</label>
        <textarea id="message" name="message" required></textarea>
        <button type="submit"><?php echo htmlspecialchars($translations['send']); ?></button>
    </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LdQalkqAAAAAOAaZ72UetAF-LTDiDhcM1Pv5P0J"></script>
<script>
    const contact = document.getElementById("contact-form");
    contact.addEventListener("submit", (e) => {
        e.preventDefault();
        let recaptcha = false;
        grecaptcha.ready(function () {
            grecaptcha.execute('6LdQalkqAAAAAOAaZ72UetAF-LTDiDhcM1Pv5P0J', {action: 'submit'}).then(function (token) {
                const dataR = new FormData();
                dataR.append("token", token);
                fetch("/src/api/recaptcha.php", {
                    method: "POST",
                    body: dataR
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.success)
                            recaptcha = true;
                    })
                     .then(() => {
                         if (recaptcha) {
                             registerUser();
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: '<?php echo htmlspecialchars($translations['title-error']); ?>',
                                text: '<?php echo htmlspecialchars($translations['recaptcha-error']); ?>',
                                footer: '<?php echo htmlspecialchars($translations['no-bots']); ?>'
                            })
                        }
                    })
            });
        });

        function registerUser() {
            const formData = new FormData(contact);
            // console.log(formData);
            fetch("src/api/sendContactMail.php", {
                method: "POST",
                body: formData
            })
               .then(
                   Swal.fire({
                       icon: 'info',
                       title: '<?php echo htmlspecialchars($translations['title-please-wait']); ?>',
                       text: '<?php echo htmlspecialchars($translations['sending']); ?>',
                       allowOutsideClick: false,
                       allowEscapeKey: false,
                       allowEnterKey: false,
                       showConfirmButton: false,
                       timer: 5000
                   })
               )
               .then(response => response.json())
               .then(data => {
                   Swal.fire({
                       icon: data.icon,
                        title: data.title,
                       text: data.message,
                   })
                   .then(() => {
                       if (data.icon === "success") {
                           contact.reset();
                       }
                   });
               })
               .catch(error => {
                   console.error(error);
               });
        }
    });
</script>
<?php
include(__DIR__ . '/includes/footer.php');
?>
