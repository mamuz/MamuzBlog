# MamuzBlog [![License](https://poser.pugx.org/mamuz/mamuz-blog/license.svg)](https://packagist.org/packages/mamuz/mamuz-blog)

                | Badge
----------------|----
**Releases**    |[![Latest Stable Version](https://poser.pugx.org/mamuz/mamuz-blog/v/stable.svg)](https://packagist.org/packages/mamuz/mamuz-blog) [![Latest Unstable Version](https://poser.pugx.org/mamuz/mamuz-blog/v/unstable.svg)](https://packagist.org/packages/mamuz/mamuz-blog)
**Tests**       |[![Build Status](https://travis-ci.org/mamuz/MamuzBlog.svg?branch=master)](https://travis-ci.org/mamuz/MamuzBlog) [![Coverage Status](https://coveralls.io/repos/mamuz/MamuzBlog/badge.png?branch=master)](https://coveralls.io/r/mamuz/MamuzBlog?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mamuz/MamuzBlog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mamuz/MamuzBlog/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/8ed31e07-75b3-462c-a6ca-fce63b401eb8/mini.png)](https://insight.sensiolabs.com/projects/8ed31e07-75b3-462c-a6ca-fce63b401eb8) [![HHVM Status](http://hhvm.h4cc.de/badge/mamuz/mamuz-blog.png)](http://hhvm.h4cc.de/package/mamuz/mamuz-blog)
**Dependencies**|[![Dependency Status](https://www.versioneye.com/user/projects/538f788746c473980c00001d/badge.svg)](https://www.versioneye.com/user/projects/538f788746c473980c00001d)
**Downloads**   |[![Total Downloads](https://poser.pugx.org/mamuz/mamuz-blog/downloads.svg)](https://packagist.org/packages/mamuz/mamuz-blog)

## Features

- This module provides a blog based on ZF2 and Doctrine2.
- Posts are rendered by a markdown parser.
- Posts are taggable and searchable.
- Post listing is provided, same is true for tags.
- Hyperlinks to dedicated posts are secured by encrypted identities.
- Hyperlinks also ends with slugified post titles to meet SEO.
- Views are twitter-Bootstrap compatible.

Screenshot |
---------- |
![MamuzBlog](https://cloud.githubusercontent.com/assets/4173317/3939375/26d27e8a-24c6-11e4-8fd4-e4e1ced9652d.png)|

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
`MamuzBlog` to `modules` in `./config/application.config.php`:

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

```sh
./vendor/bin/doctrine-module orm:schema-tool:update
```

## Configuration

### Post identity encryption for hyperlinks

Encryption is supported by [`hashids/hashids`](https://github.com/ivanakimov/hashids.php)
and have to be configured by copy `./vendor/mamuz-blog/config/crypt.local.php.dist`
to `./config/autoload/crypt.local.php`. Be sure that this file is not under version control.
The only thing you have to do is changing `salt` value to any complex string.

### Default configuration

Besides configuration for identity encryption this module is usable out of the box,
but you can overwrite default configuration by adding a config file in `./config/autoload` directory.
For default configuration see
[`module.config.php`](https://github.com/mamuz/MamuzBlog/blob/master/config/module.config.php)

### Pagination

Listings of posts and tags includes a pagination feature, which seperates
views to a default range. Default range is overwritable by adding a config file in `./config/autoload` directory.

#### Posts

Post listing is provided by route `blogPublishedPosts` and default range is two items.

#### Tags

Tag listing is provided by route `blogTags` and default range is 10 items.

## Creating a new Post

Create an entity in `MamuzBlogPost` repository and tag it in related `MamuzBlogTag`.

*Admin Module to provide an interface for that is planned.*

## Workflow

If routing to a dedicated post found by published flag and encrypted identity is successful,
post content will be responsed in a new view model rendered as markdown,
otherwise it will set a 404 status code to the http response object.

## Terminology

- **Posts**: Published articles about any issues which are listed chronological in a blog.
- **Tag**: Category to group related posts to a specific issue.
