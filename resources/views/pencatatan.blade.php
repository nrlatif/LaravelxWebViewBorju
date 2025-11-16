<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Pencatatan - KP Borju</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .record-container {
            padding: 1rem;
            padding-bottom: 6rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .record-form {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #991B27;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #E0E0E0;
            border-radius: 6px;
            font-size: 1rem;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #991B27;
            box-shadow: 0 0 0 3px rgba(153, 27, 39, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .form-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s ease;
            flex: 1;
        }

        .btn-submit {
            background: linear-gradient(135deg, #991B27 0%, #BD2630 100%);
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(153, 27, 39, 0.3);
        }

        .btn-reset {
            background: white;
            color: #991B27;
            border: 2px solid #991B27;
        }

        .btn-reset:hover {
            background: #F5F5F5;
        }

        .records-section {
            margin-top: 2rem;
        }

        .records-header {
            font-size: 1.5rem;
            font-weight: bold;
            color: #991B27;
            margin-bottom: 1rem;
        }

        .record-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .record-card {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #991B27;
        }

        .record-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 0.75rem;
        }

        .record-title {
            font-weight: bold;
            color: #333;
            flex: 1;
        }

        .record-date {
            font-size: 0.85rem;
            color: #999;
        }

        .record-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #F0F0F0;
            border-radius: 4px;
            font-size: 0.75rem;
            color: #666;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .record-content {
            color: #666;
            line-height: 1.6;
            margin-bottom: 0.75rem;
        }

        .record-amount {
            font-size: 1.1rem;
            font-weight: bold;
            color: #991B27;
        }

        .record-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }

        .btn-small {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
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

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #999;
        }

        .category-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-label {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #991B27;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top navbar removed -->

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Bottom Navbar -->
    @include('partials.bottom-navbar')

    <div class="record-container">
        <!-- Statistics -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-label">Total Catatan</div>
                <div class="stat-value" id="statTotalRecords">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Pengeluaran</div>
                <div class="stat-value" style="font-size: 1.1rem;" id="statTotalExpense">Rp 0</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Pemasukan</div>
                <div class="stat-value" style="font-size: 1.1rem;" id="statTotalIncome">Rp 0</div>
            </div>
        </div>

        <!-- Form -->
        <div class="record-form">
            <h3 style="color: #991B27; margin-bottom: 1rem;">Tambah Pencatatan</h3>
            <form id="recordForm">
                <div class="form-group">
                    <label>Judul Catatan *</label>
                    <input type="text" id="recordTitle" required placeholder="Cth: Pembelian Bahan">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select id="recordCategory" required>
                            <option value="">Pilih Kategori</option>
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                            <option value="note">Catatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah (Rp)</label>
                        <input type="number" id="recordAmount" min="0" placeholder="0">
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea id="recordDescription" rows="3" placeholder="Masukkan detail catatan..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-submit">Simpan Catatan</button>
                    <button type="reset" class="btn btn-reset">Bersihkan</button>
                </div>
            </form>
        </div>

        <!-- Records List -->
        <div class="records-section">
            <div class="records-header">Daftar Catatan</div>
            <div class="record-list" id="recordList">
                <div class="empty-state">Tidak ada catatan</div>
            </div>
        </div>
    </div>

    <script>
        let records = [];

        // Load records
        function loadRecords() {
            try {
                records = JSON.parse(localStorage.getItem('kp_records')) || [];
                updateStatistics();
                renderRecords();
            } catch (error) {
                console.error('[Pencatatan] Error loading records:', error);
            }
        }

        // Update statistics
        function updateStatistics() {
            const totalExpense = records
                .filter(r => r.category === 'expense')
                .reduce((sum, r) => sum + (r.amount || 0), 0);

            const totalIncome = records
                .filter(r => r.category === 'income')
                .reduce((sum, r) => sum + (r.amount || 0), 0);

            document.getElementById('statTotalRecords').textContent = records.length;
            document.getElementById('statTotalExpense').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(totalExpense)}`;
            document.getElementById('statTotalIncome').textContent = `Rp ${new Intl.NumberFormat('id-ID').format(totalIncome)}`;
        }

        // Render records
        function renderRecords() {
            const recordList = document.getElementById('recordList');

            if (records.length === 0) {
                recordList.innerHTML = '<div class="empty-state">Tidak ada catatan</div>';
                return;
            }

            recordList.innerHTML = records.slice().reverse().map((record, index) => `
                <div class="record-card">
                    <div class="record-header">
                        <div>
                            <div class="record-title">${record.title}</div>
                            <div class="record-date">${record.date}</div>
                        </div>
                    </div>
                    <div>
                        <span class="record-category">${
                            record.category === 'income' ? 'Pemasukan' :
                            record.category === 'expense' ? 'Pengeluaran' :
                            'Catatan'
                        }</span>
                    </div>
                    ${record.description ? `<div class="record-content">${record.description}</div>` : ''}
                    ${record.amount ? `<div class="record-amount">Rp ${new Intl.NumberFormat('id-ID').format(record.amount)}</div>` : ''}
                    <div class="record-actions">
                        <button class="btn-small btn-edit" onclick="editRecord(${records.length - 1 - index})">Edit</button>
                        <button class="btn-small btn-delete" onclick="deleteRecord(${records.length - 1 - index})">Hapus</button>
                    </div>
                </div>
            `).join('');
        }

        // Edit record
        function editRecord(index) {
            const record = records[index];
            if (!record) return;

            document.getElementById('recordTitle').value = record.title;
            document.getElementById('recordCategory').value = record.category;
            document.getElementById('recordAmount').value = record.amount || '';
            document.getElementById('recordDescription').value = record.description || '';

            records.splice(index, 1);
            localStorage.setItem('kp_records', JSON.stringify(records));
            updateStatistics();
            renderRecords();

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Delete record
        function deleteRecord(index) {
            if (confirm('Yakin ingin menghapus catatan ini?')) {
                records.splice(index, 1);
                localStorage.setItem('kp_records', JSON.stringify(records));
                updateStatistics();
                renderRecords();
            }
        }

        // Handle form submit
        document.getElementById('recordForm').addEventListener('submit', (e) => {
            e.preventDefault();

            const title = document.getElementById('recordTitle').value.trim();
            const category = document.getElementById('recordCategory').value;
            const amount = parseInt(document.getElementById('recordAmount').value) || 0;
            const description = document.getElementById('recordDescription').value.trim();

            if (!title || !category) {
                alert('Judul dan kategori harus diisi!');
                return;
            }

            const newRecord = {
                id: Date.now(),
                title: title,
                category: category,
                amount: amount,
                description: description,
                date: new Date().toLocaleString('id-ID')
            };

            records.push(newRecord);
            localStorage.setItem('kp_records', JSON.stringify(records));
            updateStatistics();
            renderRecords();

            document.getElementById('recordForm').reset();
            console.log('[Pencatatan] Record saved:', newRecord);
        });

        // Initialize
        loadRecords();
    </script>
</body>
</html>
