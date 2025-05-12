document.querySelectorAll(".share-button").forEach((btn) => {
    btn.addEventListener("click", async () => {
        const shareData = {
            title: btn.dataset.title,
            text: btn.dataset.text,
            url: btn.dataset.url
        };

        const resultPara = btn.closest("div").querySelector(".result"); //closest contient les données title, text, url


        await navigator.share(shareData);
        if (resultPara) resultPara.textContent = "Partagé avec succès !";

    });
});
