import './bootstrap';
import { createIcons, icons } from 'lucide';

function renderIcons() {
    createIcons({ icons });
}

document.addEventListener('DOMContentLoaded', renderIcons);

if (typeof Livewire !== 'undefined') {
    document.addEventListener('livewire:navigated', renderIcons);
    document.addEventListener('livewire:morph.updated', renderIcons);
}

document.addEventListener('livewire:init', () => {
    if (window.Livewire) {
        Livewire.hook('morph.updated', () => {
            renderIcons();
        });

        // Sesi kedaluwarsa (419): arahkan ke halaman login
        Livewire.hook('request', ({ fail }) => {
            fail(({ status, preventDefault }) => {
                if (status === 419) {
                    preventDefault();
                    window.location.href = '/login';
                }
            });
        });
    }
});