// Função para criar e mostrar o toast
function showToast(message, type) {
    const toastContainer = document.getElementById("toast-container");
    const toast = document.createElement("div");
    toast.className = `toast show-toast ${type}`;
    toast.textContent = message;
    toastContainer.appendChild(toast);

    // Após 3 segundos, ocultar o toast
    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Verifique se há um erro no parâmetro GET
if (location.search.includes("erro=email_invalido")) {
    showToast("O email inserido é inválido!", "erro");
}
if (location.search.includes("erro=login_invalido")) {
    showToast("Atenção ocorreu algum erro de login!", "erro");
}