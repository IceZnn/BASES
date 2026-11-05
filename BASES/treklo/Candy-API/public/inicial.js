$(document).ready(function() {
    console.log("Token no inicial:", $.cookie("token")); 
    $("#salvaBotao").click(function(e) {
        e.preventDefault();

        const formData = new FormData();

        formData.append('token', $.cookie("token"));
        formData.append('Nome', $("#inputNome").val());
        formData.append('Sabor', $("#inputSabor").val());
        formData.append('Preco', $("#inputPreco").val());
        formData.append('Quantidade', $("#inputQuantidade").val());
        formData.append('Alergicos', $("#inputAlergicos").val());
        formData.append('Ingredientes', $("#inputIngredientes").val());
        formData.append('Descricao', $("#inputDescricao").val());

        const imagemInput = document.getElementById('inputImagem');
        if (imagemInput && imagemInput.files && imagemInput.files[0]) {
            formData.append('imagem', imagemInput.files[0]);
        }

        $.ajax({
            url: "http://127.0.0.1:8000/api/salva_doce",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                console.log(res);
                $("#doceForm")[0].reset();
                Swal.fire("Sucesso!", "Doce salvo com sucesso.", "success");
            },
            error: function(error) {
                Swal.fire("Deu não fiote", "Erro ao salvar.", "error");
                console.log(error);
            }
        });
    });
});