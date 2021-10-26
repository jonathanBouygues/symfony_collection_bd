AOS.init();


// ╚╚╚╚╚╚╚╚╚╚ PAGE ADMIN

// ╚╚ Manage the appear's bloc
// Selecteur
const containerBd = document.querySelector(".containerBd");
const containerEditor = document.querySelector(".containerEditor");
const containerAuthor = document.querySelector(".containerAuthor");
const buttonAdmin = document.querySelectorAll(".buttonAdmin");
// Evenement : au click, apparition du bloc demandé
for (let elem of buttonAdmin) {
    elem.addEventListener('click', function () {
        containerEditor.style.display = "none";
        containerBd.style.display = "none";
        containerAuthor.style.display = "none";
        if (elem.id === "buttonEditor") {
            containerEditor.style.display = "flex";
        } else if (elem.id === "buttonAuthor") {
            containerAuthor.style.display = "flex";
        } else {
            containerBd.style.display = "flex";
        };
    });
};

// ╚╚╚╚╚╚╚╚╚╚ PAGE COPY

// ╚╚ Manage the favorite copy
// Selector
const butFavorite = document.getElementById('actionFavorite');
const trCopyFavorite = document.querySelectorAll('.copyFavorite');
const trCopyNoFavorite = document.querySelectorAll('.copyNoFavorite');


butFavorite.addEventListener('click', function () {
    for (let copy of trCopyNoFavorite) {
        copy.style.display == "none" ? copy.style.display = "" : copy.style.display = "none";

    };
});
