document.querySelectorAll('.faq-pergunta').forEach(function(btn) {
    btn.addEventListener('click', function() {
        const resposta = this.nextElementSibling;
        const aberta = this.getAttribute('aria-expanded') === 'true';

        document.querySelectorAll('.faq-pergunta').forEach(function(b) {
            b.setAttribute('aria-expanded', 'false');
            b.nextElementSibling.classList.remove('aberta');
        });

        if (!aberta) {
            this.setAttribute('aria-expanded', 'true');
            resposta.classList.add('aberta');
        }
    });
});

const btnVerMais = document.getElementById('btn-ver-mais');

if (btnVerMais) {
    let expandido = false;

    btnVerMais.addEventListener('click', function() {
        const extras = document.querySelectorAll('.faq-extra');

        expandido = !expandido;

        extras.forEach(function(item) {
            item.classList.toggle('oculto');
        });

        btnVerMais.textContent = expandido
            ? 'Ver menos ∧'
            : 'Ver mais perguntas ∨';
    });
}