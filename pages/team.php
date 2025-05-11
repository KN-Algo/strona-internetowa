<?php 
  include '../includes/header.php'; 
  include '../includes/navbar.php'; 
?>

<main>
  <!-- Sekcja nagłówka strony -->
  <section class="py-5 text-center bg-light">
    <div class="container">
      <h1 class="display-5 fw-bold">Poznaj nasz zespół</h1>
      <p class="lead">Ludzie, którzy tworzą Koło Naukowe Algo</p>
    </div>
  </section>

  <!-- Sekcja: Zdjęcie grupowe -->
  <section class="group-photo-section">
    <div class="container text-center">
      <div class="group-photo-wrapper">
      <br>
      <img src="../img/kn_algo_grupowe1.webp" alt="Zdjęcie zespołu" class="img-fluid group-photo">
      </div>
    </div>
  </section>

  <!-- Sekcja: Prowadzący -->
  <section class="leaders-section py-5">
    <div class="container">
      <h2 class="section-title">
  Opiekunowie<br><br>
</h2>
      <div class="row align-items-center">
        <div class="col-md-6 text-center">
        <img src="../img/leaders/opiekunowie2.webp" alt="Prowadzący" class="img-fluid leader-main-photo">
        </div>
        <div class="col-md-6">
        <div class="leaders-intro-description">
            <p><strong>dr inż. Jacek Jagodziński i mgr inż. Marta Lampasiak</strong> to duet, który łączy pasję do algorytmów z doświadczeniem dydaktycznym. Od lat inspirują studentów do eksplorowania świata struktur danych, grafów, teorii złożoności i bardziej praktycznych zastosowań algorytmiki.</p>
            <p>Ich wspólne działania to nie tylko prowadzenie koła, ale też organizacja wydarzeń, opieka nad projektami badawczymi i mentoring przyszłych specja.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Pole prowadzących -->
    <section class="leaders-cards-section py-5">
  <div class="container">
    <div class="row justify-content-center g-4">
      
      <!-- M P -->
      <div class="col-md-5">
        <div class="leader-card" onclick="toggleLeaderDescription(this)">
          <img src="../img/leaders/martalampasiak.webp" alt="Marta Lampasiak" class="leader-img mb-3">
          <h5 class="text-center mb-2">mgr inż. Marta Lampasiak</h5>
          <div class="expand-icon">▼</div>
          <div class="leader-description hidden">
            <p>Mgr inż. Marta Lampasiak w 2022 ukończyła kierunek Automatyka i Robotyka na Wydziale Elektroniki. Pracę na Wydziale Informatyki i Telekomunikacji na Politechnice Wrocławskiej podjęła jeszcze w tym samym roku.<br> Prowadzi głównie przedmioty związane z programowaniem i technologiami informatycznymi, jednakże jej obszar zainteresowań badawczych obejmuje: modelowanie i identyfikacja systemów dynamicznych, projektowanie układów sterowania i badania symulacyjne. Aktualnie pracuje nad doktoratem i prowadzi badania naukowe, a ich efekty często prezentuje na międzynarodowych konferencjach naukowych. Praca na PWr pozwala jej na łączenie dwóch aspektów, bez których nie wyobraża sobie swojego życia: zdobywania wiedzy i przekazywania jej innym. Dla mgr inż. Marty Lampasiak praca dydaktyczna, a w tym atmosfera na jej zajęciach, ma równie ważne znaczenie co praca naukowa, o czym świadczy chociażby tytuł laureata w Programie Quintus, w którym to studenci wybierają prowadzących wyróżniających się swoim zaangażowaniem i sposobem prowadzenia zajęć.</p>
          </div>
        </div>
      </div>

      <!-- J J -->
      <div class="col-md-5">
        <div class="leader-card" onclick="toggleLeaderDescription(this)">
          <img src="../img/leaders/jacekjagodzinski.webp" alt="Jacek Jagodzinski" class="leader-img mb-3">
          <h5 class="text-center mb-2">dr inż. Jacek Jagodziński</h5>
          <div class="expand-icon">▼</div>
          <div class="leader-description hidden">
            <p>Dr inż. Jacek Jagodziński ukończył studia na kierunku Automatyka i Robotyka na Wydziale Elektroniki, na Politechnice Wrocławskiej uzyskał również tytuł doktora, a pracę na wspomnianej uczelni rozpoczął w 2017 roku. Prowadzi przedmioty związane z szeroko pojętą automatyką przemysłową, IoT, przetwarzaniem sygnałów i wiele innych. Warto również nadmienić, że jego praca doktorska dotyczyła zagadnień związanych z robotyką. Natomiast w swojej pracy naukowej skupia się głównie na tworzeniu modeli systemów (nie tylko tych związanych z automatyką), ich identyfikacji oraz na ogólnie pojętej estymacji. Dr inż. Jacek Jagodziński jest opiekunem Laboratorium urządzeń i układów automatyki, a jeśli chodzi o jego pracę dydaktyczną najlepszym dowodem jego zaangażowania, a także i pomysłowości dotyczącej wymyślania coraz to nowszych tematów projektów do realizacji, są absolwenci, zarówno studiów inżynierskich, jak i magisterskich, których miał przyjemność być promotorem. Dodatkowo należy nadmienić, że posiada on duże doświadczenie związane z pracą w projektach badawczych.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


  </section>

  <!-- Sekcja: Członkowie (dynamicznie) -->
  <!-- Sekcja: Członkowie (dynamicznie) -->
<section class="members-section py-5 bg-light">
  <div class="container">
    <h2 class="section-title text-center mb-5">Członkowie koła</h2>
    <div class="row g-4 justify-content-center" id="members-container">
      <!-- Wczytane przez JS -->
    </div>
  </div>
</section>
</main>

<?php include '../includes/footer.php'; ?>
