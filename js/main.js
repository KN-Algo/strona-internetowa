console.log("main.js został załadowany!");

//STRONA GŁÓWNA
window.addEventListener('load', () => {
  // particles.js dla sekcji głównej
  if (window.particlesJS && document.getElementById('particles-js')) {
    particlesJS.load('particles-js', '/js/particles-config.json', function () {
      console.log('particles.js config loaded');
    });
  }
});


// Funkcja do ładowania aktualności
function loadNews() {
  const newsPath = window.i18n ? window.i18n.getDataPath('news') : '../data/news_pl.json';

  fetch(newsPath)
  .then(response => {
    if (!response.ok) throw new Error("Błąd odpowiedzi: " + response.status);
    return response.json();
  })
  .then(data => {
    const container = document.getElementById("news-carousel");
    if (!container) return;

    // Najnowsze wpisy są na dole pliku – odwracamy kolejność
    const sorted = Array.isArray(data) ? [...data].reverse() : [];

    const carouselId = 'newsCarousel';

    // Bazowo tworzymy po 1 karcie na slajd (potem uzupełnimy do 3 przez klonowanie)
    const slidesHTML = sorted.map((item, idx) => `
      <div class="carousel-item${idx === 0 ? ' active' : ''}">
        <div class="row justify-content-center g-3">
          <div class="col-12 col-sm-6 col-lg-4 d-flex">
            <div class="news-card h-100 d-flex flex-column w-100">
              <img src="${item.image}" alt="${item.title}">
              <div class="news-card-body d-flex flex-column">
                <div>
                  <h5 class="news-card-title">${item.title}</h5>
                  <p class="news-card-text">${item.description}</p>
                </div>
                <a href="${item.link}" class="btn btn-outline-dark mt-auto">Czytaj więcej</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    `).join('');

    const indicatorsHTML = sorted.map((_, idx) => `
      <button type="button" data-bs-target="#${carouselId}" data-bs-slide-to="${idx}" ${idx === 0 ? 'class="active" aria-current="true"' : ''} aria-label="Slide ${idx + 1}"></button>
    `).join('');

    // Użyjemy trybu fade, aby uzyskać płynniejsze przejścia bez znikania elementów
    container.innerHTML = `
      <div id="${carouselId}" class="carousel slide carousel-fade" data-bs-touch="true" data-bs-interval="false">
        <div class="carousel-inner">
          ${slidesHTML}
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Poprzednie</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Następne</span>
        </button>
        <div class="carousel-indicators">${indicatorsHTML}</div>
      </div>
    `;

    // Multi-item: uzupełnij każdy slajd do 3 kart przez sklonowanie kolejnych elementów
    const minPerSlide = 3;
    const items = container.querySelectorAll(`#${carouselId} .carousel-item`);
    items.forEach((el) => {
      let next = el.nextElementSibling;
      for (let i = 1; i < minPerSlide; i++) {
        if (!next) next = items[0];
        const clone = next.querySelector('.col-12').cloneNode(true);
        el.querySelector('.row').appendChild(clone);
        next = next.nextElementSibling;
      }
    });

    // --- Dodano: automatyczne przewijanie karuzeli gdy jest w widoku + obsługa scroll (kółko myszy)
    // Pobierz element karuzeli i stwórz instancję Bootstrap Carousel z interwałem
    const carouselEl = document.getElementById(carouselId);
    if (carouselEl) {
      // Ustawiamy instancję z interwałem (ms) i bez automatycznego startu
      const bsCarousel = new bootstrap.Carousel(carouselEl, { interval: 4000, ride: false, pause: false });

      // Auto-start tylko gdy karuzela jest widoczna (oszczędza CPU i UX)
      let autoSliding = false;
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && entry.intersectionRatio > 0.35) {
            if (!autoSliding) {
              bsCarousel.cycle();
              autoSliding = true;
            }
          } else {
            if (autoSliding) {
              bsCarousel.pause();
              autoSliding = false;
            }
          }
        });
      }, { threshold: [0, 0.2, 0.35, 0.6, 1] });

      observer.observe(carouselEl);

      // Pauzuj przy najechaniu myszką, wznów po opuszczeniu
      carouselEl.addEventListener('mouseenter', () => bsCarousel.pause());
      carouselEl.addEventListener('mouseleave', () => { if (autoSliding) bsCarousel.cycle(); });

      // (Usunięto handler obsługi kółka myszy — preferujemy tylko kliknięcia strzałek dla nawigacji)
    }
  })
  .catch(error => {
    console.error("Błąd wczytywania aktualności:", error);
  });
}

