<?php 
  include '../includes/header.php'; 
  include '../includes/navbar.php'; 
?>

<main> 
  <section class="projects-section py-5 bg-light">
    <div class="container">
      <h2 class="section-title text-center mb-5">Nasze projekty</h2>
      <div class="accordion" id="projects-accordion">
        <!-- Dynamiczne wpisy tutaj -->
      </div>

       
    </div>
    <br><br><hr><br><br>
    
   <div class="container">
  <h2 class="section-title text-center mb-5">Nadchodzące projekty</h2>
  <div class="accordion" id="mip_projects-accordion">
    <!-- Dynamiczne wpisy tutaj -->
  </div>
</div>
  </section>
</main>


<!-- Modal pełnoekranowy ze zdjęciami -->
<div class="modal fade" id="fullImageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen modal-dialog-centered">
    <div class="modal-content bg-dark border-0 position-relative">
      <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" id="closeFullImageModal" aria-label="Zamknij"></button>
      <div class="modal-body d-flex justify-content-center align-items-center p-0">
        <div id="fullImageCarousel" class="carousel slide w-100" data-bs-ride="carousel">
          <div class="carousel-inner" id="fullImageCarouselInner">
            <!-- Zdjęcia z projektu -->
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

<?php include '../includes/footer.php'; ?>
