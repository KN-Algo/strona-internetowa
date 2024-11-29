function getJSON(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.responseType = 'json';
    xhr.onload = function() {
      var status = xhr.status;
      if (status === 200) {
        callback(null, xhr.response);
      } else {
        callback(status, xhr.response);
      }
    };
    xhr.send();
};


function create_person_container(person) {
  let html = `
  <div class="person-container">
    <div>
      <img src="${person.img}"></img>
    </div>
    <h2>${person.name}</h2>
  </div>`

  document.querySelector(".person-grid").innerHTML += html;
}


let members = getJSON("src/members/members.json", (err, data) => {
  if(err != null) {
    console.err(err);
    return;
  }

  data.members.forEach(e => {
    create_person_container(e);
  });
});