// Wywołaj po załadowaniu i18n
if (window.i18n && window.i18n.translations && Object.keys(window.i18n.translations).length > 0) {
  loadNews();
} else {
  window.addEventListener('DOMContentLoaded', loadNews);
}

// Przeładuj po zmianie języka
window.addEventListener('languageChanged', loadNews);


// ZESPÓŁ
// Członkowie koła
function loadTeam() {
  const membersContainer = document.getElementById('members-container');

  if (membersContainer) {
    // Team.json nie wymaga tłumaczenia (imiona międzynarodowe), więc zawsze ładujemy ten sam plik
    fetch('../data/team.json')
      .then(response => {
        if (!response.ok) throw new Error("Błąd ładowania członków: " + response.status);
        return response.json();
      })
      .then(data => {
        // Wyczyść istniejącą zawartość przed przeładowaniem
        membersContainer.innerHTML = '';
        
        data.forEach(member => {
          const col = document.createElement('div');
          col.className = 'col-12 col-sm-6 col-lg-4 mb-4';

          // Sprawdź czy członek ma stanowisko
          let positionHTML = '';
          if (member.position) {
            const positionKey = `team.${member.position}`;
            const positionText = window.i18n ? window.i18n.t(positionKey) : member.position;
            positionHTML = `<br><b>${positionText}</b>`;
          }

          col.innerHTML = `
            <div class="member-card text-center py-4 px-3 h-100">
              <img src="${member.image}" alt="${member.firstName} ${member.lastName}" class="member-img mb-3" loading="lazy">
              <h5 class="member-name mb-0">${member.firstName} ${member.lastName}${positionHTML}</h5>
            </div>
          `;

          membersContainer.appendChild(col);
        });
      })
      .catch(error => {
        console.error("Błąd ładowania członków:", error);
      });
  }
}

document.addEventListener('DOMContentLoaded', loadTeam);
window.addEventListener('languageChanged', loadTeam);

// Toggle opisu prowadzących
function toggleLeaderDescription(card) {
  const desc = card.querySelector('.leader-description');
  const isExpanded = desc.classList.contains('expanded');

  const isMobile = window.innerWidth < 768;

  if (isMobile) {
    // na mobile: zamknij wszystkie pozostałe
    document.querySelectorAll('.leader-card').forEach(c => {
      if (c !== card) {
        c.classList.remove('active');
        const otherDesc = c.querySelector('.leader-description');
        otherDesc.classList.remove('expanded');
        otherDesc.style.maxHeight = null;
      }
    });
  }

  card.classList.toggle('active');
  desc.classList.toggle('expanded');

  if (!isExpanded) {
    desc.style.maxHeight = desc.scrollHeight + 'px';
  } else {
    desc.style.maxHeight = null;
  }
}

// PROJEKTY

