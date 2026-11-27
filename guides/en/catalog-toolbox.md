# Toolbox Bricolage - catalog data

> Catalog data sheet. To run the demo, use [`demo-toolbox.md`](demo-toolbox.md).

A DIY and hardware shop: 525 products, one price list in euros, one catalog behind three shopfronts
(`toolbox_fr`, `toolbox_en`, `toolbox_de`). French is the reference language. Vector search is
strongest in English (`toolbox_en`); in French it works on short phrases, as demo step 2.3 shows.

The demos are listed in [README.md](README.md).

## At a glance

| Item | In this shop |
|---|---|
| Products | 525, all sold as a single item - no variants |
| Departments | 11: hand tools, power tools, batteries and chargers, accessories, paint, plumbing, electrical, hardware, garden, safety, workshop machines |
| Languages | French `toolbox_fr`, English `toolbox_en`, German `toolbox_de` |
| Categories | 85, three levels, one of them built by a rule |
| Prices | 3.90 € to 699.90 € |
| Out of stock | 11 products |
| On promotion | 38 products |
| Articles | 15 |
| Product types | simple only; 47 filters, 6 of them sortable specifications |
| Autocomplete attributes | brand, tool material, paint colour |

## Categories

Product counts from the fixtures (`toolbox_fr`), except the rule-built one.

| Category | Id | Products | What is special |
|---|---|---|---|
| Outillage électroportatif (Power Tools) | `cat_tbx_10` | 61 | densest filters: Sans fil, Tension, Type de moteur, Vitesses, Marque; no power value, so a power sort does nothing |
| Perceuses & Visseuses (Drills & Drivers) | `cat_tbx_11` | 10 | drills; the cordless ones lead a `perceuse` search |
| Batteries & Chargeurs (Batteries & Chargers) | `cat_tbx_19` | 25 | 12V, 18V, 36V batteries and chargers |
| Protection des yeux (Eye Protection) | `cat_tbx_69` | 5 | part of Sécurité & EPI (Safety & PPE, 35 products) |
| Machines d'atelier (Workshop Machines) | `cat_tbx_76` | 49 | sort by "Puissance (W)" works here, smallest machine first |
| Univers 18V sans fil (18V cordless range) | `cat_tbx_85` | 45 | rule-built: cordless, or 18V battery; in the main menu only |

## Products worth knowing

| SKU | Name or type | Why |
|---|---|---|
| `TBX-ELP-PV-001` | Perceuse-visseuse sans fil ForceMax 18V 50 Nm | one of the 32 cordless products the boost lifts; has related, cross-sell and upsell rules |
| `TBX-MAT-TM-002` | Fraiseuse d'établi AtelierPro | 699.90 €, top of the price range |
| `TBX-PEI-BA-003` | Ruban de masquage peintre bleu | 3.90 €, bottom of the price range |
| `TBX-ELP-SE-008` | Scie à onglet 216 mm 1500W | out of stock, so "add to cart" is disabled |
| `TBX-OAM-TV-005` | Jeu de 7 tournevis isolés 1000V | on promotion, 34.90 € down from 39.90 € |

## Searches worth knowing

| Term | Language | Measured result | What it shows |
|---|---|---|---|
| `perceuse` | `toolbox_fr` | all five suggestion sections: popular searches, brand, products, category, articles | cordless boost fires; article "Bien choisir sa perceuse-visseuse" suggested |
| `ponceuse` | `toolbox_fr` | plain relevance order | no boost on this term |
| `disqueuse` | `toolbox_fr` | the angle grinders | synonym `disqueuse` = `meuleuse` |
| `Bohrschruber` | `toolbox_de` | the right products | misspelling recovered |
| `sandre` | `toolbox_en` | the right products | misspelling of "sander" taken from real search logs, recovered |
| `forcemax` | `toolbox_fr` | three suggestion sections, brand and its products | a brand name |
| "protect my eyes while drilling" | `toolbox_en` | 0 from the search box; vector search page returns safety goggles, a face visor, safety glasses | no product text contains "eyes" or all of the words |

