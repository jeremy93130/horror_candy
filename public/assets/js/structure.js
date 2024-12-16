function addPanier(event, id) {
    var panier = document.querySelector('#nombreArticles');
    event.preventDefault();

    fetch('/addPanier', {
        method: 'post',
        headers : {
            // 'Content-Type' : 'application/json'
        },
        body: id // {id : id} / {"id" : id}
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
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: id })
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
        var produits = document.querySelectorAll('.div_img_produit');
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


document.addEventListener('DOMContentLoaded', function () {
    let images = document.querySelectorAll('.image-bonbon');

    images.forEach(function (image) {
        image.addEventListener('mouseenter', function () {
            if (!this.querySelector('.addCart')) {
                let id = this.getAttribute('data-id');
                let panier = document.createElement('div');
                panier.className = 'addCart';
                panier.innerHTML = `<div><i class="fa-solid fa-cart-plus addPanier" onclick="addPanier(event, ${id})"></i></div>`;
                this.appendChild(panier);
            }
        });

        image.addEventListener('mouseleave', function () {
            let panier = this.querySelector('.addCart');
            if (panier) {
                panier.remove();
            }
        });
    });
});
