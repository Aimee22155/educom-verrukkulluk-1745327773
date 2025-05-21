document.addEventListener('DOMContentLoaded', () => {
    // Wacht tot de DOM (Document Object Model) volledig geladen is.
    const heart = document.getElementById('favorite-heart');
    // Haalt het HTML-element met de ID 'favorite-heart' op.
    const dishId = '{{ dish.id }}';
    // Definieert de ID van het huidige gerecht.
    const storageKey = 'favorite_dishes';
    // Definieert de sleutel die gebruikt wordt om de favoriete gerechten op te slaan in de lokale opslag van de browser (localStorage).

    // Laad favorieten uit localStorage
    let favorites = JSON.parse(localStorage.getItem(storageKey)) || [];
    // Probeert de opgeslagen favoriete gerechten op te halen uit de localStorage.
    // JSON.parse() converteert de string die is opgeslagen terug naar een JavaScript array.
    // Als er niets is opgeslagen onder de 'storageKey', dan wordt er een lege array ([]) gebruikt.

    // Controleer of dit gerecht favoriet is en update het icoon
    if (favorites.includes(dishId)) {
        heart.classList.remove('fa-heart-o');
        heart.classList.add('fa-heart');
    }

    heart.addEventListener('click', () => {
        // Voegt een event listener toe aan het 'heart' element dat reageert op een klik.
        if (favorites.includes(dishId)) {
            favorites = favorites.filter(id => id !== dishId);
            // Filtert de 'favorites' array om alle IDs te behouden behalve de ID van het huidige gerecht.
            heart.classList.remove('fa-heart');
            // Verwijdert de CSS-klasse voor het gevulde hart.
            heart.classList.add('fa-heart-o');
            // Voegt de CSS-klasse toe voor het lege hart.

        } else {
            favorites.push(dishId);
            // Voegt de ID van het huidige gerecht toe aan de 'favorites' array.
            heart.classList.remove('fa-heart-o');
            // Verwijdert de CSS-klasse voor het lege hart.
            heart.classList.add('fa-heart');
            // Voegt de CSS-klasse toe voor het gevulde hart.
        }
        localStorage.setItem(storageKey, JSON.stringify(favorites));
        // Slaat de bijgewerkte 'favorites' array op in de localStorage.
        // JSON.stringify() converteert de JavaScript array naar een string die opgeslagen kan worden.
    });
});

