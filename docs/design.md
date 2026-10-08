# 🎨 RideEasy — Mobile & Web UI/UX Design System & Screen Specifications

| | |
| :--- | :--- |
| **Document** | RideEasy UI/UX Design System Specification |
| **Version** | 1.0 (Derived from High-Fidelity Mobile Design Suite) |
| **Date** | October 2026 |
| **Status** | Approved Design Reference |
| **Theme Support** | Dual Theme: Clean Minimal Light & Midnight Electric Dark |
| **Target Viewport** | Mobile-First (390px × 844px baseline; responsive to Tablet & Web) |
| **PRD Reference** | [docs/PRD.md](../docs/PRD.md) |

---

## Table of Contents

1. [Design Philosophy & Visual Language](#1-design-philosophy--visual-language)
2. [Color Palette & Theme Tokens](#2-color-palette--theme-tokens)
3. [Typography System](#3-typography-system)
4. [Elevation, Spacing & Border Radii](#4-elevation-spacing--border-radii)
5. [Comprehensive Screen-by-Screen Breakdown](#5-comprehensive-screen-by-screen-breakdown)
   - [Screen 01: Onboarding Carousel / Hero Discovery](#screen-01-onboarding-carousel--hero-discovery)
   - [Screen 02: Auth Welcome & Social Entry](#screen-02-auth-welcome--social-entry)
   - [Screen 03: Sign In (Light Theme)](#screen-03-sign-in-light-theme)
   - [Screen 04: Sign Up & Account Creation (Light Theme)](#screen-04-sign-up--account-creation-light-theme)
   - [Screen 05: OTP / Email Verification ("Almost there!")](#screen-05-otp--email-verification-almost-there)
   - [Screen 06: Location Picker & Map Discovery](#screen-06-location-picker--map-discovery)
   - [Screen 07: Home Discovery & Recommendations](#screen-07-home-discovery--recommendations)
   - [Screen 08: Catalog & Vehicle Type Hub](#screen-08-catalog--vehicle-type-hub)
   - [Screen 09: Filter & Price Histogram Sheet (Dark Theme)](#screen-09-filter--price-histogram-sheet-dark-theme)
   - [Screen 10: Vehicle Detail Specification View (Dark Theme)](#screen-10-vehicle-detail-specification-view-dark-theme)
   - [Screen 11: 360° Interactive Vehicle Viewer (Dark Theme)](#screen-11-360-interactive-vehicle-viewer-dark-theme)
   - [Screen 12: Itemized Pricing & Checkout Breakdown (Light Theme)](#screen-12-itemized-pricing--checkout-breakdown-light-theme)
   - [Screen 13: Deposit & Credit Simulation Sheet](#screen-13-deposit--credit-simulation-sheet)
   - [Screen 14: Vehicle Color & Trim Customizer Modal](#screen-14-vehicle-color--trim-customizer-modal)
   - [Screen 15: Favorites & Saved Fleet](#screen-15-favorites--saved-fleet)
   - [Screen 16: Direct Messaging & Fleet Support](#screen-16-direct-messaging--fleet-support)
6. [Reusable Component Specifications](#6-reusable-component-specifications)
7. [Navigation Architecture](#7-navigation-architecture)
8. [Motion & Micro-Interaction Guidelines](#8-motion--micro-interaction-guidelines)
9. [Tailwind CSS Design Tokens Configuration](#9-tailwind-css-design-tokens-configuration)

---

## 1. Design Philosophy & Visual Language

RideEasy's design language combines modern automotive showroom aesthetics with fast, high-conversion mobile rental ergonomics.

- **Vibrant Neo-Electric Accent**: Electric Royal Blue (`#2F54EB` / `#3B5BFD`) communicates trust, technology, and speed.
- **Atmospheric Contrast (Dual Mode)**:
  - **Light Mode**: High-legibility, clean white surfaces with subtle border dividers and soft drop shadows for daytime discovery, checkout, and account settings.
  - **Dark / Midnight Mode**: High-drama deep navy (`#0B0F19`) with radial back-glows and metallic vehicle renders for vehicle detail inspection, 360° exterior viewing, and advanced filtering.
- **Card-Driven Architecture**: Content is organized in rounded, padded surfaces (`border-radius: 16px` to `24px`) with clear visual hierarchy.
- **Floating Pill Controls**: Interactive tabs, category selectors, and primary CTAs use stadium/pill shapes (`rounded-full`) with touch targets ≥ 48px.

---

## 2. Color Palette & Theme Tokens

### 2.1 Core Palette

| Role | Color Name | Hex Code | HSL / CSS Variable | Description |
| :--- | :--- | :--- | :--- | :--- |
| **Brand Primary** | Electric Royal Blue | `#3B5BFD` | `hsl(230, 98%, 61%)` | Primary CTAs, active tab pills, brand marks |
| **Brand Hover / Active** | Deep Royal Blue | `#2342E2` | `hsl(230, 78%, 51%)` | Button hover and pressed states |
| **Brand Soft Tint** | Ice Blue Tint | `#EEF2FF` | `hsl(226, 100%, 97%)` | Chip active backgrounds in light mode |
| **Secondary Accent** | Cyan Glow | `#06B6D4` | `hsl(189, 94%, 43%)` | 360° indicator hotspot, live status |
| **Success** | Emerald Green | `#10B981` | `hsl(152, 69%, 41%)` | Verified badges, confirmation, available status |
| **Warning** | Amber Yellow | `#F59E0B` | `hsl(38, 92%, 50%)` | Star ratings (⭐ 4.8), low stock warning |
| **Destructive / Error** | Coral Red | `#EF4444` | `hsl(0, 84%, 60%)` | Validation errors, cancel actions, un-favorite |

### 2.2 Semantic Surface Tokens (Light vs. Dark Mode)

```css
:root {
  /* Light Theme */
  --bg-canvas: #FFFFFF;
  --bg-surface: #F8FAFC;
  --bg-surface-elevated: #FFFFFF;
  --border-subtle: #E2E8F0;
  --border-strong: #CBD5E1;
  --text-primary: #0F172A;
  --text-secondary: #64748B;
  --text-muted: #94A3B8;
  --cta-primary-bg: #3B5BFD;
  --cta-primary-text: #FFFFFF;
  --card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.06);
}

[data-theme='dark'] {
  /* Midnight Dark Theme */
  --bg-canvas: #0B0F19;
  --bg-surface: #111827;
  --bg-surface-elevated: #1F2937;
  --border-subtle: rgba(255, 255, 255, 0.08);
  --border-strong: rgba(255, 255, 255, 0.16);
  --text-primary: #F8FAFC;
  --text-secondary: #94A3B8;
  --text-muted: #64748B;
  --cta-primary-bg: #3B5BFD;
  --cta-primary-text: #FFFFFF;
  --card-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.45);
}
```

---

## 3. Typography System

**Font Family:** Plus Jakarta Sans, Inter, or Outfit with high legibility on mobile viewports.

| Token | Size | Line Height | Weight | Usage |
| :--- | :--- | :--- | :--- | :--- |
| `display-1` | 32px (2rem) | 38px | 800 (Extra Bold) | Splash & onboarding headlines |
| `h1` | 24px (1.5rem) | 30px | 700 (Bold) | Screen headers, vehicle titles |
| `h2` | 20px (1.25rem) | 26px | 600 (Semi-Bold) | Section headings ("Car recommendation") |
| `h3` | 16px (1rem) | 22px | 600 (Semi-Bold) | Vehicle card titles, modal sub-headers |
| `body-lg` | 15px (0.938rem) | 22px | 500 (Medium) | Form input text, primary button labels |
| `body-md` | 14px (0.875rem) | 20px | 400 (Regular) | Descriptive copy, terms of service |
| `caption` | 12px (0.75rem) | 16px | 500 (Medium) | Spec pill tags, bottom bar icon labels |
| `badge` | 11px (0.688rem) | 14px | 700 (Bold) | "Free test drive", "540 hp", discount tags |

---

## 4. Elevation, Spacing & Border Radii

### Spacing Grid

4px base:

`4px, 8px, 12px, 16px, 20px, 24px, 32px, 40px`

### Corner Radii

- `rounded-sm`: 6px — badges, tags
- `rounded-md`: 12px — form input fields, small thumbnail cards
- `rounded-lg`: 16px — vehicle catalog cards, bottom sheets
- `rounded-xl`: 24px — main display cards, hero promo banners
- `rounded-full`: 9999px — CTAs, filter category pills, floating badges

### Layering & Depth

**Glassmorphism:**

```css
backdrop-filter: blur(16px);
background: rgba(17, 24, 39, 0.75);
border: 1px solid rgba(255, 255, 255, 0.1);
```

---

## 5. Comprehensive Screen-by-Screen Breakdown

### Screen 01: Onboarding Carousel / Hero Discovery

**Theme:** Vibrant Royal Blue Gradient (`#2A4FE8 → #1E3BB8`).

- **Header:** Top progress bar (dash + dot indicator) with top-right ghost button `Skip`.
- **Hero Title:** "Choose ride right for you" (White, 30px, Bold).
- **Subtitle:** "Answer a few quick questions to find the right vehicle for you." (White 80% opacity, 14px).
- **Center Graphic:** High-contrast front-quarter vehicle render with dynamic floating spec pills:
  - Floating pill left: ⚡ `540 hp / 150 cc` (Translucent white glass).
  - Floating pill right: `Automatic` (Translucent white glass).
- **Pagination:** Carousel dot indicators with active pill indicator.
- **Bottom CTA:** Full-width white stadium button: `Get Started` with royal blue text.

### Screen 02: Auth Welcome & Social Entry

**Theme:** Royal Blue Background with car silhouette overlay.

- **Top Brand:** Logo icon + brand title `RideEasy / Carline`.
- **Headline:** "Let's get started" followed by "Sign up or login to see what's happening near you".
- **Center Visual:** Full metallic blue vehicle facing user.
- **Action Buttons:**
  - `Continue with Email` — White stadium button, dark text.
  - `Continue with Google` — White/translucent stadium button with multicolor Google logo.
  - `Continue with Apple` — Black/dark stadium button with white Apple logo.

### Screen 03: Sign In (Light Theme)

**Theme:** Clean Light Surface (`#FFFFFF`).

- **Header:** `✕` close button on top-left, title `Sign in to RideEasy`, sub-caption `Welcome back! Please enter your details.`
- **Form Inputs:**
  - **Email Field:** Leading mail icon, placeholder `saskirapolova@mail.com`, clear input outline with subtle focus ring.
  - **Password Field:** Leading key/lock icon, masked bullet points, trailing eye show/hide icon.
- **Help Link:** Right-aligned text link `Forgot password? Reset it`.
- **Primary CTA:** Full-width stadium button `Sign In` (`#3B5BFD` with white text).
- **Alternative OAuth:** Divider with `Sign in with Google` and `Sign in with Apple`.
- **Footer:** Centered caption: `Don't have an account? Sign Up`.

### Screen 04: Sign Up & Account Creation (Light Theme)

**Theme:** Clean Light Surface.

- **Header:** `✕` close button, title `Sign Up`.
- **Form Fields:**
  - Full Name input (user avatar icon).
  - Email input (mail icon).
  - Password input (lock icon + validation check).
- **Legal Copy:** "By signing up, you agree to our Terms of Service and Privacy Policy." with clickable links.
- **Primary CTA:** `Sign Up` stadium button.
- **Social Options:** Google & Apple sign-up buttons.
- **Footer:** `Already have an account? Sign In`.

### Screen 05: OTP / Email Verification ("Almost there!")

**Theme:** Light Mode.

- **Graphic:** Center-aligned mailbox/envelope badge icon with subtle circular drop shadow.
- **Headline:** "Almost there!"
- **Instructions:** "Check your email inbox and input the verification code to verify your account."
- **PIN Input:** 4 individual `rounded-md` boxes (`48px × 56px`) with active cursor focus ring: `[ 7 ] [ 5 ] [ 0 ] [   ]`.
- **Actions:**
  - **Primary CTA:** `Continue` (`#3B5BFD` pill).
  - **Secondary Action:** `Resend Code` (Ghost button with countdown timer).

### Screen 06: Location Picker & Map Discovery

**Theme:** Light Mode with embedded map vector styling.

- **Header:** Back arrow `←` + title `Choose your location`.
- **Search Bar:** Input with location pin icon: `Clay Street, San Francisco / Panaji, North Goa`.
- **Map Viewport:** Embedded map with radial location pin drop.
- **Current Location Card:**
  - Icon: Navigation compass icon in blue circle.
  - Label: `Use my current location`.
  - Address caption: `Jackson Street / Candolim Road`.
  - Metric badge: `50 available vehicles in current location`.
- **Actions:** Bottom sticky `Continue` button + `Skip` text button.

### Screen 07: Home Discovery & Recommendations

**Theme:** Light Mode.

- **Header:**
  - Location Selector: Location pin + `Location: San Francisco / North Goa` dropdown arrow.
  - Action: Notification bell icon with red unread badge dot.
- **Search & Filter Bar:**
  - Rounded-full search field `Search vehicles...` with magnifying glass icon.
  - Trailing filter settings slider icon.
- **Category Filter Tabs (Horizontal Scroll):**
  - Segment pills: `Sedan | Hatchback | Convertible | Scooter | Cruiser`.
  - Active pill: Solid Electric Blue with white text.
  - Inactive pill: Light grey background.
- **Section Header:** `Car recommendation` with right-aligned `View all` link.
- **Featured Recommendation Card:**
  - Vehicle render (side angle, Audi R8 or premium bike).
  - Top-right wishlist heart icon.
  - Tag: `Free test drive` / `Zero Deposit`.
  - Name: `Audi R8 Performance RWD` (18px, Bold).
  - Rating: ⭐ `4.8` (Star in yellow, score in bold).
  - Specs Chips: ⚡ `540 hp` | `Automatic` | `2 Seats`.
  - Pricing: `$176,037.11 / ₹1,200 / day`.
- **Bottom Navigation Bar:** 4-icon dock — Home, Favorites, Messages, Profile.

### Screen 08: Catalog & Vehicle Type Hub

**Theme:** Light Mode.

- **Header:** Location header + search bar.
- **Horizontal Quick-Browse Cards:** Mini cards showing recent models (`Audi A8 Quattro $12,190`, `Ferrari 488 Pista`).
- **Category Grid ("Shop by car type"):**
  - 4-column icon grid: `SUV | Hatchback | EV/Hybrid | Supercar`.
  - Dark rounded-xl container buttons with white silhouette icons.
- **Promotional Hub Banner:**
  - Deep Navy Card: `Test drive in your area`.
  - Description: `Test drive from your home or a RideEasy fleet hub`.
  - Action button: White pill `View vehicles`.
- **Infinite Catalog Section:** `Available vehicles` with full vehicle cards list.

### Screen 09: Filter & Price Histogram Sheet (Dark Theme)

**Theme:** Midnight Dark (`#0B0F19` canvas, `#111827` sheet).

- **Header:** Top bar with `Cancel`, title `Filters`, and `Reset`.
- **Quick Switch:** `Free test drive / Instant Pickup` toggle switch.
- **Active Filter Chips:** Dismissible chips with `✕` icon:
  - `Free test drive ✕`
  - `Toyota ✕`
  - `$23k - $80k ✕`
- **Brand Selector:** Grid of automotive brand logo tiles: Ferrari, Toyota (Active with blue outline), BMW, Honda.
- **Price Distribution Histogram Slider:**
  - Frequency bar chart showing volume of vehicles per price bucket.
  - Dual-thumb slider with min/max indicator pills: `$20,000 — $80,000` or `₹500/day — ₹2,500/day`.
- **Feature Filter Tags:** Selectable tags:
  - Navigation
  - Climate Control
  - Air Condition
  - Helmet Included
  - Bluetooth
- **Sticky CTA:** `Apply Filter` (Full-width `#3B5BFD` pill).

### Screen 10: Vehicle Detail Specification View (Dark Theme)

**Theme:** Midnight Dark (`#0B0F19`).

- **Header:** Transparent navigation bar with Back `←`, Wishlist `♡`, and Share `➦`.
- **Hero Staging:** Front-angle vehicle showcase resting on a glowing radial pedestal.
- **Title & Badge:**
  - Blue Badge: `Free test drive / Available Now`.
  - Vehicle Name: `Audi Q7 50 Quattro / Royal Enfield Hunter 350`.
- **Core Performance Grid (3 Columns):**
  - Metric 1: ⚡ `335 HP` — Horsepower.
  - Metric 2: ⚙ `369 lb-ft` — Torque / Engine capacity.
  - Metric 3: ⏱ `5.6 sec` — 0-60 mph / Top speed.
- **Content Segment Tabs:** `Details` (Active with underline) | `Features` | `Design` | `Price maps`.
- **Description Copy:** High-contrast typography describing transmission, headlights, safety packages, and rental guidelines.
- **Sticky Bottom Action Bar:**
  - Left: Price label (`$80,063` or `₹1,499 / day`).
  - Right: High-prominence CTA button `Book Now / Rent Now`.

### Screen 11: 360° Interactive Vehicle Viewer (Dark Theme)

**Theme:** Immersive Deep Navy (`#0B0F19`).

- **Header:** `✕` exit button, Vehicle Title rotated vertically or subtitled.
- **Canvas:** Fullscreen rotatable 3D model (isometric top-down view).
- **Interactive Scrubber Pill:** Floating pill overlay: `◂ 360° ▸` with touch-drag gesture indicator.
- **Inspection Hotspots:** Interactive glowing circular pins highlighting:
  - Wheels
  - Sunroof
  - Trunk capacity
  - Engine specs
- **Controls:** Share button and camera reset icon.

### Screen 12: Itemized Pricing & Checkout Breakdown (Light Theme)

**Theme:** Clean Light Mode.

- **Header:** Back arrow, title `Audi Q7 Quattro`, Wishlist, Share.
- **Tagline:** `Simple pricing, no haggling required`.
- **Itemized Bill Card:**
  - Base Vehicle Rate: `$79.00 / day`
  - Platform & Maintenance Fee: `$175.00`
  - Documentation / Verification: `$30.00`
  - Vehicle Registration / Insurance: `$80.00`
  - Sales Tax / GST (18%): `$3,874.00`
  - Total Amount: `$80,063.00` (or total rental sum)
- **Flexible Option:** Est. Monthly payment / Daily rate: `$1,075 / mo`.
- **Secondary Tool:** Outlined stadium button `Credit Simulation / Security Deposit Details`.
- **Sticky Booking Footer:**
  - Summary: Total Price in bold.
  - Action: Primary Blue CTA `Confirm & Reserve / Buy`.

### Screen 13: Deposit & Credit Simulation Sheet

**Theme:** Light Mode Bottom Sheet.

- **Header:** `✕` close button, title `Credit Simulation` or `Deposit & Duration Calculator`.
- **Interactive Slider 1:** Down payment / Security deposit amount with live value pill.
- **Interactive Slider 2:** Loan tenure / Rental duration days with live recalculation.
- **Calculated Result:** Live monthly or daily installment forecast.

### Screen 14: Vehicle Color & Trim Customizer Modal

**Theme:** Midnight Dark / Royal Blue Card.

- **Header:** `✕` close button, vehicle thumbnail.
- **Visual:** Live interactive vehicle render switching colors on the fly.
- **Color Swatches:** Palette selector pills:
  - Glacier White
  - Mythos Black
  - Navarra Blue
  - Daytona Grey

### Screen 15: Favorites & Saved Fleet

**Theme:** Light Mode.

- **Header:** Back button, title `Favorites`.
- **Content:** 2-column or list view of saved vehicles with:
  - Live availability indicators (`Available` in green vs `Booked` in grey).
  - Quick delete swipe.
  - Instant `Book` shortcut.

### Screen 16: Direct Messaging & Fleet Support

**Theme:** Light Mode.

- **Header:** Back button, title `Messages`, trailing more-options icon.
- **Search:** `Search message` search input.
- **Conversation List:**
  - Avatar with online status green dot.
  - Contact Name: `Florencia Dorrance` (Fleet Hub Manager).
  - Preview snippet: `Yes, of course. We will make it easy...`.
  - Timestamp: `06:00 PM`.
  - Unread badge counter.

---

## 6. Reusable Component Specifications

### 6.1 Buttons & Action Controls

| Component | Visual Style | Dimensions | Padding | Radius | Usage |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Primary Pill** | Background `#3B5BFD`, Text `#FFFFFF`, font-semibold | Height 52px | `px-6 py-3.5` | `rounded-full` | Main CTAs (`Get Started`, `Sign In`, `Book Now`) |
| **Secondary Outlined** | Border 1.5px solid `#3B5BFD`, Text `#3B5BFD`, Transparent bg | Height 48px | `px-5 py-3` | `rounded-full` | `Credit Simulation`, `Resend Code` |
| **Social OAuth Pill** | Background `#FFFFFF` or `#0F172A`, 1px border `#E2E8F0` | Height 50px | `px-4 py-3` | `rounded-full` | Google & Apple sign-in buttons |
| **Category Filter Pill** | Active: `#3B5BFD` with white text; Inactive: `#F1F5F9` with `#475569` text | Height 38px | `px-4 py-2` | `rounded-full` | Vehicle type selectors |
| **Icon Button Circle** | Translucent glass or light grey circle | `44px × 44px` | `p-2.5` | `rounded-full` | Icon-only actions |

---

## 7. Navigation Architecture

### 7.1 Primary Mobile Navigation

The primary mobile application navigation uses a persistent bottom navigation dock.

| Tab | Icon | Destination | Purpose |
| :--- | :--- | :--- | :--- |
| **Home** | Home | Home Discovery | Vehicle discovery, recommendations, promotions |
| **Favorites** | Heart | Favorites | Saved vehicles and availability |
| **Messages** | Message | Fleet Support | Direct support and fleet communication |
| **Profile** | User | Account | Profile, settings, verification, preferences |

### 7.2 Core Navigation Flow

```text
Onboarding
    ↓
Auth Welcome
    ├── Sign In
    └── Sign Up
          ↓
     Email Verification
          ↓
     Location Picker
          ↓
     Home Discovery
       ├── Catalog
       │    ├── Filters
       │    └── Vehicle Detail
       │          ├── 360° Viewer
       │          ├── Color / Trim Customizer
       │          └── Pricing / Checkout
       │                └── Deposit / Credit Simulation
       ├── Favorites
       ├── Messages
       └── Profile
```

---

## 8. Motion & Micro-Interaction Guidelines

### 8.1 General Principles

- Use motion to communicate hierarchy, state changes, and spatial relationships.
- Keep interactions responsive and avoid unnecessary animation.
- Prefer short transitions between 150ms and 300ms for standard UI interactions.
- Use spring-like easing for interactive cards, sheets, and draggable controls.
- Respect reduced-motion accessibility preferences.

### 8.2 Recommended Interaction Patterns

| Interaction | Motion |
| :--- | :--- |
| Button press | Subtle scale-down (`0.98`) and return |
| Filter chip removal | Fade + horizontal collapse |
| Bottom sheet | Slide from bottom with spring easing |
| Modal | Fade backdrop + scale from `0.96` to `1` |
| Vehicle card | Slight elevation / scale on press |
| Wishlist toggle | Heart scale pulse |
| Tab selection | Sliding indicator / color transition |
| Carousel | Horizontal swipe with momentum |
| 360° viewer | Direct manipulation with inertial drag |
| Loading state | Skeleton shimmer or restrained pulse |

---

## 9. Tailwind CSS Design Tokens Configuration

The following tokens provide a Tailwind-oriented mapping of the RideEasy design system.

```js
/** @type {import('tailwindcss').Config} */
export default {
  theme: {
    extend: {
      colors: {
        brand: {
          DEFAULT: '#3B5BFD',
          hover: '#2342E2',
          soft: '#EEF2FF',
        },
        cyan: '#06B6D4',
        success: '#10B981',
        warning: '#F59E0B',
        danger: '#EF4444',
        midnight: '#0B0F19',
        surface: {
          light: '#F8FAFC',
          dark: '#111827',
          elevated: '#1F2937',
        },
      },
      borderRadius: {
        sm: '6px',
        md: '12px',
        lg: '16px',
        xl: '24px',
      },
      boxShadow: {
        card: '0 4px 20px -2px rgba(15, 23, 42, 0.06)',
        'card-dark': '0 8px 32px 0 rgba(0, 0, 0, 0.45)',
      },
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'Inter', 'Outfit', 'sans-serif'],
      },
    },
  },
  plugins: [],
};
```

---