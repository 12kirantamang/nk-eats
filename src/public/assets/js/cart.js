/* NK-EATS cart (LocalStorage) + shared helpers */
const NK = {
  KEY: 'nk-eats-cart', DELIVERY_FEE: 300, FREE_OVER: 3000,
  yen: n => '¥' + Number(n).toLocaleString('ja-JP') + ' (税込)',
  yenPlain: n => '¥' + Number(n).toLocaleString('ja-JP'),
  get() { try { return JSON.parse(localStorage.getItem(NK.KEY)) || []; } catch (e) { return []; } },
  save(c) { localStorage.setItem(NK.KEY, JSON.stringify(c)); NK.badge(); },
  add(id, qty = 1) {
    const c = NK.get(), i = c.find(x => x.id === id);
    i ? i.qty += qty : c.push({ id, qty }); NK.save(c);
  },
  setQty(id, q) { NK.save(NK.get().map(x => x.id === id ? { ...x, qty: Math.max(1, q) } : x)); },
  remove(id) { NK.save(NK.get().filter(x => x.id !== id)); },
  clear() { NK.save([]); },
  count() { return NK.get().reduce((s, x) => s + x.qty, 0); },
  lines() { return NK.get().map(x => ({ ...PRODUCTS.find(p => p.id === x.id), qty: x.qty })).filter(l => l.id); },
  subtotal() { return NK.lines().reduce((s, l) => s + l.price * l.qty, 0); },
  taxOf(t) { return Math.floor(t * 10 / 110); }, // 10% tax already included in price
  badge() { document.querySelectorAll('.nk-cart-count').forEach(e => { e.textContent = NK.count(); e.classList.toggle('d-none', !NK.count()); }); },
  img(p, cls = '') { return `<img class="${cls}" src="${p.img}" alt="${p.jp}" loading="lazy" onerror="this.onerror=null;this.src='${p.fb}'">`; },
  card(p) {
    return `<div class="col-6 col-md-4 col-lg-3 mb-4"><div class="card nk-card h-100 border-0 shadow-sm">
      <a href="food-details.html?id=${p.id}" class="nk-thumb">${NK.img(p, 'card-img-top')}</a>
      <div class="card-body d-flex flex-column"><span class="badge nk-pill mb-2 align-self-start">${CATEGORIES.find(c => c.id === p.cat).jp}</span>
      <h5 class="mb-0 fw-bold">${p.jp}</h5><small class="text-muted mb-2">${p.en}</small>
      <div class="mt-auto d-flex justify-content-between align-items-center"><span class="fw-bold nk-price">${NK.yen(p.price)}</span>
      <button class="btn btn-primary btn-sm nk-add" data-id="${p.id}" aria-label="カートに追加"><i class="fas fa-plus"></i></button></div></div></div></div>`;
  },
  bindAdd(root = document) {
    root.querySelectorAll('.nk-add').forEach(b => b.onclick = () => {
      NK.add(+b.dataset.id); b.innerHTML = '<i class="fas fa-check"></i>'; setTimeout(() => b.innerHTML = '<i class="fas fa-plus"></i>', 900);
    });
  }
};
