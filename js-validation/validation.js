document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(event) {
        const passwordInput = document.getElementById('password');
        const accountTypeInput = document.getElementById('account_type');

        // Vérification du mot de passe : ne doit pas contenir d'espaces
        if (passwordInput.value.includes(' ')) {
            event.preventDefault();
            document.getElementById("alert-response-password").innerHTML = "Le mot de passe ne doit pas contenir d'espaces.";
            return;
        }

        // Vérification du type de compte
        const validAccountTypes = ["courant", "epargne", "entreprise"];
        if (!validAccountTypes.includes(accountTypeInput.value)) {
            event.preventDefault();
            document.getElementById("alert-response-account").innerHTML = "Type de compte invalide. Choisissez 'courant', 'épargne' ou 'entreprise'.";
            return;
        }
    });

    // Validation pour le formulaire de dépôt
    const depositForm = document.getElementById('deposit-form');
    depositForm.addEventListener('submit', function(event) {
        const depositAmountInput = document.getElementById('deposit-amount');
        const depositAmount = parseFloat(depositAmountInput.value);

        if (depositAmount < 10 || depositAmount > 2000) {
            event.preventDefault(); 
            document.getElementById("alert").innerHTML = "Le montant du dépôt doit être compris entre 10 et 2000.";
            return;
        }
    });

    // Validation pour le formulaire de retrait
    const withdrawalForm = document.getElementById('withdrawal-form');
    withdrawalForm.addEventListener('submit', function(event) {
        const withdrawalAmountInput = document.getElementById('withdrawal-amount');
        const withdrawalAmount = parseFloat(withdrawalAmountInput.value);

        if (withdrawalAmount < 10 || withdrawalAmount > 2000) {
            event.preventDefault();
            document.getElementById("alert").innerHTML = "Le montant du retrait doit être compris entre 10 et 2000.";
            return;
        }
    });
});
