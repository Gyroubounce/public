// Ouvrir la modale lorsque l'utilisateur clique sur l'icône
document.getElementById('openModal').addEventListener('click', function() {
    document.getElementById('modalScreen').style.display = 'block';
});

// Fermer la modale lorsque l'utilisateur clique sur le bouton "X"
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('modalScreen').style.display = 'none';
});

// Fermer la modale si l'utilisateur clique en dehors de la modale
window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('modalScreen')) {
        document.getElementById('modalScreen').style.display = 'none';
    }
});
