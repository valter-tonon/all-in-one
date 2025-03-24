import './bootstrap';
import '../css/app.css';
import Alpine from 'alpinejs';
import axios from 'axios';

window.Alpine = Alpine;
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Alpine.start();

// Funções utilitárias
document.addEventListener('DOMContentLoaded', () => {
    // Fechar alertas
    document.querySelectorAll('[data-dismiss="alert"]').forEach(button => {
        button.addEventListener('click', () => {
            const alert = button.closest('.alert');
            if (alert) {
                alert.remove();
            }
        });
    });

    // Confirmações de exclusão
    document.querySelectorAll('[data-confirm]').forEach(element => {
        element.addEventListener('click', (e) => {
            const message = element.getAttribute('data-confirm') || 'Tem certeza que deseja realizar esta ação?';
            if (!confirm(message)) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });
}); 