document.querySelectorAll('.reaction').forEach((bouton) => {
    bouton.addEventListener('click', function(event) {
        event.preventDefault();
        fetch(this.href)
            .then(response => response.json())
            .then(data => {

                const type = this.dataset.type; // récupère type réactions

                const countSpan = this.querySelector('.count');
                if (type === 'like') {
                    countSpan.textContent = data.likeCount;
                } else if (type === 'love') {
                    countSpan.textContent = data.loveCount;
                }

                if (data.isLiked) {
                    this.classList.add('bg-white', 'text-black');
                    this.classList.remove('text-gray-400');
                } else {
                    this.classList.remove('bg-white', 'text-black');
                    this.classList.add('text-gray-400');
                }
            })

    });
});
