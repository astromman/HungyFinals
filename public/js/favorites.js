document.addEventListener('DOMContentLoaded', function () {
    const favoriteButtons = document.querySelectorAll('.toggle-favorite');
    const favoritesContainer = document.getElementById('favoritesContainer');
    const noFavoritesMessage = document.getElementById('noFavoritesMessage');

    favoriteButtons.forEach(button => {
        const productCard = button.closest('.product-card');
        const productName = productCard.querySelector('h4 a').textContent.trim();

        // Set the initial state of the heart icon
        if (isProductInFavorites(productName)) {
            button.querySelector('i').classList.add('active');
        }

        button.addEventListener('click', function (event) {
            event.preventDefault();

            if (button.querySelector('i').classList.contains('active')) {
                removeFavorite(productName);
                button.querySelector('i').classList.remove('active');
            } else {
                addFavorite(productCard.outerHTML, productName);
                button.querySelector('i').classList.add('active');
            }

            displayFavorites();
        });
    });

    function addFavorite(productHTML, productName) {
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        // Prevent duplicates by checking if the product already exists
        if (!favorites.some(fav => fav.includes(productName))) {
            favorites.push(productHTML);
            localStorage.setItem('favorites', JSON.stringify(favorites));
        }
    }

    function removeFavorite(productName) {
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        favorites = favorites.filter(fav => !fav.includes(productName));
        localStorage.setItem('favorites', JSON.stringify(favorites));
    }

    function isProductInFavorites(productName) {
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        return favorites.some(fav => fav.includes(productName));
    }

    function displayFavorites() {
        let favorites = JSON.parse(localStorage.getItem('favorites')) || [];

        if (favorites.length === 0) {
            noFavoritesMessage.style.display = 'block';
            favoritesContainer.innerHTML = '';
        } else {
            noFavoritesMessage.style.display = 'none';
            favoritesContainer.innerHTML = favorites.join('');
        }
    }

    displayFavorites();
});
