# Fiora Fashion - demo script

An apparel shop. 433 products, almost all of them sold in several colours and sizes, three
languages, one price list in euros.

**Show it to** anyone selling clothing, footwear or anything else where one product means a dozen
variants, and anyone who cares about promotions and editorial content. This is the best-looking
catalogue of the four and the one to use when the audience buys with their eyes.

**Open** the Gally example app and pick "Fiora Fashion" (`fashion_fr`) in the header
selector. The demo lands on another shop by default.

## At a glance

| Item | In this shop |
|---|---|
| Products | 433, of which 409 sold in several colours or sizes |
| Languages | French, English, German - one catalogue behind all three |
| Categories | 63, four levels deep, tied with papershop as the deepest shop |
| Prices | 12.90 € to 349.90 € |
| Out of stock | 20 products, spread across every department |
| On promotion | 72 products, each with its old price struck through |
| Articles | 15, found by the same search box as the products |
| Widest product | 27 colour and size combinations, on each of 50 shoes |

## Worth knowing by name

Paste a reference straight into the search box to jump to the product.

| Reference | Why this one |
|---|---|
| `FIO-CHA-BA-001` | **27 colour and size combinations** on one card, like 49 other shoes |
| `FIO-FRO-RC-001` | eight filters on one dress, the most of any product - 40 dresses tie |
| `FIO-MAN-BC-001` | 349.90 €, top of the range |
| `FIO-LIN-CS-002` | 12.90 €, bottom of it |
| `FIO-FTP-BL-002` | on promotion, 39.90 € with 49.90 € struck through |
| `FIO-FTP-BL-003` | out of stock, so "add to cart" is genuinely disabled |

| Search | Why this one |
|---|---|
| `lin` | **fills six of the seven suggestion sections at once**, all but popular searches - the one to pause on |
| `robe` | the ranking rule fires, promotions lead |
| `jupe` | the same shop with no rule - run it straight after |
| `robe` in the English shop | the same word working across languages |
| `bracellet` | a misspelling, recovered |

## The run - about ten minutes

| | Type or click | What it shows |
|---|---|---|
| 1 | `robe`, then `jupe` | a ranking rule the merchant set, and its limits |
| 2 | `robe` in the English shop | one vocabulary across three languages |
| 3 | the white leather trainer | 27 variants behind a single card |
| 4 | a category's filters | filters that change with what you are looking at |
| 5 | any listing | 72 promotions, old price beside new |
| 6 | `robe de soirée` | editorial and products in one search |

---

### 1. Search `robe`, then `jupe`

The dresses come back with the discounted ones first. The skirts come back in ordinary relevance
order.

Same catalogue, same search box. Someone decided that on a dress search, what is on promotion
leads - and changed it without a developer. A second rule is prepared and switched off; if you
have admin access, turn it on live and search again.

### 2. Type `robe` in the English shop

Switch to English and search the French word: the dresses are still there. The same holds in
German with `Kleid`.

One product catalogue, three shopfronts, and the merchant maintaining the words customers actually
type in each language.

### 3. Open a trainer and change colour and size

"Basket minimaliste en cuir blanc Essential" is the strongest one to open: it is a single product
sold in **27 combinations** of colour and size. "Robe courte en lin lavé Riviera" is a good second.

The listing shows one card, not 27. That is the whole point - the customer sees a product, the
merchant manages the variants.

### 4. Filter a category

**Couleur**, **Matière haut**, **Taille vêtement**, **Pointure**, **Marque**. The filters change
depending on what you are looking at: shoes offer a shoe size, tops offer a neckline and a sleeve
length. They are not one generic list bolted onto every product.

### 5. Show the promotions

Seventy-two products are discounted, each with its old price struck through beside the new one.
Combined with the rule from step 1, this is a complete promotion story: the merchant flags the
products, then decides where they surface.

### 6. Search `robe de soirée`, then open an article

Fifteen editorial articles sit alongside the catalogue. Search `robe de soirée`: the results page
counts 10 products and 2 articles, "Choisir sa robe de soirée" among them. Open it. The article page
itself does not link to products.

This is worth pointing out: the same engine searches the articles and the products, so editorial
content is not a separate silo that nobody can find.

---

## If you have more time

- **Make a spelling mistake**: `bracellet` in French, `dres` or `neckless` in English, `Ohringe` in
  German. All of them find the right things.
- **Prices** run from about 13 to 350 euros.
- **Out of stock**: twenty products across every department, so the availability filter works and
  some "add to cart" buttons are genuinely disabled.
- **Describe a garment instead of naming it** on the vector search page. In English, *"something to
  wear to the beach"* brings back a beach poncho and swim shorts; in French, *"tenue de soirée"*
  puts two evening dresses in the top four. The ordinary search box returns zero for both. The model
  is English-first, so keep French and German to short phrases. Run both.
- **Recommendations.** Open the silk blouse `FIO-FTP-BL-001`: "You May Also Like" lists three other
  tops, its related products. Add it to the cart: the cart offers the cigarette trousers, the pencil
  skirt, the Diva 85 pumps and the quilted bag, its cross-sell. The T-shirt `FIO-FTP-TS-001` works
  the same way. This shop has 52 related and 49 cross-sell rules, one per product.
- **Three languages** on the same page, categories and articles following along.

---

## Don't do this

- **Don't promise sorting by a product specification.** The dropdown offers relevance, name, price,
  availability and creation date. It also lists Accessory_brand and Date_of_manufacture, raw labels
  from another shop: skip them. This shop has no sortable specification the way the DIY one does.
- **Don't present recommendations as learned from shoppers.** They are rules a merchant set up in
  Gally; nothing reads tracking data. Pick a product that has one (the blouse or the T-shirt above):
  a product without a rule shows no strip at all. The 61 upsell rules are not shown anywhere.
- **Use the suggested queries on the vector search page - they belong to this shop.** Each one was
  measured here: the first ones return nothing at all from the ordinary search box (in German only
  the first two: `Abendkleid` finds four), and the last one is a deliberate control that the
  ordinary box handles perfectly well. Show the control last and say what it proves, or an audience
  will assume the whole page is rigged.
- **Don't go looking for a rule-built category.** This shop has none. Use Toolbox Bricolage or
  Le livre & le lièvre for that.
