# Front polyfill bundle by CWS

## Configuration

**Create a YAML file:**

You can copy the `Resources/sample/config.yaml` in your app (in `/frontend/polyfill/config.yaml` for example).

You can configure this path by overriding this parameters in your app:

```
parameters:
    cws.polyfill.config_path: /frontend/polyfill/config.yaml
```

Activate the polyfills you need by setting `active: true` in this config file.

## Route

Paste this in __routes.yaml__:

```
cws.polyfill:
    resource: '@CwsFrontPolyfillBundle/Resources/config/routing.xml'
```

## Services

Add this line in the import section of your __services.yaml__

```
imports:
    - { resource: '@CwsFrontPolyfillBundle/Resources/config/services.xml' }
```

## Use

### Javascript support tests

Get the active polyfill list:

**With an object list**

```php
{% set polyfillList = get_front_polyfill_list() %}

<script>
var myPolyfillArray = [
{%- for name, polyfill in polyfillList.list -%}
    {
        "test": {{ polyfill.test|raw }},
        "name": "{{ name|raw }}"
    }{{ loop.last ? '' : ',' }}
{%- endfor -%}
];
</script>
```

**With a JS array-like string**

```js
var myPolyfillArray = {{ get_front_polyfill_list('js') }};
```

This will give :

```js
var myPolyfillArray = [
    {
        "test": test1,
        "name": "test1"
    },{
        "test": test2,
        "name": "test2"
    },
    ...
];
```

You can change the name of the properties:

```js
var myPolyfillArray = {{ get_front_polyfill_list('js', 'a', 'b') }};
```

Results in :

```js
var myPolyfillArray = [{
        "b": test1,
        "a": "test1"
    },{
        "b": test2,
        "a": "test2"
    },
    ...
];
```

**Polyfill content**

Then use it to create an url to load the polyfill content.

Here an example:

```php
{% set polyfillArrayString = get_front_polyfill_list('js') %}

<script>
    let polyfillContentUrl;

    {%- if polyfillArrayString is defined and polyfillArrayString|length > 2 -%}
        let neededPolyfill = [];

        {{ polyfillArrayString }}
            .forEach( function( polyfill ) {
                if (typeof polyfill.test === 'function' && polyfill.test() ||
                    typeof polyfill.test !== 'function' && polyfill.test) {
                    neededPolyfill.push( polyfill.name );
                }
            });

        if ( neededPolyfill.length ) {
            polyfillContentUrl = '{{ asset(path('cws.front.js_polyfill')) }}?' + neededPolyfill.join( '&' );
        }
    {%- endif -%}

    [
        polyfillContentUrl,
        '1.js',
        '2.js'
    ].forEach( function( src ) {
        if ( !src ) {
            return;
        }
        var script = document.createElement('script');
        script.src = src;
        script.async = false;
        document.head.appendChild(script);
    } );
</script>
```