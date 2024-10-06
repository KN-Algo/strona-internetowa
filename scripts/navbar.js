function toggleMenu() {
    var x = document.getElementById("nav-menu");
    let logo = document.querySelector("nav img");
    if (x.className === "topnav") {
        x.className += " responsive";
        logo.hidden = true;
    } else {
        x.className = "topnav";
        logo.hidden = false;
    }
}
