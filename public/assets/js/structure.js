function addPanier(event, id) {
    var panier = document.querySelector('#nombreArticles');
    event.preventDefault();

    fetch('/addPanier', {
        method: 'post',
        body: id
    })
        .then(function (result) {
            return result.json();
        }).then(function (result) {
            panier.textContent = result.nombreArticles;
        })
        .catch(error => { throw (error) })
}

function supprimerArticle(event, id) {
    var panier = document.querySelector('#nombreArticles');
    event.preventDefault();

    fetch('/supp', {
        method: 'post',
        body: id
    })
        .then(function (result) {
            return result.json();
        })
        .then(function (result) {
            let cible = document.querySelector('[data-id="' + id + '"]');
            panier.textContent = result.nombreArticles;
            if (result.nombreArticles !== 0) {
                cible.remove();
            } else {
                window.location.reload();
            }
        })
        .catch(error => { throw (error) })
}

document.addEventListener('DOMContentLoaded', function () {
    var searchBar = document.querySelector('#searchBar');

    searchBar.addEventListener('input', function (event) {
        var produits = document.querySelectorAll('.searchCards');
        produits.forEach(produit => {
            let nom = produit.getAttribute('data-nom').toLowerCase();
            if (!nom.includes(event.target.value)) {
                produit.style.display = 'none';

                if (produit.length <= 0) {
                    produit.textContent = '<p> Aucun produit n\'a été trouvé </p>';
                }
            } else {
                produit.style.display = 'block';
            }
        });
    });
});