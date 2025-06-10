import './bootstrap';

import 'flyonui/flyonui';

import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

import Tribute from 'tributejs';
import 'tributejs/dist/tribute.css'

window.Tribute = Tribute;

window.addEventListener('load', function () {
    const notyf = new Notyf({
        types: [
            {
                type: 'info',
                background: '#3b82f6',
                icon: false,
            },
            {
                type: 'success',
                background: '#16a34a', // green
            },
            {
                type: 'error',
                background: '#dc2626', // red
            },
            {
                type: 'warning',
                background: '#facc15', // yellow
            }
        ]
    });

    const body = document.querySelector('body');
    const message = body?.dataset.toastMessage;
    const type = body?.dataset.toastType || 'info';  // default to info if none

    if (message) {
        notyf.open({ type: type, message: message });
    }
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
