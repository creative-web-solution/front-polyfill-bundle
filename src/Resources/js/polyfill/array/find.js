/*! Polyfill from MDN */
Array.prototype.find||(Array.prototype.find=function(r){"use strict";if(null==this)throw new TypeError("Array.prototype.find called on null or undefined");if("function"!=typeof r)throw new TypeError("The argument must be a function");for(var t,n=Object(this),e=n.length>>>0,o=arguments[1],i=0;i<e;i++)if(t=n[i],r.call(o,t,i,n))return t});