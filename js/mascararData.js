function mascararData(input) {
    let valor = input.value;
    // Remove tudo que não for número
    valor = valor.replace(/\D/g, '');
    // Adiciona a barra no lugar certo
    if (valor.length > 2) valor = valor.replace(/^(\d{2})(\d)/, '$1/$2');
    if (valor.length > 5) valor = valor.replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3');
    // Limita ao formato DD/MM/AAAA
    input.value = valor.slice(0, 10);
}
