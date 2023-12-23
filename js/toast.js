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

function mostrarSenha() {
    var senhaInput = document.getElementById("pass");
    var olhoIcon = document.getElementById("olho");

    if (senhaInput.type === "password") {
        senhaInput.type = "text";
        olhoIcon.src = "https://cdn0.iconfinder.com/data/icons/ui-icons-pack/100/ui-icon-pack-15-512.png"; // ícone de olho aberto
    } else {
        senhaInput.type = "password";
        olhoIcon.src = "https://cdn0.iconfinder.com/data/icons/ui-icons-pack/100/ui-icon-pack-14-512.png"; // ícone de olho fechado
    }
}

document.getElementById('btnConvidado').addEventListener('click', function() {
    // Atualiza o valor do campo oculto "modo"
    document.querySelector('input[name="modo"]').value = "convidado";
    document.querySelector('.login-form').submit();
});

document.getElementById('btnEntrar').addEventListener('click', function() {
    // Atualiza o valor do campo oculto "modo"
    document.querySelector('input[name="modo"]').value = "entrar";
    document.querySelector('.login-form').submit();
});

document.getElementById('btnCadastro').addEventListener('click', function() {
    // Atualiza o valor do campo oculto "modo"
    document.querySelector('input[name="modo"]').value = "cadastro";
    document.querySelector('.login-form').submit();
});