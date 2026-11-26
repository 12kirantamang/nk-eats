<!DOCTYPE html>
<html lang="ja" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>NK-EATS | あなたの料理、あなたの選択</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="assets/css/theme.css" rel="stylesheet" />
    <link href="assets/css/nk.css" rel="stylesheet" />

  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" data-navbar-on-scroll="data-navbar-on-scroll">
        <div class="container"><a class="navbar-brand d-inline-flex" href="index.html"><img class="d-inline-block" src="assets/img/gallery/logo.svg" alt="NK-EATS logo" /><span class="text-1000 fs-3 fw-bold ms-2 text-gradient">NK-EATS</span></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"> </span></button>
          <div class="collapse navbar-collapse border-top border-lg-0 my-2 mt-lg-0" id="navbarSupportedContent">
            <div class="mx-auto pt-5 pt-lg-0 d-block d-lg-none d-xxl-block">
              <p class="mb-0 fw-bold text-lg-center">お届け先：<i class="fas fa-map-marker-alt text-warning mx-2"></i><span class="fw-normal">現在地 </span><span>日本国内</span></p>
            </div>
            <form class="d-flex mt-4 mt-lg-0 ms-lg-auto ms-xl-0" onsubmit="return false">
              <div class="input-group-icon pe-2"><i class="fas fa-search input-box-icon text-primary"></i>
                <input class="form-control border-0 input-box bg-100" type="search" placeholder="料理を検索" aria-label="検索" />
              </div>
            </form>
            <div class="d-flex align-items-center mt-3 mt-lg-0 ms-lg-2 gap-2" id="nk-auth">
              <button class="btn btn-white shadow-warning text-warning" type="button" data-bs-toggle="modal" data-bs-target="#nkLogin"><i class="fas fa-user me-2"></i>ログイン</button>
              <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#nkRegister">新規登録</button>
              <button class="btn btn-outline-warning position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#nkCart" aria-label="カート"><i class="fas fa-shopping-cart"></i><span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle nk-count">0</span></button>
            </div>
          </div>
        </div>
      </nav>
      <section class="py-5 overflow-hidden bg-primary" id="home">
        <div class="container">
          <div class="row flex-center">
            <div class="col-md-5 col-lg-6 order-0 order-md-1 mt-8 mt-md-0"><a class="img-landing-banner" href="#!"><img class="img-fluid" src="assets/img/gallery/hero-header.png" alt="hero-header" /></a></div>
            <div class="col-md-7 col-lg-6 py-8 text-md-start text-center">
              <h1 class="display-1 fs-md-5 fs-lg-6 fs-xl-8 text-light">お腹すいてませんか？</h1>
              <h1 class="text-800 mb-5 fs-4">数クリックで、あなたの近くの<br class="d-none d-xxl-block" />おいしい料理が見つかります</h1>
              <div class="card w-xxl-75">
                <div class="card-body">
                  <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <button class="nav-link active mb-3" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-motorcycle me-2"></i>配達</button>
                      <button class="nav-link mb-3" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-shopping-bag me-2"></i>店頭受取</button>
                    </div>
                  </nav>
                  <div class="tab-content mt-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                      <form class="row gx-2 gy-2 align-items-center">
                        <div class="col">
                          <div class="input-group-icon"><i class="fas fa-map-marker-alt text-danger input-box-icon"></i>
                            <label class="visually-hidden" for="inputDelivery">住所</label>
                            <input class="form-control input-box form-foodwagon-control" id="inputDelivery" type="text" placeholder="住所を入力してください" />
                          </div>
                        </div>
                        <div class="d-grid gap-3 col-sm-auto">
                          <button class="btn btn-danger" type="submit">料理を探す</button>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                      <form class="row gx-4 gy-2 align-items-center">
                        <div class="col">
                          <div class="input-group-icon"><i class="fas fa-map-marker-alt text-danger input-box-icon"></i>
                            <label class="visually-hidden" for="inputPickup">住所</label>
                            <input class="form-control input-box form-foodwagon-control" id="inputPickup" type="text" placeholder="住所を入力してください" />
                          </div>
                        </div>
                        <div class="d-grid gap-3 col-sm-auto">
                          <button class="btn btn-danger" type="submit">料理を探す</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-0">

        <div class="container">
          <div class="row h-100 gx-2 mt-7">
            <div class="col-sm-6 col-lg-3 mb-3 mb-md-0 h-100 pb-4">
              <div class="card card-span h-100">
                <div class="position-relative"> <img class="img-fluid rounded-3 w-100" src="assets/img/gallery/discount-item-1.png" alt="..." />
                  <div class="card-actions">
                    <div class="badge badge-foodwagon bg-primary p-4">
                      <div class="d-flex flex-between-center">
                        <div class="text-white fs-7">15</div>
                        <div class="d-block text-white fs-2">% <br />
                          <div class="fw-normal fs-1 mt-2">オフ</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body px-0">
                  <h5 class="fw-bold text-1000 text-truncate">本日のおすすめ</h5><span class="badge bg-soft-danger py-2 px-3"><span class="fs-1 text-danger">残り6日</span></span>
                </div><a class="stretched-link" href="#"></a>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-md-0 h-100 pb-4">
              <div class="card card-span h-100">
                <div class="position-relative"> <img class="img-fluid rounded-3 w-100" src="assets/img/gallery/discount-item-2.png" alt="..." />
                  <div class="card-actions">
                    <div class="badge badge-foodwagon bg-primary p-4">
                      <div class="d-flex flex-between-center">
                        <div class="text-white fs-7">10</div>
                        <div class="d-block text-white fs-2">% <br />
                          <div class="fw-normal fs-1 mt-2">オフ</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body px-0">
                  <h5 class="fw-bold text-1000 text-truncate">ランチセット</h5><span class="badge bg-soft-danger py-2 px-3"><span class="fs-1 text-danger">残り6日</span></span>
                </div><a class="stretched-link" href="#"></a>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-md-0 h-100 pb-4">
              <div class="card card-span h-100">
                <div class="position-relative"> <img class="img-fluid rounded-3 w-100" src="assets/img/gallery/discount-item-3.png" alt="..." />
                  <div class="card-actions">
                    <div class="badge badge-foodwagon bg-primary p-4">
                      <div class="d-flex flex-between-center">
                        <div class="text-white fs-7">25</div>
                        <div class="d-block text-white fs-2">% <br />
                          <div class="fw-normal fs-1 mt-2">オフ</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body px-0">
                  <h5 class="fw-bold text-1000 text-truncate">ボリュームセット</h5><span class="badge bg-soft-danger py-2 px-3"><span class="fs-1 text-danger">残り6日</span></span>
                </div><a class="stretched-link" href="#"></a>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-md-0 h-100 pb-4">
              <div class="card card-span h-100">
                <div class="position-relative"> <img class="img-fluid rounded-3 w-100" src="assets/img/gallery/discount-item-4.png" alt="..." />
                  <div class="card-actions">
                    <div class="badge badge-foodwagon bg-primary p-4">
                      <div class="d-flex flex-between-center">
                        <div class="text-white fs-7">20</div>
                        <div class="d-block text-white fs-2">% <br />
                          <div class="fw-normal fs-1 mt-2">オフ</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body px-0">
                  <h5 class="fw-bold text-1000 text-truncate">ファミリーセット</h5><span class="badge bg-soft-danger py-2 px-3"><span class="fs-1 text-danger">残り6日</span></span>
                </div><a class="stretched-link" href="#"></a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->




      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-0 bg-primary-gradient">

        <div class="container">
          <div class="row justify-content-center g-0">
            <div class="col-xl-9">
              <div class="col-lg-6 text-center mx-auto mb-3 mb-md-5 mt-4">
                <h5 class="fw-bold text-danger fs-3 fs-lg-5 lh-sm my-6">ご利用の流れ</h5>
              </div>
              <div class="row">
                <div class="col-sm-6 col-md-3 mb-6">
                  <div class="text-center"><img class="shadow-icon" src="assets/img/gallery/location.png" height="112" alt="..." />
                    <h5 class="mt-4 fw-bold">お届け先を選ぶ</h5>
                    <p class="mb-md-0">料理をお届けする場所を選んでください。</p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-6">
                  <div class="text-center"><img class="shadow-icon" src="assets/img/gallery/order.png" height="112" alt="..." />
                    <h5 class="mt-4 fw-bold">メニューを選ぶ</h5>
                    <p class="mb-md-0">たくさんのメニューからお気に入りを選べます</p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-6">
                  <div class="text-center"><img class="shadow-icon" src="assets/img/gallery/pay.png" height="112" alt="..." />
                    <h5 class="mt-4 fw-bold">お支払い</h5>
                    <p class="mb-md-0">かんたん・安全。さまざまなお支払い方法をご利用いただけます</p>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-6">
                  <div class="text-center"><img class="shadow-icon" src="assets/img/gallery/meals.png" height="112" alt="..." />
                    <h5 class="mt-4 fw-bold">お食事を楽しむ</h5>
                    <p class="mb-md-0">出来たてをご自宅までお届けします。</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->




      <!-- ============================================-->
      <!-- <section> begin ============================-->
     
       <section class="py-4 overflow-hidden" id="western-menu">

        <div class="container">
          <div class="row h-100">
            <div class="col-lg-7 mx-auto text-center mt-7 mb-5">
              <h5 class="fw-bold fs-3 fs-lg-5 lh-sm">洋食</h5>
            </div>
            <div class="col-12">
              <div class="carousel slide" id="carouselPopularItems" data-bs-touch="false" data-bs-interval="false">
                <div class="carousel-inner">
                  <div class="carousel-item active" data-bs-interval="10000">
                    <div class="row gx-3 h-100 align-items-center">
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/food1.jpeg" alt="コロッケ定食" />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">コロッケ定食</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="690">¥690<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/food2.jpeg" alt="トンカツ定食" />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">トンカツ定食</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="480">¥480<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/food3.jpeg" alt="オムライス" />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">オムライス</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="380">¥380<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/food5.jpeg" alt="シーフードグラタン" />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">シーフードグラタン</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="580">¥580<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/food4.jpeg" alt="ハヤシライス" />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">ハヤシライス</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="850">¥850<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item" data-bs-interval="5000">
                    <div class="row gx-3 h-100 align-items-center">
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/cheese-burger.png" alt="..." style="height:220px!important;min-height:220px!important;width:100%;object-fit:cover" />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">チーズバーガー</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="690">¥690<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/toffes-cake.png" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">トフィーケーキ</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="480">¥480<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/dancake.png" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">ダンケーキ</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="380">¥380<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/crispy-sandwitch.png" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">クリスピーサンド</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="580">¥580<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/thai-soup.png" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">タイスープ</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="850">¥850<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="row gx-3 h-100 align-items-center">
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/cheese-burger.png" alt="..." style="height:220px!important;min-height:220px!important;width:100%;object-fit:cover" />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">チーズバーガー</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="690">¥690<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/toffes-cake.png" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">トフィーケーキ</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="480">¥480<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/dancake.png" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">ダンケーキ</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="380">¥380<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/crispy-sandwitch.png" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">クリスピーサンド</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="580">¥580<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                      <div class="col-sm-6 col-md-4 col-xl mb-5 h-100">
                        <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="assets/img/gallery/thai-soup.png" alt="..." />
                          <div class="card-body ps-0">
                            <h5 class="fw-bold text-1000 text-truncate mb-1">タイスープ</h5>
                            <div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="850">¥850<small class="fw-normal">（税込）</small></span>
                          </div>
                        </div>
                        <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                      </div>
                    </div>
                  </div>
                </div>
                <button class="carousel-control-prev carousel-icon" type="button" data-bs-target="#carouselPopularItems" data-bs-slide="prev"><span class="carousel-control-prev-icon hover-top-shadow" aria-hidden="true"></span><span class="visually-hidden">前へ</span></button>
                <button class="carousel-control-next carousel-icon" type="button" data-bs-target="#carouselPopularItems" data-bs-slide="next"><span class="carousel-control-next-icon hover-top-shadow" aria-hidden="true"></span><span class="visually-hidden">次へ </span></button>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->




      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="pb-5 pt-8">

        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="card card-span mb-3 shadow-lg">
                <div class="card-body py-0">
                  <div class="row justify-content-center">
                    <div class="col-md-5 col-xl-7 col-xxl-8 g-0 order-0 order-md-1"><img class="img-fluid w-100 fit-cover h-100 rounded-top rounded-md-end rounded-md-top-0" src="assets/img/gallery/crispy-sandwiches.png" alt="..." /></div>
                    <div class="col-md-7 col-xl-5 col-xxl-4 p-4 p-lg-5">
                      <h1 class="card-title mt-xl-5 mb-4">お得なセール <span class="text-primary"> クリスピーサンド</span></h1>
                      <p class="fs-1">ボリューム満点のサンドイッチで食事を楽しもう。</p>
                      <div class="d-grid bottom-0"><a class="btn btn-lg btn-primary mt-xl-6" href="#!">注文に進む<i class="fas fa-chevron-right ms-2"></i></a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->




      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-0">

        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="card card-span mb-3 shadow-lg">
                <div class="card-body py-0">
                  <div class="row justify-content-center">
                    <div class="col-md-5 col-xl-7 col-xxl-8 g-0 order-md-0"><img class="img-fluid w-100 fit-cover h-100 rounded-top rounded-md-start rounded-md-top-0" src="assets/img/gallery/fried-chicken.png" alt="..." /></div>
                    <div class="col-md-7 col-xl-5 col-xxl-4 p-4 p-lg-5">
                      <h1 class="card-title mt-xl-5 mb-4">パーティーには <span class="text-primary">フライドチキン</span></h1>
                      <p class="fs-1">レモンチリ味のおいしいフライドチキン。お得なセールをチェック。</p>
                      <div class="d-grid bottom-0"><a class="btn btn-lg btn-primary mt-xl-6" href="#!">注文に進む<i class="fas fa-chevron-right ms-2"></i></a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->




      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="pt-5">

        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="card card-span mb-3 shadow-lg">
                <div class="card-body py-0">
                  <div class="row justify-content-center">
                    <div class="col-md-5 col-xl-7 col-xxl-8 g-0 order-0 order-md-1"><img class="img-fluid w-100 fit-cover h-100 rounded-top rounded-md-end rounded-md-top-0" src="assets/img/gallery/pizza.png" alt="..." /></div>
                    <div class="col-md-7 col-xl-5 col-xxl-4 p-4 p-lg-5">
                      <h1 class="card-title mt-xl-5 mb-4">熱々でスパイシーな <span class="text-primary">ピザはいかが？</span></h1>
                      <p class="fs-1">友達とシェアして、熱々サクサクのピザを楽しもう。お得なセールでお試しください。</p>
                      <div class="d-grid bottom-0"><a class="btn btn-lg btn-primary mt-xl-6" href="#!">注文に進む<i class="fas fa-chevron-right ms-2"></i></a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->


      <section class="py-0">
        <div class="bg-holder" style="background-image:url(assets/img/gallery/cta-two-bg.png);background-position:center;background-size:cover;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
          <div class="row flex-center">
            <div class="col-xxl-9 py-7 text-center">
              <h1 class="fw-bold mb-4 text-white fs-6">お得なセールで <br />注文してみませんか？ </h1><a class="btn btn-danger" href="#"> 注文に進む<i class="fas fa-chevron-right ms-2"></i></a>
            </div>
          </div>
        </div>
      </section>


      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-0 pt-7 bg-1000">

        <div class="container">
          <div class="row justify-content-lg-between">
            <h5 class="lh-lg fw-bold text-white">主な配達エリア</h5>
            <div class="col-6 col-md-4 col-lg-auto mb-3">
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">東京</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">大阪</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">名古屋</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">横浜</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">京都</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-auto mb-3">
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">福岡</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">札幌</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">神戸</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">仙台</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">広島</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-auto mb-3">
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">岡山</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">千葉</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">埼玉</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">静岡</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">新潟</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-auto mb-3">
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">熊本</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">鹿児島</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">金沢</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">松山</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">長崎</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-auto mb-3">
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">奈良</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">岐阜</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">宇都宮</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">松山</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">那覇</a></li>
              </ul>
            </div>
          </div>
          <hr class="text-900" />
          <div class="row">
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-3">
              <h5 class="lh-lg fw-bold text-white">会社情報</h5>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">私たちについて</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">チーム</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">採用情報</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">ブログ</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2 col-lg-3 mb-3">
              <h5 class="lh-lg fw-bold text-white">お問い合わせ</h5>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">ヘルプ・サポート</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">加盟店募集 </a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">配達員募集</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">配達員募集</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-3">
              <h5 class="lh-lg fw-bold text-white">規約・ポリシー</h5>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">利用規約</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">返金・キャンセル</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">プライバシーポリシー</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">Cookieポリシー</a></li>
              </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-3">
              <h5 class="lh-lg fw-bold text-white">規約・ポリシー</h5>
              <ul class="list-unstyled mb-md-4 mb-lg-0">
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">利用規約</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">返金・キャンセル</a></li>
                <li class="lh-lg"><a class="text-200 text-decoration-none" href="#!">プライバシーポリシー</a></li>
              </ul>
            </div>
            <div class="col-12 col-md-8 col-lg-6 col-xxl-4">
              <h5 class="lh-lg fw-bold text-500">フォローする</h5>
              <div class="text-start my-3"> <a href="#!">
                  <svg class="svg-inline--fa fa-instagram fa-w-14 fs-2 me-2" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="#BDBDBD" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                  </svg></a><a href="#!">
                  <svg class="svg-inline--fa fa-facebook fa-w-16 fs-2 mx-2" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="#BDBDBD" d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"></path>
                  </svg></a><a href="#!">
                  <svg class="svg-inline--fa fa-twitter fa-w-16 fs-2 mx-2" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="#BDBDBD" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                  </svg></a></div>
              <h3 class="text-500 my-4">限定のお得な情報を <br />メールでお届けします</h3>
              <div class="row input-group-icon mb-5">
                <div class="col-auto"><i class="fas fa-envelope input-box-icon text-500 ms-3"></i>
                  <input class="form-control input-box bg-800 border-0" type="email" placeholder="メールアドレスを入力" aria-label="email" />
                </div>
                <div class="col-auto">
                  <button class="btn btn-primary" type="submit">登録する</button>
                </div>
              </div>
            </div>
          </div>
          <hr class="border border-800" />
          <div class="row flex-center pb-3">
            <div class="col-md-6 order-0">
              <p class="text-200 text-center text-md-start">© 2026 NK-EATS. All rights reserved.</p>
            </div>
            
          </div>
        </div><!-- end of .container-->

      </section>
      <!-- <section> close ============================-->
      <!-- ============================================-->


    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->




    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="vendors/@popperjs/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/nk-cart.js?v=20261124-no-double-add"></script>

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&amp;display=swap" rel="stylesheet">
    <script>
      document.addEventListener('DOMContentLoaded', async () => {
        try {
          const response = await fetch('/api/products?t=' + Date.now(), { headers: { 'Accept': 'application/json', 'Cache-Control': 'no-cache' } });
          const data = await response.json();
          const products = data.products || [];
          const esc = value => String(value ?? '').replace(/[&<>"']/g, char => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#039;' }[char]));

          const renderCarousel = (sectionId, category, title) => {
            let section = document.querySelector(sectionId);
            if (!section) {
              const western = document.querySelector('#western-menu');
              section = document.createElement('section');
              section.id = sectionId.replace('#', '');
              section.className = 'py-4 overflow-hidden';
              western?.insertAdjacentElement('afterend', section);
            }

            const list = products.filter(product => product.category === category);
            const carouselId = sectionId === '#western-menu' ? 'carouselWesternMenu' : 'carouselNepaliMenu';
            const chunks = [];
            for (let i = 0; i < list.length; i += 5) chunks.push(list.slice(i, i + 5));

            section.innerHTML = `<div class="container"><div class="row h-100"><div class="col-lg-7 mx-auto text-center mt-7 mb-5"><h5 class="fw-bold fs-3 fs-lg-5 lh-sm">${esc(title)}</h5></div><div class="col-12"><div class="carousel slide" id="${carouselId}" data-bs-touch="false" data-bs-interval="false"><div class="carousel-inner">${(chunks.length ? chunks : [[]]).map((chunk, index) => `
              <div class="carousel-item${index === 0 ? ' active' : ''}"${index === 0 ? ' data-bs-interval="10000"' : ''}><div class="row gx-3 h-100 align-items-center">${chunk.length ? chunk.map(product => `
                <div class="col-sm-6 col-md-4 col-xl mb-5 h-100" data-product-id="${Number(product.id)}">
                  <div class="card card-span h-100 rounded-3"><img class="img-fluid rounded-3 h-100" src="${esc(product.image_url || '/assets/img/gallery/cheese-burger.png')}" alt="${esc(product.name)}" style="height:220px!important;min-height:220px!important;width:100%;object-fit:cover" onerror="this.onerror=null;this.src='/assets/img/gallery/cheese-burger.png'">
                    <div class="card-body ps-0"><h5 class="fw-bold text-1000 text-truncate mb-1">${esc(product.name)}</h5><div><span class="text-warning me-2"><i class="fas fa-map-marker-alt"></i></span><span class="text-primary">NK-EATS</span></div><span class="text-1000 fw-bold" data-price="${Number(product.price)}">¥${Number(product.price).toLocaleString('ja-JP')}<small class="fw-normal">（税込）</small></span></div>
                  </div>
                  <div class="d-grid gap-2"><button class="btn btn-lg btn-danger nk-add" type="button"><i class="fas fa-cart-plus me-2"></i>カートに追加</button></div>
                </div>`).join('') : '<div class="col-12 text-center text-muted py-5">商品がありません。</div>'}</div></div>`).join('')}</div><button class="carousel-control-prev carousel-icon" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev"><span class="carousel-control-prev-icon hover-top-shadow" aria-hidden="true"></span><span class="visually-hidden">前へ</span></button><button class="carousel-control-next carousel-icon" type="button" data-bs-target="#${carouselId}" data-bs-slide="next"><span class="carousel-control-next-icon hover-top-shadow" aria-hidden="true"></span><span class="visually-hidden">次へ</span></button></div></div></div></div>`;

          };

          renderCarousel('#western-menu', '洋食', '洋食');
          renderCarousel('#nepali-menu', 'ネパール料理', 'ネパール料理');
        } catch (error) {
          console.error('Unable to load storefront products', error);
        }
      });
    </script>
  </body>

</html>