# 🔍 Troubleshooting: Halaman Tidak Menampilkan Apa-apa

## Quick Diagnosis

### 1. **Check Browser Console (F12)**
```
Buka: http://localhost:8000/dashboard (atau halaman mana pun)
Tekan: F12 (Developer Tools)
Go to: Console tab
Cari: Error messages dengan prefix [Menu], [Kasir], [Firebase]
```

**Expected logs** (harus muncul):
```
✓ Firebase initialized successfully
✓ Firebase Auth initialized
✓ Firestore initialized
✓ window.menuFunctions available
[Menu CRUD] Loading menu items from Firestore...
[Menu] Fetched X menus
```

### 2. **Check Network Tab**
```
F12 → Network tab
Refresh page
Cari: firestore.googleapis.com requests
Status harus: 200 OK (bukan 404, 401, 403)
```

### 3. **Test Firestore Debug Page**
```
Open: http://localhost:8000/firestore-debug.html
Click: "Test Firestore Connection"
Click: "Test Menu Functions"
Click: "Test Get Menus"

Semua harus ✓ (green checks)
```

## Common Causes & Fixes

### Issue 1: Blank Page / Nothing Loads

**Check 1: Server Running?**
```bash
# Terminal 1: Check if Laravel running
php artisan serve
# Should say: Local: http://localhost:8000

# Terminal 2: Check if Vite running  
npm run dev
# Should say: Local: http://localhost:5173
```

**Check 2: Browser Console Errors**
- F12 → Console
- Red errors = blocking issue
- Common: "Cannot read property 'name' of undefined"

**Check 3: Network Requests Failed**
- F12 → Network
- Red entries = failed requests
- Check firestore.googleapis.com status

**Fix:**
```bash
# Kill all servers (Ctrl+C)
# Clear cache
rm -rf node_modules/.vite
npm run dev
php artisan serve

# Hard refresh page: Ctrl+Shift+R
```

### Issue 2: Firebase Config Not Loading

**Check:**
```javascript
// Console:
console.log('Firebase config:', {
  apiKey: import.meta.env?.VITE_FIREBASE_API_KEY ? '✓' : '❌',
  projectId: import.meta.env?.VITE_FIREBASE_PROJECT_ID ? '✓' : '❌',
})
```

**Fix:**
1. Verify `.env` file ada dan punya Firebase variables
2. Restart servers (Ctrl+C, then npm run dev & php artisan serve)
3. Hard refresh: Ctrl+Shift+R

### Issue 3: Menu Data Not Showing (Page Loads But Empty)

**Check:**
```javascript
// Console:
(async () => {
    const menus = await window.menuFunctions.getMenus();
    console.log('Menus found:', menus?.length);
    console.table(menus);
})();
```

If empty (returns []):
1. Check Firestore Console → menus collection punya data?
2. Check Firestore security rules allow read?
3. Check user authenticated?

**Fix:**
```javascript
// Console:
(async () => {
    const user = await window.authFunctions.getCurrentUser();
    console.log('User:', user ? user.email : 'Not logged in');
})();
```

If not logged in → Login terlebih dahulu sebelum buka menu page.

### Issue 4: Image Not Showing (Text OK, Image Missing)

**Check:**
1. Cloudinary image URL valid?
2. CORS issue?

**Fix:**
```javascript
// Console:
const testUrl = 'https://res.cloudinary.com/...'; // URL dari menu
fetch(testUrl, { method: 'HEAD' })
    .then(r => console.log('✓ Image accessible:', r.status))
    .catch(e => console.error('❌ Image error:', e.message));
```

## Step-by-Step Debugging

### Step 1: Is Page Loading At All?
```bash
# Go to: http://localhost:8000/dashboard
# Do you see HTML? (any text/styles?)

If YES → Go to Step 2
If NO  → Check servers running
```

### Step 2: Browser Console Clean?
```bash
# F12 → Console tab
# Any red error messages?

If YES  → Copy error, search solution
If NO   → Go to Step 3
```

