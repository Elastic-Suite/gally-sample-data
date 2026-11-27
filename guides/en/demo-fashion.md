[Français](../fr/demo-fashion.md)

# Gally demo guide - Fiora Fashion

> Demo script. For this shop's facts and numbers, see [`catalog-fashion.md`](catalog-fashion.md).

This guide runs a Gally demo in two windows: the back office and the example storefront. You do
something in the back office, reload the shop, and show what appeared.

- **Audience:** a merchant or a product owner - someone who will use the back office.
- **The question it answers:** "what do I control, and what do I get without doing anything?"
- **You need:** basic Gally knowledge (what a catalog, a facet and a boost are) and a local stack
  with the sample data loaded.
- **Shop used:** Fiora Fashion (`fashion_fr`): women's and men's clothing, shoes, sportswear,
  accessories and jewellery, in French. Its facts and references are in
  [`catalog-fashion.md`](catalog-fashion.md).
- **Length:** about 30 minutes, or 20 without part 1.

The guide has three parts:

1. **What Gally does on its own** - nothing configured, shop only.
2. **Action and reaction** - 12 back office actions. Each one adds to the previous ones. Nothing
   is undone until the end of the demo.
3. **The other direction** - what the shop sends back to the back office.

---

## Before you start

1. Open the shop: `https://demo.gally.dev/example/fashion_fr`. The homepage must load.
2. Open the back office: `https://demo.gally.dev/`. Log in with `admin@example.com` /
   `apassword`.
3. Put the two windows side by side. Keep the shop window **wider than 768 pixels**: narrower,
   the search popup switches to tabs (Products, Blog, Suggestions) and shows only the Products tab
   until you click another one.
4. Check the starting state in the shop:
   - search `futal` - **0 results**
   - search `réveillon` - **0 results**
   - the homepage row "Notre sélection" starts with Robe longue drapée en jersey Muse

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
| 1.4 | shop | search `velours` | names ranked above descriptions |
| 1.5 | shop | type in the search box | suggestions that follow the query |
| 1.6 | shop | type, then search `robe` | products and articles from one search box |
| 2.1 | back office | create a synonym | 0 results become 36 |
| 2.2 | back office | create an expansion | 0 results become 28 evening pieces |
| 2.3 | back office | turn on vector search on no result | short phrases find sunglasses, yoga wear, sandals |
| 2.4 | back office | enable a prepared boost | one brand takes the top |
| 2.5 | back office | create a boost | new products take the top |
| 2.6 | back office | pin a product | the homepage changes |
| 2.7 | back office | change a category's default sort | the category opens by price |
| 2.8 | back office | force a facet and move it | a hidden filter appears first |
| 2.9 | back office | add an attribute to autocomplete | a new section in the search box |
| 2.10 | back office | make a category virtual | 8 products become 39 |
| 2.11 | back office | create related products for a category | every pair of tights shows others |
| 2.12 | back office | create a cross-sell between categories | any cape suggests hats |
| 3 | both | open Analyze | the shop's activity in the back office |

---

## Part 1 - What Gally does on its own

No facet in this shop has been configured. Say so first: everything in this part is Gally's
default behaviour.

### 1.1 Filters that follow the category

