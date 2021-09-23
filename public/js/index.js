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

// ╚╚ Manage the copy archived by AJAX
// Selector
const switchArchive = document.querySelectorAll(".switchArchive");
// Archive the copy if click on the button
for (let elem of switchArchive) {
    elem.addEventListener('click', function (e) {
        e.preventDefault();
        if (confirm("Etes-vous sûr d'archiver cette bd ?")) {
            // Initialize datas
            token = this.attributes.value.value;
            url = this.href;
            // AJAX method fetch
            fetch(url, {
                method: 'POST',
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ "token": token })
            }).then(
                // Get the JSON response
                response => response.json()
            ).then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    // Change the button by archived data
                    if (data.success == true) {
                        this.firstElementChild.attributes.src.nodeValue = "/img/switchOn.png";
                    } else {
                        this.firstElementChild.attributes.src.nodeValue = "/img/switchOff.png";
                    }
                }
            }).catch(e => alert('ereur' + e));
        };
    });
};
