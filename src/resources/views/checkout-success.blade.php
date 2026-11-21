<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>決済完了 | NK-EATS</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="/assets/css/theme.css" rel="stylesheet">
  <link href="/assets/css/nk.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-100">
  <main class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card border-0 shadow-lg rounded-4 text-center p-5" style="max-width:520px">
      <div class="display-1 text-success mb-3"><i class="fas fa-circle-check"></i></div>
      <h1 class="fw-bold">決済が完了しました</h1>
      <p class="text-muted mt-3">ご注文ありがとうございます。<br>お届けまたは店頭受取の準備を進めます。</p>
      <p class="small text-muted">決済ID: {{ $sessionId }}</p>
      <a href="/" class="btn btn-danger btn-lg mt-3">ホームに戻る</a>
    </div>
  </main>
</body>
</html>
