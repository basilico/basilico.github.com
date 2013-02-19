---
layout: post
title: "Grabbing ctrl+input key with jQuery"
date: 2013-02-19 12:00
comments: true
categories: [jquery, keyboard, user input]
author: Dharma
---

Snippet usage

``` javascript
$.ctrl('S', function() {
  //save
});
```

Snippet source code

{% codeblock plugin - jquery.ctrl.js %}
$.ctrl = function(key, callback, args) {
  $(document).keydown(function(e) {
    if(!args) args=[]; // IE barks when args is null
    if(e.keyCode == key.charCodeAt(0) && e.ctrlKey) {
      callback.apply(this, args);
      return false;
    }
  });
};
{% endcodeblock %}  