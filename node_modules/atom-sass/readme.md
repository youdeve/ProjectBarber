# Atom SASS

An extremely simple set of SASS components to help build out the basic layout
of a given site. Ignores style as much as possible, focusing on layout, and 
built for responsive design.

---

  - [Installation](#installation)
    - [Getting the SASS Files](#getting-the-sass-files)
    - [(Optional) Update SASS includePaths for Easy Imports](#optional-update-sass-includepaths-for-easy-imports)
  - [Usage](#usage)
  - [Components](#components)
    - [Container](#container)
    - [Icon Unordered List](#icon-unordered-list)
    - [Split](#split)
    - [Split List](#split-list)
    - [Uneven Split](#uneven-split)

## Installation

### Getting the SASS Files

To get the SASS files, just include `atom-sass` in your NPM package:

```
npm i --save-dev atom-sass
```

### (Optional) Update SASS includePaths for Easy Imports

You can optionally also update your SASS `includePaths` configuration to
make `@import` statements simpler. Most of the documentation below assumes that
you have completed this step, for brevity.

To do so, just add `node_modules/` to your `includePaths` configuration. For
example:

```Javascript
const sassConfig = {
    includePaths: [
        "node_modules/"
    ]
};
```

Which results in:

**Before:**

```SCSS
@import "path/to/node_modules/atom-sass/sass/split"; 
```

**After:**

```SCSS
@import "atom-sass/sass/split";
```

## Usage

Each component is separated into its own SASS file, and each component can have
any number of configuration variables based on the components' function. To 
include a component, simply add `@import "atom-sass/sass/[component name]"` to 
the appropriate SASS file. See the [Components](#components) section for a list 
of components, their names, and any configuration variables they have.

## Components

See below for a list of components. 

### Container

**Name:** `container`<br />
**Import:** `@import "atom-sass/sass/container";`<br />
**Classes:** `.container`

Any element with this class will automatically fill the entire width of the
screen, unless the screen width is greater than `$atom_container_max`
(default: `1151px`). If the screen width is greater than that value, then the 
contents of the element will max out at that width, and margin will be evenly 
applied to the left and right sides to center the content.

In addition, a gutter (applied via padding) is added to the left and right side
for mobile devices, and screens smaller than `$atom_container_max`.

**Example:**

```HTML
<div class="container">
    <!-- Your content here -->
</div>
```

#### Variables

##### $atom_container_max

**Type:** Unit<br />
**Default:** `1151px`

The maximum width of the content in the container.

##### $atom_container_gutter

**Type:** Unit<br />
**Default:** `15px`

The amount of padding to add to the left and right of the container as a gutter
for mobile devices.

### Icon Unordered List

**Name:** `icon-ul`<br />
**Import:** `@import "atom-sass/sass/icon-ul";`<br />
**Classes:** `.icon-ul`

Provides a way of replacing the default unorder lists' bullet icons with any 
other icon. Just apply the `icon-ul` class to any `<ul>` element to change its
icons.

**Example:**

```HTML
<ul class="icon-ul">
    <!-- list items here -->
</ul>
```

#### Variables

##### $atom_icon_ul_icon_font

**Type:** Font Family<br />
**Default:** `FontAwesome`

The font family of the font to use to render the icon.

##### $atom_icon_ul_icon

**Type:** String<br />
**Default:** `'\f00c'` (`fa-check` in FontAwesome)

The string holding the character code of the character in the font to render 
in the place of the bullet points.

##### $atom_icon_ul_color

**Type:** Color<br />
**Default:** `#000`

The color of the icon.

### Split

**Name:** `split`<br />
**Import:** `@import "atom-sass/sass/split";`<br />
**Classes:** `.split .split-item`

When the `split` class is applied to an element, it will evenly split the 
horizontal space within it amoung all of its children that have the
`split-item` class on them.

**Example:**

```HTML
<div class="split">
    <div class="split-item">
        Column 1
    </div>
    <div class="split-item">
        Column 2
    </div>
    <div class="split-item">
        Column 3
    </div>
</div>
```

### Split List

**Name:** `split-list`<br />
**Import:** `@import "atom-sass/sass/split-list";`<br />
**Classes:** `.split-list .split-item .split-*`

Any element with the `split-list` class applied to it will make all elements
with `split-item` beneath it take up an even amount of columns, and wrap down
the page.

The amount of horizontal space taken up by a given `split-item` is determined
by the `split-*` class applied to the parent `split-list` element, where the 
`*` represents the split number. By default, `split-2`, `split-3`, and `split-4`
are available, but these are configurable.

The split number determines how much space the items take up by computing 
`1 / [split number]`, and multiplying that by the total amount of horizontal 
space available.

So, for example, `split-3` means that all `split-item` elements would take up 
one third, or `33.3%` of the available horizontal space.

**Example:**

```HTML
<div class="split-list split-2">
    <div class="split-item">
        Column 1 Row 1
    </div>
    <div class="split-item">
        Column 2 Row 1
    </div>
    <div class="split-item">
        Column 1 Row 2
    </div>
    <div class="split-item">
        Column 2 Row 2
    </div>
</div>
```

#### Variables

##### $atom_split_list_options

**Type:** Array<Integer><br />
**Default:** `(2, 3, 4)`

List of integers representing each split number available for use.

### Uneven Split

**Name:** `uneven-split`<br />
**Import:** `@import "atom-sass/sass/uneven-split";`<br />
**Classes:** `.uneven-split .split-item .split-match .split-fill .split-*`

When the `uneven-split` class is applied to an element, it will split the 
horizontal space within it among all of the elements beneath it that have the 
`split-item` class on them.

The precise amount of space each `split-item` element is given is based on the 
split class applied to it.

`split-match` causes the split item to only take up as much space as it needs 
based on its contents, and to neither grow nor shrink.

`split-fill` causes the split item to fill all of the remaining space. If there
are multiple `split-item`s with the `split-fill` class on them, then they will
all get an even distribution of the remaining space after all other splits.

`split-*` actually represents an unknown number of additional classes, where 
the `*` is a wildcard where a number would normally be. By default, the 
`uneven-split` module comes with `split-1 split-2 split-3 split-4` as classes,
however, these are configurable. 

The number in the `split-*` class reprsents how many columns a given
`split-item` with that class takes up. So, for example, a `split-item` with the
class `split-2` would span two columns worth of space horizontally. The amount 
of columns is determined by the `$atom_uneven_split_split_basis` variable, and
defaults to `12`.

**Example:**

```HTML
<div class="uneven-split">
    <div class="split-match">
        I'm exactly the size I need to display this text.
    </div>
    <div class="split-fill">
        I'm going to take up any remaining space not taken up by other splits.
    </div>
    <div class="split-2">
        I'm going to span 2 columns, which by default represents ~16% of the 
        horizontal space.
    </div>
    <div class="split-4">
        I'm going to span 4 columns, which by default represents ~33.3% of the
        horizontal space.
    </div>
</div>
```

#### Variables

##### $atom_uneven_split_split_match

**Type:** Boolean<br />
**Default:** `true`

If true, includes the `split-match` class. Can be set to false to exclude it to
reduce output CSS size and remove unused classes.

##### $atom_uneven_split_split_fill

**Type:** Boolean<br />
**Default:** `true`

If true, includes the `split-fill` class. Can be set to false to exclude it to
reduce output CSS size and remove unused classes.

##### $atom_uneven_split_split_basis

**Type:** Integer<br />
**Default:** `12`

Determines the amount of columns that will be available for a given split. See
the main documentation for this module for more information on the columns.

##### $atom_uneven_split_split_options

**Type:** Array<Integer><br />
**Default:** `(1, 2, 3, 4)`

Represents a list of all available classes for the `split-*` classes. So, for
example, if you changed this to `(1, 2)` then only `split-1` and `split-2` would
be available.

The rendered size of each split for these numbers is determined by the amount
of columns.