// Máscara para CPF: XXX.XXX.XXX-XX
function mascararCPF(campo) {
    let valor = campo.value.replace(/\D/g, ''); // Remove tudo que não é número

    if (valor.length > 9) {
        campo.value = valor.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2})$/, "$1.$2.$3-$4");
    } else if (valor.length > 6) {
        campo.value = valor.replace(/^(\d{3})(\d{3})(\d{0,3})$/, "$1.$2.$3");
    } else if (valor.length > 3) {
        campo.value = valor.replace(/^(\d{3})(\d{0,3})$/, "$1.$2");
    } else {
        campo.value = valor; // Digitação inicial
    }
}