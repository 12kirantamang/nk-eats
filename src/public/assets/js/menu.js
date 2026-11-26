/* Database-backed helper for storefronts that use nk-tabs/nk-grid/nk-search. */
async function initMenu() {
  const tabs = document.getElementById('nk-tabs');
  const grid = document.getElementById('nk-grid');
  const box = document.getElementById('nk-search');
  if (!tabs || !grid) return;

  const response = await fetch('/api/products?t=' + Date.now(), { headers: { Accept: 'application/json' } });
  const data = await response.json().catch(() => ({ products: [] }));
  const products = data.products || [];
  const categories = [
    { id: 'all', jp: 'すべて' },
    { id: '洋食', jp: '洋食' },
    { id: 'ネパール料理', jp: 'ネパール料理' }
  ];

  let activeCategory = 'all';
  let query = '';
  tabs.innerHTML = categories.map(category =>
    `<button class="btn nk-tab" data-cat="${category.id}">${category.jp}</button>`
  ).join('');

  const draw = () => {
    const normalizedQuery = query.trim().toLowerCase();
    const list = products.filter(product => {
      const matchesCategory = activeCategory === 'all' || product.category === activeCategory;
      const searchable = `${product.name || ''} ${product.description || ''}`.toLowerCase();
      return matchesCategory && (!normalizedQuery || searchable.includes(normalizedQuery));
    });

    grid.innerHTML = list.length ? list.map(product => `
      <div class="col-6 col-md-4 col-lg-3 mb-4" data-product-id="${product.id}">
        <div class="card nk-card h-100 border-0 shadow-sm">
          <img class="card-img-top" src="${product.image_url || '/assets/img/gallery/cheese-burger.png'}" alt="${product.name}" style="height:180px;object-fit:cover">
          <div class="card-body d-flex flex-column">
            <span class="badge nk-pill mb-2 align-self-start">${product.category}</span>
            <h5 class="fw-bold">${product.name}</h5>
            <small class="text-muted mb-2">${product.description || ''}</small>
            <div class="mt-auto d-flex justify-content-between align-items-center">
              <span class="fw-bold">¥${Number(product.price).toLocaleString('ja-JP')}</span>
              <button class="btn btn-primary btn-sm nk-add" type="button">追加</button>
            </div>
          </div>
        </div>
      </div>`).join('') : '<p class="text-center text-muted py-6">該当するメニューがありません。</p>';

    tabs.querySelectorAll('.nk-tab').forEach(button => {
      button.classList.toggle('active', button.dataset.cat === activeCategory);
    });
  };

  tabs.onclick = event => {
    const button = event.target.closest('.nk-tab');
    if (!button) return;
    activeCategory = button.dataset.cat;
    draw();
  };
  if (box) box.oninput = () => { query = box.value; draw(); };
  draw();
}
