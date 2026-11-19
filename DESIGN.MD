---
version: 1.0.0-PROD
name: UNERD-Footwear-Editorial-Monochrome-Design-System
description: High-contrast modern footwear & e-commerce design system for UNERD Footwear ("Nerd Can Stand Out"). Blends crisp gallery white canvas (#FFFFFF) and studio concrete surfaces (#F5F5F7) with Jet Black (#09090B) brand anchors and energetic performance accents — Volt Neon, Blaze Orange, Retro Gum, and Electric Cobalt.

colors:
  primary: "#09090B"
  primary-active: "#27272A"
  primary-disabled: "#D4D4D8"
  ink: "#09090B"
  body: "#3F3F46"
  body-strong: "#18181B"
  muted: "#71717A"
  muted-soft: "#A1A1AA"
  hairline: "#E4E4E7"
  hairline-soft: "#F4F4F5"
  canvas: "#FFFFFF"
  surface-soft: "#F8F8FA"
  surface-card: "#F4F4F5"
  surface-strong: "#E4E4E7"
  surface-dark: "#09090B"
  surface-dark-elevated: "#18181B"
  surface-volt: "#F7FEE7"
  surface-blaze: "#FFF7ED"
  surface-cobalt: "#EFF6FF"
  surface-gum: "#FAF7F2"
  on-primary: "#FFFFFF"
  on-dark: "#FFFFFF"
  on-dark-soft: "#A1A1AA"
  brand-jet-black: "#09090B"
  brand-volt: "#D9F99D"
  brand-volt-intense: "#BEF264"
  brand-blaze: "#FF5500"
  brand-cobalt: "#2563EB"
  brand-gum: "#C8A98E"
  brand-concrete: "#E4E4E7"
  success: "#16A34A"
  warning: "#F59E0B"
  error: "#DC2626"

typography:
  display-xl:
    fontFamily: "Plus Jakarta Sans, Space Grotesk, Inter, sans-serif"
    fontSize: 72px
    fontWeight: 800
    lineHeight: 0.95
    letterSpacing: -3px
  display-lg:
    fontFamily: "Plus Jakarta Sans, Space Grotesk, Inter, sans-serif"
    fontSize: 56px
    fontWeight: 800
    lineHeight: 1.0
    letterSpacing: -2.2px
  display-md:
    fontFamily: "Plus Jakarta Sans, Space Grotesk, Inter, sans-serif"
    fontSize: 40px
    fontWeight: 700
    lineHeight: 1.08
    letterSpacing: -1.5px
  display-sm:
    fontFamily: "Plus Jakarta Sans, Space Grotesk, Inter, sans-serif"
    fontSize: 32px
    fontWeight: 700
    lineHeight: 1.15
    letterSpacing: -0.8px
  title-lg:
    fontFamily: "Plus Jakarta Sans, Inter, sans-serif"
    fontSize: 24px
    fontWeight: 700
    lineHeight: 1.25
    letterSpacing: -0.4px
  title-md:
    fontFamily: "Inter, sans-serif"
    fontSize: 18px
    fontWeight: 600
    lineHeight: 1.35
    letterSpacing: -0.2px
  title-sm:
    fontFamily: "Inter, sans-serif"
    fontSize: 16px
    fontWeight: 600
    lineHeight: 1.4
    letterSpacing: 0
  body-md:
    fontFamily: "Inter, sans-serif"
    fontSize: 16px
    fontWeight: 400
    lineHeight: 1.55
    letterSpacing: 0
  body-sm:
    fontFamily: "Inter, sans-serif"
    fontSize: 14px
    fontWeight: 400
    lineHeight: 1.55
    letterSpacing: 0
  caption:
    fontFamily: "Inter, sans-serif"
    fontSize: 13px
    fontWeight: 500
    lineHeight: 1.4
    letterSpacing: 0.2px
  caption-uppercase:
    fontFamily: "Plus Jakarta Sans, Inter, sans-serif"
    fontSize: 12px
    fontWeight: 700
    lineHeight: 1.4
    letterSpacing: 1.8px
  button:
    fontFamily: "Plus Jakarta Sans, Inter, sans-serif"
    fontSize: 14px
    fontWeight: 700
    lineHeight: 1
    letterSpacing: 0.5px
  nav-link:
    fontFamily: "Inter, sans-serif"
    fontSize: 14px
    fontWeight: 600
    lineHeight: 1.4
    letterSpacing: 0.2px

rounded:
  xs: 4px
  sm: 6px
  md: 8px
  lg: 12px
  xl: 16px
  pill: 9999px
  full: 9999px

spacing:
  xxs: 4px
  xs: 8px
  sm: 12px
  md: 16px
  lg: 24px
  xl: 32px
  xxl: 48px
  section: 96px

components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.on-primary}"
    typography: "{typography.button}"
    rounded: "{rounded.md}"
    padding: 14px 24px
    height: 48px
  button-primary-active:
    backgroundColor: "{colors.primary-active}"
    textColor: "{colors.on-primary}"
    rounded: "{rounded.md}"
  button-primary-disabled:
    backgroundColor: "{colors.primary-disabled}"
    textColor: "{colors.muted}"
    rounded: "{rounded.md}"
  button-secondary:
    backgroundColor: "{colors.canvas}"
    textColor: "{colors.ink}"
    typography: "{typography.button}"
    rounded: "{rounded.md}"
    padding: 14px 24px
    height: 48px
  button-on-color:
    backgroundColor: "{colors.canvas}"
    textColor: "{colors.ink}"
    typography: "{typography.button}"
    rounded: "{rounded.md}"
    padding: 14px 24px
    height: 48px
  button-text-link:
    backgroundColor: transparent
    textColor: "{colors.ink}"
    typography: "{typography.button}"
  text-link:
    backgroundColor: transparent
    textColor: "{colors.ink}"
    typography: "{typography.body-md}"
  top-nav:
    backgroundColor: "{colors.canvas}"
    textColor: "{colors.ink}"
    typography: "{typography.nav-link}"
    height: 72px
  hero-band:
    backgroundColor: "{colors.canvas}"
    textColor: "{colors.ink}"
    typography: "{typography.display-xl}"
    padding: 96px
  hero-lookbook-card:
    backgroundColor: "{colors.surface-card}"
    textColor: "{colors.ink}"
    rounded: "{rounded.xl}"
  feature-card-black:
    backgroundColor: "{colors.brand-jet-black}"
    textColor: "{colors.on-dark}"
    typography: "{typography.title-md}"
    rounded: "{rounded.xl}"
    padding: 32px
  feature-card-volt:
    backgroundColor: "{colors.brand-volt-intense}"
    textColor: "{colors.ink}"
    typography: "{typography.title-md}"
    rounded: "{rounded.xl}"
    padding: 32px
  feature-card-blaze:
    backgroundColor: "{colors.brand-blaze}"
    textColor: "{colors.on-dark}"
    typography: "{typography.title-md}"
    rounded: "{rounded.xl}"
    padding: 32px
  feature-card-cobalt:
    backgroundColor: "{colors.brand-cobalt}"
    textColor: "{colors.on-dark}"
    typography: "{typography.title-md}"
    rounded: "{rounded.xl}"
    padding: 32px
  feature-card-gum:
    backgroundColor: "{colors.brand-gum}"
    textColor: "{colors.ink}"
    typography: "{typography.title-md}"
    rounded: "{rounded.xl}"
    padding: 32px
  feature-card-concrete:
    backgroundColor: "{colors.surface-card}"
    textColor: "{colors.ink}"
    typography: "{typography.title-md}"
    rounded: "{rounded.xl}"
    padding: 32px
  product-shoe-card:
    backgroundColor: "{colors.surface-soft}"
    textColor: "{colors.ink}"
    typography: "{typography.title-md}"
    rounded: "{rounded.lg}"
    padding: 20px
  review-card:
    backgroundColor: "{colors.surface-card}"
    textColor: "{colors.ink}"
    typography: "{typography.body-md}"
    rounded: "{rounded.lg}"
    padding: 24px
  size-selector-pill:
    backgroundColor: "{colors.canvas}"
    textColor: "{colors.ink}"
    typography: "{typography.button}"
    rounded: "{rounded.sm}"
    padding: 10px 14px
  size-selector-pill-active:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.on-primary}"
    typography: "{typography.button}"
    rounded: "{rounded.sm}"
  text-input:
    backgroundColor: "{colors.canvas}"
    textColor: "{colors.ink}"
    typography: "{typography.body-md}"
    rounded: "{rounded.md}"
    padding: 12px 16px
    height: 48px
  text-input-focused:
    backgroundColor: "{colors.canvas}"
    textColor: "{colors.ink}"
    rounded: "{rounded.md}"
  category-tab:
    backgroundColor: transparent
    textColor: "{colors.muted}"
    typography: "{typography.nav-link}"
    rounded: "{rounded.pill}"
    padding: 8px 18px
  category-tab-active:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.on-primary}"
    typography: "{typography.nav-link}"
    rounded: "{rounded.pill}"
  badge-pill:
    backgroundColor: "{colors.surface-card}"
    textColor: "{colors.ink}"
    typography: "{typography.caption-uppercase}"
    rounded: "{rounded.pill}"
    padding: 6px 12px
  collab-spotlight-card:
    backgroundColor: "{colors.surface-dark}"
    textColor: "{colors.on-dark}"
    typography: "{typography.title-lg}"
    rounded: "{rounded.xl}"
    padding: 32px
  cta-band-editorial:
    backgroundColor: "{colors.surface-card}"
    textColor: "{colors.ink}"
    typography: "{typography.display-md}"
    rounded: "{rounded.xl}"
    padding: 80px
  footer:
    backgroundColor: "{colors.surface-dark}"
    textColor: "{colors.on-dark-soft}"
    typography: "{typography.body-sm}"
    padding: 80px
