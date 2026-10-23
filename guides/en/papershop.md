# Le livre & le lièvre - demo script

A stationery shop, a bookshop and a furniture business under one roof. 250 products, three
languages, one price list in euros.

**Show it to** anyone whose catalogue is not uniform: a marketplace, a department store, a
distributor whose ranges have nothing in common. One search box has to cope with a 1.20 euro
pencil and a 1290 euro armchair, and that is the demo.

**Open** the Gally example app and pick "Le livre & le lièvre" (`papershop_fr`) in the
header selector.

## At a glance

| Item | In this shop |
|---|---|
| Products | 250 - 90 stationery, 90 books, 70 furniture |
| Languages | French, English, German - one catalogue behind all three |
| Categories | 54, four levels, one of them built by a rule |
| Prices | 1.20 € to 1290 €, the widest range of the four shops |
| Out of stock | 11 products |
| On promotion | 51 products |
| Articles | 18, the most per product of any shop |
| Search suggestions | 6 kinds - brands, materials, colours, rulings, bindings, authors |

## Worth knowing by name

Paste a reference straight into the search box to bring up that product on its own.

| Reference | Why this one |
|---|---|
| `LLV-PAP-AGE-008` | **sustainable and on promotion at once** - both marks on one card, opposite corners |
| `LLV-MOB-FAU-004` | 1290 €, top of the range, with real width, height and depth |
| `LLV-PAP-CRA-003` | 1.20 €, bottom of it - show the two together with the price sort |
| `LLV-LIV-CLA-001` | a book: author, page count, year of publication |
| `LLV-PAP-CAH-001` | ten filters (the most, shared by every school notebook) and three colours |
| `LLV-PAP-CRO-002` | out of stock, so "add to cart" is genuinely disabled |

| Search | Why this one |
|---|---|
| `papier` | **fills all five suggestion sections at once**, and the ranking rule fires |
| `atelier` | three unrelated departments on one result page |
| `pen` in the French shop | the same word working across languages |
| `austen` | an author name, straight from the suggestions |

## The run - about ten minutes

| | Type or click | What it shows |
|---|---|---|
| 1 | `atelier` | three unrelated ranges, one result page |
| 2 | "Sélection éco-responsable" | a category that fills itself from a rule, 104 products |
| 3 | `papier` | the same rule deciding what surfaces first |
| 4 | the price sort | 1.20 € to 1290 € in one catalogue |
| 5 | `pen` in the French shop | one vocabulary across languages |
| 6 | a book, then `austen` | each range keeping its own vocabulary |

---

### 1. Search `atelier`

Back come a graphite pencil, an art book, a wall calendar and a reading lamp. The category filter
counts 12 stationery, 5 books and 8 furniture: three departments with nothing in common, one result
page.

Say what this replaces: shops with ranges this different usually end up with three search boxes,
or one that works properly for only one of them.

### 2. Open "Sélection éco-responsable"

A category in the main menu holding **104 of the 250 products**, each one marked with a green
**Éco** label.

Nobody filled this category. It holds whatever matches a rule the merchant wrote, and it maintains
itself: flag a new product as sustainable tomorrow and it appears here on its own. The same green
label turns up on some of the cards in most paper and furniture categories, never on a book, which
shows the rule's reach.

This is normally the moment a merchandiser reacts to, because it is the job they currently do by
hand every season.

### 3. Search `papier`

Sustainable products lead the results. The same rule that fills the category above also decides
what surfaces first on this search, and neither took a developer.

### 4. Sort by price

On the "Le livre & le lièvre" category page, pick **Prix** in the sort list. A 1.20 euro graphite
pencil comes first. Click the arrow next to the list and a 1290 euro reading armchair takes its
place, in the same catalogue.

On a uniform catalogue a price sort changes little. Here it is the fastest way to say "I am
furnishing an office" rather than "I am buying a pencil".

### 5. Search `pen` in the French shop

The fountain pens come back, even though every product is named in French. The same works the
other way: `stylo` in the English shop.

### 6. Show what the filters know about a book

Open a book - "Orgueil et Préjugés - édition intégrale" is the clearest. It carries an **Auteur**, a
**Nombre de pages** and an **Année de parution**. A desk carries width, height and depth instead. A
notebook carries its **Réglure**.

The point: each range keeps its own vocabulary, and the customer still only sees one shop. Typing
an author's name, `austen`, finds them straight from the search suggestions.

---

## If you have more time

- **Six kinds of suggestion in the search box** - the richest of the four shops. Brands, materials,
  colours, rulings, bindings and authors all appear as you type.
- **Eighteen articles** alongside the products, each linking to real items: "Le grammage, et
  pourquoi 80 g ne suffit pas toujours" is a good one after a paper search.
- **Out of stock**: eleven products, so ticking the availability filter really removes some.
- **Three languages** on the same page.
- **Describe something instead of naming it** on the vector search page. In English, *"furnish a
  home office"* brings back a desk, a desk chair and a desk lamp, pulling the furniture range out by
  intent; in French, *"siège de bureau"* brings back office chairs; in German, *"Füllfederhalter"*
  brings back every fountain pen, which this shop calls "Füllhalter". The ordinary search box
  returns zero for all three.
- **Recommendations.** This shop has no related-product rules, so the product page falls back to
  cross-sell. Open *Orgueil et Préjugés* `LLV-LIV-CLA-001`: "You May Also Like" lists a sketchbook,
  a paper ream, a document sorter and a reading chair. Add it to the cart and the cart offers the
  same four. This shop has 42 cross-sell rules.

---

## Don't do this

- **Don't demo spelling correction here.** This shop's search history has no misspellings in it.
  Use Toolbox Bricolage, which has them on purpose.
- **Don't drag the price filter.** Its range is wrong on every page: on the whole catalogue it stops
  at 10 euros. Sort by price instead.
- **Use the suggested queries on the vector search page - they belong to this shop.** Each one was
  measured here: the first ones return nothing at all from the ordinary search box, and the last one
  is a deliberate control that the ordinary box handles perfectly well in French and English. In
  German the control, "Märchen", returns zero from the ordinary box too, so skip it there. Show the
  control last and say what it proves, or an audience will assume the whole page is rigged.
- **Don't lean on variants.** Some notebooks come in three colours, but nothing here compares with
  the 27-variant shoe in Fiora Fashion.
- **Don't show upsell here.** The 24 upsell rules pair a book with other, unrelated books - *Les
  Misérables* with a pocket edition of *La Lettre volée* - and the storefront does not show upsell
  anyway. Cross-sell, above, is the one to demo.
