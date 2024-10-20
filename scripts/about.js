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


function person_onclick() {
  if(this.clicked == undefined) {
    this.clicked = false;
  }

  if(!this.clicked) {
    this.classList.add("person-container-checked");
  } else {
    this.classList.remove("person-container-checked");
  }

  this.clicked = !this.clicked;
}


function create_person_container(person) {
  let main_div = document.createElement("div");
//  main_div.onclick = person_onclick;
  main_div.classList.add("person-container");
  if(person.god) {
    return; //why redesign the code, just make spaghetti instead
  }

  let img_div = document.createElement("div");
  let img = document.createElement("img");
  img.src = person.img;

  let h2 = document.createElement("h2");
  h2.innerHTML = person.name;
  
  img_div.appendChild(img)
  main_div.appendChild(img_div);
  main_div.appendChild(h2);

  document.querySelector(".person-grid").appendChild(main_div);
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
