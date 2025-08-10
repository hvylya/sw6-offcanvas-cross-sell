```text
[User] --(AJAX: add to cart)--> [Storefront Controller]
                                   |
                                   |---(Decorated by plugin)
                                         |
                                         |---(Decides off-canvas type: minimal or standard)
                                         |---(Gets last added cart item)
                                         |---(Resolves cross-selling group)
                                               |
                                               |---(Reads product custom field)
                                               |---(Reads plugin config)
                                               |---(Fallback: first group or none)
                                               |
                                         |---(Renders minimal off-canvas template)
                                         |---(Twig: translations, minimal markup, accessibility)
```
