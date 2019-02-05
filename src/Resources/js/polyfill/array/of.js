/*! Polyfill from MDN */
Array.of||(Array.of=function(){return Array.prototype.slice.call(arguments)});