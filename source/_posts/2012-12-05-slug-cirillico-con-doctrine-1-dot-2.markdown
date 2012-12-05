---
layout: post
title: "Slug Cirillico con Doctrine 1.2"
date: 2012-12-05 01:13
comments: true
categories: [doctrine, symfony1, i18n]
author: Dharma
---

**PROBLEMA**: in doctrine non esiste il supporto al cirillico quando si genera lo slug.

Classe: Doctrine\Inflector

Patch:

* 256: `public static function replaceCyrillic($text)`
* 279: `$text = self::replaceCyrillic($text)`

<!-- more -->
{% include_code Inflector.php doctrine-cirillico.php %}