<div align="center">

 <img src="https://img.shields.io/badge/Shopware-6.7%2B-0a92ff?logo=shopware" alt="Shopware 6.7+">
 <img src="https://img.shields.io/badge/PHP-8.2%2B-777bb4?logo=php" alt="PHP 8.2+">
<img src="https://img.shields.io/badge/Status-Skeleton-lightgrey" alt="Status: Skeleton">
 <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="MIT License"></a>

</div>

<h1 align="center">HvOffCanvasCrossSell</h1>

A minimal, clean Shopware 6 plugin skeleton to introduce an alternative “Add-to-Cart” off-canvas with room for
cross-selling.

> Status: Skeleton — functionality will be implemented step‑by‑step

---

## What this plugin will do

- Minimal off-canvas shown automatically after adding an item to the cart (only the last added item).
- Keep the default off-canvas when the cart icon is clicked (shows all items).
- Use the free space to display cross-selling products with a simple, compact product list.

## Planned features

- Part 1 — Minimal off‑canvas
    - Decorate the controller/route responsible for the add‑to‑cart off‑canvas
    - Render a minimal template focusing on the last added item
- Part 2 — Cross‑selling
    - Show a cross‑selling group in the minimal off‑canvas
    - Selection strategy:
        1) Product custom field (index/position of the cross‑selling group)
        2) Global plugin config (default index/position)
        3) Fallback to the first available cross‑selling group
        4) If none exist — hide cross‑selling

## Compatibility

- Shopware: 6.7+
- PHP: 8.2+

## Installation

- From release:
    1. Download HvOffCanvasCrossSell.zip from Releases.
       https://github.com/hvylya/sw6-offcanvas-cross-sell/releases
    2. In Shopware Admin: Extensions → My extensions → Upload → select the ZIP.
    3. Activate the plugin.

- For development:
    - Place the plugin in:
      ```
      custom/plugins/HvOffCanvasCrossSell
      composer install
      ```
    - Then run:
      ```
      bin/console plugin:refresh
      bin/console plugin:install --activate HvOffCanvasCrossSell
      ```

## Development

- Recommended local env: Dockware

### Scripts and tests

| Purpose            | Command              |
|--------------------|----------------------|
| Unit tests         | `composer test:unit` |
| Integration tests  | `composer test:int`  |
| Run all tests      | `composer test`      |
| Code style — check | `composer cs:check`  |
| Code style — fix   | `composer cs:fix`    |
| Static analysis    | `composer phpstan`   |

## Roadmap

- [ ] Decorate the off-canvas route/controller for add-to-cart flow
- [ ] Minimal off-canvas template (last added item only)
- [ ] Custom field for cross-selling index on product
- [ ] Global plugin configuration for default cross-selling index
- [ ] Cross-selling loader with selection logic and fallback
- [ ] Render compact product list (image, name, price, add-to-cart)

## Documentation links

- <a href="https://developer.shopware.com/docs/guides/plugins/plugins/">Plugins overview</a>
- <a href="https://developer.shopware.com/docs/guides/plugins/plugins/framework/store-api/override-existing-route.html#override-existing-route">
  Override existing route/controller</a>
- <a href="https://developer.shopware.com/docs/guides/plugins/plugins/storefront/customize-templates.html">Customize
  storefront templates</a>
- <a href="https://developer.shopware.com/docs/guides/plugins/plugins/framework/custom-field/">Custom fields</a>
- <a href="https://developer.shopware.com/docs/guides/plugins/plugins/plugin-fundamentals/">Plugin fundamentals (config,
  services)</a>
- <a href="https://developer.shopware.com/docs/guides/plugins/plugins/framework/data-handling/">Data handling (
  DB/Repositories)</a>
- <a href="https://docs.dockware.io/development/start-developing">Dockware (development)</a>

## License

[MIT](LICENSE)
