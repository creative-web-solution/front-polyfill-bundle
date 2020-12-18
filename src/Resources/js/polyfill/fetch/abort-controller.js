/*! AbortController polyfill 1.5.0 - https://github.com/mo/abortcontroller-polyfill */
!function(t){"function"==typeof define&&define.amd?define(t):t()}(function(){"use strict";function t(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}function e(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}function n(t,n,r){return n&&e(t.prototype,n),r&&e(t,r),t}function r(t){return(r=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function o(t,e){return(o=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}function i(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}function c(t){var e=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],function(){})),!0}catch(t){return!1}}();return function(){var n,o,c=r(t);if(e){var u=r(this).constructor;n=Reflect.construct(c,arguments,u)}else n=c.apply(this,arguments);return!(o=n)||"object"!=typeof o&&"function"!=typeof o?i(this):o}}function u(t,e,n){return(u="undefined"!=typeof Reflect&&Reflect.get?Reflect.get:function(t,e,n){var o=function(t,e){for(;!Object.prototype.hasOwnProperty.call(t,e)&&null!==(t=r(t)););return t}(t,e);if(o){var i=Object.getOwnPropertyDescriptor(o,e);return i.get?i.get.call(n):i.value}})(t,e,n||t)}var l=function(){function e(){t(this,e),Object.defineProperty(this,"listeners",{value:{},writable:!0,configurable:!0})}return n(e,[{key:"addEventListener",value:function(t,e){t in this.listeners||(this.listeners[t]=[]),this.listeners[t].push(e)}},{key:"removeEventListener",value:function(t,e){if(t in this.listeners)for(var n=this.listeners[t],r=0,o=n.length;r<o;r++)if(n[r]===e)return void n.splice(r,1)}},{key:"dispatchEvent",value:function(t){var e=this;if(t.type in this.listeners){for(var n=function(n){setTimeout(function(){return n.call(e,t)})},r=this.listeners[t.type],o=0,i=r.length;o<i;o++)n(r[o]);return!t.defaultPrevented}}}]),e}(),f=function(e){!function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&o(t,e)}(a,l);var f=c(a);function a(){var e;return t(this,a),(e=f.call(this)).listeners||l.call(i(e)),Object.defineProperty(i(e),"aborted",{value:!1,writable:!0,configurable:!0}),Object.defineProperty(i(e),"onabort",{value:null,writable:!0,configurable:!0}),e}return n(a,[{key:"toString",value:function(){return"[object AbortSignal]"}},{key:"dispatchEvent",value:function(t){"abort"===t.type&&(this.aborted=!0,"function"==typeof this.onabort&&this.onabort.call(this,t)),u(r(a.prototype),"dispatchEvent",this).call(this,t)}}]),a}(),a=function(){function e(){t(this,e),Object.defineProperty(this,"signal",{value:new f,writable:!0,configurable:!0})}return n(e,[{key:"abort",value:function(){var t;try{t=new Event("abort")}catch(e){"undefined"!=typeof document?document.createEvent?(t=document.createEvent("Event")).initEvent("abort",!1,!1):(t=document.createEventObject()).type="abort":t={type:"abort",bubbles:!1,cancelable:!1}}this.signal.dispatchEvent(t)}},{key:"toString",value:function(){return"[object AbortController]"}}]),e}();"undefined"!=typeof Symbol&&Symbol.toStringTag&&(a.prototype[Symbol.toStringTag]="AbortController",f.prototype[Symbol.toStringTag]="AbortSignal"),function(t){(function(t){return t.__FORCE_INSTALL_ABORTCONTROLLER_POLYFILL?(console.log("__FORCE_INSTALL_ABORTCONTROLLER_POLYFILL=true is set, will force install polyfill"),!0):"function"==typeof t.Request&&!t.Request.prototype.hasOwnProperty("signal")||!t.AbortController})(t)&&(t.AbortController=a,t.AbortSignal=f)}("undefined"!=typeof self?self:global)});