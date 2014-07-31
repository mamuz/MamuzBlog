# MamuzBlog

[![Build Status](https://travis-ci.org/mamuz/MamuzBlog.svg?branch=master)](https://travis-ci.org/mamuz/MamuzBlog)
[![Dependency Status](https://www.versioneye.com/user/projects/538f788746c473980c00001d/badge.svg)](https://www.versioneye.com/user/projects/538f788746c473980c00001d)
[![Coverage Status](https://coveralls.io/repos/mamuz/MamuzBlog/badge.png?branch=master)](https://coveralls.io/r/mamuz/MamuzBlog?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mamuz/MamuzBlog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mamuz/MamuzBlog/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8ed31e07-75b3-462c-a6ca-fce63b401eb8/mini.png)](https://insight.sensiolabs.com/projects/8ed31e07-75b3-462c-a6ca-fce63b401eb8)

[![Latest Stable Version](https://poser.pugx.org/mamuz/mamuz-blog/v/stable.svg)](https://packagist.org/packages/mamuz/mamuz-blog)
[![Total Downloads](https://poser.pugx.org/mamuz/mamuz-blog/downloads.svg)](https://packagist.org/packages/mamuz/mamuz-blog)
[![Latest Unstable Version](https://poser.pugx.org/mamuz/mamuz-blog/v/unstable.svg)](https://packagist.org/packages/mamuz/mamuz-blog)
[![License](https://poser.pugx.org/mamuz/mamuz-blog/license.svg)](https://packagist.org/packages/mamuz/mamuz-blog)

## Domain

 - This module provides a simple read only blog feature.
 - Posts are persisted in a database.
 - Markdown is supported for post content.
 - Post identities are encrypted in frontend.
 - Posts are searchable by tag, title or encrypted identity.
 - twitter-Bootstrap 2/3 compatible

## Installation

The recommended way to install
[`mamuz/mamuz-blog`](https://packagist.org/packages/mamuz/mamuz-blog) is through
[composer](http://getcomposer.org/) by adding dependency to your `composer.json`:

```json
{
    "require": {
        "mamuz/mamuz-blog": "1.*"
    }
}
```

After that run `composer update` and enable this module for ZF2 by adding
`MamuzBlog` to the `modules` key in `./config/application.config.php`:

```php
// ...
    'modules' => array(
        'MamuzBlog',
    ),
```

This module is based on [`DoctrineORMModule`](https://github.com/doctrine/DoctrineORMModule)
and be sure that you have already [configured database connection](https://github.com/doctrine/DoctrineORMModule).

Create database tables with command line tool provided by
[`DoctrineORMModule`](https://github.com/doctrine/DoctrineORMModule):

### Dump the sql to fire it manually
```sh
./vendor/bin/doctrine-module orm:schema-tool:update --dump-sql
```

### Fire sql automaticly

```sh
./vendor/bin/doctrine-module orm:schema-tool:update --force
```

## Configuration

### Post identity encryption

This is supported by [`hashids/hashids`](https://github.com/ivanakimov/hashids.php)
and wrapped by an own adapter. This adapter have to be configured by copy `./vendor/mamuz-blog/config/crypt.local.php.dist`
to `./config/autoload/crypt.local.php` and be sure that file is not under version control.
The only one you have to do is to change `salt` value.
If you change `minLength` value, you have to consider the route `id` parameter
constraint for route `blogActivePost` in default configuration.

### Default configuration

Excepts encryption configuration this module is already configured out of the box, but you can overwrite it by
adding a config file in `./config/autoload` directory.
For default configuration see
[`module.config.php`](https://github.com/mamuz/MamuzBlog/blob/master/config/module.config.php)

### Pagination Range

#### Posts

Listing of posts is provided by route `blogActivePosts`. List includes a pagination feature, which seperates
views to a default range of 2 items. Default range is overwritable by adding a config file in `./config/autoload` directory.
See `mamuz-blog/pagination/range/post` key in
[`module.config.php`](https://github.com/mamuz/MamuzBlog/blob/master/config/module.config.php).

#### Tags

Listing of tags is provided by route `blogTags`. List includes a pagination feature, which seperates
views to a default range of 10 items. Default range is overwritable by adding a config file in `./config/autoload` directory.
See `mamuz-blog/pagination/range/tag` key in
[`module.config.php`](https://github.com/mamuz/MamuzBlog/blob/master/config/module.config.php).

## Creating new Posts

Create new entities in `MamuzBlogPost` database table and tag it in related database table `MamuzBlogTag`.
Content will be rendered with a markdown parser.

## Workflow

If routing is successful to a post entity or to post entities found by active flag,
post content will be responsed in a new view model. Otherwise in case of fetching one entity which doesnt exist
it will set a 404 status code to http response object.
