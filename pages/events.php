<?php 
  include '../includes/header.php'; 
  include '../includes/navbar.php'; 
?>
<main>
<section class="events-section py-5 bg-light">
  <div class="container">
    <h2 class="section-title text-center mb-5" data-i18n="events.page_title">Wydarzenia</h2>
    <div class="row g-4" id="events-container"></div>
  </div>
</section>

<!-- Modal z opisem wydarzenia -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="eventDescription"></p>
        <div id="eventGallery" class="row mt-4"></div>
      </div>
    </div>
  </div>
</div>

<!-- Modal pełnoekranowy ze zdjęciami -->
<div class="modal fade" id="fullImageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content bg-dark border-0 position-relative">
      <!-- Działa poprawnie: -->
      <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" id="closeFullImageModal" data-i18n-aria="common.close"></button>

      <div class="modal-body d-flex justify-content-center align-items-center p-0">
        <div id="fullImageCarousel" class="carousel slide w-100" data-bs-ride="carousel">
          <div class="carousel-inner" id="fullImageCarouselInner">
            <!-- Zdjęcia wstawiane dynamicznie -->
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#fullImageCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#fullImageCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
</main>
<?php include '../includes/footer.php'; ?>
