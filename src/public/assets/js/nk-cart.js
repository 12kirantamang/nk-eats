/* NK-EATS: cart drawer (LocalStorage) + login / register (demo, front-end only) */
(function () {
  const CK = 'nk-eats-cart', DK = 'nk-eats-delivery', UK = 'nk-eats-users', SK = 'nk-eats-session';
  const FEE = 300, FREE = 3000;
  const yen = n => '¥' + n.toLocaleString('ja-JP');
  const read = (k, d) => { try { return JSON.parse(localStorage.getItem(k)) ?? d; } catch (e) { return d; } };
  const write = (k, v) => localStorage.setItem(k, JSON.stringify(v));
  const inst = (C, el) => C.getInstance(el) || new C(el);
  const $ = (s, r = document) => r.querySelector(s);
  const esc = s => String(s).replace(/[&<>"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
  let cart = read(CK, []);
  let pendingCheckout = false;
  const save = () => { write(CK, cart); render(); };

  const UI = `
<div class="offcanvas offcanvas-end" tabindex="-1" id="nkCart" aria-labelledby="nkCartTitle">
  <div class="offcanvas-header"><h5 class="fw-bold mb-0" id="nkCartTitle"><i class="fas fa-shopping-cart text-warning me-2"></i>カート</h5><button class="btn-close" data-bs-dismiss="offcanvas" aria-label="閉じる"></button></div>
  <div class="offcanvas-body d-flex flex-column"><div id="nk-lines" class="flex-grow-1"></div><div id="nk-sum"></div></div>
</div>
<div class="modal fade" id="nkLogin" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><form class="modal-content" id="nk-login-form">
  <div class="modal-header"><h5 class="modal-title fw-bold">ログイン</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button></div>
  <div class="modal-body"><div class="alert alert-danger d-none" id="nk-login-err"></div>
  <label class="form-label">メールアドレス</label><input class="form-control mb-3" type="email" name="email" required>
  <label class="form-label">パスワード</label><input class="form-control" type="password" name="pw" required></div>
  <div class="modal-footer justify-content-between"><a href="#!" id="nk-to-reg" class="small">新規登録はこちら</a><button class="btn btn-danger px-4">ログイン</button></div></form></div></div>
<div class="modal fade" id="nkRegister" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><form class="modal-content" id="nk-reg-form">
  <div class="modal-header"><h5 class="modal-title fw-bold">新規登録</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button></div>
  <div class="modal-body"><div class="alert alert-danger d-none" id="nk-reg-err"></div>
  <label class="form-label">お名前</label><input class="form-control mb-3" name="name" required>
  <label class="form-label">メールアドレス</label><input class="form-control mb-3" type="email" name="email" required>
  <label class="form-label">電話番号</label><input class="form-control mb-3" type="tel" name="tel">
  <label class="form-label">パスワード（8文字以上）</label><input class="form-control mb-3" type="password" name="pw" minlength="8" required>
  <label class="form-label">パスワード（確認）</label><input class="form-control" type="password" name="pw2" required></div>
  <div class="modal-footer justify-content-between"><a href="#!" id="nk-to-login" class="small">ログインはこちら</a><button class="btn btn-danger px-4">登録する</button></div></form></div></div>
<div class="nk-toast" id="nk-toast" role="status"></div>`;

  function toast(msg) { const t = $('#nk-toast'); t.textContent = msg; t.classList.add('show'); clearTimeout(toast.t); toast.t = setTimeout(() => t.classList.remove('show'), 1800); }

  function add(item) {
    const i = cart.find(x => x.id === item.id);
    i ? i.qty++ : cart.push({ ...item, qty: 1 });
    save(); toast(`「${item.name}」をカートに追加しました`);
  }

  function render() {
    const n = cart.reduce((s, x) => s + x.qty, 0), sub = cart.reduce((s, x) => s + x.qty * x.price, 0);
    document.querySelectorAll('.nk-count').forEach(e => { e.textContent = n; e.classList.toggle('d-none', !n); });
    const L = $('#nk-lines'), S = $('#nk-sum'); if (!L) return;
    if (!cart.length) { L.innerHTML = '<p class="text-center text-muted mt-6">カートは空です。<br>お好みの料理を追加してください。</p>'; S.innerHTML = ''; return; }
    L.innerHTML = cart.map((x, i) => `<div class="nk-line"><img src="${esc(x.img)}" alt="">
      <div class="flex-grow-1"><div class="fw-bold">${esc(x.name)}</div><div class="text-primary">${yen(x.price)}<small class="text-muted">（税込）</small></div></div>
      <div class="nk-qty d-flex align-items-center gap-2"><button class="btn btn-sm btn-outline-secondary" data-act="dec" data-i="${i}" aria-label="減らす">−</button><b>${x.qty}</b><button class="btn btn-sm btn-outline-secondary" data-act="inc" data-i="${i}" aria-label="増やす">＋</button></div>
      <button class="btn btn-sm text-danger" data-act="del" data-i="${i}" aria-label="削除"><i class="fas fa-trash"></i></button></div>`).join('');
    const fee = sub < FREE ? FEE : 0;
    S.innerHTML = `<div class="pt-3">
      <div class="btn-group w-100 mb-3" role="group"><input type="radio" class="btn-check" name="nk-m" id="nk-m1" value="delivery" checked><label class="btn btn-outline-warning" for="nk-m1"><i class="fas fa-motorcycle me-1"></i>配達</label>
      <input type="radio" class="btn-check" name="nk-m" id="nk-m2" value="pickup"><label class="btn btn-outline-warning" for="nk-m2"><i class="fas fa-shopping-bag me-1"></i>店頭受取</label></div>
      <div id="nk-delivery-form">
        <label class="form-label mt-2">お届け先住所（市区町村・番地）</label>
        <input class="form-control mb-2" id="nk-address" autocomplete="street-address" placeholder="例：東京都渋谷区〇〇1-2-3" required>
        <label class="form-label">電話番号</label>
        <input class="form-control mb-3" id="nk-phone" type="tel" autocomplete="tel" placeholder="090-1234-5678" required>
      </div>
      <div class="d-flex justify-content-between"><span>小計（税込）</span><span>${yen(sub)}</span></div>
      <div class="d-flex justify-content-between small text-muted"><span>（内 消費税10%）</span><span>${yen(Math.floor(sub * 10 / 110))}</span></div>
      <div class="d-flex justify-content-between"><span>配達料</span><span id="nk-fee">${fee ? yen(fee) : '無料'}</span></div><hr>
      <div class="d-flex justify-content-between fw-bold fs-5"><span>合計</span><span class="text-primary" id="nk-total">${yen(sub + fee)}</span></div>
      <p class="small text-muted mb-3">${yen(FREE)}以上のご注文は配達料無料。店頭受取は配達料なし。</p>
      <button class="btn btn-danger w-100 btn-lg" id="nk-order">お支払いへ進む</button>
      <button class="btn btn-link w-100 text-muted" id="nk-clear">カートを空にする</button></div>`;
    document.querySelectorAll('input[name=nk-m]').forEach(r => r.onchange = () => {
      const pick = r.value === 'pickup' && r.checked ? true : $('#nk-m2').checked, f = pick ? 0 : fee;
      $('#nk-fee').textContent = f ? yen(f) : '無料'; $('#nk-total').textContent = yen(sub + f);
      $('#nk-delivery-form').classList.toggle('d-none', pick);
    });
    $('#nk-clear').onclick = () => { cart = []; save(); };
    const saveDeliveryAndProceed = () => {
      const pickup = $('#nk-m2')?.checked;
      const details = {
        delivery: pickup ? 'pickup' : 'delivery',
        address: $('#nk-address')?.value.trim() || '',
        phone: $('#nk-phone')?.value.trim() || ''
      };
      write(DK, details);
      pendingCheckout = false;
      window.location.href = '/checkout';
    };

    $('#nk-order').onclick = async () => {
      if (!cart.length) return toast('カートに商品がありません。');

      try {
        const response = await fetch('/auth/status', { headers: { 'Accept': 'application/json' } });
        const status = await response.json();
        if (status.authenticated) return saveDeliveryAndProceed();
      } catch (_) {}

      pendingCheckout = true;
      inst(bootstrap.Modal, $('#nkLogin')).show();
    };
  }
  const render2 = () => document.querySelectorAll('.nk-count').forEach(e => e.classList.add('d-none'));

  /* ---- auth (front-end demo only; real accounts need a backend) ---- */
  const session = () => read(SK, null);
  const apiHeaders = () => ({
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
  });

  async function apiPost(url, body) {
    const response = await fetch(url, { method: 'POST', headers: apiHeaders(), body: JSON.stringify(body) });
    const data = await response.json().catch(() => ({}));
    if (!response.ok) throw new Error(data.message || data.errors?.email?.[0] || data.errors?.password?.[0] || '処理に失敗しました。');
    return data;
  }

  function paintAuth(u = session()) {
    const box = $('#nk-auth'); if (!box) return;
    box.querySelectorAll('[data-bs-target="#nkLogin"],[data-bs-target="#nkRegister"],[data-bs-target="#nkCart"],#nk-user').forEach(b => {
      if (b.id === 'nk-user') b.remove();
      else if (b.hasAttribute('data-bs-target') && b.dataset.bsTarget !== '#nkCart') b.classList.toggle('d-none', !!u);
    });
    if (u) {
      box.insertAdjacentHTML('afterbegin', `<span id="nk-user" class="d-flex align-items-center gap-2"><span class="fw-bold text-1000"><i class="fas fa-user-circle text-warning me-1"></i>${esc(u.name)}さん</span><button class="btn btn-sm btn-outline-secondary" id="nk-logout">ログアウト</button></span>`);
      $('#nk-logout').onclick = async () => {
        try { await apiPost('/logout', {}); } catch (_) {}
        localStorage.removeItem(SK); paintAuth(null); toast('ログアウトしました');
      };
    }
  }
  const showErr = (id, m) => { const e = $(id); e.textContent = m; e.classList.remove('d-none'); };

  document.addEventListener('DOMContentLoaded', () => {
    document.body.insertAdjacentHTML('beforeend', UI);
    // every "add to cart" button reads its card (name / image / price)
    document.querySelectorAll('.nk-add').forEach(b => b.addEventListener('click', () => {
      const col = b.closest('[class*="col-"]'), name = $('h5', col).textContent.trim(), p = $('[data-price]', col);
      add({ id: name, name, price: +p.dataset.price, img: $('img', col).getAttribute('src') });
      b.classList.add('added'); const old = b.innerHTML; b.innerHTML = '<i class="fas fa-check me-2"></i>追加しました'; setTimeout(() => { b.classList.remove('added'); b.innerHTML = old; }, 900);
    }));
    $('#nkCart').addEventListener('click', e => {
      const b = e.target.closest('[data-act]'); if (!b) return; const i = +b.dataset.i;
      if (b.dataset.act === 'inc') cart[i].qty++; else if (b.dataset.act === 'dec') cart[i].qty = Math.max(1, cart[i].qty - 1); else cart.splice(i, 1);
      save();
    });
    $('#nk-to-reg').onclick = () => { bootstrap.Modal.getInstance($('#nkLogin')).hide(); inst(bootstrap.Modal,$('#nkRegister')).show(); };
    $('#nk-to-login').onclick = () => { bootstrap.Modal.getInstance($('#nkRegister')).hide(); inst(bootstrap.Modal,$('#nkLogin')).show(); };
    $('#nk-reg-form').onsubmit = async e => {
      e.preventDefault();
      const f = new FormData(e.target);
      const err = $('#nk-reg-err'); err.classList.add('d-none');
      if (f.get('pw') !== f.get('pw2')) return showErr('#nk-reg-err', 'パスワードが一致しません。');

      try {
        const data = await apiPost('/register', {
          name: f.get('name').trim(),
          email: f.get('email').trim(),
          password: f.get('pw')
        });
        write(SK, data.user);
        bootstrap.Modal.getInstance($('#nkRegister')).hide();
        e.target.reset(); paintAuth(data.user); toast(data.message);
        if (pendingCheckout) saveDeliveryAndProceed();
      } catch (error) {
        showErr('#nk-reg-err', error.message);
      }
    };

    $('#nk-login-form').onsubmit = async e => {
      e.preventDefault();
      const f = new FormData(e.target);
      const err = $('#nk-login-err'); err.classList.add('d-none');

      try {
        const data = await apiPost('/login', {
          email: f.get('email').trim(),
          password: f.get('pw')
        });
        write(SK, data.user);
        bootstrap.Modal.getInstance($('#nkLogin')).hide();
        e.target.reset(); paintAuth(data.user); toast(data.message);
        if (pendingCheckout) saveDeliveryAndProceed();
      } catch (error) {
        showErr('#nk-login-err', error.message);
      }
    };
    render(); paintAuth();
  });
})();
