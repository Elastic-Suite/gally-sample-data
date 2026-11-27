[Français](../fr/demo-default.md)

# Gally demo guide - Venia

> Demo script. For this shop's facts and numbers, see [`catalog-default.md`](catalog-default.md).

This guide runs a Gally demo in two windows: the back office and the example storefront. You do
something in the back office, reload the shop, and show what appeared.

- **Audience:** a merchant or a product owner - someone who will use the back office.
- **The question it answers:** "what do I control, and what do I get without doing anything?"
- **You need:** basic Gally knowledge (what a catalog, a facet and a boost are) and a local stack
  with the sample data loaded.
- **Shop used:** Venia (`com_en`): womenswear and jewellery, 85 products, **in English** - the
  product texts are English in both languages, and the French shop has no search history. Its
  facts and references are in [`catalog-default.md`](catalog-default.md).
- **Length:** about 30 minutes, or 20 without part 1.

The guide has three parts:

1. **What Gally does on its own** - nothing configured, shop only.
2. **Action and reaction** - 12 back office actions. Each one adds to the previous ones. Nothing
   is undone until the end of the demo.
3. **The other direction** - what the shop sends back to the back office.

---

## Before you start

1. Open the shop: `https://demo.gally.dev/example/com_en`. The homepage must load.
2. Open the back office: `https://demo.gally.dev/`. Log in with `admin@example.com` /
   `apassword`.
3. Put the two windows side by side. Keep the shop window **wider than 768 pixels**: narrower,
   the search popup switches to tabs (Products, Blog, Suggestions) and shows only the Products tab
   until you click another one.
4. Check the starting state in the shop:
   - search `jumper` - **0 results**
   - search `office` - **0 results**
   - the homepage row "Our selection" starts with Gold Omni Bangle Set
   - type `dress` and wait: the popup's first product is Candace Dress

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
| 1.2 | shop | tick a material | counts that stay complete |
| 1.3 | shop | search with typos | the right products anyway |
| 1.4 | shop | search `lace` | names ranked above descriptions |
| 1.5 | shop | type in the search box | suggestions that follow the query |
| 1.6 | shop | type, then search `dress` | products and articles from one search box |
| 2.1 | back office | create a synonym | 0 results become 8 |
| 2.2 | back office | create an expansion | 0 results become 19 office pieces |
| 2.3 | back office | turn on vector search on no result | described needs find belts, earrings, trousers |
| 2.4 | back office | create a boost | products on sale take the top |
| 2.5 | back office | extend a boost to the search box | the popup follows the same rule |
| 2.6 | back office | pin a product | the homepage changes |
| 2.7 | back office | change a category's default sort | the category opens by price |
| 2.8 | back office | force a facet and move it | a hidden filter appears first |
| 2.9 | back office | add an attribute to autocomplete | a new section in the search box |
| 2.10 | back office | make a category virtual | 1 product becomes 12 |
| 2.11 | back office | create related products for a category | every dress shows other dresses |
| 2.12 | back office | create a cross-sell between categories | any skirt suggests belts |
| 3 | both | open Analyze | the shop's activity in the back office |

---

## Part 1 - What Gally does on its own

No facet in this shop has been configured. Say so first: everything in this part is Gally's
default behaviour.

### 1.1 Filters that follow the category

1. Open the top category, [Default Category](https://demo.gally.dev/example/com_en/category/cat_2), and look at the filters of the whole catalogue (85
   products): Category, Price, Availability, Color, Material, and two more.
