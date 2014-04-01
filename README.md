Apigility.org web site
======================

(C) Copyright 2013-2014 Zend Technologies Ltd.

Creating a new release
----------------------

Use the `Makefile`:

```console
$ make all VERSION=<version string>
```

This will update:

- `config/autoload/global.php`
- `data/releases.json`

Spot-check those, commit, and push.

Updating 3rd Party UI Dependencies
----------------------------------

We use [Bower](http://bower.io) for managing 3rd party UI dependencies. If you
need to update or add dependencies, make sure you have installed Bower first.

To add a dependency:

```console
$ bower install <name> -S
```

Once installed and integrated, add the new directory under
`public/bower_components` and the `bower.json` file, and commit.

To update dependencies:

```console
$ bower update <name>
```

As with installing dependencies, after testing the updated version, add the
updated directory under `public/bower_components` and the `bower.json` file, and
commit.

Documentation
-------------

Documentation is written in a separate repository,
[apigility-documentation](https://github.com/zfcampus/apigility-documentation),
and the apigility.org website consumes that documentation. To update the
documentation to display on the website, run:

```console
$ composer update
```

and commit the `composer.lock` when done.

### Rendering Documentation

Since the documentation is written in GitHub Flavored Markdown, we use "fenced
code blocks," which provide us with the ability to specify the programming
language used in the code block in order to provide syntax highlighting.

Unfortunately, no Markdown libraries we found for PHP would perform the syntax
highlighting beyond a CSS class referring to the language.

This website solves the problem by identifying each fenced code block and the
syntax specified for it, and passing it to [pygmentize](http://pygments.org/).
This means the `pygmentize` executable needs to be available on the system
running the website.

If it is, and it is available at `/usr/bin/pygmentize`, you do not need to do
anything. If it is on any other path, add the following to your
`config/autoload/local.php` file (create it if it hasn't been):

```php
'pygmentize' => 'path/to/pygmentize'
```
