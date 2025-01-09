// Envoi du formulaire pour ajouter un article
document.getElementById('form-ajouter-article').addEventListener('submit', (e) => {
    e.preventDefault();
    const nomArticle = document.getElementById('nom-article').value;
    const descriptionArticle = document.getElementById('description-article').value;
    const prixArticle = document.getElementById('prix-article').value;
    const quantiteArticle = document.getElementById('quantite-article').value;
    const imageArticle = document.getElementById('image-article').files[0];
    const formData = new FormData();
    formData.append('nom', nomArticle);
    formData.append('description', descriptionArticle);
    formData.append('prix', prixArticle);
    formData.append('quantite', quantiteArticle);
    formData.append('image', imageArticle);
    fetch('add_article.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => console.log(data));
});
