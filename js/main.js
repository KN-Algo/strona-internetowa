console.log("main.js został załadowany!");

// Particles.js na stronie głównej
window.addEventListener('load', () => {
  if (window.particlesJS && document.getElementById('particles-js')) {
    particlesJS.load('particles-js', '/js/particles-config.json', function () {
      console.log('particles.js config loaded');
    });
  }
});

// Aktualności
fetch('../data/news.json')
  .then(response => {
    if (!response.ok) throw new Error("Błąd odpowiedzi: " + response.status);
    return response.json();
  })
  .then(data => {
    const shuffled = data.sort(() => 0.5 - Math.random());
    const container = document.getElementById("news-carousel");
    if (!container) return;

    shuffled.forEach(item => {
      const col = document.createElement("div");
      col.className = "col-12 col-md-6 col-lg-4";

      col.innerHTML = `
        <div class="news-card h-100 d-flex flex-column">
          <img src="${item.image}" alt="${item.title}">
          <div class="news-card-body d-flex flex-column">
            <div>
              <h5 class="news-card-title">${item.title}</h5>
              <p class="news-card-text">${item.description}</p>
            </div>
            <a href="${item.link}" class="btn btn-outline-dark mt-auto">Czytaj więcej</a>
          </div>
        </div>
      `;
      container.appendChild(col);
    });
  })
  .catch(error => {
    console.error("Błąd wczytywania aktualności:", error);
  });

// Członkowie koła – dynamiczne wczytanie
document.addEventListener('DOMContentLoaded', () => {
  const membersContainer = document.getElementById('members-container');

  if (membersContainer) {
    fetch('../data/team.json')
      .then(response => {
        if (!response.ok) throw new Error("Błąd ładowania członków: " + response.status);
        return response.json();
      })
      .then(data => {
        data.forEach(member => {
          const col = document.createElement('div');
          col.className = 'col-12 col-sm-6 col-lg-4 mb-4';

          col.innerHTML = `
            <div class="member-card text-center py-4 px-3 h-100">
              <img src="${member.image}" alt="${member.firstName} ${member.lastName}" class="member-img mb-3">
              <h5 class="member-name mb-0">${member.firstName} ${member.lastName}</h5>
            </div>
          `;

          membersContainer.appendChild(col);
        });
      })
      .catch(error => {
        console.error("Błąd ładowania członków:", error);
      });
  }
});

// Prowadzący – toggle opisu
function toggleLeaderDescription(card) {
  const desc = card.querySelector('.leader-description');
  desc.classList.toggle('expanded');
}
