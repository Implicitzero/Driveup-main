// Máscara para número de celular (XX) XXXXX-XXXX
function mascararCelular(campo) {
    let valor = campo.value.replace(/\D/g, ''); // Remove tudo que não é número

    if (valor.length > 10) {
        campo.value = valor.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
    } else if (valor.length > 6) {
        campo.value = valor.replace(/^(\d{2})(\d{4})(\d{0,4})$/, "($1) $2-$3");
    } else if (valor.length > 2) {
        campo.value = valor.replace(/^(\d{2})(\d{0,4})$/, "($1) $2");
    } else {
        campo.value = valor.replace(/^(\d*)$/, "($1");
    }
}

// Máscara para data de nascimento DD/MM/AAAA
// function mascararData(campo) {
//     let valor = campo.value.replace(/\D/g, ''); // Remove tudo que não é número

//     if (valor.length > 4) {
//         campo.value = valor.replace(/^(\d{2})(\d{2})(\d{0,4})$/, "$1/$2/$3");
//     } else if (valor.length > 2) {
//         campo.value = valor.replace(/^(\d{2})(\d{0,2})$/, "$1/$2");
//     } else {
//         campo.value = valor;
//     }
// }