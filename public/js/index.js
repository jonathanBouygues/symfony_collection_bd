AOS.init();

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