### Step 3: Firebase Connected?
```bash
# Go to: http://localhost:8000/firestore-debug.html
# Click all test buttons
# Do you see ✓ Firebase loaded?

If YES → Go to Step 4
If NO  → Firebase config issue (check .env)
```

### Step 4: Menu Functions Available?
```javascript
// Console:
typeof window.menuFunctions?.getMenus
// Should return: 'function'

If YES  → Go to Step 5
If NO   → Restart servers
```

### Step 5: Menus Loading?
```javascript
// Console:
(async () => {
    const m = await window.menuFunctions.getMenus();
    console.log('Menu count:', m?.length);
})();
// Should show: Menu count: X (not 0)

If YES (>0)  → Menus are loading!
If NO (=0)   → Check Firestore has data
If ERROR     → Check auth status
```

## Checklist untuk "Nothing Shows"

- [ ] Laravel server running (`php artisan serve`)
- [ ] Vite dev server running (`npm run dev`)
- [ ] Browser accessing correct URL (`http://localhost:8000/...`)
- [ ] No red errors di console (F12)
- [ ] Firebase config di `.env` filled
- [ ] Firestore collection `menus` punya data
- [ ] Logged in (sebelum buka menu page)
- [ ] Firestore security rules allow read

## Quick Test Commands

Paste ini di browser console untuk quick test:

```javascript
// 1. Check servers & environment
console.log('🔍 Environment Check');
console.log('Firebase loaded:', typeof firebase !== 'undefined');
console.log('Functions available:', !!window.menuFunctions?.getMenus);

// 2. Check Firebase connection
console.log('\n🔗 Firebase Connection');
console.log('Config:', {
  apiKey: !!import.meta.env?.VITE_FIREBASE_API_KEY,
  projectId: !!import.meta.env?.VITE_FIREBASE_PROJECT_ID,
});

// 3. Check authentication
console.log('\n👤 Authentication');
(async () => {
    const user = await window.authFunctions.getCurrentUser();
    console.log('User:', user?.email || 'Not logged in');
})();

// 4. Check Firestore data
console.log('\n📚 Firestore Data');
(async () => {
    const menus = await window.menuFunctions.getMenus();
    console.log('Menus found:', menus?.length || 0);
    if (menus?.length > 0) {
        console.table(menus);
    }
})();
```

## For Different Pages

### Dashboard Page
- Should show: Statistics cards, Recent orders
- Check: localStorage untuk stats data (`kp_statistics`)

### Menu CRUD Page
- Should show: Menu grid dengan cards
- Check: Firestore `menus` collection

### Kasir Page
- Should show: Menu items grid + Cart sidebar
- Check: Same as Menu CRUD

### Riwayat Page
- Should show: Order history list
- Check: localStorage untuk orders (`kp_orders`)

## Console Logs to Look For

Saat page load, console harus show:

```
✓ Firebase initialized successfully
✓ Firebase Auth initialized
✓ Firestore initialized
[Menu] Fetching all menus from Firestore...
[Menu] Fetched 5 menus
[Menu CRUD] Real-time listener initialized
```

Jika tidak ada = ada yang error during initialization.

## If Still Stuck

1. **Screenshot console output** (F12 → Console)
2. **Screenshot Network tab** (F12 → Network, refresh, screenshot failed requests)
3. **Screenshot Firebase Console** (menus collection data)
4. **Tell me:**
   - Halaman mana yang blank?
   - Apa error di console?
   - Firestore ada data atau tidak?
   - User logged in atau tidak?

## Recovery Commands

Jika stuck, try ini:

```bash
# 1. Clear all caches
rm -rf node_modules/.vite
npm run build

# 2. Restart servers
# Ctrl+C di semua terminals

# 3. Run fresh
npm run dev
php artisan serve

# 4. Hard refresh browser
Ctrl+Shift+R (Windows) atau Cmd+Shift+R (Mac)

# 5. Test halaman
http://localhost:8000/firestore-debug.html
```

---

**Next**: Follow checklist di atas untuk identify masalahnya!
