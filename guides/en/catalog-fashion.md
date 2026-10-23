# Fiora Fashion - catalog data

> Catalog data sheet. To run the demo, use [`demo-fashion.md`](demo-fashion.md).

An apparel shop: 433 products, almost all sold in several colours and sizes, one price list in
euros, one catalog behind three shopfronts (`fashion_fr`, `fashion_en`, `fashion_de`). French is the
reference language and works for search and suggestions. Use English for vector search: the model
is English-first.

The demos are listed in [README.md](README.md).

## At a glance

| Item | In this shop |
|---|---|
| Products | 433, of which 409 sold in several colours or sizes |
| Departments | 6: Femme 201, Homme 55, Chaussures 50, Sacs & Maroquinerie 35, Accessoires & Bijoux 52, Sport & Performance 40 |
| Languages | French `fashion_fr`, English `fashion_en`, German `fashion_de` |
| Categories | 63, four levels deep, tied with papershop as the deepest shop |
| Prices | 12.90 € to 349.90 € |
| Out of stock | 20 products, spread across every department |
| On promotion | 72 products, each with its old price struck through |
| Articles | 15, found by the same search box as the products |
| Product types | widest product: 27 colour and size combinations, on each of 50 shoes |
| Autocomplete attributes | colour, fabric, brand |

## Categories

Product counts from the fixtures; facets measured live on `fashion_en`.

| Category | Id | Products | What is special |
|---|---|---|---|
| root | `cat_fio_1` | 433 | facets: Category, Price, Availability, New, On sale, Colour, Brand |
| Robes & Combinaisons (Dresses & Jumpsuits) | `cat_fio_16` | 40 | adds Clothing size, Dress length, Occasion, Dress fabric, Backless, Dress colour; the promotions boost applies here |
| Robes de soirée (Evening Dresses) | `cat_fio_20` | 8 | matches the article "Choisir sa robe de soirée" |
| Chaussures (Shoes) | `cat_fio_44` | 50 | adds Shoe size, Heel height, Shoe material, Sole type, Vegan |
| Baskets & Sneakers (Trainers & Sneakers) | `cat_fio_45` | 8 | home of the 27-variant trainer |
| Accessoires & Bijoux (Accessories & Jewelry) | `cat_fio_54` | 52 | no Colour facet, only Brand |

## Products worth knowing

| SKU | Name | Why |
|---|---|---|
| `FIO-CHA-BA-001` | Essential minimalist white leather trainer | 27 colour and size combinations on one card, like 49 other shoes |
| `FIO-FRO-RC-001` | Washed linen mini dress Riviera | eight filters, the most of any product - 40 dresses tie |
| `FIO-MAN-BC-001` | Lambskin leather biker jacket Rebel | 349.90 €, top of the range |
| `FIO-LIN-CS-002` | Seconde Peau laser-cut microfibre thong | 12.90 €, bottom of the range |
| `FIO-FTP-BL-001` | Silk pussy-bow blouse Natural | related: 3 other tops (`BL-002`, `BL-003`, `BL-005`); cross-sell: cigarette trousers, pencil skirt, Diva 85 pumps, quilted bag `FIO-ACC-SM-002` |
| `FIO-FTP-BL-002` | Cold shoulder V-neck top Grace | on promotion, 39.90 € with 49.90 € struck through |
| `FIO-FTP-BL-003` | Sheer chiffon blouse Cloud | out of stock, so "add to cart" is disabled |
| `FIO-FTP-TS-001` | Essential organic cotton T-shirt | related and cross-sell rules, like the blouse |

## Searches worth knowing

| Term | Language | Measured result | What it shows |
|---|---|---|---|
| `lin` | `fashion_fr` | six of the seven suggestion sections, all but popular searches | richest suggestion panel |
| `robe` | `fashion_fr` | top 6 all on promotion | promotions boost fires; 8 popular-search suggestions |
| `jupe` | `fashion_fr` | plain relevance order | no boost on this term |
| `robe` | `fashion_en` | the dresses | synonym `robe` = `dress` = `kleid`; `Kleid` works in German |
| `dress` | `fashion_en` | top 6 all on promotion; 9 popular-search suggestions | boost; popup offers Colour and Brand |
| `bracellet`, `dres`, `neckless`, `Ohringe` | fr, en, en, de | the right products | misspellings recovered |
| `robe de soirée` | `fashion_fr` | 10 products and 2 articles | editorial and products in one search |
| `leather` | `fashion_en` | 100, 22 of them LuxeLine | the query where the inactive LuxeLine boost shows when switched on |
| "something to wear to the beach" | `fashion_en` | 0 from the search box; vector page: a beach poncho, swim shorts | search by meaning |
| "tenue de soirée" | `fashion_fr` | 0 from the search box; vector page: two evening dresses in the top four | French short phrases work |

## Merchandising configured

- **Boosts**
  - "Promotions en tête" - active, +100, all three shopfronts. Lifts products on sale on searches
    containing `robe` or `dress`, and in `cat_fio_16`. Switched off, `dress` becomes a flat,
    mixed order.
  - "LuxeLine en tête" - inactive, +80, brand = LuxeLine (41 of 433 products), on any search.
    Switched on: `leather` gets five LuxeLine products in the top 5; `dress` and `coat` do not
    change, because no LuxeLine dress exists.
- **Thesaurus**
  - synonym `robe` = `dress` = `kleid` (all three shopfronts)
  - expansion `veste` -> `manteau`, `trench` (`fashion_fr` only, one way)
- **Rule-built (virtual) categories** - none.
- **Recommenders** - 52 related, 49 cross-sell, 61 upsell, one per product, all rules set by hand.
  The storefront shows related ("You May Also Like") and cross-sell (cart), not upsell. When related
  is empty, the product page falls back to cross-sell.
- **Autocomplete attributes** - `fio_color`, `fio_fabric`, `fio_brand`. "Dress length" is not
  flagged.
- **Vector search** - the vector search page offers suggested queries measured on this shop: the
  first ones return 0 from the search box, the last one is a control that keyword search handles.
  In German only the first two return 0: `Abendkleid` finds four.

## Known gaps

- No sortable product specification. The sort list offers relevance, name, price, availability and
  creation date, plus Accessory_brand and Date_of_manufacture, raw labels from another shop.
- No rule-built category. Toolbox Bricolage and Le livre & le lièvre each have one.
- Recommendations are rules, not learned from tracking data. A product without a rule shows no
  strip. The 61 upsell rules are not shown anywhere.
- Some SKUs carry a different product name per language, with the same price, stock and category:
  `FIO-FTP-BL-002` is "Top fluide imprimé floral Printemps" in French and "Cold shoulder V-neck top
  Grace" in English; `FIO-FTP-BL-003` is "Blouse à volants col montant Victoire" and "Sheer chiffon
  blouse with ribbon collar Cloud".
- The article pages do not link to products.
- The vector model is English-first: keep French and German queries to short phrases.

## Sources

Figures carried over from the earlier demo script (measurement date not recorded). Facets, boosts,
suggestions and recommenders of `fashion_en` / `fashion_fr` checked live on 2026-11-02. Category
counts, thesaurus and recommender counts recounted from the fixtures (`src/DataFixtures/01_fashion/`).