1. Open the top category, [Fiora Mode](https://demo.gally.dev/example/fashion_fr/category/cat_fio_1), and look at the filters of the whole catalogue
   (433 products): Catégorie, Prix, Disponibilité, Nouveauté, En promotion, Couleur, Marque.
2. Open [Femme > Robes & Combinaisons](https://demo.gally.dev/example/fashion_fr/category/cat_fio_16) (40 products). Added: Taille vêtement, Occasion, Matière robe,
   Dos nu, Couleur robe, Longueur robe.
3. Open [Chaussures](https://demo.gally.dev/example/fashion_fr/category/cat_fio_44) (50 products). The dress filters are gone. Added: Pointure, Hauteur de
   talon, Matière chaussure, Type de semelle, Vegan.
4. Open [Sport & Performance](https://demo.gally.dev/example/fashion_fr/category/cat_fio_60) (40 products). Added: Taille sport, Tissu technique, Intensité,
   Protection UV, Séchage rapide.

**Point out:** Gally shows a filter only when at least 90 % of the products on the page have that
attribute. It recomputes this for every page, search and filter. Dresses get dress filters and
shoes get shoe filters, for free.

### 1.2 Counts that stay complete

1. Open [Femme > Robes & Combinaisons](https://demo.gally.dev/example/fashion_fr/category/cat_fio_16) (40 products).
2. In **Marque**, tick **PureBasics**.

**You should see:**

- 8 products.
- The Marque filter still lists every brand with its full count: Fiora 28, PureBasics 8,
  UrbanEdge 4. The shopper can add a second brand.
- Occasion now counts only the PureBasics dresses: Casual 4, Bureau 3, Cocktail 1.

### 1.3 Typos and sound-alikes

1. Search `juppe` - 23 results, the same as `jupe`.
2. Search `ecarpin` - 8 results, the same first three as `escarpin`.
3. Search `kachemire` - 9 results, the same as `cachemire`.

**Point out:**

- Steps 1-2 are typo tolerance.
- Step 3 changes the first letter, which typo tolerance never does. It works because the words
  sound alike (phonetic matching).
- There is no "did you mean" message. The shopper just gets results.

### 1.4 The name counts more than the description

1. Search `velours` - 8 products.

**You should see:**

- First, the five products with "velours" in their name: Pantalon velours côtelé Automnal, Sweat
  à capuche velours Cozy, Blazer en velours côtelé Bohème, Robe de soirée en velours Noblesse,
  Escarpin kitten heel en velours Rétro.
- Last, three products whose name does not say velvet: Blouson en daim Seventies and Mocassin
  Tassel mention it in their description, Veste denim Atelier has Velours as its fabric.

**Point out:** by default the product name weighs ten times more than other fields.

### 1.5 Suggestions that follow the query

1. Type `pull` and wait - do not press Enter. The attribute sections are Couleur (Noir, Gris chiné, Beige), Matière
   haut and Marque.
2. Type `cuir` and wait - do not press Enter. Only Couleur and Marque (Fiora, LuxeLine, UrbanEdge).
3. Type `rob` and wait - do not press Enter. Section **Recherches populaires** (popular searches): "robe longue", "robe noire", "robe soirée" and others.

In a narrow window, the suggested searches are under the **Suggestions** tab.

**Point out:**

- The merchant chooses which attributes may appear. Gally picks the ones that fit the query, and
  their values.
- The suggested searches come from what shoppers really searched in this shop.

### 1.6 One search box, several kinds of content

1. Type `robe` and wait - do not press Enter. Under the categories, the popup has a **Blog**
   section: the articles that match the word, the same ones as in step 3. If the popup shows tabs,
   the window is too narrow: click **Blog**.
2. Press Enter. The results page shows 44 products.
3. Switch from **Products** to **Articles**. 4 articles, led by "Choisir sa robe de soirée" and "S'habiller pour un mariage sans se tromper".

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

1. **Before:** search `futal` - **0 results**. Shoppers say futal, the catalogue says pantalon.
   Both words name the same trousers.
2. **Back office:** go to **Search > Thesaurus**, click **Create thesaurus**.
3. Fill in:
   - Name: "Demo futal", Enable: on
   - Context type: **Localized catalog**, then Localized catalog(s): Fiora Français
   - Thesaurus type: **Synonym**
   - Synonyms: `futal`, `pantalon`
4. Click **Create**.
5. **After:** search `futal` - **36 results**, the trousers: Tregging pantalon-legging Hybrid,
   Pantalon palazzo fluide Liberté, Pantalon velours côtelé Automnal, and more.
6. Search `pantalon` - the same 36, in the same order.

**Point out:**

- No developer and no reindex. It applies on save.
- A synonym joins words that mean exactly the same thing, in the shop's language: a familiar
  word, a regional word, an abbreviation. It works in every direction.
- A broad word that should bring narrower ones (`anorak` for down jackets, parkas and
  windbreakers) is not a synonym. As a synonym, `parka` would also bring down jackets. That is an
  expansion - next step.
- Do not use a thesaurus to translate (`dress` = `robe`). Each language has its own catalog and
  its own thesaurus.
- The thesaurus matches the exact word. Keep to single words: `cache-nez`, with its hyphen, did
  not match `écharpe` in a test.

### 2.2 Create an expansion

1. **Before:** search `réveillon` - **0 results**.
2. **Back office:** **Search > Thesaurus**, click **Create thesaurus**.
3. Fill in:
   - Name: "Demo réveillon", Enable: on
   - Context type: **Localized catalog**, then Localized catalog(s): Fiora Français
   - Thesaurus type: **Expansion**
   - Reference term: `réveillon`
   - Expansion terms: `soirée`, `sequins`, `paillettes`, `fourreau`, `taffetas`
4. Click **Create**.
5. **After:** search `réveillon` - **28 results**, evening pieces first: Robe bustier taffetas
   Opéra, Escarpin pailleté Sparkle, Robe fourreau pailletée Midnight, then more evening dresses, a
   satin mule and a clutch further down.

**Point out:** an expansion goes one way. `réveillon` brings the evening dresses; `soirée` still
returns its own 27. This is how a merchant prepares a season, or makes a broad word bring the
narrower ones.

### 2.3 Answer searches nobody planned for

1. **Before:** search `lunettes soleil femme` - **0 results**. Same for `tenue yoga` and
   `sandales plage`.
2. **Back office:** go to **Settings > Configurations**, tab **Vector search**.
3. Set **Configuration applies to:** Fiora Français.
4. Turn on **Use on no result**. Click **Save**.
5. **After:**
   - `lunettes soleil femme` - three pairs of sunglasses first
   - `tenue yoga` - Legging yoga Zen, Short yoga Flow, Sweat Pilates
   - `sandales plage` - three pairs of sandals first

**Point out:** when keyword search finds nothing, Gally searches by meaning. The thesaurus covers
the words you expect; this covers the ones you did not.

**Careful:**

- Use only these three phrases. Phrases with "chaussures" bring socks first, and `tenue de plage`
  brings a wallet.
- The count shows about 100 products, whatever the phrase: it is the **K value** of the same form, not a
  number of relevant products. Talk about the first row, not the number.
- From now on, no search shows "0 results". Every step that starts from 0 comes before this one.

### 2.4 Enable a prepared boost

1. **Before:** search `cuir` - 100 products, one LuxeLine item in the first eight.
2. **Back office:** **Merchandize > Boosts**. Open **"LuxeLine en tête"**. It is shipped disabled.
3. Turn on **Enable**. Save.
4. **After:** search `cuir` - the first seven are all LuxeLine: clutches, wallets, a pouch.
5. Search `portefeuille` - the five LuxeLine wallets move from 4th-8th to 1st-5th.

**Point out:** a rule can wait, disabled or with dates, and go live at the right time.

**Careful:** use `cuir` or `portefeuille`. On `robe`, `jupe` or `lunettes` nothing changes - no
LuxeLine product there.

### 2.5 Create a boost

1. **Before:** search `jean`. Jean bio regular Natural, with the "Nouveau" badge, is 4th. Jean slim
   brut selvedge Premium, also new, is 16th.
2. **Back office:** go to **Merchandize > Boosts**, click **Create boost**.
3. Fill in:
   - Name: "Demo nouveautés", Enable: on
   - Localized catalog(s): Fiora Français
   - Request type: **Search result**, All search terms
   - Virtual rule: **Add condition > Attribute condition**, **Nouveauté** is equal **true**
   - Model: **Constant score**, Boost value (%): 100
4. Click **Create**.
5. **After:** search `jean` - the two new jeans are 1st and 2nd.
6. Search `veste` - Veste Shacket goes from 13th to 1st.

**Point out:**

- The shop already has a promotions rule ("Promotions en tête") on dresses. This one lifts new
  arrivals - one more rule, on another attribute.
- The form has a **Preview** block: choose the localized catalog and a search term, then click
  **Preview** to check the rule before saving.
- Boosts add up. The LuxeLine boost of step 2.4 is still on: a new LuxeLine product gets both.
  Search `cuir` again - Ceinture boucle dorée and Montre Rose, new and LuxeLine, are now 1st and
  2nd, then three new Fiora shoes, then the other LuxeLine items.

### 2.6 Pin a product on the homepage

1. **Before:** the homepage row "Notre sélection" shows Robe longue drapée en jersey Muse, Robe
   cocktail en dentelle Guipure Sublime, Robe de soirée bustier en taffetas Opéra.
2. **Back office:** go to **Merchandize > Categories**.
3. Choose the catalog Fiora Fashion and the French locale.
4. Select the **top category** of the tree, **Fiora Mode**.
5. Check that **Default sorting** is **Position**. Pinning is refused otherwise.
   The pin applies to every language of the shop.
6. In the product list, find **Basket minimaliste en cuir blanc Essential** (`FIO-CHA-BA-001`).
7. Click **Pin** and move it to the first place. Click **Save**.
8. **After:** reload the homepage. The sneaker opens the "Notre sélection" row, with its "Nouveau"
   badge.

**Point out:** the homepage row is the whole catalogue in its merchandised order. The merchant
decides what greets the shopper.

### 2.7 Change a category's default sort

1. **Before:** open [Accessoires & Bijoux > Bijoux](https://demo.gally.dev/example/fashion_fr/category/cat_fio_58) (16 products). Collier rivière Éternité
   (89.90 €) is first.
2. **Back office:** **Merchandize > Categories**, select **Fiora Mode > Accessoires & Bijoux > Bijoux**.
3. Set **Default sorting** to **Price**. Save.
4. **After:** reload the shop with **F5**. Bijoux opens cheapest first: Chaîne de cheville Summer
   at 15.90 €, and the diamond stud earrings at 199.90 € last.

### 2.8 Force a facet and move it first

1. **Before:** open [Accessoires & Bijoux](https://demo.gally.dev/example/fashion_fr/category/cat_fio_54). No "Couleur" filter: only 28 of the 52 products have
   one (54 %) - belts, sunglasses and hats - under the 90 % rule of step 1.1.
2. **Back office:** go to **Search > Facets**. In the **Categories** panel on the left, under **By
   category**, select **Fiora Mode > Accessoires & Bijoux**.
3. On the **Couleur** row:
   - Display: **Displayed**
   - Position: **1**

   There is no Save button: each change is saved at once.
4. **After:** reload. "Couleur" is the first filter: Beige 15, Bordeaux 13, Camel 12, Gris chiné
   11, and the others.

**Point out:** Gally hid it by default. The merchant decided colour matters here, and put it first.
The setting applies to this category only.

### 2.9 Add an attribute to the search box

1. **Before:** type `robe`. No length section.
2. **Back office:** go to **Settings**, tab **Attributes**.
3. On **Longueur robe**, tick **Displayed in autocomplete**. The box is saved at once, with no
   Save button.
4. **After:** type `robe` - a new section Longueur robe: Maxi 16, Midi 9, Au-dessus du genou 8.
5. Type `soirée` - the same section with Maxi 9 first. Type `jean` - no section: no jean has a
   dress length. The values follow the query.

### 2.10 Make a category virtual

1. **Before:** open [Sport & Performance > Shorts & Joggings](https://demo.gally.dev/example/fashion_fr/category/cat_fio_63). 8 products.
2. **Back office:** **Merchandize > Categories**, select **Fiora Mode > Sport & Performance > Shorts & Joggings**.
3. Turn on **Virtual category**.
4. Rule: **Marque** is equal **ActivePulse**. Save - twice if the first save shows an error.
5. **After:** reload. **39 products**: every ActivePulse item, from leggings to sports bras.

**Point out:**

- A virtual category keeps itself up to date: a new ActivePulse product appears here on its own.
- Choose the rule with care: most categories of this shop mix brands, so a brand rule would drop
  some of their products. Shorts & Joggings holds only ActivePulse products, which is why it is used here.

### 2.11 Create related products for a whole category

1. **Before:** open [Collant opaque 80 deniers Everyday](https://demo.gally.dev/example/fashion_fr/product/FIO-LIN-CC-001) (`FIO-LIN-CC-001`). No recommendation
   strip: tights and socks have no rule.
2. **Back office:** go to **Merchandize > Recommenders > Auto recommenders**, click **Create
   auto recommender**.
3. Fill in:
   - Enable: on, Name: "Demo related"
   - Localized catalog(s): Fiora Français
   - Applied to: **Related product**
4. Source rule engine - which products get the recommendation:
   1. Click **Add condition**, then **Attribute condition**.
   2. Attribute: **Catégorie**. Operator: **is equal**.
   3. In the category tree, pick **Fiora Mode > Femme > Lingerie & Homewear > Collants &
      Chaussettes**.
5. Target rule engine - what is recommended: the same condition, the same category.
6. Click **Create**.
7. **After:** reload the tights. A strip shows six other tights and socks.
8. Open another product of the same category - it gets six too.
9. Open [a legging](https://demo.gally.dev/example/fashion_fr/product/FIO-FBA-LE-001) (`FIO-FBA-LE-001`) - nothing changed.

**Point out:**

- One rule, no product list: it covers the whole category, and a new pair of tights joins it on
  its own.
- These are rules, not learned from shoppers. The list comes in a fixed order, minus the product
  being viewed - "the same shelf", not a personal recommendation.

### 2.12 Create a cross-sell for the cart

1. **Before:** add [Cape Élégance](https://demo.gally.dev/example/fashion_fr/product/FIO-MAN-CP-001) (`FIO-MAN-CP-001`) to the cart and open the cart. No
   suggestion strip.
2. **Back office:** **Merchandize > Recommenders > Auto recommenders**, click **Create auto
   recommender**.
3. Fill in:
   - Enable: on, Name: "Demo cross-sell"
   - Localized catalog(s): Fiora Français
   - Applied to: **Cross-sell**
4. Source rule engine: **Catégorie** is equal **Fiora Mode > Femme > Manteaux & Vestes > Capes &
   Ponchos**. Take the one under Femme: Homme has a "Manteaux & Vestes" too.
5. Target rule engine: **Catégorie** is equal **Fiora Mode > Accessoires & Bijoux > Chapeaux &
   Bonnets**.
6. Click **Create**.
7. **After:** reload the cart. A suggestion strip shows the seven hats: a fedora, a merino beanie,
   a cap, a bucket hat, a beret, a Panama, a cashmere beanie.
8. Replace the cape with [a poncho](https://demo.gally.dev/example/fashion_fr/product/FIO-MAN-CP-004) (`FIO-MAN-CP-004`) - the same seven. Any cape or poncho gets
   them.

---

## Part 3 - The other direction

Every search, product view and add-to-cart in the shop is sent to Gally.

1. In the shop, click the **Gally Insights** button, bottom left. The panel "Ce que Gally sait"
   lists the events the shop sent.
2. In the back office, open **Analyze > Search usage**: searches, products viewed, add-to-carts,
   sessions, and the popular searches table with its conversion rate column.
3. Open **Analyze > Results**. Choose the catalog, the **Request type** (Search result or Category
   listing), then a search term or a category. It shows the ranking; click a row for that
   product's details. Try `cuir`, with the boost of step 2.4 on.

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
- **The cart strip does not appear** - check that a cape or poncho, not another product, is in the
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

The results below are those of the starting state. After step 2.3, a search that found nothing
returns the vector search list instead.

- **Searches of several words** - every word must match: `tenue de soirée` returns 0, while
  `soirée` returns 27.
- **`lin`** - 86 results: the 12 linen products, then 74 lingerie items.
- **Typos while showing "Promotions en tête"** - that shipped boost fires when the search contains
  "robe", so `rboe` finds the dresses but in another order.
- **A synonym with a hyphen** - `nu-pieds` typed with its hyphen did not match in a test; prefer
  single words, as in step 2.1.
- **Switching the shop to English** - some products have a different name there (for example
  `FIO-FTP-BL-002`, `FIO-FTP-BL-003`).

## Reset

Run through this list after the demo, or before it if the starting state check failed.

1. Search > Thesaurus - delete "Demo futal" and "Demo réveillon".
2. Settings > Configurations, tab Vector search, Fiora Français - Use on no result
   **off**.
3. Merchandize > Boosts - delete "Demo nouveautés"; "LuxeLine en tête" **disabled**.
4. Merchandize > Categories, top category (**Fiora Mode**) - Basket minimaliste en cuir blanc Essential
   **unpinned**.
5. Merchandize > Categories, **Fiora Mode > Accessoires & Bijoux > Bijoux** - Default sorting **Position**.
6. Merchandize > Categories, **Fiora Mode > Sport & Performance > Shorts & Joggings** - Virtual category **off**, rule cleared.
7. Search > Facets, Categories panel, **Fiora Mode > Accessoires & Bijoux**, Couleur - Display **Auto**, no position.
8. Settings, tab Attributes - Longueur robe, Displayed in autocomplete
   **unticked**.
9. Merchandize > Recommenders > Auto recommenders - delete "Demo related" and "Demo cross-sell".
10. In the shop, empty the cart.
11. Check the starting state again (Before you start, step 4). Also check that the top
    category still shows the Catégorie, Prix and Disponibilité filters - see [If something looks wrong](#if-something-looks-wrong).

Setting a facet or a configuration back stores the default value instead of removing it. The shop
behaves exactly as before.

---

Every step, count and product name was checked on a live instance on 2026-11-02, through the back
office API: the steps in this order, each change kept, then the reset. On 2026-11-09, a Playwright script went through the papershop guide on the back office and
shop screens, and the screen labels in this guide were corrected from that run. The French screens
were checked; the English labels are translations. This guide's counts and product names were not
re-checked on screen: they come from the API check above. The other sample shops are described in their data sheets - see [`README.md`](README.md).
