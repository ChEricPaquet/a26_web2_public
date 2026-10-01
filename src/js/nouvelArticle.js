document.addEventListener("DOMContentLoaded", () => {
    const inputResume = document.getElementById("resume");
    const resumeCompteur = document.getElementById("resumeCompteur");
    const imagesConteneur = document.getElementById("imagesConteneur");
    const btnAjouterImage = document.getElementById("btnAjouterImage");
    const inputContenu = document.getElementById("contenu");
    const contenuCompteur = document.getElementById("contenuCompteur");

    inputResume.addEventListener("input", (e) => {
        const val = e.target.value;
        resumeCompteur.textContent = `${val.length} / 4096`;
    });

    inputContenu.addEventListener("input", (e) => {
        const val = e.target.value;
        contenuCompteur.innerHTML = `${val.length} / 65&nbsp;535`;
    });

    function mettreAJourNameDesImages() {
        const rows = imagesConteneur.querySelectorAll(".image-input-groupe");
        rows.forEach((row, index) => {
            const input = row.querySelector("input");
            input.name = `images[${index}]`;
        });
    }

    function creerNouvelleLigneImage() {
        const rowDiv = document.createElement("div");
        rowDiv.className = "image-input-groupe card p-2 bg-light border-1";
        rowDiv.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <img src="https://placehold.net/default.svg" class="img-preview-thumb img-thumbnail-ref" alt="Miniature">
                <div class="flex-grow-1">
                    <input type="url" class="form-control form-control-sm image-url-input" placeholder="https://exemple.com/image.jpg" required>
                    <div class="invalid-feedback">Veuillez entrer une URL d'image valide.</div>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm supprimer-img-btn" title="Supprimer l'image">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;

        const urlInput = rowDiv.querySelector(".image-url-input");
        const thumbImg = rowDiv.querySelector(".img-thumbnail-ref");

        urlInput.addEventListener("input", (e) => {
            const val = e.target.value.trim();
            thumbImg.src =
                val !== "" ? val : "https://placehold.net/default.svg";
        });

        const supprimerImgBtn = rowDiv.querySelector(".supprimer-img-btn");
        supprimerImgBtn.addEventListener("click", () => {
            rowDiv.remove();
            mettreAJourNameDesImages();
        });

        imagesConteneur.appendChild(rowDiv);
        mettreAJourNameDesImages();
    }
    creerNouvelleLigneImage();

    btnAjouterImage.addEventListener("click", () => {
        creerNouvelleLigneImage();
    });
});
