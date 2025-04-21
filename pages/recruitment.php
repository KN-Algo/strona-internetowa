<?php 
  include '../includes/header.php'; 
  include '../includes/navbar.php'; 
?>

<main>
  <section class="contact-hero text-white text-center py-5" style="background-color: #0b0c2a;">
    <div class="container">
      <h2 class="section-title mb-3">Dołącz do nas!</h2>
      <p class="lead">Nasze koło się rozwija i chętnie przyjmujemy nowe osoby. Skontaktuj się z nami!</p>
    </div>
  </section>

  <section class="contact-form-section py-5 bg-light">
    <div class="container">
      <form id="contact-form" method="POST" action="/api/send-mail.php" class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="name" class="form-label">Imię i Nazwisko</label>
          <input type="text" class="form-control" id="name" name="name" required maxlength="100">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Adres e-mail</label>
          <input type="email" class="form-control" id="email" name="email" required maxlength="100">
        </div>

        <div class="mb-3">
          <label for="subject" class="form-label">Temat</label>
          <input type="text" class="form-control" id="subject" name="subject" required maxlength="120">
        </div>

        <div class="mb-4">
          <label for="message" class="form-label">Wiadomość</label>
          <textarea class="form-control" id="message" name="message" rows="6" required maxlength="2000"></textarea>
        </div>

        <input type="hidden" name="token" id="recaptcha-token">
        <button type="submit" class="btn btn-dark">Wyślij wiadomość</button>
      </form>
    </div>
  </section>
</main>

<script src="https://www.google.com/recaptcha/api.js?render=............"></script>
<script>
  document.getElementById("contact-form").addEventListener("submit", function(e) {
    e.preventDefault();
    grecaptcha.ready(function() {
      grecaptcha.execute("TWÓJ_SITE_KEY", {action: "submit"}).then(function(token) {
        document.getElementById("recaptcha-token").value = token;
        e.target.submit();
      });
    });
  });
</script>

<?php include '../includes/footer.php'; ?>