---

## Overview

UNERD Footwear embodies a **bold, high-contrast streetwear-meets-performance aesthetic** anchored by its ethos *"Nerd Can Stand Out"*. The base atmosphere is a **crisp gallery-white canvas** (`{colors.canvas}` — #FFFFFF) paired with cool studio-concrete product pedestals (`{colors.surface-card}` — #F4F4F5) and razor-sharp Jet Black ink (`{colors.ink}` — #09090B). Rather than distracting from footwear colorways, the monochrome shell acts as a clean architectural gallery where shoe silhouettes, materials, and limited collaborations take center stage.

Type voice runs **Bold Geometric Display** (`Plus Jakarta Sans` / `Space Grotesk` at weight 700–800 with tight negative letter-spacing) mirroring UNERD's bold, slightly rounded all-caps logotype and heel-tab branding. Body and spec tables use `Inter` at clean, utilitarian weights for sizing charts, midsole specs, and checkout flows.

Component voltage comes from **purpose-coded category and technology cards**: Jet Black for flagship drops & collaborations, Volt Neon for Beat-series running propulsion, Blaze Orange for trail & energy return, Electric Cobalt for heritage IP collabs (e.g., Garuda Indonesia), and Retro Gum for classic lifestyle silhouettes (e.g., DHIGH & Insurgent).

**Key Characteristics:**
- Crisp gallery-white canvas (`{colors.canvas}` — #FFFFFF) paired with neutral concrete product cards (`{colors.surface-card}` — #F4F4F5) so multi-colorway sneakers never clash with the UI.
- Jet Black primary CTAs (`{colors.primary}` — #09090B) with crisp `{rounded.md}` (8px) corners — engineered, athletic, and decisive.
- 6-surface category & tech palette: `{colors.brand-jet-black}`, `{colors.brand-volt-intense}`, `{colors.brand-blaze}`, `{colors.brand-cobalt}`, `{colors.brand-gum}`, and `{colors.surface-card}` (concrete).
- High-resolution 3/4 studio footwear cut-outs, sole-tech macro renders, and editorial street-style lookbook photography as primary visual artifacts.
- Heavy geometric display headlines (`Plus Jakarta Sans` 800 weight, `-2.2px` to `-3px` tracking) contrasted with technical uppercase spec labels (`{typography.caption-uppercase}`).
- Structured, crisp border radii: `{rounded.sm}` (6px) for EU size selectors, `{rounded.md}` (8px) for buttons/inputs, `{rounded.lg}` (12px) for product cards, and `{rounded.xl}` (16px) for campaign banners.
- Embedded footwear engineering specs inside feature cards — midsole foam durometer, drop height (mm), outsole grip diagrams, and colorway swatches.
- Section rhythm `{spacing.section}` (96px) between lookbook, product grid, and tech breakdown bands.
- High-contrast **Jet Black Footer** (`{colors.surface-dark}` — #09090B) mirroring UNERD's signature black shoebox packaging and flagship retail store aesthetic.

## Colors

### Brand & Category Accents
- **Primary / Jet Black** (`{colors.primary}` — #09090B): Primary CTAs ("ADD TO BAG", "SHOP DROP"), h1/h2 display ink, and flagship shoebox surfaces.
- **Brand Volt** (`{colors.brand-volt-intense}` — #BEF264): High-visibility neon lime-yellow for *Beat Tempo / Beat Flow* running tech cards and speed badges.
- **Brand Blaze** (`{colors.brand-blaze}` — #FF5500): Energetic safety orange for *Montrex* trail running, energy-return callouts, and "NEW DROP" tags.
- **Brand Cobalt** (`{colors.brand-cobalt}` — #2563EB): Bold electric blue for special IP collaborations and recovery sandal lines (*Thera Active*).
- **Brand Gum** (`{colors.brand-gum}` — #C8A98E): Warm vulcanized rubber / earth-tone accent for *DHIGH* & *Insurgent* retro lifestyle sneakers.
- **Brand Concrete** (`{colors.brand-concrete}` — #E4E4E7): Architectural gray accent for dividers, size grids, and technical spec lines.

### Surface
- **Canvas** (`{colors.canvas}` — #FFFFFF): Default page floor. Pure gallery white to keep shoe photography color-accurate.
- **Surface Soft** (`{colors.surface-soft}` — #F8F8FA): Subtle studio backdrop for product catalog thumbnails.
- **Surface Card** (`{colors.surface-card}` — #F4F4F5): Cool light-gray cards for customer reviews, editorial banners, and neutral feature blocks.
- **Surface Strong** (`{colors.surface-strong}` — #E4E4E7): Active filter bars and emphasized structural bands.
- **Surface Dark** (`{colors.surface-dark}` — #09090B): Signature UNERD shoebox black for the global footer, limited drop countdowns, and VIP collab spotlights.
- **Surface Dark Elevated** (`{colors.surface-dark-elevated}` — #18181B): Interactive cards on dark drop sections.
- **Hairline** (`{colors.hairline}` — #E4E4E7): Crisp 1px borders on EU size pills, inputs, and spec matrices.

### Text
- **Ink** (`{colors.ink}` — #09090B): Headlines, product titles, and prices.
- **Body Strong** (`{colors.body-strong}` — #18181B): Emphasized product descriptions and key tech specs.
- **Body** (`{colors.body}` — #3F3F46): Default editorial copy and material breakdowns.
- **Muted** (`{colors.muted}` — #71717A): Secondary metadata, category breadcrumbs, and sold-out size states.
- **Muted Soft** (`{colors.muted-soft}` — #A1A1AA): Fine-print, SKU codes, and dark-footer links.
- **On Primary / On Dark** (`{colors.on-primary}` — #FFFFFF): Text on Jet Black buttons, Blaze/Cobalt cards, and dark footer.

### Semantic
- **Success** (`{colors.success}` — #16A34A): "In Stock", verified buyer badges, and free shipping thresholds.
- **Warning** (`{colors.warning}` — #F59E0B): "Low Stock — Only 2 Left" urgency indicators.
- **Error** (`{colors.error}` — #DC2626): "Sold Out" states and form validation errors.

## Typography

### Font Family
The system pairs **Plus Jakarta Sans** (or **Space Grotesk**) for punchy, geometric display headlines that echo UNERD's bold wordmark, with **Inter** for clean e-commerce UI, technical midsole specs, and pricing. Fallback stack: `Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif`.

### Hierarchy

| Token | Size | Weight | Line Height | Letter Spacing | Use |
|---|---|---|---|---|---|
| `{typography.display-xl}` | 72px | 800 | 0.95 | -3px | Hero Drop Headlines ("NERD CAN STAND OUT") |
| `{typography.display-lg}` | 56px | 800 | 1.0 | -2.2px | Collection Headers ("BEAT SERIES RUNNING") |
| `{typography.display-md}` | 40px | 700 | 1.08 | -1.5px | Sub-section heads, Collaboration titles |
| `{typography.display-sm}` | 32px | 700 | 1.15 | -0.8px | Editorial CTA headers, Midsole tech titles |
| `{typography.title-lg}` | 24px | 700 | 1.25 | -0.4px | Product Detail Page (PDP) shoe title & price |
| `{typography.title-md}` | 18px | 600 | 1.35 | -0.2px | Feature card titles, Lookbook captions |
| `{typography.title-sm}` | 16px | 600 | 1.4 | 0 | Product grid card title (e.g., "DHIGH Off-White") |
| `{typography.body-md}` | 16px | 400 | 1.55 | 0 | Product storytelling, material descriptions |
| `{typography.body-sm}` | 14px | 400 | 1.55 | 0 | Shipping/return info, footer links |
| `{typography.caption}` | 13px | 500 | 1.4 | 0.2px | Colorway names, SKU labels, review dates |
| `{typography.caption-uppercase}` | 12px | 700 | 1.4 | 1.8px | Category tags ("LIFESTYLE", "RUNNING", "COLLAB") |
| `{typography.button}` | 14px | 700 | 1.0 | 0.5px | Uppercase/Sentence CTA labels, EU Size numbers |
| `{typography.nav-link}` | 14px | 600 | 1.4 | 0.2px | Top-nav categories (Sneakers, Running, Sandals, Collabs) |

### Principles
Display headlines stay unapologetically bold (700–800) with tight negative letter-spacing to match the blocky, confident geometry of UNERD's "U" side-stripe and heel-tab branding.

Technical metadata (stack height, weight in grams, drop in mm, SKU codes) uses crisp uppercase labels (`{typography.caption-uppercase}`) to give performance footwear an engineered, athletic-lab credibility.

## Layout

### Spacing System
- **Base unit:** 4px.
- **Tokens:** `{spacing.xxs}` 4px · `{spacing.xs}` 8px · `{spacing.sm}` 12px · `{spacing.md}` 16px · `{spacing.lg}` 24px · `{spacing.xl}` 32px · `{spacing.xxl}` 48px · `{spacing.section}` 96px.
- **Section padding:** `{spacing.section}` (96px) between major lookbook, catalog, and tech feature bands.
- **Card internal padding:** `{spacing.xl}` (32px) for tech/collab feature cards; `{spacing.md}` to `{spacing.lg}` (16–24px) for e-commerce product cards.

### Grid & Container
- **Max content width:** 1320px centered (generous width for 4-column shoe catalogs).
- **Hero grid:** Asymmetric 6/6 or 7/5 split (bold typography + drop CTA left, floating 3/4 shoe render or editorial lookbook right).
- **Product catalog grid:** 4-up at desktop, 2-up at tablet, 2-up compact at mobile.
- **Technology / Feature cards:** 3-up at desktop, 2-up at tablet, 1-up at mobile.

### Whitespace Philosophy
Gallery-clean breathing room around footwear silhouettes. By keeping the main canvas pure white (`#FFFFFF`) and placing shoes on soft concrete pedestals (`#F8F8FA`), every stitch, suede overlay, and gum sole stands out without visual clutter.

## Elevation & Depth

| Level | Treatment | Use |
|---|---|---|
| Flat | No shadow, no border | Body sections, editorial headers |
| Studio Pedestal | `{colors.surface-soft}` (#F8F8FA) fill, no shadow | Product grid image containers |
| Crisp Hairline | 1px `{colors.hairline}` border | EU size selector pills, text inputs, spec tables |
| Saturated Tech Card | Jet Black / Volt / Blaze / Cobalt / Gum fill — no shadow | Footwear technology & collection highlight cards |
| Dark Shoebox Band | `{colors.surface-dark}` (#09090B) fill | Limited edition drops, global footer |

The system avoids soft drop-shadows; depth is achieved through sharp monochrome contrast (`#FFFFFF` vs `#09090B`) and clean studio cutouts.

### Decorative Depth
- **3/4 Angle Studio Footwear Cut-outs** — crisp, high-resolution product photography with subtle grounded contact shadows.
- **Stylized "U" Graphic Motif** — oversized low-opacity watermark of UNERD's signature curved "U" quarter-panel emblem used behind hero and collab sections.

## Shapes

### Border Radius Scale

| Token | Value | Use |
|---|---|---|
| `{rounded.xs}` | 4px | Colorway swatch squares, discount tags |
| `{rounded.sm}` | 6px | EU size selector buttons (39–45), filter chips |
| `{rounded.md}` | 8px | Primary CTA buttons ("ADD TO BAG"), search & promo inputs |
| `{rounded.lg}` | 12px | Product catalog cards, customer review cards |
| `{rounded.xl}` | 16px | Tech feature cards, campaign lookbook banners |
| `{rounded.pill}` | 9999px | Category filter tabs, status badges ("BEST SELLER", "SOLD OUT") |
| `{rounded.full}` | 9999px / 50% | Circular colorway dots, reviewer avatars |

## Components

### Top Navigation

**`top-nav`** — Sticky gallery-white header (`{colors.canvas}`), 72px tall with 1px bottom `{colors.hairline}`. Bold **UNERD** geometric wordmark at left; center navigation (`New Arrivals`, `Sneakers`, `Running`, `Sandals`, `Collaborations`); right utility cluster with Search icon, Account, and Shopping Bag counter badge in `{colors.primary}`.

### Buttons

**`button-primary`** — Solid Jet Black (`{colors.primary}` — #09090B), white bold text (`{colors.on-primary}`), `{typography.button}`, padding 14px × 24px, height 48px, rounded `{rounded.md}` (8px).

**`button-secondary`** — Pure white (`{colors.canvas}`) with 1.5px Jet Black border, `{colors.ink}` text. Used for "VIEW SIZE CHART" or secondary collection links.

**`button-on-color`** — White button (`{colors.canvas}` fill, `{colors.ink}` text) placed inside Jet Black, Blaze Orange, or Cobalt feature cards.

**`button-text-link`** — Inline uppercase link with directional arrow (`EXPLORE SERIES →`), no background.

### Cards & Containers

**`hero-band`** — Pure white canvas (`{colors.canvas}`) with bold display headline (`{typography.display-xl}`), collection badge (`{component.badge-pill}`), primary + secondary CTA row on the left, and a high-impact `{component.hero-lookbook-card}` featuring the flagship silhouette on the right.

**`hero-lookbook-card`** — Concrete-gray studio pedestal (`{colors.surface-card}`), rounded `{rounded.xl}` (16px), showcasing full-bleed sneaker photography with floating spec callouts (e.g., *"Ultra-Responsive Foam • 245g"*).

**`product-shoe-card`** — E-commerce grid card. Top 4:5 image container on `{colors.surface-soft}` (`{rounded.lg}`) with top-left `{component.badge-pill}` ("NEW", "COLLAB", "RESTOCK"). Below sits interactive colorway dots, shoe title in `{typography.title-sm}`, category subtitle (`Lifestyle` / `Performance Running`), and bold IDR price (`Rp 349.000`).

**`feature-card-black`** / **`feature-card-volt`** / **`feature-card-blaze`** / **`feature-card-cobalt`** / **`feature-card-gum`** — Saturated single-color technology & line cards. Rounded `{rounded.xl}` (16px), padding `{spacing.xl}` (32px).
- `feature-card-black` (white text): Limited collaborations (*UNERD x Tahilalats*, *Godzilla*, *Makers by Makna*).
- `feature-card-volt` (dark ink text): *Beat Series* running propulsion & carbon/nylon plate tech.
- `feature-card-blaze` (white text): *Montrex* trail grip & high-abrasion outsoles.
- `feature-card-cobalt` (white text): *Thera Active* post-run recovery sandals & special IP drops.
- `feature-card-gum` (dark ink text): *DHIGH* & *Insurgent* classic vulcanized & cupsole lifestyle series.

**`feature-card-concrete`** — Neutral `{colors.surface-card}` block for brand craftsmanship stories (Pasuruan manufacturing, quality control, local materials).

**`review-card`** — Verified buyer testimonial on `{colors.surface-card}`, rounded `{rounded.lg}`, padding `{spacing.lg}`. Includes 5-star rating in `{colors.ink}`, sizing fit indicator (*"True to Size"*), purchased colorway + EU size tag, and customer quote.

**`collab-spotlight-card`** — Full-width dark shoebox banner (`{colors.surface-dark}` — #09090B), rounded `{rounded.xl}`, highlighting limited-edition drops with countdown timer, co-branded logos, and `{component.button-on-color}`.

### E-Commerce Selectors & Inputs

**`size-selector-pill`** + **`size-selector-pill-active`** — Grid of EU shoe sizes (`38` to `45`). Default: white fill, 1px `{colors.hairline}` border, `{rounded.sm}` (6px). Active: Jet Black fill (`#09090B`) with white bold text. Disabled/Sold-out: `{colors.surface-soft}` fill with strikethrough `{colors.muted}` text.

**`text-input`** — White background (`{colors.canvas}`), 1px `{colors.hairline}` border, rounded `{rounded.md}` (8px), height 48px. Used for newsletter drop alerts, promo codes, and shipping checkout.

### Tabs & Badges

**`category-tab`** + **`category-tab-active`** — Horizontal filter pills (`All Footwear`, `Lifestyle Sneakers`, `Running`, `Trail`, `Sandals`). Active pill flips to solid Jet Black (`#09090B`) with white text.

**`badge-pill`** — Uppercase tag (`{typography.caption-uppercase}`), rounded `{rounded.pill}`. Neutral concrete for standard tags; Volt or Blaze fill for high-priority drops.

### CTA & Footer

**`cta-band-editorial`** — Pre-footer brand manifesto band (*"Nerd Can Stand Out — Step Into Your Pair"*). Background `{colors.surface-card}`, rounded `{rounded.xl}`, padding 80px, paired with `{component.button-primary}`.

**`footer`** — Signature **Jet Black Shoebox Footer** (`{colors.surface-dark}` — #09090B) with crisp white UNERD wordmark, 4-column navigation (`Shop`, `Collections`, `Customer Care & Sizing`, `Offline Stores — Plaza Senayan & Surabaya`), newsletter drop signup, and payment/shipping badges.

## Do's and Don'ts

### Do
- Keep the main shopping canvas pure gallery white (`#FFFFFF`) and product pedestals neutral concrete (`#F8F8FA`) so multi-color shoe photography remains 100% color-accurate.
- Use Jet Black (`#09090B`) as the unmistakable brand anchor across primary buttons, active size pills, and the shoebox-inspired footer.
- Code saturated feature cards by product function: Volt for Running speed, Blaze for Trail energy, Gum for Retro Lifestyle, Cobalt for Recovery/IP Collabs, and Jet Black for Limited Drops.
- Use bold geometric display typography (`700–800` weight, tight negative tracking) to mirror UNERD's bold wordmark and heel-tab aesthetic.
- Include practical footwear UX metadata (EU sizing fit notes, weight in grams, heel-to-toe drop, colorway swatches) directly inside product and tech cards.
- Maintain `{spacing.section}` (96px) vertical breathing room between major lookbook and catalog sections.

### Don't
- Don't tint the main product catalog background with warm cream or pastel colors—it distorts white, off-white, and cream sneaker colorways.
- Don't use overly soft, bubbly 24px+ pill radii on buttons or size selectors; keep corners crisp (`6px–12px`) to match athletic streetwear precision.
- Don't place saturated Volt or Blaze cards back-to-back without a neutral white or concrete breather section between them.
- Don't use thin/light font weights (`300`) for headlines; UNERD's visual voice is bold, confident, and high-contrast.
- Don't use a light-gray footer; the Jet Black shoebox footer is a core brand signature.

## Responsive Behavior

### Breakpoints

| Name | Width | Key Changes |
|---|---|---|
| Mobile | < 768px | Hamburger drawer nav; hero h1 72→38px; hero shoe card stacks below; product grid 2-up; size selector 4-column grid; feature cards 1-up |
| Tablet | 768–1024px | Condensed top nav; product grid 3-up; feature cards 2-up |
| Desktop | 1024–1440px | Full top-nav; 4-up product catalog grid; 3-up tech feature cards |
| Wide | > 1440px | Max container 1320px centered with wide gallery margins |

### Touch Targets
- `{component.button-primary}` and `{component.text-input}` at 48px height (exceeds WCAG AAA 44px minimum).
- `{component.size-selector-pill}` minimum 44 × 44px tap area for effortless mobile size selection.

### Collapsing Strategy
- Top nav collapses to slide-out drawer at < 768px with persistent Bag icon visible.
- Hero 6/6 split stacks vertically on mobile with CTA placed directly beneath the shoe visual.
- Product catalog collapses `4 → 3 → 2` columns (never 1-up on mobile so users can compare silhouettes quickly).
- Tech feature cards collapse `3 → 2 → 1`.

## Iteration Guide

1. Focus on ONE component at a time. Reference its YAML key (`{component.product-shoe-card}`, `{component.feature-card-volt}`).
2. Match the surface color to the footwear category: `feature-card-volt` for Beat running tech, `feature-card-blaze` for Montrex trail, `feature-card-gum` for DHIGH/Insurgent lifestyle, `feature-card-cobalt` for Thera/IP collabs, `feature-card-black` for limited drops.
3. Variants (`-active`, `-disabled`) live as separate entries in `components:`.
4. Always reference `{token.refs}` rather than hardcoded hex values inside component definitions.
5. Keep display typography bold (`700–800`) with tight tracking; keep e-commerce pricing and sizing tabular and legible.

## Known Gaps

- Custom display font matching UNERD's exact bespoke logotype geometry is approximated via `Plus Jakarta Sans` / `Space Grotesk` at weight 800.
- Interactive 360-degree shoe spin viewers and AR try-on overlays are asset/script integrations outside static design tokens.
- Complex multi-tier loyalty / reseller portal tables are out of scope for this consumer storefront design system.