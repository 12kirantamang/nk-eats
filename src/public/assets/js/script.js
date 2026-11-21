/* Layout injection + page logic */
const HEAD = `<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm"><div class="container">
<a class="navbar-brand d-inline-flex align-items-center" href="index.html"><img src="assets/img/gallery/logo.svg" width="32" alt="NK-EATS logo"><span class="fs-3 fw-bold ms-2 text-gradient">NK-EATS</span></a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nkNav" aria-label="メニュー"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nkNav"><ul class="navbar-nav mx-auto"><li class="nav-item"><a class="nav-link" href="index.html">ホーム</a></li><li class="nav-item"><a class="nav-link" href="menu.html">メニュー</a></li></ul>
<form class="d-flex me-lg-3 my-2 my-lg-0" action="menu.html"><input class="form-control bg-100 border-0" name="q" type="search" placeholder="料理を検索" aria-label="検索"></form>
<a class="btn btn-primary position-relative" href="cart.html"><i class="fas fa-shopping-cart me-1"></i>カート<span class="badge bg-dark nk-cart-count d-none rounded-pill">0</span></a></div></div></nav>`;
const FOOT = `<footer class="bg-1000 text-200 mt-6 py-5"><div class="container"><div class="row"><div class="col-md-5 mb-3"><h5 class="text-white fw-bold">NK-EATS</h5><p class="mb-1">あなたの料理、あなたの選択。</p><p class="small">日本料理・洋食・ネパール料理・ファストフードをお届け。<br>配達エリア：日本国内（一部地域を除く）</p></div>
<div class="col-md-4 mb-3"><h6 class="text-white">ご案内</h6><ul class="list-unstyled"><li><a class="text-200" href="menu.html">メニュー</a></li><li><a class="text-200" href="cart.html">カート</a></li><li><a class="text-200" href="#!">特定商取引法に基づく表記</a></li><li><a class="text-200" href="#!">プライバシーポリシー</a></li></ul></div>
<div class="col-md-3"><h6 class="text-white">注文方法</h6><p class="small mb-0">配達 / 店頭受取<br>価格はすべて税込表示です。</p></div></div><hr class="border-secondary"><p class="small mb-0 text-center">© 2026 NK-EATS. All rights reserved.</p></div></footer>`;
document.addEventListener('DOMContentLoaded', () => {
  document.body.insertAdjacentHTML('afterbegin', HEAD);
  document.body.insertAdjacentHTML('beforeend', FOOT);
  NK.badge();
  const page = document.body.dataset.page;
  ({ home: initHome, menu: initMenu, details: initDetails, cart: initCart, checkout: initCheckout }[page] || (() => {}))();
});
const $ = id => document.getElementById(id);

function initHome() {
  $('nk-cats').innerHTML = CATEGORIES.map(c => `<div class="col-6 col-lg-3 mb-4"><a class="nk-cat" href="menu.html?cat=${c.id}"><div class="e">${c.icon}</div><h5 class="fw-bold mt-2 mb-0">${c.jp}</h5><small class="text-muted">${c.en}</small></a></div>`).join('');
  $('nk-featured').innerHTML = PRODUCTS.filter(p => p.featured).slice(0, 8).map(NK.card).join('');
  NK.bindAdd();
}

function initDetails() {
  const p = PRODUCTS.find(x => x.id === +new URLSearchParams(location.search).get('id'));
  if (!p) { $('nk-detail').innerHTML = '<p class="text-center py-6">料理が見つかりません。<a href="menu.html">メニューへ戻る</a></p>'; return; }
  document.title = `${p.jp} | NK-EATS`;
  let qty = 1;
  $('nk-detail').innerHTML = `<div class="col-md-6 mb-4"><div class="nk-thumb rounded-3">${NK.img(p)}</div></div>
  <div class="col-md-6"><span class="badge nk-pill mb-2">${CATEGORIES.find(c => c.id === p.cat).jp}</span><h1 class="fw-bold">${p.jp}</h1><p class="text-muted">${p.en}</p>
  <p class="fs-1 nk-price fw-bold">${NK.yen(p.price)}</p><p>${p.desc}</p>
  <div class="d-flex align-items-center mb-4"><button class="btn btn-outline-secondary" id="m">−</button><span class="mx-3 fs-3 nk-num" id="q">1</span><button class="btn btn-outline-secondary" id="p">＋</button></div>
  <button class="btn btn-primary btn-lg" id="add"><i class="fas fa-shopping-cart me-2"></i>カートに追加</button> <a class="btn btn-link" href="menu.html">← メニューへ</a><p class="mt-3 text-success d-none" id="ok">カートに追加しました。<a href="cart.html">カートを見る</a></p></div>`;
  $('m').onclick = () => $('q').textContent = qty = Math.max(1, qty - 1);
  $('p').onclick = () => $('q').textContent = qty = Math.min(20, qty + 1);
  $('add').onclick = () => { NK.add(p.id, qty); $('ok').classList.remove('d-none'); };
}

