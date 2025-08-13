<h1 align="center">HvOffcanvasCrossSell</h1>

<div align="center">

 <img src="https://img.shields.io/badge/Shopware-6.7%2B-0a92ff?logo=shopware" alt="Shopware 6.7+">
 <img src="https://img.shields.io/badge/PHP-8.2%2B-777bb4?logo=php" alt="PHP 8.2+">
 <img src="https://img.shields.io/badge/Status-MVP-yellow" alt="Status: MVP">
 <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="MIT License"></a>

</div>

**Minimal Shopware 6 plugin: alternative “Add-to-Cart” off-canvas with async cross-selling.**

> MVP — see [Roadmap](docs/roadmap.md) and [TODO](docs/todo.md).

---

## Overview

- Minimal off-canvas after **Add to cart** (shows only the last added item).
- Default off-canvas via cart icon remains unchanged.
- Cross-sell is loaded asynchronously into a placeholder inside the off-canvas.
- Uses existing Storefront markup/classes to stay close to core styling.

---

## How it works

See the full sequence diagram in [docs/flow.md](docs/flow.md).

---

## Compatibility

**Minimum requirements**
- Shopware 6.7
- PHP 8.2

**Tested with**
- Shopware 6.7.x
- PHP 8.2, 8.3

## Quick Links

- [Business rules](docs/business-rules.md)
- [Flow](docs/flow.md)
- [Installation](docs/installation.md)
- [Development](docs/development.md)
- [Caveats](docs/caveats.md)
- [TODO](docs/todo.md)
- [Roadmap](docs/roadmap.md)

---

## License

[MIT](LICENSE)
