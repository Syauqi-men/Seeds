import './bootstrap';
import { createIcons, icons } from 'lucide';

// ── Lucide icons ─────────────────────────────────────────────
// Render all <i data-lucide="..."> elements into inline SVGs.
// Re-run after Livewire DOM updates.
function renderIcons() {
    createIcons({ icons });
}

document.addEventListener('DOMContentLoaded', renderIcons);

// Livewire re-renders — re-init icons after morphdom patch
if (typeof Livewire !== 'undefined') {
    document.addEventListener('livewire:navigated', renderIcons);
    document.addEventListener('livewire:morph.updated', renderIcons);
}
// Fallback for Livewire 3 hook
document.addEventListener('livewire:init', () => {
    if (window.Livewire) {
        Livewire.hook('morph.updated', ({ el }) => {
            renderIcons();
        });
    }
});