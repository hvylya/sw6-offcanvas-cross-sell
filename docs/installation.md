# Installation

## From Release

1. Download `HvOffCanvasCrossSell.zip` from [Releases](https://github.com/hvylya/sw6-offcanvas-cross-sell/releases).
2. In Shopware Admin: Extensions → My extensions → Upload → select the ZIP.
3. Activate the plugin.

## For Development

```bash
# Place plugin in:
custom/plugins/HvOffCanvasCrossSell

composer install

# Then run:
bin/console plugin:refresh
bin/console plugin:install --activate HvOffCanvasCrossSell
```
