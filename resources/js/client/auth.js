import '../bootstrap';
import { initAddressSelectors } from '../shared/address-selector';

document.addEventListener('DOMContentLoaded', () => {
    initAddressSelectors();

    document.querySelectorAll('[data-auth-shell]').forEach((shell) => {
        const applyState = (panel) => {
            shell.classList.toggle('is-register', panel === 'register');
            shell.dataset.authPanel = panel;
        };

        applyState(shell.dataset.authPanel || 'login');

        shell.querySelectorAll('[data-auth-target]').forEach((button) => {
            button.addEventListener('click', () => {
                applyState(button.dataset.authTarget || 'login');
            });
        });
    });
});
