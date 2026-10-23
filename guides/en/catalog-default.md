# Venia & Luma - catalog data

> Catalog data sheet. To run the demo, use [`demo-default.md`](demo-default.md).

The original sample shop, and the one the storefront opens on. Three catalogs: **Venia**
(womenswear and jewellery, `com_en` / `com_fr`), **Luma** (sportswear, `fr_en` / `fr_fr`) and a
third, `en_en` / `en_fr`, with nothing indexed. Use **English** (`com_en`): the products are written
in English, so vector search works best there, and the French search history has aged out.

The demos are listed in [README.md](README.md).

## At a glance

| Item | In this shop |
|---|---|
| Products | 85 in Venia. Luma has 183 but nothing configured around them |
| Departments | Venia: accessories and jewellery, tops, bottoms, dresses, plus "Shop The Look" sets |
| Languages | English `com_en` and French `com_fr` for Venia; `fr_en` / `fr_fr` for Luma; `en_en` / `en_fr` empty |
| Categories | 19 |
| Prices | 15 to 156 |
| Out of stock | 22 of the 85, the highest proportion of the four shops |
| On promotion | 9 products |
| Articles | 57, by far the largest editorial section, with suggestions by topic, tag and author |
| Product types | all of them - 70 with variants, plus a bundle, a grouped set and a virtual product |
| Autocomplete attributes | Color, Material, Size, Style |

## Categories

Venia, `com_en`. Product counts come from the fixtures, facets and prices from a live check.

| Category | Id | Products | What is special |
|---|---|---|---|
| Accessories | `cat_3` | 24 | no Size, Style or Brand facet |
| Belts | `cat_4` | 4 | has a Size facet (4 options) |
| Jewelry | `cat_5` | 14 | prices 48 to 156, 8 price buckets |
| Tops | `cat_8` | 24 | Blouses & Shirts 12 + Sweaters 12; Size and Style facets |
| Bottoms | `cat_11` | 24 | prices 78 to 118 |
| Dresses | `cat_14` | 12 | 8 in stock, 4 out; the "Tank dress" boost applies here |
| Shop The Look | `cat_15` | 10 | sets of products shown together |

## Products worth knowing

| SKU | Name or type | Why |
|---|---|---|
| `VSK12` | configurable | 20 colour and size combinations behind one card |
| `VA24` | bundle | the priciest item at 156; contains `VA13-GO-NA` and `VA17-SI-NA` |
| `VA23` | grouped set | three products sold together |
| `VVP01` | virtual | a service rather than an object, and the cheapest thing in the shop |
| `VA13-GO-NA` | simple | on promotion, 78 with 98 struck through, two badges at once; searching the SKU returns `VA24` first |
| `VA17-SI-NA` | simple | out of stock; searching the SKU returns `VA24` first |
| `VA11-GO-NA` | simple | a single material, so it shows the "100 %" badge |
| `VD10` | Claudia Crochet Dress | 11th in the Dresses listing by default, below the five Tank dresses lifted by the boost |

## Searches worth knowing

| Term | Language | Measured result | What it shows |
|---|---|---|---|
| `dress` | `com_en` | 18 products; all five suggestion sections filled | Tank dresses first (boost); popup offers Color, Material, Size, Style |
| `robe` | `com_en` | the same dresses | synonym of `dress`, without the boost |
| `trousers` | `com_en` | 29 pants and shorts | expansion thesaurus; 0 when that thesaurus is off |
| `skrit`, `sweter`, `kardigan` | `com_en` | 13, 16, 7 | misspellings recovered: skirts, sweaters, cardigans |
| `skirts` | `com_en` | 13, same top 3 as `skirt` | plural handled |
| `lace` | `com_en` | 6 | name matches score about 8 times higher than description matches |
| `jewellery`, `wedding guest outfit`, "something to wear to the beach", `gift for my wife` | `com_en` | 0 from the search box | vector search page suggestions that keyword search cannot answer |
| `cardigan` | `com_en` | keyword search handles it | the control among the vector search suggestions |

## Merchandising configured

- **Boost "Tank dress"** - active, +100, `com_en` and `com_fr`. Lifts products whose name contains
  "Tank" on searches containing "Dress" and in the Dresses category `cat_14`. Five Tank dresses
  lead both. Not applied to `robe`.
- **Thesaurus**
  - synonym `robe` = `dress` (`com_en`, `com_fr`, `fr_en`)
  - expansion `trousers` -> `pants`, `shorts` (`com_en`, `fr_en`)
  - expansion `blazer` -> `jackets`, `tanks`, scoped by locale (fr_FR, fr_CA), so it reaches every
    French shopfront
- **Rule-built (virtual) categories** - none.
- **Recommenders** - none.
- **Autocomplete attributes** - `fashion_color`, `fashion_material`, `fashion_size`,
  `fashion_style`.
- **Popular searches** - `com_en` suggests 10 terms for `dress`; `com_fr` suggests none for `dress`
  or `robe`.
- **Vector search** - the product name is vectorised (shared setting for all shops). The vector
  search page offers five suggestions written for this shop. "Use on no result" is off: a phrase
  such as "something light to wear on a hot day at the beach" returns 0 from the search box.

## Known gaps

- French is weak: the popular-searches list is empty and the product descriptions are in English.
- The third catalog (`en_en` / `en_fr`) has nothing indexed.
- Luma has products and shares a few synonyms with Venia, but no editorial content and no boost.
- No recommenders and no rule-built category. Toolbox Bricolage and Le livre & le lièvre each have
  one rule-built category.
- No Brand facet appears in any `com_en` category: the brand covers 4 of 24 products in
  Accessories, below the display threshold.
- No facet sort order gives sizes as XS, S, M, L, XL.

## Sources

Counts measured on 2026-08-13; searches and pages checked on 2026-10-23; categories, facets and
spelling results checked live on 2026-11-02; per-category product counts taken from the fixtures.
