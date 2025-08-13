```text
[User] --(AJAX: add to cart)--> [Storefront Controller]
                                   |
                                   |---(Decorated by plugin)
                                         |
                                         |---(Decides off-canvas type: minimal or standard)
                                         |---(Gets last added cart item)
                                         |---(Render off-canvas with cross-sell placeholder)
                                               |
                                               |---[Storefront JS] -> call AJAX route with productId
                                               v
                                            [Server Controller]
                                               |---(Use SelectionService: custom field → config → fallback)
                                               |---(Render tiny partial or return 204)
                                               v
                                            [Storefront JS]
                                               |---(Replace placeholder or remove it)
```
