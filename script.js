document.querySelectorAll('.faq-question').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var answer = this.nextElementSibling;
        var isOpen = this.getAttribute('aria-expanded') === 'true';

        document.querySelectorAll('.faq-question').forEach(function(b) {
            b.setAttribute('aria-expanded', 'false');
            b.nextElementSibling.classList.remove('open');
        });

        if (!isOpen) {
            this.setAttribute('aria-expanded', 'true');
            answer.classList.add('open');
        }
    });
});

var btnShowMore = document.getElementById('btn-show-more');
var isExpanded = false;

btnShowMore.addEventListener('click', function() {
    var extras = document.querySelectorAll('.faq-extra');

    isExpanded = !isExpanded;

    extras.forEach(function(item) {
        item.classList.toggle('hidden');
    });

    btnShowMore.textContent = isExpanded ? 'Ver menos' : 'Ver mais perguntas';
});