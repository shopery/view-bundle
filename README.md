shopery/view-bundle
===================

Integrates `shopery/view` into your Symfony projects.

## Installation
You can install this library:

- Install via [composer](https://getcomposer.org): `composer require shopery/view-bundle`
- Use the [official Git repository](https://github.com/shopery/datetime): `git clone https://github.com/shopery/view-bundle`.

And add the bundle to your kernel as usual.

If you have any trouble, please refer to the [symfony docs](http://symfony.com/doc/current/cookbook/bundles/installation.html).

## Usage

This bundle defines a service named `view_factory` which can be injected as a dependency.

This class implements `Shopery\View\ViewFactory` and has a `createView` method.

Tag any service with `view_factory` to register it as a factory for a given object.

```yml
services:

    my_view_factory_for_products:
        class: ...
        arguments: ...
        tags:
            - { name: view_factory, class: Acme\Product }
```

So whenever you pass an `Acme\Product` to `view_factory::create_view`, your factory is run.
