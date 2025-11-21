<?php 
  include 'includes/header.php'; 
  include 'includes/navbar.php'; 
?>

<main>
  <!-- Hero section -->
  <section class="hero-section text-center text-white d-flex align-items-center justify-content-center position-relative">
    <div id="particles-js" class="position-absolute top-0 start-0 w-100 h-100 z-0"></div>
    <div class="container position-relative z-1">
      <h1 data-i18n="home.title">Koło Naukowe Algo</h1>
      <p class="lead" data-i18n="home.motto">Piękno teorii, siła praktyki!</p>
    </div>

  </section>

  <!-- About section -->
  <div class="about-wrapper">
    <section class="about-section container">
      <h2 class="section-title">
        <i class="bi bi-code-slash me-2"></i> <span data-i18n="home.about_title">Poznajmy się!</span>
      </h2>
      <div class="section-divider"></div>
      <p data-i18n="home.about_p1">
        Koło Naukowe Algo zrzesza studentów chcących poszerzać swoje horyzonty, chętnych do rozwoju w różnych dziedzinach nauki.
      </p>
      <p data-i18n="home.about_p2">
        Naszym celem jest tworzenie nowych rozwiązań współczesnych problemów z wykorzystaniem technologii i algorytmów matematycznych.
      </p>
      <p data-i18n="home.about_p3">
        Poprzez współpracę i innowacje zmieniamy otaczającą nas rzeczywistość.
      </p>
    </section>
  </div>



  <!-- Sekcja aktualności z tłem -->
  <section class="news-section position-relative">
  <div class="container position-relative z-1">
    <h2 class="section-title text-center mb-5" data-i18n="home.news_title">Aktualności</h2>
    <div class="row justify-content-center g-4" id="news-carousel">
      <!-- Kafelki -->
    </div>
  </div>
</section>
</main>



<?php include 'includes/footer.php'; ?>
