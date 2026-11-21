<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>お支払い確認 | NK-EATS</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="/assets/css/theme.css" rel="stylesheet">
  <link href="/assets/css/nk.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-100">
  <main class="container py-5">
    <a href="/" class="text-decoration-none text-primary fw-bold"><i class="fas fa-arrow-left me-2"></i>ショッピングに戻る</a>
    <h1 class="fw-bold text-center my-4">お支払い確認</h1>

    <div class="row justify-content-center g-4">
      <div class="col-lg-7">
        <div class="card shadow-sm rounded-4 border-0">
          <div class="card-body p-4">
            <h5 class="fw-bold mb-3">お届け方法</h5>
            <div class="btn-group w-100 mb-4" role="group">
              <input type="radio" class="btn-check" name="delivery" id="delivery" value="delivery" checked>
              <label class="btn btn-outline-warning" for="delivery"><i class="fas fa-motorcycle me-2"></i>配達</label>
              <input type="radio" class="btn-check" name="delivery" id="pickup" value="pickup">
              <label class="btn btn-outline-warning" for="pickup"><i class="fas fa-shopping-bag me-2"></i>店頭受取</label>
            </div>

            <div id="delivery-fields">
              <label class="form-label fw-bold">お届け先住所</label>
              <input class="form-control mb-3" id="address" autocomplete="street-address" placeholder="東京都渋谷区〇〇1-2-3">
              <label class="form-label fw-bold">電話番号</label>
              <input class="form-control" id="phone" type="tel" autocomplete="tel" placeholder="090-1234-5678">
            </div>

            <hr>
            <h5 class="fw-bold mb-3">カート内容</h5>
            <div id="checkout-lines"></div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card shadow-sm rounded-4 border-0">
          <div class="card-body p-4">
            <h5 class="fw-bold">注文内容</h5>
            <div class="d-flex justify-content-between mt-3"><span>小計</span><span id="checkout-subtotal">¥0</span></div>
            <div class="d-flex justify-content-between text-muted small"><span>配達料</span><span id="checkout-fee">¥300</span></div>
            <hr>
            <div class="d-flex justify-content-between fw-bold fs-5"><span>合計</span><span class="text-primary" id="checkout-total">¥0</span></div>
            <button class="btn btn-danger btn-lg w-100 mt-4" id="pay-button"><i class="fas fa-lock me-2"></i>カードで支払う</button>
            <p class="text-muted small text-center mt-3 mb-0"><i class="fas fa-shield-halved me-1"></i>Stripeによる安全な決済</p>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="/vendors/bootstrap/bootstrap.min.js"></script>
  <script>
    const cart = JSON.parse(localStorage.getItem('nk-eats-cart') || '[]');
    let savedDelivery = {};
    try {
      savedDelivery = JSON.parse(localStorage.getItem('nk-eats-delivery') || '{}');
    } catch (_) {}

    const addressInput = document.getElementById('address');
    const phoneInput = document.getElementById('phone');
    addressInput.value = savedDelivery.address || '';
    phoneInput.value = savedDelivery.phone || '';

    if (savedDelivery.delivery === 'pickup') {
      document.getElementById('pickup').checked = true;
      document.getElementById('delivery').checked = false;
    }

    const yen = n => '¥' + n.toLocaleString('ja-JP');
    const subtotal = cart.reduce((sum, item) => sum + item.price * item.qty, 0);

    document.getElementById('checkout-lines').innerHTML = cart.length
      ? cart.map(item => `<div class="d-flex align-items-center gap-3 mb-3"><img src="${item.img}" style="width:64px;height:64px;object-fit:cover;border-radius:.5rem"><div class="flex-grow-1"><b>${item.name}</b><div class="text-muted small">数量: ${item.qty}</div></div><b>${yen(item.price * item.qty)}</b></div>`).join('')
      : '<p class="text-muted">カートに商品がありません。</p>';

    function updateTotal() {
      const pickup = document.getElementById('pickup').checked;
      const fee = pickup || subtotal >= 3000 ? 0 : 300;
      document.getElementById('delivery-fields').classList.toggle('d-none', pickup);
      document.getElementById('checkout-subtotal').textContent = yen(subtotal);
      document.getElementById('checkout-fee').textContent = fee ? yen(fee) : '無料';
      document.getElementById('checkout-total').textContent = yen(subtotal + fee);
    }

    document.querySelectorAll('input[name="delivery"]').forEach(input => input.addEventListener('change', () => {
      updateTotal();
      localStorage.setItem('nk-eats-delivery', JSON.stringify({
        delivery: document.getElementById('pickup').checked ? 'pickup' : 'delivery',
        address: addressInput.value.trim(),
        phone: phoneInput.value.trim()
      }));
    }));

    [addressInput, phoneInput].forEach(input => input.addEventListener('input', () => {
      localStorage.setItem('nk-eats-delivery', JSON.stringify({
        delivery: document.getElementById('pickup').checked ? 'pickup' : 'delivery',
        address: addressInput.value.trim(),
        phone: phoneInput.value.trim()
      }));
    }));

    updateTotal();

    const payButton = document.getElementById('pay-button');

    payButton.addEventListener('click', async () => {
      if (payButton.disabled) return;
      if (!cart.length) return alert('カートに商品がありません。');

      const pickup = document.getElementById('pickup').checked;
      const address = document.getElementById('address').value.trim();
      const phone = document.getElementById('phone').value.trim();
      if (!pickup && (!address || !phone)) return alert('お届け先住所と電話番号を入力してください。');

      payButton.disabled = true;
      payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>決済画面へ移動中…';

      try {
        const response = await fetch('/checkout', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ cart, delivery: pickup ? 'pickup' : 'delivery', address, phone })
        });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || '決済を開始できませんでした。');
        if (!data.url) throw new Error('決済URLを取得できませんでした。');

        localStorage.removeItem('nk-eats-cart');
        localStorage.removeItem('nk-eats-delivery');
        window.location.assign(data.url);
      } catch (error) {
        alert(error.message || '決済を開始できませんでした。');
        payButton.disabled = false;
        payButton.innerHTML = '<i class="fas fa-lock me-2"></i>カードで支払う';
      }
    });
  </script>
</body>
</html>
