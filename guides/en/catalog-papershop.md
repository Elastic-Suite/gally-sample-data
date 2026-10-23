# Le livre & le lièvre - catalog data

> Catalog data sheet. To run the demo, use [`demo-papershop.md`](demo-papershop.md).

A stationery shop, a bookshop and a furniture business under one roof: 250 products, one price list
in euros, one catalog behind three shopfronts (`papershop_fr`, `papershop_en`, `papershop_de`).
French (`papershop_fr`) works best: the products are named in French and all live checks were made
there. Vector search also answers in English and German.

The demo itself is in [demo-papershop.md](demo-papershop.md).

## At a glance

| Item | In this shop |
|---|---|
| Products | 250 |
| Departments | 3: Papeterie 90, Livres 90, Mobilier 70 |
| Languages | French `papershop_fr`, English `papershop_en`, German `papershop_de` |
| Categories | 54, four levels, one of them built by a rule |
| Prices | 1.20 € to 1290 €, the widest range of the four shops |
| Out of stock | 11 products |
| On promotion | 51 products |
| Articles | 18, the most per product of any shop, each linking to real products |
| Product types | 199 simple, 51 with variants (some notebooks in three colours); each range has its own attributes |
| Autocomplete attributes | 6: brand, material, colour, ruling, binding, author |

## Categories

Ids, facets and counts measured live on `papershop_fr`.

| Category | Id | Products | What is special |
|---|---|---|---|
| Le livre & le lièvre (root) | `cat_llv_1` | 250 | facets: Catégorie, Prix, Disponibilité, Nouveauté, En promotion, Marque, Pays de fabrication; its first 3 products fill the homepage "Notre sélection" |
| Papeterie | `cat_llv_2` | 90 | adds Matière, Couleur, Matières durables; no Réglure at this level |
| Cahiers scolaires | `cat_llv_4` | 8 | adds Grammage, Réglure (6 values), Format, Reliure, Nombre de pages |
| Livres | `cat_llv_20` | 90 | adds Format, Reliure, Auteur, Langue du texte, Nombre de pages, Année de parution |
| Littérature classique | `cat_llv_22` | 12 | Auteur: Charles Dickens 2, Jane Austen 2, Victor Hugo 2, and more |
| Mobilier | `cat_llv_38` | 70 | adds Matière, Couleur, Matières durables, Largeur, Hauteur, Profondeur, Montage nécessaire; no Auteur |
| Bureaux | `cat_llv_40` | 8 | default sort is by position; prices 189 € to 829 € |
| Accessoires d'atelier | `cat_llv_52` | 5 | book ends only, though 25 products carry the brand Lumen Atelier |
| Sélection éco-responsable | `cat_llv_54` | 104 | rule-built: every product flagged sustainable; green "Éco" label, never on a book |

## Products worth knowing

| SKU | Name | Why |
|---|---|---|
| `LLV-PAP-AGE-008` | Agenda Vannerie, Poche | sustainable and on promotion at once - both marks on one card, opposite corners |
| `LLV-MOB-FAU-004` | Fauteuil de lecture Pigeonnier | 1290 €, top of the range, with width, height and depth |
| `LLV-PAP-CRA-003` | Crayon graphite Vannerie | 1.20 €, bottom of the range; first on a price sort |
| `LLV-LIV-CLA-001` | Orgueil et Préjugés - édition intégrale | a book: author, page count, year; no related rule, so the product page shows its 4 cross-sell products |
| `LLV-PAP-CAH-001` | Cahier piqué Volute | ten filters (the most, shared by every school notebook) and three colours |
| `LLV-PAP-CRO-002` | Carnet de croquis Estampe | out of stock, so "add to cart" is disabled |
| `LLV-PAP-PLU-001` | Stylo plume Encrier | no cross-sell rule, so the cart shows no recommendation strip |

## Searches worth knowing

