# Venia & Luma - demo script

The original sample shop, and still the one the storefront opens on. Three shopfronts: **Venia**,
womenswear and jewellery, the only one worth demoing; **Luma**, sportswear, half furnished; and a
third that is empty.

**Show it to** anyone who wants to see the search behaviour itself - synonyms, ranking rules,
vector search. This shop has the merchandising features the other three did not have until
recently, and the deepest editorial section.

**Open** the Gally example app on the `com_en` shopfront - **in English**, not French. Two reasons,
and both will bite you if you ignore them: the search history behind the French shopfront has aged
out, so the popular-searches list is empty, and the products are written in English, so vector
search only works properly there.

## At a glance

| Item | In this shop |
|---|---|
| Products | 85 in Venia. Luma has 183 but nothing configured around them |
| Languages | English and French - demo in **English** |
| Categories | 19 |
| Prices | 15 to 156 |
| Out of stock | 22 of the 85, the highest proportion of the four shops |
| On promotion | 9 products |
| Articles | 57, by far the largest editorial section |
| Product types | all of them - 70 with variants, plus a bundle, a grouped set and a virtual |

## Worth knowing by name

Paste a reference into the search box to find the product. For `VA13-GO-NA` and `VA17-SI-NA`,
the bundle `VA24` that contains them comes first, so open the second result.

| Reference | Why this one |
|---|---|
| `VSK12` | 20 colour and size combinations behind one card |
| `VA24` | a bundle, and the priciest item at 156 |
| `VA23` | a grouped set - three products sold together |
| `VVP01` | a service rather than an object, and the cheapest thing in the shop |
| `VA13-GO-NA` | on promotion, 78 with 98 struck through, and two badges at once |
| `VA17-SI-NA` | out of stock, one of 22 |
| `VA11-GO-NA` | a single material, so it shows the "100 %" badge |

| Search | Why this one |
|---|---|
| `dress` | fills all five suggestion sections - pause before pressing enter |
| `robe` | the same dresses through a synonym, without the ranking rule |
| `trousers` | a search deliberately widened to pants and shorts |

## The run - about ten minutes

| | Type or click | What it shows |
|---|---|---|
| 1 | `dress`, and pause | five kinds of suggestion at once |
| 2 | `dress`, then `robe` | one vocabulary, and a ranking rule on top of it |
| 3 | `trousers` | a search deliberately widened by the merchant |
| 4 | a phrase in no product's words | search by meaning, not by words |
| 5 | a bundle, a grouped set | every product type in one shop |
| 6 | the blog | 57 articles searched through the same box |

---

### 1. Type `dress` and stop before pressing enter

The suggestion panel fills with all five kinds of result at once: popular searches, matching
colours, materials, sizes and styles, products, a category and articles from the blog.

Let it sit on screen for a moment. Most search boxes offer one of those five.

### 2. Search `dress`, then `robe`

Both find the dresses - the merchant has told the engine the two words mean the same thing.

But the ranking differs, because a rule lifts every dress with "Tank" in its name on one of those
searches and not the other. Two things are happening at once here: a vocabulary the merchant
maintains, and a ranking decision the merchant makes. Worth separating them out loud.

### 3. Search `trousers`

The results are wider than the word: 29 pants and shorts come back, because the merchant widened
that search deliberately.

Nothing announces this in the interface. Say it, or it goes unnoticed.

### 4. Describe something instead of naming it

The vector search page offers five suggestions, and they were written for this shop - use them
here, they work. Four return **zero** from the ordinary search box: `jewellery`, because the
catalogue spells it "Jewelry" and names the pieces "Necklace" and "Earrings";
`wedding guest outfit` and *"something to wear to the beach"*, because the shopper describes the
occasion and the catalogue describes the garment; `gift for my wife`, which has no product noun in
it at all.

The fifth, `cardigan`, is there on purpose as a control: keyword search handles it perfectly well.
Show it last. The honest claim is not that vector search wins everywhere, it is that it answers
the questions keyword search cannot answer at all - and an audience that spots the four rigged
examples on its own will stop believing the rest.

### 5. Open a few products

This shop has every product type: a simple one, one sold in several colours and sizes, a bundle
and a grouped set. None of the three newer shops has a bundle or a grouped set.

Twenty-two of the eighty-five products are out of stock, so the availability filter has both sides
and some "add to cart" buttons are genuinely disabled.

### 6. Show the blog

Fifty-seven articles, by far the largest editorial section of the four shops, searchable through
the same box as the products and with their own suggestions by topic, tag and author.

---

## Don't do this

- **Don't demo in French.** The popular-searches list is empty there, and the product descriptions
  are still in English, which looks like a translation bug in front of a customer.
- **Don't switch to the third shopfront.** Nothing is indexed in it; you get an empty shop.
- **Don't lean on Luma**, the sportswear one. It has products and shares a few synonyms with Venia,
  but it has no editorial content and no ranking rule.
- **Don't offer recommendations.** This shop has none configured. The three newer shops do - though
  the storefront cannot display them yet either.
- **Don't look for a rule-built category.** This shop has none; Toolbox Bricolage and
  Le livre & le lièvre each have one.

---

Counts here were measured on 2026-08-13. Every search, suggestion and page in the script was checked
against a live instance on 2026-10-23. The full dataset reference, including how each number was
obtained and what the catalogue contains field by field, is in `../../GUIDE.md`.
