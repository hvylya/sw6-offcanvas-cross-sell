# HvOffCanvasCrossSell

A minimal, clean Shopware 6 plugin skeleton to introduce an alternative “Add-to-Cart” off-canvas with room for cross-selling.

> Status: Skeleton (structure only). Functionality will be implemented in steps.

## What this plugin will do
- Minimal off-canvas shown automatically after adding an item to the cart (only the last added item).
- Keep the default off-canvas when the cart icon is clicked (shows all items).
- Use the free space to display cross-selling products with a simple, compact product list.

## Planned features
- Part 1 — Minimal off-canvas
    - Decorate the controller/route responsible for the off-canvas shown after add-to-cart.
    - Render a minimal template focusing on the last added item.

- Part 2 — Cross-selling
    - Show a cross-selling group in the minimal off-canvas.
    - Selection strategy:
        1) Product custom field (index/position of the cross-selling group)
        2) Global plugin config (default index/position)
        3) Fallback to the first available cross-selling group
        4) If none exist, don’t show cross-selling

## Compatibility
- Shopware: 6.7+
- PHP: 8.2+

## Installation
- From release (recommended):
    1. Download HvOffCanvasCrossSell.zip from Releases.
       https://github.com/hvylya/sw6-offcanvas-cross-sell/releases
    2. In Shopware Admin: Extensions → My extensions → Upload → select the ZIP.
    3. Activate the plugin.

- For development:
    - Place the plugin in:
      ```
      custom/plugins/HvOffCanvasCrossSell
      ```
    - Then run:
      ```
      bin/console plugin:refresh
      bin/console plugin:install --activate HvOffCanvasCrossSell
      ```

## Development setup (recommended)
- Dockware (Shopware local environment):
  https://docs.dockware.io/development/start-developing

## Tests
Run via Composer:

- **Unit:** `composer test:unit`
- **Integration:** `composer test:int`
- **All tests:** `composer test`

## Roadmap
- [ ] Decorate the off-canvas route/controller for add-to-cart flow
- [ ] Minimal off-canvas template (last added item only)
- [ ] Custom field for cross-selling index on product
- [ ] Global plugin configuration for default cross-selling index
- [ ] Cross-selling loader with selection logic and fallback
- [ ] Render compact product list (image, name, price, add-to-cart)

## Documentation links
- Plugins overview:
  https://developer.shopware.com/docs/guides/plugins/plugins/
- Override existing route/controller:
  https://developer.shopware.com/docs/guides/plugins/plugins/framework/store-api/override-existing-route.html#override-existing-route
- Customize storefront templates:
  https://developer.shopware.com/docs/guides/plugins/plugins/storefront/customize-templates.html
- Custom fields:
  https://developer.shopware.com/docs/guides/plugins/plugins/framework/custom-field/
- Plugin fundamentals (config, services):
  https://developer.shopware.com/docs/guides/plugins/plugins/plugin-fundamentals/
- Data handling (DB/Repositories):
  https://developer.shopware.com/docs/guides/plugins/plugins/framework/data-handling/

## Naming and structure
- Namespace: `Hvylya\OffCanvasCrossSell`
- Plugin class: `Hvylya\OffCanvasCrossSell\HvOffCanvasCrossSell`
- Composer type: `shopware-platform-plugin`

## License
[MIT](LICENSE)