| Term | Language | Measured result | What it shows |
|---|---|---|---|
| `papier` | `papershop_fr` | 49; all five suggestion sections filled | sustainable boost fires; popular searches: papier dessin, papier machine, papier aquarelle |
| `atelier` | `papershop_fr` | 25: Papeterie 12, Livres 5, Mobilier 8 | three ranges on one page; all 25 come from the brand Lumen Atelier |
| `chêne` | `papershop_fr` | 23, all furniture | brands Chêne & Fer 15, Boisclair 5 |
| `cahier` | `papershop_fr` | 8 | popup offers Marque, Matière, Couleur, Réglure, Reliure |
| `cahir`, `stilo`, `crayom`, `ajenda` | `papershop_fr` | 39, 15, 15, 8 | typos recovered (`stilo` = `stylo`, `ajenda` = `agenda`) |
| `krayon`, `kaier`, `karnet`, `buro`, `chèze` | `papershop_fr` | 15, 35, 8, 30, 28 | phonetic matches, low scores |
| `voyage` | `papershop_fr` | 8 | name matches rank above description matches |
| `édition` | `papershop_fr` | 69 | 1 product on promotion in the top 8 |
| `siège`, `rentrée` | `papershop_fr` | 0, 0 | no thesaurus covers them; `chaise` 8, `fauteuil` 7 |
| `pen` / `stylo` | `papershop_fr` / `papershop_en` | the fountain pens | synonym across languages |
| `austen` | `papershop_fr` | found from the suggestions | author attribute in autocomplete |
| "furnish a home office" | `papershop_en` | 0 from the search box; vector page: a desk, a desk chair, a desk lamp | intent across a range |
| "siège de bureau" | `papershop_fr` | 0 from the search box; vector page: office chairs | search by meaning |
| "Füllfederhalter" | `papershop_de` | 0 from the search box; vector page: every fountain pen | the shop says "Füllhalter" |

## Merchandising configured

- **Boosts**
  - "Éco-responsable en tête" - active, +100, all three shopfronts. Lifts sustainable products on
    searches containing `papier` or `paper`, and in `cat_llv_54`.
  - "Reliure du Nord en tête" - inactive, +80, brand = Reliure du Nord, on any search. Switched on:
    `cahier` puts the two Reliure du Nord notebooks first, `carnet` moves its sketchbook from 4th
    to 1st. `papier` does not change, the eco boost already decides it.
- **Thesaurus**
  - synonym `stylo` = `pen` (all three shopfronts)
  - expansion `carnet` -> `cahier`, `bloc` (`papershop_fr` only, one way)
- **Rule-built (virtual) category** - "Sélection éco-responsable" `cat_llv_54`, 104 of 250 products.
- **Recommenders** - 42 cross-sell, 24 upsell, no related. The product page falls back to
  cross-sell; the cart shows cross-sell; upsell is not shown.
- **Autocomplete attributes** - `llv_brand`, `llv_material`, `llv_color`, `llv_ruling`,
  `llv_binding`, `llv_author`. "Pays de fabrication" is not flagged.
- **Popular searches** - the fixtures hold 76 `papershop_fr` search events on 43 terms, none
  misspelt, none with zero results. Examples: `rom` -> roman policier, romans ados; `sey` -> seyès;
  `hug` -> hugo.
- **Vector search** - the vector search page offers suggested queries measured on this shop; the
  last one is a control that keyword search handles in French and English. "Use on no result" is
  off. Switched on, it rescues "siège de bureau", "meubler un bureau" and "histoire de détective",
  but returns about 173 products for any phrase, even `zzqx`.

## Known gaps

- The price filter range is wrong on every page: on the whole catalog it stops at 10 euros. The
  price sort works.
- The search history has no misspellings in it. Spelling tolerance in the search itself works, see the typos above.
- All 90 books show "Langue du texte: Anglais", French titles included.
- The popularity value of every suggested search term is 0.
- In German the vector control query "Märchen" also returns 0 from the search box.
- Variants are shallow: 51 products have them, but nothing compares with the 27-variant shoe of
  Fiora Fashion.
- The 24 upsell rules pair books with unrelated books - *Les Misérables* with a pocket edition of
  *La Lettre volée* - and the storefront does not show upsell.
- "Matières durables" is hidden on the root category: only 160 of 250 products carry a value.
- In the admin, the first save of a category's default sorting or virtual rule returned HTTP 500
  twice; the same save again worked.

## Sources

Figures carried over from the earlier demo script (measurement date not recorded). Category ids,
facets, searches, boosts and recommenders measured live on `papershop_fr` on 2026-11-02.
Thesaurus and recommender counts recounted from the fixtures (`src/DataFixtures/02_papershop/`).
