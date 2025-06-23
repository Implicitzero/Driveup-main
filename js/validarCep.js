
    function validarCep() {
        const cep = $("input[name='cep']").val().replace("-", "");
        
        if (cep.length === 8 && /^[0-9]+$/.test(cep)) {
            $.ajax({
                url: `https://viacep.com.br/ws/${cep}/json/`,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    if (!data.erro) {
                        $("input[name='endereco']").val(data.logradouro);
                        $("input[name='cidade']").val(data.localidade);
                    } else {
                        alert("CEP não encontrado!");
                    }
                },
                error: function () {
                    alert("Erro ao consultar o CEP.");
                }
            });
        } else {
            alert("CEP inválido! Insira um CEP válido no formato 00000-000.");
        }
    }
