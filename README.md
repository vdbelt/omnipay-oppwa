# Omnipay: Oppwa

**Oppwa driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/vdbelt/omnipay-oppwa.png?branch=master)](https://travis-ci.org/vdbelt/omnipay-oppwa)
[![Latest Stable Version](https://poser.pugx.org/vdbelt/omnipay-oppwa/version.png)](https://packagist.org/packages/vdbelt/omnipay-oppwa)
[![Total Downloads](https://poser.pugx.org/vdbelt/omnipay-oppwa/d/total.png)](https://packagist.org/packages/vdbelt/omnipay-oppwa)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements Oppwa support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply require omnipay/omnipay and vdbelt/omnipay-oppwa with Composer:

```
composer require omnipay/omnipay vdbelt/omnipay-oppwa
```


## Basic Usage

The following gateways are provided by this package:

* Oppwa

Available configuration options:

* userId (string, required)
* password (string, required)
* entityId (string, required)
* testMode (0/1, optional)

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/vdbelt/omnipay-oppwa/issues),
or better yet, fork the library and submit a pull request.