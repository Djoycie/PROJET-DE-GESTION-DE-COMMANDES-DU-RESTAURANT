const formAuthentification = document.getElementById('form-authentification');
const nomAdmin = 'admin';
const mdpAdmin = 'password';

formAuthentification.addEventListener('submit', (e) => {
e.preventDefault();
const nomSaisi = document.getElementById('nom-admin').value;
const mdpSaisi = document.getElementById('mdp-admin').value;

if (nomSaisi === nomAdmin && mdpSaisi === mdpAdmin) {
document.getElementById('message-authentification').innerHTML = 'Authentification réussie !';
// Redirection vers la page d'administration
window.location.href = 'restaurateur.html';
} else {
document.getElementById('message-authentification').innerHTML = 'Nom d\'utilisateur ou mot de passe incorrect !';
}
});