console.log('salut');
let collection,
    boutonAjout,
    span;
window.onload = () => {
    collection = document.querySelector("#video");
    span = collection.querySelector("span");
    boutonAjout = document.createElement("button");
    boutonAjout.className = "ajout-video btn btn secondary";
    boutonAjout.innerText = "Ajouter une video";

    let nouveauBouton = span.append(boutonAjout);
    collection.dataset.index = collection.querySelectorAll("input").length;
    boutonAjout.addEventListener("click", function () {
        console.log('click bouton');
        addButton(collection, nouveauBouton);
    })
    function addButton(collection, nouveauBouton) {
        let prototype = collection.dataset.prototype;
        let index = collection.dataset.index;

        prototype = prototype.replace(/__name__/g, index);
        let content = document.createElement("url")
        content.innerHtml = prototype;
        let newForm = content.querySelector("div");
        let boutonSupprimer = document.createElement("buttton");
        boutonSupprimer.type = 'button';
        boutonSupprimer.className = 'btn red';
        boutonSupprimer.id = "-delete-video-" + index;
        boutonSupprimer.innerText = "Supprimer cette video"
        newForm.append(boutonSupprimer);

        collection.dataset.index++;
        let boutonAjout = collection.querySelector("-ajout-video-");
        span.insertBefore(newForm, boutonAjout);

         }
    }