function loadProjects() {
  const projectsAccordion = document.getElementById('projects-accordion');

  if (projectsAccordion) {
    // Wyczyść istniejące projekty przed przeładowaniem
    projectsAccordion.innerHTML = '';

    const projectsPath = window.i18n ? window.i18n.getDataPath('projects') : '../data/projects_pl.json';

    fetch(projectsPath)
    .then(res => res.json())
    .then(data => {
      data.forEach((project, index) => {
        const card = document.createElement('div');
        card.className = 'accordion-item mb-3';

        let imagesHTML = '';

        if (project.images && project.images.length >= 2) {
          const carouselId = `carousel-${index}`;
          const indicators = project.images.map((_, i) =>
            `<button type="button" data-bs-target="#${carouselId}" data-bs-slide-to="${i}" ${i === 0 ? 'class="active"' : ''} aria-label="Slide ${i + 1}"></button>`
          ).join('');

          imagesHTML = `
            <div id="${carouselId}" class="carousel slide mt-4" data-bs-ride="carousel">
              <div class="carousel-indicators">
                ${indicators}
              </div>
              <div class="carousel-inner fixed-carousel">
              ${project.images.map((img, i) => `
                <div class="carousel-item ${i === 0 ? 'active' : ''}">
                  <img src="${img}" class="d-block mx-auto carousel-img" alt="Zdjęcie projektu" data-project-index="${index}">
                </div>
              `).join('')}
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Poprzednie</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Następne</span>
              </button>
            </div>
          `;
        } else if (project.images && project.images.length === 1) {
          imagesHTML = `
            <div class="text-center mt-4">
              <img src="${project.images[0]}" class="img-fluid rounded shadow-sm carousel-img" alt="Zdjęcie projektu" data-project-index="${index}">
            </div>
          `;
        }

        card.innerHTML = `
          <h2 class="accordion-header" id="heading-${index}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${index}" aria-expanded="false" aria-controls="collapse-${index}">
              ${project.title}
            </button>
          </h2>
          <div id="collapse-${index}" class="accordion-collapse collapse" aria-labelledby="heading-${index}" data-bs-parent="#projects-accordion">
            <div class="accordion-body">
              <p>${project.description}</p>
              ${imagesHTML}
            </div>
          </div>
        `;

        projectsAccordion.appendChild(card);
      });


      

      // pełnoekranowy modal tylko dla zdjęć z danego projektu
      document.addEventListener('click', function (e) {
        const img = e.target.closest('.carousel-img');
        if (!img) return;

        const projectIndex = img.getAttribute('data-project-index');
        const allImages = [...document.querySelectorAll(`.carousel-img[data-project-index="${projectIndex}"]`)];
        const clickedIndex = allImages.indexOf(img);

        const carouselInner = document.getElementById('fullImageCarouselInner');
        carouselInner.innerHTML = '';

        allImages.forEach((imgEl, i) => {
          const item = document.createElement('div');
          item.className = `carousel-item${i === clickedIndex ? ' active' : ''}`;
          item.innerHTML = `<img src="${imgEl.src}" class="d-block w-100" alt="Zdjęcie projektu">`;
          carouselInner.appendChild(item);
        });

        const fullModal = new bootstrap.Modal(document.getElementById('fullImageModal'));
        fullModal.show();
      });

      // zamykanie modala przez kliknięcie poza
      document.getElementById('fullImageModal').addEventListener('click', function (e) {
        const content = e.target.closest('.modal-content');
        if (!content) {
          const fullModal = bootstrap.Modal.getInstance(this);
          fullModal.hide();
        }
      });

      document.getElementById('closeFullImageModal').addEventListener('click', function () {
        const fullModal = bootstrap.Modal.getInstance(document.getElementById('fullImageModal'));
        fullModal.hide();
      });
    })
    .catch(err => {
      console.error('Błąd ładowania projektów:', err);
    });
  }
}

document.addEventListener('DOMContentLoaded', loadProjects);
window.addEventListener('languageChanged', loadProjects);

//NADCHODZĄCE PROJEKTY

function loadMipProjects() {
  const mip_projectsAccordion = document.getElementById('mip_projects-accordion');

  if (mip_projectsAccordion) {
    // Wyczyść istniejące projekty przed przeładowaniem
    mip_projectsAccordion.innerHTML = '';

    const mipProjectsPath = window.i18n ? window.i18n.getDataPath('mip_projects') : '../data/mip_projects_pl.json';

    fetch(mipProjectsPath)
    .then(res => res.json())
    .then(data => {
      data.forEach((project, index) => {
        const card = document.createElement('div');
        card.className = 'accordion-item mb-3';

        let imagesHTML = '';

        if (project.images && project.images.length >= 2) {
          const carouselId = `mip-carousel-${index}`;
          const indicators = project.images.map((_, i) =>
            `<button type="button" data-bs-target="#${carouselId}" data-bs-slide-to="${i}" ${i === 0 ? 'class="active"' : ''} aria-label="Slide ${i + 1}"></button>`
          ).join('');

          imagesHTML = `
            <div id="${carouselId}" class="carousel slide mt-4" data-bs-ride="carousel">
              <div class="carousel-indicators">
                ${indicators}
              </div>
              <div class="carousel-inner fixed-carousel">
              ${project.images.map((img, i) => `
                <div class="carousel-item ${i === 0 ? 'active' : ''}">
                  <img src="${img}" class="d-block mx-auto carousel-img" alt="Zdjęcie projektu" data-project-index="mip-${index}">
                </div>
              `).join('')}
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Poprzednie</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Następne</span>
              </button>
            </div>
          `;
        } else if (project.images && project.images.length === 1) {
          imagesHTML = `
            <div class="text-center mt-4">
              <img src="${project.images[0]}" class="img-fluid rounded shadow-sm carousel-img" alt="Zdjęcie projektu" data-project-index="mip-${index}">
            </div>
          `;
        }

        card.innerHTML = `
          <h2 class="accordion-header" id="mip-heading-${index}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#mip-collapse-${index}" aria-expanded="false" aria-controls="mip-collapse-${index}">
              ${project.title}
            </button>
          </h2>
          <div id="mip-collapse-${index}" class="accordion-collapse collapse" aria-labelledby="mip-heading-${index}" data-bs-parent="#mip_projects-accordion">
            <div class="accordion-body">
              <p>${project.description}</p>
              ${imagesHTML}
            </div>
          </div>
        `;

        mip_projectsAccordion.appendChild(card);
      });
    })
    .catch(err => {
      console.error('Błąd ładowania nadchodzących projektów:', err);
    });
  }
}

