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

## Services

Add this line in the import section of your __services.yaml__

```
imports:
    - { resource: '@CwsFrontPolyfillBundle/Resources/config/services.xml' }
```

## Javascript support tests

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


Here a full example to create an url like 'js/pf1-pf2-pf3.js':

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
            polyfillContentUrl = `js/${ neededPolyfill.join( '-' ) }.js`;
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


## Polyfill loading

Use the array of test to create an url to load the polyfill content.

There is 2 ways to load the polyfills:


### 1/ The polyfill names are contained in the filename itself and separated by `-`

This is the **recommended way** to do it because this way allow you **to create a real file**. Handy with Symfony as if the file exists, **it will not be rerendered**.

```
<script src="js/polyfill-domch-eachnl-picture.js"></script>
```

Inside the Twig file that render the response for `polyfill-domch-eachnl-picture.js` (and save the file if you want):

```
{{ get_front_polyfill_content()|raw }}

// Other stuff in JS
```

The route to this file **MUST** contains a placeholder. By default its name is `polyfill_list`. So, in our example `/js/polyfill-domch-eachnl-picture.js`, the route must be `/js/polyfill-{polyfill_list}.js`

You can configure the placeholder name in the `parameters.yaml`:

```
parameters:
    cws.polyfill.route_placeholder: polyfill_list
```


**When there is a clear cache action, it is recommended to delete those generated files as well.**


### 2/ The polyfill names are contained in the query string and separated by `&`

```
<script src="js/polyfill.js?domch&eachnl&picture"></script>
```

Tou have to specify it using the parameter `query` of the `get_front_polyfill_content` TWIG function.

Inside the Twig file that render the response for `polyfill.js`:

```
{{ get_front_polyfill_content('query')|raw }}

// Other stuff in JS
```
