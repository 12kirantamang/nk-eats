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
window.NKEATS_CATEGORY_NAMES = {
  '洋食': '洋食',
  'ネパール料理': 'ネパール料理'
};
