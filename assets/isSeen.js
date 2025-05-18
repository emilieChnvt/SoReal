    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.seen').forEach((btn) => {
        btn.addEventListener('click', function (event) {
            event.preventDefault();


            fetch(this.href)
                .then(response => response.json())
                .then(data => {
                    if (data.isSeen) {
                        const notifElement = document.querySelector('.notifs');
                        if (notifElement) {
                            notifElement.remove();
                        }
                    }
                })
        });
    });
});
