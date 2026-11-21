/* NK-EATS central menu data (20 items). Put AI images in public/images/<category>/<name>.webp
   -> shown automatically; until then the `fb` fallback image is used. */
const CATEGORIES = [
  { id: 'japanese', jp: '日本料理', en: 'Japanese', icon: '🍜' },
  { id: 'western', jp: '洋食', en: 'Western', icon: '🍝' },
  { id: 'nepali', jp: 'ネパール料理', en: 'Nepali', icon: '🥟' },
  { id: 'fast-food', jp: 'ファストフード', en: 'Fast Food', icon: '🍔' }
];
const G = 'assets/img/gallery/';
const P = (id, cat, file, en, jp, price, desc, fb, featured) => ({
  id, cat, en, jp, price, desc, featured: !!featured,
  img: `images/${cat}/${file}.webp`, fb: G + (fb || 'placeholder.svg')
});
const PRODUCTS = [
  P(1, 'japanese', 'tonkotsu-ramen', 'Tonkotsu Ramen', '豚骨ラーメン', 980, '濃厚クリーミーな豚骨スープに、とろけるチャーシューと半熟味玉をのせた一杯。', 'thai-soup.png', 1),
  P(2, 'japanese', 'karaage', 'Karaage', '唐揚げ', 680, 'サクッとジューシーな日本の定番フライドチキン。レモンとマヨネーズ付き。', 'fried-chicken.png', 1),
  P(3, 'japanese', 'sushi-set', 'Sushi Set', '寿司セット', 1580, 'サーモン、大トロ、海老、玉子焼きなど新鮮な握り寿司の盛り合わせ。', '', 1),
  P(4, 'japanese', 'katsudon', 'Katsudon', 'カツ丼', 890, 'サクサクのとんかつをふわとろ卵と甘い出汁でとじた丼。'),
  P(5, 'japanese', 'gyudon', 'Gyudon', '牛丼', 590, '甘辛く煮込んだ牛肉と玉ねぎをのせた、紅しょうが添えの牛丼。'),
  P(6, 'japanese', 'takoyaki', 'Takoyaki', 'たこ焼き', 480, '外はカリッと中はとろとろ。かつお節と青のりがたっぷり。'),
  P(7, 'western', 'carbonara', 'Carbonara', 'カルボナーラ', 1080, '黄身とパルミジャーノ、カリカリパンチェッタのクリーミーなパスタ。', 'noodles.png', 1),
  P(8, 'western', 'club-sandwich', 'Club Sandwich', 'クラブサンド', 880, 'グリルチキン、ベーコン、野菜をはさんだ三段重ねのサンド。ポテト付き。', 'crispy-sandwiches.png'),
  P(9, 'western', 'chicken-wings', 'Chicken Wings', 'チキンウィング', 780, 'BBQとバッファローの甘辛ソースをたっぷり絡めたウィング。', ''),
  P(10, 'western', 'grilled-chicken', 'Grilled Chicken', 'グリルチキン', 980, 'ハーブでマリネしたジューシーなグリルチキン。ガーリックバターソース。', 'steak.png'),
  P(11, 'nepali', 'chicken-momo', 'Chicken Momo', 'チキンモモ', 780, 'ネパール風蒸し餃子。トマトとごまのアチャールソース付き。', '', 1),
  P(12, 'nepali', 'dal-bhat', 'Dal Bhat', 'ダルバート', 1180, 'ダール、チキンカレー、サグ、アチャールが付いたネパールの定食。', ''),
  P(13, 'nepali', 'chicken-chowmein', 'Chicken Chowmein', 'チキンチャウミン', 850, 'ヒマラヤスパイスで炒めたネパール風焼きそば。', 'chowmein.png'),
  P(14, 'nepali', 'chicken-biryani', 'Chicken Biryani', 'チキンビリヤニ', 1080, 'サフランの香るバスマティ米とマリネしたチキンのビリヤニ。ライタ付き。', ''),
  P(15, 'fast-food', 'cheeseburger', 'Cheeseburger', 'チーズバーガー', 690, 'ジューシーなパティにとろけるチェダーをのせたダブルチーズバーガー。', 'cheese-burger.png', 1),
  P(16, 'fast-food', 'pepperoni-pizza', 'Pepperoni Pizza', 'ペパロニピザ', 1280, 'カリカリのペパロニとモッツァレラがたっぷりの石窯ピザ。', 'pizza.png'),
  P(17, 'fast-food', 'french-fries', 'French Fries', 'フライドポテト', 380, '塩をふったカリッと黄金色のポテト。ケチャップ付き。', ''),
  P(18, 'fast-food', 'chicken-nuggets', 'Chicken Nuggets', 'チキンナゲット', 480, '一口サイズのサクサクナゲット。ハニーマスタードとスイートチリ付き。', ''),
  P(19, 'fast-food', 'hot-dog', 'Hot Dog', 'ホットドッグ', 450, 'パリッとソーセージをふわふわバンズではさんだ定番ホットドッグ。', 'sub-sandwich.png'),
  P(20, 'fast-food', 'fried-chicken', 'Fried Chicken', 'フライドチキン', 750, '衣がサクサクの骨付きフライドチキン。', 'fried-chicken.png')
];
