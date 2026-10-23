[Français](../fr/README.md)

# Demo scripts

One per sample shop. Each is written for whoever is running the demo: what to open, what to type,
what happens and what to say about it. No file paths, no field names - the dataset reference for
the original catalogue is in `../../GUIDE.md`.

| Shop | Script | Use it when the audience cares about |
|---|---|---|
| Toolbox Bricolage | [`toolbox.md`](toolbox.md) | technical catalogues, filtering by specification, a self-filling category |
| Fiora Fashion | [`fashion.md`](fashion.md) | variants, promotions, editorial tied to products |
| Le livre & le lièvre | [`papershop.md`](papershop.md) | mixed assortments, a wide price range, a self-filling category |
| Venia & Luma | [`default.md`](default.md) | search behaviour itself - synonyms, ranking rules, vector search |

## Which shop shows what

Read it the other way round when a customer asks for something specific: find the row, open that
shop.

| What you want to show | Toolbox | Fiora | Le livre | Venia |
|---|:---:|:---:|:---:|:---:|
| A ranking rule the merchant set on a search | yes | yes | yes | yes |
| A second rule, switched off, to turn on live | yes | yes | yes | - |
| The same word working across languages | 3 langs | 3 langs | 2 langs | 2 langs |
| A search deliberately widened to related words | yes | yes | yes | yes |
| Spelling mistakes recovered | **best** | yes | - | - |
| A category that fills itself from a rule | 45 items | - | **104 items** | - |
| One product sold in many colours and sizes | - | **27 on one** | light | 70 of 85 |
| Promotions, old price beside new | 38 | **72** | 51 | 9 |
| Out of stock, and a filter with both sides | 11 | 20 | 11 | 22 of 85 |
| Filtering by technical specification | **47 filters** | yes | yes | yes |
| Sorting by a specification, not just price | 6 ways | - | 6 ways | - |
| Editorial articles tied to real products | 15 | 15 | 18 | 57 |
| A price range wide enough to matter | 4-700 € | 13-350 € | **1-1290 €** | 15-156 |
| Search by meaning rather than by words | yes | yes | yes | yes |
| Recommendations | related + cross-sell | related + cross-sell | cross-sell only | none |

**The Gally example app opens on Venia & Luma.** Pick any other shop in the header selector:
`toolbox_fr`, `fashion_fr`, `papershop_fr`.

Four things are true of every shop and are not worth discovering live:

- **Search by meaning works in every shop, best in English.** The model behind it is
  English-first. French and German get their own suggestions, kept because they return the right
  products there: mostly short phrases and synonyms, not long sentences. In the English shop the
  last suggestion in each list is a control the ordinary search box answers perfectly well - show
  it last and say so, or the demo looks rigged.

- The product page and the cart show real recommendations: rules a merchant set up in Gally, not
  learned from shoppers. The product page shows related products, or cross-sell when a product has
  no related rule; the cart shows cross-sell for what it holds. Upsell rules exist but are not
  shown. Each shop's guide names a product that has them - a product without a rule shows no strip.
- Where a shop has a rule-built category, the product count beside it in the menu reads zero while
  the page itself lists the products. Click through rather than reading the number.
- Each thematic shop is one catalogue in three languages; Venia has two. Switching language switches
  categories, filters and articles - not the products.

## Keeping the two languages in sync

`en/` and `fr/` are one document in two languages, not two documents. Change one and change the
other in the same edit: the same sections in the same order, and the same rows in every table.
Product references, search terms and shop names stay untranslated on both sides, so a demoer
reading either version types exactly the same thing.

From `guides/`, `./check-sync.py` verifies it. It compares the file list, the heading structure and
the table row counts, and resolves every link. It does not check the translation, only that one
side has not grown a section the other lacks.
