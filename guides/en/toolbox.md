# Toolbox Bricolage - demo script

A DIY and hardware shop. 525 products, three languages, one price list in euros.

**Show it to** anyone whose catalogue is technical: industrial supply, building trade, spare parts,
anything where a product is described by its specifications rather than by how it looks. This is
the catalogue where filtering does the work.

**Open** the Gally example app and pick "Toolbox Bricolage" (`toolbox_fr`) in the header
selector. The demo lands on another shop by default, so switch before the visitor arrives.

## At a glance

| Item | In this shop |
|---|---|
| Products | 525, all sold as a single item - no variants |
| Languages | French, English, German - one catalogue behind all three |
| Categories | 85, three levels, one of them built by a rule |
| Prices | 3.90 € to 699.90 € |
| Out of stock | 11 products |
| On promotion | 38 products |
| Articles | 15 |
| Filters | 47 - 6 of them sortable specifications |

## Worth knowing by name

Paste a reference into the search box: the results page shows that one product.

| Reference | Why this one |
|---|---|
| `TBX-ELP-PV-001` | one of the 32 cordless products the ranking rule lifts to the top |
| `TBX-MAT-TM-002` | 699.90 €, top of the price range |
| `TBX-PEI-BA-003` | 3.90 €, bottom of it - show the two together on the price filter |
| `TBX-ELP-SE-008` | out of stock, so "add to cart" is genuinely disabled |
| `TBX-OAM-TV-005` | on promotion, 34.90 € down from 39.90 € |

| Search | Why this one |
|---|---|
| `perceuse` | all five suggestion sections, and the ranking rule fires |
| `ponceuse` | the same shop with no rule on it - run it straight after |
| `Bohrschruber` (German shop) | a misspelling, recovered |
| `sandre` (English shop) | another, and a real one from the logs |
| `forcemax` | a brand name: the panel suggests the brand and its products |

**`perceuse` fills the whole suggestion panel.** Popular searches, brand, products, category and
articles all answer. A brand name such as `forcemax` fills only three sections.

## The run - about ten minutes

| | Type or click | What it shows |
|---|---|---|
| 1 | `perceuse`, then `ponceuse` | a ranking rule the merchant set, and its limits |
| 2 | `perceuse` in the English shop | one vocabulary across three languages |
| 3 | `Bohrschruber`, `sandre` | spelling mistakes handled |
| 4 | a power tool category | filtering by specification, sorting by power |
| 5 | "Univers 18V sans fil" | a category that fills itself from a rule |
| 6 | *"protect my eyes while drilling"*, English shop | search by meaning, not by words |

---

### 1. Search `perceuse`, then `ponceuse`

The first search puts cordless drills at the top. The second one, a sander, is an ordinary
relevance ranking.

Nothing in the catalogue changed between the two. Someone decided that on this shop, when a
customer types "perceuse", cordless tools lead - and that decision took effect immediately, with
nothing rebuilt and nobody from the development team involved. Type the two searches back to back
and let the difference speak.

There is a second rule prepared and switched off. If you have admin access, turn it on while the
visitor watches and search again: the order changes in front of them.

### 2. Type `perceuse` in the English shop

Switch the language to English and search the French word. The drills come back anyway.

The same works in German. One product catalogue, three shopfronts, and the words customers
actually use in each of them handled as a vocabulary the merchant maintains - not as three
translations of the data.

### 3. Make a spelling mistake

In the German shop, type `Bohrschruber` - one letter short of "Bohrschrauber". In English, `sandre`
instead of "sander". Both find the right products.

Worth saying out loud: these are not invented for the demo, they are the kind of thing that turns
up in real search logs.

### 4. Open a power tool category and use the filters

This is the densest part of the catalogue. The filters are the product's own specifications: **Sans
fil**, **Tension**, **Type de moteur**, **Vitesses**, **Marque**. Tick a couple and watch the count
fall.

The point for a technical catalogue: the customer narrows by what the tool *does*, not by guessing
which category someone filed it under. To sort by power, open "Machines d'atelier" and pick
"Puissance (W)": the smallest machine comes first. Power tools carry no power value, so the sort
does nothing on them.

### 5. Open "Univers 18V sans fil"

A category in the main menu holding 45 products - the cordless tools and the batteries that fit
them, side by side.

Nobody put a single product in it. It holds whatever matches a rule the merchant wrote, and it
updates itself: add a new 18V tool to the catalogue tomorrow and it appears here, with no one
touching the category.

This is usually the moment that lands hardest with a merchandiser, because it is the one they
currently do by hand.

### 6. Describe a tool instead of naming it

**Switch to the English shop first.** The model behind this only speaks English; in French or
German it returns confident nonsense, and the page gives no warning.

On the vector search page type *"protect my eyes while drilling"*. Back come safety goggles, a
face visor and safety glasses. No product text contains "eyes", and none contains all of the
words.

The ordinary search box returns **zero** for that phrase. Run it there first, then on the vector
search page. That contrast is the demo, and it is the honest claim: vector search does not beat
keyword search everywhere, it answers the questions keyword search cannot answer at all.

---

## If you have more time

- **Prices** run from under 4 euros to nearly 700. The price slider has something to bite on.
- **Out of stock**: eleven products are unavailable, so the availability filter has both sides and
  the "add to cart" button is genuinely disabled on some products.
- **Three languages**: switch between French, English and German on the same page. Categories,
  filters and editorial content all follow.
- **Fifteen articles** sit alongside the products and come up in the search suggestions - "Bien
  choisir sa perceuse-visseuse" is the obvious one to open after the `perceuse` search.
- **Recommendations** - the clearest of the three shops. Open the ForceMax 18V 50 Nm drill
  `TBX-ELP-PV-001`: "You May Also Like" lists three other drills, its related products. Add it to
  the cart: the cart offers two ForceMax batteries, a charger, two drill bit sets and safety
  glasses, its cross-sell. This shop has 154 related and 190 cross-sell rules.

---

## Don't do this

- **Don't look for "Univers 18V sans fil" in the category filter of "Tous les produits".** It is
  not listed there. Open it from the main menu instead.
- **Use the suggested queries on the vector search page - they belong to this shop.** Each one
  was measured here: the first ones return nothing at all from the ordinary search box, and the
  last one is a deliberate control that the ordinary box handles perfectly well. Show the control
  last and say what it proves, or an audience will assume the whole page is rigged.
- **Don't promise a size or colour picker.** Nothing in this shop has variants. Use Fiora Fashion
  for that.
- **Don't present recommendations as learned from shoppers.** They are rules a merchant set up in
  Gally; nothing reads tracking data. Pick a product that has one (the drill above): a product
  without a rule shows no strip at all. The 67 upsell rules - the drill's rule offers the same drill
  as a kit with two 4Ah batteries, and the brushless 82 Nm kit - are not shown anywhere.
