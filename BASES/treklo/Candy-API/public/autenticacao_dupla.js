$(document).ready(function() {
    const params = new URLSearchParams(window.location.search);
    const emailParam = params.get('email');

    if (emailParam) {
        $('#email').val(emailParam);
    }

    $('#enviar_codigo').click(function() {
        const codigo = $('#codigo').val();
        const email = $('#email').val();

        if (!email || !codigo) {
            alert('Preencha o e-mail e o código.');
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/api/enviar_codigo',
            data: {
                codigo: codigo,
                email: email,
            },
            dataType: 'json',
            success: function(response) {
                if (response.erro === 'n') {
                    $.cookie('token', response.token, { expires: 7, path: '/' });
                    alert('Código válido! Você será redirecionado.');
                    window.location.href = '/Inicio';
                } else {
                    alert(response.data || 'Erro ao validar o código.');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert((response && response.data) ? response.data : 'Erro ao validar o código.');
            }
        });
    });
});