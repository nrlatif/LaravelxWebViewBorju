<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Kelola Menu - KP Borju</title>
    
    <!-- Preconnect untuk optimasi loading -->
    <link rel="preconnect" href="https://res.cloudinary.com" crossorigin>
    <link rel="preconnect" href="https://firestore.googleapis.com" crossorigin>
    <link rel="dns-prefetch" href="https://res.cloudinary.com">
    <link rel="dns-prefetch" href="https://firestore.googleapis.com">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .menu-crud-container {
            padding: 1rem;
            padding-bottom: 6rem;
            max-width: 1200px;
            margin: 0 auto;
            height: calc(100vh - 60px);
            overflow-y: auto;
        }

        .action-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 27, 39, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #991B27;
            border: 2px solid #991B27;
        }

        .btn-secondary:hover {
            background: #F5F5F5;
        }

        .btn-danger {
            background: #FF6B6B;
            color: white;
        }

        .btn-danger:hover {
            background: #FF5252;
        }

        .search-bar {
            flex: 1;
            min-width: 200px;
        }

        .search-bar input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #E0E0E0;
            border-radius: 6px;
            font-size: 1rem;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #991B27;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .menu-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .menu-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .menu-card-header {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-card-icon {
            font-size: 1.5rem;
        }

        .menu-card-title {
            font-weight: bold;
            flex: 1;
        }

        .menu-card-body {
            padding: 1rem;
        }

        .menu-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .menu-info-label {
            color: #666;
            font-weight: 600;
        }

        .menu-info-value {
            color: #333;
        }

        .menu-card-actions {
            display: flex;
            gap: 0.5rem;
            padding: 0 1rem 1rem;
        }

        .menu-card-actions button {
            flex: 1;
            padding: 0.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background: #2196F3;
            color: white;
        }

        .btn-edit:hover {
            background: #1976D2;
        }

        .btn-delete {
            background: #FF6B6B;
            color: white;
        }

        .btn-delete:hover {
            background: #FF5252;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            font-size: 1.5rem;
            font-weight: bold;
            color: #991B27;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #991B27;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #E0E0E0;
            border-radius: 6px;
            font-size: 1rem;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #991B27;
            box-shadow: 0 0 0 3px rgba(153, 27, 39, 0.1);
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .modal-actions button {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .btn-save {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
        }

        .btn-save:hover {
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: #E0E0E0;
            color: #333;
        }

        .btn-cancel:hover {
            background: #CCC;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #999;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top navbar removed -->

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Bottom Navbar -->
    @include('partials.bottom-navbar')

    <div class="menu-crud-container">
        <!-- Action Bar -->
        <div class="action-bar">
            <button class="btn btn-primary" id="addMenuBtn">+ Tambah Menu</button>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Cari menu...">
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="menu-grid" id="menuGrid">
            <div class="empty-state" style="grid-column: 1/-1;">
                <p>Tidak ada menu</p>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal" id="menuModal">
        <div class="modal-content">
            <div class="modal-header" id="modalTitle">Tambah Menu</div>
            <form id="menuForm">
                <div class="form-group">
                    <label>Nama Menu *</label>
                    <input type="text" id="menuName" required>
                </div>
                <div class="form-group">
                    <label>Kategori *</label>
                    <select id="menuKategori" required style="width: 100%; padding: 0.75rem; border: 2px solid #E0E0E0; border-radius: 6px; font-size: 1rem;">
                        <option value="">Pilih Kategori</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga Beli *</label>
                    <input type="number" id="menuPriceBuy" min="0" required placeholder="Harga modal/beli">
                </div>
                <div class="form-group">
                    <label>Harga Jual *</label>
                    <input type="number" id="menuPrice" min="0" required placeholder="Harga jual ke customer">
                </div>
                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" id="menuStok" min="0" required value="0">
                </div>
                <div class="form-group">
                    <label>Gambar Menu</label>
                    <input type="file" id="menuImage" accept="image/*" style="margin-bottom: 0.5rem;">
                    <div id="imagePreview" style="margin-top: 0.5rem; display: none;">
                        <img id="previewImg" style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover;">
                        <div id="uploadProgress" style="margin-top: 0.5rem; display: none;">
                            <div style="background: #E0E0E0; border-radius: 4px; height: 8px; overflow: hidden;">
                                <div id="progressBar" style="background: linear-gradient(135deg, #991B27 0%, #BD2630 100%); height: 100%; width: 0%; transition: width 0.3s ease;"></div>
                            </div>
                            <p id="progressText" style="margin-top: 0.25rem; font-size: 0.85rem; color: #666;">0%</p>
                        </div>
                    </div>
                    <input type="hidden" id="menuImageUrl">
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea id="menuDescription" rows="3"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn-save">Simpan</button>
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let menuItems = [];
        let editingId = null;
        let unsubscribe = null;

        // NOTE: do not destructure `window.menuFunctions` at top-level (bundle may load later).
        // Access `window.menuFunctions` methods dynamically where needed.

        // Load menu items from Firestore
        async function loadMenuItems() {
            try {
                console.log('[Menu CRUD] Loading menu items from Firestore...');
                const mf = window.menuFunctions || {};
                if (typeof mf.getMenus !== 'function') {
                    throw new Error('menuFunctions.getMenus not available');
                }
                menuItems = await mf.getMenus();
                renderMenuItems();

                // Setup real-time listener if available
                if (typeof mf.onMenusChange === 'function') {
                    unsubscribe = await mf.onMenusChange((updatedMenus) => {
                        menuItems = updatedMenus;
                        renderMenuItems();
                    });
                }
                console.log('[Menu CRUD] Real-time listener initialized');
            } catch (error) {
                console.error('[Menu CRUD] Error loading menu:', error);
                // Fallback to empty array if not authenticated
                menuItems = [];
                renderMenuItems();
            }
        }

        // Render menu items
        function renderMenuItems(items = menuItems) {
            const menuGrid = document.getElementById('menuGrid');

            if (items.length === 0) {
                menuGrid.innerHTML = '<div class="empty-state" style="grid-column: 1/-1;"><p>Tidak ada menu</p></div>';
                return;
            }

            menuGrid.innerHTML = items.map(item => {
                // Optimasi URL Cloudinary dengan transformasi + cache busting
                let optimizedUrl = item.imageUrl;
                if (optimizedUrl && optimizedUrl.includes('cloudinary.com')) {
                    optimizedUrl = optimizedUrl.replace('/upload/', '/upload/w_300,h_300,c_fill,q_auto,f_auto/');
                    // Tambah timestamp untuk prevent caching
                    const separator = optimizedUrl.includes('?') ? '&' : '?';
                    optimizedUrl += `${separator}t=${item.updatedAt || Date.now()}`;
                }
                return `
                <div class="menu-card">
                    <div class="menu-card-header">
                        ${item.imageUrl ? `<img src="${optimizedUrl}" alt="${item.name}" loading="lazy" style="width: 100%; height: 150px; object-fit: cover;">` : `<div style="width: 100%; height: 150px; background: #E0E0E0; display: flex; align-items: center; justify-content: center;">📷</div>`}
                    </div>
                    <div class="menu-card-body">
                        <h3 style="margin: 0.5rem 0; font-size: 1rem;">${item.name}</h3>
                        <div class="menu-info">
                            <span class="menu-info-label">Harga Jual:</span>
                            <span class="menu-info-value">Rp ${new Intl.NumberFormat('id-ID').format(item.price || 0)}</span>
                        </div>
                        <div class="menu-info">
                            <span class="menu-info-label">Harga Beli:</span>
                            <span class="menu-info-value">Rp ${new Intl.NumberFormat('id-ID').format(item.priceBuy || 0)}</span>
                        </div>
                        <div class="menu-info">
                            <span class="menu-info-label">Kategori:</span>
                            <span class="menu-info-value">${item.kategori || '-'}</span>
                        </div>
                        <div class="menu-info">
                            <span class="menu-info-label">Stok:</span>
                            <span class="menu-info-value">${item.stok || 0}</span>
                        </div>
                        <div class="menu-info">
                            <span class="menu-info-label">Deskripsi:</span>
                            <span class="menu-info-value">${item.description || '-'}</span>
                        </div>
                    </div>
                    <div class="menu-card-actions">
                        <button class="btn-edit" onclick="editMenu('${item.id}')">Edit</button>
                        <button class="btn-delete" onclick="deleteMenu_Handler('${item.id}')">Hapus</button>
                    </div>
                </div>
                `;
            }).join('');
        }

        // Open modal for adding
        document.getElementById('addMenuBtn').addEventListener('click', () => {
            editingId = null;
            document.getElementById('modalTitle').textContent = 'Tambah Menu';
            document.getElementById('menuForm').reset();
            document.getElementById('menuImageUrl').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('menuModal').classList.add('active');
        });

        // Edit menu
        function editMenu(id) {
            const item = menuItems.find(m => m.id === id);
            if (!item) return;

            editingId = id;
            document.getElementById('modalTitle').textContent = 'Edit Menu';
            document.getElementById('menuName').value = item.name || '';
            document.getElementById('menuKategori').value = item.kategori || '';
            document.getElementById('menuPriceBuy').value = item.priceBuy || '';
            document.getElementById('menuPrice').value = item.price || '';
            document.getElementById('menuStok').value = item.stok || 0;
            document.getElementById('menuDescription').value = item.description || '';
            document.getElementById('menuImageUrl').value = item.imageUrl || '';
            
            // Show existing image preview with cache busting
            if (item.imageUrl) {
                let previewUrl = item.imageUrl;
                const separator = previewUrl.includes('?') ? '&' : '?';
                previewUrl += `${separator}t=${Date.now()}`;
                document.getElementById('previewImg').src = previewUrl;
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('uploadProgress').style.display = 'none';
            } else {
                document.getElementById('imagePreview').style.display = 'none';
            }
            
            document.getElementById('menuModal').classList.add('active');
        }

        // Handle image upload preview and Cloudinary upload
        document.getElementById('menuImage').addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            try {
                // Show preview immediately
                const preview = document.getElementById('imagePreview');
                const previewImg = document.getElementById('previewImg');
                preview.style.display = 'block';

                // Generate local preview first
                const reader = new FileReader();
                reader.onload = (event) => {
                    previewImg.src = event.target.result;
                };
                reader.readAsDataURL(file);

                // Upload to Cloudinary
                const uploadProgress = document.getElementById('uploadProgress');
                const progressBar = document.getElementById('progressBar');
                const progressText = document.getElementById('progressText');
                
                uploadProgress.style.display = 'block';

                // Use Cloudinary for image upload
                if (!window.imageUploadFunctions) {
                    throw new Error('Image upload functions not loaded. Make sure Vite is running.');
                }
                
                const imageUrl = await window.imageUploadFunctions.uploadImage(file, (percent) => {
                    progressBar.style.width = percent + '%';
                    progressText.textContent = percent + '%';
                });

                // Store the Cloudinary URL
                document.getElementById('menuImageUrl').value = imageUrl;
                // Set preview with fresh URL (no cache busting needed, it's a new upload)
                previewImg.src = imageUrl + '?t=' + Date.now();
                
                // Hide progress after upload
                setTimeout(() => {
                    uploadProgress.style.display = 'none';
                }, 1000);

                console.log('[Menu CRUD] Image uploaded to Cloudinary:', imageUrl);
            } catch (error) {
                console.error('[Menu CRUD] Image upload error:', error);
                await window.KPAlert.error('Gagal upload gambar: ' + error.message, 'Upload Gagal');
                document.getElementById('imagePreview').style.display = 'none';
            }
        });

        // Delete menu
        async function deleteMenu_Handler(id) {
            const confirmed = await window.KPAlert.confirm('Menu ini akan dihapus secara permanen', 'Hapus Menu?');
            if (confirmed) {
                try {
                    console.log('[Menu CRUD] Deleting menu:', id);
                    if (!window.menuFunctions || typeof window.menuFunctions.deleteMenu !== 'function') throw new Error('menuFunctions.deleteMenu not available');
                    await window.menuFunctions.deleteMenu(id);
                    console.log('[Menu CRUD] Menu deleted successfully');
                } catch (error) {
                    console.error('[Menu CRUD] Error deleting menu:', error);
                    await window.KPAlert.error('Gagal menghapus menu: ' + error.message, 'Gagal Menghapus');
                }
            }
        }

        // Close modal
        function closeModal() {
            document.getElementById('menuModal').classList.remove('active');
            editingId = null;
        }

        // Save menu
        document.getElementById('menuForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('menuName').value.trim();
            const kategori = document.getElementById('menuKategori').value;
            const priceBuy = parseInt(document.getElementById('menuPriceBuy').value) || 0;
            const price = parseInt(document.getElementById('menuPrice').value) || 0;
            const stok = parseInt(document.getElementById('menuStok').value) || 0;
            const description = document.getElementById('menuDescription').value.trim();
            const imageUrl = document.getElementById('menuImageUrl').value.trim();

            if (!name || !kategori || price === 0 || priceBuy === 0) {
                await window.KPAlert.warning('Nama, kategori, harga beli, dan harga jual harus diisi!', 'Data Tidak Lengkap');
                return;
            }

            try {
                // Buat object dengan fields yang ada di Firestore
                const menuData = {
                    name: name,
                    kategori: kategori,
                    priceBuy: priceBuy,
                    price: price,
                    stok: stok,
                    description: description,
                    imageUrl: imageUrl || '',
                    updatedAt: Date.now() // Tambah timestamp untuk cache busting
                };

                if (editingId) {
                    console.log('[Menu CRUD] Updating menu:', editingId);
                    if (!window.menuFunctions || typeof window.menuFunctions.updateMenu !== 'function') throw new Error('menuFunctions.updateMenu not available');
                    await window.menuFunctions.updateMenu(editingId, menuData);
                    console.log('[Menu CRUD] Menu updated successfully');
                    await window.KPAlert.success('Menu telah berhasil diperbarui', 'Berhasil Diupdate!');
                } else {
                    console.log('[Menu CRUD] Adding new menu');
                    menuData.createdAt = Date.now(); // Tambah timestamp untuk menu baru
                    if (!window.menuFunctions || typeof window.menuFunctions.addMenu !== 'function') throw new Error('menuFunctions.addMenu not available');
                    await window.menuFunctions.addMenu(menuData);
                    console.log('[Menu CRUD] Menu added successfully');
                    await window.KPAlert.success('Menu baru telah ditambahkan ke daftar', 'Berhasil Ditambahkan!');
                }

                closeModal();
            } catch (error) {
                console.error('[Menu CRUD] Error saving menu:', error);
                await window.KPAlert.error('Gagal menyimpan menu: ' + error.message, 'Gagal Menyimpan');
            }
        });

        // Search
        document.getElementById('searchInput').addEventListener('input', async (e) => {
            const query = e.target.value.trim();

            if (query === '') {
                renderMenuItems(menuItems);
            } else {
                try {
                    console.log('[Menu CRUD] Searching menus:', query);
                    if (!window.menuFunctions || typeof window.menuFunctions.searchMenus !== 'function') throw new Error('menuFunctions.searchMenus not available');
                    const filtered = await window.menuFunctions.searchMenus(query);
                    renderMenuItems(filtered);
                } catch (error) {
                    console.error('[Menu CRUD] Error searching menus:', error);
                    renderMenuItems(menuItems);
                }
            }
        });

        // Close modal when clicking outside
        document.getElementById('menuModal').addEventListener('click', (e) => {
            if (e.target.id === 'menuModal') {
                closeModal();
            }
        });

        // Initialize
        async function init() {
            // Wait for window.menuFunctions to be available
            let attempts = 0;
            while ((!window.menuFunctions || typeof window.menuFunctions.getMenus !== 'function') && attempts < 40) {
                await new Promise(r => setTimeout(r, 100));
                attempts++;
            }

            if (!window.menuFunctions || typeof window.menuFunctions.getMenus !== 'function') {
                console.error('[Menu CRUD] menuFunctions not available on window');
                const menuGrid = document.getElementById('menuGrid');
                if (menuGrid) {
                    menuGrid.innerHTML = '<div class="empty-state" style="grid-column: 1/-1;"><p>Modul menu tidak tersedia. Pastikan `resources/js/app.js` dibundel dan dimuat.</p></div>';
                }
                return;
            }

            console.log('[Menu CRUD] menuFunctions available, starting load...');
            loadMenuItems();
        }

        // Start init
        init();
    </script>
</body>
</html>
