// Configuração das máscaras
const masks = {
    cpf: new Inputmask("999.999.999-99", { placeholder: "_", clearIncomplete: true }),
    date: new Inputmask("99/99/9999", { placeholder: "_", clearIncomplete: true }),
    phone: new Inputmask("(99) 99999-9999", { placeholder: "_", clearIncomplete: true }),
};

// Função para aplicar a máscara no foco
function applyMaskOnFocus(input, mask) {
    input.addEventListener("focus", () => {
        mask.mask(input); // Aplica a máscara no campo
    });
}

// Aplica as máscaras nos campos ao carregar o DOM
document.addEventListener("DOMContentLoaded", () => {
    applyMaskOnFocus(document.getElementById("cpf"), masks.cpf);
    applyMaskOnFocus(document.getElementById("data_nasc"), masks.date);
    applyMaskOnFocus(document.getElementById("contato"), masks.phone);
});

function validarCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    // Verifica se todos os dígitos são iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    
    // Valida primeiro dígito verificador
    for ($i = 9, $j = 0, $soma = 0; $i > 0; $i--, $j++) {
        $soma += $cpf[$j] * $i;
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;
    
    // Valida segundo dígito verificador
    for ($i = 10, $j = 0, $soma = 0; $i > 1; $i--, $j++) {
        $soma += $cpf[$j] * $i;
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;
    
    // Verifica se os dígitos calculados conferem com os informados
    return ($cpf[9] == $digito1 && $cpf[10] == $digito2);
}

// No processamento:
if(!validarCPF($cpf)) {
    header("Location: cadastrar.php?error=invalid_cpf");
    exit();
}