function summary() {
  const sub = NK.subtotal(), fee = sub && sub < NK.FREE_OVER ? NK.DELIVERY_FEE : 0;
  return { sub, fee, tax: NK.taxOf(sub) };
}
function initCart() {
  const draw = () => {
    const L = NK.lines(), s = summary();
    if (!L.length) { $('nk-cart').innerHTML = '<div class="text-center py-6"><p class="fs-4">カートは空です。</p><a class="btn btn-primary" href="menu.html">メニューを見る</a></div>'; return; }
    $('nk-cart').innerHTML = `<div class="col-lg-8">${L.map(l => `<div class="card border-0 shadow-sm mb-3"><div class="card-body d-flex align-items-center">
      <div class="nk-thumb rounded-3 me-3" style="width:90px;flex:none">${NK.img(l)}</div><div class="flex-grow-1"><h6 class="fw-bold mb-1">${l.jp}</h6><span class="nk-price">${NK.yen(l.price)}</span></div>
      <div class="d-flex align-items-center"><button class="btn btn-sm btn-outline-secondary" data-a="-" data-id="${l.id}">−</button><span class="mx-2 nk-num">${l.qty}</span><button class="btn btn-sm btn-outline-secondary" data-a="+" data-id="${l.id}">＋</button></div>
      <button class="btn btn-sm text-danger ms-2" data-a="x" data-id="${l.id}" aria-label="削除"><i class="fas fa-trash"></i></button></div></div>`).join('')}</div>
      <div class="col-lg-4"><div class="card border-0 shadow-sm"><div class="card-body"><h5 class="fw-bold">ご注文内容</h5>
      <div class="d-flex justify-content-between"><span>小計 (税込)</span><span>${NK.yenPlain(s.sub)}</span></div>
      <div class="d-flex justify-content-between text-muted small"><span>（内 消費税10%）</span><span>${NK.yenPlain(s.tax)}</span></div>
      <div class="d-flex justify-content-between"><span>配達料 (配達の場合)</span><span>${s.fee ? NK.yenPlain(s.fee) : '無料'}</span></div><hr>
      <div class="d-flex justify-content-between fw-bold fs-5"><span>合計</span><span class="nk-price">${NK.yen(s.sub + s.fee)}</span></div>
      <p class="small text-muted mt-2">${NK.yenPlain(NK.FREE_OVER)}以上のご注文で配達料無料。店頭受取は配達料なし。</p>
      <a class="btn btn-primary w-100" href="checkout.html">注文手続きへ</a></div></div></div>`;
    $('nk-cart').querySelectorAll('[data-a]').forEach(b => b.onclick = () => {
      const id = +b.dataset.id, it = NK.get().find(x => x.id === id);
      b.dataset.a === 'x' ? NK.remove(id) : NK.setQty(id, it.qty + (b.dataset.a === '+' ? 1 : -1)); draw();
    });
  };
  draw();
}

function initCheckout() {
  if (!NK.count()) { $('nk-checkout').innerHTML = '<div class="text-center py-6"><p class="fs-4">カートは空です。</p><a class="btn btn-primary" href="menu.html">メニューを見る</a></div>'; return; }
  const sync = () => {
    const del = document.querySelector('input[name=method]:checked').value === 'delivery', s = summary();
    $('addr').classList.toggle('d-none', del === false); $('addr').querySelectorAll('input').forEach(i => i.required = del);
    $('pick').classList.toggle('d-none', del); $('tot').textContent = NK.yen(s.sub + (del ? s.fee : 0));
  };
  document.querySelectorAll('input[name=method]').forEach(i => i.onchange = sync); sync();
  $('nk-form').onsubmit = e => {
    e.preventDefault(); const no = 'NK' + Date.now().toString().slice(-8);
    NK.clear(); $('nk-checkout').innerHTML = `<div class="text-center py-6"><div class="display-4">🎉</div><h2 class="fw-bold">ご注文ありがとうございます！</h2><p>注文番号：<b class="nk-num">${no}</b></p><a class="btn btn-primary" href="index.html">ホームへ戻る</a></div>`;
  };
}
