<?php 
  include 'includes/header.php'; 
  include 'includes/navbar.php'; 
?>

<main>
  <!-- Hero section -->
  <section class="hero-section text-center text-white d-flex align-items-center justify-content-center position-relative">
    <div id="particles-js" class="position-absolute top-0 start-0 w-100 h-100 z-0"></div>
    <div class="container position-relative z-1">
      <h1>Koło Naukowe Algo</h1>
      <p class="lead">Piękno teorii, siła praktyki!</p>
    </div>
  </section>

  <!-- About section -->
  <div class="about-wrapper">
  <section class="about-section container">
    <h2 class="section-title">
      <i class="bi bi-code-slash me-2"></i> Poznajmy się!
    </h2>
    <div class="section-divider"></div>
    <p>
      Koło Naukowe Algo zrzesza studentów chcących poszerzać swoje horyzonty, chętnych do rozwoju w różnych dziedzinach nauki.
    </p>
    <p>
      Naszym celem jest tworzenie nowych rozwiązań współczesnych problemów z wykorzystaniem technologii i algorytmów matematycznych.
    </p>
    <p>
      Poprzez współpracę i innowacje zmieniamy otaczającą nas rzeczywistość.
    </p>
  </section>
</div>

  <!-- News section -->
  <section class="news-section py-5">
  <div class="container">
    <h2 class="section-title">Aktualności</h2>
    <div class="section-divider"></div>

    <!-- Kontener na dynamiczne kafelki -->
    <div id="news-carousel" class="row g-4">
      <!-- Tu pojawią się dynamiczne kafelki -->
    </div>
  </div>
</section>
</main>

<?php include 'includes/footer.php'; ?>