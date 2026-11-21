/* Category filter + JP/EN live search */
function initMenu() {
  const q0 = new URLSearchParams(location.search), st = { cat: q0.get('cat') || 'all', q: q0.get('q') || '' };
  const tabs = document.getElementById('nk-tabs'), grid = document.getElementById('nk-grid'), box = document.getElementById('nk-search');
  box.value = st.q;
  tabs.innerHTML = [{ id: 'all', jp: 'すべて', icon: '🍽️' }, ...CATEGORIES].map(c =>
    `<button class="btn nk-tab" data-cat="${c.id}">${c.icon} ${c.jp}</button>`).join('');
  const draw = () => {
    const q = st.q.trim().toLowerCase();
    const list = PRODUCTS.filter(p => (st.cat === 'all' || p.cat === st.cat) &&
      (!q || (p.jp + ' ' + p.en + ' ' + p.desc).toLowerCase().includes(q)));
    grid.innerHTML = list.length ? list.map(NK.card).join('') : '<p class="text-center text-muted py-6">該当するメニューがありません。</p>';
    tabs.querySelectorAll('.nk-tab').forEach(b => b.classList.toggle('active', b.dataset.cat === st.cat));
    NK.bindAdd(grid);
  };
  tabs.onclick = e => { const b = e.target.closest('.nk-tab'); if (b) { st.cat = b.dataset.cat; draw(); } };
  box.oninput = () => { st.q = box.value; draw(); };
  draw();
}
