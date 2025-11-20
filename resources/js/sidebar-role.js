// Setup sidebar menu visibility based on user role
// This can be called from any page

import { onAuthChange } from './auth.js';

// Apply role-based menu immediately without waiting
function applyRoleBasedMenu(userRole) {
    const isAdmin = userRole === 'admin';
    
    // Batch DOM queries for better performance
    const elements = {
        sidebarKasir: document.getElementById('sidebarKasirItem'),
        sidebarRiwayat: document.getElementById('sidebarRiwayatItem'),
        sidebarPencatatan: document.getElementById('sidebarPencatatanItem'),
        sidebarMenuCrud: document.getElementById('sidebarMenuCrudItem'),
        bottomNavKasir: document.getElementById('bottomNavKasir'),
        bottomNavRiwayat: document.getElementById('bottomNavRiwayat'),
        bottomNavPencatatan: document.getElementById('bottomNavPencatatan'),
        bottomNavMenuCrud: document.getElementById('bottomNavMenuCrud')
    };

    // Use requestAnimationFrame for smoother updates
    requestAnimationFrame(() => {
        if (isAdmin) {
            // Admin sees all items
            if (elements.sidebarKasir) elements.sidebarKasir.style.display = 'block';
            if (elements.sidebarRiwayat) elements.sidebarRiwayat.style.display = 'block';
            if (elements.sidebarPencatatan) elements.sidebarPencatatan.style.display = 'block';
            if (elements.sidebarMenuCrud) elements.sidebarMenuCrud.style.display = 'block';
            if (elements.bottomNavKasir) elements.bottomNavKasir.style.display = 'flex';
            if (elements.bottomNavRiwayat) elements.bottomNavRiwayat.style.display = 'flex';
            if (elements.bottomNavPencatatan) elements.bottomNavPencatatan.style.display = 'flex';
            if (elements.bottomNavMenuCrud) elements.bottomNavMenuCrud.style.display = 'flex';
        } else {
            // Kasir only sees Kasir and Riwayat (already hidden by default CSS)
            if (elements.sidebarKasir) elements.sidebarKasir.style.display = 'block';
            if (elements.sidebarRiwayat) elements.sidebarRiwayat.style.display = 'block';
            if (elements.bottomNavKasir) elements.bottomNavKasir.style.display = 'flex';
            if (elements.bottomNavRiwayat) elements.bottomNavRiwayat.style.display = 'flex';
            // Pencatatan and MenuCrud remain hidden
        }
    });
}

export function setupSidebarByRole() {
    onAuthChange((user) => {
        if (!user) return;
        const userRole = user.role || 'kasir';
        applyRoleBasedMenu(userRole);
    });
}

// Auto-initialize when document is ready
if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupSidebarByRole);
    } else {
        setupSidebarByRole();
    }
}
