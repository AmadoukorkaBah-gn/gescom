import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('layout', {
    sidebarOpen: false,
    sidebarCollapsed: false,

    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
    },

    closeSidebar() {
        this.sidebarOpen = false;
    },

    toggleCollapse() {
        this.sidebarCollapsed = !this.sidebarCollapsed;
    },
});

Alpine.start();