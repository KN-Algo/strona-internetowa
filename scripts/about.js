let person_onclick = function() {
  if(this.clicked == undefined) {
    this.clicked = false;
  }

  if(!this.clicked) {
    this.classList.add("person-container-checked")
  } else {
    this.classList.remove("person-container-checked")
  }

  this.clicked = !this.clicked;
}

document.querySelectorAll(".person-container").forEach((e) => e.onclick = person_onclick)
