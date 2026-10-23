[Français](../fr/demo-toolbox.md)

# Gally demo guide - Toolbox Bricolage

> Demo script. For this shop's facts and numbers, see [`catalog-toolbox.md`](catalog-toolbox.md).

This guide runs a Gally demo in two windows: the back office and the example storefront. You do
something in the back office, reload the shop, and show what appeared.

- **Audience:** a merchant or a product owner - someone who will use the back office.
- **The question it answers:** "what do I control, and what do I get without doing anything?"
- **You need:** basic Gally knowledge (what a catalog, a facet and a boost are) and a local stack
  with the sample data loaded.
- **Shop used:** Toolbox Bricolage (`toolbox_fr`): power tools, hand tools, paint, garden and
  safety gear, in French. Its facts and references are in [`catalog-toolbox.md`](catalog-toolbox.md).
- **Length:** about 30 minutes, or 20 without part 1.

The guide has three parts:

1. **What Gally does on its own** - nothing configured, shop only.
2. **Action and reaction** - 12 back office actions. Each one adds to the previous ones. Nothing
   is undone until the end of the demo.
3. **The other direction** - what the shop sends back to the back office.

---

## Before you start

1. Open the shop: `https://demo.gally.dev/example/toolbox_fr`. The homepage must load.
2. Open the back office: `https://demo.gally.dev/`. Log in with `admin@example.com` /
   `apassword`.
3. Put the two windows side by side. Keep the shop window **wider than 768 pixels**: narrower,
   the search popup switches to tabs (Products, Blog, Suggestions) and shows only the Products tab
   until you click another one.
