Apigility.org web site
======================

(C) Copyright 2013-2014 Zend Technologies Ltd.

Creating a new release
----------------------

Use the `Makefile`:

```sh
make all VERSION=<version string>
```

This will update:

- `config/autoload/global.php`
- `data/releases.json`

Spot-check those, commit, and push.