## Merchandising configured

- **Boosts**
  - "Sans fil d'abord" - active, +100, all three shopfronts. Lifts products with Sans fil = yes on
    searches containing `perceuse` or `drill`, and in the category `cat_tbx_85`.
  - "Brushless en tête" - inactive, +80, motor type = brushless, on any search. Shipped off so it
    can be switched on from the admin.
- **Thesaurus**
  - synonyms, one thesaurus per shopfront: `disqueuse` = `meuleuse` (fr), `spanner` = `wrench` (en), `flex` = `winkelschleifer` (de)
  - expansion `visseuse` -> `perceuse`, `tournevis` (`toolbox_fr` only, one way)
- **Rule-built (virtual) category** - "Univers 18V sans fil" `cat_tbx_85`, 45 products: cordless
  tools and 18V batteries.
- **Recommenders** - 154 related, 190 cross-sell, 67 upsell, all rules set by hand. The storefront
  shows related ("You May Also Like" on the product page) and cross-sell (cart), not upsell.
  - `TBX-ELP-PV-001`: related = three other drills; cross-sell = two ForceMax batteries, a charger,
    two drill bit sets, safety glasses; upsell = the same drill as a kit with two 4Ah batteries,
    and the brushless 82 Nm kit.
- **Autocomplete attributes** - `tbx_brand`, `tbx_tool_material`, `tbx_paint_color`.
- **Vector search** - the vector search page offers suggested queries measured on this shop: the
  first ones return 0 from the search box, the last one is a control that keyword search handles.

## Known gaps

- "Univers 18V sans fil" is not listed in the category filter of "Toolbox Bricolage".
- No product has variants, so there is no size or colour picker.
- Power tools carry no power value; sorting them by power does nothing.
- The vector model is English-first. In French, short phrases work: `gants jardinage` brings gloves
  first, `lunettes soudure` safety glasses (measured 2026-11-27). Long sentences in French or German
  were not measured, so keep to short phrases there.
- Some SKUs carry a different product name per language, with the same price, stock and category:
  `TBX-ELP-SE-008` is "Scie à onglet 216 mm 1500W" in French and "Cordless reciprocating saw 18V
  body only ForceMax" in English; `TBX-OAM-TV-005` is a set of 7 insulated screwdrivers in French
  and a single stubby screwdriver in English.
- Recommendations are rules, not learned from tracking data. A product without a rule shows no
  recommendation strip. The 67 upsell rules are not shown anywhere.

## Sources and reproducing

Figures carried over from the earlier demo script (measurement date not recorded). Category
counts, boosts, thesaurus and recommender counts recounted from the fixtures
(`src/DataFixtures/00_toolbox/`) on 2026-11-02.

**Measured live on 2026-11-27**, on a fresh load of this branch:

- synonyms: `disqueuse` and `meuleuse` 12 each in `toolbox_fr`, `spanner` and `wrench` 10 in
  `toolbox_en`, `flex` and `winkelschleifer` 17 in `toolbox_de`
- vector search in `toolbox_fr`: `gants jardinage`, `lunettes bricolage`, `lunettes soudure` return
  0, then gloves or safety glasses first once "Use on no result" is on (demo step 2.3)

**Reproducing**

- Load it with `make fixtures_load catalogs=00_toolbox`. It erases the database and asks for
  confirmation. Do not pipe `y` into it without `catalogs=`: the load is skipped with no message.
  Boosts, thesauri, recommenders and vector search need the premium bundles.
- A figure is **expected** (read from the fixtures in `src/DataFixtures/00_toolbox/`) unless this
  section says it was **measured** live, with its date.
- Measure on a fresh load, or after the demo guide's Reset section. What the demo creates live
  (thesauri, boosts and settings named in its steps) is not in the committed data, and it changes
  search results.
