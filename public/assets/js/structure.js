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
            if(result.nombreArticles !== 0){
                cible.remove();
            } else {
                window.location.reload();
            }
        })
}