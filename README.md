# Front polyfill bundle by CWS

## Configuration

**Create a YAML file like this one:**

```yaml
polyfill:
    arrfill:
        file: 'polyfill/array/fill.js'
        test: '![].fill'
        active: false
        support:
            chrome: 45
            firefox: 31
            ie: false
            edge: true
            opera: true
            safari: 8
            ios: 8
            android: 5
```

Save it in `/frontend/polyfill/config.yaml` for example.

## Route

Paste this in __routes.yaml__:

```
cws.polyfill:
    resource: '@CwsFrontPolyfillBundle/Resources/config/routing.xml'
```

## Use

You can call the route with the names of the polyfill in parameter, it will send you a response filled with the polyfills.

```html
<script src="{{ path('cws.front.js_polyfill') }}?picture&fetch"></script>
```
