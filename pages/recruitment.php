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
      <form id="contact-form" class="needs-validation" novalidate>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LeX-TErAAAAAKTVYSlg6zFHadyLOxvxjob3orV4"></script>
<script>
    const contact = document.getElementById("contact-form");
    contact.addEventListener("submit", (e) => {
        e.preventDefault();
        let recaptcha = false;
        grecaptcha.ready(function () {
            grecaptcha.execute('6LeX-TErAAAAAKTVYSlg6zFHadyLOxvxjob3orV4', {action: 'submit'}).then(function (token) {
                const dataR = new FormData();
                dataR.append("token", token);
                fetch("/../src/api/recaptcha.php", {
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
                                title: 'Chwila!',
                                text: 'Robotom wstęp wzbroniony!',
                                footer: 'Test reCAPTCHA nie powiódł się.',
                            })
                        }
                    })
            });
        });

        function registerUser() {
            const formData = new FormData(contact);
            // console.log(formData);
            fetch("/../src/api/sendContactMail.php", {
                method: "POST",
                body: formData
            })
               .then(
                   Swal.fire({
                       icon: 'info',
                       title: 'Proszę czekać...',
                       text: 'Wysyłanie wiadomości...',
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

<?php include '../includes/footer.php'; ?>
