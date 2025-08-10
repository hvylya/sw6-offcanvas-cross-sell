# Business Rules

## Minimal Off-Canvas

- When an item is added to the cart, show a minimal off-canvas with only the last added item.
- When the cart icon is clicked, show the default Shopware off-canvas (all items).

## Cross-Selling Product Selection

1. **Product custom field**: If set, use cross-selling group at this position/index.
2. **Plugin config**: If set and custom field is empty, use global cross-selling index.
3. **Fallback**: If neither is set or no group at those indices, use the lowest position available cross-selling group.
4. **No group**: If product has no cross-selling, show nothing.

## Cross-Selling Display

- Show selected cross-selling group below the added item in minimal off-canvas.
- Product box: image, name, price, add-to-cart button.
