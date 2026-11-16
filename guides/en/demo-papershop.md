[Français](../fr/demo-papershop.md)

# Gally demo guide - back office and storefront

> Demo script. For this shop's facts and numbers, see [`catalog-papershop.md`](catalog-papershop.md).

This guide runs a Gally demo in two windows: the back office and the example storefront. You do
something in the back office, reload the shop, and show what appeared.

- **Audience:** a merchant or a product owner - someone who will use the back office.
- **The question it answers:** "what do I control, and what do I get without doing anything?"
- **You need:** basic Gally knowledge (what a catalog, a facet and a boost are) and a local stack
  with the sample data loaded.
- **Shop used:** Le livre & le lièvre (`papershop_fr`): stationery, books and furniture, in French.
  Its facts and references are in [`catalog-papershop.md`](catalog-papershop.md).
- **Length:** about 30 minutes, or 20 without part 1.

The guide has three parts:

1. **What Gally does on its own** - nothing configured, shop only.
2. **Action and reaction** - 12 back office actions. Each one adds to the previous ones. Nothing
   is undone until the end of the demo.
3. **The other direction** - what the shop sends back to the back office.

---

## Before you start

1. Open the shop: `https://demo.gally.dev/example/papershop_fr`. The homepage must load.
2. Open the back office: `https://demo.gally.dev/`. Log in with `admin@example.com` /
   `apassword`.
3. Put the two windows side by side. Keep the shop window **wider than 768 pixels**: narrower,
   the search popup switches to tabs (Products, Blog, Suggestions) and shows only the Products tab
   until you click another one.
4. Check the starting state in the shop:
   - search `rame` - **0 results**
   - search `rentrée` - **0 results**
   - search `siège de bureau` - **0 results**
   - the homepage row "Notre sélection" starts with Crayon graphite Tourbière

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
| 1.4 | shop | search `voyage` | titles ranked above descriptions |
| 1.5 | shop | type in the search box | suggestions that follow the query |
| 1.6 | shop | type, then search `papier` | products and articles from one search box |
| 2.1 | back office | create a synonym | 0 results become 7 |
| 2.2 | back office | create an expansion | 0 results become 46 |
| 2.3 | back office | turn on vector search on no result | a phrase finds office chairs |
| 2.4 | back office | enable a prepared boost | one brand takes the top |
| 2.5 | back office | create a boost | books on promotion take the top |
| 2.6 | back office | pin a product | the homepage changes |
| 2.7 | back office | change a category's default sort | the category opens by price |
| 2.8 | back office | force a facet and move it | a hidden filter appears first |
| 2.9 | back office | add an attribute to autocomplete | a new section in the search box |
| 2.10 | back office | make a category virtual | 5 products become 25 |
| 2.11 | back office | create related products for a category | every classic shows other classics |
| 2.12 | back office | create a cross-sell between categories | any fountain pen suggests inks |
| 3 | both | open Analyze | the shop's activity in the back office |

---

## Part 1 - What Gally does on its own

No facet in this shop has been configured. Say so first: everything in this part is Gally's
default behaviour.

### 1.1 Filters that follow the category

