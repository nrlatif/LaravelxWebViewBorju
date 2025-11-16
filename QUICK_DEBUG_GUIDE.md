# Quick Debug Guide - "Nothing Shows" Issue

## 🚀 Quickest Way to Diagnose

### Step 1: Run the Diagnostic Page (2 minutes)
```
Open: http://localhost:8000/diagnostics.html
Click: "Run All Tests" button
Look for: Any ✗ (red errors)
```

**What to check:**
- ✓ means working
- ✗ means not working (this is the problem)
- ⚠ means warning (might be okay)

### Step 2: Check These Specific Issues

#### Issue A: "Firebase not loaded"
If you see: `✗ Firebase not loaded`

**Fix:**
1. Open terminal
2. Run: `npm run dev` (should show Vite server running)
3. Wait 5 seconds
4. Refresh page: `Ctrl+F5` (hard refresh)
5. Try diagnostics again

#### Issue B: "User not logged in"
If you see: `⚠ No user logged in`

**Fix:**
1. Go to: http://localhost:8000/login
2. Login with your account
3. Go to dashboard
4. Try menu page again

#### Issue C: "getMenus returned nothing"
If you see: `✗ No menus found in Firestore`

**This means:**
- Firestore collection 'menus' is empty, OR
- Security rules block read access

**Fix:**
- Check Firebase Console: https://console.firebase.google.com/
- Project: kpborju
- Firestore → Collections → Check if 'menus' exists and has data
- If empty, add test data first

#### Issue D: "window.menuFunctions not available"
If you see: `✗ window.menuFunctions not available`

**Fix:**
1. Check console (F12 → Console tab)
2. Look for red errors
3. Most likely: Vite not running (`npm run dev`)
4. Or: app.js not loading properly

---

## 🔍 Browser Console Check (F12)

Open your browser's Developer Tools:
```
Windows/Linux: F12
Mac: Cmd + Option + I
```

Go to **Console** tab and run these commands:

### Test 1: Check Firebase
```javascript
typeof firebase !== 'undefined' ? '✓ Firebase loaded' : '✗ Firebase not loaded'
```

### Test 2: Check Firestore
```javascript
typeof db !== 'undefined' ? '✓ Firestore available' : '✗ Firestore not available'
```

### Test 3: Check Auth Functions
```javascript
typeof window.authFunctions !== 'undefined' ? '✓ Auth available' : '✗ Auth not available'
```

### Test 4: Check Menu Functions
```javascript
typeof window.menuFunctions !== 'undefined' ? '✓ Menu functions available' : '✗ Menu functions not available'
```

### Test 5: Try to Get Menus
```javascript
window.menuFunctions?.getMenus().then(menus => {
  console.log('Total menus:', menus?.length);
  if (menus && menus.length > 0) {
    console.log('First menu:', menus[0]);
  }
}).catch(e => console.error('Error:', e.message));
```

---

## ⚡ Common Issues & Quick Fixes

### Problem: Page loads but shows nothing
**Likely cause:** Vite dev server not running

**Fix:**
```powershell
npm run dev
```
Wait for message: `VITE v5.x.x  ready in xxx ms`

---

### Problem: console shows "Cannot read firebase"
**Likely cause:** .env variables not loaded

**Fix:**
1. Check file: `.env` (in project root)
2. Should have `VITE_FIREBASE_*` variables
3. If missing, see `SETUP_FIREBASE_ENV.md`
4. Restart servers after adding variables:
   ```powershell
   npm run dev
   php artisan serve
   ```

---

### Problem: "getMenus returns empty array"
**Likely cause:** No data in Firestore OR not logged in

**Fix:**
1. Login first: http://localhost:8000/login
2. Check Firestore: https://console.firebase.google.com/
   - Project: `kpborju`
   - Firestore Database
   - Collections
   - Look for `menus` collection
3. If menus collection is empty, add test data:
   ```javascript
   // Run in Firebase Console or script
   db.collection('menus').add({
     name: 'Test Menu',
     price: 50000,
     priceBuy: 25000,
     kategori: 'Main',
     stok: 10,
     status: true,
     description: 'Test item'
   })
   ```

---

### Problem: Blank page on dashboard
**Likely causes** (in order):
1. Not logged in
2. JavaScript errors in console
3. Vite not running
4. Firebase not initialized

**Fix sequence:**
```
1. Check console (F12 → Console) for red errors
2. Login: http://localhost:8000/login  
3. Run diagnostics: http://localhost:8000/diagnostics.html
4. Check what's failing in diagnostics
5. Apply targeted fix from this guide
```

---

## 📋 Full Diagnostic Checklist

- [ ] Vite running (`npm run dev` shows ready)
- [ ] Laravel server running (http://localhost:8000 loads)
- [ ] User logged in (can access dashboard)
- [ ] Firebase initialized (test 1 passes)
- [ ] Firestore connected (test 2 passes)
- [ ] Menu functions available (test 4 passes)
- [ ] Menus data exists (test 5 returns items)
- [ ] No red errors in F12 console
- [ ] No red errors in Network tab (F12)

If any are unchecked, that's your problem!

---

## 🔧 Emergency Recovery

If everything is broken:

### Option 1: Restart Everything
```powershell
# Terminal 1
npm run dev

# Terminal 2 (in same folder)
php artisan serve

# Then visit: http://localhost:8000
```

### Option 2: Clear Caches
```powershell
# Clear npm cache
npm cache clean --force

# Clear Laravel cache
php artisan cache:clear

# Clear view cache
php artisan view:clear

# Restart servers
npm run dev
php artisan serve
```

### Option 3: Rebuild Vite
```powershell
# Delete node_modules cache
rm -r node_modules/.vite

# Restart dev server
npm run dev
```

---

## 📞 If Still Not Working

1. **Take screenshot** of http://localhost:8000/diagnostics.html output
2. **Screenshot console** (F12 → Console, show all errors)
3. **Screenshot Network tab** (F12 → Network, check for 404/500)
4. **Share these** so we can diagnose more specifically

---

## ✅ What "Working" Looks Like

On http://localhost:8000/diagnostics.html, you should see:
```
✓ Laravel server responding
✓ Firestore initialized  
✓ User logged in: your@email.com
✓ Function available: getMenus
✓ Function available: onMenusChange
✓ Function available: addMenu
✓ Successfully fetched 5 menus (or however many you have)
```

And when you visit http://localhost:8000/dashboard, you should see:
- Navigation bars (top, bottom, or side)
- Statistics cards with numbers
- Menu items displayed
- No blank page

---

## 🎯 Next Steps After Fixing

1. Test menu-crud page: http://localhost:8000/menu-crud
2. Test kasir page: http://localhost:8000/kasir  
3. Check if data persists (reload page, data still there?)
4. Try adding/editing/deleting items

If those work, Firestore integration is complete! ✓