document.addEventListener('DOMContentLoaded', loadMipProjects);
window.addEventListener('languageChanged', loadMipProjects);



//WYDARZENIA
function loadEvents() {
  const eventsContainer = document.getElementById('events-container');
  const modal = document.getElementById('eventModal') ? new bootstrap.Modal(document.getElementById('eventModal')) : null;

  if (eventsContainer) {
    // Wyczyść istniejące wydarzenia przed przeładowaniem
    eventsContainer.innerHTML = '';

    const eventsPath = window.i18n ? window.i18n.getDataPath('events') : '../data/events_pl.json';

    fetch(eventsPath)
      .then(res => res.json())
      .then(events => {
        const hash = window.location.hash.replace('#', '');
      
        events.forEach(event => {
          const col = document.createElement('div');
          col.className = 'col-12 col-md-6 col-lg-4';
          col.innerHTML = `
            <div class="card h-100 event-card" data-id="${event.id}" style="cursor:pointer;">
              <img src="${event.thumbnail}" class="card-img-top" alt="${event.title}">
              <div class="card-body">
                <h5 class="card-title">${event.title}</h5>
                <p class="card-text">${event.date}</p>
                <a class="read-more" href="#${event.id}">
                  Zobacz więcej <i class="bi bi-arrow-right-circle"></i>
                </a>
              </div>
            </div>
          `;
          col.querySelector('.event-card').addEventListener('click', () => openEventModal(event));
          eventsContainer.appendChild(col);
    
          if (event.id === hash) {
            setTimeout(() => openEventModal(event), 300);
          }
        });
      });
  }
}

document.addEventListener('DOMContentLoaded', loadEvents);
window.addEventListener('languageChanged', loadEvents);

function openEventModal(event) {
  const modal = document.getElementById('eventModal') ? new bootstrap.Modal(document.getElementById('eventModal')) : null;
  
  document.getElementById('eventModalLabel').textContent = event.title;
  document.getElementById('eventDescription').innerHTML = event.description;

  const gallery = document.getElementById('eventGallery');
  gallery.innerHTML = '';
  if (event.images && event.images.length > 0) {
    event.images.forEach(img => {
      const col = document.createElement('div');
      col.className = 'col-md-4 mb-3';
      col.innerHTML = `<img src="${img}" class="img-fluid rounded shadow-sm gallery-image" alt="Zdjęcie wydarzenia">`;
      gallery.appendChild(col);
    });
  }

  if (modal) modal.show();
}

// Klik w zdjęcie – fullscreen
document.addEventListener('click', function (e) {
  if (e.target.matches('.gallery-image')) {
    const images = [...document.querySelectorAll('.gallery-image')];
    const clickedIndex = images.indexOf(e.target);

    const carouselInner = document.getElementById('fullImageCarouselInner');
    carouselInner.innerHTML = '';

    images.forEach((img, i) => {
      const item = document.createElement('div');
      item.className = `carousel-item${i === clickedIndex ? ' active' : ''}`;
      item.innerHTML = `<img src="${img.src}" class="d-block w-100" alt="Zdjęcie wydarzenia">`;
      carouselInner.appendChild(item);
    });

    const fullModal = new bootstrap.Modal(document.getElementById('fullImageModal'));
    fullModal.show();
  }
});

// Klik poza – zamknięcie
const fullImageModal = document.getElementById('fullImageModal');
if (fullImageModal) {
  fullImageModal.addEventListener('click', function (e) {
    const content = e.target.closest('.modal-content');
    if (!content) {
      const fullModal = bootstrap.Modal.getInstance(this);
      fullModal.hide();
    }
  });
}

// Zamknięcie modala przez przycisk X
const closeFullImageModal = document.getElementById('closeFullImageModal');
if (closeFullImageModal) {
  closeFullImageModal.addEventListener('click', function () {
    const fullModal = bootstrap.Modal.getInstance(document.getElementById('fullImageModal'));
    fullModal.hide();
  });
}