1. Open the top category, [Le livre & le lièvre](https://demo.gally.dev/example/papershop_fr/category/cat_llv_1), and look at the filters of the whole catalogue: Catégorie, Prix,
   Disponibilité, Nouveauté, En promotion, Marque, Pays de fabrication.
2. Open [Livres](https://demo.gally.dev/example/papershop_fr/category/cat_llv_20). Five filters are added: Format, Reliure, Auteur, Nombre de pages, Année de
   parution.
3. Open [Mobilier](https://demo.gally.dev/example/papershop_fr/category/cat_llv_38). The book filters are gone. New ones: Matière, Couleur, Matières durables,
   Largeur, Hauteur, Profondeur, Montage nécessaire.
4. Open [Papeterie > Cahiers & carnets > Cahiers scolaires](https://demo.gally.dev/example/papershop_fr/category/cat_llv_4) (8 products). Grammage and Réglure appear.

**Point out:** Gally shows a filter only when at least 90 % of the products on the page have that
attribute. It recomputes this for every page, search and filter.

### 1.2 Counts that stay complete

1. Open [Mobilier](https://demo.gally.dev/example/papershop_fr/category/cat_llv_38) (70 products).
2. In **Marque**, tick **Boisclair**.

**You should see:**

- 17 products.
- The Marque filter still lists every brand with its full count: Verso 16, Chêne & Fer 15, and so
  on. The shopper can add a second brand.
- Couleur and the other filters now count only the Boisclair products.

### 1.3 Typos and sound-alikes

1. Search `cahir` - the notebooks come back.
2. Search `stilo` - the same 15 results as `stylo`.
3. Search `krayon` - 15 results, among them the 7 graphite pencils.
4. Search `chèze` - office chairs first.

**Point out:**

- Steps 1-2 are typo tolerance.
- Steps 3-4 change the first letter, which typo tolerance never does. They work because the words
  sound alike (phonetic matching).
- There is no "did you mean" message. The shopper just gets results.

### 1.4 The name counts more than the description

1. Search `voyage` - 8 books.

**You should see:**

- First, the four titles containing "Voyage": Voyage en Italie, Le Voyage du Beagle, Voyage au
  centre de la Terre, Voyage avec un âne.
- Last, the books that mention travel only in their description.

**Point out:** by default the product name weighs ten times more than other fields.

### 1.5 Suggestions that follow the query

1. Type `cahier` and wait - do not press Enter. The attribute sections are Marque, Matière, Couleur, Réglure, Reliure.
2. Type `bureau` and wait - do not press Enter. Only Marque, Matière, Couleur.
3. Type `rom` and wait - do not press Enter. Section **Recherches populaires** (popular searches): "roman policier", "romans ados".

In a narrow window, the suggested searches are under the **Suggestions** tab.

**Point out:**

- The merchant chooses which attributes may appear. Gally picks the ones that fit the query, and
  their values.
- The suggested searches come from what shoppers really searched in this shop.

### 1.6 One search box, several kinds of content

1. Type `papier` and wait - do not press Enter. Under the categories, the popup has a **Blog**
   section: the articles that match the word, the same ones as in step 3. If the popup shows tabs,
   the window is too narrow: click **Blog**.
2. Press Enter. The results page shows 49 products.
3. Switch from **Products** to **Articles**. 5 articles, led by "Le papier recyclé passe-t-il vraiment en imprimante" and "Le grammage, et pourquoi 80 g ne suffit pas toujours".

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

1. **Before:** search `rame` - **0 results**. Shoppers say rame, the catalogue says ramette. Both
   words name the same pack of paper.
2. **Back office:** go to **Search > Thesaurus**, click **Create thesaurus**.
3. Fill in:
   - Name: anything, for example "Demo rame"
   - Enable: on
   - Context type: **Localized catalog**, then Localized catalog(s): Le livre & le lièvre France
   - Thesaurus type: **Synonym**
   - Synonyms: `rame`, `ramette`
4. Click **Create**.
5. **After:** search `rame` - **7 results**, the seven paper reams. Search `ramette` - the same 7,
   in the same order.

**Point out:**

- No developer and no reindex. It applies on save.
- A synonym joins words that mean exactly the same thing, in the shop's language: a familiar
  word, a regional word, an abbreviation. It works in every direction.
- A broad word that should bring narrower ones (`siège` for chairs and armchairs) is not a
  synonym. As a synonym, `chaise` would also bring armchairs. That is an expansion - next step.
- Do not use a thesaurus to translate (`pen` = `stylo`). Each language has its own catalog and
  its own thesaurus.
- The thesaurus matches the exact word: `rames`, in the plural, still finds nothing.

### 2.2 Create an expansion

1. **Before:** search `rentrée` - **0 results**.
2. **Back office:** **Search > Thesaurus**, click **Create thesaurus**.
3. Fill in:
   - Name: "Demo rentrée", Enable: on
   - Context type: **Localized catalog**, then Localized catalog(s): Le livre & le lièvre France
   - Thesaurus type: **Expansion**
   - Reference term: `rentrée`
   - Expansion terms: `cahier`, `crayon`, `stylo`, `agenda`
4. Click **Create**.
5. **After:** search `rentrée` - **46 results**, all stationery: pencils first, then diaries,
   notebooks, sketchbooks, inks, pens. `rentree` without the accent works too.

**Point out:** an expansion goes one way. `rentrée` brings notebooks; `cahier` does not bring
anything else. This is how a merchant prepares a season, or makes a broad word bring the
narrower ones.

### 2.3 Answer searches nobody planned for

1. **Before:** search `siège de bureau` - **0 results**. Same for `meubler un bureau` and
   `histoire de détective`.
2. **Back office:** go to **Settings > Configurations**, tab **Vector search**.
3. Set **Configuration applies to:** Le livre & le lièvre France.
4. Turn on **Use on no result**. Click **Save**.
5. **After:**
   - `siège de bureau` - office chairs first
   - `meubler un bureau` - standing desks first
   - `histoire de détective` - Histoires extraordinaires, Nouvelles histoires extraordinaires, then
     a Sherlock Holmes

**Point out:** when keyword search finds nothing, Gally searches by meaning. The thesaurus covers
the words you expect; this covers the ones you did not.

**Careful:**

- Use only these three phrases. Some others give odd first results.
- The count shows about 100 products, ranked by closeness: it is the **K value** of the same form, not a
  number of relevant products. Talk about the first row, not the number.
- From now on, no search shows "0 results". Every step that starts from 0 comes before this one.

### 2.4 Enable a prepared boost

1. **Before:** search `cahier`. Cahier piqué Bastide is 4th, Cahier piqué Colombage 6th.
2. **Back office:** **Merchandize > Boosts**. Open **"Reliure du Nord en tête"**. It is shipped
   disabled.
3. Turn on **Enable**. Save.
4. **After:** search `cahier` - the two Reliure du Nord notebooks are 1st and 2nd.
5. Search `carnet` - Carnet de croquis Pigeonnier goes from 4th to 1st.

**Point out:** a rule can wait, disabled or with dates, and go live at the right time.

**Careful:** use `cahier`, not `papier` - on `papier` the first eight do not change.

### 2.5 Create a boost

1. **Before:** search `édition` - 69 books. Three of the first eight have the promotion badge.
2. **Back office:** go to **Merchandize > Boosts**, click **Create boost**.
3. Fill in:
   - Name: "Demo promotions", Enable: on
   - Localized catalog(s): Le livre & le lièvre France
   - Request type: **Search result**, All search terms
   - Virtual rule: **Add condition > Attribute condition**, **En promotion** is equal **true**
   - Model: **Constant score**, Boost value (%): 100
4. Click **Create**.
5. **After:** search `édition` - **all eight** first books are on promotion: Les Confessions,
   Les Misérables, Voyage en Italie, Le Voyage du Beagle, and others.
6. Search `bureau` - the desks on promotion come first too.

**Point out:**

- The form has a **Preview** block: choose the localized catalog and a search term, then click
  **Preview** to check the rule before saving.
- Boosts add up. The Reliure du Nord boost of step 2.4 is still on: a Reliure du Nord notebook on
  promotion gets both.
- The search box popup is not affected. It is a separate request type, **Autocomplete**.

### 2.6 Pin a product on the homepage

1. **Before:** the homepage row "Notre sélection" shows Crayon graphite Tourbière, Roller Lucarne,
   Roller Colline.
2. **Back office:** go to **Merchandize > Categories**.
3. Choose the catalog Le livre & le lièvre and the French locale.
4. Select the **top category** (**Le livre & le lièvre**) of the tree.
5. Check that **Default sorting** is **Position**. Pinning is refused otherwise.
   The pin applies to every language of the shop.
6. In the product list, find **Fauteuil de lecture Pigeonnier** (`LLV-MOB-FAU-004`).
7. Click **Pin** and move it to the first place. Click **Save**.
8. **After:** reload the homepage. The armchair opens the "Notre sélection" row.

**Point out:** the homepage row is the whole catalogue in its merchandised order. The merchant
decides what greets the shopper.

### 2.7 Change a category's default sort

1. **Before:** open [Mobilier > Bureaux & tables > Bureaux](https://demo.gally.dev/example/papershop_fr/category/cat_llv_40). Pigeonnier (829 €) is first.
2. **Back office:** **Merchandize > Categories**, select **Le livre & le lièvre > Mobilier > Bureaux & tables > Bureaux**.
3. Set **Default sorting** to **Price**. Save.
4. **After:** reload the shop with **F5**. Bureaux opens cheapest first: Passerelle 189 €, Guéret
   249 €, Colombage 329 €, and Pigeonnier last.

### 2.8 Force a facet and move it first

1. **Before:** the whole catalogue has no "Matières durables" filter. Only 160 of 250 products
   have this attribute - under the 90 % rule of step 1.1.
2. **Back office:** go to **Search > Facets**. In the **Categories** panel on the left, under **By
   category**, select the top category, **Le livre & le lièvre**.
3. On the **Matières durables** row:
   - Display: **Displayed**
   - Position: **1**

   There is no Save button: each change is saved at once.
4. **After:** reload. "Matières durables" is the first filter, with a single **Oui** box.

**Point out:** Gally hid it by default. The merchant decided sustainability sells, and put it
first. The setting applies to this category only.

### 2.9 Add an attribute to the search box

1. **Before:** type `cahier`. Sections: Marque, Matière, Couleur, Réglure, Reliure.
2. **Back office:** go to **Settings**, tab **Attributes**.
3. On **Pays de fabrication**, tick **Displayed in autocomplete**. The box is saved at once, with no
   Save button.
4. **After:** type `cahier` - a new section Pays de fabrication: France 4, Allemagne 1,
   Espagne 1.
5. Type `bureau` - the same section, with Pologne first. The values follow the query.

### 2.10 Make a category virtual

1. **Before:** open [Mobilier > Accessoires d'atelier](https://demo.gally.dev/example/papershop_fr/category/cat_llv_52). 5 products, all bookends.
2. **Back office:** **Merchandize > Categories**, select **Le livre & le lièvre > Mobilier > Accessoires d'atelier**.
3. Turn on **Virtual category**.
4. Rule: **Marque** is equal **Lumen Atelier**. Save.
5. **After:** reload. **25 products** from the whole shop: lamps, e-readers, calendars, sketchbooks,
   inks, even books - everything the brand makes. The bookends have left the category: in a virtual
   category, the rule replaces the product list. The Mobilier list grows
   from 70 to 87 products.

**Point out:**

- The shop already has one such category: "Sélection éco-responsable".
- A virtual category keeps itself up to date: a new Lumen Atelier product appears here on its
  own.

### 2.11 Create related products for a whole category

1. **Before:** open [Orgueil et Préjugés](https://demo.gally.dev/example/papershop_fr/product/LLV-LIV-CLA-001) (`LLV-LIV-CLA-001`). The "Vous aimerez aussi" strip
   shows cross-sell: a sketchbook, a paper ream, a document sorter, an armchair. This shop has no
   related-product rules.
2. **Back office:** go to **Merchandize > Recommenders > Auto recommenders**, click **Create
   auto recommender**.
3. Fill in:
   - Enable: on, Name: "Demo related"
   - Localized catalog(s): Le livre & le lièvre France
   - Applied to: **Related product**
4. Source rule engine - which products get the recommendation:
   1. Click **Add condition**, then **Attribute condition**.
   2. Attribute: **Catégorie**. Operator: **is equal**.
   3. In the category tree, pick **Le livre & le lièvre > Livres > Romans & littérature > Littérature classique**.
5. Target rule engine - what is recommended: the same condition, the same category.
6. Click **Create**.
7. **After:** reload the book. The strip shows six other classics: Les Misérables, Madame Bovary,
   Les Hauts de Hurlevent, De grandes espérances, Moby Dick, La Métamorphose.
8. Open **Moby Dick** - it gets six classics too, without Moby Dick itself.
9. Open **Le Chien des Baskerville**, a crime novel - nothing changed.

**Point out:**

- One rule, no product list: it covers all 12 classics, and a classic added tomorrow joins it on
  its own.
- The shop asks for related products first, and falls back to cross-sell when there are none.
- These are rules, not learned from shoppers. The list comes in a fixed order, minus the
  product being viewed - "the same shelf", not a personal recommendation.

### 2.12 Create a cross-sell for the cart

1. **Before:** add [Stylo plume Encrier](https://demo.gally.dev/example/papershop_fr/product/LLV-PAP-PLU-001) (`LLV-PAP-PLU-001`) to the cart and open the cart. No
   suggestion strip.
2. **Back office:** **Merchandize > Recommenders > Auto recommenders**, click **Create auto
   recommender**.
3. Fill in:
   - Enable: on, Name: "Demo cross-sell"
   - Localized catalog(s): Le livre & le lièvre France
   - Applied to: **Cross-sell**
4. Source rule engine: **Catégorie** is equal **Le livre & le lièvre > Papeterie > Écriture > Stylos plume**.
5. Target rule engine: **Catégorie** is equal **Le livre & le lièvre > Papeterie > Écriture > Encres & recharges**.
6. Click **Create**.
7. **After:** reload the cart. A "Complète bien votre panier" strip shows the seven inks: Bleu
   Frimaire, Noir Ardoise, Sauge Clairière, and the others.
8. Replace the pen with **Stylo plume Sillage** - the same seven inks. Any fountain pen gets them.

**Point out:** with two products in the cart, the suggestions of both are merged, up to eight.

---

## Part 3 - The other direction

Every search, product view and add-to-cart in the shop is sent to Gally.

1. In the shop, click the **Gally Insights** button, bottom left. The panel "Ce que Gally sait"
   lists the events the shop sent.
2. In the back office, open **Analyze > Search usage**: searches, products viewed, add-to-carts,
   sessions, and the popular searches table with its conversion rate column.
3. Open **Analyze > Results**. Choose the catalog, the **Request type** (Search result or Category
   listing), then a search term or a category. It shows the ranking; click a row for that
   product's details. Try `édition`, with the boost of step 2.5 on.

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
- **After step 2.10, the Mobilier banner still says 70 products** - that is the shop; the list
  below does count 87. Show the list.
- **The popup shows no articles or no suggested searches** - the shop window is 768 pixels wide
  or less, so the popup uses tabs. Widen the window, or click **Blog** or **Suggestions**.
- **A boost changes nothing** - check the search term. Each boost step names the term to use.
- **The cart strip does not appear** - check that the pen, not another product, is in the cart.

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

- **Searching a category name** - `policier` and `classique` return nothing, although these
  categories exist.
- **Dragging the price filter** - its range is wrong. Use the price sort instead.

## Reset

Run through this list after the demo, or before it if the starting state check failed.

1. Search > Thesaurus - delete "Demo rame" and "Demo rentrée".
2. Settings > Configurations, tab Vector search, Le livre & le lièvre France - Use on no result
   **off**.
3. Merchandize > Boosts - delete "Demo promotions"; "Reliure du Nord en tête" **disabled**.
4. Merchandize > Categories, top category (**Le livre & le lièvre**) - Fauteuil de lecture Pigeonnier **unpinned**.
5. Merchandize > Categories, **Le livre & le lièvre > Mobilier > Bureaux & tables > Bureaux** - Default sorting **Position**.
6. Merchandize > Categories, **Le livre & le lièvre > Mobilier > Accessoires d'atelier** - Virtual category **off**, rule cleared.
7. Search > Facets, Categories panel, top category (**Le livre & le lièvre**), Matières durables - Display **Auto**, no
   position.
8. Settings, tab Attributes - Pays de fabrication, Displayed in autocomplete
   **unticked**.
9. Merchandize > Recommenders > Auto recommenders - delete "Demo related" and "Demo cross-sell".
10. In the shop, empty the cart.
11. Check the starting state again (Before you start, step 4). Also check that the top
    category still shows the Catégorie, Prix and Disponibilité filters - see [If something looks wrong](#if-something-looks-wrong).

Setting a facet or a configuration back stores the default value instead of removing it. The shop
behaves exactly as before.

---

Every step, count and product name was checked on a live instance on 2026-11-02, through the back
office API: the steps in this order, each change kept, then the reset. On 2026-11-09, a Playwright
script went through the whole guide on the back office and shop screens, and the labels were
corrected from that run. The French screens were checked; the English labels are translations. The other sample shops are described in their data sheets - see [`README.md`](README.md).
