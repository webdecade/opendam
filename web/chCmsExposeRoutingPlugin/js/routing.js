/*!
 * routing.js
 * Copyright (c) 2011 Julien Muetton <julien_muetton@carpe-hora.com>
 * MIT Licensed
 */

jQuery.ExposeRouting = jQuery.ExposeRouting || {};

/**
 * define Routing class
 */
(function(Routing, $, undefined) {
	
  // now register our routing methods
  $.extend(Routing, (function() {

    var _routes = {},
        _defaults = {},
        _variables = {},
        _requirements = {},
        rquery = /\?/,
        rabsurl = /^\//,
        rescregexp = /[-[\]{}()*+?.,\\^$|#\s]/g,
        rdblslash = /\/\//g;

    /**
     * @api private
     * prepare a regexp part with several caracters/parts
     * having to be escaped.
     *
     *    regexify('a'); // returns 'a'
     *    regexify(['a', '.']); // returns 'a|\.'
     *    regexify(['a', '.'], '$'); // returns 'a|\.|$'
     *
     * @param {Array|string}  separators  a list of separators.
     * @param {String}        unescaped   a meta character to use in regexp.
     * @return {String}      the regexp part, ready to use.
     */
    function regexify(separators, unescaped) {
      var _i, _separators = [];
      // make sure separator is an array
      if (!$.isArray(separators)) {
        separators = [separators];
      }
      // escape every separator
      for (_i = 0; _i < separators.length; _i++) {
        _separators[_i] = separators[_i].replace(rescregexp, '\\$&');
      }
      // add unescaped caracters
      if (unescaped) { _separators.push(unescaped); }
      
      // return in a or
      if (_separators.length > 1) {return _separators.join('|')}
      else if(_separators.length) {return _separators[0];}
      return '';
    };

    /**
     * replace params in given url.
     * **WARNING:** used params are removed.
     *
     * @param {String} url the raw url.
     * @param {Object} params the params to replace.
     * @return {String} the treated url.
     * @api private
     */
    function replace_params(url, params) {
        var _i,
            _url = url,
            _separators = Routing.segmentSeparators,
            _prefixes = regexify(Routing.variablePrefix),
            _suffixes = regexify(Routing.variableSuffix),
            _prefix = '(' + regexify(_separators, '^') + ')' + _prefixes,
            _suffix = _suffixes + '(' + regexify(_separators, '$') + ')';

        for (_i in params) {
        	if (params.hasOwnProperty(_i)) {
	          var _r = new RegExp(_prefix + _i + _suffix, '');
	
	          if (_r.test(_url)) {
	            _url = _url.replace(_r, '$1' + params[_i] + '$2');
	            delete(params[_i]);
	          }
        	}
        }

        return _url;
    }

    function getKeys(o) {
    	var keys = [], key;
    	
    	for (key in o) {
    		if (o.hasOwnProperty(key)) {
    			keys.push(key);
    		}
    	}

    	return keys;
    }

    function in_array(array, val) {
    	for (var i = 0; i < array.length; i++) {
    		if (array[i] === val) {
    			return true;
    		}
    	}
    	
    	return false;
    }

    return {
      /**
       * default routing parameters for every routes.
       *
       * @api public
       */
      defaults: {},
      /**
       * route parameter suffix.
       *
       * @type {String}
       * @api public
       */
      variableSuffix: '',
      /**
       * route parameter prefix.
       *
       * @type {String}
       * @api public
       */
      variablePrefix: ':',
      /**
       * route url separator list.
       *
       * @type {String|Array}
       * @api public
       */
      segmentSeparators: ['/', '.'],
      /**
       * route url prefix to use.
       *
       * @type {String}
       * @api public
       */
      prefix: '',
      /**
       * the cross site request forgery defaults
       *
       * @param {Object}
       * @api public
       */
      csrf: {},
      /**
       * generate a route url from route id and params.
       *
       * @param {String}  route_id  the id of route to generate url for.
       * @param {Objects} params    the parameters to append to the route.
       * @return {String} generated url.
       * @api public
       */
      generate: function(route_id, params) {
        var _route = Routing.get(route_id),
            _params = $.extend({}, _defaults[route_id] || {}, params || {}),
            _queryString,
            _url = _route;

        if (!_url) {
          throw new Error('No matching route for ' + route_id);
        }

        var variables = getKeys(_variables[route_id]);
        var requirements = _requirements[route_id];

        // test les paramètres oubliés
        var paramKeys = getKeys(_params);
        var missingParams = [];

        for (var i = 0; i < variables.length; i++) {
        	var variable = variables[i];
        	
        	if (!in_array(paramKeys, variable)) {
        		missingParams.push(variable);
        	}
        }

        if (missingParams.length) {
        	throw new Error("missing parameters: " + missingParams.toString());
        }

        // replace with params then defaults
        _url = replace_params(_url, _params);
        _url = replace_params(_url, $.extend({}, Routing.defaults || {}));

        // remaining params as query string
        _queryString = $.param(_params);

        if (_queryString.length) {
          _url += (rquery.test(_url) ? '&' : '?') + _queryString;
        }

        _url = (rabsurl.test(_url) ? '' : '/') + _url;
        _url = Routing.prefix + _url;
        _url = (rabsurl.test(_url) ? '' : '/') + _url;

        return _url.replace(rdblslash, '/');
      },
      /**
       * connect a route.
       *
       * @param {String} id       the route id.
       * @param {String} pattern  the url pattern.
       * @return {Object} Routing.
       * @api public
       */
      connect: function(id, pattern, defaults, variables, requirements) {
        _routes[id] = pattern;
        _defaults[id] = defaults || {};
        _variables[id] = variables;
        _requirements[id] = requirements;

        return Routing;
      },
      /**
       * retrieve a route by it's id.
       *
       * @param {String} route_id the route id to retrieve.
       * @return {String} requested route.
       * @api public
       */
      get: function(route_id) {
        return _routes[route_id] || undefined;
      },
      /**
       * determines wether a route is registered or not.
       *
       * @param {String} route_id the route id to retrieve.
       * @return {Boolean} wether the route is registered or not.
       * @api public
       */
      has: function(route_id) {
        return (_routes[route_id] ? true : false);
      },
      /**
       * clears all routes
       *
       * @return {Object} Routing.
       * @api public
       */
      flush: function() {
        _routes = {};
        _defaults = {};
        return Routing;
      }
    }; // end of return
  })());
})($.ExposeRouting, jQuery);