4. Check the starting state in the shop:
   - search `clé anglaise` - **2 results**, the Torx and Allen key sets
   - search `printemps` - **0 results**
   - search `gants jardinage` - **0 results**
   - the homepage row "Notre sélection" starts with Ponceuse à bande 900W 75 x 533 mm

   If any of these differ, a previous demo was not undone. Go to [Reset](#reset) first.

Good to know:

- **A change shows when you reload the shop page.** Nothing is cached between the shop and Gally.
- **Three things need a full reload (F5):** the sort options, the category menu and the list of
  shops. The shop reads them once per browser tab.
- **Back office labels are in English** in this guide, as the back office shows them.
- **Do the steps in order, and keep every change.** Each step was checked with all the previous
  ones still in place. The order matters: for example, step 2.3 gives results to every search that
  had none, so the "0 results" steps come before it. Undo everything at the end, with [Reset](#reset).

## Two ways to search

This guide uses two different words for two different screens. Do not mix them up.

| The guide says | What you do | What you look at |
|---|---|---|
| **Type** `word` | Type the word in the search box, then stop. **Do not press Enter.** | The small window that opens under the search box (the popup): suggested searches, filters, a few products. |
| **Search** `word` | Type the word, then **press Enter**. | The results page: every matching product, with the filters on the side. |

The two screens do not always show the same products in the same order. A back office setting
can change one and not the other.

## Overview

| Step | Where | Action | What the audience sees |
|---|---|---|---|
| 1.1 | shop | open three categories | different filters in each, with no setting |
| 1.2 | shop | tick a brand | counts that stay complete |
| 1.3 | shop | search with typos | the right products anyway |
| 1.4 | shop | search `carrelage` | names ranked above descriptions |
| 1.5 | shop | type in the search box | suggestions that follow the query |
| 1.6 | shop | type, then search `peinture` | products and articles from one search box |
| 2.1 | back office | create a synonym | 2 wrong results become 3 wrenches |
| 2.2 | back office | create an expansion | 0 results become 15 garden products |
| 2.3 | back office | turn on vector search on no result | short phrases find gloves and glasses |
| 2.4 | back office | enable a prepared boost | brushless tools take the top |
| 2.5 | back office | create a boost | products on promotion take the top |
| 2.6 | back office | pin a product | the homepage changes |
| 2.7 | back office | change a category's default sort | the category opens by price |
| 2.8 | back office | force a facet and move it | a hidden filter appears first |
| 2.9 | back office | add an attribute to autocomplete | a new section in the search box |
| 2.10 | back office | make a category virtual | 6 products become 50 |
| 2.11 | back office | create related products for a category | every measuring tool shows others |
| 2.12 | back office | create a cross-sell between categories | any screwdriver suggests bits |
| 3 | both | open Analyze | the shop's activity in the back office |

---

## Part 1 - What Gally does on its own

No facet in this shop has been configured. Say so first: everything in this part is Gally's
default behaviour.

### 1.1 Filters that follow the category

1. Open the top category, [Tous les produits](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_1), and look at the filters of the whole catalogue (525 products):
   Catégorie, Prix, Disponibilité, Nouveauté, En promotion.
2. Open [Outillage électroportatif](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_10) (61 products). Added: Tension, Type de moteur, Vitesses,
   Sans fil, Marque.
3. Open [Peinture & Décoration > Peintures murales](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_32) (10 products). Those are gone. Added: Couleur, Finition, Rendement,
   Séchage rapide, Marque.
4. Open [Sécurité & EPI](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_68) (35 products). Added: Tailles disponibles, Haute visibilité, Niveau de
   confort.

**Point out:** Gally shows a filter only when at least 90 % of the products on the page have that
attribute. It recomputes this for every page, search and filter. A shop with power tools and paint
gets different filters for each, for free.

### 1.2 Counts that stay complete

1. Open [Outillage électroportatif](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_10) (61 products).
2. In **Marque**, tick **TurboTec**.

**You should see:**

- 9 products.
- The Marque filter still lists every brand with its full count: ForceMax 50, TurboTec 9,
  AtelierPro 1. The shopper can add a second brand.
- Tension now counts only the TurboTec products: 18V 8, 12V 1.

### 1.3 Typos and sound-alikes

1. Search `ponseuse` - the sanders, with the same top three as `ponceuse`.
2. Search `meleuse` - the same 12 results as `meuleuse`.
3. Search `kable` - the same 6 results as `cable`.

**Point out:**

- Steps 1-2 are typo tolerance.
- Step 3 changes the first letter, which typo tolerance never does. It works because the words
  sound alike (phonetic matching).
- There is no "did you mean" message. The shopper just gets results.

### 1.4 The name counts more than the description

1. Search `carrelage` - 10 products.

**You should see:**

- First, four products whose name matches: Disque diamant carrelage, then three tile hole saws
  (Trépan Ø 55, Trépan Ø 35, Coffret 4 trépans).
- Last, six products that mention tiling only in their description, such as Maillet caoutchouc
  and Mastic silicone.

**Point out:** by default the product name weighs ten times more than other fields.

### 1.5 Suggestions that follow the query

1. Type `peinture` and wait - do not press Enter. The attribute sections are Couleur (Blanc, Gris, Noir) and Marque.
2. Type `clé` and wait - do not press Enter. The sections are Matériau (Acier chrome-vanadium, Acier S2) and Marque.
3. Type `sci` and wait - do not press Enter. Section **Recherches populaires** (popular searches): "scie à onglet", "scie circulaire", "scie sabre" and
   others.

In a narrow window, the suggested searches are under the **Suggestions** tab.

**Point out:**

- The merchant chooses which attributes may appear. Gally picks the ones that fit the query, and
  their values.
- The suggested searches come from what shoppers really searched in this shop.

### 1.6 One search box, several kinds of content

1. Type `peinture` and wait - do not press Enter. Under the categories, the popup has a **Blog**
   section: the articles that match the word, the same ones as in step 3. If the popup shows tabs,
   the window is too narrow: click **Blog**.
2. Press Enter. The results page shows 49 products.
3. Switch from **Products** to **Articles**. 2 articles, led by "Quel rouleau pour quelle peinture" and "Peindre un mur sans laisser de traces".

**Point out:**

- Gally indexes more than products. It also indexes categories and CMS content - in this shop,
  the blog articles, which are CMS pages.
- Each kind of content is its own type in Gally, with its own fields, filters and ranking. CMS
  blocks, store pages or FAQ entries can be indexed the same way, as one more type.
- One search box serves all of them. The shop decides how to show each one.

---

## Part 2 - Action and reaction

Every step follows the same pattern:

1. **Before** - show the shop.
2. **Back office** - make one change.
3. **After** - reload the shop and show what appeared.

Do not undo the change: the next step builds on it.

If a category save shows an error, click **Save** again. It works the second time.

### 2.1 Create a synonym

1. **Before:** search `clé anglaise` - **2 results**, and both are wrong: Jeu de 9 clés Torx and
   Jeu de 9 clés Allen. Shoppers say clé anglaise, the catalogue says clé à molette. Both words
   name the same tool.
2. **Back office:** go to **Search > Thesaurus**, click **Create thesaurus**.
3. Fill in:
   - Name: anything, for example "Demo clé anglaise"
   - Enable: on
   - Context type: **Localized catalog**, then Localized catalog(s): Toolbox Français
   - Thesaurus type: **Synonym**
   - Synonyms: `clé anglaise`, `clé à molette`
4. Click **Create**.
5. **After:** search `clé anglaise` - **3 results**, the three adjustable wrenches: Clé à molette
   250 mm chromée FluxPro, Clé à molette 250 mm ouverture 30 mm, Clé à molette 300 mm ouverture
   36 mm. Search `clé à molette` - the same 3.

**Point out:**

- No developer and no reindex. It applies on save.
- A synonym joins words that mean exactly the same thing, in the shop's language: a familiar
  word, a regional word, an abbreviation. It works in every direction.
- A broad word that should bring narrower ones (`luminaire` for bulbs and spots) is not a
  synonym. As a synonym, `ampoule` would also bring spots and floodlights. That is an expansion -
  next step.
- Do not use a thesaurus to translate (`drill` = `perceuse`). Each language has its own catalog
  and its own thesaurus.
- The thesaurus matches the exact words: search `clé` alone still gives the same 18 results.

### 2.2 Create an expansion

1. **Before:** search `printemps` - **0 results**.
2. **Back office:** **Search > Thesaurus**, click **Create thesaurus**.
3. Fill in:
   - Name: "Demo printemps", Enable: on
   - Context type: **Localized catalog**, then Localized catalog(s): Toolbox Français
   - Thesaurus type: **Expansion**
   - Reference term: `printemps`
   - Expansion terms: `tondeuse`, `taille-haie`, `arrosage`, `sécateur`, `terreau`
4. Click **Create**.
5. **After:** search `printemps` - **15 results**, 12 of them from the garden range: potting soil,
   secateurs, a watering lance, a watering timer, mowers.

**Point out:** an expansion goes one way. `printemps` brings the mowers; `tondeuse` still returns
its own 5. This is how a merchant prepares a season, or makes a broad word bring the narrower
ones.

### 2.3 Answer searches nobody planned for

1. **Before:** search `gants jardinage` - **0 results**. Same for `lunettes bricolage` and
   `lunettes soudure`.
2. **Back office:** go to **Settings > Configurations**, tab **Vector search**.
3. Set **Configuration applies to:** Toolbox Français.
4. Turn on **Use on no result**. Click **Save**.
5. **After:**
   - `gants jardinage` - three pairs of gloves first
   - `lunettes bricolage` - three pairs of safety glasses first
   - `lunettes soudure` - safety glasses first

**Point out:** when keyword search finds nothing, Gally searches by meaning. The thesaurus covers
the words you expect; this covers the ones you did not.

**Careful:**

- Use only short noun phrases like these. Full sentences ("réparer une fuite", "peindre une
  chambre") give unrelated first rows here.
- The count shows about 100 products, whatever the phrase: it is the **K value** of the same form, not a
  number of relevant products. Talk about the first row, not the number.
- From now on, no search shows "0 results". Every step that starts from 0 comes before this one.

### 2.4 Enable a prepared boost

1. **Before:** search `sans fil` - 44 products, no brushless tool in the first eight.
2. **Back office:** **Merchandize > Boosts**. Open **"Brushless en tête"**. It is shipped
   disabled.
3. Turn on **Enable**. Save.
4. **After:** search `sans fil` - the first six are all the brushless tools.
5. Search `meuleuse` - Meuleuse Brushless goes from 8th to 1st.

**Point out:** a rule can wait, disabled or with dates, and go live at the right time.

**Careful:** use `sans fil` or `meuleuse`. On `scie` or `ponceuse` nothing changes - no brushless
model there.

### 2.5 Create a boost

1. **Before:** search `coffret`. The first two products on promotion are 5th and 19th. Search `scie`:
   no promotion in the first eight.
2. **Back office:** go to **Merchandize > Boosts**, click **Create boost**.
3. Fill in:
   - Name: "Demo promotions", Enable: on
   - Localized catalog(s): Toolbox Français
   - Request type: **Search result**, All search terms
   - Virtual rule: **Add condition > Attribute condition**, **En promotion** is equal **true**
   - Model: **Constant score**, Boost value (%): 100
4. Click **Create**.
5. **After:** search `coffret` - Coffret 25 forets HSS and Coffret 9 scies cloches, both with the
   "En promo" badge, are 1st and 2nd.
6. Search `scie` - Scie à onglet radiale 1800W and Scie circulaire sur table 1500W, both on
   promotion, are 1st and 2nd.

**Point out:**

- The form has a **Preview** block: choose the localized catalog and a search term, then click
  **Preview** to check the rule before saving.
- The boost multiplies the score, it does not override it: products that barely match the search
  stay low even on promotion.
- Boosts add up. The "Brushless en tête" boost of step 2.4 is still on: a brushless tool on
  promotion gets both. On `sans fil`, two drill kits on promotion now come 5th and 6th, among the
  brushless tools.

### 2.6 Pin a product on the homepage

1. **Before:** the homepage row "Notre sélection" shows Ponceuse à bande 900W, Ponceuse vibrante
   1/3 de feuille 220W, Ponceuse excentrique filaire 400W.
2. **Back office:** go to **Merchandize > Categories**.
3. Choose the catalog Toolbox Bricolage and the French locale.
4. Select the **top category** (**Tous les produits**) of the tree.
5. Check that **Default sorting** is **Position**. Pinning is refused otherwise.
   The pin applies to every language of the shop.
6. In the product list, find **Perceuse-visseuse Brushless Kit 2x5Ah** (`TBX-ELP-PV-004`).
7. Click **Pin** and move it to the first place. Click **Save**.
8. **After:** reload the homepage. The drill opens the "Notre sélection" row, with its promotion
   badge.

**Point out:** the homepage row is the whole catalogue in its merchandised order. The merchant
decides what greets the shopper.

### 2.7 Change a category's default sort

1. **Before:** open [Outillage électroportatif > Scies électriques](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_15). Scie circulaire TurboTec (139.90 €) is first.
2. **Back office:** **Merchandize > Categories**, select **Tous les produits > Outillage électroportatif > Scies électriques**.
3. Set **Default sorting** to **Price**. Save.
4. **After:** reload the shop with **F5**. Scies électriques opens cheapest first: Scie sauteuse
   filaire at 69.90 €, and Scie à onglet radiale at 269.90 € last.

### 2.8 Force a facet and move it first

1. **Before:** the whole catalogue has no "Marque" filter. 388 of 525 products have a brand
   (74 %) - under the 90 % rule of step 1.1. Hand tools and accessories have none.
2. **Back office:** go to **Search > Facets**. In the **Categories** panel on the left, under **By
   category**, select the top category, **Tous les produits**.
3. On the **Marque** row:
   - Display: **Displayed**
   - Position: **1**

   There is no Save button: each change is saved at once.
4. **After:** reload. "Marque" is the first filter: ForceMax 71, VoltSafe 55, AtelierPro 50,
   FixMaster 48, and the others.

**Point out:** Gally hid it by default. The merchant decided brands sell, and put them first. The
setting applies to this category only.

### 2.9 Add an attribute to the search box

1. **Before:** type `visseuse`. No voltage section.
2. **Back office:** go to **Settings**, tab **Attributes**.
3. On **Tension**, tick **Displayed in autocomplete**. The box is saved at once, with no
   Save button.
4. **After:** type `visseuse` - a new section Tension: 18V 10, 12V 2, 230V 2.
5. Type `meuleuse` - the same section with 18V 4, 230V 3. The values follow the query.

### 2.10 Make a category virtual

1. **Before:** open [Machines d'atelier > Accessoires d'atelier](https://demo.gally.dev/example/toolbox_fr/category/cat_tbx_84). 6 products.
2. **Back office:** **Merchandize > Categories**, select **Tous les produits > Machines d'atelier > Accessoires d'atelier**.
3. Turn on **Virtual category**.
4. Rule: **Marque** is equal **AtelierPro**. Save - twice if the first save shows an error.
5. **After:** reload. **50 products**: the 6 accessories, the dust extraction range and every
   AtelierPro machine.

**Point out:**

- The shop already has one such category: "Univers 18V sans fil".
- A virtual category keeps itself up to date: a new AtelierPro product appears here on its own.

### 2.11 Create related products for a whole category

1. **Before:** open [Mètre ruban 5 m](https://demo.gally.dev/example/toolbox_fr/product/TBX-OAM-ME-001) (`TBX-OAM-ME-001`). No recommendation strip: the
   measuring tools have no rule.
2. **Back office:** go to **Merchandize > Recommenders > Auto recommenders**, click **Create
   auto recommender**.
3. Fill in:
   - Enable: on, Name: "Demo related"
   - Localized catalog(s): Toolbox Français
   - Applied to: **Related product**
4. Source rule engine - which products get the recommendation:
   1. Click **Add condition**, then **Attribute condition**.
   2. Attribute: **Catégorie**. Operator: **is equal**.
   3. In the category tree, pick **Tous les produits > Outillage à main > Mesure & Traçage**.
5. Target rule engine - what is recommended: the same condition, the same category.
6. Click **Create**.
7. **After:** reload the tape measure. A strip shows six other measuring tools: Mètre ruban 8 m,
   two spirit levels, a laser level, a laser rangefinder, a square.
8. Open **Détecteur de métaux** - it gets six measuring tools too.
9. Open **Scie égoïne**, a hand saw - nothing changed.

**Point out:**

- One rule, no product list: it covers the whole category, and a new measuring tool joins it on
  its own.
- These are rules, not learned from shoppers. The list comes in a fixed order, minus the
  product being viewed - "the same shelf", not a personal recommendation.

### 2.12 Create a cross-sell for the cart

1. **Before:** add [a screwdriver](https://demo.gally.dev/example/toolbox_fr/product/TBX-OAM-TV-001) (`TBX-OAM-TV-001`) to the cart and open the cart. No suggestion
   strip.
2. **Back office:** **Merchandize > Recommenders > Auto recommenders**, click **Create auto
   recommender**.
3. Fill in:
   - Enable: on, Name: "Demo cross-sell"
   - Localized catalog(s): Toolbox Français
   - Applied to: **Cross-sell**
4. Source rule engine: **Catégorie** is equal **Tous les produits > Outillage à main > Tournevis**.
5. Target rule engine: **Catégorie** is equal **Tous les produits > Accessoires & Consommables > Embouts de vissage**.
6. Click **Create**.
7. **After:** reload the cart. A "Complète bien votre panier" strip shows eight bit sets and holders: Coffret
   32 embouts, the PH2, PZ2, T20 and T25 sets, a bit holder, and others.
8. Replace the screwdriver with [another one](https://demo.gally.dev/example/toolbox_fr/product/TBX-OAM-TV-004) (`TBX-OAM-TV-004`) - the same eight. Any screwdriver
   gets them.

**Point out:** drills are not used here on purpose: every drill already has its own cross-sell
rule, so the strip would already be on screen.

---

## Part 3 - The other direction

Every search, product view and add-to-cart in the shop is sent to Gally.

1. In the shop, click the **Gally Insights** button, bottom left. The panel "Ce que Gally sait"
   lists the events the shop sent.
2. In the back office, open **Analyze > Search usage**: searches, products viewed, add-to-carts,
   sessions, and the popular searches table with its conversion rate column.
3. Open **Analyze > Results**. Choose the catalog, the **Request type** (Search result or Category
   listing), then a search term or a category. It shows the ranking; click a row for that
   product's details. Try `sans fil`, with the boost of step 2.4 on.

**Careful:** events are processed every minute, but the delay before the dashboard shows them was
not measured. Run a few searches before the demo rather than counting on it live.

**Point out:** the suggested searches of step 1.5 come from the same data. Gally filters them: no
typos, no search that found nothing, nothing older than 180 days.

---

## If something looks wrong

- **A search shows results where the guide says 0** - the previous demo was not reset, or step
  2.3 is already done. Check Search > Thesaurus and Settings > Configurations, tab Vector
  search.
- **Catégorie, Prix and Disponibilité vanish from the top category after step 2.9 or the reset** - seen twice
  in eight saves of an autocomplete setting. Untick and tick Displayed in autocomplete again.
- **A category save shows an error** - click Save again.
- **The sort did not change** - reload with F5.
- **The popup shows no articles or no suggested searches** - the shop window is 768 pixels wide
  or less, so the popup uses tabs. Widen the window, or click **Blog** or **Suggestions**.
- **A boost changes nothing** - check the search term. Each boost step names the term to use.
- **The cart strip does not appear** - check that a screwdriver, not another product, is in the
  cart.

## What cannot be shown live

These settings are real, but they only apply after the catalog is reindexed. On the demo stack a
reindex means reloading all sample data, which also erases every back office change. Describe
them, do not click them:

- making an attribute searchable, or changing its search weight
- making an attribute sortable (the option appears, but sorting does not work yet)
- "Use category name in product search"
- spellcheck, analyzer and span settings on an attribute
- which fields are vectorised, and their prompts (the "Use on no result" switch is the exception)
- relevance settings (typo tolerance, phonetic, words that must match): they apply at once, but
  nothing on screen shows them

## What is the storefront, not Gally

Do not present these as Gally features:

- hiding a filter that has a single value
- the categories in the search box popup (a text match done in the browser)
- colour swatches, "show more" after five options, the popup waiting for two characters
- the availability rule and the disabled "add to cart" button
- upsell: Gally has upsell rules, but the storefront never shows them

## Things to avoid in this shop

- **Switching the shop to English** - some products have a different name there:
  `TBX-ELP-PO-004` is a belt sander in French and a sheet sander in English.
- **The "Univers 18V sans fil" count in the menu** - it reads 0, although the page lists the
  products. Click through.
- **Misspelling `perceuse` while showing "Sans fil d'abord"** - that shipped boost fires when the
  search contains "perceuse", so `perseuse` finds drills but without the boost.
- **The Tension section on `batterie`** - it shows 18V and 12V only; battery voltage is in a
  separate attribute, so the 36V batteries do not appear there.

## Reset

Run through this list after the demo, or before it if the starting state check failed.

1. Search > Thesaurus - delete "Demo clé anglaise" and "Demo printemps".
2. Settings > Configurations, tab Vector search, Toolbox Français - Use on no result
   **off**.
3. Merchandize > Boosts - delete "Demo promotions"; "Brushless en tête" **disabled**.
4. Merchandize > Categories, top category (**Tous les produits**) - Perceuse-visseuse Brushless Kit 2x5Ah **unpinned**.
5. Merchandize > Categories, **Tous les produits > Outillage électroportatif > Scies électriques** - Default sorting **Position**.
6. Merchandize > Categories, **Tous les produits > Machines d'atelier > Accessoires d'atelier** - Virtual category **off**, rule cleared.
7. Search > Facets, Categories panel, top category (**Tous les produits**), Marque - Display **Auto**, no position.
8. Settings, tab Attributes - Tension, Displayed in autocomplete
   **unticked**.
9. Merchandize > Recommenders > Auto recommenders - delete "Demo related" and "Demo cross-sell".
10. In the shop, empty the cart.
11. Check the starting state again (Before you start, step 4). Also check that the top
    category still shows the Catégorie, Prix and Disponibilité filters - see [If something looks wrong](#if-something-looks-wrong).

Setting a facet or a configuration back stores the default value instead of removing it. The shop
behaves exactly as before.

---

Every step, count and product name was checked on a live instance on 2026-11-02, through the back
office API: the steps in this order, each change kept, then the reset. Step 2.1 was measured on
its own, from the starting state: the cumulative run used another synonym, and no later step
searches a word that `clé anglaise` changes. On 2026-11-09, a Playwright script went through the papershop guide on the back office and
shop screens, and the screen labels in this guide were corrected from that run. The French screens
were checked; the English labels are translations. This guide's counts and product names were not
re-checked on screen: they come from the API check above. The other sample shops are described in their data sheets - see [`README.md`](README.md).
