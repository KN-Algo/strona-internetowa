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

  
 
  <!-- Sekcja aktualności z tłem -->
  <section class="news-section position-relative">
  <div class="container position-relative z-1">
    <h2 class="section-title text-center mb-5">Aktualności</h2>
    <div class="row justify-content-center g-4" id="news-carousel">
      <!-- Kafelki -->
    </div>
  </div>
</section>
</main>

<!-- [RECRUITMENT MODAL - TEMP START] Popup on homepage -->
<div class="modal fade recruitment-modal" id="recruitmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="poster-wrapper mx-auto">
          <img src="img/events/algo_rekru.webp" alt="Rekrutacja do Koła Naukowego Algo" class="poster-img" loading="eager">
        </div>
      </div>
      <div class="modal-footer recruitment-footer">
        <a class="btn btn-recruitment btn-lg w-100" href="https://docs.google.com/forms/d/e/1FAIpQLSdrH77bBYWOwYfHsaS_MdbeBNQkQLhAsgrdQtlPtBoWAfq72g/viewform?usp=header">
          Dołącz – formularz rekrutacyjny
        </a>
      </div>
    </div>
  </div>
</div>
<!-- Global close button fixed to viewport corner -->
<button type="button" class="recruitment-close-global" aria-label="Zamknij"></button>
<!-- [RECRUITMENT MODAL - TEMP END] -->

<?php include 'includes/footer.php'; ?>