2. Open [Tops](https://demo.gally.dev/example/com_en/category/cat_8) (24 products). Added: Size and Style.
3. Open [Accessories > Jewelry](https://demo.gally.dev/example/com_en/category/cat_5) (14 products). No Size, no Style: jewellery has neither.
4. Open [Accessories > Belts](https://demo.gally.dev/example/com_en/category/cat_4) (4 products). Size is back - every belt has a size - but no Style.

**Point out:** Gally shows a filter only when at least 90 % of the products on the page have that
attribute. It recomputes this for every page, search and filter.

### 1.2 Counts that stay complete

1. Open [Tops](https://demo.gally.dev/example/com_en/category/cat_8) (24 products).
2. In **Material**, tick **Cashmere**.

**You should see:**

- 4 products: Rosalina, Sabina Hooded, Helena Cardigan, Echo Sweater.
- The Material filter still lists every material with its full count: Cotton 15, Rayon 6,
  Acrylic 4, and the others. Tick a second one and the products add up.
- Style now counts only the cashmere tops: Long Sleeve 3, Open Front 3.

### 1.3 Typos and sound-alikes

1. Search `skrit` - 13 results, the same first three as `skirt`: Rowena, Johanna, Pomona Skirt.
2. Search `earings` - 8 results, the same first three as `earrings`.
3. Search `kardigan` - the 7 cardigans: Helena, Carina, Phoebe and the others.

**Point out:**

- Steps 1-2 are typo tolerance.
- Step 3 changes the first letter, which typo tolerance never does. It works because the words
  sound alike (phonetic matching).
- There is no "did you mean" message. The shopper just gets results.

### 1.4 The name counts more than the description

1. Search `lace` - 6 products.

**You should see:**

- First, the three with "Lace" in their name: Liana Lace Shorts, Corina Lace-Back Sweater, Emilia
  Cropped Lace Top.
- Last, the three that mention lace only in their description: Anna Draped Top, Cora Open-Back
  Tank, Jillian Top.

**Point out:** by default the product name weighs ten times more than other fields.

### 1.5 Suggestions that follow the query

1. Type `dress` and wait - do not press Enter. Color shows Gold, Lilac, Peach; Style shows Above Knee, Short Sleeve,
   Sleeveless.
2. Type `skirt` and wait - do not press Enter. Color shows Gold, Rain, Lilac; Style shows Full Length first.
3. Type `dre` and wait - do not press Enter. The popular searches section: "hot weather dress", "summer dress", "cocktail dress"
   and others.

In a narrow window, the suggested searches are under the **Suggestions** tab.

**Point out:**

- The merchant chose the four attributes that may appear. Gally picks their values and counts for
  each query.
- The suggested searches come from what shoppers really searched in this shop.

### 1.6 One search box, several kinds of content

1. Type `dress` and wait - do not press Enter. Under the categories, the popup has a **Blog**
   section: the articles that match the word, the same ones as in step 3. If the popup shows tabs,
   the window is too narrow: click **Blog**.
2. Press Enter. The results page shows 18 products.
3. Switch from **Products** to **Articles**. 27 articles, led by "The Cocktail Dress Code, Decoded" and "Finding Your Dress Size Online".

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

1. **Before:** search `jumper` - **0 results**. A British shopper says jumper, the catalogue uses
   the American word, sweater. Both words name the same garment.
2. **Back office:** go to **Search > Thesaurus**, click **Create thesaurus**.
3. Fill in:
   - Name: "Demo jumper", Enable: on
   - Context type: **Localized catalog**, then Localized catalog(s): COM English Catalog
   - Thesaurus type: **Synonym**
   - Synonyms: `jumper`, `sweater`
4. Click **Create**.
5. **After:** search `jumper` - **8 results**: Juno, Hanna, Echo, Roxana Cropped and Corina
   Lace-Back Sweater, then three cardigans whose description says sweater: Helena, Rosalina and
   Brigid Boucle.
6. Search `sweater` - the same 8, in the same order.

**Point out:**

- No developer and no reindex. It applies on save.
- A synonym joins words that mean exactly the same thing, in the shop's language: here a British
  and an American word for one garment. It works in every direction.
- A cardigan is not a jumper, so `cardigan` stays out of the list. A broad word that should bring
  narrower ones (`knitwear` for sweaters and cardigans) is not a synonym either. That is an
  expansion - next step.
- Do not use a thesaurus to translate (`robe` = `dress`). Each language has its own catalog and
  its own thesaurus.
- The thesaurus matches the exact words, not their variants.

### 2.2 Create an expansion

1. **Before:** search `office` - **0 results**.
2. **Back office:** **Search > Thesaurus**, click **Create thesaurus**.
3. Fill in:
   - Name: "Demo office", Enable: on
   - Context type: **Localized catalog**, then Localized catalog(s): COM English Catalog
   - Thesaurus type: **Expansion**
   - Reference term: `office`
   - Expansion terms: `blouse`, `cardigan`, `pants`
4. Click **Create**.
5. **After:** search `office` - **19 results**: four blouses first (Serena, Penelope Peasant,
   Isabella Sleeveless, Aurora Sleeveless), then cardigans and pants, and Candace Dress
   last.

**Point out:** an expansion goes one way. `office` brings blouses; `blouse` still returns
its own 4. This is how a merchant builds an occasion, or makes a broad word bring the narrower ones.

### 2.3 Answer searches nobody planned for

1. **Before:** search `a belt for my jeans` - **0 results**. Same for `sparkly earrings` and
   `comfortable trousers for summer`.
2. **Back office:** go to **Settings > Configurations**, tab **Vector search**.
3. Set **Configuration applies to:** COM English Catalog.
4. Turn on **Use on no result**. Click **Save**.
5. **After:**
   - `a belt for my jeans` - Stretch Belt With Leather Clasp, then two braided leather belts
   - `sparkly earrings` - Augusta, Gold Sol and Carmina Earrings
   - `comfortable trousers for summer` - Honora Wide Leg, Camilla Palazzo, Calista Linen Pants

**Point out:** when keyword search finds nothing, Gally searches by meaning. The thesaurus covers
the words you expect; this covers the ones you did not.

**Careful:**

- Use these phrases. `something to keep my neck warm` and `gift for my wife` give poor first rows.
- The count shows at most 100 products (the **K value** of the same form), ranked by closeness -
  not a number of relevant products. Talk about the first row, not the number.
- From now on, no search shows "0 results". Every step that starts from 0 comes before this one.

### 2.4 Create a boost

1. **Before:** search `tank`. Valeria Two-Layer Tank, with the "On Sale" badge, is 8th. Search
   `pants`: Honora Wide Leg Pants, also on sale, is 6th.
2. **Back office:** go to **Merchandize > Boosts**, click **Create boost**.
3. Fill in:
   - Name: "Demo sale", Enable: on
   - Localized catalog(s): COM English Catalog
   - Request type: **Search result**, All search terms
   - Virtual rule: **Add condition > Attribute condition**, **Promotion** is equal **true**
   - Model: **Constant score**, Boost value (%): 100
4. Click **Create**.
5. **After:** search `tank` - Valeria Two-Layer Tank is 1st.
6. Search `pants` - Honora Wide Leg Pants is 1st.

**Point out:**

- The form has a **Preview** block: choose the localized catalog and a search term, then click
  **Preview** to check the rule before saving.
- The boost multiplies the score, it does not override it: on `top`, Roxana Cropped Sweater, on sale,
  rises from 11th to 6th only, and a sale dress that matches only in its description does not
  move.
- It applies to every search. `jumper` now opens with Roxana Cropped Sweater, and `office` with
  Honora Wide Leg Pants.
- The search box popup is not affected. It is a separate request type, **Autocomplete** - next
  step.

### 2.5 Extend a boost to the search box

Venia ships one rule, `Boost "Tank dress"`: on searches containing "dress", it lifts the Tank
dresses. It applies to the results page, not to the search box popup.

1. **Before:** type `dress` and stop. The popup products start with Candace Dress, then Angelina
   Tank, Felicia Maxi, Veronica Maxi. Press Enter: the results page shows Angelina, Valentina,
   Alexia Maxi, Karena Halter, Flora, Athena. Alexia and Karena are on sale: the boost of step 2.4
   adds to the Tank dress rule there. The two lists differ.
2. **Back office:** go to **Merchandize > Boosts**, open **`Boost "Tank dress"`**.
3. In **Request type**, add **Autocomplete**, with the same search limitation. Save.
4. **After:** type `dress` again. The popup now starts with Angelina, Valentina, Flora, Athena
   Tank Dress and Paulina Draped Tank Dress: the Tank dresses come first.

**Point out:**

- One rule, three places it can apply - category pages, the results page and the search box. The
  merchant picks which.
- The results page still differs: Alexia Maxi and Karena Halter are 3rd and 4th there. The sale
  boost of step 2.4 covers Search result only, so the popup does not get it.

### 2.6 Pin a product on the homepage

1. **Before:** the homepage row "Our selection" shows Gold Omni Bangle Set, Gold Cirque Earrings,
   Silver Cirque Earrings.
2. **Back office:** go to **Merchandize > Categories**.
3. Choose the catalog COM Catalog and the English locale.
4. Select the **top category** of the tree, **Default Category**.
5. Check that **Default sorting** is **Position**. Pinning is refused otherwise.
   The pin applies to every language of the shop.
6. In the product list, find **Karena Halter Dress** (`VD03`).
7. Click **Pin** and move it to the first place. Click **Save**.
8. **After:** reload the homepage. The dress opens the "Our selection" row, with its "On Sale"
   badge.

**Point out:** the homepage row is the whole catalogue in its merchandised order. The merchant
decides what greets the shopper.

### 2.7 Change a category's default sort

1. **Before:** open [Accessories > Jewelry](https://demo.gally.dev/example/com_en/category/cat_5). Gold Omni Bangle Set (78) is first.
2. **Back office:** **Merchandize > Categories**, select **Default Category > Accessories > Jewelry**.
3. Set **Default sorting** to **Price**. Save.
4. **After:** reload the shop with **F5**. Jewelry opens cheapest first: Gold Sol Earrings and
   Silver Sol Earrings at 48, and Night Out Collection at 156 last.

### 2.8 Force a facet and move it first

1. **Before:** open [Accessories](https://demo.gally.dev/example/com_en/category/cat_3). No Brand filter: only 4 of the 24 products have a brand -
   under the 90 % rule of step 1.1.
2. **Back office:** go to **Search > Facets**. In the **Categories** panel on the left, under **By
   category**, select **Default Category > Accessories**.
3. On the brand attribute row - labelled **Marque** in the back office:
   - Display: **Displayed**
   - Position: **1**

   There is no Save button: each change is saved at once.
4. **After:** reload. "Brand" is the first filter: Luma 3, Venia 2. Open Jewelry - unchanged.

**Point out:** Gally hid it by default. The merchant overruled that, for this category only.

### 2.9 Add an attribute to the search box

1. **Before:** type `necklace`. Sections for Color and Material - no brand.
2. **Back office:** go to **Settings**, tab **Attributes**.
3. On the brand attribute (**Marque**), tick **Displayed in autocomplete**. The box is saved at once, with no
   Save button.
4. **After:** type `necklace` - a new Brand section: Luma 2, Venia 1.
5. Type `dress` - no Brand section: no dress has a brand. The sections follow the query.

**Careful:** the counts are small - only a few accessories have a brand.

### 2.10 Make a category virtual

1. **Before:** open [New Products](https://demo.gally.dev/example/com_en/category/cat_7). 1 product: Venia Stylist Consultation.
2. **Back office:** **Merchandize > Categories**, select **Default Category > New Products**.
3. Turn on **Virtual category**.
4. Rule: **Nouveauté** (the new attribute) is equal **true**. Save - twice if the first save shows an error.
5. **After:** reload. **12 products**, all with the "New" badge: Night Out Collection, Luna Scarf,
   Angelina and Athena Tank Dress, Selena Pants, and others.

**Point out:**

- The category now fills itself from the product data. A product flagged new tomorrow appears
  here on its own, and leaves when the flag goes.
- The consultation is no longer there: it is not flagged new.

**Careful:** the count next to the category in the menu stays at 1. Click through to the page.

### 2.11 Create related products for a whole category

1. **Before:** open [Claudia Crochet Dress](https://demo.gally.dev/example/com_en/product/VD10) (`VD10`). No recommendation strip: this shop has no
   recommendation rules at all.
2. **Back office:** go to **Merchandize > Recommenders > Auto recommenders**, click **Create
   auto recommender**.
3. Fill in:
   - Enable: on, Name: "Demo related"
   - Localized catalog(s): COM English Catalog
   - Applied to: **Related product**
4. Source rule engine - which products get the recommendation:
   1. Click **Add condition**, then **Attribute condition**.
   2. Attribute: **Catégorie** (the category attribute). Operator: **is equal**.
   3. In the category tree, pick **Default Category > Dresses**.
5. Target rule engine - what is recommended: the same condition, the same category.
6. Click **Create**.
7. **After:** reload the dress. A strip shows six other dresses: Petra Sundress, Athena Tank,
   Alexia Maxi, Valentina Tank, Paulina Draped Tank, Flora Tank.
8. Open **Candace Dress** - it gets six dresses too.
9. Open **Rowena Skirt** - nothing changed.

**Point out:**

- One rule, no product list: it covers every dress, and a new dress joins it on its own.
- These are rules, not learned from shoppers. The list comes in a fixed order, minus the product
  being viewed - "the same shelf", not a personal recommendation.

### 2.12 Create a cross-sell for the cart

1. **Before:** add **Johanna Skirt** to the cart and open the cart. No suggestion strip.
2. **Back office:** **Merchandize > Recommenders > Auto recommenders**, click **Create auto
   recommender**.
3. Fill in:
   - Enable: on, Name: "Demo cross-sell"
   - Localized catalog(s): COM English Catalog
   - Applied to: **Cross-sell**
4. Source rule engine: **Catégorie** is equal **Default Category > Bottoms > Skirts**.
5. Target rule engine: **Catégorie** is equal **Default Category > Accessories > Belts**.
6. Click **Create**.
7. **After:** reload the cart. A suggestion strip shows the four belts: Stretch Belt With Leather
   Clasp, Thin and Thick Leather Braided Belt, Laser Cut Stretch Belt.
8. Replace the skirt with **Pomona Skirt** - the same four. Any skirt gets them.

**Point out:** a skirt's product page now shows the belts too. With no related-products rule, the
product page falls back to cross-sell.

---

## Part 3 - The other direction

Every search, product view and add-to-cart in the shop is sent to Gally.

1. In the shop, click the **Gally Insights** button, bottom left. The panel lists the events
   the shop sent.
2. In the back office, open **Analyze > Search usage**: searches, products viewed, add-to-carts,
   sessions, and the popular searches table with its conversion rate column.
3. Open **Analyze > Results**. Choose the catalog, the **Request type** (Search result or Category
   listing), then a search term or a category. It shows the ranking; click a row for that
   product's details. Try `tank`, with the boost of step 2.4 on.

**Careful:** events are processed every minute, but the delay before the dashboard shows them was
not measured. Run a few searches before the demo rather than counting on it live.

**Point out:** the suggested searches of step 1.5 come from the same data. Gally filters them: no
typos, no search that found nothing, nothing older than 180 days.

---

## If something looks wrong

- **A search shows results where the guide says 0** - the previous demo was not reset, or step
  2.3 is already done. Check Search > Thesaurus and Settings > Configurations, tab Vector
  search.
- **Category, Price and Availability vanish from the top category after step 2.9 or the reset** - seen twice
  in eight saves of an autocomplete setting. Untick and tick Displayed in autocomplete again.
- **A category save shows an error** - click Save again.
- **The sort did not change** - reload with F5.
- **The popup shows no articles or no suggested searches** - the shop window is 768 pixels wide
  or less, so the popup uses tabs. Widen the window, or click **Blog** or **Suggestions**.
- **A boost changes nothing** - check the search term. Each boost step names the term to use.
- **The cart strip does not appear** - check that a skirt, not another product, is in the cart.

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
- upsell: Gally supports upsell rules, but the storefront never shows them, and Venia has none

## Things to avoid in this shop

The results below are those of the starting state. After step 2.3, a search that found nothing
returns the vector search list instead.

- **Demoing in French** - the product texts are English there too, and the search box has no
  suggested searches.
- **The two last filters of the top category** - they show raw codes, "Date_of_manufacture" and
  "Manufacture_location".
- **Searching `jewelry`** - it returns 0, although a category has that name.
- **Promising a size order** - no sort mode lists XS, S, M, L, XL in that order.
- **Suggested searches beyond dresses** - the history holds dress searches, "shoes", which this
  shop does not sell, and a few searches about the terms of sale ("terms of sale", "sale
  conditions").

## Reset

Run through this list after the demo, or before it if the starting state check failed.

1. Search > Thesaurus - delete "Demo jumper" and "Demo office".
2. Settings > Configurations, tab Vector search, COM English Catalog - Use on no result
   **off**.
3. Merchandize > Boosts - delete "Demo sale"; `Boost "Tank dress"` request types back to
   **Category listing** and **Search result** only.
4. Merchandize > Categories, top category (**Default Category**) - Karena Halter Dress **unpinned**.
5. Merchandize > Categories, **Default Category > Accessories > Jewelry** - Default sorting **Position**.
6. Merchandize > Categories, **Default Category > New Products** - Virtual category **off**, rule cleared.
7. Search > Facets, Categories panel, **Default Category > Accessories**, Marque - Display **Auto**, no position.
8. Settings, tab Attributes - Marque, Displayed in autocomplete **unticked**.
9. Merchandize > Recommenders > Auto recommenders - delete "Demo related" and "Demo cross-sell".
10. In the shop, empty the cart.
11. Check the starting state again (Before you start, step 4). Also check that the top
    category still shows the Category, Price and Availability filters - see [If something looks wrong](#if-something-looks-wrong).

Setting a facet or a configuration back stores the default value instead of removing it. The shop
behaves exactly as before.

---

Every step, count and product name was checked on a live instance on 2026-11-02, through the back
office API: the steps in this order, each change kept, then the reset. On 2026-11-09, a Playwright script went through the papershop guide on the back office and
shop screens, and the screen labels in this guide were corrected from that run. The French screens
were checked; the English labels are translations. This guide's counts and product names were not
re-checked on screen: they come from the API check above. The other sample shops are described in their data sheets - see [`README.md`](README.md).
