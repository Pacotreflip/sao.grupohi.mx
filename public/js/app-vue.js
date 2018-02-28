(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
!function(e,n){"object"==typeof exports&&"undefined"!=typeof module?module.exports=n():"function"==typeof define&&define.amd?define(n):(e.__locale__es=e.__locale__es||{},e.__locale__es.js=n())}(this,function(){"use strict";var e={after:function(e,n){return"El campo "+e+" debe ser posterior a "+n[0]+"."},alpha_dash:function(e){return"El campo "+e+" solo debe contener letras, números y guiones."},alpha_num:function(e){return"El campo "+e+" solo debe contener letras y números."},alpha_spaces:function(e){return"El campo "+e+" solo debe contener letras y espacios."},alpha:function(e){return"El campo "+e+" solo debe contener letras."},before:function(e,n){return"El campo "+e+" debe ser anterior a "+n[0]+"."},between:function(e,n){return"El campo "+e+" debe estar entre "+n[0]+" y "+n[1]+"."},confirmed:function(e,n){return"El campo "+e+" no coincide con "+n[0]+"."},credit_card:function(e,n){n[0];return"El campo "+e+" es inválido."},date_between:function(e,n){return"El campo "+e+" debe estar entre "+n[0]+" y "+n[1]+"."},date_format:function(e,n){return"El campo "+e+" debe tener formato formato "+n[0]+"."},decimal:function(e,n){void 0===n&&(n=["*"]);var o=n[0];return"El campo "+e+" debe ser númerico y contener "+("*"===o?"":o)+" puntos decimales."},digits:function(e,n){return"El campo "+e+" debe ser númerico y contener exactamente "+n[0]+" dígitos."},dimensions:function(e,n){return"El campo "+e+" debe ser de "+n[0]+" pixeles por "+n[1]+" pixeles."},email:function(e){return"El campo "+e+" debe ser un correo electrónico válido."},ext:function(e){return"El campo "+e+" debe ser un archivo válido."},image:function(e){return"El campo "+e+" debe ser una imagen."},in:function(e){return"El campo "+e+" debe ser un valor válido."},ip:function(e){return"El campo "+e+" debe ser una dirección ip válida."},max:function(e,n){return"El campo "+e+" no debe ser mayor a "+n[0]+" caracteres."},max_value:function(e,n){return"El campo "+e+" debe de ser "+n[0]+" o menor."},mimes:function(e){return"El campo "+e+" debe ser un tipo de archivo válido."},min:function(e,n){return"El campo "+e+" debe tener al menos "+n[0]+" caracteres."},min_value:function(e,n){return"El campo "+e+" debe ser "+n[0]+" o superior."},not_in:function(e){return"El campo "+e+" debe ser un valor válido."},numeric:function(e){return"El campo "+e+" debe contener solo caracteres númericos."},regex:function(e){return"El formato del campo "+e+" no es válido."},required:function(e){return"El campo "+e+" es obligatorio."},size:function(e,n){return"El campo "+e+" debe ser menor a "+n[0]+" KB."},url:function(e){return"El campo "+e+" no es una URL válida."}},n={name:"es",messages:e,attributes:{}};return"undefined"!=typeof VeeValidate&&VeeValidate&&(VeeValidate.Validator,!0)&&VeeValidate.Validator.addLocale(n),n});
},{}],2:[function(require,module,exports){
/**
 * vee-validate v2.0.0-rc.5
 * (c) 2017 Abdelrahman Awad
 * @license MIT
 */
(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(global.VeeValidate = factory());
}(this, (function () { 'use strict';

/**
 * Some Alpha Regex helpers.
 * https://github.com/chriso/validator.js/blob/master/src/lib/alpha.js
 */

var alpha$1 = {
  en: /^[A-Z]*$/i,
  cs: /^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ]*$/i,
  da: /^[A-ZÆØÅ]*$/i,
  de: /^[A-ZÄÖÜß]*$/i,
  es: /^[A-ZÁÉÍÑÓÚÜ]*$/i,
  fr: /^[A-ZÀÂÆÇÉÈÊËÏÎÔŒÙÛÜŸ]*$/i,
  nl: /^[A-ZÉËÏÓÖÜ]*$/i,
  hu: /^[A-ZÁÉÍÓÖŐÚÜŰ]*$/i,
  pl: /^[A-ZĄĆĘŚŁŃÓŻŹ]*$/i,
  pt: /^[A-ZÃÁÀÂÇÉÊÍÕÓÔÚÜ]*$/i,
  ru: /^[А-ЯЁ]*$/i,
  sr: /^[A-ZČĆŽŠĐ]*$/i,
  tr: /^[A-ZÇĞİıÖŞÜ]*$/i,
  uk: /^[А-ЩЬЮЯЄIЇҐ]*$/i,
  ar: /^[ءآأؤإئابةتثجحخدذرزسشصضطظعغفقكلمنهوىيًٌٍَُِّْٰ]*$/
};

var alphaSpaces = {
  en: /^[A-Z\s]*$/i,
  cs: /^[A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ\s]*$/i,
  da: /^[A-ZÆØÅ\s]*$/i,
  de: /^[A-ZÄÖÜß\s]*$/i,
  es: /^[A-ZÁÉÍÑÓÚÜ\s]*$/i,
  fr: /^[A-ZÀÂÆÇÉÈÊËÏÎÔŒÙÛÜŸ\s]*$/i,
  nl: /^[A-ZÉËÏÓÖÜ\s]*$/i,
  hu: /^[A-ZÁÉÍÓÖŐÚÜŰ\s]*$/i,
  pl: /^[A-ZĄĆĘŚŁŃÓŻŹ\s]*$/i,
  pt: /^[A-ZÃÁÀÂÇÉÊÍÕÓÔÚÜ\s]*$/i,
  ru: /^[А-ЯЁ\s]*$/i,
  sr: /^[A-ZČĆŽŠĐ\s]*$/i,
  tr: /^[A-ZÇĞİıÖŞÜ\s]*$/i,
  uk: /^[А-ЩЬЮЯЄIЇҐ\s]*$/i,
  ar: /^[ءآأؤإئابةتثجحخدذرزسشصضطظعغفقكلمنهوىيًٌٍَُِّْٰ\s]*$/
};

var alphanumeric = {
  en: /^[0-9A-Z]*$/i,
  cs: /^[0-9A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ]*$/i,
  da: /^[0-9A-ZÆØÅ]$/i,
  de: /^[0-9A-ZÄÖÜß]*$/i,
  es: /^[0-9A-ZÁÉÍÑÓÚÜ]*$/i,
  fr: /^[0-9A-ZÀÂÆÇÉÈÊËÏÎÔŒÙÛÜŸ]*$/i,
  hu: /^[0-9A-ZÁÉÍÓÖŐÚÜŰ]*$/i,
  nl: /^[0-9A-ZÉËÏÓÖÜ]*$/i,
  pl: /^[0-9A-ZĄĆĘŚŁŃÓŻŹ]*$/i,
  pt: /^[0-9A-ZÃÁÀÂÇÉÊÍÕÓÔÚÜ]*$/i,
  ru: /^[0-9А-ЯЁ]*$/i,
  sr: /^[0-9A-ZČĆŽŠĐ]*$/i,
  tr: /^[0-9A-ZÇĞİıÖŞÜ]*$/i,
  uk: /^[0-9А-ЩЬЮЯЄIЇҐ]*$/i,
  ar: /^[٠١٢٣٤٥٦٧٨٩0-9ءآأؤإئابةتثجحخدذرزسشصضطظعغفقكلمنهوىيًٌٍَُِّْٰ]*$/
};

var alphaDash = {
  en: /^[0-9A-Z_-]*$/i,
  cs: /^[0-9A-ZÁČĎÉĚÍŇÓŘŠŤÚŮÝŽ_-]*$/i,
  da: /^[0-9A-ZÆØÅ_-]*$/i,
  de: /^[0-9A-ZÄÖÜß_-]*$/i,
  es: /^[0-9A-ZÁÉÍÑÓÚÜ_-]*$/i,
  fr: /^[0-9A-ZÀÂÆÇÉÈÊËÏÎÔŒÙÛÜŸ_-]*$/i,
  nl: /^[0-9A-ZÉËÏÓÖÜ_-]*$/i,
  hu: /^[0-9A-ZÁÉÍÓÖŐÚÜŰ_-]*$/i,
  pl: /^[0-9A-ZĄĆĘŚŁŃÓŻŹ_-]*$/i,
  pt: /^[0-9A-ZÃÁÀÂÇÉÊÍÕÓÔÚÜ_-]*$/i,
  ru: /^[0-9А-ЯЁ_-]*$/i,
  sr: /^[0-9A-ZČĆŽŠĐ_-]*$/i,
  tr: /^[0-9A-ZÇĞİıÖŞÜ_-]*$/i,
  uk: /^[0-9А-ЩЬЮЯЄIЇҐ_-]*$/i,
  ar: /^[٠١٢٣٤٥٦٧٨٩0-9ءآأؤإئابةتثجحخدذرزسشصضطظعغفقكلمنهوىيًٌٍَُِّْٰ_-]*$/
};

var alpha$$1 = function (value, ref) {
  if ( ref === void 0 ) ref = [null];
  var locale = ref[0];

  // Match at least one locale.
  if (! locale) {
    return Object.keys(alpha$1).some(function (loc) { return alpha$1[loc].test(value); });
  }

  return (alpha$1[locale] || alpha$1.en).test(value);
};

var alpha_dash = function (value, ref) {
  if ( ref === void 0 ) ref = [null];
  var locale = ref[0];

  // Match at least one locale.
  if (! locale) {
    return Object.keys(alphaDash).some(function (loc) { return alphaDash[loc].test(value); });
  }

  return (alphaDash[locale] || alphaDash.en).test(value);
};

var alpha_num = function (value, ref) {
  if ( ref === void 0 ) ref = [null];
  var locale = ref[0];

  // Match at least one locale.
  if (! locale) {
    return Object.keys(alphanumeric).some(function (loc) { return alphanumeric[loc].test(value); });
  }

  return (alphanumeric[locale] || alphanumeric.en).test(value);
};

var alpha_spaces = function (value, ref) {
  if ( ref === void 0 ) ref = [null];
  var locale = ref[0];

  // Match at least one locale.
  if (! locale) {
    return Object.keys(alphaSpaces).some(function (loc) { return alphaSpaces[loc].test(value); });
  }

  return (alphaSpaces[locale] || alphaSpaces.en).test(value);
};

var between = function (value, ref) {
	var min = ref[0];
	var max = ref[1];

	return Number(min) <= value && Number(max) >= value;
};

var confirmed = function (value, ref, validatingField) {
  var confirmedField = ref[0];

  var field = confirmedField
    ? document.querySelector(("input[name='" + confirmedField + "']"))
    : document.querySelector(("input[name='" + validatingField + "_confirmation']"));

  return !! (field && String(value) === field.value);
};

function unwrapExports (x) {
	return x && x.__esModule ? x['default'] : x;
}

function createCommonjsModule(fn, module) {
	return module = { exports: {} }, fn(module, module.exports), module.exports;
}

var assertString_1 = createCommonjsModule(function (module, exports) {
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = assertString;
function assertString(input) {
  if (typeof input !== 'string') {
    throw new TypeError('This library (validator.js) validates strings only');
  }
}
module.exports = exports['default'];
});

var isCreditCard_1 = createCommonjsModule(function (module, exports) {
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = isCreditCard;



var _assertString2 = _interopRequireDefault(assertString_1);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/* eslint-disable max-len */
var creditCard = /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|(222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})|62[0-9]{14}$/;
/* eslint-enable max-len */

function isCreditCard(str) {
  (0, _assertString2.default)(str);
  var sanitized = str.replace(/[^0-9]+/g, '');
  if (!creditCard.test(sanitized)) {
    return false;
  }
  var sum = 0;
  var digit = void 0;
  var tmpNum = void 0;
  var shouldDouble = void 0;
  for (var i = sanitized.length - 1; i >= 0; i--) {
    digit = sanitized.substring(i, i + 1);
    tmpNum = parseInt(digit, 10);
    if (shouldDouble) {
      tmpNum *= 2;
      if (tmpNum >= 10) {
        sum += tmpNum % 10 + 1;
      } else {
        sum += tmpNum;
      }
    } else {
      sum += tmpNum;
    }
    shouldDouble = !shouldDouble;
  }
  return !!(sum % 10 === 0 ? sanitized : false);
}
module.exports = exports['default'];
});

var isCreditCard = unwrapExports(isCreditCard_1);

var credit_card = function (value) { return isCreditCard(String(value)); };

var decimal = function (value, params) {
  var decimals = Array.isArray(params) ? (params[0] || '*') : '*';
  if (Array.isArray(value)) {
    return false;
  }

  if (value === null || value === undefined || value === '') {
    return true;
  }

    // if is 0.
  if (Number(decimals) === 0) {
    return /^-?\d*$/.test(value);
  }

  var regexPart = decimals === '*' ? '+' : ("{1," + decimals + "}");
  var regex = new RegExp(("^-?\\d*(\\.\\d" + regexPart + ")?$"));

  if (! regex.test(value)) {
    return false;
  }

  var parsedValue = parseFloat(value);

    // eslint-disable-next-line
    return parsedValue === parsedValue;
};

var digits = function (value, ref) {
  var length = ref[0];

  var strVal = String(value);

  return /^[0-9]*$/.test(strVal) && strVal.length === Number(length);
};

var validateImage = function (file, width, height) {
  var URL = window.URL || window.webkitURL;
  return new Promise(function (resolve) {
    var image = new Image();
    image.onerror = function () { return resolve({ valid: false }); };
    image.onload = function () { return resolve({
      valid: image.width === Number(width) && image.height === Number(height)
    }); };

    image.src = URL.createObjectURL(file);
  });
};

var dimensions = function (files, ref) {
  var width = ref[0];
  var height = ref[1];

  var list = [];
  for (var i = 0; i < files.length; i++) {
        // if file is not an image, reject.
    if (! /\.(jpg|svg|jpeg|png|bmp|gif)$/i.test(files[i].name)) {
      return false;
    }

    list.push(files[i]);
  }

  return Promise.all(list.map(function (file) { return validateImage(file, width, height); }));
};

var merge_1 = createCommonjsModule(function (module, exports) {
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = merge;
function merge() {
  var obj = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var defaults = arguments[1];

  for (var key in defaults) {
    if (typeof obj[key] === 'undefined') {
      obj[key] = defaults[key];
    }
  }
  return obj;
}
module.exports = exports['default'];
});

var isByteLength_1 = createCommonjsModule(function (module, exports) {
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

exports.default = isByteLength;



var _assertString2 = _interopRequireDefault(assertString_1);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/* eslint-disable prefer-rest-params */
function isByteLength(str, options) {
  (0, _assertString2.default)(str);
  var min = void 0;
  var max = void 0;
  if ((typeof options === 'undefined' ? 'undefined' : _typeof(options)) === 'object') {
    min = options.min || 0;
    max = options.max;
  } else {
    // backwards compatibility: isByteLength(str, min [, max])
    min = arguments[1];
    max = arguments[2];
  }
  var len = encodeURI(str).split(/%..|./).length - 1;
  return len >= min && (typeof max === 'undefined' || len <= max);
}
module.exports = exports['default'];
});

var isFQDN = createCommonjsModule(function (module, exports) {
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = isFDQN;



var _assertString2 = _interopRequireDefault(assertString_1);



var _merge2 = _interopRequireDefault(merge_1);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var default_fqdn_options = {
  require_tld: true,
  allow_underscores: false,
  allow_trailing_dot: false
};

function isFDQN(str, options) {
  (0, _assertString2.default)(str);
  options = (0, _merge2.default)(options, default_fqdn_options);

  /* Remove the optional trailing dot before checking validity */
  if (options.allow_trailing_dot && str[str.length - 1] === '.') {
    str = str.substring(0, str.length - 1);
  }
  var parts = str.split('.');
  if (options.require_tld) {
    var tld = parts.pop();
    if (!parts.length || !/^([a-z\u00a1-\uffff]{2,}|xn[a-z0-9-]{2,})$/i.test(tld)) {
      return false;
    }
  }
  for (var part, i = 0; i < parts.length; i++) {
    part = parts[i];
    if (options.allow_underscores) {
      part = part.replace(/_/g, '');
    }
    if (!/^[a-z\u00a1-\uffff0-9-]+$/i.test(part)) {
      return false;
    }
    if (/[\uff01-\uff5e]/.test(part)) {
      // disallow full-width chars
      return false;
    }
    if (part[0] === '-' || part[part.length - 1] === '-') {
      return false;
    }
  }
  return true;
}
module.exports = exports['default'];
});

var isEmail_1 = createCommonjsModule(function (module, exports) {
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = isEmail;



var _assertString2 = _interopRequireDefault(assertString_1);



var _merge2 = _interopRequireDefault(merge_1);



var _isByteLength2 = _interopRequireDefault(isByteLength_1);



var _isFQDN2 = _interopRequireDefault(isFQDN);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var default_email_options = {
  allow_display_name: false,
  require_display_name: false,
  allow_utf8_local_part: true,
  require_tld: true
};

/* eslint-disable max-len */
/* eslint-disable no-control-regex */
var displayName = /^[a-z\d!#\$%&'\*\+\-\/=\?\^_`{\|}~\.\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+[a-z\d!#\$%&'\*\+\-\/=\?\^_`{\|}~\.\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF\s]*<(.+)>$/i;
var emailUserPart = /^[a-z\d!#\$%&'\*\+\-\/=\?\^_`{\|}~]+$/i;
var quotedEmailUser = /^([\s\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e]|(\\[\x01-\x09\x0b\x0c\x0d-\x7f]))*$/i;
var emailUserUtf8Part = /^[a-z\d!#\$%&'\*\+\-\/=\?\^_`{\|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+$/i;
var quotedEmailUserUtf8 = /^([\s\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|(\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*$/i;
/* eslint-enable max-len */
/* eslint-enable no-control-regex */

function isEmail(str, options) {
  (0, _assertString2.default)(str);
  options = (0, _merge2.default)(options, default_email_options);

  if (options.require_display_name || options.allow_display_name) {
    var display_email = str.match(displayName);
    if (display_email) {
      str = display_email[1];
    } else if (options.require_display_name) {
      return false;
    }
  }

  var parts = str.split('@');
  var domain = parts.pop();
  var user = parts.join('@');

  var lower_domain = domain.toLowerCase();
  if (lower_domain === 'gmail.com' || lower_domain === 'googlemail.com') {
    user = user.replace(/\./g, '').toLowerCase();
  }

  if (!(0, _isByteLength2.default)(user, { max: 64 }) || !(0, _isByteLength2.default)(domain, { max: 256 })) {
    return false;
  }

  if (!(0, _isFQDN2.default)(domain, { require_tld: options.require_tld })) {
    return false;
  }

  if (user[0] === '"') {
    user = user.slice(1, user.length - 1);
    return options.allow_utf8_local_part ? quotedEmailUserUtf8.test(user) : quotedEmailUser.test(user);
  }

  var pattern = options.allow_utf8_local_part ? emailUserUtf8Part : emailUserPart;

  var user_parts = user.split('.');
  for (var i = 0; i < user_parts.length; i++) {
    if (!pattern.test(user_parts[i])) {
      return false;
    }
  }

  return true;
}
module.exports = exports['default'];
});

var isEmail = unwrapExports(isEmail_1);

var email = function (value) { return isEmail(String(value)); };

var ext = function (files, extensions) {
  var regex = new RegExp((".(" + (extensions.join('|')) + ")$"), 'i');

  return files.every(function (file) { return regex.test(file.name); });
};

var image = function (files) { return files.every(function (file) { return /\.(jpg|svg|jpeg|png|bmp|gif)$/i.test(file.name); }
); };

var In = function (value, options) { return !! options.filter(function (option) { return option == value; }).length; }; // eslint-disable-line

var isIP_1 = createCommonjsModule(function (module, exports) {
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = isIP;



var _assertString2 = _interopRequireDefault(assertString_1);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var ipv4Maybe = /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/;
var ipv6Block = /^[0-9A-F]{1,4}$/i;

function isIP(str) {
  var version = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

  (0, _assertString2.default)(str);
  version = String(version);
  if (!version) {
    return isIP(str, 4) || isIP(str, 6);
  } else if (version === '4') {
    if (!ipv4Maybe.test(str)) {
      return false;
    }
    var parts = str.split('.').sort(function (a, b) {
      return a - b;
    });
    return parts[3] <= 255;
  } else if (version === '6') {
    var blocks = str.split(':');
    var foundOmissionBlock = false; // marker to indicate ::

    // At least some OS accept the last 32 bits of an IPv6 address
    // (i.e. 2 of the blocks) in IPv4 notation, and RFC 3493 says
    // that '::ffff:a.b.c.d' is valid for IPv4-mapped IPv6 addresses,
    // and '::a.b.c.d' is deprecated, but also valid.
    var foundIPv4TransitionBlock = isIP(blocks[blocks.length - 1], 4);
    var expectedNumberOfBlocks = foundIPv4TransitionBlock ? 7 : 8;

    if (blocks.length > expectedNumberOfBlocks) {
      return false;
    }
    // initial or final ::
    if (str === '::') {
      return true;
    } else if (str.substr(0, 2) === '::') {
      blocks.shift();
      blocks.shift();
      foundOmissionBlock = true;
    } else if (str.substr(str.length - 2) === '::') {
      blocks.pop();
      blocks.pop();
      foundOmissionBlock = true;
    }

    for (var i = 0; i < blocks.length; ++i) {
      // test for a :: which can not be at the string start/end
      // since those cases have been handled above
      if (blocks[i] === '' && i > 0 && i < blocks.length - 1) {
        if (foundOmissionBlock) {
          return false; // multiple :: in address
        }
        foundOmissionBlock = true;
      } else if (foundIPv4TransitionBlock && i === blocks.length - 1) {
        // it has been checked before that the last
        // block is a valid IPv4 address
      } else if (!ipv6Block.test(blocks[i])) {
        return false;
      }
    }
    if (foundOmissionBlock) {
      return blocks.length >= 1;
    }
    return blocks.length === expectedNumberOfBlocks;
  }
  return false;
}
module.exports = exports['default'];
});

var isIP = unwrapExports(isIP_1);

var ip = function (value, ref) {
	if ( ref === void 0 ) ref = [4];
	var version = ref[0];

	return isIP(value, version);
};

var max = function (value, ref) {
  var length = ref[0];

  if (value === undefined || value === null) {
    return length >= 0;
  }

  return String(value).length <= length;
};

var max_value = function (value, ref) {
  var max = ref[0];

  if (Array.isArray(value) || value === null || value === undefined || value === '') {
    return false;
  }

  return Number(value) <= max;
};

var mimes = function (files, mimes) {
  var regex = new RegExp(((mimes.join('|').replace('*', '.+')) + "$"), 'i');

  return files.every(function (file) { return regex.test(file.type); });
};

var min = function (value, ref) {
  var length = ref[0];

  if (value === undefined || value === null) {
    return false;
  }
  return String(value).length >= length;
};

var min_value = function (value, ref) {
  var min = ref[0];

  if (Array.isArray(value) || value === null || value === undefined || value === '') {
    return false;
  }

  return Number(value) >= min;
};

var not_in = function (value, options) { return ! options.filter(function (option) { return option == value; }).length; }; // eslint-disable-line

var numeric = function (value) { return /^[0-9]+$/.test(String(value)); };

var regex = function (value, ref) {
  var regex = ref[0];
  var flags = ref.slice(1);

  if (regex instanceof RegExp) {
    return regex.test(value);
  }

  return new RegExp(regex, flags).test(String(value));
};

var required = function (value) {
  if (Array.isArray(value)) {
    return !! value.length;
  }

  if (value === undefined || value === null || value === false) {
    return false;
  }

  return !! String(value).trim().length;
};

var size = function (files, ref) {
  var size = ref[0];

  if (isNaN(size)) {
    return false;
  }

  var nSize = Number(size) * 1024;
  for (var i = 0; i < files.length; i++) {
    if (files[i].size > nSize) {
      return false;
    }
  }

  return true;
};

var isURL_1 = createCommonjsModule(function (module, exports) {
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.default = isURL;



var _assertString2 = _interopRequireDefault(assertString_1);



var _isFQDN2 = _interopRequireDefault(isFQDN);



var _isIP2 = _interopRequireDefault(isIP_1);



var _merge2 = _interopRequireDefault(merge_1);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var default_url_options = {
  protocols: ['http', 'https', 'ftp'],
  require_tld: true,
  require_protocol: false,
  require_host: true,
  require_valid_protocol: true,
  allow_underscores: false,
  allow_trailing_dot: false,
  allow_protocol_relative_urls: false
};

var wrapped_ipv6 = /^\[([^\]]+)\](?::([0-9]+))?$/;

function isRegExp(obj) {
  return Object.prototype.toString.call(obj) === '[object RegExp]';
}

function checkHost(host, matches) {
  for (var i = 0; i < matches.length; i++) {
    var match = matches[i];
    if (host === match || isRegExp(match) && match.test(host)) {
      return true;
    }
  }
  return false;
}

function isURL(url, options) {
  (0, _assertString2.default)(url);
  if (!url || url.length >= 2083 || /[\s<>]/.test(url)) {
    return false;
  }
  if (url.indexOf('mailto:') === 0) {
    return false;
  }
  options = (0, _merge2.default)(options, default_url_options);
  var protocol = void 0,
      auth = void 0,
      host = void 0,
      hostname = void 0,
      port = void 0,
      port_str = void 0,
      split = void 0,
      ipv6 = void 0;

  split = url.split('#');
  url = split.shift();

  split = url.split('?');
  url = split.shift();

  split = url.split('://');
  if (split.length > 1) {
    protocol = split.shift();
    if (options.require_valid_protocol && options.protocols.indexOf(protocol) === -1) {
      return false;
    }
  } else if (options.require_protocol) {
    return false;
  } else if (options.allow_protocol_relative_urls && url.substr(0, 2) === '//') {
    split[0] = url.substr(2);
  }
  url = split.join('://');

  split = url.split('/');
  url = split.shift();

  if (url === '' && !options.require_host) {
    return true;
  }

  split = url.split('@');
  if (split.length > 1) {
    auth = split.shift();
    if (auth.indexOf(':') >= 0 && auth.split(':').length > 2) {
      return false;
    }
  }
  hostname = split.join('@');

  port_str = ipv6 = null;
  var ipv6_match = hostname.match(wrapped_ipv6);
  if (ipv6_match) {
    host = '';
    ipv6 = ipv6_match[1];
    port_str = ipv6_match[2] || null;
  } else {
    split = hostname.split(':');
    host = split.shift();
    if (split.length) {
      port_str = split.join(':');
    }
  }

  if (port_str !== null) {
    port = parseInt(port_str, 10);
    if (!/^[0-9]+$/.test(port_str) || port <= 0 || port > 65535) {
      return false;
    }
  }

  if (!(0, _isIP2.default)(host) && !(0, _isFQDN2.default)(host, options) && (!ipv6 || !(0, _isIP2.default)(ipv6, 6)) && host !== 'localhost') {
    return false;
  }

  host = host || ipv6;

  if (options.host_whitelist && !checkHost(host, options.host_whitelist)) {
    return false;
  }
  if (options.host_blacklist && checkHost(host, options.host_blacklist)) {
    return false;
  }

  return true;
}
module.exports = exports['default'];
});

var isURL = unwrapExports(isURL_1);

var url = function (value, ref) {
        if ( ref === void 0 ) ref = [true];
        var requireProtocol = ref[0];

        return isURL(value, { require_protocol: !! requireProtocol });
};

/* eslint-disable camelcase */
var Rules = {
  alpha_dash: alpha_dash,
  alpha_num: alpha_num,
  alpha_spaces: alpha_spaces,
  alpha: alpha$$1,
  between: between,
  confirmed: confirmed,
  credit_card: credit_card,
  decimal: decimal,
  digits: digits,
  dimensions: dimensions,
  email: email,
  ext: ext,
  image: image,
  in: In,
  ip: ip,
  max: max,
  max_value: max_value,
  mimes: mimes,
  min: min,
  min_value: min_value,
  not_in: not_in,
  numeric: numeric,
  regex: regex,
  required: required,
  size: size,
  url: url
};

var ErrorBag = function ErrorBag() {
  this.errors = [];
};

  /**
   * Adds an error to the internal array.
   *
   * @param {string} field The field name.
   * @param {string} msg The error message.
   * @param {String} rule The rule that is responsible for the error.
   * @param {String} scope The Scope name, optional.
   */
ErrorBag.prototype.add = function add (field, msg, rule, scope) {
    if ( scope === void 0 ) scope = '__global__';

  this.errors.push({ field: field, msg: msg, rule: rule, scope: scope });
};

  /**
   * Gets all error messages from the internal array.
   *
   * @param {String} scope The Scope name, optional.
   * @return {Array} errors Array of all error messages.
   */
ErrorBag.prototype.all = function all (scope) {
  if (! scope) {
    return this.errors.map(function (e) { return e.msg; });
  }

  return this.errors.filter(function (e) { return e.scope === scope; }).map(function (e) { return e.msg; });
};

  /**
   * Checks if there are any errors in the internal array.
   * @param {String} scope The Scope name, optional.
   * @return {boolean} result True if there was at least one error, false otherwise.
   */
ErrorBag.prototype.any = function any (scope) {
  if (! scope) {
    return !! this.errors.length;
  }

  return !! this.errors.filter(function (e) { return e.scope === scope; }).length;
};

  /**
   * Removes all items from the internal array.
   *
   * @param {String} scope The Scope name, optional.
   */
ErrorBag.prototype.clear = function clear (scope) {
  if (! scope) {
    scope = '__global__';
  }

  this.errors = this.errors.filter(function (e) { return e.scope !== scope; });
};

  /**
   * Collects errors into groups or for a specific field.
   *
   * @param{string} field The field name.
   * @param{string} scope The scope name.
   * @param {Boolean} map If it should map the errors to strings instead of objects.
   * @return {Array} errors The errors for the specified field.
   */
ErrorBag.prototype.collect = function collect (field, scope, map) {
    if ( map === void 0 ) map = true;

  if (! field) {
    var collection = {};
    this.errors.forEach(function (e) {
      if (! collection[e.field]) {
        collection[e.field] = [];
      }

      collection[e.field].push(map ? e.msg : e);
    });

    return collection;
  }

  if (! scope) {
    return this.errors.filter(function (e) { return e.field === field; }).map(function (e) { return (map ? e.msg : e); });
  }

  return this.errors.filter(function (e) { return e.field === field && e.scope === scope; })
                    .map(function (e) { return (map ? e.msg : e); });
};
  /**
   * Gets the internal array length.
   *
   * @return {Number} length The internal array length.
   */
ErrorBag.prototype.count = function count () {
  return this.errors.length;
};

  /**
   * Gets the first error message for a specific field.
   *
   * @param{string} field The field name.
   * @return {string|null} message The error message.
   */
ErrorBag.prototype.first = function first (field, scope) {
    var this$1 = this;
    if ( scope === void 0 ) scope = '__global__';

  var selector = this._selector(field);
  var scoped = this._scope(field);

  if (scoped) {
    var result = this.first(scoped.name, scoped.scope);
    // if such result exist, return it. otherwise it could be a field.
    // with dot in its name.
    if (result) {
      return result;
    }
  }

  if (selector) {
    return this.firstByRule(selector.name, selector.rule, scope);
  }

  for (var i = 0; i < this.errors.length; i++) {
    if (this$1.errors[i].field === field && (this$1.errors[i].scope === scope)) {
      return this$1.errors[i].msg;
    }
  }

  return null;
};

  /**
   * Returns the first error rule for the specified field
   *
   * @param {string} field The specified field.
   * @return {string|null} First error rule on the specified field if one is found, otherwise null
   */
ErrorBag.prototype.firstRule = function firstRule (field, scope) {
  var errors = this.collect(field, scope, false);

  return (errors.length && errors[0].rule) || null;
};

  /**
   * Checks if the internal array has at least one error for the specified field.
   *
   * @param{string} field The specified field.
   * @return {Boolean} result True if at least one error is found, false otherwise.
   */
ErrorBag.prototype.has = function has (field, scope) {
    if ( scope === void 0 ) scope = '__global__';

  return !! this.first(field, scope);
};

  /**
   * Gets the first error message for a specific field and a rule.
   * @param {String} name The name of the field.
   * @param {String} rule The name of the rule.
   * @param {String} scope The name of the scope (optional).
   */
ErrorBag.prototype.firstByRule = function firstByRule (name, rule, scope) {
  var error = this.collect(name, scope, false).filter(function (e) { return e.rule === rule; })[0];

  return (error && error.msg) || null;
};

  /**
   * Removes all error messages associated with a specific field.
   *
   * @param{string} field The field which messages are to be removed.
   * @param {String} scope The Scope name, optional.
   */
ErrorBag.prototype.remove = function remove (field, scope) {
  var filter = scope ? (function (e) { return e.field !== field || e.scope !== scope; }) :
                         (function (e) { return e.field !== field || e.scope !== '__global__'; });

  this.errors = this.errors.filter(filter);
};


  /**
   * Get the field attributes if there's a rule selector.
   *
   * @param{string} field The specified field.
   * @return {Object|null}
   */
ErrorBag.prototype._selector = function _selector (field) {
  if (field.indexOf(':') > -1) {
    var ref = field.split(':');
      var name = ref[0];
      var rule = ref[1];

    return { name: name, rule: rule };
  }

  return null;
};

  /**
   * Get the field scope if specified using dot notation.
   *
   * @param {string} field the specifie field.
   * @return {Object|null}
   */
ErrorBag.prototype._scope = function _scope (field) {
  if (field.indexOf('.') > -1) {
    var ref = field.split('.');
      var scope = ref[0];
      var name = ref[1];

    return { name: name, scope: scope };
  }

  return null;
};

var ValidatorException = (function () {
  function anonymous(msg) {
    this.msg = "[vee-validate]: " + msg;
  }

  anonymous.prototype.toString = function toString () {
    return this.msg;
  };

  return anonymous;
}());

/**
 * Gets the data attribute. the name must be kebab-case.
 */
var getDataAttribute = function (el, name) { return el.getAttribute(("data-vv-" + name)); };

/**
 * Determines the input field scope.
 */
var getScope = function (el) {
  var scope = getDataAttribute(el, 'scope');
  if (! scope && el.form) {
    scope = getDataAttribute(el.form, 'scope');
  }

  return scope;
};

/**
 * Gets the value in an object safely.
 * @param {String} propPath
 * @param {Object} target
 * @param {*} def
 */
var getPath = function (propPath, target, def) {
  if ( def === void 0 ) def = undefined;

  if (!propPath || !target) { return def; }

  var value = target;
  propPath.split('.').every(function (prop) {
    if (! Object.prototype.hasOwnProperty.call(value, prop)) {
      value = def;

      return false;
    }

    value = value[prop];

    return true;
  });

  return value;
};

/**
 * Debounces a function.
 */
var debounce = function (callback, wait, immediate) {
  if ( wait === void 0 ) wait = 0;
  if ( immediate === void 0 ) immediate = true;

  var timeout;

  return function () {
    var args = [], len = arguments.length;
    while ( len-- ) args[ len ] = arguments[ len ];

    var later = function () {
      timeout = null;
      if (!immediate) { callback.apply(void 0, args); }
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) { callback.apply(void 0, args); }
  };
};

/**
 * Emits a warning to the console.
 */
var warn = function (message) {
  if (! console) {
    return;
  }

    console.warn(("[vee-validate]: " + message)); // eslint-disable-line
};

/**
 * Checks if the value is an object.
 */
var isObject = function (object) { return object !== null && object && typeof object === 'object' && ! Array.isArray(object); };

/**
 * Checks if a function is callable.
 */
var isCallable = function (func) { return typeof func === 'function'; };

/**
 * Check if element has the css class on it.
 */
var hasClass = function (el, className) {
  if (el.classList) {
    return el.classList.contains(className);
  }

  return !!el.className.match(new RegExp(("(\\s|^)" + className + "(\\s|$)")));
};

/**
 * Adds the provided css className to the element.
 */
var addClass = function (el, className) {
  if (el.classList) {
    el.classList.add(className);
    return;
  }

  if (!hasClass(el, className)) {
    el.className += " " + className;
  }
};

/**
 * Remove the provided css className from the element.
 */
var removeClass = function (el, className) {
  if (el.classList) {
    el.classList.remove(className);
    return;
  }

  if (hasClass(el, className)) {
    var reg = new RegExp(("(\\s|^)" + className + "(\\s|$)"));
    el.className = el.className.replace(reg, ' ');
  }
};

/**
 * Converts an array-like object to array.
 * Simple polyfill for Array.from
 */
var toArray = function (arrayLike) {
  if (Array.from) {
    return Array.from(arrayLike);
  }

  var array = [];
  var length = arrayLike.length;
  for (var i = 0; i < length; i++) {
    array.push(arrayLike[i]);
  }

  return array;
};

/**
 * Assign polyfill from the mdn.
 */
var assign = function (target) {
  var others = [], len = arguments.length - 1;
  while ( len-- > 0 ) others[ len ] = arguments[ len + 1 ];

  if (Object.assign) {
    return Object.assign.apply(Object, [ target ].concat( others ));
  }

  if (target == null) {
    throw new TypeError('Cannot convert undefined or null to object');
  }

  var to = Object(target);
  others.forEach(function (arg) {
    // Skip over if undefined or null
    if (arg != null) {
      Object.keys(arg).forEach(function (key) {
        to[key] = arg[key];
      });
    }
  });

  return to;
};

/**
 * polyfills array.find
 * @param {Array} array
 * @param {Function} predicate
 */
var find = function (array, predicate) {
  if (array.find) {
    return array.find(predicate);
  }

  var result;
  array.some(function (item) {
    if (predicate(item)) {
      result = item;
      return true;
    }

    return false;
  });

  return result;
};

/**
 * Gets the rules from a binding value or the element dataset.
 *
 * @param {String} expression The binding expression.
 * @param {Object|String} value The binding value.
 * @param {element} el The element.
 * @returns {String|Object}
 */
var getRules = function (expression, value, el) {
  if (! expression) {
    return getDataAttribute(el, 'rules');
  }

  if (typeof value === 'string') {
    return value;
  }

  if (~['string', 'object'].indexOf(typeof value.rules)) {
    return value.rules;
  }

  return value;
};

var Dictionary = function Dictionary(dictionary) {
  if ( dictionary === void 0 ) dictionary = {};

  this.dictionary = {};
  this.merge(dictionary);
};

Dictionary.prototype.hasLocale = function hasLocale (locale) {
  return !! this.dictionary[locale];
};

Dictionary.prototype.getMessage = function getMessage (locale, key, fallback) {
  if (! this.hasMessage(locale, key)) {
    return fallback || this._getDefaultMessage(locale);
  }

  return this.dictionary[locale].messages[key];
};

/**
 * Gets a specific message for field. fallsback to the rule message.
 *
 * @param {String} locale
 * @param {String} field
 * @param {String} key
 */
Dictionary.prototype.getFieldMessage = function getFieldMessage (locale, field, key) {
  if (! this.hasLocale(locale)) {
    return this.getMessage(locale, key);
  }

  var dict = this.dictionary[locale].custom && this.dictionary[locale].custom[field];
  if (! dict || ! dict[key]) {
    return this.getMessage(locale, key);
  }

  return dict[key];
};

Dictionary.prototype._getDefaultMessage = function _getDefaultMessage (locale) {
  if (this.hasMessage(locale, '_default')) {
    return this.dictionary[locale].messages._default;
  }

  return this.dictionary.en.messages._default;
};

Dictionary.prototype.getAttribute = function getAttribute (locale, key, fallback) {
    if ( fallback === void 0 ) fallback = '';

  if (! this.hasAttribute(locale, key)) {
    return fallback;
  }

  return this.dictionary[locale].attributes[key];
};

Dictionary.prototype.hasMessage = function hasMessage (locale, key) {
  return !! (
          this.hasLocale(locale) &&
          this.dictionary[locale].messages &&
          this.dictionary[locale].messages[key]
      );
};

Dictionary.prototype.hasAttribute = function hasAttribute (locale, key) {
  return !! (
          this.hasLocale(locale) &&
          this.dictionary[locale].attributes &&
          this.dictionary[locale].attributes[key]
      );
};

Dictionary.prototype.merge = function merge (dictionary) {
  this._merge(this.dictionary, dictionary);
};

Dictionary.prototype.setMessage = function setMessage (locale, key, message) {
  if (! this.hasLocale(locale)) {
    this.dictionary[locale] = {
      messages: {},
      attributes: {}
    };
  }

  this.dictionary[locale].messages[key] = message;
};

Dictionary.prototype.setAttribute = function setAttribute (locale, key, attribute) {
  if (! this.hasLocale(locale)) {
    this.dictionary[locale] = {
      messages: {},
      attributes: {}
    };
  }

  this.dictionary[locale].attributes[key] = attribute;
};

Dictionary.prototype._merge = function _merge (target, source) {
    var this$1 = this;

  if (! (isObject(target) && isObject(source))) {
    return target;
  }

  Object.keys(source).forEach(function (key) {
    if (isObject(source[key])) {
      if (! target[key]) {
        assign(target, ( obj = {}, obj[key] = {}, obj ));
          var obj;
      }

      this$1._merge(target[key], source[key]);
      return;
    }

    assign(target, ( obj$1 = {}, obj$1[key] = source[key], obj$1 ));
      var obj$1;
  });

  return target;
};

/* istanbul ignore next */
var messages = {
  _default: function (field) { return ("The " + field + " value is not valid."); },
  alpha_dash: function (field) { return ("The " + field + " field may contain alpha-numeric characters as well as dashes and underscores."); },
  alpha_num: function (field) { return ("The " + field + " field may only contain alpha-numeric characters."); },
  alpha_spaces: function (field) { return ("The " + field + " field may only contain alphabetic characters as well as spaces."); },
  alpha: function (field) { return ("The " + field + " field may only contain alphabetic characters."); },
  between: function (field, ref) {
    var min = ref[0];
    var max = ref[1];

    return ("The " + field + " field must be between " + min + " and " + max + ".");
},
  confirmed: function (field) { return ("The " + field + " confirmation does not match."); },
  credit_card: function (field) { return ("The " + field + " field is invalid."); },
  decimal: function (field, ref) {
    if ( ref === void 0 ) ref = ['*'];
    var decimals = ref[0];

    return ("The " + field + " field must be numeric and may contain " + (decimals === '*' ? '' : decimals) + " decimal points.");
},
  digits: function (field, ref) {
    var length = ref[0];

    return ("The " + field + " field must be numeric and exactly contain " + length + " digits.");
},
  dimensions: function (field, ref) {
    var width = ref[0];
    var height = ref[1];

    return ("The " + field + " field must be " + width + " pixels by " + height + " pixels.");
},
  email: function (field) { return ("The " + field + " field must be a valid email."); },
  ext: function (field) { return ("The " + field + " field must be a valid file."); },
  image: function (field) { return ("The " + field + " field must be an image."); },
  in: function (field) { return ("The " + field + " field must be a valid value."); },
  ip: function (field) { return ("The " + field + " field must be a valid ip address."); },
  max: function (field, ref) {
    var length = ref[0];

    return ("The " + field + " field may not be greater than " + length + " characters.");
},
  max_value: function (field, ref) {
    var max = ref[0];

    return ("The " + field + " field must be " + max + " or less.");
},
  mimes: function (field) { return ("The " + field + " field must have a valid file type."); },
  min: function (field, ref) {
    var length = ref[0];

    return ("The " + field + " field must be at least " + length + " characters.");
},
  min_value: function (field, ref) {
    var min = ref[0];

    return ("The " + field + " field must be " + min + " or more.");
},
  not_in: function (field) { return ("The " + field + " field must be a valid value."); },
  numeric: function (field) { return ("The " + field + " field may only contain numeric characters."); },
  regex: function (field) { return ("The " + field + " field format is invalid."); },
  required: function (field) { return ("The " + field + " field is required."); },
  size: function (field, ref) {
    var size = ref[0];

    return ("The " + field + " field must be less than " + size + " KB.");
},
  url: function (field) { return ("The " + field + " field is not a valid URL."); }
};

var after = function (moment) { return function (value, ref) {
  var targetField = ref[0];
  var inclusion = ref[1];
  var format = ref[2];

  var field = document.querySelector(("input[name='" + targetField + "']"));
  if (typeof format === 'undefined') {
    format = inclusion;
    inclusion = false;
  }
  var dateValue = moment(value, format, true);
  var otherValue = moment(field ? field.value : targetField, format, true);

  // if either is not valid.
  if (! dateValue.isValid() || ! otherValue.isValid()) {
    return false;
  }

  return dateValue.isAfter(otherValue) || (inclusion && dateValue.isSame(otherValue));
}; };

var before = function (moment) { return function (value, ref) {
  var targetField = ref[0];
  var inclusion = ref[1];
  var format = ref[2];

  var field = document.querySelector(("input[name='" + targetField + "']"));
  if (typeof format === 'undefined') {
    format = inclusion;
    inclusion = false;
  }
  var dateValue = moment(value, format, true);
  var otherValue = moment(field ? field.value : targetField, format, true);

  // if either is not valid.
  if (! dateValue.isValid() || ! otherValue.isValid()) {
    return false;
  }

  return dateValue.isBefore(otherValue) || (inclusion && dateValue.isSame(otherValue));
}; };

var date_format = function (moment) { return function (value, ref) {
	var format = ref[0];

	return moment(value, format, true).isValid();
 }	};

var date_between = function (moment) { return function (value, params) {
  var min;
  var max;
  var format;
  var inclusivity = '()';

  if (params.length > 3) {
    var assign;
    (assign = params, min = assign[0], max = assign[1], inclusivity = assign[2], format = assign[3]);
  } else {
    var assign$1;
    (assign$1 = params, min = assign$1[0], max = assign$1[1], format = assign$1[2]);
  }

  var minDate = moment(min, format, true);
  var maxDate = moment(max, format, true);
  var dateVal = moment(value, format, true);

  if (! (minDate.isValid() && maxDate.isValid() && dateVal.isValid())) {
    return false;
  }

  return dateVal.isBetween(minDate, maxDate, 'days', inclusivity);
}; };

/* istanbul ignore next */
/* eslint-disable max-len */
var messages$1 = {
  after: function (field, ref) {
    var target = ref[0];

    return ("The " + field + " must be after " + target + ".");
},
  before: function (field, ref) {
    var target = ref[0];

    return ("The " + field + " must be before " + target + ".");
},
  date_between: function (field, ref) {
    var min = ref[0];
    var max = ref[1];

    return ("The " + field + " must be between " + min + " and " + max + ".");
},
  date_format: function (field, ref) {
    var format = ref[0];

    return ("The " + field + " must be in the format " + format + ".");
}
};

var date = {
  make: function (moment) { return ({
    date_format: date_format(moment),
    after: after(moment),
    before: before(moment),
    date_between: date_between(moment)
  }); },
  messages: messages$1,
  installed: false
};

var LOCALE = 'en';
var STRICT_MODE = true;
var DICTIONARY = new Dictionary({
  en: {
    messages: messages,
    attributes: {},
    custom: {}
  }
});

var Validator = function Validator(validations, options) {
  if ( options === void 0 ) options = { init: true, vm: null };

  this.strictMode = STRICT_MODE;
  this.$scopes = { __global__: {} };
  this._createFields(validations);
  this.errorBag = new ErrorBag();
  this.fieldBag = {};
  this.paused = false;
  this.$vm = options.vm;

  // Some fields will be later evaluated, because the vm isn't mounted yet
  // so it may register it under an inaccurate scope.
  this.$deferred = [];
  this.$ready = false;

  // if momentjs is present, install the validators.
  if (typeof moment === 'function') {
    // eslint-disable-next-line
    this.installDateTimeValidators(moment);
  }

  if (options.init) {
    this.init();
  }
};

var prototypeAccessors = { dictionary: {},locale: {},rules: {} };

/**
 * @return {Dictionary}
 */
prototypeAccessors.dictionary.get = function () {
  return DICTIONARY;
};

/**
 * @return {String}
 */
prototypeAccessors.locale.get = function () {
  return LOCALE;
};

/**
 * @return {Object}
 */
prototypeAccessors.rules.get = function () {
  return Rules;
};

/**
 * Merges a validator object into the Rules and Messages.
 *
 * @param{string} name The name of the validator.
 * @param{function|object} validator The validator object.
 */
Validator._merge = function _merge (name, validator) {
  if (isCallable(validator)) {
    Rules[name] = validator;
    return;
  }

  Rules[name] = validator.validate;
  if (isCallable(validator.getMessage)) {
    DICTIONARY.setMessage(LOCALE, name, validator.getMessage);
  }

  if (validator.messages) {
    DICTIONARY.merge(
      Object.keys(validator.messages).reduce(function (prev, curr) {
        var dict = prev;
        dict[curr] = {
          messages: ( obj = {}, obj[name] = validator.messages[curr], obj )
        };
          var obj;

        return dict;
      }, {})
    );
  }
};

/**
 * Guards from extnsion violations.
 *
 * @param{string} name name of the validation rule.
 * @param{object} validator a validation rule object.
 */
Validator._guardExtend = function _guardExtend (name, validator) {
  if (Rules[name]) {
    throw new ValidatorException(
      ("Extension Error: There is an existing validator with the same name '" + name + "'.")
    );
  }

  if (isCallable(validator)) {
    return;
  }

  if (! isCallable(validator.validate)) {
    throw new ValidatorException(
      // eslint-disable-next-line
      ("Extension Error: The validator '" + name + "' must be a function or have a 'validate' method.")
    );
  }

  if (! isCallable(validator.getMessage) && ! isObject(validator.messages)) {
    throw new ValidatorException(
      // eslint-disable-next-line
      ("Extension Error: The validator '" + name + "' must have a 'getMessage' method or have a 'messages' object.")
    );
  }
};

/**
 * Static constructor.
 *
 * @param{object} validations The validations object.
 * @return {Validator} validator A validator object.
 */
Validator.create = function create (validations, options) {
  return new Validator(validations, options);
};

/**
 * Adds a custom validator to the list of validation rules.
 *
 * @param{string} name The name of the validator.
 * @param{object|function} validator The validator object/function.
 */
Validator.extend = function extend (name, validator) {
  Validator._guardExtend(name, validator);
  Validator._merge(name, validator);
};

/**
 * Installs the datetime validators and the messages.
 */
Validator.installDateTimeValidators = function installDateTimeValidators (moment) {
  if (typeof moment !== 'function') {
    warn('To use the date-time validators you must provide moment reference.');

    return false;
  }

  if (date.installed) {
    return true;
  }

  var validators = date.make(moment);
  Object.keys(validators).forEach(function (name) {
    Validator.extend(name, validators[name]);
  });

  Validator.updateDictionary({
    en: {
      messages: date.messages
    }
  });
  date.installed = true;

  return true;
};

/**
 * Removes a rule from the list of validators.
 * @param {String} name The name of the validator/rule.
 */
Validator.remove = function remove (name) {
  delete Rules[name];
};

/**
 * Sets the default locale for all validators.
 *
 * @param {String} language The locale id.
 */
Validator.setLocale = function setLocale (language) {
    if ( language === void 0 ) language = 'en';

  /* istanbul ignore if */
  if (! DICTIONARY.hasLocale(language)) {
    // eslint-disable-next-line
    warn('You are setting the validator locale to a locale that is not defined in the dicitionary. English messages may still be generated.');
  }

  LOCALE = language;
};

/**
 * Sets the operating mode for all newly created validators.
 * strictMode = true: Values without a rule are invalid and cause failure.
 * strictMode = false: Values without a rule are valid and are skipped.
 * @param {Boolean} strictMode.
 */
Validator.setStrictMode = function setStrictMode (strictMode) {
    if ( strictMode === void 0 ) strictMode = true;

  STRICT_MODE = strictMode;
};

/**
 * Updates the dicitionary, overwriting existing values and adding new ones.
 *
 * @param{object} data The dictionary object.
 */
Validator.updateDictionary = function updateDictionary (data) {
  DICTIONARY.merge(data);
};

Validator.addLocale = function addLocale (locale) {
  if (! locale.name) {
    warn('Your locale must have a name property');
    return;
  }

  this.updateDictionary(( obj = {}, obj[locale.name] = locale, obj ));
    var obj;
};

Validator.prototype.addLocale = function addLocale (locale) {
  Validator.addLocale(locale);
};

/**
 * Resolves the scope value. Only strings and functions are allowed.
 * @param {Function|String} scope
 * @returns {String}
 */
Validator.prototype._resolveScope = function _resolveScope (scope) {
  if (typeof scope === 'string') {
    return scope;
  }

  // The resolved value should be string.
  if (isCallable(scope)) {
    var value = scope();
    return typeof value === 'string' ? value : '__global__';
  }

  return '__global__';
};

/**
 * Resolves the field values from the getter functions.
 */
Validator.prototype._resolveValuesFromGetters = function _resolveValuesFromGetters (scope) {
    var this$1 = this;
    if ( scope === void 0 ) scope = '__global__';

  if (! this.$scopes[scope]) {
    return {};
  }
  var values = {};
  Object.keys(this.$scopes[scope]).forEach(function (name) {
    var field = this$1.$scopes[scope][name];
    var getter = field.getter;
    var context = field.context;
    var fieldScope = this$1._resolveScope(field.scope);
    if (getter && context && (scope === '__global__' || fieldScope === scope)) {
      values[name] = {
        value: getter(context()),
        scope: fieldScope
      };
    }
  });

  return values;
};

/**
 * Creates the fields to be validated.
 *
 * @param{object} validations
 * @return {object} Normalized object.
 */
Validator.prototype._createFields = function _createFields (validations) {
    var this$1 = this;

  if (! validations) {
    return;
  }

  Object.keys(validations).forEach(function (field) {
    this$1._createField(field, validations[field]);
  });
};

/**
 * Creates a field entry in the fields object.
 * @param {String} name.
 * @param {String|Array} checks.
 */
Validator.prototype._createField = function _createField (name, checks, scope) {
    if ( scope === void 0 ) scope = '__global__';

  scope = this._resolveScope(scope);
  if (! this.$scopes[scope]) {
    this.$scopes[scope] = {};
  }

  if (! this.$scopes[scope][name]) {
    this.$scopes[scope][name] = {};
  }

  var field = this.$scopes[scope][name];
  field.validations = this._normalizeRules(name, checks, scope);
  field.required = this._isRequired(field);
};

/**
 * Normalizes rules.
 * @return {Object}
 */
Validator.prototype._normalizeRules = function _normalizeRules (name, checks, scope) {
  if (! checks) { return {}; }

  if (typeof checks === 'string') {
    return this._normalizeString(checks);
  }

  if (! isObject(checks)) {
    warn(("Your checks for '" + scope + "." + name + "' must be either a string or an object."));
    return {};
  }

  return this._normalizeObject(checks);
};

/**
 * Checks if a field has a required rule.
 */
Validator.prototype._isRequired = function _isRequired (field) {
  return field.validations && field.validations.required;
};

/**
 * Normalizes an object of rules.
 */
Validator.prototype._normalizeObject = function _normalizeObject (rules) {
    var this$1 = this;

  var validations = {};
  Object.keys(rules).forEach(function (rule) {
    var params = [];
    if (rules[rule] === true) {
      params = [];
    } else if (Array.isArray(rules[rule])) {
      params = rules[rule];
    } else {
      params = [rules[rule]];
    }

    if (rules[rule] === false) {
      delete validations[rule];
    } else {
      validations[rule] = params;
    }

    if (date.installed && this$1._isADateRule(rule)) {
      var dateFormat = this$1._getDateFormat(validations);

      if (! this$1._containsValidation(validations[rule], dateFormat)) {
        validations[rule].push(this$1._getDateFormat(validations));
      }
    }
  });

  return validations;
};

/**
 * Date rules need the existance of a format, so date_format must be supplied.
 * @param {String} name The rule name.
 * @param {Array} validations the field validations.
 */
Validator.prototype._getDateFormat = function _getDateFormat (validations) {
  if (validations.date_format && Array.isArray(validations.date_format)) {
    return validations.date_format[0];
  }

  return null;
};

/**
 * Checks if the passed rule is a date rule.
 */
Validator.prototype._isADateRule = function _isADateRule (rule) {
  return !! ~['after', 'before', 'date_between'].indexOf(rule);
};

/**
 * Checks if the passed validation appears inside the array.
 */
Validator.prototype._containsValidation = function _containsValidation (validations, validation) {
  return !! ~validations.indexOf(validation);
};

/**
 * Normalizes string rules.
 * @param {String} rules The rules that will be normalized.
 * @param {Object} field The field object that is being operated on.
 */
Validator.prototype._normalizeString = function _normalizeString (rules) {
    var this$1 = this;

  var validations = {};
  rules.split('|').forEach(function (rule) {
    var parsedRule = this$1._parseRule(rule);
    if (! parsedRule.name) {
      return;
    }

    if (parsedRule.name === 'required') {
      validations.required = true;
    }

    validations[parsedRule.name] = parsedRule.params;
    if (date.installed && this$1._isADateRule(parsedRule.name)) {
      var dateFormat = this$1._getDateFormat(validations);

      if (! this$1._containsValidation(validations[parsedRule.name], dateFormat)) {
        validations[parsedRule.name].push(this$1._getDateFormat(validations));
      }
    }
  });

  return validations;
};

/**
 * Normalizes a string rule.
 *
 * @param {string} rule The rule to be normalized.
 * @return {object} rule The normalized rule.
 */
Validator.prototype._parseRule = function _parseRule (rule) {
  var params = [];
  var name = rule.split(':')[0];

  if (~rule.indexOf(':')) {
    params = rule.split(':').slice(1).join(':').split(',');
  }

  return { name: name, params: params };
};

/**
 * Formats an error message for field and a rule.
 *
 * @param{string} field The field name.
 * @param{object} rule Normalized rule object.
 * @param {object} data Additional Information about the validation result.
 * @param {string} scope The field scope.
 * @return {string} Formatted error message.
 */
Validator.prototype._formatErrorMessage = function _formatErrorMessage (field, rule, data, scope) {
    if ( data === void 0 ) data = {};
    if ( scope === void 0 ) scope = '__global__';

  var name = this._getFieldDisplayName(field, scope);
  var params = this._getLocalizedParams(rule, scope);
  // Defaults to english message.
  if (! this.dictionary.hasLocale(LOCALE)) {
    var msg$1 = this.dictionary.getFieldMessage('en', field, rule.name);

    return isCallable(msg$1) ? msg$1(name, params, data) : msg$1;
  }

  var msg = this.dictionary.getFieldMessage(LOCALE, field, rule.name);

  return isCallable(msg) ? msg(name, params, data) : msg;
};

/**
 * Translates the parameters passed to the rule (mainly for target fields).
 */
Validator.prototype._getLocalizedParams = function _getLocalizedParams (rule, scope) {
    if ( scope === void 0 ) scope = '__global__';

  if (~ ['after', 'before', 'confirmed'].indexOf(rule.name) &&
      rule.params && rule.params[0]) {
    var param = this.$scopes[scope][rule.params[0]];
    if (param && param.name) { return [param.name]; }
    return [this.dictionary.getAttribute(LOCALE, rule.params[0], rule.params[0])];
  }

  return rule.params;
};

/**
 * Resolves an appropiate display name, first checking 'data-as' or the registered 'prettyName'
 * Then the dictionary, then fallsback to field name.
 * @return {String} displayName The name to be used in the errors.
 */
Validator.prototype._getFieldDisplayName = function _getFieldDisplayName (field, scope) {
    if ( scope === void 0 ) scope = '__global__';

  return this.$scopes[scope][field].as || this.dictionary.getAttribute(LOCALE, field, field);
};

/**
 * Tests a single input value against a rule.
 *
 * @param{*} name The name of the field.
 * @param{*} valuethe value of the field.
 * @param{object} rule the rule object.
 * @param {scope} scope The field scope.
 * @return {boolean} Whether it passes the check.
 */
Validator.prototype._test = function _test (name, value, rule, scope) {
    var this$1 = this;
    if ( scope === void 0 ) scope = '__global__';

  var validator = Rules[rule.name];
  if (! validator || typeof validator !== 'function') {
    throw new ValidatorException(("No such validator '" + (rule.name) + "' exists."));
  }

  var result = validator(value, rule.params, name);

  // If it is a promise.
  if (isCallable(result.then)) {
    return result.then(function (values) {
      var allValid = true;
      var data = {};
      if (Array.isArray(values)) {
        allValid = values.every(function (t) { return t.valid; });
      } else { // Is a single object.
        allValid = values.valid;
        data = values.data;
      }

      if (! allValid) {
        this$1.errorBag.add(
                      name,
                      this$1._formatErrorMessage(name, rule, data, scope),
                      rule.name,
                      scope
                  );
      }

      return allValid;
    });
  }

  if (! isObject(result)) {
    result = { valid: result, data: {} };
  }

  if (! result.valid) {
    this.errorBag.add(
              name,
              this._formatErrorMessage(name, rule, result.data, scope),
              rule.name,
              scope
          );
  }

  return result.valid;
};

/**
 * Adds an event listener for a specific field.
 * @param {String} name
 * @param {String} fieldName
 * @param {Function} callback
 */
Validator.prototype.on = function on (name, fieldName, scope, callback) {
  if (! fieldName) {
    throw new ValidatorException(("Cannot add a listener for non-existent field " + fieldName + "."));
  }

  if (! isCallable(callback)) {
    throw new ValidatorException(("The " + name + " callback for field " + fieldName + " is not callable."));
  }

  this.$scopes[scope][fieldName].events[name] = callback;
};

/**
 * Removes the event listener for a specific field.
 * @param {String} name
 * @param {String} fieldName
 */
Validator.prototype.off = function off (name, fieldName, scope) {
  if (! fieldName) {
    warn(("Cannot remove a listener for non-existent field " + fieldName + "."));
  }

  this.$scopes[scope][fieldName].events[name] = undefined;
};

Validator.prototype._assignFlags = function _assignFlags (field) {
  field.flags = {
    untouched: true,
    touched: false,
    dirty: false,
    pristine: true,
    valid: null,
    invalid: null,
    required: field.required,
    pending: false
  };

  var flagObj = {};
    flagObj[field.name] = field.flags;
  if (field.scope === '__global__') {
    this.fieldBag = assign({}, this.fieldBag, flagObj);
    return;
  }

  var scopeObj = assign({}, this.fieldBag[("$" + (field.scope))], flagObj);

  this.fieldBag = assign({}, this.fieldBag, ( obj = {}, obj[("$" + (field.scope))] = scopeObj, obj ));
    var obj;
};

/**
 * Registers a field to be validated.
 *
 * @param{string} name The field name.
 * @param{String|Array|Object} checks validations expression.
 * @param {string} prettyName Custom name to be used as field name in error messages.
 * @param {Function} getter A function used to retrive a fresh value for the field.
 */
Validator.prototype.attach = function attach (name, checks, options) {
    var this$1 = this;
    if ( options === void 0 ) options = {};

  var attach = function () {
    options.scope = this$1._resolveScope(options.scope);
    this$1.updateField(name, checks, options);
    var field = this$1.$scopes[options.scope][name];
    field.scope = options.scope;
    field.name = name;
    field.as = options.prettyName;
    field.getter = options.getter;
    field.context = options.context;
    field.listeners = options.listeners || { detach: function detach() {} };
    field.el = field.listeners.el;
    field.events = {};
    this$1._assignFlags(field);
    // cache the scope property.
    if (field.el && isCallable(field.el.setAttribute)) {
      field.el.setAttribute('data-vv-scope', field.scope);
    }

    if (field.listeners.classes) {
      field.listeners.classes.attach(field);
    }
    this$1._setAriaRequiredAttribute(field);
    this$1._setAriaValidAttribute(field, true);
    // if initial modifier is applied, validate immediatly.
    if (options.initial) {
      this$1.validate(name, field.getter(field.context()), field.scope).catch(function () {});
    }
  };

  var scope = isCallable(options.scope) ? options.scope() : options.scope;
  if (! scope && ! this.$ready) {
    this.$deferred.push(attach);
    return;
  }

  attach();
};

/**
 * Initializes the non-scoped fields and any bootstrap logic.
 */
Validator.prototype.init = function init () {
  this.$ready = true;
  this.$deferred.forEach(function (attach) {
    attach();
  });
  this.$deferred = [];

  return this;
};

/**
 * Sets the flags on a field.
 *
 * @param {String} name
 * @param {Object} flags
 */
Validator.prototype.flag = function flag (name, flags) {
  var ref = name.split('.');
    var scope = ref[0];
    var fieldName = ref[1];
  if (!fieldName) {
    fieldName = scope;
    scope = null;
  }
  var field = scope ? getPath((scope + "." + fieldName), this.$scopes) :
                        this.$scopes.__global__[fieldName];
  if (! field) {
    return;
  }

  Object.keys(field.flags).forEach(function (flag) {
    field.flags[flag] = flags[flag] !== undefined ? flags[flag] : field.flags[flag];
  });
  field.listeners.classes.sync();
};

/**
 * Append another validation to an existing field.
 *
 * @param{string} name The field name.
 * @param{string} checks validations expression.
 */
Validator.prototype.append = function append (name, checks, options) {
    if ( options === void 0 ) options = {};

  options.scope = this._resolveScope(options.scope);
  // No such field
  if (! this.$scopes[options.scope] || ! this.$scopes[options.scope][name]) {
    this.attach(name, checks, options);
  }

  var field = this.$scopes[options.scope][name];
  var newChecks = this._normalizeRules(name, checks, options.scope);
  Object.keys(newChecks).forEach(function (key) {
    field.validations[key] = newChecks[key];
  });
};

/**
 * Updates the field rules with new ones.
 */
Validator.prototype.updateField = function updateField (name, checks, options) {
    if ( options === void 0 ) options = {};

  var field = getPath(((options.scope) + "." + name), this.$scopes, null);
  var oldChecks = field ? JSON.stringify(field.validations) : '';
  this._createField(name, checks, options.scope);
  field = getPath(((options.scope) + "." + name), this.$scopes, null);
  var newChecks = field ? JSON.stringify(field.validations) : '';

  // compare both newChecks and oldChecks to make sure we don't trigger uneccessary directive
  // update by changing the errorBag (prevents infinite loops).
  if (newChecks !== oldChecks) {
    this.errorBag.remove(name, options.scope);
  }
};

/**
 * Clears the errors from the errorBag using the next tick if possible.
 */
Validator.prototype.clean = function clean () {
    var this$1 = this;

  if (! this.$vm || ! isCallable(this.$vm.$nextTick)) {
    return;
  }

  this.$vm.$nextTick(function () {
    this$1.errorBag.clear();
  });
};

/**
 * Removes a field from the validator.
 *
 * @param{String} name The name of the field.
 * @param {String} scope The name of the field scope.
 */
Validator.prototype.detach = function detach (name, scope) {
    if ( scope === void 0 ) scope = '__global__';

  // No such field.
  if (! this.$scopes[scope] || ! this.$scopes[scope][name]) {
    return;
  }

  if (this.$scopes[scope][name].listeners) {
    this.$scopes[scope][name].listeners.detach();
  }

  this.errorBag.remove(name, scope);
  delete this.$scopes[scope][name];
};

/**
 * Adds a custom validator to the list of validation rules.
 *
 * @param{string} name The name of the validator.
 * @param{object|function} validator The validator object/function.
 */
Validator.prototype.extend = function extend (name, validator) {
  Validator.extend(name, validator);
};

/**
 * Gets the internal errorBag instance.
 *
 * @return {ErrorBag} errorBag The internal error bag object.
 */
Validator.prototype.getErrors = function getErrors () {
  return this.errorBag;
};

/**
 * Just an alias to the static method for convienece.
 */
Validator.prototype.installDateTimeValidators = function installDateTimeValidators (moment) {
  Validator.installDateTimeValidators(moment);
};

/**
 * Removes a rule from the list of validators.
 * @param {String} name The name of the validator/rule.
 */
Validator.prototype.remove = function remove (name) {
  Validator.remove(name);
};

/**
 * Sets the validator current langauge.
 *
 * @param {string} language locale or language id.
 */
Validator.prototype.setLocale = function setLocale (language) {
  /* istanbul ignore if */
  if (! this.dictionary.hasLocale(language)) {
    // eslint-disable-next-line
    warn('You are setting the validator locale to a locale that is not defined in the dicitionary. English messages may still be generated.');
  }

  LOCALE = language;
};

/**
 * Sets the operating mode for this validator.
 * strictMode = true: Values without a rule are invalid and cause failure.
 * strictMode = false: Values without a rule are valid and are skipped.
 * @param {Boolean} strictMode.
 */
Validator.prototype.setStrictMode = function setStrictMode (strictMode) {
    if ( strictMode === void 0 ) strictMode = true;

  this.strictMode = strictMode;
};

/**
 * Updates the messages dicitionary, overwriting existing values and adding new ones.
 *
 * @param{object} data The messages object.
 */
Validator.prototype.updateDictionary = function updateDictionary (data) {
  Validator.updateDictionary(data);
};

/**
 * Adds a scope.
 */
Validator.prototype.addScope = function addScope (scope) {
  if (scope && ! this.$scopes[scope]) {
    this.$scopes[scope] = {};
  }
};

/**
 * Validates a value against a registered field validations.
 *
 * @param{string} name the field name.
 * @param{*} value The value to be validated.
 * @param {String} scope The scope of the field.
 * @param {Boolean} throws If it should throw.
 * @return {Promise}
 */
Validator.prototype.validate = function validate (name, value, scope, throws) {
    var this$1 = this;
    if ( scope === void 0 ) scope = '__global__';
    if ( throws === void 0 ) throws = true;

  if (this.paused) { return Promise.resolve(true); }

  if (name && name.indexOf('.') > -1) {
    // no such field, try the scope form.
    if (! this.$scopes.__global__[name]) {
      var assign$$1;
        (assign$$1 = name.split('.'), scope = assign$$1[0], name = assign$$1[1]);
    }
  }
  if (! scope) { scope = '__global__'; }
  if (! this.$scopes[scope] || ! this.$scopes[scope][name]) {
    if (! this.strictMode) { return Promise.resolve(true); }

    var fullName = scope === '__global__' ? name : (scope + "." + name);
    warn(("Validating a non-existant field: \"" + fullName + "\". Use \"attach()\" first."));

    throw new ValidatorException('Validation Failed');
  }

  var field = this.$scopes[scope][name];
  if (field.flags) {
    field.flags.pending = true;
  }
  this.errorBag.remove(name, scope);
  // if its not required and is empty or null or undefined then it passes.
  if (! field.required && ~[null, undefined, ''].indexOf(value)) {
    this._setAriaValidAttribute(field, true);
    if (field.events && isCallable(field.events.after)) {
      field.events.after({ valid: true });
    }

    return Promise.resolve(true);
  }

  try {
    var promises = Object.keys(field.validations).map(function (rule) {
      var result = this$1._test(
        name,
        value,
        { name: rule, params: field.validations[rule] },
        scope
      );

      if (isCallable(result.then)) {
        return result;
      }

      // Early exit.
      if (! result) {
        if (field.events && isCallable(field.events.after)) {
          field.events.after({ valid: false });
        }
        throw new ValidatorException('Validation Aborted.');
      }

      if (field.events && isCallable(field.events.after)) {
        field.events.after({ valid: true });
      }
      return Promise.resolve(result);
    });

    return Promise.all(promises).then(function (values) {
      var valid = values.every(function (t) { return t; });
      this$1._setAriaValidAttribute(field, valid);

      if (! valid && throws) {
        if (field.events && isCallable(field.events.after)) {
          field.events.after({ valid: false });
        }
        throw new ValidatorException('Failed Validation');
      }
      return valid;
    });
  } catch (error) {
    if (error.msg === '[vee-validate]: Validation Aborted.') {
      if (field.events && isCallable(field.events.after)) {
        field.events.after({ valid: false });
      }
      return Promise.resolve(false);
    }

    throw error;
  }
};

/**
 * Sets the aria-invalid attribute on the element.
 */
Validator.prototype._setAriaValidAttribute = function _setAriaValidAttribute (field, valid) {
  if (! field.el || field.listeners.component) {
    return;
  }

  field.el.setAttribute('aria-invalid', !valid);
};

/**
 * Sets the aria-required attribute on the element.
 */
Validator.prototype._setAriaRequiredAttribute = function _setAriaRequiredAttribute (field) {
  if (! field.el || field.listeners.component) {
    return;
  }

  field.el.setAttribute('aria-required', !! field.required);
};

/**
 * Pauses the validator.
 *
 * @return {Validator}
 */
Validator.prototype.pause = function pause () {
  this.paused = true;

  return this;
};

/**
 * Resumes the validator.
 *
 * @return {Validator}
 */
Validator.prototype.resume = function resume () {
  this.paused = false;

  return this;
};

/**
 * Validates each value against the corresponding field validations.
 * @param{object} values The values to be validated.
 * @param{String} scope The scope to be applied on validation.
 * @return {Promise} Returns a promise with the validation result.
 */
Validator.prototype.validateAll = function validateAll (values, scope) {
    var this$1 = this;
    if ( scope === void 0 ) scope = '__global__';

  if (this.paused) { return Promise.resolve(true); }

  var normalizedValues;
  if (! values || typeof values === 'string') {
    this.errorBag.clear(values);
    normalizedValues = this._resolveValuesFromGetters(values);
  } else {
    normalizedValues = {};
    Object.keys(values).forEach(function (key) {
      normalizedValues[key] = {
        value: values[key],
        scope: scope
      };
    });
  }
  var promises = Object.keys(normalizedValues).map(function (property) { return this$1.validate(
    property,
    normalizedValues[property].value,
    normalizedValues[property].scope,
    false // do not throw
  ); });

  return Promise.all(promises).then(function (results) {
    var valid = results.every(function (t) { return t; });
    if (! valid) {
      throw new ValidatorException('Validation Failed');
    }

    return valid;
  });
};

/**
 * Validates all scopes.
 * @returns {Promise} All promises resulted from each scope.
 */
Validator.prototype.validateScopes = function validateScopes () {
    var this$1 = this;

  if (this.paused) { return Promise.resolve(true); }

  return Promise.all(
    Object.keys(this.$scopes).map(function (scope) { return this$1.validateAll(scope); })
  );
};

Object.defineProperties( Validator.prototype, prototypeAccessors );

var validatorRequested = function (injections) {
  if (! injections) {
    return false;
  }

  if (Array.isArray(injections) && ~injections.indexOf('$validator')) {
    return true;
  }

  if (isObject(injections) && injections.$validator) {
    return true;
  }

  return false;
};

var makeMixin = function (Vue, options) {
  var mixin = {};
  mixin.provide = function providesValidator() {
    if (this.$validator) {
      return {
        $validator: this.$validator
      };
    }

    return {};
  };

  mixin.beforeCreate = function beforeCreate() {
    // if its a root instance, inject anyways, or if it requested a new instance.
    if (this.$options.$validates || !this.$parent) {
      this.$validator = new Validator(null, { init: false, vm: this });
    }

    var requested = validatorRequested(this.$options.inject);

    // if automatic injection is enabled and no instance was requested.
    if (! this.$validator && options.inject && !requested) {
      this.$validator = new Validator(null, { init: false, vm: this });
    }

    // don't inject errors or fieldBag as no validator was resolved.
    if (! requested && ! this.$validator) {
      return;
    }

    // There is a validator but it isn't injected, mark as reactive.
    if (! requested && this.$validator) {
      Vue.util.defineReactive(this.$validator, 'errorBag', this.$validator.errorBag);
      Vue.util.defineReactive(this.$validator, 'fieldBag', this.$validator.fieldBag);
    }

    if (! this.$options.computed) {
      this.$options.computed = {};
    }

    this.$options.computed[options.errorBagName] = function errorBagGetter() {
      return this.$validator.errorBag;
    };
    this.$options.computed[options.fieldsBagName] = function fieldBagGetter() {
      return this.$validator.fieldBag;
    };
  };

  mixin.mounted = function mounted() {
    if (this.$validator) {
      this.$validator.init();
    }
  };

  return mixin;
};

var DEFAULT_CLASS_NAMES = {
  touched: 'touched', // the control has been blurred
  untouched: 'untouched', // the control hasn't been blurred
  valid: 'valid', // model is valid
  invalid: 'invalid', // model is invalid
  pristine: 'pristine', // control has not been interacted with
  dirty: 'dirty' // control has been interacted with
};

var ClassListener = function ClassListener(el, validator, options) {
  if ( options === void 0 ) options = {};

  this.el = el;
  this.validator = validator;
  this.enabled = options.enableAutoClasses;
  this.classNames = assign({}, DEFAULT_CLASS_NAMES, options.classNames || {});
  this.component = options.component;
  this.listeners = {};
};

/**
 * Resets the classes state.
 */
ClassListener.prototype.reset = function reset () {
  // detach all listeners.
  this.detach();

  // remove classes
  this.remove(this.classNames.dirty);
  this.remove(this.classNames.touched);
  this.remove(this.classNames.valid);
  this.remove(this.classNames.invalid);

  // listen again.
  this.attach(this.field);
};

/**
 * Syncs the automatic classes.
 */
ClassListener.prototype.sync = function sync () {
  this.addInteractionListeners();

  if (! this.enabled) { return; }

  this.toggle(this.classNames.dirty, this.field.flags.dirty);
  this.toggle(this.classNames.pristine, this.field.flags.pristine);
  this.toggle(this.classNames.valid, this.field.flags.valid);
  this.toggle(this.classNames.invalid, this.field.flags.invalid);
  this.toggle(this.classNames.touched, this.field.flags.touched);
  this.toggle(this.classNames.untouched, this.field.flags.untouched);
};

ClassListener.prototype.addFocusListener = function addFocusListener () {
    var this$1 = this;

  // listen for focus event.
  this.listeners.focus = function () {
    this$1.remove(this$1.classNames.untouched);
    this$1.add(this$1.classNames.touched);
    this$1.field.flags.touched = true;
    this$1.field.flags.untouched = false;

    if (this$1.component) { return; }

    // only needed once.
    this$1.el.removeEventListener('focus', this$1.listeners.focus);
    this$1.listeners.focus = null;
  };

  if (this.component) {
    this.component.$once('focus', this.listeners.focus);
  } else {
    this.el.addEventListener('focus', this.listeners.focus);
  }
};

ClassListener.prototype.addInputListener = function addInputListener () {
    var this$1 = this;

  // listen for input.
  this.listeners.input = function () {
    this$1.remove(this$1.classNames.pristine);
    this$1.add(this$1.classNames.dirty);
    this$1.field.flags.dirty = true;
    this$1.field.flags.pristine = false;

    if (this$1.component) { return; }

    // only needed once.
    this$1.el.removeEventListener('input', this$1.listeners.input);
    this$1.listeners.input = null;
  };

  if (this.component) {
    this.component.$once('input', this.listeners.input);
  } else {
    this.el.addEventListener('input', this.listeners.input);
  }
};

ClassListener.prototype.addInteractionListeners = function addInteractionListeners () {
  if (! this.listeners.focus) {
    this.addFocusListener();
  }

  if (! this.listeners.input) {
    this.addInputListener();
  }
};

/**
 * Attach field with its listeners.
 * @param {*} field
 */
ClassListener.prototype.attach = function attach (field) {
    var this$1 = this;

  this.field = field;
  this.add(this.classNames.pristine);
  this.add(this.classNames.untouched);

  this.addInteractionListeners();

  this.listeners.after = function (e) {
    this$1.remove(e.valid ? this$1.classNames.invalid : this$1.classNames.valid);
    this$1.add(e.valid ? this$1.classNames.valid : this$1.classNames.invalid);
    this$1.field.flags.valid = e.valid;
    this$1.field.flags.invalid = ! e.valid;
    this$1.field.flags.pending = false;
  };

  this.validator.on('after', this.field.name, this.field.scope, this.listeners.after);
};

/**
 * Detach all listeners.
 */
ClassListener.prototype.detach = function detach () {
  // TODO: Why could the field be undefined?
  if (! this.field) { return; }

  if (this.component) {
    this.component.$off('input', this.listeners.input);
    this.component.$off('focus', this.listeners.focus);
  } else {
    this.el.removeEventListener('focus', this.listeners.focus);
    this.el.removeEventListener('input', this.listeners.input);
  }
  this.validator.off('after', this.field.name, this.field.scope);
};

/**
 * Add a class.
 * @param {*} className
 */
ClassListener.prototype.add = function add (className) {
  if (! this.enabled) { return; }

  addClass(this.el, className);
};

/**
 * Remove a class.
 * @param {*} className
 */
ClassListener.prototype.remove = function remove (className) {
  if (! this.enabled) { return; }

  removeClass(this.el, className);
};

/**
 * Toggles the class name.
 *
 * @param {String} className
 * @param {Boolean} status
 */
ClassListener.prototype.toggle = function toggle (className, status) {
  if (status) {
    this.add(className);
    return;
  }

  this.remove(className);
};

var config = {
  locale: 'en',
  delay: 0,
  errorBagName: 'errors',
  dictionary: null,
  strict: true,
  fieldsBagName: 'fields',
  enableAutoClasses: false,
  classNames: {},
  events: 'input|blur',
  inject: true
};

var ListenerGenerator = function ListenerGenerator(el, binding, vnode, options) {
  this.unwatch = undefined;
  this.callbacks = [];
  this.el = el;
  this.scope = isObject(binding.value) ? binding.value.scope : getScope(el);
  this.binding = binding;
  this.vm = vnode.context;
  this.component = vnode.child;
  this.options = assign({}, config, options);
  this.fieldName = this._resolveFieldName();
  this.model = this._resolveModel(vnode.data.directives);
  this.classes = new ClassListener(el, this.vm.$validator, {
    component: this.component,
    enableAutoClasses: options.enableAutoClasses,
    classNames: options.classNames
  });
};

/**
 * Checks if the node directives contains a v-model.
 */
ListenerGenerator.prototype._resolveModel = function _resolveModel (directives) {
  var expRegex = /^[a-z_]+[0-9]*(\w*\.[a-z_]\w*)*$/i;
  var model = find(directives, function (d) { return d.name === 'model' && expRegex.test(d.expression); });

  return model && this._isExistingPath(model.expression) && model.expression;
};

/**
 * @param {String} path
 */
ListenerGenerator.prototype._isExistingPath = function _isExistingPath (path) {
  var obj = this.vm;
  return path.split('.').every(function (prop) {
    if (! Object.prototype.hasOwnProperty.call(obj, prop)) {
      return false;
    }

    obj = obj[prop];

    return true;
  });
};

  /**
   * Resolves the field name to trigger validations.
   * @return {String} The field name.
   */
ListenerGenerator.prototype._resolveFieldName = function _resolveFieldName () {
  if (this.component) {
    return getDataAttribute(this.el, 'name') || this.component.name;
  }

  return getDataAttribute(this.el, 'name') || this.el.name;
};

  /**
   * Determines if the validation rule requires additional listeners on target fields.
   */
ListenerGenerator.prototype._hasFieldDependency = function _hasFieldDependency (rules) {
    var this$1 = this;

  var fieldName = false;
  if (! rules) {
    return false;
  }

  if (isObject(rules)) {
    Object.keys(rules).forEach(function (r) { // eslint-disable-line
      if (/confirmed|after|before/.test(r)) {
        fieldName = rules[r];

        return false;
      }
    });

    return fieldName;
  }

  rules.split('|').every(function (r) {
    if (/\b(confirmed|after|before):/.test(r)) {
      fieldName = r.split(':')[1];
      return false;
    }

    if (/\b(confirmed)/.test(r)) {
      fieldName = (this$1.fieldName) + "_confirmation";
      return false;
    }

    return true;
  });

  return fieldName;
};

  /**
   * Validates input value, triggered by 'input' event.
   */
ListenerGenerator.prototype._inputListener = function _inputListener () {
  return this._validate(this.el.value);
};

  /**
   * Validates files, triggered by 'change' event.
   */
ListenerGenerator.prototype._fileListener = function _fileListener () {
    var this$1 = this;

  return this._validate(toArray(this.el.files)).then(function (isValid) {
    if (! isValid && this$1.binding.modifiers.reject) {
      this$1.el.value = '';
    }
  });
};

  /**
   * Validates radio buttons, triggered by 'change' event.
   */
ListenerGenerator.prototype._radioListener = function _radioListener () {
  var checked = document.querySelector(("input[name=\"" + (this.el.name) + "\"]:checked"));
  return this._validate(checked ? checked.value : null);
};

  /**
   * Validates checkboxes, triggered by change event.
   */
ListenerGenerator.prototype._checkboxListener = function _checkboxListener () {
    var this$1 = this;

  var checkedBoxes = document.querySelectorAll(("input[name=\"" + (this.el.name) + "\"]:checked"));
  if (! checkedBoxes || ! checkedBoxes.length) {
    this._validate(null);
    return;
  }

  toArray(checkedBoxes).forEach(function (box) {
    this$1._validate(box.value);
  });
};

  /**
   * Trigger the validation for a specific value.
   */
ListenerGenerator.prototype._validate = function _validate (value) {
  return this.vm.$validator.validate(
    this.fieldName, value, this.scope || getScope(this.el)
    ).catch(function (result) { return result; });
};

  /**
   * Returns a scoped callback, only runs if the el scope is the same as the recieved scope
   * From the event.
   */
ListenerGenerator.prototype._getScopedListener = function _getScopedListener (callback) {
    var this$1 = this;

  return function (scope) {
    if (! scope || scope === this$1.scope || scope instanceof window.Event) {
      callback();
    }
  };
};

  /**
   * Attaches validator event-triggered validation.
   */
ListenerGenerator.prototype._attachValidatorEvent = function _attachValidatorEvent () {
    var this$1 = this;

  var listener = this._getScopedListener(this._getSuitableListener().listener.bind(this));
  var fieldName = this._hasFieldDependency(
      getRules(this.binding.expression, this.binding.value, this.el)
    );
  if (fieldName) {
          // Wait for the validator ready triggered when vm is mounted because maybe
          // the element isn't mounted yet.
    this.vm.$nextTick(function () {
      var target = document.querySelector(("input[name='" + fieldName + "']"));
      if (! target) {
        warn('Cannot find target field, no additional listeners were attached.');
        return;
      }

      var events = getDataAttribute(this$1.el, 'validate-on') || this$1.options.events;
      events.split('|').forEach(function (e) {
        target.addEventListener(e, listener, false);
        this$1.callbacks.push({ name: e, listener: listener, el: target });
      });
    });
  }
};

  /**
   * Determines a suitable listener for the element.
   */
ListenerGenerator.prototype._getSuitableListener = function _getSuitableListener () {
  var listener;
  var overrides = {
    input: 'input',
    blur: 'blur'
  };

  if (this.el.tagName === 'SELECT') {
    overrides.input = 'change';
    listener = {
      names: ['change', 'blur'],
      listener: this._inputListener
    };
  } else {
    // determine the suitable listener and events to handle
    switch (this.el.type) {
    case 'file':
      overrides.input = 'change';
      overrides.blur = null;
      listener = {
        names: ['change'],
        listener: this._fileListener
      };
      break;

    case 'radio':
      overrides.input = 'change';
      overrides.blur = null;
      listener = {
        names: ['change'],
        listener: this._radioListener
      };
      break;

    case 'checkbox':
      overrides.input = 'change';
      overrides.blur = null;
      listener = {
        names: ['change'],
        listener: this._checkboxListener
      };
      break;

    default:
      listener = {
        names: ['input', 'blur'],
        listener: this._inputListener
      };
      break;
    }
  }
  // users are able to specify which events they want to validate on
  var events = getDataAttribute(this.el, 'validate-on') || this.options.events;
  listener.names = events.split('|')
                         .filter(function (e) { return overrides[e] !== null; })
                         .map(function (e) { return overrides[e] || e; });

  return listener;
};

/**
 * Attaches neccessary validation events for the component.
 */
ListenerGenerator.prototype._attachComponentListeners = function _attachComponentListeners () {
    var this$1 = this;

  this.componentListener = debounce(function (value) {
    this$1._validate(value);
  }, getDataAttribute(this.el, 'delay') || this.options.delay);

  this.component.$on('input', this.componentListener);
  this.componentPropUnwatch = this.component.$watch('value', this.componentListener);
};

/**
 * Attachs a suitable listener for the input.
 */
ListenerGenerator.prototype._attachFieldListeners = function _attachFieldListeners () {
    var this$1 = this;

  // If it is a component, use vue events instead.
  if (this.component) {
    this._attachComponentListeners();

    return;
  }

  var handler = this._getSuitableListener();
  var listener = debounce(
    handler.listener.bind(this),
    getDataAttribute(this.el, 'delay') || this.options.delay
  );

  if (~['radio', 'checkbox'].indexOf(this.el.type)) {
    this.vm.$nextTick(function () {
      var elms = document.querySelectorAll(("input[name=\"" + (this$1.el.name) + "\"]"));
      toArray(elms).forEach(function (input) {
        handler.names.forEach(function (handlerName) {
          input.addEventListener(handlerName, listener, false);
          this$1.callbacks.push({ name: handlerName, listener: listener, el: input });
        });
      });
    });

    return;
  }

  handler.names.forEach(function (handlerName) {
    this$1.el.addEventListener(handlerName, listener, false);
    this$1.callbacks.push({ name: handlerName, listener: listener, el: this$1.el });
  });
};

/**
 * Returns a context, getter factory pairs for each input type.
 */
ListenerGenerator.prototype._resolveValueGetter = function _resolveValueGetter () {
    var this$1 = this;

  if (this.component) {
    return {
      context: function () { return this$1.component; },
      getter: function getter(context) {
        return context.value;
      }
    };
  }

  switch (this.el.type) {
  case 'checkbox': return {
    context: function () { return document.querySelectorAll(("input[name=\"" + (this$1.el.name) + "\"]:checked")); },
    getter: function getter(context) {
      if (! context || ! context.length) {
        return null;
      }

      return toArray(context).map(function (checkbox) { return checkbox.value; });
    }
  };
  case 'radio': return {
    context: function () { return document.querySelector(("input[name=\"" + (this$1.el.name) + "\"]:checked")); },
    getter: function getter(context) {
      return context && context.value;
    }
  };
  case 'file': return {
    context: function () { return this$1.el; },
    getter: function getter(context) {
      return toArray(context.files);
    }
  };

  default: return {
    context: function () { return this$1.el; },
    getter: function getter(context) {
      return context.value;
    }
  };
  }
};

/*
* Gets the arg string value, either from the directive or the expression value.
*/
ListenerGenerator.prototype._getArg = function _getArg () {
  // Get it from the directive arg.
  if (this.binding.arg) {
    return this.binding.arg;
  }

  // Get it from v-model.
  if (this.model) {
    return this.model;
  }

  return isObject(this.binding.value) ? this.binding.value.arg : null;
};

/**
 * Attaches model watchers and extra listeners.
 */
ListenerGenerator.prototype._attachModelWatcher = function _attachModelWatcher (arg) {
    var this$1 = this;

  var events = getDataAttribute(this.el, 'validate-on') || this.options.events;
  var listener = debounce(
    this._getSuitableListener().listener.bind(this),
    getDataAttribute(this.el, 'delay') || this.options.delay
  );
  events.split('|').forEach(function (name) {
    if (~['input', 'change'].indexOf(name)) {
      var debounced = debounce(function (value) {
        this$1.vm.$validator.validate(
          this$1.fieldName, value, this$1.scope || getScope(this$1.el)
        ).catch(function (result) { return result; });
      }, getDataAttribute(this$1.el, 'delay') || this$1.options.delay);
      this$1.unwatch = this$1.vm.$watch(arg, debounced, { deep: true });
      // No need to attach it on element as it will use the vue watcher.
      return;
    }

    this$1.el.addEventListener(name, listener, false);
    this$1.callbacks.push({ name: name, listener: listener, el: this$1.el });
  });
};

/**
 * Attaches the Event Listeners.
 */
ListenerGenerator.prototype.attach = function attach () {
    var this$1 = this;

  var ref = this._resolveValueGetter();
    var context = ref.context;
    var getter = ref.getter;
  this.vm.$validator.attach(
    this.fieldName,
    getRules(this.binding.expression, this.binding.value, this.el), {
      // eslint-disable-next-line
      scope: function () {
        return this$1.scope || getScope(this$1.el);
      },
      prettyName: getDataAttribute(this.el, 'as') || this.el.title,
      context: context,
      getter: getter,
      listeners: this,
      initial: this.binding.modifiers.initial
    }
  );

  if (this.binding.modifiers.disable) {
    return;
  }

  this._attachValidatorEvent();
  var arg = this._getArg();
  if (arg) {
    this._attachModelWatcher(arg);
    return;
  }

  this._attachFieldListeners();
};

  /**
   * Removes all attached event listeners.
   */
ListenerGenerator.prototype.detach = function detach () {
  if (this.component) {
    this.component.$off('input', this.componentListener);

    if (isCallable(this.componentPropUnwatch)) {
      this.componentPropUnwatch();
    }
  }

  if (this.unwatch) {
    this.unwatch();
  }

  this.classes.detach();

  this.callbacks.forEach(function (h) {
    h.el.removeEventListener(h.name, h.listener);
  });
  this.callbacks = [];
};

var listenersInstances = [];

var makeDirective = function (options) { return ({
  inserted: function inserted(el, binding, vnode) {
    if (! vnode.context.$validator) {
      var name = vnode.context.$options._componentTag;
      // eslint-disable-next-line
      warn(("No validator instance is present on " + (name ?'component "' +  name + '"' : 'un-named component') + ", did you forget to inject '$validator'?"));

      return;
    }
    var listener = new ListenerGenerator(el, binding, vnode, options);
    listener.attach();
    listenersInstances.push({ vm: vnode.context, el: el, instance: listener });
  },
  update: function update(el, ref, ref$1) {
    var expression = ref.expression;
    var value = ref.value;
    var context = ref$1.context;

    var ref$2 = find(listenersInstances, function (l) { return l.vm === context && l.el === el; });
    var instance = ref$2.instance;
    // make sure we don't do uneccessary work if no expression was passed
    // nor if the expression did not change.
    if (! expression || (instance.cachedExp === JSON.stringify(value))) { return; }

    instance.cachedExp = JSON.stringify(value);
    var scope = isObject(value) ? (value.scope || getScope(el)) : getScope(el);
    context.$validator.updateField(
      instance.fieldName,
      getRules(expression, value, el),
      { scope: scope || '__global__' }
    );
  },
  unbind: function unbind(el, ref, ref$1) {
    var value = ref.value;
    var context = ref$1.context;

    var holder = find(listenersInstances, function (l) { return l.vm === context && l.el === el; });
    if (typeof holder === 'undefined') {
      return;
    }

    var scope = isObject(value) ? value.scope : (getScope(el) || '__global__');
    context.$validator.detach(holder.instance.fieldName, scope);
    listenersInstances.splice(listenersInstances.indexOf(holder), 1);
  }
}); };

var normalize = function (fields) {
  if (Array.isArray(fields)) {
    return fields.reduce(function (prev, curr) {
      if (~curr.indexOf('.')) {
        prev[curr.split('.')[1]] = curr;
      } else {
        prev[curr] = curr;
      }

      return prev;
    }, {});
  }

  return fields;
};

/**
 * Maps fields to computed functions.
 *
 * @param {Array|Object} fields
 */
var mapFields = function (fields) {
  var normalized = normalize(fields);
  return Object.keys(normalized).reduce(function (prev, curr) {
    var field = normalized[curr];
    prev[curr] = function mappedField() {
      if (this.$validator.fieldBag[field]) {
        return this.$validator.fieldBag[field];
      }

      var index = field.indexOf('.');
      if (index <= 0) {
        return {};
      }
      var ref = field.split('.');
      var scope = ref[0];
      var name = ref[1];

      return getPath(("$" + scope + "." + name), this.$validator.fieldBag, {});
    };

    return prev;
  }, {});
};

// eslint-disable-next-line
var install = function (Vue, options) {
  var config$$1 = assign({}, config, options);
  if (config$$1.dictionary) {
    Validator.updateDictionary(config$$1.dictionary);
  }

  Validator.setLocale(config$$1.locale);
  Validator.setStrictMode(config$$1.strict);

  Vue.mixin(makeMixin(Vue, config$$1));
  Vue.directive('validate', makeDirective(config$$1));
};

var index = {
  install: install,
  mapFields: mapFields,
  Validator: Validator,
  ErrorBag: ErrorBag,
  Rules: Rules,
  version: '2.0.0-rc.5'
};

return index;

})));

},{}],3:[function(require,module,exports){
(function (global){
/*!
 * Vue.js v2.3.4
 * (c) 2014-2017 Evan You
 * Released under the MIT License.
 */
(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(global.Vue = factory());
}(this, (function () { 'use strict';

/*  */

// these helpers produces better vm code in JS engines due to their
// explicitness and function inlining
function isUndef (v) {
  return v === undefined || v === null
}

function isDef (v) {
  return v !== undefined && v !== null
}

function isTrue (v) {
  return v === true
}

function isFalse (v) {
  return v === false
}
/**
 * Check if value is primitive
 */
function isPrimitive (value) {
  return typeof value === 'string' || typeof value === 'number'
}

/**
 * Quick object check - this is primarily used to tell
 * Objects from primitive values when we know the value
 * is a JSON-compliant type.
 */
function isObject (obj) {
  return obj !== null && typeof obj === 'object'
}

var _toString = Object.prototype.toString;

/**
 * Strict object type check. Only returns true
 * for plain JavaScript objects.
 */
function isPlainObject (obj) {
  return _toString.call(obj) === '[object Object]'
}

function isRegExp (v) {
  return _toString.call(v) === '[object RegExp]'
}

/**
 * Convert a value to a string that is actually rendered.
 */
function toString (val) {
  return val == null
    ? ''
    : typeof val === 'object'
      ? JSON.stringify(val, null, 2)
      : String(val)
}

/**
 * Convert a input value to a number for persistence.
 * If the conversion fails, return original string.
 */
function toNumber (val) {
  var n = parseFloat(val);
  return isNaN(n) ? val : n
}

/**
 * Make a map and return a function for checking if a key
 * is in that map.
 */
function makeMap (
  str,
  expectsLowerCase
) {
  var map = Object.create(null);
  var list = str.split(',');
  for (var i = 0; i < list.length; i++) {
    map[list[i]] = true;
  }
  return expectsLowerCase
    ? function (val) { return map[val.toLowerCase()]; }
    : function (val) { return map[val]; }
}

/**
 * Check if a tag is a built-in tag.
 */
var isBuiltInTag = makeMap('slot,component', true);

/**
 * Remove an item from an array
 */
function remove (arr, item) {
  if (arr.length) {
    var index = arr.indexOf(item);
    if (index > -1) {
      return arr.splice(index, 1)
    }
  }
}

/**
 * Check whether the object has the property.
 */
var hasOwnProperty = Object.prototype.hasOwnProperty;
function hasOwn (obj, key) {
  return hasOwnProperty.call(obj, key)
}

/**
 * Create a cached version of a pure function.
 */
function cached (fn) {
  var cache = Object.create(null);
  return (function cachedFn (str) {
    var hit = cache[str];
    return hit || (cache[str] = fn(str))
  })
}

/**
 * Camelize a hyphen-delimited string.
 */
var camelizeRE = /-(\w)/g;
var camelize = cached(function (str) {
  return str.replace(camelizeRE, function (_, c) { return c ? c.toUpperCase() : ''; })
});

/**
 * Capitalize a string.
 */
var capitalize = cached(function (str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
});

/**
 * Hyphenate a camelCase string.
 */
var hyphenateRE = /([^-])([A-Z])/g;
var hyphenate = cached(function (str) {
  return str
    .replace(hyphenateRE, '$1-$2')
    .replace(hyphenateRE, '$1-$2')
    .toLowerCase()
});

/**
 * Simple bind, faster than native
 */
function bind (fn, ctx) {
  function boundFn (a) {
    var l = arguments.length;
    return l
      ? l > 1
        ? fn.apply(ctx, arguments)
        : fn.call(ctx, a)
      : fn.call(ctx)
  }
  // record original fn length
  boundFn._length = fn.length;
  return boundFn
}

/**
 * Convert an Array-like object to a real Array.
 */
function toArray (list, start) {
  start = start || 0;
  var i = list.length - start;
  var ret = new Array(i);
  while (i--) {
    ret[i] = list[i + start];
  }
  return ret
}

/**
 * Mix properties into target object.
 */
function extend (to, _from) {
  for (var key in _from) {
    to[key] = _from[key];
  }
  return to
}

/**
 * Merge an Array of Objects into a single Object.
 */
function toObject (arr) {
  var res = {};
  for (var i = 0; i < arr.length; i++) {
    if (arr[i]) {
      extend(res, arr[i]);
    }
  }
  return res
}

/**
 * Perform no operation.
 */
function noop () {}

/**
 * Always return false.
 */
var no = function () { return false; };

/**
 * Return same value
 */
var identity = function (_) { return _; };

/**
 * Generate a static keys string from compiler modules.
 */
function genStaticKeys (modules) {
  return modules.reduce(function (keys, m) {
    return keys.concat(m.staticKeys || [])
  }, []).join(',')
}

/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 */
function looseEqual (a, b) {
  var isObjectA = isObject(a);
  var isObjectB = isObject(b);
  if (isObjectA && isObjectB) {
    try {
      return JSON.stringify(a) === JSON.stringify(b)
    } catch (e) {
      // possible circular reference
      return a === b
    }
  } else if (!isObjectA && !isObjectB) {
    return String(a) === String(b)
  } else {
    return false
  }
}

function looseIndexOf (arr, val) {
  for (var i = 0; i < arr.length; i++) {
    if (looseEqual(arr[i], val)) { return i }
  }
  return -1
}

/**
 * Ensure a function is called only once.
 */
function once (fn) {
  var called = false;
  return function () {
    if (!called) {
      called = true;
      fn.apply(this, arguments);
    }
  }
}

var SSR_ATTR = 'data-server-rendered';

var ASSET_TYPES = [
  'component',
  'directive',
  'filter'
];

var LIFECYCLE_HOOKS = [
  'beforeCreate',
  'created',
  'beforeMount',
  'mounted',
  'beforeUpdate',
  'updated',
  'beforeDestroy',
  'destroyed',
  'activated',
  'deactivated'
];

/*  */

var config = ({
  /**
   * Option merge strategies (used in core/util/options)
   */
  optionMergeStrategies: Object.create(null),

  /**
   * Whether to suppress warnings.
   */
  silent: false,

  /**
   * Show production mode tip message on boot?
   */
  productionTip: "development" !== 'production',

  /**
   * Whether to enable devtools
   */
  devtools: "development" !== 'production',

  /**
   * Whether to record perf
   */
  performance: false,

  /**
   * Error handler for watcher errors
   */
  errorHandler: null,

  /**
   * Ignore certain custom elements
   */
  ignoredElements: [],

  /**
   * Custom user key aliases for v-on
   */
  keyCodes: Object.create(null),

  /**
   * Check if a tag is reserved so that it cannot be registered as a
   * component. This is platform-dependent and may be overwritten.
   */
  isReservedTag: no,

  /**
   * Check if an attribute is reserved so that it cannot be used as a component
   * prop. This is platform-dependent and may be overwritten.
   */
  isReservedAttr: no,

  /**
   * Check if a tag is an unknown element.
   * Platform-dependent.
   */
  isUnknownElement: no,

  /**
   * Get the namespace of an element
   */
  getTagNamespace: noop,

  /**
   * Parse the real tag name for the specific platform.
   */
  parsePlatformTagName: identity,

  /**
   * Check if an attribute must be bound using property, e.g. value
   * Platform-dependent.
   */
  mustUseProp: no,

  /**
   * Exposed for legacy reasons
   */
  _lifecycleHooks: LIFECYCLE_HOOKS
});

/*  */

var emptyObject = Object.freeze({});

/**
 * Check if a string starts with $ or _
 */
function isReserved (str) {
  var c = (str + '').charCodeAt(0);
  return c === 0x24 || c === 0x5F
}

/**
 * Define a property.
 */
function def (obj, key, val, enumerable) {
  Object.defineProperty(obj, key, {
    value: val,
    enumerable: !!enumerable,
    writable: true,
    configurable: true
  });
}

/**
 * Parse simple path.
 */
var bailRE = /[^\w.$]/;
function parsePath (path) {
  if (bailRE.test(path)) {
    return
  }
  var segments = path.split('.');
  return function (obj) {
    for (var i = 0; i < segments.length; i++) {
      if (!obj) { return }
      obj = obj[segments[i]];
    }
    return obj
  }
}

/*  */

var warn = noop;
var tip = noop;
var formatComponentName = (null); // work around flow check

{
  var hasConsole = typeof console !== 'undefined';
  var classifyRE = /(?:^|[-_])(\w)/g;
  var classify = function (str) { return str
    .replace(classifyRE, function (c) { return c.toUpperCase(); })
    .replace(/[-_]/g, ''); };

  warn = function (msg, vm) {
    if (hasConsole && (!config.silent)) {
      console.error("[Vue warn]: " + msg + (
        vm ? generateComponentTrace(vm) : ''
      ));
    }
  };

  tip = function (msg, vm) {
    if (hasConsole && (!config.silent)) {
      console.warn("[Vue tip]: " + msg + (
        vm ? generateComponentTrace(vm) : ''
      ));
    }
  };

  formatComponentName = function (vm, includeFile) {
    if (vm.$root === vm) {
      return '<Root>'
    }
    var name = typeof vm === 'string'
      ? vm
      : typeof vm === 'function' && vm.options
        ? vm.options.name
        : vm._isVue
          ? vm.$options.name || vm.$options._componentTag
          : vm.name;

    var file = vm._isVue && vm.$options.__file;
    if (!name && file) {
      var match = file.match(/([^/\\]+)\.vue$/);
      name = match && match[1];
    }

    return (
      (name ? ("<" + (classify(name)) + ">") : "<Anonymous>") +
      (file && includeFile !== false ? (" at " + file) : '')
    )
  };

  var repeat = function (str, n) {
    var res = '';
    while (n) {
      if (n % 2 === 1) { res += str; }
      if (n > 1) { str += str; }
      n >>= 1;
    }
    return res
  };

  var generateComponentTrace = function (vm) {
    if (vm._isVue && vm.$parent) {
      var tree = [];
      var currentRecursiveSequence = 0;
      while (vm) {
        if (tree.length > 0) {
          var last = tree[tree.length - 1];
          if (last.constructor === vm.constructor) {
            currentRecursiveSequence++;
            vm = vm.$parent;
            continue
          } else if (currentRecursiveSequence > 0) {
            tree[tree.length - 1] = [last, currentRecursiveSequence];
            currentRecursiveSequence = 0;
          }
        }
        tree.push(vm);
        vm = vm.$parent;
      }
      return '\n\nfound in\n\n' + tree
        .map(function (vm, i) { return ("" + (i === 0 ? '---> ' : repeat(' ', 5 + i * 2)) + (Array.isArray(vm)
            ? ((formatComponentName(vm[0])) + "... (" + (vm[1]) + " recursive calls)")
            : formatComponentName(vm))); })
        .join('\n')
    } else {
      return ("\n\n(found in " + (formatComponentName(vm)) + ")")
    }
  };
}

/*  */

function handleError (err, vm, info) {
  if (config.errorHandler) {
    config.errorHandler.call(null, err, vm, info);
  } else {
    {
      warn(("Error in " + info + ": \"" + (err.toString()) + "\""), vm);
    }
    /* istanbul ignore else */
    if (inBrowser && typeof console !== 'undefined') {
      console.error(err);
    } else {
      throw err
    }
  }
}

/*  */
/* globals MutationObserver */

// can we use __proto__?
var hasProto = '__proto__' in {};

// Browser environment sniffing
var inBrowser = typeof window !== 'undefined';
var UA = inBrowser && window.navigator.userAgent.toLowerCase();
var isIE = UA && /msie|trident/.test(UA);
var isIE9 = UA && UA.indexOf('msie 9.0') > 0;
var isEdge = UA && UA.indexOf('edge/') > 0;
var isAndroid = UA && UA.indexOf('android') > 0;
var isIOS = UA && /iphone|ipad|ipod|ios/.test(UA);
var isChrome = UA && /chrome\/\d+/.test(UA) && !isEdge;

var supportsPassive = false;
if (inBrowser) {
  try {
    var opts = {};
    Object.defineProperty(opts, 'passive', ({
      get: function get () {
        /* istanbul ignore next */
        supportsPassive = true;
      }
    } )); // https://github.com/facebook/flow/issues/285
    window.addEventListener('test-passive', null, opts);
  } catch (e) {}
}

// this needs to be lazy-evaled because vue may be required before
// vue-server-renderer can set VUE_ENV
var _isServer;
var isServerRendering = function () {
  if (_isServer === undefined) {
    /* istanbul ignore if */
    if (!inBrowser && typeof global !== 'undefined') {
      // detect presence of vue-server-renderer and avoid
      // Webpack shimming the process
      _isServer = global['process'].env.VUE_ENV === 'server';
    } else {
      _isServer = false;
    }
  }
  return _isServer
};

// detect devtools
var devtools = inBrowser && window.__VUE_DEVTOOLS_GLOBAL_HOOK__;

/* istanbul ignore next */
function isNative (Ctor) {
  return typeof Ctor === 'function' && /native code/.test(Ctor.toString())
}

var hasSymbol =
  typeof Symbol !== 'undefined' && isNative(Symbol) &&
  typeof Reflect !== 'undefined' && isNative(Reflect.ownKeys);

/**
 * Defer a task to execute it asynchronously.
 */
var nextTick = (function () {
  var callbacks = [];
  var pending = false;
  var timerFunc;

  function nextTickHandler () {
    pending = false;
    var copies = callbacks.slice(0);
    callbacks.length = 0;
    for (var i = 0; i < copies.length; i++) {
      copies[i]();
    }
  }

  // the nextTick behavior leverages the microtask queue, which can be accessed
  // via either native Promise.then or MutationObserver.
  // MutationObserver has wider support, however it is seriously bugged in
  // UIWebView in iOS >= 9.3.3 when triggered in touch event handlers. It
  // completely stops working after triggering a few times... so, if native
  // Promise is available, we will use it:
  /* istanbul ignore if */
  if (typeof Promise !== 'undefined' && isNative(Promise)) {
    var p = Promise.resolve();
    var logError = function (err) { console.error(err); };
    timerFunc = function () {
      p.then(nextTickHandler).catch(logError);
      // in problematic UIWebViews, Promise.then doesn't completely break, but
      // it can get stuck in a weird state where callbacks are pushed into the
      // microtask queue but the queue isn't being flushed, until the browser
      // needs to do some other work, e.g. handle a timer. Therefore we can
      // "force" the microtask queue to be flushed by adding an empty timer.
      if (isIOS) { setTimeout(noop); }
    };
  } else if (typeof MutationObserver !== 'undefined' && (
    isNative(MutationObserver) ||
    // PhantomJS and iOS 7.x
    MutationObserver.toString() === '[object MutationObserverConstructor]'
  )) {
    // use MutationObserver where native Promise is not available,
    // e.g. PhantomJS IE11, iOS7, Android 4.4
    var counter = 1;
    var observer = new MutationObserver(nextTickHandler);
    var textNode = document.createTextNode(String(counter));
    observer.observe(textNode, {
      characterData: true
    });
    timerFunc = function () {
      counter = (counter + 1) % 2;
      textNode.data = String(counter);
    };
  } else {
    // fallback to setTimeout
    /* istanbul ignore next */
    timerFunc = function () {
      setTimeout(nextTickHandler, 0);
    };
  }

  return function queueNextTick (cb, ctx) {
    var _resolve;
    callbacks.push(function () {
      if (cb) {
        try {
          cb.call(ctx);
        } catch (e) {
          handleError(e, ctx, 'nextTick');
        }
      } else if (_resolve) {
        _resolve(ctx);
      }
    });
    if (!pending) {
      pending = true;
      timerFunc();
    }
    if (!cb && typeof Promise !== 'undefined') {
      return new Promise(function (resolve, reject) {
        _resolve = resolve;
      })
    }
  }
})();

var _Set;
/* istanbul ignore if */
if (typeof Set !== 'undefined' && isNative(Set)) {
  // use native Set when available.
  _Set = Set;
} else {
  // a non-standard Set polyfill that only works with primitive keys.
  _Set = (function () {
    function Set () {
      this.set = Object.create(null);
    }
    Set.prototype.has = function has (key) {
      return this.set[key] === true
    };
    Set.prototype.add = function add (key) {
      this.set[key] = true;
    };
    Set.prototype.clear = function clear () {
      this.set = Object.create(null);
    };

    return Set;
  }());
}

/*  */


var uid = 0;

/**
 * A dep is an observable that can have multiple
 * directives subscribing to it.
 */
var Dep = function Dep () {
  this.id = uid++;
  this.subs = [];
};

Dep.prototype.addSub = function addSub (sub) {
  this.subs.push(sub);
};

Dep.prototype.removeSub = function removeSub (sub) {
  remove(this.subs, sub);
};

Dep.prototype.depend = function depend () {
  if (Dep.target) {
    Dep.target.addDep(this);
  }
};

Dep.prototype.notify = function notify () {
  // stabilize the subscriber list first
  var subs = this.subs.slice();
  for (var i = 0, l = subs.length; i < l; i++) {
    subs[i].update();
  }
};

// the current target watcher being evaluated.
// this is globally unique because there could be only one
// watcher being evaluated at any time.
Dep.target = null;
var targetStack = [];

function pushTarget (_target) {
  if (Dep.target) { targetStack.push(Dep.target); }
  Dep.target = _target;
}

function popTarget () {
  Dep.target = targetStack.pop();
}

/*
 * not type checking this file because flow doesn't play well with
 * dynamically accessing methods on Array prototype
 */

var arrayProto = Array.prototype;
var arrayMethods = Object.create(arrayProto);[
  'push',
  'pop',
  'shift',
  'unshift',
  'splice',
  'sort',
  'reverse'
]
.forEach(function (method) {
  // cache original method
  var original = arrayProto[method];
  def(arrayMethods, method, function mutator () {
    var arguments$1 = arguments;

    // avoid leaking arguments:
    // http://jsperf.com/closure-with-arguments
    var i = arguments.length;
    var args = new Array(i);
    while (i--) {
      args[i] = arguments$1[i];
    }
    var result = original.apply(this, args);
    var ob = this.__ob__;
    var inserted;
    switch (method) {
      case 'push':
        inserted = args;
        break
      case 'unshift':
        inserted = args;
        break
      case 'splice':
        inserted = args.slice(2);
        break
    }
    if (inserted) { ob.observeArray(inserted); }
    // notify change
    ob.dep.notify();
    return result
  });
});

/*  */

var arrayKeys = Object.getOwnPropertyNames(arrayMethods);

/**
 * By default, when a reactive property is set, the new value is
 * also converted to become reactive. However when passing down props,
 * we don't want to force conversion because the value may be a nested value
 * under a frozen data structure. Converting it would defeat the optimization.
 */
var observerState = {
  shouldConvert: true,
  isSettingProps: false
};

/**
 * Observer class that are attached to each observed
 * object. Once attached, the observer converts target
 * object's property keys into getter/setters that
 * collect dependencies and dispatches updates.
 */
var Observer = function Observer (value) {
  this.value = value;
  this.dep = new Dep();
  this.vmCount = 0;
  def(value, '__ob__', this);
  if (Array.isArray(value)) {
    var augment = hasProto
      ? protoAugment
      : copyAugment;
    augment(value, arrayMethods, arrayKeys);
    this.observeArray(value);
  } else {
    this.walk(value);
  }
};

/**
 * Walk through each property and convert them into
 * getter/setters. This method should only be called when
 * value type is Object.
 */
Observer.prototype.walk = function walk (obj) {
  var keys = Object.keys(obj);
  for (var i = 0; i < keys.length; i++) {
    defineReactive$$1(obj, keys[i], obj[keys[i]]);
  }
};

/**
 * Observe a list of Array items.
 */
Observer.prototype.observeArray = function observeArray (items) {
  for (var i = 0, l = items.length; i < l; i++) {
    observe(items[i]);
  }
};

// helpers

/**
 * Augment an target Object or Array by intercepting
 * the prototype chain using __proto__
 */
function protoAugment (target, src) {
  /* eslint-disable no-proto */
  target.__proto__ = src;
  /* eslint-enable no-proto */
}

/**
 * Augment an target Object or Array by defining
 * hidden properties.
 */
/* istanbul ignore next */
function copyAugment (target, src, keys) {
  for (var i = 0, l = keys.length; i < l; i++) {
    var key = keys[i];
    def(target, key, src[key]);
  }
}

/**
 * Attempt to create an observer instance for a value,
 * returns the new observer if successfully observed,
 * or the existing observer if the value already has one.
 */
function observe (value, asRootData) {
  if (!isObject(value)) {
    return
  }
  var ob;
  if (hasOwn(value, '__ob__') && value.__ob__ instanceof Observer) {
    ob = value.__ob__;
  } else if (
    observerState.shouldConvert &&
    !isServerRendering() &&
    (Array.isArray(value) || isPlainObject(value)) &&
    Object.isExtensible(value) &&
    !value._isVue
  ) {
    ob = new Observer(value);
  }
  if (asRootData && ob) {
    ob.vmCount++;
  }
  return ob
}

/**
 * Define a reactive property on an Object.
 */
function defineReactive$$1 (
  obj,
  key,
  val,
  customSetter
) {
  var dep = new Dep();

  var property = Object.getOwnPropertyDescriptor(obj, key);
  if (property && property.configurable === false) {
    return
  }

  // cater for pre-defined getter/setters
  var getter = property && property.get;
  var setter = property && property.set;

  var childOb = observe(val);
  Object.defineProperty(obj, key, {
    enumerable: true,
    configurable: true,
    get: function reactiveGetter () {
      var value = getter ? getter.call(obj) : val;
      if (Dep.target) {
        dep.depend();
        if (childOb) {
          childOb.dep.depend();
        }
        if (Array.isArray(value)) {
          dependArray(value);
        }
      }
      return value
    },
    set: function reactiveSetter (newVal) {
      var value = getter ? getter.call(obj) : val;
      /* eslint-disable no-self-compare */
      if (newVal === value || (newVal !== newVal && value !== value)) {
        return
      }
      /* eslint-enable no-self-compare */
      if ("development" !== 'production' && customSetter) {
        customSetter();
      }
      if (setter) {
        setter.call(obj, newVal);
      } else {
        val = newVal;
      }
      childOb = observe(newVal);
      dep.notify();
    }
  });
}

/**
 * Set a property on an object. Adds the new property and
 * triggers change notification if the property doesn't
 * already exist.
 */
function set (target, key, val) {
  if (Array.isArray(target) && typeof key === 'number') {
    target.length = Math.max(target.length, key);
    target.splice(key, 1, val);
    return val
  }
  if (hasOwn(target, key)) {
    target[key] = val;
    return val
  }
  var ob = (target ).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    "development" !== 'production' && warn(
      'Avoid adding reactive properties to a Vue instance or its root $data ' +
      'at runtime - declare it upfront in the data option.'
    );
    return val
  }
  if (!ob) {
    target[key] = val;
    return val
  }
  defineReactive$$1(ob.value, key, val);
  ob.dep.notify();
  return val
}

/**
 * Delete a property and trigger change if necessary.
 */
function del (target, key) {
  if (Array.isArray(target) && typeof key === 'number') {
    target.splice(key, 1);
    return
  }
  var ob = (target ).__ob__;
  if (target._isVue || (ob && ob.vmCount)) {
    "development" !== 'production' && warn(
      'Avoid deleting properties on a Vue instance or its root $data ' +
      '- just set it to null.'
    );
    return
  }
  if (!hasOwn(target, key)) {
    return
  }
  delete target[key];
  if (!ob) {
    return
  }
  ob.dep.notify();
}

/**
 * Collect dependencies on array elements when the array is touched, since
 * we cannot intercept array element access like property getters.
 */
function dependArray (value) {
  for (var e = (void 0), i = 0, l = value.length; i < l; i++) {
    e = value[i];
    e && e.__ob__ && e.__ob__.dep.depend();
    if (Array.isArray(e)) {
      dependArray(e);
    }
  }
}

/*  */

/**
 * Option overwriting strategies are functions that handle
 * how to merge a parent option value and a child option
 * value into the final value.
 */
var strats = config.optionMergeStrategies;

/**
 * Options with restrictions
 */
{
  strats.el = strats.propsData = function (parent, child, vm, key) {
    if (!vm) {
      warn(
        "option \"" + key + "\" can only be used during instance " +
        'creation with the `new` keyword.'
      );
    }
    return defaultStrat(parent, child)
  };
}

/**
 * Helper that recursively merges two data objects together.
 */
function mergeData (to, from) {
  if (!from) { return to }
  var key, toVal, fromVal;
  var keys = Object.keys(from);
  for (var i = 0; i < keys.length; i++) {
    key = keys[i];
    toVal = to[key];
    fromVal = from[key];
    if (!hasOwn(to, key)) {
      set(to, key, fromVal);
    } else if (isPlainObject(toVal) && isPlainObject(fromVal)) {
      mergeData(toVal, fromVal);
    }
  }
  return to
}

/**
 * Data
 */
strats.data = function (
  parentVal,
  childVal,
  vm
) {
  if (!vm) {
    // in a Vue.extend merge, both should be functions
    if (!childVal) {
      return parentVal
    }
    if (typeof childVal !== 'function') {
      "development" !== 'production' && warn(
        'The "data" option should be a function ' +
        'that returns a per-instance value in component ' +
        'definitions.',
        vm
      );
      return parentVal
    }
    if (!parentVal) {
      return childVal
    }
    // when parentVal & childVal are both present,
    // we need to return a function that returns the
    // merged result of both functions... no need to
    // check if parentVal is a function here because
    // it has to be a function to pass previous merges.
    return function mergedDataFn () {
      return mergeData(
        childVal.call(this),
        parentVal.call(this)
      )
    }
  } else if (parentVal || childVal) {
    return function mergedInstanceDataFn () {
      // instance merge
      var instanceData = typeof childVal === 'function'
        ? childVal.call(vm)
        : childVal;
      var defaultData = typeof parentVal === 'function'
        ? parentVal.call(vm)
        : undefined;
      if (instanceData) {
        return mergeData(instanceData, defaultData)
      } else {
        return defaultData
      }
    }
  }
};

/**
 * Hooks and props are merged as arrays.
 */
function mergeHook (
  parentVal,
  childVal
) {
  return childVal
    ? parentVal
      ? parentVal.concat(childVal)
      : Array.isArray(childVal)
        ? childVal
        : [childVal]
    : parentVal
}

LIFECYCLE_HOOKS.forEach(function (hook) {
  strats[hook] = mergeHook;
});

/**
 * Assets
 *
 * When a vm is present (instance creation), we need to do
 * a three-way merge between constructor options, instance
 * options and parent options.
 */
function mergeAssets (parentVal, childVal) {
  var res = Object.create(parentVal || null);
  return childVal
    ? extend(res, childVal)
    : res
}

ASSET_TYPES.forEach(function (type) {
  strats[type + 's'] = mergeAssets;
});

/**
 * Watchers.
 *
 * Watchers hashes should not overwrite one
 * another, so we merge them as arrays.
 */
strats.watch = function (parentVal, childVal) {
  /* istanbul ignore if */
  if (!childVal) { return Object.create(parentVal || null) }
  if (!parentVal) { return childVal }
  var ret = {};
  extend(ret, parentVal);
  for (var key in childVal) {
    var parent = ret[key];
    var child = childVal[key];
    if (parent && !Array.isArray(parent)) {
      parent = [parent];
    }
    ret[key] = parent
      ? parent.concat(child)
      : [child];
  }
  return ret
};

/**
 * Other object hashes.
 */
strats.props =
strats.methods =
strats.computed = function (parentVal, childVal) {
  if (!childVal) { return Object.create(parentVal || null) }
  if (!parentVal) { return childVal }
  var ret = Object.create(null);
  extend(ret, parentVal);
  extend(ret, childVal);
  return ret
};

/**
 * Default strategy.
 */
var defaultStrat = function (parentVal, childVal) {
  return childVal === undefined
    ? parentVal
    : childVal
};

/**
 * Validate component names
 */
function checkComponents (options) {
  for (var key in options.components) {
    var lower = key.toLowerCase();
    if (isBuiltInTag(lower) || config.isReservedTag(lower)) {
      warn(
        'Do not use built-in or reserved HTML elements as component ' +
        'id: ' + key
      );
    }
  }
}

/**
 * Ensure all props option syntax are normalized into the
 * Object-based format.
 */
function normalizeProps (options) {
  var props = options.props;
  if (!props) { return }
  var res = {};
  var i, val, name;
  if (Array.isArray(props)) {
    i = props.length;
    while (i--) {
      val = props[i];
      if (typeof val === 'string') {
        name = camelize(val);
        res[name] = { type: null };
      } else {
        warn('props must be strings when using array syntax.');
      }
    }
  } else if (isPlainObject(props)) {
    for (var key in props) {
      val = props[key];
      name = camelize(key);
      res[name] = isPlainObject(val)
        ? val
        : { type: val };
    }
  }
  options.props = res;
}

/**
 * Normalize raw function directives into object format.
 */
function normalizeDirectives (options) {
  var dirs = options.directives;
  if (dirs) {
    for (var key in dirs) {
      var def = dirs[key];
      if (typeof def === 'function') {
        dirs[key] = { bind: def, update: def };
      }
    }
  }
}

/**
 * Merge two option objects into a new one.
 * Core utility used in both instantiation and inheritance.
 */
function mergeOptions (
  parent,
  child,
  vm
) {
  {
    checkComponents(child);
  }

  if (typeof child === 'function') {
    child = child.options;
  }

  normalizeProps(child);
  normalizeDirectives(child);
  var extendsFrom = child.extends;
  if (extendsFrom) {
    parent = mergeOptions(parent, extendsFrom, vm);
  }
  if (child.mixins) {
    for (var i = 0, l = child.mixins.length; i < l; i++) {
      parent = mergeOptions(parent, child.mixins[i], vm);
    }
  }
  var options = {};
  var key;
  for (key in parent) {
    mergeField(key);
  }
  for (key in child) {
    if (!hasOwn(parent, key)) {
      mergeField(key);
    }
  }
  function mergeField (key) {
    var strat = strats[key] || defaultStrat;
    options[key] = strat(parent[key], child[key], vm, key);
  }
  return options
}

/**
 * Resolve an asset.
 * This function is used because child instances need access
 * to assets defined in its ancestor chain.
 */
function resolveAsset (
  options,
  type,
  id,
  warnMissing
) {
  /* istanbul ignore if */
  if (typeof id !== 'string') {
    return
  }
  var assets = options[type];
  // check local registration variations first
  if (hasOwn(assets, id)) { return assets[id] }
  var camelizedId = camelize(id);
  if (hasOwn(assets, camelizedId)) { return assets[camelizedId] }
  var PascalCaseId = capitalize(camelizedId);
  if (hasOwn(assets, PascalCaseId)) { return assets[PascalCaseId] }
  // fallback to prototype chain
  var res = assets[id] || assets[camelizedId] || assets[PascalCaseId];
  if ("development" !== 'production' && warnMissing && !res) {
    warn(
      'Failed to resolve ' + type.slice(0, -1) + ': ' + id,
      options
    );
  }
  return res
}

/*  */

function validateProp (
  key,
  propOptions,
  propsData,
  vm
) {
  var prop = propOptions[key];
  var absent = !hasOwn(propsData, key);
  var value = propsData[key];
  // handle boolean props
  if (isType(Boolean, prop.type)) {
    if (absent && !hasOwn(prop, 'default')) {
      value = false;
    } else if (!isType(String, prop.type) && (value === '' || value === hyphenate(key))) {
      value = true;
    }
  }
  // check default value
  if (value === undefined) {
    value = getPropDefaultValue(vm, prop, key);
    // since the default value is a fresh copy,
    // make sure to observe it.
    var prevShouldConvert = observerState.shouldConvert;
    observerState.shouldConvert = true;
    observe(value);
    observerState.shouldConvert = prevShouldConvert;
  }
  {
    assertProp(prop, key, value, vm, absent);
  }
  return value
}

/**
 * Get the default value of a prop.
 */
function getPropDefaultValue (vm, prop, key) {
  // no default, return undefined
  if (!hasOwn(prop, 'default')) {
    return undefined
  }
  var def = prop.default;
  // warn against non-factory defaults for Object & Array
  if ("development" !== 'production' && isObject(def)) {
    warn(
      'Invalid default value for prop "' + key + '": ' +
      'Props with type Object/Array must use a factory function ' +
      'to return the default value.',
      vm
    );
  }
  // the raw prop value was also undefined from previous render,
  // return previous default value to avoid unnecessary watcher trigger
  if (vm && vm.$options.propsData &&
    vm.$options.propsData[key] === undefined &&
    vm._props[key] !== undefined
  ) {
    return vm._props[key]
  }
  // call factory function for non-Function types
  // a value is Function if its prototype is function even across different execution context
  return typeof def === 'function' && getType(prop.type) !== 'Function'
    ? def.call(vm)
    : def
}

/**
 * Assert whether a prop is valid.
 */
function assertProp (
  prop,
  name,
  value,
  vm,
  absent
) {
  if (prop.required && absent) {
    warn(
      'Missing required prop: "' + name + '"',
      vm
    );
    return
  }
  if (value == null && !prop.required) {
    return
  }
  var type = prop.type;
  var valid = !type || type === true;
  var expectedTypes = [];
  if (type) {
    if (!Array.isArray(type)) {
      type = [type];
    }
    for (var i = 0; i < type.length && !valid; i++) {
      var assertedType = assertType(value, type[i]);
      expectedTypes.push(assertedType.expectedType || '');
      valid = assertedType.valid;
    }
  }
  if (!valid) {
    warn(
      'Invalid prop: type check failed for prop "' + name + '".' +
      ' Expected ' + expectedTypes.map(capitalize).join(', ') +
      ', got ' + Object.prototype.toString.call(value).slice(8, -1) + '.',
      vm
    );
    return
  }
  var validator = prop.validator;
  if (validator) {
    if (!validator(value)) {
      warn(
        'Invalid prop: custom validator check failed for prop "' + name + '".',
        vm
      );
    }
  }
}

var simpleCheckRE = /^(String|Number|Boolean|Function|Symbol)$/;

function assertType (value, type) {
  var valid;
  var expectedType = getType(type);
  if (simpleCheckRE.test(expectedType)) {
    valid = typeof value === expectedType.toLowerCase();
  } else if (expectedType === 'Object') {
    valid = isPlainObject(value);
  } else if (expectedType === 'Array') {
    valid = Array.isArray(value);
  } else {
    valid = value instanceof type;
  }
  return {
    valid: valid,
    expectedType: expectedType
  }
}

/**
 * Use function string name to check built-in types,
 * because a simple equality check will fail when running
 * across different vms / iframes.
 */
function getType (fn) {
  var match = fn && fn.toString().match(/^\s*function (\w+)/);
  return match ? match[1] : ''
}

function isType (type, fn) {
  if (!Array.isArray(fn)) {
    return getType(fn) === getType(type)
  }
  for (var i = 0, len = fn.length; i < len; i++) {
    if (getType(fn[i]) === getType(type)) {
      return true
    }
  }
  /* istanbul ignore next */
  return false
}

/*  */

var mark;
var measure;

{
  var perf = inBrowser && window.performance;
  /* istanbul ignore if */
  if (
    perf &&
    perf.mark &&
    perf.measure &&
    perf.clearMarks &&
    perf.clearMeasures
  ) {
    mark = function (tag) { return perf.mark(tag); };
    measure = function (name, startTag, endTag) {
      perf.measure(name, startTag, endTag);
      perf.clearMarks(startTag);
      perf.clearMarks(endTag);
      perf.clearMeasures(name);
    };
  }
}

/* not type checking this file because flow doesn't play well with Proxy */

var initProxy;

{
  var allowedGlobals = makeMap(
    'Infinity,undefined,NaN,isFinite,isNaN,' +
    'parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,' +
    'Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,' +
    'require' // for Webpack/Browserify
  );

  var warnNonPresent = function (target, key) {
    warn(
      "Property or method \"" + key + "\" is not defined on the instance but " +
      "referenced during render. Make sure to declare reactive data " +
      "properties in the data option.",
      target
    );
  };

  var hasProxy =
    typeof Proxy !== 'undefined' &&
    Proxy.toString().match(/native code/);

  if (hasProxy) {
    var isBuiltInModifier = makeMap('stop,prevent,self,ctrl,shift,alt,meta');
    config.keyCodes = new Proxy(config.keyCodes, {
      set: function set (target, key, value) {
        if (isBuiltInModifier(key)) {
          warn(("Avoid overwriting built-in modifier in config.keyCodes: ." + key));
          return false
        } else {
          target[key] = value;
          return true
        }
      }
    });
  }

  var hasHandler = {
    has: function has (target, key) {
      var has = key in target;
      var isAllowed = allowedGlobals(key) || key.charAt(0) === '_';
      if (!has && !isAllowed) {
        warnNonPresent(target, key);
      }
      return has || !isAllowed
    }
  };

  var getHandler = {
    get: function get (target, key) {
      if (typeof key === 'string' && !(key in target)) {
        warnNonPresent(target, key);
      }
      return target[key]
    }
  };

  initProxy = function initProxy (vm) {
    if (hasProxy) {
      // determine which proxy handler to use
      var options = vm.$options;
      var handlers = options.render && options.render._withStripped
        ? getHandler
        : hasHandler;
      vm._renderProxy = new Proxy(vm, handlers);
    } else {
      vm._renderProxy = vm;
    }
  };
}

/*  */

var VNode = function VNode (
  tag,
  data,
  children,
  text,
  elm,
  context,
  componentOptions
) {
  this.tag = tag;
  this.data = data;
  this.children = children;
  this.text = text;
  this.elm = elm;
  this.ns = undefined;
  this.context = context;
  this.functionalContext = undefined;
  this.key = data && data.key;
  this.componentOptions = componentOptions;
  this.componentInstance = undefined;
  this.parent = undefined;
  this.raw = false;
  this.isStatic = false;
  this.isRootInsert = true;
  this.isComment = false;
  this.isCloned = false;
  this.isOnce = false;
};

var prototypeAccessors = { child: {} };

// DEPRECATED: alias for componentInstance for backwards compat.
/* istanbul ignore next */
prototypeAccessors.child.get = function () {
  return this.componentInstance
};

Object.defineProperties( VNode.prototype, prototypeAccessors );

var createEmptyVNode = function () {
  var node = new VNode();
  node.text = '';
  node.isComment = true;
  return node
};

function createTextVNode (val) {
  return new VNode(undefined, undefined, undefined, String(val))
}

// optimized shallow clone
// used for static nodes and slot nodes because they may be reused across
// multiple renders, cloning them avoids errors when DOM manipulations rely
// on their elm reference.
function cloneVNode (vnode) {
  var cloned = new VNode(
    vnode.tag,
    vnode.data,
    vnode.children,
    vnode.text,
    vnode.elm,
    vnode.context,
    vnode.componentOptions
  );
  cloned.ns = vnode.ns;
  cloned.isStatic = vnode.isStatic;
  cloned.key = vnode.key;
  cloned.isComment = vnode.isComment;
  cloned.isCloned = true;
  return cloned
}

function cloneVNodes (vnodes) {
  var len = vnodes.length;
  var res = new Array(len);
  for (var i = 0; i < len; i++) {
    res[i] = cloneVNode(vnodes[i]);
  }
  return res
}

/*  */

var normalizeEvent = cached(function (name) {
  var passive = name.charAt(0) === '&';
  name = passive ? name.slice(1) : name;
  var once$$1 = name.charAt(0) === '~'; // Prefixed last, checked first
  name = once$$1 ? name.slice(1) : name;
  var capture = name.charAt(0) === '!';
  name = capture ? name.slice(1) : name;
  return {
    name: name,
    once: once$$1,
    capture: capture,
    passive: passive
  }
});

function createFnInvoker (fns) {
  function invoker () {
    var arguments$1 = arguments;

    var fns = invoker.fns;
    if (Array.isArray(fns)) {
      for (var i = 0; i < fns.length; i++) {
        fns[i].apply(null, arguments$1);
      }
    } else {
      // return handler return value for single handlers
      return fns.apply(null, arguments)
    }
  }
  invoker.fns = fns;
  return invoker
}

function updateListeners (
  on,
  oldOn,
  add,
  remove$$1,
  vm
) {
  var name, cur, old, event;
  for (name in on) {
    cur = on[name];
    old = oldOn[name];
    event = normalizeEvent(name);
    if (isUndef(cur)) {
      "development" !== 'production' && warn(
        "Invalid handler for event \"" + (event.name) + "\": got " + String(cur),
        vm
      );
    } else if (isUndef(old)) {
      if (isUndef(cur.fns)) {
        cur = on[name] = createFnInvoker(cur);
      }
      add(event.name, cur, event.once, event.capture, event.passive);
    } else if (cur !== old) {
      old.fns = cur;
      on[name] = old;
    }
  }
  for (name in oldOn) {
    if (isUndef(on[name])) {
      event = normalizeEvent(name);
      remove$$1(event.name, oldOn[name], event.capture);
    }
  }
}

/*  */

function mergeVNodeHook (def, hookKey, hook) {
  var invoker;
  var oldHook = def[hookKey];

  function wrappedHook () {
    hook.apply(this, arguments);
    // important: remove merged hook to ensure it's called only once
    // and prevent memory leak
    remove(invoker.fns, wrappedHook);
  }

  if (isUndef(oldHook)) {
    // no existing hook
    invoker = createFnInvoker([wrappedHook]);
  } else {
    /* istanbul ignore if */
    if (isDef(oldHook.fns) && isTrue(oldHook.merged)) {
      // already a merged invoker
      invoker = oldHook;
      invoker.fns.push(wrappedHook);
    } else {
      // existing plain hook
      invoker = createFnInvoker([oldHook, wrappedHook]);
    }
  }

  invoker.merged = true;
  def[hookKey] = invoker;
}

/*  */

function extractPropsFromVNodeData (
  data,
  Ctor,
  tag
) {
  // we are only extracting raw values here.
  // validation and default values are handled in the child
  // component itself.
  var propOptions = Ctor.options.props;
  if (isUndef(propOptions)) {
    return
  }
  var res = {};
  var attrs = data.attrs;
  var props = data.props;
  if (isDef(attrs) || isDef(props)) {
    for (var key in propOptions) {
      var altKey = hyphenate(key);
      {
        var keyInLowerCase = key.toLowerCase();
        if (
          key !== keyInLowerCase &&
          attrs && hasOwn(attrs, keyInLowerCase)
        ) {
          tip(
            "Prop \"" + keyInLowerCase + "\" is passed to component " +
            (formatComponentName(tag || Ctor)) + ", but the declared prop name is" +
            " \"" + key + "\". " +
            "Note that HTML attributes are case-insensitive and camelCased " +
            "props need to use their kebab-case equivalents when using in-DOM " +
            "templates. You should probably use \"" + altKey + "\" instead of \"" + key + "\"."
          );
        }
      }
      checkProp(res, props, key, altKey, true) ||
      checkProp(res, attrs, key, altKey, false);
    }
  }
  return res
}

function checkProp (
  res,
  hash,
  key,
  altKey,
  preserve
) {
  if (isDef(hash)) {
    if (hasOwn(hash, key)) {
      res[key] = hash[key];
      if (!preserve) {
        delete hash[key];
      }
      return true
    } else if (hasOwn(hash, altKey)) {
      res[key] = hash[altKey];
      if (!preserve) {
        delete hash[altKey];
      }
      return true
    }
  }
  return false
}

/*  */

// The template compiler attempts to minimize the need for normalization by
// statically analyzing the template at compile time.
//
// For plain HTML markup, normalization can be completely skipped because the
// generated render function is guaranteed to return Array<VNode>. There are
// two cases where extra normalization is needed:

// 1. When the children contains components - because a functional component
// may return an Array instead of a single root. In this case, just a simple
// normalization is needed - if any child is an Array, we flatten the whole
// thing with Array.prototype.concat. It is guaranteed to be only 1-level deep
// because functional components already normalize their own children.
function simpleNormalizeChildren (children) {
  for (var i = 0; i < children.length; i++) {
    if (Array.isArray(children[i])) {
      return Array.prototype.concat.apply([], children)
    }
  }
  return children
}

// 2. When the children contains constructs that always generated nested Arrays,
// e.g. <template>, <slot>, v-for, or when the children is provided by user
// with hand-written render functions / JSX. In such cases a full normalization
// is needed to cater to all possible types of children values.
function normalizeChildren (children) {
  return isPrimitive(children)
    ? [createTextVNode(children)]
    : Array.isArray(children)
      ? normalizeArrayChildren(children)
      : undefined
}

function isTextNode (node) {
  return isDef(node) && isDef(node.text) && isFalse(node.isComment)
}

function normalizeArrayChildren (children, nestedIndex) {
  var res = [];
  var i, c, last;
  for (i = 0; i < children.length; i++) {
    c = children[i];
    if (isUndef(c) || typeof c === 'boolean') { continue }
    last = res[res.length - 1];
    //  nested
    if (Array.isArray(c)) {
      res.push.apply(res, normalizeArrayChildren(c, ((nestedIndex || '') + "_" + i)));
    } else if (isPrimitive(c)) {
      if (isTextNode(last)) {
        // merge adjacent text nodes
        // this is necessary for SSR hydration because text nodes are
        // essentially merged when rendered to HTML strings
        (last).text += String(c);
      } else if (c !== '') {
        // convert primitive to vnode
        res.push(createTextVNode(c));
      }
    } else {
      if (isTextNode(c) && isTextNode(last)) {
        // merge adjacent text nodes
        res[res.length - 1] = createTextVNode(last.text + c.text);
      } else {
        // default key for nested array children (likely generated by v-for)
        if (isTrue(children._isVList) &&
          isDef(c.tag) &&
          isUndef(c.key) &&
          isDef(nestedIndex)) {
          c.key = "__vlist" + nestedIndex + "_" + i + "__";
        }
        res.push(c);
      }
    }
  }
  return res
}

/*  */

function ensureCtor (comp, base) {
  return isObject(comp)
    ? base.extend(comp)
    : comp
}

function resolveAsyncComponent (
  factory,
  baseCtor,
  context
) {
  if (isTrue(factory.error) && isDef(factory.errorComp)) {
    return factory.errorComp
  }

  if (isDef(factory.resolved)) {
    return factory.resolved
  }

  if (isTrue(factory.loading) && isDef(factory.loadingComp)) {
    return factory.loadingComp
  }

  if (isDef(factory.contexts)) {
    // already pending
    factory.contexts.push(context);
  } else {
    var contexts = factory.contexts = [context];
    var sync = true;

    var forceRender = function () {
      for (var i = 0, l = contexts.length; i < l; i++) {
        contexts[i].$forceUpdate();
      }
    };

    var resolve = once(function (res) {
      // cache resolved
      factory.resolved = ensureCtor(res, baseCtor);
      // invoke callbacks only if this is not a synchronous resolve
      // (async resolves are shimmed as synchronous during SSR)
      if (!sync) {
        forceRender();
      }
    });

    var reject = once(function (reason) {
      "development" !== 'production' && warn(
        "Failed to resolve async component: " + (String(factory)) +
        (reason ? ("\nReason: " + reason) : '')
      );
      if (isDef(factory.errorComp)) {
        factory.error = true;
        forceRender();
      }
    });

    var res = factory(resolve, reject);

    if (isObject(res)) {
      if (typeof res.then === 'function') {
        // () => Promise
        if (isUndef(factory.resolved)) {
          res.then(resolve, reject);
        }
      } else if (isDef(res.component) && typeof res.component.then === 'function') {
        res.component.then(resolve, reject);

        if (isDef(res.error)) {
          factory.errorComp = ensureCtor(res.error, baseCtor);
        }

        if (isDef(res.loading)) {
          factory.loadingComp = ensureCtor(res.loading, baseCtor);
          if (res.delay === 0) {
            factory.loading = true;
          } else {
            setTimeout(function () {
              if (isUndef(factory.resolved) && isUndef(factory.error)) {
                factory.loading = true;
                forceRender();
              }
            }, res.delay || 200);
          }
        }

        if (isDef(res.timeout)) {
          setTimeout(function () {
            if (isUndef(factory.resolved)) {
              reject(
                "timeout (" + (res.timeout) + "ms)"
              );
            }
          }, res.timeout);
        }
      }
    }

    sync = false;
    // return in case resolved synchronously
    return factory.loading
      ? factory.loadingComp
      : factory.resolved
  }
}

/*  */

function getFirstComponentChild (children) {
  if (Array.isArray(children)) {
    for (var i = 0; i < children.length; i++) {
      var c = children[i];
      if (isDef(c) && isDef(c.componentOptions)) {
        return c
      }
    }
  }
}

/*  */

/*  */

function initEvents (vm) {
  vm._events = Object.create(null);
  vm._hasHookEvent = false;
  // init parent attached events
  var listeners = vm.$options._parentListeners;
  if (listeners) {
    updateComponentListeners(vm, listeners);
  }
}

var target;

function add (event, fn, once$$1) {
  if (once$$1) {
    target.$once(event, fn);
  } else {
    target.$on(event, fn);
  }
}

function remove$1 (event, fn) {
  target.$off(event, fn);
}

function updateComponentListeners (
  vm,
  listeners,
  oldListeners
) {
  target = vm;
  updateListeners(listeners, oldListeners || {}, add, remove$1, vm);
}

function eventsMixin (Vue) {
  var hookRE = /^hook:/;
  Vue.prototype.$on = function (event, fn) {
    var this$1 = this;

    var vm = this;
    if (Array.isArray(event)) {
      for (var i = 0, l = event.length; i < l; i++) {
        this$1.$on(event[i], fn);
      }
    } else {
      (vm._events[event] || (vm._events[event] = [])).push(fn);
      // optimize hook:event cost by using a boolean flag marked at registration
      // instead of a hash lookup
      if (hookRE.test(event)) {
        vm._hasHookEvent = true;
      }
    }
    return vm
  };

  Vue.prototype.$once = function (event, fn) {
    var vm = this;
    function on () {
      vm.$off(event, on);
      fn.apply(vm, arguments);
    }
    on.fn = fn;
    vm.$on(event, on);
    return vm
  };

  Vue.prototype.$off = function (event, fn) {
    var this$1 = this;

    var vm = this;
    // all
    if (!arguments.length) {
      vm._events = Object.create(null);
      return vm
    }
    // array of events
    if (Array.isArray(event)) {
      for (var i$1 = 0, l = event.length; i$1 < l; i$1++) {
        this$1.$off(event[i$1], fn);
      }
      return vm
    }
    // specific event
    var cbs = vm._events[event];
    if (!cbs) {
      return vm
    }
    if (arguments.length === 1) {
      vm._events[event] = null;
      return vm
    }
    // specific handler
    var cb;
    var i = cbs.length;
    while (i--) {
      cb = cbs[i];
      if (cb === fn || cb.fn === fn) {
        cbs.splice(i, 1);
        break
      }
    }
    return vm
  };

  Vue.prototype.$emit = function (event) {
    var vm = this;
    {
      var lowerCaseEvent = event.toLowerCase();
      if (lowerCaseEvent !== event && vm._events[lowerCaseEvent]) {
        tip(
          "Event \"" + lowerCaseEvent + "\" is emitted in component " +
          (formatComponentName(vm)) + " but the handler is registered for \"" + event + "\". " +
          "Note that HTML attributes are case-insensitive and you cannot use " +
          "v-on to listen to camelCase events when using in-DOM templates. " +
          "You should probably use \"" + (hyphenate(event)) + "\" instead of \"" + event + "\"."
        );
      }
    }
    var cbs = vm._events[event];
    if (cbs) {
      cbs = cbs.length > 1 ? toArray(cbs) : cbs;
      var args = toArray(arguments, 1);
      for (var i = 0, l = cbs.length; i < l; i++) {
        cbs[i].apply(vm, args);
      }
    }
    return vm
  };
}

/*  */

/**
 * Runtime helper for resolving raw children VNodes into a slot object.
 */
function resolveSlots (
  children,
  context
) {
  var slots = {};
  if (!children) {
    return slots
  }
  var defaultSlot = [];
  for (var i = 0, l = children.length; i < l; i++) {
    var child = children[i];
    // named slots should only be respected if the vnode was rendered in the
    // same context.
    if ((child.context === context || child.functionalContext === context) &&
      child.data && child.data.slot != null
    ) {
      var name = child.data.slot;
      var slot = (slots[name] || (slots[name] = []));
      if (child.tag === 'template') {
        slot.push.apply(slot, child.children);
      } else {
        slot.push(child);
      }
    } else {
      defaultSlot.push(child);
    }
  }
  // ignore whitespace
  if (!defaultSlot.every(isWhitespace)) {
    slots.default = defaultSlot;
  }
  return slots
}

function isWhitespace (node) {
  return node.isComment || node.text === ' '
}

function resolveScopedSlots (
  fns, // see flow/vnode
  res
) {
  res = res || {};
  for (var i = 0; i < fns.length; i++) {
    if (Array.isArray(fns[i])) {
      resolveScopedSlots(fns[i], res);
    } else {
      res[fns[i].key] = fns[i].fn;
    }
  }
  return res
}

/*  */

var activeInstance = null;

function initLifecycle (vm) {
  var options = vm.$options;

  // locate first non-abstract parent
  var parent = options.parent;
  if (parent && !options.abstract) {
    while (parent.$options.abstract && parent.$parent) {
      parent = parent.$parent;
    }
    parent.$children.push(vm);
  }

  vm.$parent = parent;
  vm.$root = parent ? parent.$root : vm;

  vm.$children = [];
  vm.$refs = {};

  vm._watcher = null;
  vm._inactive = null;
  vm._directInactive = false;
  vm._isMounted = false;
  vm._isDestroyed = false;
  vm._isBeingDestroyed = false;
}

function lifecycleMixin (Vue) {
  Vue.prototype._update = function (vnode, hydrating) {
    var vm = this;
    if (vm._isMounted) {
      callHook(vm, 'beforeUpdate');
    }
    var prevEl = vm.$el;
    var prevVnode = vm._vnode;
    var prevActiveInstance = activeInstance;
    activeInstance = vm;
    vm._vnode = vnode;
    // Vue.prototype.__patch__ is injected in entry points
    // based on the rendering backend used.
    if (!prevVnode) {
      // initial render
      vm.$el = vm.__patch__(
        vm.$el, vnode, hydrating, false /* removeOnly */,
        vm.$options._parentElm,
        vm.$options._refElm
      );
    } else {
      // updates
      vm.$el = vm.__patch__(prevVnode, vnode);
    }
    activeInstance = prevActiveInstance;
    // update __vue__ reference
    if (prevEl) {
      prevEl.__vue__ = null;
    }
    if (vm.$el) {
      vm.$el.__vue__ = vm;
    }
    // if parent is an HOC, update its $el as well
    if (vm.$vnode && vm.$parent && vm.$vnode === vm.$parent._vnode) {
      vm.$parent.$el = vm.$el;
    }
    // updated hook is called by the scheduler to ensure that children are
    // updated in a parent's updated hook.
  };

  Vue.prototype.$forceUpdate = function () {
    var vm = this;
    if (vm._watcher) {
      vm._watcher.update();
    }
  };

  Vue.prototype.$destroy = function () {
    var vm = this;
    if (vm._isBeingDestroyed) {
      return
    }
    callHook(vm, 'beforeDestroy');
    vm._isBeingDestroyed = true;
    // remove self from parent
    var parent = vm.$parent;
    if (parent && !parent._isBeingDestroyed && !vm.$options.abstract) {
      remove(parent.$children, vm);
    }
    // teardown watchers
    if (vm._watcher) {
      vm._watcher.teardown();
    }
    var i = vm._watchers.length;
    while (i--) {
      vm._watchers[i].teardown();
    }
    // remove reference from data ob
    // frozen object may not have observer.
    if (vm._data.__ob__) {
      vm._data.__ob__.vmCount--;
    }
    // call the last hook...
    vm._isDestroyed = true;
    // invoke destroy hooks on current rendered tree
    vm.__patch__(vm._vnode, null);
    // fire destroyed hook
    callHook(vm, 'destroyed');
    // turn off all instance listeners.
    vm.$off();
    // remove __vue__ reference
    if (vm.$el) {
      vm.$el.__vue__ = null;
    }
    // remove reference to DOM nodes (prevents leak)
    vm.$options._parentElm = vm.$options._refElm = null;
  };
}

function mountComponent (
  vm,
  el,
  hydrating
) {
  vm.$el = el;
  if (!vm.$options.render) {
    vm.$options.render = createEmptyVNode;
    {
      /* istanbul ignore if */
      if ((vm.$options.template && vm.$options.template.charAt(0) !== '#') ||
        vm.$options.el || el) {
        warn(
          'You are using the runtime-only build of Vue where the template ' +
          'compiler is not available. Either pre-compile the templates into ' +
          'render functions, or use the compiler-included build.',
          vm
        );
      } else {
        warn(
          'Failed to mount component: template or render function not defined.',
          vm
        );
      }
    }
  }
  callHook(vm, 'beforeMount');

  var updateComponent;
  /* istanbul ignore if */
  if ("development" !== 'production' && config.performance && mark) {
    updateComponent = function () {
      var name = vm._name;
      var id = vm._uid;
      var startTag = "vue-perf-start:" + id;
      var endTag = "vue-perf-end:" + id;

      mark(startTag);
      var vnode = vm._render();
      mark(endTag);
      measure((name + " render"), startTag, endTag);

      mark(startTag);
      vm._update(vnode, hydrating);
      mark(endTag);
      measure((name + " patch"), startTag, endTag);
    };
  } else {
    updateComponent = function () {
      vm._update(vm._render(), hydrating);
    };
  }

  vm._watcher = new Watcher(vm, updateComponent, noop);
  hydrating = false;

  // manually mounted instance, call mounted on self
  // mounted is called for render-created child components in its inserted hook
  if (vm.$vnode == null) {
    vm._isMounted = true;
    callHook(vm, 'mounted');
  }
  return vm
}

function updateChildComponent (
  vm,
  propsData,
  listeners,
  parentVnode,
  renderChildren
) {
  // determine whether component has slot children
  // we need to do this before overwriting $options._renderChildren
  var hasChildren = !!(
    renderChildren ||               // has new static slots
    vm.$options._renderChildren ||  // has old static slots
    parentVnode.data.scopedSlots || // has new scoped slots
    vm.$scopedSlots !== emptyObject // has old scoped slots
  );

  vm.$options._parentVnode = parentVnode;
  vm.$vnode = parentVnode; // update vm's placeholder node without re-render
  if (vm._vnode) { // update child tree's parent
    vm._vnode.parent = parentVnode;
  }
  vm.$options._renderChildren = renderChildren;

  // update props
  if (propsData && vm.$options.props) {
    observerState.shouldConvert = false;
    {
      observerState.isSettingProps = true;
    }
    var props = vm._props;
    var propKeys = vm.$options._propKeys || [];
    for (var i = 0; i < propKeys.length; i++) {
      var key = propKeys[i];
      props[key] = validateProp(key, vm.$options.props, propsData, vm);
    }
    observerState.shouldConvert = true;
    {
      observerState.isSettingProps = false;
    }
    // keep a copy of raw propsData
    vm.$options.propsData = propsData;
  }
  // update listeners
  if (listeners) {
    var oldListeners = vm.$options._parentListeners;
    vm.$options._parentListeners = listeners;
    updateComponentListeners(vm, listeners, oldListeners);
  }
  // resolve slots + force update if has children
  if (hasChildren) {
    vm.$slots = resolveSlots(renderChildren, parentVnode.context);
    vm.$forceUpdate();
  }
}

function isInInactiveTree (vm) {
  while (vm && (vm = vm.$parent)) {
    if (vm._inactive) { return true }
  }
  return false
}

function activateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = false;
    if (isInInactiveTree(vm)) {
      return
    }
  } else if (vm._directInactive) {
    return
  }
  if (vm._inactive || vm._inactive === null) {
    vm._inactive = false;
    for (var i = 0; i < vm.$children.length; i++) {
      activateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'activated');
  }
}

function deactivateChildComponent (vm, direct) {
  if (direct) {
    vm._directInactive = true;
    if (isInInactiveTree(vm)) {
      return
    }
  }
  if (!vm._inactive) {
    vm._inactive = true;
    for (var i = 0; i < vm.$children.length; i++) {
      deactivateChildComponent(vm.$children[i]);
    }
    callHook(vm, 'deactivated');
  }
}

function callHook (vm, hook) {
  var handlers = vm.$options[hook];
  if (handlers) {
    for (var i = 0, j = handlers.length; i < j; i++) {
      try {
        handlers[i].call(vm);
      } catch (e) {
        handleError(e, vm, (hook + " hook"));
      }
    }
  }
  if (vm._hasHookEvent) {
    vm.$emit('hook:' + hook);
  }
}

/*  */


var MAX_UPDATE_COUNT = 100;

var queue = [];
var activatedChildren = [];
var has = {};
var circular = {};
var waiting = false;
var flushing = false;
var index = 0;

/**
 * Reset the scheduler's state.
 */
function resetSchedulerState () {
  index = queue.length = activatedChildren.length = 0;
  has = {};
  {
    circular = {};
  }
  waiting = flushing = false;
}

/**
 * Flush both queues and run the watchers.
 */
function flushSchedulerQueue () {
  flushing = true;
  var watcher, id;

  // Sort queue before flush.
  // This ensures that:
  // 1. Components are updated from parent to child. (because parent is always
  //    created before the child)
  // 2. A component's user watchers are run before its render watcher (because
  //    user watchers are created before the render watcher)
  // 3. If a component is destroyed during a parent component's watcher run,
  //    its watchers can be skipped.
  queue.sort(function (a, b) { return a.id - b.id; });

  // do not cache length because more watchers might be pushed
  // as we run existing watchers
  for (index = 0; index < queue.length; index++) {
    watcher = queue[index];
    id = watcher.id;
    has[id] = null;
    watcher.run();
    // in dev build, check and stop circular updates.
    if ("development" !== 'production' && has[id] != null) {
      circular[id] = (circular[id] || 0) + 1;
      if (circular[id] > MAX_UPDATE_COUNT) {
        warn(
          'You may have an infinite update loop ' + (
            watcher.user
              ? ("in watcher with expression \"" + (watcher.expression) + "\"")
              : "in a component render function."
          ),
          watcher.vm
        );
        break
      }
    }
  }

  // keep copies of post queues before resetting state
  var activatedQueue = activatedChildren.slice();
  var updatedQueue = queue.slice();

  resetSchedulerState();

  // call component updated and activated hooks
  callActivatedHooks(activatedQueue);
  callUpdateHooks(updatedQueue);

  // devtool hook
  /* istanbul ignore if */
  if (devtools && config.devtools) {
    devtools.emit('flush');
  }
}

function callUpdateHooks (queue) {
  var i = queue.length;
  while (i--) {
    var watcher = queue[i];
    var vm = watcher.vm;
    if (vm._watcher === watcher && vm._isMounted) {
      callHook(vm, 'updated');
    }
  }
}

/**
 * Queue a kept-alive component that was activated during patch.
 * The queue will be processed after the entire tree has been patched.
 */
function queueActivatedComponent (vm) {
  // setting _inactive to false here so that a render function can
  // rely on checking whether it's in an inactive tree (e.g. router-view)
  vm._inactive = false;
  activatedChildren.push(vm);
}

function callActivatedHooks (queue) {
  for (var i = 0; i < queue.length; i++) {
    queue[i]._inactive = true;
    activateChildComponent(queue[i], true /* true */);
  }
}

/**
 * Push a watcher into the watcher queue.
 * Jobs with duplicate IDs will be skipped unless it's
 * pushed when the queue is being flushed.
 */
function queueWatcher (watcher) {
  var id = watcher.id;
  if (has[id] == null) {
    has[id] = true;
    if (!flushing) {
      queue.push(watcher);
    } else {
      // if already flushing, splice the watcher based on its id
      // if already past its id, it will be run next immediately.
      var i = queue.length - 1;
      while (i > index && queue[i].id > watcher.id) {
        i--;
      }
      queue.splice(i + 1, 0, watcher);
    }
    // queue the flush
    if (!waiting) {
      waiting = true;
      nextTick(flushSchedulerQueue);
    }
  }
}

/*  */

var uid$2 = 0;

/**
 * A watcher parses an expression, collects dependencies,
 * and fires callback when the expression value changes.
 * This is used for both the $watch() api and directives.
 */
var Watcher = function Watcher (
  vm,
  expOrFn,
  cb,
  options
) {
  this.vm = vm;
  vm._watchers.push(this);
  // options
  if (options) {
    this.deep = !!options.deep;
    this.user = !!options.user;
    this.lazy = !!options.lazy;
    this.sync = !!options.sync;
  } else {
    this.deep = this.user = this.lazy = this.sync = false;
  }
  this.cb = cb;
  this.id = ++uid$2; // uid for batching
  this.active = true;
  this.dirty = this.lazy; // for lazy watchers
  this.deps = [];
  this.newDeps = [];
  this.depIds = new _Set();
  this.newDepIds = new _Set();
  this.expression = expOrFn.toString();
  // parse expression for getter
  if (typeof expOrFn === 'function') {
    this.getter = expOrFn;
  } else {
    this.getter = parsePath(expOrFn);
    if (!this.getter) {
      this.getter = function () {};
      "development" !== 'production' && warn(
        "Failed watching path: \"" + expOrFn + "\" " +
        'Watcher only accepts simple dot-delimited paths. ' +
        'For full control, use a function instead.',
        vm
      );
    }
  }
  this.value = this.lazy
    ? undefined
    : this.get();
};

/**
 * Evaluate the getter, and re-collect dependencies.
 */
Watcher.prototype.get = function get () {
  pushTarget(this);
  var value;
  var vm = this.vm;
  if (this.user) {
    try {
      value = this.getter.call(vm, vm);
    } catch (e) {
      handleError(e, vm, ("getter for watcher \"" + (this.expression) + "\""));
    }
  } else {
    value = this.getter.call(vm, vm);
  }
  // "touch" every property so they are all tracked as
  // dependencies for deep watching
  if (this.deep) {
    traverse(value);
  }
  popTarget();
  this.cleanupDeps();
  return value
};

/**
 * Add a dependency to this directive.
 */
Watcher.prototype.addDep = function addDep (dep) {
  var id = dep.id;
  if (!this.newDepIds.has(id)) {
    this.newDepIds.add(id);
    this.newDeps.push(dep);
    if (!this.depIds.has(id)) {
      dep.addSub(this);
    }
  }
};

/**
 * Clean up for dependency collection.
 */
Watcher.prototype.cleanupDeps = function cleanupDeps () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    var dep = this$1.deps[i];
    if (!this$1.newDepIds.has(dep.id)) {
      dep.removeSub(this$1);
    }
  }
  var tmp = this.depIds;
  this.depIds = this.newDepIds;
  this.newDepIds = tmp;
  this.newDepIds.clear();
  tmp = this.deps;
  this.deps = this.newDeps;
  this.newDeps = tmp;
  this.newDeps.length = 0;
};

/**
 * Subscriber interface.
 * Will be called when a dependency changes.
 */
Watcher.prototype.update = function update () {
  /* istanbul ignore else */
  if (this.lazy) {
    this.dirty = true;
  } else if (this.sync) {
    this.run();
  } else {
    queueWatcher(this);
  }
};

/**
 * Scheduler job interface.
 * Will be called by the scheduler.
 */
Watcher.prototype.run = function run () {
  if (this.active) {
    var value = this.get();
    if (
      value !== this.value ||
      // Deep watchers and watchers on Object/Arrays should fire even
      // when the value is the same, because the value may
      // have mutated.
      isObject(value) ||
      this.deep
    ) {
      // set new value
      var oldValue = this.value;
      this.value = value;
      if (this.user) {
        try {
          this.cb.call(this.vm, value, oldValue);
        } catch (e) {
          handleError(e, this.vm, ("callback for watcher \"" + (this.expression) + "\""));
        }
      } else {
        this.cb.call(this.vm, value, oldValue);
      }
    }
  }
};

/**
 * Evaluate the value of the watcher.
 * This only gets called for lazy watchers.
 */
Watcher.prototype.evaluate = function evaluate () {
  this.value = this.get();
  this.dirty = false;
};

/**
 * Depend on all deps collected by this watcher.
 */
Watcher.prototype.depend = function depend () {
    var this$1 = this;

  var i = this.deps.length;
  while (i--) {
    this$1.deps[i].depend();
  }
};

/**
 * Remove self from all dependencies' subscriber list.
 */
Watcher.prototype.teardown = function teardown () {
    var this$1 = this;

  if (this.active) {
    // remove self from vm's watcher list
    // this is a somewhat expensive operation so we skip it
    // if the vm is being destroyed.
    if (!this.vm._isBeingDestroyed) {
      remove(this.vm._watchers, this);
    }
    var i = this.deps.length;
    while (i--) {
      this$1.deps[i].removeSub(this$1);
    }
    this.active = false;
  }
};

/**
 * Recursively traverse an object to evoke all converted
 * getters, so that every nested property inside the object
 * is collected as a "deep" dependency.
 */
var seenObjects = new _Set();
function traverse (val) {
  seenObjects.clear();
  _traverse(val, seenObjects);
}

function _traverse (val, seen) {
  var i, keys;
  var isA = Array.isArray(val);
  if ((!isA && !isObject(val)) || !Object.isExtensible(val)) {
    return
  }
  if (val.__ob__) {
    var depId = val.__ob__.dep.id;
    if (seen.has(depId)) {
      return
    }
    seen.add(depId);
  }
  if (isA) {
    i = val.length;
    while (i--) { _traverse(val[i], seen); }
  } else {
    keys = Object.keys(val);
    i = keys.length;
    while (i--) { _traverse(val[keys[i]], seen); }
  }
}

/*  */

var sharedPropertyDefinition = {
  enumerable: true,
  configurable: true,
  get: noop,
  set: noop
};

function proxy (target, sourceKey, key) {
  sharedPropertyDefinition.get = function proxyGetter () {
    return this[sourceKey][key]
  };
  sharedPropertyDefinition.set = function proxySetter (val) {
    this[sourceKey][key] = val;
  };
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function initState (vm) {
  vm._watchers = [];
  var opts = vm.$options;
  if (opts.props) { initProps(vm, opts.props); }
  if (opts.methods) { initMethods(vm, opts.methods); }
  if (opts.data) {
    initData(vm);
  } else {
    observe(vm._data = {}, true /* asRootData */);
  }
  if (opts.computed) { initComputed(vm, opts.computed); }
  if (opts.watch) { initWatch(vm, opts.watch); }
}

var isReservedProp = {
  key: 1,
  ref: 1,
  slot: 1
};

function initProps (vm, propsOptions) {
  var propsData = vm.$options.propsData || {};
  var props = vm._props = {};
  // cache prop keys so that future props updates can iterate using Array
  // instead of dynamic object key enumeration.
  var keys = vm.$options._propKeys = [];
  var isRoot = !vm.$parent;
  // root instance props should be converted
  observerState.shouldConvert = isRoot;
  var loop = function ( key ) {
    keys.push(key);
    var value = validateProp(key, propsOptions, propsData, vm);
    /* istanbul ignore else */
    {
      if (isReservedProp[key] || config.isReservedAttr(key)) {
        warn(
          ("\"" + key + "\" is a reserved attribute and cannot be used as component prop."),
          vm
        );
      }
      defineReactive$$1(props, key, value, function () {
        if (vm.$parent && !observerState.isSettingProps) {
          warn(
            "Avoid mutating a prop directly since the value will be " +
            "overwritten whenever the parent component re-renders. " +
            "Instead, use a data or computed property based on the prop's " +
            "value. Prop being mutated: \"" + key + "\"",
            vm
          );
        }
      });
    }
    // static props are already proxied on the component's prototype
    // during Vue.extend(). We only need to proxy props defined at
    // instantiation here.
    if (!(key in vm)) {
      proxy(vm, "_props", key);
    }
  };

  for (var key in propsOptions) loop( key );
  observerState.shouldConvert = true;
}

function initData (vm) {
  var data = vm.$options.data;
  data = vm._data = typeof data === 'function'
    ? getData(data, vm)
    : data || {};
  if (!isPlainObject(data)) {
    data = {};
    "development" !== 'production' && warn(
      'data functions should return an object:\n' +
      'https://vuejs.org/v2/guide/components.html#data-Must-Be-a-Function',
      vm
    );
  }
  // proxy data on instance
  var keys = Object.keys(data);
  var props = vm.$options.props;
  var i = keys.length;
  while (i--) {
    if (props && hasOwn(props, keys[i])) {
      "development" !== 'production' && warn(
        "The data property \"" + (keys[i]) + "\" is already declared as a prop. " +
        "Use prop default value instead.",
        vm
      );
    } else if (!isReserved(keys[i])) {
      proxy(vm, "_data", keys[i]);
    }
  }
  // observe data
  observe(data, true /* asRootData */);
}

function getData (data, vm) {
  try {
    return data.call(vm)
  } catch (e) {
    handleError(e, vm, "data()");
    return {}
  }
}

var computedWatcherOptions = { lazy: true };

function initComputed (vm, computed) {
  var watchers = vm._computedWatchers = Object.create(null);

  for (var key in computed) {
    var userDef = computed[key];
    var getter = typeof userDef === 'function' ? userDef : userDef.get;
    {
      if (getter === undefined) {
        warn(
          ("No getter function has been defined for computed property \"" + key + "\"."),
          vm
        );
        getter = noop;
      }
    }
    // create internal watcher for the computed property.
    watchers[key] = new Watcher(vm, getter, noop, computedWatcherOptions);

    // component-defined computed properties are already defined on the
    // component prototype. We only need to define computed properties defined
    // at instantiation here.
    if (!(key in vm)) {
      defineComputed(vm, key, userDef);
    } else {
      if (key in vm.$data) {
        warn(("The computed property \"" + key + "\" is already defined in data."), vm);
      } else if (vm.$options.props && key in vm.$options.props) {
        warn(("The computed property \"" + key + "\" is already defined as a prop."), vm);
      }
    }
  }
}

function defineComputed (target, key, userDef) {
  if (typeof userDef === 'function') {
    sharedPropertyDefinition.get = createComputedGetter(key);
    sharedPropertyDefinition.set = noop;
  } else {
    sharedPropertyDefinition.get = userDef.get
      ? userDef.cache !== false
        ? createComputedGetter(key)
        : userDef.get
      : noop;
    sharedPropertyDefinition.set = userDef.set
      ? userDef.set
      : noop;
  }
  Object.defineProperty(target, key, sharedPropertyDefinition);
}

function createComputedGetter (key) {
  return function computedGetter () {
    var watcher = this._computedWatchers && this._computedWatchers[key];
    if (watcher) {
      if (watcher.dirty) {
        watcher.evaluate();
      }
      if (Dep.target) {
        watcher.depend();
      }
      return watcher.value
    }
  }
}

function initMethods (vm, methods) {
  var props = vm.$options.props;
  for (var key in methods) {
    vm[key] = methods[key] == null ? noop : bind(methods[key], vm);
    {
      if (methods[key] == null) {
        warn(
          "method \"" + key + "\" has an undefined value in the component definition. " +
          "Did you reference the function correctly?",
          vm
        );
      }
      if (props && hasOwn(props, key)) {
        warn(
          ("method \"" + key + "\" has already been defined as a prop."),
          vm
        );
      }
    }
  }
}

function initWatch (vm, watch) {
  for (var key in watch) {
    var handler = watch[key];
    if (Array.isArray(handler)) {
      for (var i = 0; i < handler.length; i++) {
        createWatcher(vm, key, handler[i]);
      }
    } else {
      createWatcher(vm, key, handler);
    }
  }
}

function createWatcher (vm, key, handler) {
  var options;
  if (isPlainObject(handler)) {
    options = handler;
    handler = handler.handler;
  }
  if (typeof handler === 'string') {
    handler = vm[handler];
  }
  vm.$watch(key, handler, options);
}

function stateMixin (Vue) {
  // flow somehow has problems with directly declared definition object
  // when using Object.defineProperty, so we have to procedurally build up
  // the object here.
  var dataDef = {};
  dataDef.get = function () { return this._data };
  var propsDef = {};
  propsDef.get = function () { return this._props };
  {
    dataDef.set = function (newData) {
      warn(
        'Avoid replacing instance root $data. ' +
        'Use nested data properties instead.',
        this
      );
    };
    propsDef.set = function () {
      warn("$props is readonly.", this);
    };
  }
  Object.defineProperty(Vue.prototype, '$data', dataDef);
  Object.defineProperty(Vue.prototype, '$props', propsDef);

  Vue.prototype.$set = set;
  Vue.prototype.$delete = del;

  Vue.prototype.$watch = function (
    expOrFn,
    cb,
    options
  ) {
    var vm = this;
    options = options || {};
    options.user = true;
    var watcher = new Watcher(vm, expOrFn, cb, options);
    if (options.immediate) {
      cb.call(vm, watcher.value);
    }
    return function unwatchFn () {
      watcher.teardown();
    }
  };
}

/*  */

function initProvide (vm) {
  var provide = vm.$options.provide;
  if (provide) {
    vm._provided = typeof provide === 'function'
      ? provide.call(vm)
      : provide;
  }
}

function initInjections (vm) {
  var result = resolveInject(vm.$options.inject, vm);
  if (result) {
    Object.keys(result).forEach(function (key) {
      /* istanbul ignore else */
      {
        defineReactive$$1(vm, key, result[key], function () {
          warn(
            "Avoid mutating an injected value directly since the changes will be " +
            "overwritten whenever the provided component re-renders. " +
            "injection being mutated: \"" + key + "\"",
            vm
          );
        });
      }
    });
  }
}

function resolveInject (inject, vm) {
  if (inject) {
    // inject is :any because flow is not smart enough to figure out cached
    // isArray here
    var isArray = Array.isArray(inject);
    var result = Object.create(null);
    var keys = isArray
      ? inject
      : hasSymbol
        ? Reflect.ownKeys(inject)
        : Object.keys(inject);

    for (var i = 0; i < keys.length; i++) {
      var key = keys[i];
      var provideKey = isArray ? key : inject[key];
      var source = vm;
      while (source) {
        if (source._provided && provideKey in source._provided) {
          result[key] = source._provided[provideKey];
          break
        }
        source = source.$parent;
      }
    }
    return result
  }
}

/*  */

function createFunctionalComponent (
  Ctor,
  propsData,
  data,
  context,
  children
) {
  var props = {};
  var propOptions = Ctor.options.props;
  if (isDef(propOptions)) {
    for (var key in propOptions) {
      props[key] = validateProp(key, propOptions, propsData || {});
    }
  } else {
    if (isDef(data.attrs)) { mergeProps(props, data.attrs); }
    if (isDef(data.props)) { mergeProps(props, data.props); }
  }
  // ensure the createElement function in functional components
  // gets a unique context - this is necessary for correct named slot check
  var _context = Object.create(context);
  var h = function (a, b, c, d) { return createElement(_context, a, b, c, d, true); };
  var vnode = Ctor.options.render.call(null, h, {
    data: data,
    props: props,
    children: children,
    parent: context,
    listeners: data.on || {},
    injections: resolveInject(Ctor.options.inject, context),
    slots: function () { return resolveSlots(children, context); }
  });
  if (vnode instanceof VNode) {
    vnode.functionalContext = context;
    vnode.functionalOptions = Ctor.options;
    if (data.slot) {
      (vnode.data || (vnode.data = {})).slot = data.slot;
    }
  }
  return vnode
}

function mergeProps (to, from) {
  for (var key in from) {
    to[camelize(key)] = from[key];
  }
}

/*  */

// hooks to be invoked on component VNodes during patch
var componentVNodeHooks = {
  init: function init (
    vnode,
    hydrating,
    parentElm,
    refElm
  ) {
    if (!vnode.componentInstance || vnode.componentInstance._isDestroyed) {
      var child = vnode.componentInstance = createComponentInstanceForVnode(
        vnode,
        activeInstance,
        parentElm,
        refElm
      );
      child.$mount(hydrating ? vnode.elm : undefined, hydrating);
    } else if (vnode.data.keepAlive) {
      // kept-alive components, treat as a patch
      var mountedNode = vnode; // work around flow
      componentVNodeHooks.prepatch(mountedNode, mountedNode);
    }
  },

  prepatch: function prepatch (oldVnode, vnode) {
    var options = vnode.componentOptions;
    var child = vnode.componentInstance = oldVnode.componentInstance;
    updateChildComponent(
      child,
      options.propsData, // updated props
      options.listeners, // updated listeners
      vnode, // new parent vnode
      options.children // new children
    );
  },

  insert: function insert (vnode) {
    var context = vnode.context;
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isMounted) {
      componentInstance._isMounted = true;
      callHook(componentInstance, 'mounted');
    }
    if (vnode.data.keepAlive) {
      if (context._isMounted) {
        // vue-router#1212
        // During updates, a kept-alive component's child components may
        // change, so directly walking the tree here may call activated hooks
        // on incorrect children. Instead we push them into a queue which will
        // be processed after the whole patch process ended.
        queueActivatedComponent(componentInstance);
      } else {
        activateChildComponent(componentInstance, true /* direct */);
      }
    }
  },

  destroy: function destroy (vnode) {
    var componentInstance = vnode.componentInstance;
    if (!componentInstance._isDestroyed) {
      if (!vnode.data.keepAlive) {
        componentInstance.$destroy();
      } else {
        deactivateChildComponent(componentInstance, true /* direct */);
      }
    }
  }
};

var hooksToMerge = Object.keys(componentVNodeHooks);

function createComponent (
  Ctor,
  data,
  context,
  children,
  tag
) {
  if (isUndef(Ctor)) {
    return
  }

  var baseCtor = context.$options._base;

  // plain options object: turn it into a constructor
  if (isObject(Ctor)) {
    Ctor = baseCtor.extend(Ctor);
  }

  // if at this stage it's not a constructor or an async component factory,
  // reject.
  if (typeof Ctor !== 'function') {
    {
      warn(("Invalid Component definition: " + (String(Ctor))), context);
    }
    return
  }

  // async component
  if (isUndef(Ctor.cid)) {
    Ctor = resolveAsyncComponent(Ctor, baseCtor, context);
    if (Ctor === undefined) {
      // return nothing if this is indeed an async component
      // wait for the callback to trigger parent update.
      return
    }
  }

  // resolve constructor options in case global mixins are applied after
  // component constructor creation
  resolveConstructorOptions(Ctor);

  data = data || {};

  // transform component v-model data into props & events
  if (isDef(data.model)) {
    transformModel(Ctor.options, data);
  }

  // extract props
  var propsData = extractPropsFromVNodeData(data, Ctor, tag);

  // functional component
  if (isTrue(Ctor.options.functional)) {
    return createFunctionalComponent(Ctor, propsData, data, context, children)
  }

  // extract listeners, since these needs to be treated as
  // child component listeners instead of DOM listeners
  var listeners = data.on;
  // replace with listeners with .native modifier
  data.on = data.nativeOn;

  if (isTrue(Ctor.options.abstract)) {
    // abstract components do not keep anything
    // other than props & listeners
    data = {};
  }

  // merge component management hooks onto the placeholder node
  mergeHooks(data);

  // return a placeholder vnode
  var name = Ctor.options.name || tag;
  var vnode = new VNode(
    ("vue-component-" + (Ctor.cid) + (name ? ("-" + name) : '')),
    data, undefined, undefined, undefined, context,
    { Ctor: Ctor, propsData: propsData, listeners: listeners, tag: tag, children: children }
  );
  return vnode
}

function createComponentInstanceForVnode (
  vnode, // we know it's MountedComponentVNode but flow doesn't
  parent, // activeInstance in lifecycle state
  parentElm,
  refElm
) {
  var vnodeComponentOptions = vnode.componentOptions;
  var options = {
    _isComponent: true,
    parent: parent,
    propsData: vnodeComponentOptions.propsData,
    _componentTag: vnodeComponentOptions.tag,
    _parentVnode: vnode,
    _parentListeners: vnodeComponentOptions.listeners,
    _renderChildren: vnodeComponentOptions.children,
    _parentElm: parentElm || null,
    _refElm: refElm || null
  };
  // check inline-template render functions
  var inlineTemplate = vnode.data.inlineTemplate;
  if (isDef(inlineTemplate)) {
    options.render = inlineTemplate.render;
    options.staticRenderFns = inlineTemplate.staticRenderFns;
  }
  return new vnodeComponentOptions.Ctor(options)
}

function mergeHooks (data) {
  if (!data.hook) {
    data.hook = {};
  }
  for (var i = 0; i < hooksToMerge.length; i++) {
    var key = hooksToMerge[i];
    var fromParent = data.hook[key];
    var ours = componentVNodeHooks[key];
    data.hook[key] = fromParent ? mergeHook$1(ours, fromParent) : ours;
  }
}

function mergeHook$1 (one, two) {
  return function (a, b, c, d) {
    one(a, b, c, d);
    two(a, b, c, d);
  }
}

// transform component v-model info (value and callback) into
// prop and event handler respectively.
function transformModel (options, data) {
  var prop = (options.model && options.model.prop) || 'value';
  var event = (options.model && options.model.event) || 'input';(data.props || (data.props = {}))[prop] = data.model.value;
  var on = data.on || (data.on = {});
  if (isDef(on[event])) {
    on[event] = [data.model.callback].concat(on[event]);
  } else {
    on[event] = data.model.callback;
  }
}

/*  */

var SIMPLE_NORMALIZE = 1;
var ALWAYS_NORMALIZE = 2;

// wrapper function for providing a more flexible interface
// without getting yelled at by flow
function createElement (
  context,
  tag,
  data,
  children,
  normalizationType,
  alwaysNormalize
) {
  if (Array.isArray(data) || isPrimitive(data)) {
    normalizationType = children;
    children = data;
    data = undefined;
  }
  if (isTrue(alwaysNormalize)) {
    normalizationType = ALWAYS_NORMALIZE;
  }
  return _createElement(context, tag, data, children, normalizationType)
}

function _createElement (
  context,
  tag,
  data,
  children,
  normalizationType
) {
  if (isDef(data) && isDef((data).__ob__)) {
    "development" !== 'production' && warn(
      "Avoid using observed data object as vnode data: " + (JSON.stringify(data)) + "\n" +
      'Always create fresh vnode data objects in each render!',
      context
    );
    return createEmptyVNode()
  }
  if (!tag) {
    // in case of component :is set to falsy value
    return createEmptyVNode()
  }
  // support single function children as default scoped slot
  if (Array.isArray(children) &&
    typeof children[0] === 'function'
  ) {
    data = data || {};
    data.scopedSlots = { default: children[0] };
    children.length = 0;
  }
  if (normalizationType === ALWAYS_NORMALIZE) {
    children = normalizeChildren(children);
  } else if (normalizationType === SIMPLE_NORMALIZE) {
    children = simpleNormalizeChildren(children);
  }
  var vnode, ns;
  if (typeof tag === 'string') {
    var Ctor;
    ns = config.getTagNamespace(tag);
    if (config.isReservedTag(tag)) {
      // platform built-in elements
      vnode = new VNode(
        config.parsePlatformTagName(tag), data, children,
        undefined, undefined, context
      );
    } else if (isDef(Ctor = resolveAsset(context.$options, 'components', tag))) {
      // component
      vnode = createComponent(Ctor, data, context, children, tag);
    } else {
      // unknown or unlisted namespaced elements
      // check at runtime because it may get assigned a namespace when its
      // parent normalizes children
      vnode = new VNode(
        tag, data, children,
        undefined, undefined, context
      );
    }
  } else {
    // direct component options / constructor
    vnode = createComponent(tag, data, context, children);
  }
  if (isDef(vnode)) {
    if (ns) { applyNS(vnode, ns); }
    return vnode
  } else {
    return createEmptyVNode()
  }
}

function applyNS (vnode, ns) {
  vnode.ns = ns;
  if (vnode.tag === 'foreignObject') {
    // use default namespace inside foreignObject
    return
  }
  if (isDef(vnode.children)) {
    for (var i = 0, l = vnode.children.length; i < l; i++) {
      var child = vnode.children[i];
      if (isDef(child.tag) && isUndef(child.ns)) {
        applyNS(child, ns);
      }
    }
  }
}

/*  */

/**
 * Runtime helper for rendering v-for lists.
 */
function renderList (
  val,
  render
) {
  var ret, i, l, keys, key;
  if (Array.isArray(val) || typeof val === 'string') {
    ret = new Array(val.length);
    for (i = 0, l = val.length; i < l; i++) {
      ret[i] = render(val[i], i);
    }
  } else if (typeof val === 'number') {
    ret = new Array(val);
    for (i = 0; i < val; i++) {
      ret[i] = render(i + 1, i);
    }
  } else if (isObject(val)) {
    keys = Object.keys(val);
    ret = new Array(keys.length);
    for (i = 0, l = keys.length; i < l; i++) {
      key = keys[i];
      ret[i] = render(val[key], key, i);
    }
  }
  if (isDef(ret)) {
    (ret)._isVList = true;
  }
  return ret
}

/*  */

/**
 * Runtime helper for rendering <slot>
 */
function renderSlot (
  name,
  fallback,
  props,
  bindObject
) {
  var scopedSlotFn = this.$scopedSlots[name];
  if (scopedSlotFn) { // scoped slot
    props = props || {};
    if (bindObject) {
      extend(props, bindObject);
    }
    return scopedSlotFn(props) || fallback
  } else {
    var slotNodes = this.$slots[name];
    // warn duplicate slot usage
    if (slotNodes && "development" !== 'production') {
      slotNodes._rendered && warn(
        "Duplicate presence of slot \"" + name + "\" found in the same render tree " +
        "- this will likely cause render errors.",
        this
      );
      slotNodes._rendered = true;
    }
    return slotNodes || fallback
  }
}

/*  */

/**
 * Runtime helper for resolving filters
 */
function resolveFilter (id) {
  return resolveAsset(this.$options, 'filters', id, true) || identity
}

/*  */

/**
 * Runtime helper for checking keyCodes from config.
 */
function checkKeyCodes (
  eventKeyCode,
  key,
  builtInAlias
) {
  var keyCodes = config.keyCodes[key] || builtInAlias;
  if (Array.isArray(keyCodes)) {
    return keyCodes.indexOf(eventKeyCode) === -1
  } else {
    return keyCodes !== eventKeyCode
  }
}

/*  */

/**
 * Runtime helper for merging v-bind="object" into a VNode's data.
 */
function bindObjectProps (
  data,
  tag,
  value,
  asProp
) {
  if (value) {
    if (!isObject(value)) {
      "development" !== 'production' && warn(
        'v-bind without argument expects an Object or Array value',
        this
      );
    } else {
      if (Array.isArray(value)) {
        value = toObject(value);
      }
      var hash;
      for (var key in value) {
        if (key === 'class' || key === 'style') {
          hash = data;
        } else {
          var type = data.attrs && data.attrs.type;
          hash = asProp || config.mustUseProp(tag, type, key)
            ? data.domProps || (data.domProps = {})
            : data.attrs || (data.attrs = {});
        }
        if (!(key in hash)) {
          hash[key] = value[key];
        }
      }
    }
  }
  return data
}

/*  */

/**
 * Runtime helper for rendering static trees.
 */
function renderStatic (
  index,
  isInFor
) {
  var tree = this._staticTrees[index];
  // if has already-rendered static tree and not inside v-for,
  // we can reuse the same tree by doing a shallow clone.
  if (tree && !isInFor) {
    return Array.isArray(tree)
      ? cloneVNodes(tree)
      : cloneVNode(tree)
  }
  // otherwise, render a fresh tree.
  tree = this._staticTrees[index] =
    this.$options.staticRenderFns[index].call(this._renderProxy);
  markStatic(tree, ("__static__" + index), false);
  return tree
}

/**
 * Runtime helper for v-once.
 * Effectively it means marking the node as static with a unique key.
 */
function markOnce (
  tree,
  index,
  key
) {
  markStatic(tree, ("__once__" + index + (key ? ("_" + key) : "")), true);
  return tree
}

function markStatic (
  tree,
  key,
  isOnce
) {
  if (Array.isArray(tree)) {
    for (var i = 0; i < tree.length; i++) {
      if (tree[i] && typeof tree[i] !== 'string') {
        markStaticNode(tree[i], (key + "_" + i), isOnce);
      }
    }
  } else {
    markStaticNode(tree, key, isOnce);
  }
}

function markStaticNode (node, key, isOnce) {
  node.isStatic = true;
  node.key = key;
  node.isOnce = isOnce;
}

/*  */

function initRender (vm) {
  vm._vnode = null; // the root of the child tree
  vm._staticTrees = null;
  var parentVnode = vm.$vnode = vm.$options._parentVnode; // the placeholder node in parent tree
  var renderContext = parentVnode && parentVnode.context;
  vm.$slots = resolveSlots(vm.$options._renderChildren, renderContext);
  vm.$scopedSlots = emptyObject;
  // bind the createElement fn to this instance
  // so that we get proper render context inside it.
  // args order: tag, data, children, normalizationType, alwaysNormalize
  // internal version is used by render functions compiled from templates
  vm._c = function (a, b, c, d) { return createElement(vm, a, b, c, d, false); };
  // normalization is always applied for the public version, used in
  // user-written render functions.
  vm.$createElement = function (a, b, c, d) { return createElement(vm, a, b, c, d, true); };
}

function renderMixin (Vue) {
  Vue.prototype.$nextTick = function (fn) {
    return nextTick(fn, this)
  };

  Vue.prototype._render = function () {
    var vm = this;
    var ref = vm.$options;
    var render = ref.render;
    var staticRenderFns = ref.staticRenderFns;
    var _parentVnode = ref._parentVnode;

    if (vm._isMounted) {
      // clone slot nodes on re-renders
      for (var key in vm.$slots) {
        vm.$slots[key] = cloneVNodes(vm.$slots[key]);
      }
    }

    vm.$scopedSlots = (_parentVnode && _parentVnode.data.scopedSlots) || emptyObject;

    if (staticRenderFns && !vm._staticTrees) {
      vm._staticTrees = [];
    }
    // set parent vnode. this allows render functions to have access
    // to the data on the placeholder node.
    vm.$vnode = _parentVnode;
    // render self
    var vnode;
    try {
      vnode = render.call(vm._renderProxy, vm.$createElement);
    } catch (e) {
      handleError(e, vm, "render function");
      // return error render result,
      // or previous vnode to prevent render error causing blank component
      /* istanbul ignore else */
      {
        vnode = vm.$options.renderError
          ? vm.$options.renderError.call(vm._renderProxy, vm.$createElement, e)
          : vm._vnode;
      }
    }
    // return empty vnode in case the render function errored out
    if (!(vnode instanceof VNode)) {
      if ("development" !== 'production' && Array.isArray(vnode)) {
        warn(
          'Multiple root nodes returned from render function. Render function ' +
          'should return a single root node.',
          vm
        );
      }
      vnode = createEmptyVNode();
    }
    // set parent
    vnode.parent = _parentVnode;
    return vnode
  };

  // internal render helpers.
  // these are exposed on the instance prototype to reduce generated render
  // code size.
  Vue.prototype._o = markOnce;
  Vue.prototype._n = toNumber;
  Vue.prototype._s = toString;
  Vue.prototype._l = renderList;
  Vue.prototype._t = renderSlot;
  Vue.prototype._q = looseEqual;
  Vue.prototype._i = looseIndexOf;
  Vue.prototype._m = renderStatic;
  Vue.prototype._f = resolveFilter;
  Vue.prototype._k = checkKeyCodes;
  Vue.prototype._b = bindObjectProps;
  Vue.prototype._v = createTextVNode;
  Vue.prototype._e = createEmptyVNode;
  Vue.prototype._u = resolveScopedSlots;
}

/*  */

var uid$1 = 0;

function initMixin (Vue) {
  Vue.prototype._init = function (options) {
    var vm = this;
    // a uid
    vm._uid = uid$1++;

    var startTag, endTag;
    /* istanbul ignore if */
    if ("development" !== 'production' && config.performance && mark) {
      startTag = "vue-perf-init:" + (vm._uid);
      endTag = "vue-perf-end:" + (vm._uid);
      mark(startTag);
    }

    // a flag to avoid this being observed
    vm._isVue = true;
    // merge options
    if (options && options._isComponent) {
      // optimize internal component instantiation
      // since dynamic options merging is pretty slow, and none of the
      // internal component options needs special treatment.
      initInternalComponent(vm, options);
    } else {
      vm.$options = mergeOptions(
        resolveConstructorOptions(vm.constructor),
        options || {},
        vm
      );
    }
    /* istanbul ignore else */
    {
      initProxy(vm);
    }
    // expose real self
    vm._self = vm;
    initLifecycle(vm);
    initEvents(vm);
    initRender(vm);
    callHook(vm, 'beforeCreate');
    initInjections(vm); // resolve injections before data/props
    initState(vm);
    initProvide(vm); // resolve provide after data/props
    callHook(vm, 'created');

    /* istanbul ignore if */
    if ("development" !== 'production' && config.performance && mark) {
      vm._name = formatComponentName(vm, false);
      mark(endTag);
      measure(((vm._name) + " init"), startTag, endTag);
    }

    if (vm.$options.el) {
      vm.$mount(vm.$options.el);
    }
  };
}

function initInternalComponent (vm, options) {
  var opts = vm.$options = Object.create(vm.constructor.options);
  // doing this because it's faster than dynamic enumeration.
  opts.parent = options.parent;
  opts.propsData = options.propsData;
  opts._parentVnode = options._parentVnode;
  opts._parentListeners = options._parentListeners;
  opts._renderChildren = options._renderChildren;
  opts._componentTag = options._componentTag;
  opts._parentElm = options._parentElm;
  opts._refElm = options._refElm;
  if (options.render) {
    opts.render = options.render;
    opts.staticRenderFns = options.staticRenderFns;
  }
}

function resolveConstructorOptions (Ctor) {
  var options = Ctor.options;
  if (Ctor.super) {
    var superOptions = resolveConstructorOptions(Ctor.super);
    var cachedSuperOptions = Ctor.superOptions;
    if (superOptions !== cachedSuperOptions) {
      // super option changed,
      // need to resolve new options.
      Ctor.superOptions = superOptions;
      // check if there are any late-modified/attached options (#4976)
      var modifiedOptions = resolveModifiedOptions(Ctor);
      // update base extend options
      if (modifiedOptions) {
        extend(Ctor.extendOptions, modifiedOptions);
      }
      options = Ctor.options = mergeOptions(superOptions, Ctor.extendOptions);
      if (options.name) {
        options.components[options.name] = Ctor;
      }
    }
  }
  return options
}

function resolveModifiedOptions (Ctor) {
  var modified;
  var latest = Ctor.options;
  var extended = Ctor.extendOptions;
  var sealed = Ctor.sealedOptions;
  for (var key in latest) {
    if (latest[key] !== sealed[key]) {
      if (!modified) { modified = {}; }
      modified[key] = dedupe(latest[key], extended[key], sealed[key]);
    }
  }
  return modified
}

function dedupe (latest, extended, sealed) {
  // compare latest and sealed to ensure lifecycle hooks won't be duplicated
  // between merges
  if (Array.isArray(latest)) {
    var res = [];
    sealed = Array.isArray(sealed) ? sealed : [sealed];
    extended = Array.isArray(extended) ? extended : [extended];
    for (var i = 0; i < latest.length; i++) {
      // push original options and not sealed options to exclude duplicated options
      if (extended.indexOf(latest[i]) >= 0 || sealed.indexOf(latest[i]) < 0) {
        res.push(latest[i]);
      }
    }
    return res
  } else {
    return latest
  }
}

function Vue$3 (options) {
  if ("development" !== 'production' &&
    !(this instanceof Vue$3)
  ) {
    warn('Vue is a constructor and should be called with the `new` keyword');
  }
  this._init(options);
}

initMixin(Vue$3);
stateMixin(Vue$3);
eventsMixin(Vue$3);
lifecycleMixin(Vue$3);
renderMixin(Vue$3);

/*  */

function initUse (Vue) {
  Vue.use = function (plugin) {
    /* istanbul ignore if */
    if (plugin.installed) {
      return this
    }
    // additional parameters
    var args = toArray(arguments, 1);
    args.unshift(this);
    if (typeof plugin.install === 'function') {
      plugin.install.apply(plugin, args);
    } else if (typeof plugin === 'function') {
      plugin.apply(null, args);
    }
    plugin.installed = true;
    return this
  };
}

/*  */

function initMixin$1 (Vue) {
  Vue.mixin = function (mixin) {
    this.options = mergeOptions(this.options, mixin);
    return this
  };
}

/*  */

function initExtend (Vue) {
  /**
   * Each instance constructor, including Vue, has a unique
   * cid. This enables us to create wrapped "child
   * constructors" for prototypal inheritance and cache them.
   */
  Vue.cid = 0;
  var cid = 1;

  /**
   * Class inheritance
   */
  Vue.extend = function (extendOptions) {
    extendOptions = extendOptions || {};
    var Super = this;
    var SuperId = Super.cid;
    var cachedCtors = extendOptions._Ctor || (extendOptions._Ctor = {});
    if (cachedCtors[SuperId]) {
      return cachedCtors[SuperId]
    }

    var name = extendOptions.name || Super.options.name;
    {
      if (!/^[a-zA-Z][\w-]*$/.test(name)) {
        warn(
          'Invalid component name: "' + name + '". Component names ' +
          'can only contain alphanumeric characters and the hyphen, ' +
          'and must start with a letter.'
        );
      }
    }

    var Sub = function VueComponent (options) {
      this._init(options);
    };
    Sub.prototype = Object.create(Super.prototype);
    Sub.prototype.constructor = Sub;
    Sub.cid = cid++;
    Sub.options = mergeOptions(
      Super.options,
      extendOptions
    );
    Sub['super'] = Super;

    // For props and computed properties, we define the proxy getters on
    // the Vue instances at extension time, on the extended prototype. This
    // avoids Object.defineProperty calls for each instance created.
    if (Sub.options.props) {
      initProps$1(Sub);
    }
    if (Sub.options.computed) {
      initComputed$1(Sub);
    }

    // allow further extension/mixin/plugin usage
    Sub.extend = Super.extend;
    Sub.mixin = Super.mixin;
    Sub.use = Super.use;

    // create asset registers, so extended classes
    // can have their private assets too.
    ASSET_TYPES.forEach(function (type) {
      Sub[type] = Super[type];
    });
    // enable recursive self-lookup
    if (name) {
      Sub.options.components[name] = Sub;
    }

    // keep a reference to the super options at extension time.
    // later at instantiation we can check if Super's options have
    // been updated.
    Sub.superOptions = Super.options;
    Sub.extendOptions = extendOptions;
    Sub.sealedOptions = extend({}, Sub.options);

    // cache constructor
    cachedCtors[SuperId] = Sub;
    return Sub
  };
}

function initProps$1 (Comp) {
  var props = Comp.options.props;
  for (var key in props) {
    proxy(Comp.prototype, "_props", key);
  }
}

function initComputed$1 (Comp) {
  var computed = Comp.options.computed;
  for (var key in computed) {
    defineComputed(Comp.prototype, key, computed[key]);
  }
}

/*  */

function initAssetRegisters (Vue) {
  /**
   * Create asset registration methods.
   */
  ASSET_TYPES.forEach(function (type) {
    Vue[type] = function (
      id,
      definition
    ) {
      if (!definition) {
        return this.options[type + 's'][id]
      } else {
        /* istanbul ignore if */
        {
          if (type === 'component' && config.isReservedTag(id)) {
            warn(
              'Do not use built-in or reserved HTML elements as component ' +
              'id: ' + id
            );
          }
        }
        if (type === 'component' && isPlainObject(definition)) {
          definition.name = definition.name || id;
          definition = this.options._base.extend(definition);
        }
        if (type === 'directive' && typeof definition === 'function') {
          definition = { bind: definition, update: definition };
        }
        this.options[type + 's'][id] = definition;
        return definition
      }
    };
  });
}

/*  */

var patternTypes = [String, RegExp];

function getComponentName (opts) {
  return opts && (opts.Ctor.options.name || opts.tag)
}

function matches (pattern, name) {
  if (typeof pattern === 'string') {
    return pattern.split(',').indexOf(name) > -1
  } else if (isRegExp(pattern)) {
    return pattern.test(name)
  }
  /* istanbul ignore next */
  return false
}

function pruneCache (cache, current, filter) {
  for (var key in cache) {
    var cachedNode = cache[key];
    if (cachedNode) {
      var name = getComponentName(cachedNode.componentOptions);
      if (name && !filter(name)) {
        if (cachedNode !== current) {
          pruneCacheEntry(cachedNode);
        }
        cache[key] = null;
      }
    }
  }
}

function pruneCacheEntry (vnode) {
  if (vnode) {
    vnode.componentInstance.$destroy();
  }
}

var KeepAlive = {
  name: 'keep-alive',
  abstract: true,

  props: {
    include: patternTypes,
    exclude: patternTypes
  },

  created: function created () {
    this.cache = Object.create(null);
  },

  destroyed: function destroyed () {
    var this$1 = this;

    for (var key in this$1.cache) {
      pruneCacheEntry(this$1.cache[key]);
    }
  },

  watch: {
    include: function include (val) {
      pruneCache(this.cache, this._vnode, function (name) { return matches(val, name); });
    },
    exclude: function exclude (val) {
      pruneCache(this.cache, this._vnode, function (name) { return !matches(val, name); });
    }
  },

  render: function render () {
    var vnode = getFirstComponentChild(this.$slots.default);
    var componentOptions = vnode && vnode.componentOptions;
    if (componentOptions) {
      // check pattern
      var name = getComponentName(componentOptions);
      if (name && (
        (this.include && !matches(this.include, name)) ||
        (this.exclude && matches(this.exclude, name))
      )) {
        return vnode
      }
      var key = vnode.key == null
        // same constructor may get registered as different local components
        // so cid alone is not enough (#3269)
        ? componentOptions.Ctor.cid + (componentOptions.tag ? ("::" + (componentOptions.tag)) : '')
        : vnode.key;
      if (this.cache[key]) {
        vnode.componentInstance = this.cache[key].componentInstance;
      } else {
        this.cache[key] = vnode;
      }
      vnode.data.keepAlive = true;
    }
    return vnode
  }
};

var builtInComponents = {
  KeepAlive: KeepAlive
};

/*  */

function initGlobalAPI (Vue) {
  // config
  var configDef = {};
  configDef.get = function () { return config; };
  {
    configDef.set = function () {
      warn(
        'Do not replace the Vue.config object, set individual fields instead.'
      );
    };
  }
  Object.defineProperty(Vue, 'config', configDef);

  // exposed util methods.
  // NOTE: these are not considered part of the public API - avoid relying on
  // them unless you are aware of the risk.
  Vue.util = {
    warn: warn,
    extend: extend,
    mergeOptions: mergeOptions,
    defineReactive: defineReactive$$1
  };

  Vue.set = set;
  Vue.delete = del;
  Vue.nextTick = nextTick;

  Vue.options = Object.create(null);
  ASSET_TYPES.forEach(function (type) {
    Vue.options[type + 's'] = Object.create(null);
  });

  // this is used to identify the "base" constructor to extend all plain-object
  // components with in Weex's multi-instance scenarios.
  Vue.options._base = Vue;

  extend(Vue.options.components, builtInComponents);

  initUse(Vue);
  initMixin$1(Vue);
  initExtend(Vue);
  initAssetRegisters(Vue);
}

initGlobalAPI(Vue$3);

Object.defineProperty(Vue$3.prototype, '$isServer', {
  get: isServerRendering
});

Object.defineProperty(Vue$3.prototype, '$ssrContext', {
  get: function get () {
    /* istanbul ignore next */
    return this.$vnode.ssrContext
  }
});

Vue$3.version = '2.3.4';

/*  */

// these are reserved for web because they are directly compiled away
// during template compilation
var isReservedAttr = makeMap('style,class');

// attributes that should be using props for binding
var acceptValue = makeMap('input,textarea,option,select');
var mustUseProp = function (tag, type, attr) {
  return (
    (attr === 'value' && acceptValue(tag)) && type !== 'button' ||
    (attr === 'selected' && tag === 'option') ||
    (attr === 'checked' && tag === 'input') ||
    (attr === 'muted' && tag === 'video')
  )
};

var isEnumeratedAttr = makeMap('contenteditable,draggable,spellcheck');

var isBooleanAttr = makeMap(
  'allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,' +
  'default,defaultchecked,defaultmuted,defaultselected,defer,disabled,' +
  'enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,' +
  'muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,' +
  'required,reversed,scoped,seamless,selected,sortable,translate,' +
  'truespeed,typemustmatch,visible'
);

var xlinkNS = 'http://www.w3.org/1999/xlink';

var isXlink = function (name) {
  return name.charAt(5) === ':' && name.slice(0, 5) === 'xlink'
};

var getXlinkProp = function (name) {
  return isXlink(name) ? name.slice(6, name.length) : ''
};

var isFalsyAttrValue = function (val) {
  return val == null || val === false
};

/*  */

function genClassForVnode (vnode) {
  var data = vnode.data;
  var parentNode = vnode;
  var childNode = vnode;
  while (isDef(childNode.componentInstance)) {
    childNode = childNode.componentInstance._vnode;
    if (childNode.data) {
      data = mergeClassData(childNode.data, data);
    }
  }
  while (isDef(parentNode = parentNode.parent)) {
    if (parentNode.data) {
      data = mergeClassData(data, parentNode.data);
    }
  }
  return genClassFromData(data)
}

function mergeClassData (child, parent) {
  return {
    staticClass: concat(child.staticClass, parent.staticClass),
    class: isDef(child.class)
      ? [child.class, parent.class]
      : parent.class
  }
}

function genClassFromData (data) {
  var dynamicClass = data.class;
  var staticClass = data.staticClass;
  if (isDef(staticClass) || isDef(dynamicClass)) {
    return concat(staticClass, stringifyClass(dynamicClass))
  }
  /* istanbul ignore next */
  return ''
}

function concat (a, b) {
  return a ? b ? (a + ' ' + b) : a : (b || '')
}

function stringifyClass (value) {
  if (isUndef(value)) {
    return ''
  }
  if (typeof value === 'string') {
    return value
  }
  var res = '';
  if (Array.isArray(value)) {
    var stringified;
    for (var i = 0, l = value.length; i < l; i++) {
      if (isDef(value[i])) {
        if (isDef(stringified = stringifyClass(value[i])) && stringified !== '') {
          res += stringified + ' ';
        }
      }
    }
    return res.slice(0, -1)
  }
  if (isObject(value)) {
    for (var key in value) {
      if (value[key]) { res += key + ' '; }
    }
    return res.slice(0, -1)
  }
  /* istanbul ignore next */
  return res
}

/*  */

var namespaceMap = {
  svg: 'http://www.w3.org/2000/svg',
  math: 'http://www.w3.org/1998/Math/MathML'
};

var isHTMLTag = makeMap(
  'html,body,base,head,link,meta,style,title,' +
  'address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,' +
  'div,dd,dl,dt,figcaption,figure,hr,img,li,main,ol,p,pre,ul,' +
  'a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,' +
  's,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,' +
  'embed,object,param,source,canvas,script,noscript,del,ins,' +
  'caption,col,colgroup,table,thead,tbody,td,th,tr,' +
  'button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,' +
  'output,progress,select,textarea,' +
  'details,dialog,menu,menuitem,summary,' +
  'content,element,shadow,template'
);

// this map is intentionally selective, only covering SVG elements that may
// contain child elements.
var isSVG = makeMap(
  'svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font-face,' +
  'foreignObject,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,' +
  'polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view',
  true
);

var isPreTag = function (tag) { return tag === 'pre'; };

var isReservedTag = function (tag) {
  return isHTMLTag(tag) || isSVG(tag)
};

function getTagNamespace (tag) {
  if (isSVG(tag)) {
    return 'svg'
  }
  // basic support for MathML
  // note it doesn't support other MathML elements being component roots
  if (tag === 'math') {
    return 'math'
  }
}

var unknownElementCache = Object.create(null);
function isUnknownElement (tag) {
  /* istanbul ignore if */
  if (!inBrowser) {
    return true
  }
  if (isReservedTag(tag)) {
    return false
  }
  tag = tag.toLowerCase();
  /* istanbul ignore if */
  if (unknownElementCache[tag] != null) {
    return unknownElementCache[tag]
  }
  var el = document.createElement(tag);
  if (tag.indexOf('-') > -1) {
    // http://stackoverflow.com/a/28210364/1070244
    return (unknownElementCache[tag] = (
      el.constructor === window.HTMLUnknownElement ||
      el.constructor === window.HTMLElement
    ))
  } else {
    return (unknownElementCache[tag] = /HTMLUnknownElement/.test(el.toString()))
  }
}

/*  */

/**
 * Query an element selector if it's not an element already.
 */
function query (el) {
  if (typeof el === 'string') {
    var selected = document.querySelector(el);
    if (!selected) {
      "development" !== 'production' && warn(
        'Cannot find element: ' + el
      );
      return document.createElement('div')
    }
    return selected
  } else {
    return el
  }
}

/*  */

function createElement$1 (tagName, vnode) {
  var elm = document.createElement(tagName);
  if (tagName !== 'select') {
    return elm
  }
  // false or null will remove the attribute but undefined will not
  if (vnode.data && vnode.data.attrs && vnode.data.attrs.multiple !== undefined) {
    elm.setAttribute('multiple', 'multiple');
  }
  return elm
}

function createElementNS (namespace, tagName) {
  return document.createElementNS(namespaceMap[namespace], tagName)
}

function createTextNode (text) {
  return document.createTextNode(text)
}

function createComment (text) {
  return document.createComment(text)
}

function insertBefore (parentNode, newNode, referenceNode) {
  parentNode.insertBefore(newNode, referenceNode);
}

function removeChild (node, child) {
  node.removeChild(child);
}

function appendChild (node, child) {
  node.appendChild(child);
}

function parentNode (node) {
  return node.parentNode
}

function nextSibling (node) {
  return node.nextSibling
}

function tagName (node) {
  return node.tagName
}

function setTextContent (node, text) {
  node.textContent = text;
}

function setAttribute (node, key, val) {
  node.setAttribute(key, val);
}


var nodeOps = Object.freeze({
	createElement: createElement$1,
	createElementNS: createElementNS,
	createTextNode: createTextNode,
	createComment: createComment,
	insertBefore: insertBefore,
	removeChild: removeChild,
	appendChild: appendChild,
	parentNode: parentNode,
	nextSibling: nextSibling,
	tagName: tagName,
	setTextContent: setTextContent,
	setAttribute: setAttribute
});

/*  */

var ref = {
  create: function create (_, vnode) {
    registerRef(vnode);
  },
  update: function update (oldVnode, vnode) {
    if (oldVnode.data.ref !== vnode.data.ref) {
      registerRef(oldVnode, true);
      registerRef(vnode);
    }
  },
  destroy: function destroy (vnode) {
    registerRef(vnode, true);
  }
};

function registerRef (vnode, isRemoval) {
  var key = vnode.data.ref;
  if (!key) { return }

  var vm = vnode.context;
  var ref = vnode.componentInstance || vnode.elm;
  var refs = vm.$refs;
  if (isRemoval) {
    if (Array.isArray(refs[key])) {
      remove(refs[key], ref);
    } else if (refs[key] === ref) {
      refs[key] = undefined;
    }
  } else {
    if (vnode.data.refInFor) {
      if (Array.isArray(refs[key]) && refs[key].indexOf(ref) < 0) {
        refs[key].push(ref);
      } else {
        refs[key] = [ref];
      }
    } else {
      refs[key] = ref;
    }
  }
}

/**
 * Virtual DOM patching algorithm based on Snabbdom by
 * Simon Friis Vindum (@paldepind)
 * Licensed under the MIT License
 * https://github.com/paldepind/snabbdom/blob/master/LICENSE
 *
 * modified by Evan You (@yyx990803)
 *

/*
 * Not type-checking this because this file is perf-critical and the cost
 * of making flow understand it is not worth it.
 */

var emptyNode = new VNode('', {}, []);

var hooks = ['create', 'activate', 'update', 'remove', 'destroy'];

function sameVnode (a, b) {
  return (
    a.key === b.key &&
    a.tag === b.tag &&
    a.isComment === b.isComment &&
    isDef(a.data) === isDef(b.data) &&
    sameInputType(a, b)
  )
}

// Some browsers do not support dynamically changing type for <input>
// so they need to be treated as different nodes
function sameInputType (a, b) {
  if (a.tag !== 'input') { return true }
  var i;
  var typeA = isDef(i = a.data) && isDef(i = i.attrs) && i.type;
  var typeB = isDef(i = b.data) && isDef(i = i.attrs) && i.type;
  return typeA === typeB
}

function createKeyToOldIdx (children, beginIdx, endIdx) {
  var i, key;
  var map = {};
  for (i = beginIdx; i <= endIdx; ++i) {
    key = children[i].key;
    if (isDef(key)) { map[key] = i; }
  }
  return map
}

function createPatchFunction (backend) {
  var i, j;
  var cbs = {};

  var modules = backend.modules;
  var nodeOps = backend.nodeOps;

  for (i = 0; i < hooks.length; ++i) {
    cbs[hooks[i]] = [];
    for (j = 0; j < modules.length; ++j) {
      if (isDef(modules[j][hooks[i]])) {
        cbs[hooks[i]].push(modules[j][hooks[i]]);
      }
    }
  }

  function emptyNodeAt (elm) {
    return new VNode(nodeOps.tagName(elm).toLowerCase(), {}, [], undefined, elm)
  }

  function createRmCb (childElm, listeners) {
    function remove$$1 () {
      if (--remove$$1.listeners === 0) {
        removeNode(childElm);
      }
    }
    remove$$1.listeners = listeners;
    return remove$$1
  }

  function removeNode (el) {
    var parent = nodeOps.parentNode(el);
    // element may have already been removed due to v-html / v-text
    if (isDef(parent)) {
      nodeOps.removeChild(parent, el);
    }
  }

  var inPre = 0;
  function createElm (vnode, insertedVnodeQueue, parentElm, refElm, nested) {
    vnode.isRootInsert = !nested; // for transition enter check
    if (createComponent(vnode, insertedVnodeQueue, parentElm, refElm)) {
      return
    }

    var data = vnode.data;
    var children = vnode.children;
    var tag = vnode.tag;
    if (isDef(tag)) {
      {
        if (data && data.pre) {
          inPre++;
        }
        if (
          !inPre &&
          !vnode.ns &&
          !(config.ignoredElements.length && config.ignoredElements.indexOf(tag) > -1) &&
          config.isUnknownElement(tag)
        ) {
          warn(
            'Unknown custom element: <' + tag + '> - did you ' +
            'register the component correctly? For recursive components, ' +
            'make sure to provide the "name" option.',
            vnode.context
          );
        }
      }
      vnode.elm = vnode.ns
        ? nodeOps.createElementNS(vnode.ns, tag)
        : nodeOps.createElement(tag, vnode);
      setScope(vnode);

      /* istanbul ignore if */
      {
        createChildren(vnode, children, insertedVnodeQueue);
        if (isDef(data)) {
          invokeCreateHooks(vnode, insertedVnodeQueue);
        }
        insert(parentElm, vnode.elm, refElm);
      }

      if ("development" !== 'production' && data && data.pre) {
        inPre--;
      }
    } else if (isTrue(vnode.isComment)) {
      vnode.elm = nodeOps.createComment(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    } else {
      vnode.elm = nodeOps.createTextNode(vnode.text);
      insert(parentElm, vnode.elm, refElm);
    }
  }

  function createComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i = vnode.data;
    if (isDef(i)) {
      var isReactivated = isDef(vnode.componentInstance) && i.keepAlive;
      if (isDef(i = i.hook) && isDef(i = i.init)) {
        i(vnode, false /* hydrating */, parentElm, refElm);
      }
      // after calling the init hook, if the vnode is a child component
      // it should've created a child instance and mounted it. the child
      // component also has set the placeholder vnode's elm.
      // in that case we can just return the element and be done.
      if (isDef(vnode.componentInstance)) {
        initComponent(vnode, insertedVnodeQueue);
        if (isTrue(isReactivated)) {
          reactivateComponent(vnode, insertedVnodeQueue, parentElm, refElm);
        }
        return true
      }
    }
  }

  function initComponent (vnode, insertedVnodeQueue) {
    if (isDef(vnode.data.pendingInsert)) {
      insertedVnodeQueue.push.apply(insertedVnodeQueue, vnode.data.pendingInsert);
      vnode.data.pendingInsert = null;
    }
    vnode.elm = vnode.componentInstance.$el;
    if (isPatchable(vnode)) {
      invokeCreateHooks(vnode, insertedVnodeQueue);
      setScope(vnode);
    } else {
      // empty component root.
      // skip all element-related modules except for ref (#3455)
      registerRef(vnode);
      // make sure to invoke the insert hook
      insertedVnodeQueue.push(vnode);
    }
  }

  function reactivateComponent (vnode, insertedVnodeQueue, parentElm, refElm) {
    var i;
    // hack for #4339: a reactivated component with inner transition
    // does not trigger because the inner node's created hooks are not called
    // again. It's not ideal to involve module-specific logic in here but
    // there doesn't seem to be a better way to do it.
    var innerNode = vnode;
    while (innerNode.componentInstance) {
      innerNode = innerNode.componentInstance._vnode;
      if (isDef(i = innerNode.data) && isDef(i = i.transition)) {
        for (i = 0; i < cbs.activate.length; ++i) {
          cbs.activate[i](emptyNode, innerNode);
        }
        insertedVnodeQueue.push(innerNode);
        break
      }
    }
    // unlike a newly created component,
    // a reactivated keep-alive component doesn't insert itself
    insert(parentElm, vnode.elm, refElm);
  }

  function insert (parent, elm, ref) {
    if (isDef(parent)) {
      if (isDef(ref)) {
        if (ref.parentNode === parent) {
          nodeOps.insertBefore(parent, elm, ref);
        }
      } else {
        nodeOps.appendChild(parent, elm);
      }
    }
  }

  function createChildren (vnode, children, insertedVnodeQueue) {
    if (Array.isArray(children)) {
      for (var i = 0; i < children.length; ++i) {
        createElm(children[i], insertedVnodeQueue, vnode.elm, null, true);
      }
    } else if (isPrimitive(vnode.text)) {
      nodeOps.appendChild(vnode.elm, nodeOps.createTextNode(vnode.text));
    }
  }

  function isPatchable (vnode) {
    while (vnode.componentInstance) {
      vnode = vnode.componentInstance._vnode;
    }
    return isDef(vnode.tag)
  }

  function invokeCreateHooks (vnode, insertedVnodeQueue) {
    for (var i$1 = 0; i$1 < cbs.create.length; ++i$1) {
      cbs.create[i$1](emptyNode, vnode);
    }
    i = vnode.data.hook; // Reuse variable
    if (isDef(i)) {
      if (isDef(i.create)) { i.create(emptyNode, vnode); }
      if (isDef(i.insert)) { insertedVnodeQueue.push(vnode); }
    }
  }

  // set scope id attribute for scoped CSS.
  // this is implemented as a special case to avoid the overhead
  // of going through the normal attribute patching process.
  function setScope (vnode) {
    var i;
    var ancestor = vnode;
    while (ancestor) {
      if (isDef(i = ancestor.context) && isDef(i = i.$options._scopeId)) {
        nodeOps.setAttribute(vnode.elm, i, '');
      }
      ancestor = ancestor.parent;
    }
    // for slot content they should also get the scopeId from the host instance.
    if (isDef(i = activeInstance) &&
      i !== vnode.context &&
      isDef(i = i.$options._scopeId)
    ) {
      nodeOps.setAttribute(vnode.elm, i, '');
    }
  }

  function addVnodes (parentElm, refElm, vnodes, startIdx, endIdx, insertedVnodeQueue) {
    for (; startIdx <= endIdx; ++startIdx) {
      createElm(vnodes[startIdx], insertedVnodeQueue, parentElm, refElm);
    }
  }

  function invokeDestroyHook (vnode) {
    var i, j;
    var data = vnode.data;
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.destroy)) { i(vnode); }
      for (i = 0; i < cbs.destroy.length; ++i) { cbs.destroy[i](vnode); }
    }
    if (isDef(i = vnode.children)) {
      for (j = 0; j < vnode.children.length; ++j) {
        invokeDestroyHook(vnode.children[j]);
      }
    }
  }

  function removeVnodes (parentElm, vnodes, startIdx, endIdx) {
    for (; startIdx <= endIdx; ++startIdx) {
      var ch = vnodes[startIdx];
      if (isDef(ch)) {
        if (isDef(ch.tag)) {
          removeAndInvokeRemoveHook(ch);
          invokeDestroyHook(ch);
        } else { // Text node
          removeNode(ch.elm);
        }
      }
    }
  }

  function removeAndInvokeRemoveHook (vnode, rm) {
    if (isDef(rm) || isDef(vnode.data)) {
      var i;
      var listeners = cbs.remove.length + 1;
      if (isDef(rm)) {
        // we have a recursively passed down rm callback
        // increase the listeners count
        rm.listeners += listeners;
      } else {
        // directly removing
        rm = createRmCb(vnode.elm, listeners);
      }
      // recursively invoke hooks on child component root node
      if (isDef(i = vnode.componentInstance) && isDef(i = i._vnode) && isDef(i.data)) {
        removeAndInvokeRemoveHook(i, rm);
      }
      for (i = 0; i < cbs.remove.length; ++i) {
        cbs.remove[i](vnode, rm);
      }
      if (isDef(i = vnode.data.hook) && isDef(i = i.remove)) {
        i(vnode, rm);
      } else {
        rm();
      }
    } else {
      removeNode(vnode.elm);
    }
  }

  function updateChildren (parentElm, oldCh, newCh, insertedVnodeQueue, removeOnly) {
    var oldStartIdx = 0;
    var newStartIdx = 0;
    var oldEndIdx = oldCh.length - 1;
    var oldStartVnode = oldCh[0];
    var oldEndVnode = oldCh[oldEndIdx];
    var newEndIdx = newCh.length - 1;
    var newStartVnode = newCh[0];
    var newEndVnode = newCh[newEndIdx];
    var oldKeyToIdx, idxInOld, elmToMove, refElm;

    // removeOnly is a special flag used only by <transition-group>
    // to ensure removed elements stay in correct relative positions
    // during leaving transitions
    var canMove = !removeOnly;

    while (oldStartIdx <= oldEndIdx && newStartIdx <= newEndIdx) {
      if (isUndef(oldStartVnode)) {
        oldStartVnode = oldCh[++oldStartIdx]; // Vnode has been moved left
      } else if (isUndef(oldEndVnode)) {
        oldEndVnode = oldCh[--oldEndIdx];
      } else if (sameVnode(oldStartVnode, newStartVnode)) {
        patchVnode(oldStartVnode, newStartVnode, insertedVnodeQueue);
        oldStartVnode = oldCh[++oldStartIdx];
        newStartVnode = newCh[++newStartIdx];
      } else if (sameVnode(oldEndVnode, newEndVnode)) {
        patchVnode(oldEndVnode, newEndVnode, insertedVnodeQueue);
        oldEndVnode = oldCh[--oldEndIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldStartVnode, newEndVnode)) { // Vnode moved right
        patchVnode(oldStartVnode, newEndVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldStartVnode.elm, nodeOps.nextSibling(oldEndVnode.elm));
        oldStartVnode = oldCh[++oldStartIdx];
        newEndVnode = newCh[--newEndIdx];
      } else if (sameVnode(oldEndVnode, newStartVnode)) { // Vnode moved left
        patchVnode(oldEndVnode, newStartVnode, insertedVnodeQueue);
        canMove && nodeOps.insertBefore(parentElm, oldEndVnode.elm, oldStartVnode.elm);
        oldEndVnode = oldCh[--oldEndIdx];
        newStartVnode = newCh[++newStartIdx];
      } else {
        if (isUndef(oldKeyToIdx)) { oldKeyToIdx = createKeyToOldIdx(oldCh, oldStartIdx, oldEndIdx); }
        idxInOld = isDef(newStartVnode.key) ? oldKeyToIdx[newStartVnode.key] : null;
        if (isUndef(idxInOld)) { // New element
          createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm);
          newStartVnode = newCh[++newStartIdx];
        } else {
          elmToMove = oldCh[idxInOld];
          /* istanbul ignore if */
          if ("development" !== 'production' && !elmToMove) {
            warn(
              'It seems there are duplicate keys that is causing an update error. ' +
              'Make sure each v-for item has a unique key.'
            );
          }
          if (sameVnode(elmToMove, newStartVnode)) {
            patchVnode(elmToMove, newStartVnode, insertedVnodeQueue);
            oldCh[idxInOld] = undefined;
            canMove && nodeOps.insertBefore(parentElm, newStartVnode.elm, oldStartVnode.elm);
            newStartVnode = newCh[++newStartIdx];
          } else {
            // same key but different element. treat as new element
            createElm(newStartVnode, insertedVnodeQueue, parentElm, oldStartVnode.elm);
            newStartVnode = newCh[++newStartIdx];
          }
        }
      }
    }
    if (oldStartIdx > oldEndIdx) {
      refElm = isUndef(newCh[newEndIdx + 1]) ? null : newCh[newEndIdx + 1].elm;
      addVnodes(parentElm, refElm, newCh, newStartIdx, newEndIdx, insertedVnodeQueue);
    } else if (newStartIdx > newEndIdx) {
      removeVnodes(parentElm, oldCh, oldStartIdx, oldEndIdx);
    }
  }

  function patchVnode (oldVnode, vnode, insertedVnodeQueue, removeOnly) {
    if (oldVnode === vnode) {
      return
    }
    // reuse element for static trees.
    // note we only do this if the vnode is cloned -
    // if the new node is not cloned it means the render functions have been
    // reset by the hot-reload-api and we need to do a proper re-render.
    if (isTrue(vnode.isStatic) &&
      isTrue(oldVnode.isStatic) &&
      vnode.key === oldVnode.key &&
      (isTrue(vnode.isCloned) || isTrue(vnode.isOnce))
    ) {
      vnode.elm = oldVnode.elm;
      vnode.componentInstance = oldVnode.componentInstance;
      return
    }
    var i;
    var data = vnode.data;
    if (isDef(data) && isDef(i = data.hook) && isDef(i = i.prepatch)) {
      i(oldVnode, vnode);
    }
    var elm = vnode.elm = oldVnode.elm;
    var oldCh = oldVnode.children;
    var ch = vnode.children;
    if (isDef(data) && isPatchable(vnode)) {
      for (i = 0; i < cbs.update.length; ++i) { cbs.update[i](oldVnode, vnode); }
      if (isDef(i = data.hook) && isDef(i = i.update)) { i(oldVnode, vnode); }
    }
    if (isUndef(vnode.text)) {
      if (isDef(oldCh) && isDef(ch)) {
        if (oldCh !== ch) { updateChildren(elm, oldCh, ch, insertedVnodeQueue, removeOnly); }
      } else if (isDef(ch)) {
        if (isDef(oldVnode.text)) { nodeOps.setTextContent(elm, ''); }
        addVnodes(elm, null, ch, 0, ch.length - 1, insertedVnodeQueue);
      } else if (isDef(oldCh)) {
        removeVnodes(elm, oldCh, 0, oldCh.length - 1);
      } else if (isDef(oldVnode.text)) {
        nodeOps.setTextContent(elm, '');
      }
    } else if (oldVnode.text !== vnode.text) {
      nodeOps.setTextContent(elm, vnode.text);
    }
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.postpatch)) { i(oldVnode, vnode); }
    }
  }

  function invokeInsertHook (vnode, queue, initial) {
    // delay insert hooks for component root nodes, invoke them after the
    // element is really inserted
    if (isTrue(initial) && isDef(vnode.parent)) {
      vnode.parent.data.pendingInsert = queue;
    } else {
      for (var i = 0; i < queue.length; ++i) {
        queue[i].data.hook.insert(queue[i]);
      }
    }
  }

  var bailed = false;
  // list of modules that can skip create hook during hydration because they
  // are already rendered on the client or has no need for initialization
  var isRenderedModule = makeMap('attrs,style,class,staticClass,staticStyle,key');

  // Note: this is a browser-only function so we can assume elms are DOM nodes.
  function hydrate (elm, vnode, insertedVnodeQueue) {
    {
      if (!assertNodeMatch(elm, vnode)) {
        return false
      }
    }
    vnode.elm = elm;
    var tag = vnode.tag;
    var data = vnode.data;
    var children = vnode.children;
    if (isDef(data)) {
      if (isDef(i = data.hook) && isDef(i = i.init)) { i(vnode, true /* hydrating */); }
      if (isDef(i = vnode.componentInstance)) {
        // child component. it should have hydrated its own tree.
        initComponent(vnode, insertedVnodeQueue);
        return true
      }
    }
    if (isDef(tag)) {
      if (isDef(children)) {
        // empty element, allow client to pick up and populate children
        if (!elm.hasChildNodes()) {
          createChildren(vnode, children, insertedVnodeQueue);
        } else {
          var childrenMatch = true;
          var childNode = elm.firstChild;
          for (var i$1 = 0; i$1 < children.length; i$1++) {
            if (!childNode || !hydrate(childNode, children[i$1], insertedVnodeQueue)) {
              childrenMatch = false;
              break
            }
            childNode = childNode.nextSibling;
          }
          // if childNode is not null, it means the actual childNodes list is
          // longer than the virtual children list.
          if (!childrenMatch || childNode) {
            if ("development" !== 'production' &&
              typeof console !== 'undefined' &&
              !bailed
            ) {
              bailed = true;
              console.warn('Parent: ', elm);
              console.warn('Mismatching childNodes vs. VNodes: ', elm.childNodes, children);
            }
            return false
          }
        }
      }
      if (isDef(data)) {
        for (var key in data) {
          if (!isRenderedModule(key)) {
            invokeCreateHooks(vnode, insertedVnodeQueue);
            break
          }
        }
      }
    } else if (elm.data !== vnode.text) {
      elm.data = vnode.text;
    }
    return true
  }

  function assertNodeMatch (node, vnode) {
    if (isDef(vnode.tag)) {
      return (
        vnode.tag.indexOf('vue-component') === 0 ||
        vnode.tag.toLowerCase() === (node.tagName && node.tagName.toLowerCase())
      )
    } else {
      return node.nodeType === (vnode.isComment ? 8 : 3)
    }
  }

  return function patch (oldVnode, vnode, hydrating, removeOnly, parentElm, refElm) {
    if (isUndef(vnode)) {
      if (isDef(oldVnode)) { invokeDestroyHook(oldVnode); }
      return
    }

    var isInitialPatch = false;
    var insertedVnodeQueue = [];

    if (isUndef(oldVnode)) {
      // empty mount (likely as component), create new root element
      isInitialPatch = true;
      createElm(vnode, insertedVnodeQueue, parentElm, refElm);
    } else {
      var isRealElement = isDef(oldVnode.nodeType);
      if (!isRealElement && sameVnode(oldVnode, vnode)) {
        // patch existing root node
        patchVnode(oldVnode, vnode, insertedVnodeQueue, removeOnly);
      } else {
        if (isRealElement) {
          // mounting to a real element
          // check if this is server-rendered content and if we can perform
          // a successful hydration.
          if (oldVnode.nodeType === 1 && oldVnode.hasAttribute(SSR_ATTR)) {
            oldVnode.removeAttribute(SSR_ATTR);
            hydrating = true;
          }
          if (isTrue(hydrating)) {
            if (hydrate(oldVnode, vnode, insertedVnodeQueue)) {
              invokeInsertHook(vnode, insertedVnodeQueue, true);
              return oldVnode
            } else {
              warn(
                'The client-side rendered virtual DOM tree is not matching ' +
                'server-rendered content. This is likely caused by incorrect ' +
                'HTML markup, for example nesting block-level elements inside ' +
                '<p>, or missing <tbody>. Bailing hydration and performing ' +
                'full client-side render.'
              );
            }
          }
          // either not server-rendered, or hydration failed.
          // create an empty node and replace it
          oldVnode = emptyNodeAt(oldVnode);
        }
        // replacing existing element
        var oldElm = oldVnode.elm;
        var parentElm$1 = nodeOps.parentNode(oldElm);
        createElm(
          vnode,
          insertedVnodeQueue,
          // extremely rare edge case: do not insert if old element is in a
          // leaving transition. Only happens when combining transition +
          // keep-alive + HOCs. (#4590)
          oldElm._leaveCb ? null : parentElm$1,
          nodeOps.nextSibling(oldElm)
        );

        if (isDef(vnode.parent)) {
          // component root element replaced.
          // update parent placeholder node element, recursively
          var ancestor = vnode.parent;
          while (ancestor) {
            ancestor.elm = vnode.elm;
            ancestor = ancestor.parent;
          }
          if (isPatchable(vnode)) {
            for (var i = 0; i < cbs.create.length; ++i) {
              cbs.create[i](emptyNode, vnode.parent);
            }
          }
        }

        if (isDef(parentElm$1)) {
          removeVnodes(parentElm$1, [oldVnode], 0, 0);
        } else if (isDef(oldVnode.tag)) {
          invokeDestroyHook(oldVnode);
        }
      }
    }

    invokeInsertHook(vnode, insertedVnodeQueue, isInitialPatch);
    return vnode.elm
  }
}

/*  */

var directives = {
  create: updateDirectives,
  update: updateDirectives,
  destroy: function unbindDirectives (vnode) {
    updateDirectives(vnode, emptyNode);
  }
};

function updateDirectives (oldVnode, vnode) {
  if (oldVnode.data.directives || vnode.data.directives) {
    _update(oldVnode, vnode);
  }
}

function _update (oldVnode, vnode) {
  var isCreate = oldVnode === emptyNode;
  var isDestroy = vnode === emptyNode;
  var oldDirs = normalizeDirectives$1(oldVnode.data.directives, oldVnode.context);
  var newDirs = normalizeDirectives$1(vnode.data.directives, vnode.context);

  var dirsWithInsert = [];
  var dirsWithPostpatch = [];

  var key, oldDir, dir;
  for (key in newDirs) {
    oldDir = oldDirs[key];
    dir = newDirs[key];
    if (!oldDir) {
      // new directive, bind
      callHook$1(dir, 'bind', vnode, oldVnode);
      if (dir.def && dir.def.inserted) {
        dirsWithInsert.push(dir);
      }
    } else {
      // existing directive, update
      dir.oldValue = oldDir.value;
      callHook$1(dir, 'update', vnode, oldVnode);
      if (dir.def && dir.def.componentUpdated) {
        dirsWithPostpatch.push(dir);
      }
    }
  }

  if (dirsWithInsert.length) {
    var callInsert = function () {
      for (var i = 0; i < dirsWithInsert.length; i++) {
        callHook$1(dirsWithInsert[i], 'inserted', vnode, oldVnode);
      }
    };
    if (isCreate) {
      mergeVNodeHook(vnode.data.hook || (vnode.data.hook = {}), 'insert', callInsert);
    } else {
      callInsert();
    }
  }

  if (dirsWithPostpatch.length) {
    mergeVNodeHook(vnode.data.hook || (vnode.data.hook = {}), 'postpatch', function () {
      for (var i = 0; i < dirsWithPostpatch.length; i++) {
        callHook$1(dirsWithPostpatch[i], 'componentUpdated', vnode, oldVnode);
      }
    });
  }

  if (!isCreate) {
    for (key in oldDirs) {
      if (!newDirs[key]) {
        // no longer present, unbind
        callHook$1(oldDirs[key], 'unbind', oldVnode, oldVnode, isDestroy);
      }
    }
  }
}

var emptyModifiers = Object.create(null);

function normalizeDirectives$1 (
  dirs,
  vm
) {
  var res = Object.create(null);
  if (!dirs) {
    return res
  }
  var i, dir;
  for (i = 0; i < dirs.length; i++) {
    dir = dirs[i];
    if (!dir.modifiers) {
      dir.modifiers = emptyModifiers;
    }
    res[getRawDirName(dir)] = dir;
    dir.def = resolveAsset(vm.$options, 'directives', dir.name, true);
  }
  return res
}

function getRawDirName (dir) {
  return dir.rawName || ((dir.name) + "." + (Object.keys(dir.modifiers || {}).join('.')))
}

function callHook$1 (dir, hook, vnode, oldVnode, isDestroy) {
  var fn = dir.def && dir.def[hook];
  if (fn) {
    try {
      fn(vnode.elm, dir, vnode, oldVnode, isDestroy);
    } catch (e) {
      handleError(e, vnode.context, ("directive " + (dir.name) + " " + hook + " hook"));
    }
  }
}

var baseModules = [
  ref,
  directives
];

/*  */

function updateAttrs (oldVnode, vnode) {
  if (isUndef(oldVnode.data.attrs) && isUndef(vnode.data.attrs)) {
    return
  }
  var key, cur, old;
  var elm = vnode.elm;
  var oldAttrs = oldVnode.data.attrs || {};
  var attrs = vnode.data.attrs || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(attrs.__ob__)) {
    attrs = vnode.data.attrs = extend({}, attrs);
  }

  for (key in attrs) {
    cur = attrs[key];
    old = oldAttrs[key];
    if (old !== cur) {
      setAttr(elm, key, cur);
    }
  }
  // #4391: in IE9, setting type can reset value for input[type=radio]
  /* istanbul ignore if */
  if (isIE9 && attrs.value !== oldAttrs.value) {
    setAttr(elm, 'value', attrs.value);
  }
  for (key in oldAttrs) {
    if (isUndef(attrs[key])) {
      if (isXlink(key)) {
        elm.removeAttributeNS(xlinkNS, getXlinkProp(key));
      } else if (!isEnumeratedAttr(key)) {
        elm.removeAttribute(key);
      }
    }
  }
}

function setAttr (el, key, value) {
  if (isBooleanAttr(key)) {
    // set attribute for blank value
    // e.g. <option disabled>Select one</option>
    if (isFalsyAttrValue(value)) {
      el.removeAttribute(key);
    } else {
      el.setAttribute(key, key);
    }
  } else if (isEnumeratedAttr(key)) {
    el.setAttribute(key, isFalsyAttrValue(value) || value === 'false' ? 'false' : 'true');
  } else if (isXlink(key)) {
    if (isFalsyAttrValue(value)) {
      el.removeAttributeNS(xlinkNS, getXlinkProp(key));
    } else {
      el.setAttributeNS(xlinkNS, key, value);
    }
  } else {
    if (isFalsyAttrValue(value)) {
      el.removeAttribute(key);
    } else {
      el.setAttribute(key, value);
    }
  }
}

var attrs = {
  create: updateAttrs,
  update: updateAttrs
};

/*  */

function updateClass (oldVnode, vnode) {
  var el = vnode.elm;
  var data = vnode.data;
  var oldData = oldVnode.data;
  if (
    isUndef(data.staticClass) &&
    isUndef(data.class) && (
      isUndef(oldData) || (
        isUndef(oldData.staticClass) &&
        isUndef(oldData.class)
      )
    )
  ) {
    return
  }

  var cls = genClassForVnode(vnode);

  // handle transition classes
  var transitionClass = el._transitionClasses;
  if (isDef(transitionClass)) {
    cls = concat(cls, stringifyClass(transitionClass));
  }

  // set the class
  if (cls !== el._prevClass) {
    el.setAttribute('class', cls);
    el._prevClass = cls;
  }
}

var klass = {
  create: updateClass,
  update: updateClass
};

/*  */

var validDivisionCharRE = /[\w).+\-_$\]]/;

function parseFilters (exp) {
  var inSingle = false;
  var inDouble = false;
  var inTemplateString = false;
  var inRegex = false;
  var curly = 0;
  var square = 0;
  var paren = 0;
  var lastFilterIndex = 0;
  var c, prev, i, expression, filters;

  for (i = 0; i < exp.length; i++) {
    prev = c;
    c = exp.charCodeAt(i);
    if (inSingle) {
      if (c === 0x27 && prev !== 0x5C) { inSingle = false; }
    } else if (inDouble) {
      if (c === 0x22 && prev !== 0x5C) { inDouble = false; }
    } else if (inTemplateString) {
      if (c === 0x60 && prev !== 0x5C) { inTemplateString = false; }
    } else if (inRegex) {
      if (c === 0x2f && prev !== 0x5C) { inRegex = false; }
    } else if (
      c === 0x7C && // pipe
      exp.charCodeAt(i + 1) !== 0x7C &&
      exp.charCodeAt(i - 1) !== 0x7C &&
      !curly && !square && !paren
    ) {
      if (expression === undefined) {
        // first filter, end of expression
        lastFilterIndex = i + 1;
        expression = exp.slice(0, i).trim();
      } else {
        pushFilter();
      }
    } else {
      switch (c) {
        case 0x22: inDouble = true; break         // "
        case 0x27: inSingle = true; break         // '
        case 0x60: inTemplateString = true; break // `
        case 0x28: paren++; break                 // (
        case 0x29: paren--; break                 // )
        case 0x5B: square++; break                // [
        case 0x5D: square--; break                // ]
        case 0x7B: curly++; break                 // {
        case 0x7D: curly--; break                 // }
      }
      if (c === 0x2f) { // /
        var j = i - 1;
        var p = (void 0);
        // find first non-whitespace prev char
        for (; j >= 0; j--) {
          p = exp.charAt(j);
          if (p !== ' ') { break }
        }
        if (!p || !validDivisionCharRE.test(p)) {
          inRegex = true;
        }
      }
    }
  }

  if (expression === undefined) {
    expression = exp.slice(0, i).trim();
  } else if (lastFilterIndex !== 0) {
    pushFilter();
  }

  function pushFilter () {
    (filters || (filters = [])).push(exp.slice(lastFilterIndex, i).trim());
    lastFilterIndex = i + 1;
  }

  if (filters) {
    for (i = 0; i < filters.length; i++) {
      expression = wrapFilter(expression, filters[i]);
    }
  }

  return expression
}

function wrapFilter (exp, filter) {
  var i = filter.indexOf('(');
  if (i < 0) {
    // _f: resolveFilter
    return ("_f(\"" + filter + "\")(" + exp + ")")
  } else {
    var name = filter.slice(0, i);
    var args = filter.slice(i + 1);
    return ("_f(\"" + name + "\")(" + exp + "," + args)
  }
}

/*  */

function baseWarn (msg) {
  console.error(("[Vue compiler]: " + msg));
}

function pluckModuleFunction (
  modules,
  key
) {
  return modules
    ? modules.map(function (m) { return m[key]; }).filter(function (_) { return _; })
    : []
}

function addProp (el, name, value) {
  (el.props || (el.props = [])).push({ name: name, value: value });
}

function addAttr (el, name, value) {
  (el.attrs || (el.attrs = [])).push({ name: name, value: value });
}

function addDirective (
  el,
  name,
  rawName,
  value,
  arg,
  modifiers
) {
  (el.directives || (el.directives = [])).push({ name: name, rawName: rawName, value: value, arg: arg, modifiers: modifiers });
}

function addHandler (
  el,
  name,
  value,
  modifiers,
  important,
  warn
) {
  // warn prevent and passive modifier
  /* istanbul ignore if */
  if (
    "development" !== 'production' && warn &&
    modifiers && modifiers.prevent && modifiers.passive
  ) {
    warn(
      'passive and prevent can\'t be used together. ' +
      'Passive handler can\'t prevent default event.'
    );
  }
  // check capture modifier
  if (modifiers && modifiers.capture) {
    delete modifiers.capture;
    name = '!' + name; // mark the event as captured
  }
  if (modifiers && modifiers.once) {
    delete modifiers.once;
    name = '~' + name; // mark the event as once
  }
  /* istanbul ignore if */
  if (modifiers && modifiers.passive) {
    delete modifiers.passive;
    name = '&' + name; // mark the event as passive
  }
  var events;
  if (modifiers && modifiers.native) {
    delete modifiers.native;
    events = el.nativeEvents || (el.nativeEvents = {});
  } else {
    events = el.events || (el.events = {});
  }
  var newHandler = { value: value, modifiers: modifiers };
  var handlers = events[name];
  /* istanbul ignore if */
  if (Array.isArray(handlers)) {
    important ? handlers.unshift(newHandler) : handlers.push(newHandler);
  } else if (handlers) {
    events[name] = important ? [newHandler, handlers] : [handlers, newHandler];
  } else {
    events[name] = newHandler;
  }
}

function getBindingAttr (
  el,
  name,
  getStatic
) {
  var dynamicValue =
    getAndRemoveAttr(el, ':' + name) ||
    getAndRemoveAttr(el, 'v-bind:' + name);
  if (dynamicValue != null) {
    return parseFilters(dynamicValue)
  } else if (getStatic !== false) {
    var staticValue = getAndRemoveAttr(el, name);
    if (staticValue != null) {
      return JSON.stringify(staticValue)
    }
  }
}

function getAndRemoveAttr (el, name) {
  var val;
  if ((val = el.attrsMap[name]) != null) {
    var list = el.attrsList;
    for (var i = 0, l = list.length; i < l; i++) {
      if (list[i].name === name) {
        list.splice(i, 1);
        break
      }
    }
  }
  return val
}

/*  */

/**
 * Cross-platform code generation for component v-model
 */
function genComponentModel (
  el,
  value,
  modifiers
) {
  var ref = modifiers || {};
  var number = ref.number;
  var trim = ref.trim;

  var baseValueExpression = '$$v';
  var valueExpression = baseValueExpression;
  if (trim) {
    valueExpression =
      "(typeof " + baseValueExpression + " === 'string'" +
        "? " + baseValueExpression + ".trim()" +
        ": " + baseValueExpression + ")";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }
  var assignment = genAssignmentCode(value, valueExpression);

  el.model = {
    value: ("(" + value + ")"),
    expression: ("\"" + value + "\""),
    callback: ("function (" + baseValueExpression + ") {" + assignment + "}")
  };
}

/**
 * Cross-platform codegen helper for generating v-model value assignment code.
 */
function genAssignmentCode (
  value,
  assignment
) {
  var modelRs = parseModel(value);
  if (modelRs.idx === null) {
    return (value + "=" + assignment)
  } else {
    return "var $$exp = " + (modelRs.exp) + ", $$idx = " + (modelRs.idx) + ";" +
      "if (!Array.isArray($$exp)){" +
        value + "=" + assignment + "}" +
      "else{$$exp.splice($$idx, 1, " + assignment + ")}"
  }
}

/**
 * parse directive model to do the array update transform. a[idx] = val => $$a.splice($$idx, 1, val)
 *
 * for loop possible cases:
 *
 * - test
 * - test[idx]
 * - test[test1[idx]]
 * - test["a"][idx]
 * - xxx.test[a[a].test1[idx]]
 * - test.xxx.a["asa"][test1[idx]]
 *
 */

var len;
var str;
var chr;
var index$1;
var expressionPos;
var expressionEndPos;

function parseModel (val) {
  str = val;
  len = str.length;
  index$1 = expressionPos = expressionEndPos = 0;

  if (val.indexOf('[') < 0 || val.lastIndexOf(']') < len - 1) {
    return {
      exp: val,
      idx: null
    }
  }

  while (!eof()) {
    chr = next();
    /* istanbul ignore if */
    if (isStringStart(chr)) {
      parseString(chr);
    } else if (chr === 0x5B) {
      parseBracket(chr);
    }
  }

  return {
    exp: val.substring(0, expressionPos),
    idx: val.substring(expressionPos + 1, expressionEndPos)
  }
}

function next () {
  return str.charCodeAt(++index$1)
}

function eof () {
  return index$1 >= len
}

function isStringStart (chr) {
  return chr === 0x22 || chr === 0x27
}

function parseBracket (chr) {
  var inBracket = 1;
  expressionPos = index$1;
  while (!eof()) {
    chr = next();
    if (isStringStart(chr)) {
      parseString(chr);
      continue
    }
    if (chr === 0x5B) { inBracket++; }
    if (chr === 0x5D) { inBracket--; }
    if (inBracket === 0) {
      expressionEndPos = index$1;
      break
    }
  }
}

function parseString (chr) {
  var stringQuote = chr;
  while (!eof()) {
    chr = next();
    if (chr === stringQuote) {
      break
    }
  }
}

/*  */

var warn$1;

// in some cases, the event used has to be determined at runtime
// so we used some reserved tokens during compile.
var RANGE_TOKEN = '__r';
var CHECKBOX_RADIO_TOKEN = '__c';

function model (
  el,
  dir,
  _warn
) {
  warn$1 = _warn;
  var value = dir.value;
  var modifiers = dir.modifiers;
  var tag = el.tag;
  var type = el.attrsMap.type;

  {
    var dynamicType = el.attrsMap['v-bind:type'] || el.attrsMap[':type'];
    if (tag === 'input' && dynamicType) {
      warn$1(
        "<input :type=\"" + dynamicType + "\" v-model=\"" + value + "\">:\n" +
        "v-model does not support dynamic input types. Use v-if branches instead."
      );
    }
    // inputs with type="file" are read only and setting the input's
    // value will throw an error.
    if (tag === 'input' && type === 'file') {
      warn$1(
        "<" + (el.tag) + " v-model=\"" + value + "\" type=\"file\">:\n" +
        "File inputs are read only. Use a v-on:change listener instead."
      );
    }
  }

  if (tag === 'select') {
    genSelect(el, value, modifiers);
  } else if (tag === 'input' && type === 'checkbox') {
    genCheckboxModel(el, value, modifiers);
  } else if (tag === 'input' && type === 'radio') {
    genRadioModel(el, value, modifiers);
  } else if (tag === 'input' || tag === 'textarea') {
    genDefaultModel(el, value, modifiers);
  } else if (!config.isReservedTag(tag)) {
    genComponentModel(el, value, modifiers);
    // component v-model doesn't need extra runtime
    return false
  } else {
    warn$1(
      "<" + (el.tag) + " v-model=\"" + value + "\">: " +
      "v-model is not supported on this element type. " +
      'If you are working with contenteditable, it\'s recommended to ' +
      'wrap a library dedicated for that purpose inside a custom component.'
    );
  }

  // ensure runtime directive metadata
  return true
}

function genCheckboxModel (
  el,
  value,
  modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  var trueValueBinding = getBindingAttr(el, 'true-value') || 'true';
  var falseValueBinding = getBindingAttr(el, 'false-value') || 'false';
  addProp(el, 'checked',
    "Array.isArray(" + value + ")" +
      "?_i(" + value + "," + valueBinding + ")>-1" + (
        trueValueBinding === 'true'
          ? (":(" + value + ")")
          : (":_q(" + value + "," + trueValueBinding + ")")
      )
  );
  addHandler(el, CHECKBOX_RADIO_TOKEN,
    "var $$a=" + value + "," +
        '$$el=$event.target,' +
        "$$c=$$el.checked?(" + trueValueBinding + "):(" + falseValueBinding + ");" +
    'if(Array.isArray($$a)){' +
      "var $$v=" + (number ? '_n(' + valueBinding + ')' : valueBinding) + "," +
          '$$i=_i($$a,$$v);' +
      "if($$c){$$i<0&&(" + value + "=$$a.concat($$v))}" +
      "else{$$i>-1&&(" + value + "=$$a.slice(0,$$i).concat($$a.slice($$i+1)))}" +
    "}else{" + (genAssignmentCode(value, '$$c')) + "}",
    null, true
  );
}

function genRadioModel (
    el,
    value,
    modifiers
) {
  var number = modifiers && modifiers.number;
  var valueBinding = getBindingAttr(el, 'value') || 'null';
  valueBinding = number ? ("_n(" + valueBinding + ")") : valueBinding;
  addProp(el, 'checked', ("_q(" + value + "," + valueBinding + ")"));
  addHandler(el, CHECKBOX_RADIO_TOKEN, genAssignmentCode(value, valueBinding), null, true);
}

function genSelect (
    el,
    value,
    modifiers
) {
  var number = modifiers && modifiers.number;
  var selectedVal = "Array.prototype.filter" +
    ".call($event.target.options,function(o){return o.selected})" +
    ".map(function(o){var val = \"_value\" in o ? o._value : o.value;" +
    "return " + (number ? '_n(val)' : 'val') + "})";

  var assignment = '$event.target.multiple ? $$selectedVal : $$selectedVal[0]';
  var code = "var $$selectedVal = " + selectedVal + ";";
  code = code + " " + (genAssignmentCode(value, assignment));
  addHandler(el, 'change', code, null, true);
}

function genDefaultModel (
  el,
  value,
  modifiers
) {
  var type = el.attrsMap.type;
  var ref = modifiers || {};
  var lazy = ref.lazy;
  var number = ref.number;
  var trim = ref.trim;
  var needCompositionGuard = !lazy && type !== 'range';
  var event = lazy
    ? 'change'
    : type === 'range'
      ? RANGE_TOKEN
      : 'input';

  var valueExpression = '$event.target.value';
  if (trim) {
    valueExpression = "$event.target.value.trim()";
  }
  if (number) {
    valueExpression = "_n(" + valueExpression + ")";
  }

  var code = genAssignmentCode(value, valueExpression);
  if (needCompositionGuard) {
    code = "if($event.target.composing)return;" + code;
  }

  addProp(el, 'value', ("(" + value + ")"));
  addHandler(el, event, code, null, true);
  if (trim || number || type === 'number') {
    addHandler(el, 'blur', '$forceUpdate()');
  }
}

/*  */

// normalize v-model event tokens that can only be determined at runtime.
// it's important to place the event as the first in the array because
// the whole point is ensuring the v-model callback gets called before
// user-attached handlers.
function normalizeEvents (on) {
  var event;
  /* istanbul ignore if */
  if (isDef(on[RANGE_TOKEN])) {
    // IE input[type=range] only supports `change` event
    event = isIE ? 'change' : 'input';
    on[event] = [].concat(on[RANGE_TOKEN], on[event] || []);
    delete on[RANGE_TOKEN];
  }
  if (isDef(on[CHECKBOX_RADIO_TOKEN])) {
    // Chrome fires microtasks in between click/change, leads to #4521
    event = isChrome ? 'click' : 'change';
    on[event] = [].concat(on[CHECKBOX_RADIO_TOKEN], on[event] || []);
    delete on[CHECKBOX_RADIO_TOKEN];
  }
}

var target$1;

function add$1 (
  event,
  handler,
  once$$1,
  capture,
  passive
) {
  if (once$$1) {
    var oldHandler = handler;
    var _target = target$1; // save current target element in closure
    handler = function (ev) {
      var res = arguments.length === 1
        ? oldHandler(ev)
        : oldHandler.apply(null, arguments);
      if (res !== null) {
        remove$2(event, handler, capture, _target);
      }
    };
  }
  target$1.addEventListener(
    event,
    handler,
    supportsPassive
      ? { capture: capture, passive: passive }
      : capture
  );
}

function remove$2 (
  event,
  handler,
  capture,
  _target
) {
  (_target || target$1).removeEventListener(event, handler, capture);
}

function updateDOMListeners (oldVnode, vnode) {
  if (isUndef(oldVnode.data.on) && isUndef(vnode.data.on)) {
    return
  }
  var on = vnode.data.on || {};
  var oldOn = oldVnode.data.on || {};
  target$1 = vnode.elm;
  normalizeEvents(on);
  updateListeners(on, oldOn, add$1, remove$2, vnode.context);
}

var events = {
  create: updateDOMListeners,
  update: updateDOMListeners
};

/*  */

function updateDOMProps (oldVnode, vnode) {
  if (isUndef(oldVnode.data.domProps) && isUndef(vnode.data.domProps)) {
    return
  }
  var key, cur;
  var elm = vnode.elm;
  var oldProps = oldVnode.data.domProps || {};
  var props = vnode.data.domProps || {};
  // clone observed objects, as the user probably wants to mutate it
  if (isDef(props.__ob__)) {
    props = vnode.data.domProps = extend({}, props);
  }

  for (key in oldProps) {
    if (isUndef(props[key])) {
      elm[key] = '';
    }
  }
  for (key in props) {
    cur = props[key];
    // ignore children if the node has textContent or innerHTML,
    // as these will throw away existing DOM nodes and cause removal errors
    // on subsequent patches (#3360)
    if (key === 'textContent' || key === 'innerHTML') {
      if (vnode.children) { vnode.children.length = 0; }
      if (cur === oldProps[key]) { continue }
    }

    if (key === 'value') {
      // store value as _value as well since
      // non-string values will be stringified
      elm._value = cur;
      // avoid resetting cursor position when value is the same
      var strCur = isUndef(cur) ? '' : String(cur);
      if (shouldUpdateValue(elm, vnode, strCur)) {
        elm.value = strCur;
      }
    } else {
      elm[key] = cur;
    }
  }
}

// check platforms/web/util/attrs.js acceptValue


function shouldUpdateValue (
  elm,
  vnode,
  checkVal
) {
  return (!elm.composing && (
    vnode.tag === 'option' ||
    isDirty(elm, checkVal) ||
    isInputChanged(elm, checkVal)
  ))
}

function isDirty (elm, checkVal) {
  // return true when textbox (.number and .trim) loses focus and its value is not equal to the updated value
  return document.activeElement !== elm && elm.value !== checkVal
}

function isInputChanged (elm, newVal) {
  var value = elm.value;
  var modifiers = elm._vModifiers; // injected by v-model runtime
  if ((isDef(modifiers) && modifiers.number) || elm.type === 'number') {
    return toNumber(value) !== toNumber(newVal)
  }
  if (isDef(modifiers) && modifiers.trim) {
    return value.trim() !== newVal.trim()
  }
  return value !== newVal
}

var domProps = {
  create: updateDOMProps,
  update: updateDOMProps
};

/*  */

var parseStyleText = cached(function (cssText) {
  var res = {};
  var listDelimiter = /;(?![^(]*\))/g;
  var propertyDelimiter = /:(.+)/;
  cssText.split(listDelimiter).forEach(function (item) {
    if (item) {
      var tmp = item.split(propertyDelimiter);
      tmp.length > 1 && (res[tmp[0].trim()] = tmp[1].trim());
    }
  });
  return res
});

// merge static and dynamic style data on the same vnode
function normalizeStyleData (data) {
  var style = normalizeStyleBinding(data.style);
  // static style is pre-processed into an object during compilation
  // and is always a fresh object, so it's safe to merge into it
  return data.staticStyle
    ? extend(data.staticStyle, style)
    : style
}

// normalize possible array / string values into Object
function normalizeStyleBinding (bindingStyle) {
  if (Array.isArray(bindingStyle)) {
    return toObject(bindingStyle)
  }
  if (typeof bindingStyle === 'string') {
    return parseStyleText(bindingStyle)
  }
  return bindingStyle
}

/**
 * parent component style should be after child's
 * so that parent component's style could override it
 */
function getStyle (vnode, checkChild) {
  var res = {};
  var styleData;

  if (checkChild) {
    var childNode = vnode;
    while (childNode.componentInstance) {
      childNode = childNode.componentInstance._vnode;
      if (childNode.data && (styleData = normalizeStyleData(childNode.data))) {
        extend(res, styleData);
      }
    }
  }

  if ((styleData = normalizeStyleData(vnode.data))) {
    extend(res, styleData);
  }

  var parentNode = vnode;
  while ((parentNode = parentNode.parent)) {
    if (parentNode.data && (styleData = normalizeStyleData(parentNode.data))) {
      extend(res, styleData);
    }
  }
  return res
}

/*  */

var cssVarRE = /^--/;
var importantRE = /\s*!important$/;
var setProp = function (el, name, val) {
  /* istanbul ignore if */
  if (cssVarRE.test(name)) {
    el.style.setProperty(name, val);
  } else if (importantRE.test(val)) {
    el.style.setProperty(name, val.replace(importantRE, ''), 'important');
  } else {
    var normalizedName = normalize(name);
    if (Array.isArray(val)) {
      // Support values array created by autoprefixer, e.g.
      // {display: ["-webkit-box", "-ms-flexbox", "flex"]}
      // Set them one by one, and the browser will only set those it can recognize
      for (var i = 0, len = val.length; i < len; i++) {
        el.style[normalizedName] = val[i];
      }
    } else {
      el.style[normalizedName] = val;
    }
  }
};

var prefixes = ['Webkit', 'Moz', 'ms'];

var testEl;
var normalize = cached(function (prop) {
  testEl = testEl || document.createElement('div');
  prop = camelize(prop);
  if (prop !== 'filter' && (prop in testEl.style)) {
    return prop
  }
  var upper = prop.charAt(0).toUpperCase() + prop.slice(1);
  for (var i = 0; i < prefixes.length; i++) {
    var prefixed = prefixes[i] + upper;
    if (prefixed in testEl.style) {
      return prefixed
    }
  }
});

function updateStyle (oldVnode, vnode) {
  var data = vnode.data;
  var oldData = oldVnode.data;

  if (isUndef(data.staticStyle) && isUndef(data.style) &&
    isUndef(oldData.staticStyle) && isUndef(oldData.style)
  ) {
    return
  }

  var cur, name;
  var el = vnode.elm;
  var oldStaticStyle = oldData.staticStyle;
  var oldStyleBinding = oldData.normalizedStyle || oldData.style || {};

  // if static style exists, stylebinding already merged into it when doing normalizeStyleData
  var oldStyle = oldStaticStyle || oldStyleBinding;

  var style = normalizeStyleBinding(vnode.data.style) || {};

  // store normalized style under a different key for next diff
  // make sure to clone it if it's reactive, since the user likley wants
  // to mutate it.
  vnode.data.normalizedStyle = isDef(style.__ob__)
    ? extend({}, style)
    : style;

  var newStyle = getStyle(vnode, true);

  for (name in oldStyle) {
    if (isUndef(newStyle[name])) {
      setProp(el, name, '');
    }
  }
  for (name in newStyle) {
    cur = newStyle[name];
    if (cur !== oldStyle[name]) {
      // ie9 setting to null has no effect, must use empty string
      setProp(el, name, cur == null ? '' : cur);
    }
  }
}

var style = {
  create: updateStyle,
  update: updateStyle
};

/*  */

/**
 * Add class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function addClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.add(c); });
    } else {
      el.classList.add(cls);
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    if (cur.indexOf(' ' + cls + ' ') < 0) {
      el.setAttribute('class', (cur + cls).trim());
    }
  }
}

/**
 * Remove class with compatibility for SVG since classList is not supported on
 * SVG elements in IE
 */
function removeClass (el, cls) {
  /* istanbul ignore if */
  if (!cls || !(cls = cls.trim())) {
    return
  }

  /* istanbul ignore else */
  if (el.classList) {
    if (cls.indexOf(' ') > -1) {
      cls.split(/\s+/).forEach(function (c) { return el.classList.remove(c); });
    } else {
      el.classList.remove(cls);
    }
  } else {
    var cur = " " + (el.getAttribute('class') || '') + " ";
    var tar = ' ' + cls + ' ';
    while (cur.indexOf(tar) >= 0) {
      cur = cur.replace(tar, ' ');
    }
    el.setAttribute('class', cur.trim());
  }
}

/*  */

function resolveTransition (def$$1) {
  if (!def$$1) {
    return
  }
  /* istanbul ignore else */
  if (typeof def$$1 === 'object') {
    var res = {};
    if (def$$1.css !== false) {
      extend(res, autoCssTransition(def$$1.name || 'v'));
    }
    extend(res, def$$1);
    return res
  } else if (typeof def$$1 === 'string') {
    return autoCssTransition(def$$1)
  }
}

var autoCssTransition = cached(function (name) {
  return {
    enterClass: (name + "-enter"),
    enterToClass: (name + "-enter-to"),
    enterActiveClass: (name + "-enter-active"),
    leaveClass: (name + "-leave"),
    leaveToClass: (name + "-leave-to"),
    leaveActiveClass: (name + "-leave-active")
  }
});

var hasTransition = inBrowser && !isIE9;
var TRANSITION = 'transition';
var ANIMATION = 'animation';

// Transition property/event sniffing
var transitionProp = 'transition';
var transitionEndEvent = 'transitionend';
var animationProp = 'animation';
var animationEndEvent = 'animationend';
if (hasTransition) {
  /* istanbul ignore if */
  if (window.ontransitionend === undefined &&
    window.onwebkittransitionend !== undefined
  ) {
    transitionProp = 'WebkitTransition';
    transitionEndEvent = 'webkitTransitionEnd';
  }
  if (window.onanimationend === undefined &&
    window.onwebkitanimationend !== undefined
  ) {
    animationProp = 'WebkitAnimation';
    animationEndEvent = 'webkitAnimationEnd';
  }
}

// binding to window is necessary to make hot reload work in IE in strict mode
var raf = inBrowser && window.requestAnimationFrame
  ? window.requestAnimationFrame.bind(window)
  : setTimeout;

function nextFrame (fn) {
  raf(function () {
    raf(fn);
  });
}

function addTransitionClass (el, cls) {
  (el._transitionClasses || (el._transitionClasses = [])).push(cls);
  addClass(el, cls);
}

function removeTransitionClass (el, cls) {
  if (el._transitionClasses) {
    remove(el._transitionClasses, cls);
  }
  removeClass(el, cls);
}

function whenTransitionEnds (
  el,
  expectedType,
  cb
) {
  var ref = getTransitionInfo(el, expectedType);
  var type = ref.type;
  var timeout = ref.timeout;
  var propCount = ref.propCount;
  if (!type) { return cb() }
  var event = type === TRANSITION ? transitionEndEvent : animationEndEvent;
  var ended = 0;
  var end = function () {
    el.removeEventListener(event, onEnd);
    cb();
  };
  var onEnd = function (e) {
    if (e.target === el) {
      if (++ended >= propCount) {
        end();
      }
    }
  };
  setTimeout(function () {
    if (ended < propCount) {
      end();
    }
  }, timeout + 1);
  el.addEventListener(event, onEnd);
}

var transformRE = /\b(transform|all)(,|$)/;

function getTransitionInfo (el, expectedType) {
  var styles = window.getComputedStyle(el);
  var transitionDelays = styles[transitionProp + 'Delay'].split(', ');
  var transitionDurations = styles[transitionProp + 'Duration'].split(', ');
  var transitionTimeout = getTimeout(transitionDelays, transitionDurations);
  var animationDelays = styles[animationProp + 'Delay'].split(', ');
  var animationDurations = styles[animationProp + 'Duration'].split(', ');
  var animationTimeout = getTimeout(animationDelays, animationDurations);

  var type;
  var timeout = 0;
  var propCount = 0;
  /* istanbul ignore if */
  if (expectedType === TRANSITION) {
    if (transitionTimeout > 0) {
      type = TRANSITION;
      timeout = transitionTimeout;
      propCount = transitionDurations.length;
    }
  } else if (expectedType === ANIMATION) {
    if (animationTimeout > 0) {
      type = ANIMATION;
      timeout = animationTimeout;
      propCount = animationDurations.length;
    }
  } else {
    timeout = Math.max(transitionTimeout, animationTimeout);
    type = timeout > 0
      ? transitionTimeout > animationTimeout
        ? TRANSITION
        : ANIMATION
      : null;
    propCount = type
      ? type === TRANSITION
        ? transitionDurations.length
        : animationDurations.length
      : 0;
  }
  var hasTransform =
    type === TRANSITION &&
    transformRE.test(styles[transitionProp + 'Property']);
  return {
    type: type,
    timeout: timeout,
    propCount: propCount,
    hasTransform: hasTransform
  }
}

function getTimeout (delays, durations) {
  /* istanbul ignore next */
  while (delays.length < durations.length) {
    delays = delays.concat(delays);
  }

  return Math.max.apply(null, durations.map(function (d, i) {
    return toMs(d) + toMs(delays[i])
  }))
}

function toMs (s) {
  return Number(s.slice(0, -1)) * 1000
}

/*  */

function enter (vnode, toggleDisplay) {
  var el = vnode.elm;

  // call leave callback now
  if (isDef(el._leaveCb)) {
    el._leaveCb.cancelled = true;
    el._leaveCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data)) {
    return
  }

  /* istanbul ignore if */
  if (isDef(el._enterCb) || el.nodeType !== 1) {
    return
  }

  var css = data.css;
  var type = data.type;
  var enterClass = data.enterClass;
  var enterToClass = data.enterToClass;
  var enterActiveClass = data.enterActiveClass;
  var appearClass = data.appearClass;
  var appearToClass = data.appearToClass;
  var appearActiveClass = data.appearActiveClass;
  var beforeEnter = data.beforeEnter;
  var enter = data.enter;
  var afterEnter = data.afterEnter;
  var enterCancelled = data.enterCancelled;
  var beforeAppear = data.beforeAppear;
  var appear = data.appear;
  var afterAppear = data.afterAppear;
  var appearCancelled = data.appearCancelled;
  var duration = data.duration;

  // activeInstance will always be the <transition> component managing this
  // transition. One edge case to check is when the <transition> is placed
  // as the root node of a child component. In that case we need to check
  // <transition>'s parent for appear check.
  var context = activeInstance;
  var transitionNode = activeInstance.$vnode;
  while (transitionNode && transitionNode.parent) {
    transitionNode = transitionNode.parent;
    context = transitionNode.context;
  }

  var isAppear = !context._isMounted || !vnode.isRootInsert;

  if (isAppear && !appear && appear !== '') {
    return
  }

  var startClass = isAppear && appearClass
    ? appearClass
    : enterClass;
  var activeClass = isAppear && appearActiveClass
    ? appearActiveClass
    : enterActiveClass;
  var toClass = isAppear && appearToClass
    ? appearToClass
    : enterToClass;

  var beforeEnterHook = isAppear
    ? (beforeAppear || beforeEnter)
    : beforeEnter;
  var enterHook = isAppear
    ? (typeof appear === 'function' ? appear : enter)
    : enter;
  var afterEnterHook = isAppear
    ? (afterAppear || afterEnter)
    : afterEnter;
  var enterCancelledHook = isAppear
    ? (appearCancelled || enterCancelled)
    : enterCancelled;

  var explicitEnterDuration = toNumber(
    isObject(duration)
      ? duration.enter
      : duration
  );

  if ("development" !== 'production' && explicitEnterDuration != null) {
    checkDuration(explicitEnterDuration, 'enter', vnode);
  }

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(enterHook);

  var cb = el._enterCb = once(function () {
    if (expectsCSS) {
      removeTransitionClass(el, toClass);
      removeTransitionClass(el, activeClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, startClass);
      }
      enterCancelledHook && enterCancelledHook(el);
    } else {
      afterEnterHook && afterEnterHook(el);
    }
    el._enterCb = null;
  });

  if (!vnode.data.show) {
    // remove pending leave element on enter by injecting an insert hook
    mergeVNodeHook(vnode.data.hook || (vnode.data.hook = {}), 'insert', function () {
      var parent = el.parentNode;
      var pendingNode = parent && parent._pending && parent._pending[vnode.key];
      if (pendingNode &&
        pendingNode.tag === vnode.tag &&
        pendingNode.elm._leaveCb
      ) {
        pendingNode.elm._leaveCb();
      }
      enterHook && enterHook(el, cb);
    });
  }

  // start enter transition
  beforeEnterHook && beforeEnterHook(el);
  if (expectsCSS) {
    addTransitionClass(el, startClass);
    addTransitionClass(el, activeClass);
    nextFrame(function () {
      addTransitionClass(el, toClass);
      removeTransitionClass(el, startClass);
      if (!cb.cancelled && !userWantsControl) {
        if (isValidDuration(explicitEnterDuration)) {
          setTimeout(cb, explicitEnterDuration);
        } else {
          whenTransitionEnds(el, type, cb);
        }
      }
    });
  }

  if (vnode.data.show) {
    toggleDisplay && toggleDisplay();
    enterHook && enterHook(el, cb);
  }

  if (!expectsCSS && !userWantsControl) {
    cb();
  }
}

function leave (vnode, rm) {
  var el = vnode.elm;

  // call enter callback now
  if (isDef(el._enterCb)) {
    el._enterCb.cancelled = true;
    el._enterCb();
  }

  var data = resolveTransition(vnode.data.transition);
  if (isUndef(data)) {
    return rm()
  }

  /* istanbul ignore if */
  if (isDef(el._leaveCb) || el.nodeType !== 1) {
    return
  }

  var css = data.css;
  var type = data.type;
  var leaveClass = data.leaveClass;
  var leaveToClass = data.leaveToClass;
  var leaveActiveClass = data.leaveActiveClass;
  var beforeLeave = data.beforeLeave;
  var leave = data.leave;
  var afterLeave = data.afterLeave;
  var leaveCancelled = data.leaveCancelled;
  var delayLeave = data.delayLeave;
  var duration = data.duration;

  var expectsCSS = css !== false && !isIE9;
  var userWantsControl = getHookArgumentsLength(leave);

  var explicitLeaveDuration = toNumber(
    isObject(duration)
      ? duration.leave
      : duration
  );

  if ("development" !== 'production' && isDef(explicitLeaveDuration)) {
    checkDuration(explicitLeaveDuration, 'leave', vnode);
  }

  var cb = el._leaveCb = once(function () {
    if (el.parentNode && el.parentNode._pending) {
      el.parentNode._pending[vnode.key] = null;
    }
    if (expectsCSS) {
      removeTransitionClass(el, leaveToClass);
      removeTransitionClass(el, leaveActiveClass);
    }
    if (cb.cancelled) {
      if (expectsCSS) {
        removeTransitionClass(el, leaveClass);
      }
      leaveCancelled && leaveCancelled(el);
    } else {
      rm();
      afterLeave && afterLeave(el);
    }
    el._leaveCb = null;
  });

  if (delayLeave) {
    delayLeave(performLeave);
  } else {
    performLeave();
  }

  function performLeave () {
    // the delayed leave may have already been cancelled
    if (cb.cancelled) {
      return
    }
    // record leaving element
    if (!vnode.data.show) {
      (el.parentNode._pending || (el.parentNode._pending = {}))[(vnode.key)] = vnode;
    }
    beforeLeave && beforeLeave(el);
    if (expectsCSS) {
      addTransitionClass(el, leaveClass);
      addTransitionClass(el, leaveActiveClass);
      nextFrame(function () {
        addTransitionClass(el, leaveToClass);
        removeTransitionClass(el, leaveClass);
        if (!cb.cancelled && !userWantsControl) {
          if (isValidDuration(explicitLeaveDuration)) {
            setTimeout(cb, explicitLeaveDuration);
          } else {
            whenTransitionEnds(el, type, cb);
          }
        }
      });
    }
    leave && leave(el, cb);
    if (!expectsCSS && !userWantsControl) {
      cb();
    }
  }
}

// only used in dev mode
function checkDuration (val, name, vnode) {
  if (typeof val !== 'number') {
    warn(
      "<transition> explicit " + name + " duration is not a valid number - " +
      "got " + (JSON.stringify(val)) + ".",
      vnode.context
    );
  } else if (isNaN(val)) {
    warn(
      "<transition> explicit " + name + " duration is NaN - " +
      'the duration expression might be incorrect.',
      vnode.context
    );
  }
}

function isValidDuration (val) {
  return typeof val === 'number' && !isNaN(val)
}

/**
 * Normalize a transition hook's argument length. The hook may be:
 * - a merged hook (invoker) with the original in .fns
 * - a wrapped component method (check ._length)
 * - a plain function (.length)
 */
function getHookArgumentsLength (fn) {
  if (isUndef(fn)) {
    return false
  }
  var invokerFns = fn.fns;
  if (isDef(invokerFns)) {
    // invoker
    return getHookArgumentsLength(
      Array.isArray(invokerFns)
        ? invokerFns[0]
        : invokerFns
    )
  } else {
    return (fn._length || fn.length) > 1
  }
}

function _enter (_, vnode) {
  if (vnode.data.show !== true) {
    enter(vnode);
  }
}

var transition = inBrowser ? {
  create: _enter,
  activate: _enter,
  remove: function remove$$1 (vnode, rm) {
    /* istanbul ignore else */
    if (vnode.data.show !== true) {
      leave(vnode, rm);
    } else {
      rm();
    }
  }
} : {};

var platformModules = [
  attrs,
  klass,
  events,
  domProps,
  style,
  transition
];

/*  */

// the directive module should be applied last, after all
// built-in modules have been applied.
var modules = platformModules.concat(baseModules);

var patch = createPatchFunction({ nodeOps: nodeOps, modules: modules });

/**
 * Not type checking this file because flow doesn't like attaching
 * properties to Elements.
 */

/* istanbul ignore if */
if (isIE9) {
  // http://www.matts411.com/post/internet-explorer-9-oninput/
  document.addEventListener('selectionchange', function () {
    var el = document.activeElement;
    if (el && el.vmodel) {
      trigger(el, 'input');
    }
  });
}

var model$1 = {
  inserted: function inserted (el, binding, vnode) {
    if (vnode.tag === 'select') {
      var cb = function () {
        setSelected(el, binding, vnode.context);
      };
      cb();
      /* istanbul ignore if */
      if (isIE || isEdge) {
        setTimeout(cb, 0);
      }
    } else if (vnode.tag === 'textarea' || el.type === 'text' || el.type === 'password') {
      el._vModifiers = binding.modifiers;
      if (!binding.modifiers.lazy) {
        // Safari < 10.2 & UIWebView doesn't fire compositionend when
        // switching focus before confirming composition choice
        // this also fixes the issue where some browsers e.g. iOS Chrome
        // fires "change" instead of "input" on autocomplete.
        el.addEventListener('change', onCompositionEnd);
        if (!isAndroid) {
          el.addEventListener('compositionstart', onCompositionStart);
          el.addEventListener('compositionend', onCompositionEnd);
        }
        /* istanbul ignore if */
        if (isIE9) {
          el.vmodel = true;
        }
      }
    }
  },
  componentUpdated: function componentUpdated (el, binding, vnode) {
    if (vnode.tag === 'select') {
      setSelected(el, binding, vnode.context);
      // in case the options rendered by v-for have changed,
      // it's possible that the value is out-of-sync with the rendered options.
      // detect such cases and filter out values that no longer has a matching
      // option in the DOM.
      var needReset = el.multiple
        ? binding.value.some(function (v) { return hasNoMatchingOption(v, el.options); })
        : binding.value !== binding.oldValue && hasNoMatchingOption(binding.value, el.options);
      if (needReset) {
        trigger(el, 'change');
      }
    }
  }
};

function setSelected (el, binding, vm) {
  var value = binding.value;
  var isMultiple = el.multiple;
  if (isMultiple && !Array.isArray(value)) {
    "development" !== 'production' && warn(
      "<select multiple v-model=\"" + (binding.expression) + "\"> " +
      "expects an Array value for its binding, but got " + (Object.prototype.toString.call(value).slice(8, -1)),
      vm
    );
    return
  }
  var selected, option;
  for (var i = 0, l = el.options.length; i < l; i++) {
    option = el.options[i];
    if (isMultiple) {
      selected = looseIndexOf(value, getValue(option)) > -1;
      if (option.selected !== selected) {
        option.selected = selected;
      }
    } else {
      if (looseEqual(getValue(option), value)) {
        if (el.selectedIndex !== i) {
          el.selectedIndex = i;
        }
        return
      }
    }
  }
  if (!isMultiple) {
    el.selectedIndex = -1;
  }
}

function hasNoMatchingOption (value, options) {
  for (var i = 0, l = options.length; i < l; i++) {
    if (looseEqual(getValue(options[i]), value)) {
      return false
    }
  }
  return true
}

function getValue (option) {
  return '_value' in option
    ? option._value
    : option.value
}

function onCompositionStart (e) {
  e.target.composing = true;
}

function onCompositionEnd (e) {
  // prevent triggering an input event for no reason
  if (!e.target.composing) { return }
  e.target.composing = false;
  trigger(e.target, 'input');
}

function trigger (el, type) {
  var e = document.createEvent('HTMLEvents');
  e.initEvent(type, true, true);
  el.dispatchEvent(e);
}

/*  */

// recursively search for possible transition defined inside the component root
function locateNode (vnode) {
  return vnode.componentInstance && (!vnode.data || !vnode.data.transition)
    ? locateNode(vnode.componentInstance._vnode)
    : vnode
}

var show = {
  bind: function bind (el, ref, vnode) {
    var value = ref.value;

    vnode = locateNode(vnode);
    var transition = vnode.data && vnode.data.transition;
    var originalDisplay = el.__vOriginalDisplay =
      el.style.display === 'none' ? '' : el.style.display;
    if (value && transition && !isIE9) {
      vnode.data.show = true;
      enter(vnode, function () {
        el.style.display = originalDisplay;
      });
    } else {
      el.style.display = value ? originalDisplay : 'none';
    }
  },

  update: function update (el, ref, vnode) {
    var value = ref.value;
    var oldValue = ref.oldValue;

    /* istanbul ignore if */
    if (value === oldValue) { return }
    vnode = locateNode(vnode);
    var transition = vnode.data && vnode.data.transition;
    if (transition && !isIE9) {
      vnode.data.show = true;
      if (value) {
        enter(vnode, function () {
          el.style.display = el.__vOriginalDisplay;
        });
      } else {
        leave(vnode, function () {
          el.style.display = 'none';
        });
      }
    } else {
      el.style.display = value ? el.__vOriginalDisplay : 'none';
    }
  },

  unbind: function unbind (
    el,
    binding,
    vnode,
    oldVnode,
    isDestroy
  ) {
    if (!isDestroy) {
      el.style.display = el.__vOriginalDisplay;
    }
  }
};

var platformDirectives = {
  model: model$1,
  show: show
};

/*  */

// Provides transition support for a single element/component.
// supports transition mode (out-in / in-out)

var transitionProps = {
  name: String,
  appear: Boolean,
  css: Boolean,
  mode: String,
  type: String,
  enterClass: String,
  leaveClass: String,
  enterToClass: String,
  leaveToClass: String,
  enterActiveClass: String,
  leaveActiveClass: String,
  appearClass: String,
  appearActiveClass: String,
  appearToClass: String,
  duration: [Number, String, Object]
};

// in case the child is also an abstract component, e.g. <keep-alive>
// we want to recursively retrieve the real component to be rendered
function getRealChild (vnode) {
  var compOptions = vnode && vnode.componentOptions;
  if (compOptions && compOptions.Ctor.options.abstract) {
    return getRealChild(getFirstComponentChild(compOptions.children))
  } else {
    return vnode
  }
}

function extractTransitionData (comp) {
  var data = {};
  var options = comp.$options;
  // props
  for (var key in options.propsData) {
    data[key] = comp[key];
  }
  // events.
  // extract listeners and pass them directly to the transition methods
  var listeners = options._parentListeners;
  for (var key$1 in listeners) {
    data[camelize(key$1)] = listeners[key$1];
  }
  return data
}

function placeholder (h, rawChild) {
  if (/\d-keep-alive$/.test(rawChild.tag)) {
    return h('keep-alive', {
      props: rawChild.componentOptions.propsData
    })
  }
}

function hasParentTransition (vnode) {
  while ((vnode = vnode.parent)) {
    if (vnode.data.transition) {
      return true
    }
  }
}

function isSameChild (child, oldChild) {
  return oldChild.key === child.key && oldChild.tag === child.tag
}

var Transition = {
  name: 'transition',
  props: transitionProps,
  abstract: true,

  render: function render (h) {
    var this$1 = this;

    var children = this.$slots.default;
    if (!children) {
      return
    }

    // filter out text nodes (possible whitespaces)
    children = children.filter(function (c) { return c.tag; });
    /* istanbul ignore if */
    if (!children.length) {
      return
    }

    // warn multiple elements
    if ("development" !== 'production' && children.length > 1) {
      warn(
        '<transition> can only be used on a single element. Use ' +
        '<transition-group> for lists.',
        this.$parent
      );
    }

    var mode = this.mode;

    // warn invalid mode
    if ("development" !== 'production' &&
      mode && mode !== 'in-out' && mode !== 'out-in'
    ) {
      warn(
        'invalid <transition> mode: ' + mode,
        this.$parent
      );
    }

    var rawChild = children[0];

    // if this is a component root node and the component's
    // parent container node also has transition, skip.
    if (hasParentTransition(this.$vnode)) {
      return rawChild
    }

    // apply transition data to child
    // use getRealChild() to ignore abstract components e.g. keep-alive
    var child = getRealChild(rawChild);
    /* istanbul ignore if */
    if (!child) {
      return rawChild
    }

    if (this._leaving) {
      return placeholder(h, rawChild)
    }

    // ensure a key that is unique to the vnode type and to this transition
    // component instance. This key will be used to remove pending leaving nodes
    // during entering.
    var id = "__transition-" + (this._uid) + "-";
    child.key = child.key == null
      ? id + child.tag
      : isPrimitive(child.key)
        ? (String(child.key).indexOf(id) === 0 ? child.key : id + child.key)
        : child.key;

    var data = (child.data || (child.data = {})).transition = extractTransitionData(this);
    var oldRawChild = this._vnode;
    var oldChild = getRealChild(oldRawChild);

    // mark v-show
    // so that the transition module can hand over the control to the directive
    if (child.data.directives && child.data.directives.some(function (d) { return d.name === 'show'; })) {
      child.data.show = true;
    }

    if (oldChild && oldChild.data && !isSameChild(child, oldChild)) {
      // replace old child transition data with fresh one
      // important for dynamic transitions!
      var oldData = oldChild && (oldChild.data.transition = extend({}, data));
      // handle transition mode
      if (mode === 'out-in') {
        // return placeholder node and queue update when leave finishes
        this._leaving = true;
        mergeVNodeHook(oldData, 'afterLeave', function () {
          this$1._leaving = false;
          this$1.$forceUpdate();
        });
        return placeholder(h, rawChild)
      } else if (mode === 'in-out') {
        var delayedLeave;
        var performLeave = function () { delayedLeave(); };
        mergeVNodeHook(data, 'afterEnter', performLeave);
        mergeVNodeHook(data, 'enterCancelled', performLeave);
        mergeVNodeHook(oldData, 'delayLeave', function (leave) { delayedLeave = leave; });
      }
    }

    return rawChild
  }
};

/*  */

// Provides transition support for list items.
// supports move transitions using the FLIP technique.

// Because the vdom's children update algorithm is "unstable" - i.e.
// it doesn't guarantee the relative positioning of removed elements,
// we force transition-group to update its children into two passes:
// in the first pass, we remove all nodes that need to be removed,
// triggering their leaving transition; in the second pass, we insert/move
// into the final desired state. This way in the second pass removed
// nodes will remain where they should be.

var props = extend({
  tag: String,
  moveClass: String
}, transitionProps);

delete props.mode;

var TransitionGroup = {
  props: props,

  render: function render (h) {
    var tag = this.tag || this.$vnode.data.tag || 'span';
    var map = Object.create(null);
    var prevChildren = this.prevChildren = this.children;
    var rawChildren = this.$slots.default || [];
    var children = this.children = [];
    var transitionData = extractTransitionData(this);

    for (var i = 0; i < rawChildren.length; i++) {
      var c = rawChildren[i];
      if (c.tag) {
        if (c.key != null && String(c.key).indexOf('__vlist') !== 0) {
          children.push(c);
          map[c.key] = c
          ;(c.data || (c.data = {})).transition = transitionData;
        } else {
          var opts = c.componentOptions;
          var name = opts ? (opts.Ctor.options.name || opts.tag || '') : c.tag;
          warn(("<transition-group> children must be keyed: <" + name + ">"));
        }
      }
    }

    if (prevChildren) {
      var kept = [];
      var removed = [];
      for (var i$1 = 0; i$1 < prevChildren.length; i$1++) {
        var c$1 = prevChildren[i$1];
        c$1.data.transition = transitionData;
        c$1.data.pos = c$1.elm.getBoundingClientRect();
        if (map[c$1.key]) {
          kept.push(c$1);
        } else {
          removed.push(c$1);
        }
      }
      this.kept = h(tag, null, kept);
      this.removed = removed;
    }

    return h(tag, null, children)
  },

  beforeUpdate: function beforeUpdate () {
    // force removing pass
    this.__patch__(
      this._vnode,
      this.kept,
      false, // hydrating
      true // removeOnly (!important, avoids unnecessary moves)
    );
    this._vnode = this.kept;
  },

  updated: function updated () {
    var children = this.prevChildren;
    var moveClass = this.moveClass || ((this.name || 'v') + '-move');
    if (!children.length || !this.hasMove(children[0].elm, moveClass)) {
      return
    }

    // we divide the work into three loops to avoid mixing DOM reads and writes
    // in each iteration - which helps prevent layout thrashing.
    children.forEach(callPendingCbs);
    children.forEach(recordPosition);
    children.forEach(applyTranslation);

    // force reflow to put everything in position
    var body = document.body;
    var f = body.offsetHeight; // eslint-disable-line

    children.forEach(function (c) {
      if (c.data.moved) {
        var el = c.elm;
        var s = el.style;
        addTransitionClass(el, moveClass);
        s.transform = s.WebkitTransform = s.transitionDuration = '';
        el.addEventListener(transitionEndEvent, el._moveCb = function cb (e) {
          if (!e || /transform$/.test(e.propertyName)) {
            el.removeEventListener(transitionEndEvent, cb);
            el._moveCb = null;
            removeTransitionClass(el, moveClass);
          }
        });
      }
    });
  },

  methods: {
    hasMove: function hasMove (el, moveClass) {
      /* istanbul ignore if */
      if (!hasTransition) {
        return false
      }
      if (this._hasMove != null) {
        return this._hasMove
      }
      // Detect whether an element with the move class applied has
      // CSS transitions. Since the element may be inside an entering
      // transition at this very moment, we make a clone of it and remove
      // all other transition classes applied to ensure only the move class
      // is applied.
      var clone = el.cloneNode();
      if (el._transitionClasses) {
        el._transitionClasses.forEach(function (cls) { removeClass(clone, cls); });
      }
      addClass(clone, moveClass);
      clone.style.display = 'none';
      this.$el.appendChild(clone);
      var info = getTransitionInfo(clone);
      this.$el.removeChild(clone);
      return (this._hasMove = info.hasTransform)
    }
  }
};

function callPendingCbs (c) {
  /* istanbul ignore if */
  if (c.elm._moveCb) {
    c.elm._moveCb();
  }
  /* istanbul ignore if */
  if (c.elm._enterCb) {
    c.elm._enterCb();
  }
}

function recordPosition (c) {
  c.data.newPos = c.elm.getBoundingClientRect();
}

function applyTranslation (c) {
  var oldPos = c.data.pos;
  var newPos = c.data.newPos;
  var dx = oldPos.left - newPos.left;
  var dy = oldPos.top - newPos.top;
  if (dx || dy) {
    c.data.moved = true;
    var s = c.elm.style;
    s.transform = s.WebkitTransform = "translate(" + dx + "px," + dy + "px)";
    s.transitionDuration = '0s';
  }
}

var platformComponents = {
  Transition: Transition,
  TransitionGroup: TransitionGroup
};

/*  */

// install platform specific utils
Vue$3.config.mustUseProp = mustUseProp;
Vue$3.config.isReservedTag = isReservedTag;
Vue$3.config.isReservedAttr = isReservedAttr;
Vue$3.config.getTagNamespace = getTagNamespace;
Vue$3.config.isUnknownElement = isUnknownElement;

// install platform runtime directives & components
extend(Vue$3.options.directives, platformDirectives);
extend(Vue$3.options.components, platformComponents);

// install platform patch function
Vue$3.prototype.__patch__ = inBrowser ? patch : noop;

// public mount method
Vue$3.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && inBrowser ? query(el) : undefined;
  return mountComponent(this, el, hydrating)
};

// devtools global hook
/* istanbul ignore next */
setTimeout(function () {
  if (config.devtools) {
    if (devtools) {
      devtools.emit('init', Vue$3);
    } else if ("development" !== 'production' && isChrome) {
      console[console.info ? 'info' : 'log'](
        'Download the Vue Devtools extension for a better development experience:\n' +
        'https://github.com/vuejs/vue-devtools'
      );
    }
  }
  if ("development" !== 'production' &&
    config.productionTip !== false &&
    inBrowser && typeof console !== 'undefined'
  ) {
    console[console.info ? 'info' : 'log'](
      "You are running Vue in development mode.\n" +
      "Make sure to turn on production mode when deploying for production.\n" +
      "See more tips at https://vuejs.org/guide/deployment.html"
    );
  }
}, 0);

/*  */

// check whether current browser encodes a char inside attribute values
function shouldDecode (content, encoded) {
  var div = document.createElement('div');
  div.innerHTML = "<div a=\"" + content + "\">";
  return div.innerHTML.indexOf(encoded) > 0
}

// #3663
// IE encodes newlines inside attribute values while other browsers don't
var shouldDecodeNewlines = inBrowser ? shouldDecode('\n', '&#10;') : false;

/*  */

var isUnaryTag = makeMap(
  'area,base,br,col,embed,frame,hr,img,input,isindex,keygen,' +
  'link,meta,param,source,track,wbr'
);

// Elements that you can, intentionally, leave open
// (and which close themselves)
var canBeLeftOpenTag = makeMap(
  'colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr,source'
);

// HTML5 tags https://html.spec.whatwg.org/multipage/indices.html#elements-3
// Phrasing Content https://html.spec.whatwg.org/multipage/dom.html#phrasing-content
var isNonPhrasingTag = makeMap(
  'address,article,aside,base,blockquote,body,caption,col,colgroup,dd,' +
  'details,dialog,div,dl,dt,fieldset,figcaption,figure,footer,form,' +
  'h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,legend,li,menuitem,meta,' +
  'optgroup,option,param,rp,rt,source,style,summary,tbody,td,tfoot,th,thead,' +
  'title,tr,track'
);

/*  */

var decoder;

function decode (html) {
  decoder = decoder || document.createElement('div');
  decoder.innerHTML = html;
  return decoder.textContent
}

/**
 * Not type-checking this file because it's mostly vendor code.
 */

/*!
 * HTML Parser By John Resig (ejohn.org)
 * Modified by Juriy "kangax" Zaytsev
 * Original code by Erik Arvidsson, Mozilla Public License
 * http://erik.eae.net/simplehtmlparser/simplehtmlparser.js
 */

// Regular Expressions for parsing tags and attributes
var singleAttrIdentifier = /([^\s"'<>/=]+)/;
var singleAttrAssign = /(?:=)/;
var singleAttrValues = [
  // attr value double quotes
  /"([^"]*)"+/.source,
  // attr value, single quotes
  /'([^']*)'+/.source,
  // attr value, no quotes
  /([^\s"'=<>`]+)/.source
];
var attribute = new RegExp(
  '^\\s*' + singleAttrIdentifier.source +
  '(?:\\s*(' + singleAttrAssign.source + ')' +
  '\\s*(?:' + singleAttrValues.join('|') + '))?'
);

// could use https://www.w3.org/TR/1999/REC-xml-names-19990114/#NT-QName
// but for Vue templates we can enforce a simple charset
var ncname = '[a-zA-Z_][\\w\\-\\.]*';
var qnameCapture = '((?:' + ncname + '\\:)?' + ncname + ')';
var startTagOpen = new RegExp('^<' + qnameCapture);
var startTagClose = /^\s*(\/?)>/;
var endTag = new RegExp('^<\\/' + qnameCapture + '[^>]*>');
var doctype = /^<!DOCTYPE [^>]+>/i;
var comment = /^<!--/;
var conditionalComment = /^<!\[/;

var IS_REGEX_CAPTURING_BROKEN = false;
'x'.replace(/x(.)?/g, function (m, g) {
  IS_REGEX_CAPTURING_BROKEN = g === '';
});

// Special Elements (can contain anything)
var isPlainTextElement = makeMap('script,style,textarea', true);
var reCache = {};

var decodingMap = {
  '&lt;': '<',
  '&gt;': '>',
  '&quot;': '"',
  '&amp;': '&',
  '&#10;': '\n'
};
var encodedAttr = /&(?:lt|gt|quot|amp);/g;
var encodedAttrWithNewLines = /&(?:lt|gt|quot|amp|#10);/g;

function decodeAttr (value, shouldDecodeNewlines) {
  var re = shouldDecodeNewlines ? encodedAttrWithNewLines : encodedAttr;
  return value.replace(re, function (match) { return decodingMap[match]; })
}

function parseHTML (html, options) {
  var stack = [];
  var expectHTML = options.expectHTML;
  var isUnaryTag$$1 = options.isUnaryTag || no;
  var canBeLeftOpenTag$$1 = options.canBeLeftOpenTag || no;
  var index = 0;
  var last, lastTag;
  while (html) {
    last = html;
    // Make sure we're not in a plaintext content element like script/style
    if (!lastTag || !isPlainTextElement(lastTag)) {
      var textEnd = html.indexOf('<');
      if (textEnd === 0) {
        // Comment:
        if (comment.test(html)) {
          var commentEnd = html.indexOf('-->');

          if (commentEnd >= 0) {
            advance(commentEnd + 3);
            continue
          }
        }

        // http://en.wikipedia.org/wiki/Conditional_comment#Downlevel-revealed_conditional_comment
        if (conditionalComment.test(html)) {
          var conditionalEnd = html.indexOf(']>');

          if (conditionalEnd >= 0) {
            advance(conditionalEnd + 2);
            continue
          }
        }

        // Doctype:
        var doctypeMatch = html.match(doctype);
        if (doctypeMatch) {
          advance(doctypeMatch[0].length);
          continue
        }

        // End tag:
        var endTagMatch = html.match(endTag);
        if (endTagMatch) {
          var curIndex = index;
          advance(endTagMatch[0].length);
          parseEndTag(endTagMatch[1], curIndex, index);
          continue
        }

        // Start tag:
        var startTagMatch = parseStartTag();
        if (startTagMatch) {
          handleStartTag(startTagMatch);
          continue
        }
      }

      var text = (void 0), rest$1 = (void 0), next = (void 0);
      if (textEnd >= 0) {
        rest$1 = html.slice(textEnd);
        while (
          !endTag.test(rest$1) &&
          !startTagOpen.test(rest$1) &&
          !comment.test(rest$1) &&
          !conditionalComment.test(rest$1)
        ) {
          // < in plain text, be forgiving and treat it as text
          next = rest$1.indexOf('<', 1);
          if (next < 0) { break }
          textEnd += next;
          rest$1 = html.slice(textEnd);
        }
        text = html.substring(0, textEnd);
        advance(textEnd);
      }

      if (textEnd < 0) {
        text = html;
        html = '';
      }

      if (options.chars && text) {
        options.chars(text);
      }
    } else {
      var stackedTag = lastTag.toLowerCase();
      var reStackedTag = reCache[stackedTag] || (reCache[stackedTag] = new RegExp('([\\s\\S]*?)(</' + stackedTag + '[^>]*>)', 'i'));
      var endTagLength = 0;
      var rest = html.replace(reStackedTag, function (all, text, endTag) {
        endTagLength = endTag.length;
        if (!isPlainTextElement(stackedTag) && stackedTag !== 'noscript') {
          text = text
            .replace(/<!--([\s\S]*?)-->/g, '$1')
            .replace(/<!\[CDATA\[([\s\S]*?)]]>/g, '$1');
        }
        if (options.chars) {
          options.chars(text);
        }
        return ''
      });
      index += html.length - rest.length;
      html = rest;
      parseEndTag(stackedTag, index - endTagLength, index);
    }

    if (html === last) {
      options.chars && options.chars(html);
      if ("development" !== 'production' && !stack.length && options.warn) {
        options.warn(("Mal-formatted tag at end of template: \"" + html + "\""));
      }
      break
    }
  }

  // Clean up any remaining tags
  parseEndTag();

  function advance (n) {
    index += n;
    html = html.substring(n);
  }

  function parseStartTag () {
    var start = html.match(startTagOpen);
    if (start) {
      var match = {
        tagName: start[1],
        attrs: [],
        start: index
      };
      advance(start[0].length);
      var end, attr;
      while (!(end = html.match(startTagClose)) && (attr = html.match(attribute))) {
        advance(attr[0].length);
        match.attrs.push(attr);
      }
      if (end) {
        match.unarySlash = end[1];
        advance(end[0].length);
        match.end = index;
        return match
      }
    }
  }

  function handleStartTag (match) {
    var tagName = match.tagName;
    var unarySlash = match.unarySlash;

    if (expectHTML) {
      if (lastTag === 'p' && isNonPhrasingTag(tagName)) {
        parseEndTag(lastTag);
      }
      if (canBeLeftOpenTag$$1(tagName) && lastTag === tagName) {
        parseEndTag(tagName);
      }
    }

    var unary = isUnaryTag$$1(tagName) || tagName === 'html' && lastTag === 'head' || !!unarySlash;

    var l = match.attrs.length;
    var attrs = new Array(l);
    for (var i = 0; i < l; i++) {
      var args = match.attrs[i];
      // hackish work around FF bug https://bugzilla.mozilla.org/show_bug.cgi?id=369778
      if (IS_REGEX_CAPTURING_BROKEN && args[0].indexOf('""') === -1) {
        if (args[3] === '') { delete args[3]; }
        if (args[4] === '') { delete args[4]; }
        if (args[5] === '') { delete args[5]; }
      }
      var value = args[3] || args[4] || args[5] || '';
      attrs[i] = {
        name: args[1],
        value: decodeAttr(
          value,
          options.shouldDecodeNewlines
        )
      };
    }

    if (!unary) {
      stack.push({ tag: tagName, lowerCasedTag: tagName.toLowerCase(), attrs: attrs });
      lastTag = tagName;
    }

    if (options.start) {
      options.start(tagName, attrs, unary, match.start, match.end);
    }
  }

  function parseEndTag (tagName, start, end) {
    var pos, lowerCasedTagName;
    if (start == null) { start = index; }
    if (end == null) { end = index; }

    if (tagName) {
      lowerCasedTagName = tagName.toLowerCase();
    }

    // Find the closest opened tag of the same type
    if (tagName) {
      for (pos = stack.length - 1; pos >= 0; pos--) {
        if (stack[pos].lowerCasedTag === lowerCasedTagName) {
          break
        }
      }
    } else {
      // If no tag name is provided, clean shop
      pos = 0;
    }

    if (pos >= 0) {
      // Close all the open elements, up the stack
      for (var i = stack.length - 1; i >= pos; i--) {
        if ("development" !== 'production' &&
          (i > pos || !tagName) &&
          options.warn
        ) {
          options.warn(
            ("tag <" + (stack[i].tag) + "> has no matching end tag.")
          );
        }
        if (options.end) {
          options.end(stack[i].tag, start, end);
        }
      }

      // Remove the open elements from the stack
      stack.length = pos;
      lastTag = pos && stack[pos - 1].tag;
    } else if (lowerCasedTagName === 'br') {
      if (options.start) {
        options.start(tagName, [], true, start, end);
      }
    } else if (lowerCasedTagName === 'p') {
      if (options.start) {
        options.start(tagName, [], false, start, end);
      }
      if (options.end) {
        options.end(tagName, start, end);
      }
    }
  }
}

/*  */

var defaultTagRE = /\{\{((?:.|\n)+?)\}\}/g;
var regexEscapeRE = /[-.*+?^${}()|[\]\/\\]/g;

var buildRegex = cached(function (delimiters) {
  var open = delimiters[0].replace(regexEscapeRE, '\\$&');
  var close = delimiters[1].replace(regexEscapeRE, '\\$&');
  return new RegExp(open + '((?:.|\\n)+?)' + close, 'g')
});

function parseText (
  text,
  delimiters
) {
  var tagRE = delimiters ? buildRegex(delimiters) : defaultTagRE;
  if (!tagRE.test(text)) {
    return
  }
  var tokens = [];
  var lastIndex = tagRE.lastIndex = 0;
  var match, index;
  while ((match = tagRE.exec(text))) {
    index = match.index;
    // push text token
    if (index > lastIndex) {
      tokens.push(JSON.stringify(text.slice(lastIndex, index)));
    }
    // tag token
    var exp = parseFilters(match[1].trim());
    tokens.push(("_s(" + exp + ")"));
    lastIndex = index + match[0].length;
  }
  if (lastIndex < text.length) {
    tokens.push(JSON.stringify(text.slice(lastIndex)));
  }
  return tokens.join('+')
}

/*  */

var onRE = /^@|^v-on:/;
var dirRE = /^v-|^@|^:/;
var forAliasRE = /(.*?)\s+(?:in|of)\s+(.*)/;
var forIteratorRE = /\((\{[^}]*\}|[^,]*),([^,]*)(?:,([^,]*))?\)/;

var argRE = /:(.*)$/;
var bindRE = /^:|^v-bind:/;
var modifierRE = /\.[^.]+/g;

var decodeHTMLCached = cached(decode);

// configurable state
var warn$2;
var delimiters;
var transforms;
var preTransforms;
var postTransforms;
var platformIsPreTag;
var platformMustUseProp;
var platformGetTagNamespace;

/**
 * Convert HTML string to AST.
 */
function parse (
  template,
  options
) {
  warn$2 = options.warn || baseWarn;
  platformGetTagNamespace = options.getTagNamespace || no;
  platformMustUseProp = options.mustUseProp || no;
  platformIsPreTag = options.isPreTag || no;
  preTransforms = pluckModuleFunction(options.modules, 'preTransformNode');
  transforms = pluckModuleFunction(options.modules, 'transformNode');
  postTransforms = pluckModuleFunction(options.modules, 'postTransformNode');
  delimiters = options.delimiters;

  var stack = [];
  var preserveWhitespace = options.preserveWhitespace !== false;
  var root;
  var currentParent;
  var inVPre = false;
  var inPre = false;
  var warned = false;

  function warnOnce (msg) {
    if (!warned) {
      warned = true;
      warn$2(msg);
    }
  }

  function endPre (element) {
    // check pre state
    if (element.pre) {
      inVPre = false;
    }
    if (platformIsPreTag(element.tag)) {
      inPre = false;
    }
  }

  parseHTML(template, {
    warn: warn$2,
    expectHTML: options.expectHTML,
    isUnaryTag: options.isUnaryTag,
    canBeLeftOpenTag: options.canBeLeftOpenTag,
    shouldDecodeNewlines: options.shouldDecodeNewlines,
    start: function start (tag, attrs, unary) {
      // check namespace.
      // inherit parent ns if there is one
      var ns = (currentParent && currentParent.ns) || platformGetTagNamespace(tag);

      // handle IE svg bug
      /* istanbul ignore if */
      if (isIE && ns === 'svg') {
        attrs = guardIESVGBug(attrs);
      }

      var element = {
        type: 1,
        tag: tag,
        attrsList: attrs,
        attrsMap: makeAttrsMap(attrs),
        parent: currentParent,
        children: []
      };
      if (ns) {
        element.ns = ns;
      }

      if (isForbiddenTag(element) && !isServerRendering()) {
        element.forbidden = true;
        "development" !== 'production' && warn$2(
          'Templates should only be responsible for mapping the state to the ' +
          'UI. Avoid placing tags with side-effects in your templates, such as ' +
          "<" + tag + ">" + ', as they will not be parsed.'
        );
      }

      // apply pre-transforms
      for (var i = 0; i < preTransforms.length; i++) {
        preTransforms[i](element, options);
      }

      if (!inVPre) {
        processPre(element);
        if (element.pre) {
          inVPre = true;
        }
      }
      if (platformIsPreTag(element.tag)) {
        inPre = true;
      }
      if (inVPre) {
        processRawAttrs(element);
      } else {
        processFor(element);
        processIf(element);
        processOnce(element);
        processKey(element);

        // determine whether this is a plain element after
        // removing structural attributes
        element.plain = !element.key && !attrs.length;

        processRef(element);
        processSlot(element);
        processComponent(element);
        for (var i$1 = 0; i$1 < transforms.length; i$1++) {
          transforms[i$1](element, options);
        }
        processAttrs(element);
      }

      function checkRootConstraints (el) {
        {
          if (el.tag === 'slot' || el.tag === 'template') {
            warnOnce(
              "Cannot use <" + (el.tag) + "> as component root element because it may " +
              'contain multiple nodes.'
            );
          }
          if (el.attrsMap.hasOwnProperty('v-for')) {
            warnOnce(
              'Cannot use v-for on stateful component root element because ' +
              'it renders multiple elements.'
            );
          }
        }
      }

      // tree management
      if (!root) {
        root = element;
        checkRootConstraints(root);
      } else if (!stack.length) {
        // allow root elements with v-if, v-else-if and v-else
        if (root.if && (element.elseif || element.else)) {
          checkRootConstraints(element);
          addIfCondition(root, {
            exp: element.elseif,
            block: element
          });
        } else {
          warnOnce(
            "Component template should contain exactly one root element. " +
            "If you are using v-if on multiple elements, " +
            "use v-else-if to chain them instead."
          );
        }
      }
      if (currentParent && !element.forbidden) {
        if (element.elseif || element.else) {
          processIfConditions(element, currentParent);
        } else if (element.slotScope) { // scoped slot
          currentParent.plain = false;
          var name = element.slotTarget || '"default"';(currentParent.scopedSlots || (currentParent.scopedSlots = {}))[name] = element;
        } else {
          currentParent.children.push(element);
          element.parent = currentParent;
        }
      }
      if (!unary) {
        currentParent = element;
        stack.push(element);
      } else {
        endPre(element);
      }
      // apply post-transforms
      for (var i$2 = 0; i$2 < postTransforms.length; i$2++) {
        postTransforms[i$2](element, options);
      }
    },

    end: function end () {
      // remove trailing whitespace
      var element = stack[stack.length - 1];
      var lastNode = element.children[element.children.length - 1];
      if (lastNode && lastNode.type === 3 && lastNode.text === ' ' && !inPre) {
        element.children.pop();
      }
      // pop stack
      stack.length -= 1;
      currentParent = stack[stack.length - 1];
      endPre(element);
    },

    chars: function chars (text) {
      if (!currentParent) {
        {
          if (text === template) {
            warnOnce(
              'Component template requires a root element, rather than just text.'
            );
          } else if ((text = text.trim())) {
            warnOnce(
              ("text \"" + text + "\" outside root element will be ignored.")
            );
          }
        }
        return
      }
      // IE textarea placeholder bug
      /* istanbul ignore if */
      if (isIE &&
        currentParent.tag === 'textarea' &&
        currentParent.attrsMap.placeholder === text
      ) {
        return
      }
      var children = currentParent.children;
      text = inPre || text.trim()
        ? isTextTag(currentParent) ? text : decodeHTMLCached(text)
        // only preserve whitespace if its not right after a starting tag
        : preserveWhitespace && children.length ? ' ' : '';
      if (text) {
        var expression;
        if (!inVPre && text !== ' ' && (expression = parseText(text, delimiters))) {
          children.push({
            type: 2,
            expression: expression,
            text: text
          });
        } else if (text !== ' ' || !children.length || children[children.length - 1].text !== ' ') {
          children.push({
            type: 3,
            text: text
          });
        }
      }
    }
  });
  return root
}

function processPre (el) {
  if (getAndRemoveAttr(el, 'v-pre') != null) {
    el.pre = true;
  }
}

function processRawAttrs (el) {
  var l = el.attrsList.length;
  if (l) {
    var attrs = el.attrs = new Array(l);
    for (var i = 0; i < l; i++) {
      attrs[i] = {
        name: el.attrsList[i].name,
        value: JSON.stringify(el.attrsList[i].value)
      };
    }
  } else if (!el.pre) {
    // non root node in pre blocks with no attributes
    el.plain = true;
  }
}

function processKey (el) {
  var exp = getBindingAttr(el, 'key');
  if (exp) {
    if ("development" !== 'production' && el.tag === 'template') {
      warn$2("<template> cannot be keyed. Place the key on real elements instead.");
    }
    el.key = exp;
  }
}

function processRef (el) {
  var ref = getBindingAttr(el, 'ref');
  if (ref) {
    el.ref = ref;
    el.refInFor = checkInFor(el);
  }
}

function processFor (el) {
  var exp;
  if ((exp = getAndRemoveAttr(el, 'v-for'))) {
    var inMatch = exp.match(forAliasRE);
    if (!inMatch) {
      "development" !== 'production' && warn$2(
        ("Invalid v-for expression: " + exp)
      );
      return
    }
    el.for = inMatch[2].trim();
    var alias = inMatch[1].trim();
    var iteratorMatch = alias.match(forIteratorRE);
    if (iteratorMatch) {
      el.alias = iteratorMatch[1].trim();
      el.iterator1 = iteratorMatch[2].trim();
      if (iteratorMatch[3]) {
        el.iterator2 = iteratorMatch[3].trim();
      }
    } else {
      el.alias = alias;
    }
  }
}

function processIf (el) {
  var exp = getAndRemoveAttr(el, 'v-if');
  if (exp) {
    el.if = exp;
    addIfCondition(el, {
      exp: exp,
      block: el
    });
  } else {
    if (getAndRemoveAttr(el, 'v-else') != null) {
      el.else = true;
    }
    var elseif = getAndRemoveAttr(el, 'v-else-if');
    if (elseif) {
      el.elseif = elseif;
    }
  }
}

function processIfConditions (el, parent) {
  var prev = findPrevElement(parent.children);
  if (prev && prev.if) {
    addIfCondition(prev, {
      exp: el.elseif,
      block: el
    });
  } else {
    warn$2(
      "v-" + (el.elseif ? ('else-if="' + el.elseif + '"') : 'else') + " " +
      "used on element <" + (el.tag) + "> without corresponding v-if."
    );
  }
}

function findPrevElement (children) {
  var i = children.length;
  while (i--) {
    if (children[i].type === 1) {
      return children[i]
    } else {
      if ("development" !== 'production' && children[i].text !== ' ') {
        warn$2(
          "text \"" + (children[i].text.trim()) + "\" between v-if and v-else(-if) " +
          "will be ignored."
        );
      }
      children.pop();
    }
  }
}

function addIfCondition (el, condition) {
  if (!el.ifConditions) {
    el.ifConditions = [];
  }
  el.ifConditions.push(condition);
}

function processOnce (el) {
  var once$$1 = getAndRemoveAttr(el, 'v-once');
  if (once$$1 != null) {
    el.once = true;
  }
}

function processSlot (el) {
  if (el.tag === 'slot') {
    el.slotName = getBindingAttr(el, 'name');
    if ("development" !== 'production' && el.key) {
      warn$2(
        "`key` does not work on <slot> because slots are abstract outlets " +
        "and can possibly expand into multiple elements. " +
        "Use the key on a wrapping element instead."
      );
    }
  } else {
    var slotTarget = getBindingAttr(el, 'slot');
    if (slotTarget) {
      el.slotTarget = slotTarget === '""' ? '"default"' : slotTarget;
    }
    if (el.tag === 'template') {
      el.slotScope = getAndRemoveAttr(el, 'scope');
    }
  }
}

function processComponent (el) {
  var binding;
  if ((binding = getBindingAttr(el, 'is'))) {
    el.component = binding;
  }
  if (getAndRemoveAttr(el, 'inline-template') != null) {
    el.inlineTemplate = true;
  }
}

function processAttrs (el) {
  var list = el.attrsList;
  var i, l, name, rawName, value, modifiers, isProp;
  for (i = 0, l = list.length; i < l; i++) {
    name = rawName = list[i].name;
    value = list[i].value;
    if (dirRE.test(name)) {
      // mark element as dynamic
      el.hasBindings = true;
      // modifiers
      modifiers = parseModifiers(name);
      if (modifiers) {
        name = name.replace(modifierRE, '');
      }
      if (bindRE.test(name)) { // v-bind
        name = name.replace(bindRE, '');
        value = parseFilters(value);
        isProp = false;
        if (modifiers) {
          if (modifiers.prop) {
            isProp = true;
            name = camelize(name);
            if (name === 'innerHtml') { name = 'innerHTML'; }
          }
          if (modifiers.camel) {
            name = camelize(name);
          }
          if (modifiers.sync) {
            addHandler(
              el,
              ("update:" + (camelize(name))),
              genAssignmentCode(value, "$event")
            );
          }
        }
        if (isProp || platformMustUseProp(el.tag, el.attrsMap.type, name)) {
          addProp(el, name, value);
        } else {
          addAttr(el, name, value);
        }
      } else if (onRE.test(name)) { // v-on
        name = name.replace(onRE, '');
        addHandler(el, name, value, modifiers, false, warn$2);
      } else { // normal directives
        name = name.replace(dirRE, '');
        // parse arg
        var argMatch = name.match(argRE);
        var arg = argMatch && argMatch[1];
        if (arg) {
          name = name.slice(0, -(arg.length + 1));
        }
        addDirective(el, name, rawName, value, arg, modifiers);
        if ("development" !== 'production' && name === 'model') {
          checkForAliasModel(el, value);
        }
      }
    } else {
      // literal attribute
      {
        var expression = parseText(value, delimiters);
        if (expression) {
          warn$2(
            name + "=\"" + value + "\": " +
            'Interpolation inside attributes has been removed. ' +
            'Use v-bind or the colon shorthand instead. For example, ' +
            'instead of <div id="{{ val }}">, use <div :id="val">.'
          );
        }
      }
      addAttr(el, name, JSON.stringify(value));
    }
  }
}

function checkInFor (el) {
  var parent = el;
  while (parent) {
    if (parent.for !== undefined) {
      return true
    }
    parent = parent.parent;
  }
  return false
}

function parseModifiers (name) {
  var match = name.match(modifierRE);
  if (match) {
    var ret = {};
    match.forEach(function (m) { ret[m.slice(1)] = true; });
    return ret
  }
}

function makeAttrsMap (attrs) {
  var map = {};
  for (var i = 0, l = attrs.length; i < l; i++) {
    if (
      "development" !== 'production' &&
      map[attrs[i].name] && !isIE && !isEdge
    ) {
      warn$2('duplicate attribute: ' + attrs[i].name);
    }
    map[attrs[i].name] = attrs[i].value;
  }
  return map
}

// for script (e.g. type="x/template") or style, do not decode content
function isTextTag (el) {
  return el.tag === 'script' || el.tag === 'style'
}

function isForbiddenTag (el) {
  return (
    el.tag === 'style' ||
    (el.tag === 'script' && (
      !el.attrsMap.type ||
      el.attrsMap.type === 'text/javascript'
    ))
  )
}

var ieNSBug = /^xmlns:NS\d+/;
var ieNSPrefix = /^NS\d+:/;

/* istanbul ignore next */
function guardIESVGBug (attrs) {
  var res = [];
  for (var i = 0; i < attrs.length; i++) {
    var attr = attrs[i];
    if (!ieNSBug.test(attr.name)) {
      attr.name = attr.name.replace(ieNSPrefix, '');
      res.push(attr);
    }
  }
  return res
}

function checkForAliasModel (el, value) {
  var _el = el;
  while (_el) {
    if (_el.for && _el.alias === value) {
      warn$2(
        "<" + (el.tag) + " v-model=\"" + value + "\">: " +
        "You are binding v-model directly to a v-for iteration alias. " +
        "This will not be able to modify the v-for source array because " +
        "writing to the alias is like modifying a function local variable. " +
        "Consider using an array of objects and use v-model on an object property instead."
      );
    }
    _el = _el.parent;
  }
}

/*  */

var isStaticKey;
var isPlatformReservedTag;

var genStaticKeysCached = cached(genStaticKeys$1);

/**
 * Goal of the optimizer: walk the generated template AST tree
 * and detect sub-trees that are purely static, i.e. parts of
 * the DOM that never needs to change.
 *
 * Once we detect these sub-trees, we can:
 *
 * 1. Hoist them into constants, so that we no longer need to
 *    create fresh nodes for them on each re-render;
 * 2. Completely skip them in the patching process.
 */
function optimize (root, options) {
  if (!root) { return }
  isStaticKey = genStaticKeysCached(options.staticKeys || '');
  isPlatformReservedTag = options.isReservedTag || no;
  // first pass: mark all non-static nodes.
  markStatic$1(root);
  // second pass: mark static roots.
  markStaticRoots(root, false);
}

function genStaticKeys$1 (keys) {
  return makeMap(
    'type,tag,attrsList,attrsMap,plain,parent,children,attrs' +
    (keys ? ',' + keys : '')
  )
}

function markStatic$1 (node) {
  node.static = isStatic(node);
  if (node.type === 1) {
    // do not make component slot content static. this avoids
    // 1. components not able to mutate slot nodes
    // 2. static slot content fails for hot-reloading
    if (
      !isPlatformReservedTag(node.tag) &&
      node.tag !== 'slot' &&
      node.attrsMap['inline-template'] == null
    ) {
      return
    }
    for (var i = 0, l = node.children.length; i < l; i++) {
      var child = node.children[i];
      markStatic$1(child);
      if (!child.static) {
        node.static = false;
      }
    }
  }
}

function markStaticRoots (node, isInFor) {
  if (node.type === 1) {
    if (node.static || node.once) {
      node.staticInFor = isInFor;
    }
    // For a node to qualify as a static root, it should have children that
    // are not just static text. Otherwise the cost of hoisting out will
    // outweigh the benefits and it's better off to just always render it fresh.
    if (node.static && node.children.length && !(
      node.children.length === 1 &&
      node.children[0].type === 3
    )) {
      node.staticRoot = true;
      return
    } else {
      node.staticRoot = false;
    }
    if (node.children) {
      for (var i = 0, l = node.children.length; i < l; i++) {
        markStaticRoots(node.children[i], isInFor || !!node.for);
      }
    }
    if (node.ifConditions) {
      walkThroughConditionsBlocks(node.ifConditions, isInFor);
    }
  }
}

function walkThroughConditionsBlocks (conditionBlocks, isInFor) {
  for (var i = 1, len = conditionBlocks.length; i < len; i++) {
    markStaticRoots(conditionBlocks[i].block, isInFor);
  }
}

function isStatic (node) {
  if (node.type === 2) { // expression
    return false
  }
  if (node.type === 3) { // text
    return true
  }
  return !!(node.pre || (
    !node.hasBindings && // no dynamic bindings
    !node.if && !node.for && // not v-if or v-for or v-else
    !isBuiltInTag(node.tag) && // not a built-in
    isPlatformReservedTag(node.tag) && // not a component
    !isDirectChildOfTemplateFor(node) &&
    Object.keys(node).every(isStaticKey)
  ))
}

function isDirectChildOfTemplateFor (node) {
  while (node.parent) {
    node = node.parent;
    if (node.tag !== 'template') {
      return false
    }
    if (node.for) {
      return true
    }
  }
  return false
}

/*  */

var fnExpRE = /^\s*([\w$_]+|\([^)]*?\))\s*=>|^function\s*\(/;
var simplePathRE = /^\s*[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['.*?']|\[".*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*\s*$/;

// keyCode aliases
var keyCodes = {
  esc: 27,
  tab: 9,
  enter: 13,
  space: 32,
  up: 38,
  left: 37,
  right: 39,
  down: 40,
  'delete': [8, 46]
};

// #4868: modifiers that prevent the execution of the listener
// need to explicitly return null so that we can determine whether to remove
// the listener for .once
var genGuard = function (condition) { return ("if(" + condition + ")return null;"); };

var modifierCode = {
  stop: '$event.stopPropagation();',
  prevent: '$event.preventDefault();',
  self: genGuard("$event.target !== $event.currentTarget"),
  ctrl: genGuard("!$event.ctrlKey"),
  shift: genGuard("!$event.shiftKey"),
  alt: genGuard("!$event.altKey"),
  meta: genGuard("!$event.metaKey"),
  left: genGuard("'button' in $event && $event.button !== 0"),
  middle: genGuard("'button' in $event && $event.button !== 1"),
  right: genGuard("'button' in $event && $event.button !== 2")
};

function genHandlers (
  events,
  isNative,
  warn
) {
  var res = isNative ? 'nativeOn:{' : 'on:{';
  for (var name in events) {
    var handler = events[name];
    // #5330: warn click.right, since right clicks do not actually fire click events.
    if ("development" !== 'production' &&
      name === 'click' &&
      handler && handler.modifiers && handler.modifiers.right
    ) {
      warn(
        "Use \"contextmenu\" instead of \"click.right\" since right clicks " +
        "do not actually fire \"click\" events."
      );
    }
    res += "\"" + name + "\":" + (genHandler(name, handler)) + ",";
  }
  return res.slice(0, -1) + '}'
}

function genHandler (
  name,
  handler
) {
  if (!handler) {
    return 'function(){}'
  }

  if (Array.isArray(handler)) {
    return ("[" + (handler.map(function (handler) { return genHandler(name, handler); }).join(',')) + "]")
  }

  var isMethodPath = simplePathRE.test(handler.value);
  var isFunctionExpression = fnExpRE.test(handler.value);

  if (!handler.modifiers) {
    return isMethodPath || isFunctionExpression
      ? handler.value
      : ("function($event){" + (handler.value) + "}") // inline statement
  } else {
    var code = '';
    var genModifierCode = '';
    var keys = [];
    for (var key in handler.modifiers) {
      if (modifierCode[key]) {
        genModifierCode += modifierCode[key];
        // left/right
        if (keyCodes[key]) {
          keys.push(key);
        }
      } else {
        keys.push(key);
      }
    }
    if (keys.length) {
      code += genKeyFilter(keys);
    }
    // Make sure modifiers like prevent and stop get executed after key filtering
    if (genModifierCode) {
      code += genModifierCode;
    }
    var handlerCode = isMethodPath
      ? handler.value + '($event)'
      : isFunctionExpression
        ? ("(" + (handler.value) + ")($event)")
        : handler.value;
    return ("function($event){" + code + handlerCode + "}")
  }
}

function genKeyFilter (keys) {
  return ("if(!('button' in $event)&&" + (keys.map(genFilterCode).join('&&')) + ")return null;")
}

function genFilterCode (key) {
  var keyVal = parseInt(key, 10);
  if (keyVal) {
    return ("$event.keyCode!==" + keyVal)
  }
  var alias = keyCodes[key];
  return ("_k($event.keyCode," + (JSON.stringify(key)) + (alias ? ',' + JSON.stringify(alias) : '') + ")")
}

/*  */

function bind$1 (el, dir) {
  el.wrapData = function (code) {
    return ("_b(" + code + ",'" + (el.tag) + "'," + (dir.value) + (dir.modifiers && dir.modifiers.prop ? ',true' : '') + ")")
  };
}

/*  */

var baseDirectives = {
  bind: bind$1,
  cloak: noop
};

/*  */

// configurable state
var warn$3;
var transforms$1;
var dataGenFns;
var platformDirectives$1;
var isPlatformReservedTag$1;
var staticRenderFns;
var onceCount;
var currentOptions;

function generate (
  ast,
  options
) {
  // save previous staticRenderFns so generate calls can be nested
  var prevStaticRenderFns = staticRenderFns;
  var currentStaticRenderFns = staticRenderFns = [];
  var prevOnceCount = onceCount;
  onceCount = 0;
  currentOptions = options;
  warn$3 = options.warn || baseWarn;
  transforms$1 = pluckModuleFunction(options.modules, 'transformCode');
  dataGenFns = pluckModuleFunction(options.modules, 'genData');
  platformDirectives$1 = options.directives || {};
  isPlatformReservedTag$1 = options.isReservedTag || no;
  var code = ast ? genElement(ast) : '_c("div")';
  staticRenderFns = prevStaticRenderFns;
  onceCount = prevOnceCount;
  return {
    render: ("with(this){return " + code + "}"),
    staticRenderFns: currentStaticRenderFns
  }
}

function genElement (el) {
  if (el.staticRoot && !el.staticProcessed) {
    return genStatic(el)
  } else if (el.once && !el.onceProcessed) {
    return genOnce(el)
  } else if (el.for && !el.forProcessed) {
    return genFor(el)
  } else if (el.if && !el.ifProcessed) {
    return genIf(el)
  } else if (el.tag === 'template' && !el.slotTarget) {
    return genChildren(el) || 'void 0'
  } else if (el.tag === 'slot') {
    return genSlot(el)
  } else {
    // component or element
    var code;
    if (el.component) {
      code = genComponent(el.component, el);
    } else {
      var data = el.plain ? undefined : genData(el);

      var children = el.inlineTemplate ? null : genChildren(el, true);
      code = "_c('" + (el.tag) + "'" + (data ? ("," + data) : '') + (children ? ("," + children) : '') + ")";
    }
    // module transforms
    for (var i = 0; i < transforms$1.length; i++) {
      code = transforms$1[i](el, code);
    }
    return code
  }
}

// hoist static sub-trees out
function genStatic (el) {
  el.staticProcessed = true;
  staticRenderFns.push(("with(this){return " + (genElement(el)) + "}"));
  return ("_m(" + (staticRenderFns.length - 1) + (el.staticInFor ? ',true' : '') + ")")
}

// v-once
function genOnce (el) {
  el.onceProcessed = true;
  if (el.if && !el.ifProcessed) {
    return genIf(el)
  } else if (el.staticInFor) {
    var key = '';
    var parent = el.parent;
    while (parent) {
      if (parent.for) {
        key = parent.key;
        break
      }
      parent = parent.parent;
    }
    if (!key) {
      "development" !== 'production' && warn$3(
        "v-once can only be used inside v-for that is keyed. "
      );
      return genElement(el)
    }
    return ("_o(" + (genElement(el)) + "," + (onceCount++) + (key ? ("," + key) : "") + ")")
  } else {
    return genStatic(el)
  }
}

function genIf (el) {
  el.ifProcessed = true; // avoid recursion
  return genIfConditions(el.ifConditions.slice())
}

function genIfConditions (conditions) {
  if (!conditions.length) {
    return '_e()'
  }

  var condition = conditions.shift();
  if (condition.exp) {
    return ("(" + (condition.exp) + ")?" + (genTernaryExp(condition.block)) + ":" + (genIfConditions(conditions)))
  } else {
    return ("" + (genTernaryExp(condition.block)))
  }

  // v-if with v-once should generate code like (a)?_m(0):_m(1)
  function genTernaryExp (el) {
    return el.once ? genOnce(el) : genElement(el)
  }
}

function genFor (el) {
  var exp = el.for;
  var alias = el.alias;
  var iterator1 = el.iterator1 ? ("," + (el.iterator1)) : '';
  var iterator2 = el.iterator2 ? ("," + (el.iterator2)) : '';

  if (
    "development" !== 'production' &&
    maybeComponent(el) && el.tag !== 'slot' && el.tag !== 'template' && !el.key
  ) {
    warn$3(
      "<" + (el.tag) + " v-for=\"" + alias + " in " + exp + "\">: component lists rendered with " +
      "v-for should have explicit keys. " +
      "See https://vuejs.org/guide/list.html#key for more info.",
      true /* tip */
    );
  }

  el.forProcessed = true; // avoid recursion
  return "_l((" + exp + ")," +
    "function(" + alias + iterator1 + iterator2 + "){" +
      "return " + (genElement(el)) +
    '})'
}

function genData (el) {
  var data = '{';

  // directives first.
  // directives may mutate the el's other properties before they are generated.
  var dirs = genDirectives(el);
  if (dirs) { data += dirs + ','; }

  // key
  if (el.key) {
    data += "key:" + (el.key) + ",";
  }
  // ref
  if (el.ref) {
    data += "ref:" + (el.ref) + ",";
  }
  if (el.refInFor) {
    data += "refInFor:true,";
  }
  // pre
  if (el.pre) {
    data += "pre:true,";
  }
  // record original tag name for components using "is" attribute
  if (el.component) {
    data += "tag:\"" + (el.tag) + "\",";
  }
  // module data generation functions
  for (var i = 0; i < dataGenFns.length; i++) {
    data += dataGenFns[i](el);
  }
  // attributes
  if (el.attrs) {
    data += "attrs:{" + (genProps(el.attrs)) + "},";
  }
  // DOM props
  if (el.props) {
    data += "domProps:{" + (genProps(el.props)) + "},";
  }
  // event handlers
  if (el.events) {
    data += (genHandlers(el.events, false, warn$3)) + ",";
  }
  if (el.nativeEvents) {
    data += (genHandlers(el.nativeEvents, true, warn$3)) + ",";
  }
  // slot target
  if (el.slotTarget) {
    data += "slot:" + (el.slotTarget) + ",";
  }
  // scoped slots
  if (el.scopedSlots) {
    data += (genScopedSlots(el.scopedSlots)) + ",";
  }
  // component v-model
  if (el.model) {
    data += "model:{value:" + (el.model.value) + ",callback:" + (el.model.callback) + ",expression:" + (el.model.expression) + "},";
  }
  // inline-template
  if (el.inlineTemplate) {
    var inlineTemplate = genInlineTemplate(el);
    if (inlineTemplate) {
      data += inlineTemplate + ",";
    }
  }
  data = data.replace(/,$/, '') + '}';
  // v-bind data wrap
  if (el.wrapData) {
    data = el.wrapData(data);
  }
  return data
}

function genDirectives (el) {
  var dirs = el.directives;
  if (!dirs) { return }
  var res = 'directives:[';
  var hasRuntime = false;
  var i, l, dir, needRuntime;
  for (i = 0, l = dirs.length; i < l; i++) {
    dir = dirs[i];
    needRuntime = true;
    var gen = platformDirectives$1[dir.name] || baseDirectives[dir.name];
    if (gen) {
      // compile-time directive that manipulates AST.
      // returns true if it also needs a runtime counterpart.
      needRuntime = !!gen(el, dir, warn$3);
    }
    if (needRuntime) {
      hasRuntime = true;
      res += "{name:\"" + (dir.name) + "\",rawName:\"" + (dir.rawName) + "\"" + (dir.value ? (",value:(" + (dir.value) + "),expression:" + (JSON.stringify(dir.value))) : '') + (dir.arg ? (",arg:\"" + (dir.arg) + "\"") : '') + (dir.modifiers ? (",modifiers:" + (JSON.stringify(dir.modifiers))) : '') + "},";
    }
  }
  if (hasRuntime) {
    return res.slice(0, -1) + ']'
  }
}

function genInlineTemplate (el) {
  var ast = el.children[0];
  if ("development" !== 'production' && (
    el.children.length > 1 || ast.type !== 1
  )) {
    warn$3('Inline-template components must have exactly one child element.');
  }
  if (ast.type === 1) {
    var inlineRenderFns = generate(ast, currentOptions);
    return ("inlineTemplate:{render:function(){" + (inlineRenderFns.render) + "},staticRenderFns:[" + (inlineRenderFns.staticRenderFns.map(function (code) { return ("function(){" + code + "}"); }).join(',')) + "]}")
  }
}

function genScopedSlots (slots) {
  return ("scopedSlots:_u([" + (Object.keys(slots).map(function (key) { return genScopedSlot(key, slots[key]); }).join(',')) + "])")
}

function genScopedSlot (key, el) {
  if (el.for && !el.forProcessed) {
    return genForScopedSlot(key, el)
  }
  return "{key:" + key + ",fn:function(" + (String(el.attrsMap.scope)) + "){" +
    "return " + (el.tag === 'template'
      ? genChildren(el) || 'void 0'
      : genElement(el)) + "}}"
}

function genForScopedSlot (key, el) {
  var exp = el.for;
  var alias = el.alias;
  var iterator1 = el.iterator1 ? ("," + (el.iterator1)) : '';
  var iterator2 = el.iterator2 ? ("," + (el.iterator2)) : '';
  el.forProcessed = true; // avoid recursion
  return "_l((" + exp + ")," +
    "function(" + alias + iterator1 + iterator2 + "){" +
      "return " + (genScopedSlot(key, el)) +
    '})'
}

function genChildren (el, checkSkip) {
  var children = el.children;
  if (children.length) {
    var el$1 = children[0];
    // optimize single v-for
    if (children.length === 1 &&
      el$1.for &&
      el$1.tag !== 'template' &&
      el$1.tag !== 'slot'
    ) {
      return genElement(el$1)
    }
    var normalizationType = checkSkip ? getNormalizationType(children) : 0;
    return ("[" + (children.map(genNode).join(',')) + "]" + (normalizationType ? ("," + normalizationType) : ''))
  }
}

// determine the normalization needed for the children array.
// 0: no normalization needed
// 1: simple normalization needed (possible 1-level deep nested array)
// 2: full normalization needed
function getNormalizationType (children) {
  var res = 0;
  for (var i = 0; i < children.length; i++) {
    var el = children[i];
    if (el.type !== 1) {
      continue
    }
    if (needsNormalization(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return needsNormalization(c.block); }))) {
      res = 2;
      break
    }
    if (maybeComponent(el) ||
        (el.ifConditions && el.ifConditions.some(function (c) { return maybeComponent(c.block); }))) {
      res = 1;
    }
  }
  return res
}

function needsNormalization (el) {
  return el.for !== undefined || el.tag === 'template' || el.tag === 'slot'
}

function maybeComponent (el) {
  return !isPlatformReservedTag$1(el.tag)
}

function genNode (node) {
  if (node.type === 1) {
    return genElement(node)
  } else {
    return genText(node)
  }
}

function genText (text) {
  return ("_v(" + (text.type === 2
    ? text.expression // no need for () because already wrapped in _s()
    : transformSpecialNewlines(JSON.stringify(text.text))) + ")")
}

function genSlot (el) {
  var slotName = el.slotName || '"default"';
  var children = genChildren(el);
  var res = "_t(" + slotName + (children ? ("," + children) : '');
  var attrs = el.attrs && ("{" + (el.attrs.map(function (a) { return ((camelize(a.name)) + ":" + (a.value)); }).join(',')) + "}");
  var bind$$1 = el.attrsMap['v-bind'];
  if ((attrs || bind$$1) && !children) {
    res += ",null";
  }
  if (attrs) {
    res += "," + attrs;
  }
  if (bind$$1) {
    res += (attrs ? '' : ',null') + "," + bind$$1;
  }
  return res + ')'
}

// componentName is el.component, take it as argument to shun flow's pessimistic refinement
function genComponent (componentName, el) {
  var children = el.inlineTemplate ? null : genChildren(el, true);
  return ("_c(" + componentName + "," + (genData(el)) + (children ? ("," + children) : '') + ")")
}

function genProps (props) {
  var res = '';
  for (var i = 0; i < props.length; i++) {
    var prop = props[i];
    res += "\"" + (prop.name) + "\":" + (transformSpecialNewlines(prop.value)) + ",";
  }
  return res.slice(0, -1)
}

// #3895, #4268
function transformSpecialNewlines (text) {
  return text
    .replace(/\u2028/g, '\\u2028')
    .replace(/\u2029/g, '\\u2029')
}

/*  */

// these keywords should not appear inside expressions, but operators like
// typeof, instanceof and in are allowed
var prohibitedKeywordRE = new RegExp('\\b' + (
  'do,if,for,let,new,try,var,case,else,with,await,break,catch,class,const,' +
  'super,throw,while,yield,delete,export,import,return,switch,default,' +
  'extends,finally,continue,debugger,function,arguments'
).split(',').join('\\b|\\b') + '\\b');

// these unary operators should not be used as property/method names
var unaryOperatorsRE = new RegExp('\\b' + (
  'delete,typeof,void'
).split(',').join('\\s*\\([^\\)]*\\)|\\b') + '\\s*\\([^\\)]*\\)');

// check valid identifier for v-for
var identRE = /[A-Za-z_$][\w$]*/;

// strip strings in expressions
var stripStringRE = /'(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*"|`(?:[^`\\]|\\.)*\$\{|\}(?:[^`\\]|\\.)*`|`(?:[^`\\]|\\.)*`/g;

// detect problematic expressions in a template
function detectErrors (ast) {
  var errors = [];
  if (ast) {
    checkNode(ast, errors);
  }
  return errors
}

function checkNode (node, errors) {
  if (node.type === 1) {
    for (var name in node.attrsMap) {
      if (dirRE.test(name)) {
        var value = node.attrsMap[name];
        if (value) {
          if (name === 'v-for') {
            checkFor(node, ("v-for=\"" + value + "\""), errors);
          } else if (onRE.test(name)) {
            checkEvent(value, (name + "=\"" + value + "\""), errors);
          } else {
            checkExpression(value, (name + "=\"" + value + "\""), errors);
          }
        }
      }
    }
    if (node.children) {
      for (var i = 0; i < node.children.length; i++) {
        checkNode(node.children[i], errors);
      }
    }
  } else if (node.type === 2) {
    checkExpression(node.expression, node.text, errors);
  }
}

function checkEvent (exp, text, errors) {
  var stipped = exp.replace(stripStringRE, '');
  var keywordMatch = stipped.match(unaryOperatorsRE);
  if (keywordMatch && stipped.charAt(keywordMatch.index - 1) !== '$') {
    errors.push(
      "avoid using JavaScript unary operator as property name: " +
      "\"" + (keywordMatch[0]) + "\" in expression " + (text.trim())
    );
  }
  checkExpression(exp, text, errors);
}

function checkFor (node, text, errors) {
  checkExpression(node.for || '', text, errors);
  checkIdentifier(node.alias, 'v-for alias', text, errors);
  checkIdentifier(node.iterator1, 'v-for iterator', text, errors);
  checkIdentifier(node.iterator2, 'v-for iterator', text, errors);
}

function checkIdentifier (ident, type, text, errors) {
  if (typeof ident === 'string' && !identRE.test(ident)) {
    errors.push(("invalid " + type + " \"" + ident + "\" in expression: " + (text.trim())));
  }
}

function checkExpression (exp, text, errors) {
  try {
    new Function(("return " + exp));
  } catch (e) {
    var keywordMatch = exp.replace(stripStringRE, '').match(prohibitedKeywordRE);
    if (keywordMatch) {
      errors.push(
        "avoid using JavaScript keyword as property name: " +
        "\"" + (keywordMatch[0]) + "\" in expression " + (text.trim())
      );
    } else {
      errors.push(("invalid expression: " + (text.trim())));
    }
  }
}

/*  */

function baseCompile (
  template,
  options
) {
  var ast = parse(template.trim(), options);
  optimize(ast, options);
  var code = generate(ast, options);
  return {
    ast: ast,
    render: code.render,
    staticRenderFns: code.staticRenderFns
  }
}

function makeFunction (code, errors) {
  try {
    return new Function(code)
  } catch (err) {
    errors.push({ err: err, code: code });
    return noop
  }
}

function createCompiler (baseOptions) {
  var functionCompileCache = Object.create(null);

  function compile (
    template,
    options
  ) {
    var finalOptions = Object.create(baseOptions);
    var errors = [];
    var tips = [];
    finalOptions.warn = function (msg, tip$$1) {
      (tip$$1 ? tips : errors).push(msg);
    };

    if (options) {
      // merge custom modules
      if (options.modules) {
        finalOptions.modules = (baseOptions.modules || []).concat(options.modules);
      }
      // merge custom directives
      if (options.directives) {
        finalOptions.directives = extend(
          Object.create(baseOptions.directives),
          options.directives
        );
      }
      // copy other options
      for (var key in options) {
        if (key !== 'modules' && key !== 'directives') {
          finalOptions[key] = options[key];
        }
      }
    }

    var compiled = baseCompile(template, finalOptions);
    {
      errors.push.apply(errors, detectErrors(compiled.ast));
    }
    compiled.errors = errors;
    compiled.tips = tips;
    return compiled
  }

  function compileToFunctions (
    template,
    options,
    vm
  ) {
    options = options || {};

    /* istanbul ignore if */
    {
      // detect possible CSP restriction
      try {
        new Function('return 1');
      } catch (e) {
        if (e.toString().match(/unsafe-eval|CSP/)) {
          warn(
            'It seems you are using the standalone build of Vue.js in an ' +
            'environment with Content Security Policy that prohibits unsafe-eval. ' +
            'The template compiler cannot work in this environment. Consider ' +
            'relaxing the policy to allow unsafe-eval or pre-compiling your ' +
            'templates into render functions.'
          );
        }
      }
    }

    // check cache
    var key = options.delimiters
      ? String(options.delimiters) + template
      : template;
    if (functionCompileCache[key]) {
      return functionCompileCache[key]
    }

    // compile
    var compiled = compile(template, options);

    // check compilation errors/tips
    {
      if (compiled.errors && compiled.errors.length) {
        warn(
          "Error compiling template:\n\n" + template + "\n\n" +
          compiled.errors.map(function (e) { return ("- " + e); }).join('\n') + '\n',
          vm
        );
      }
      if (compiled.tips && compiled.tips.length) {
        compiled.tips.forEach(function (msg) { return tip(msg, vm); });
      }
    }

    // turn code into functions
    var res = {};
    var fnGenErrors = [];
    res.render = makeFunction(compiled.render, fnGenErrors);
    var l = compiled.staticRenderFns.length;
    res.staticRenderFns = new Array(l);
    for (var i = 0; i < l; i++) {
      res.staticRenderFns[i] = makeFunction(compiled.staticRenderFns[i], fnGenErrors);
    }

    // check function generation errors.
    // this should only happen if there is a bug in the compiler itself.
    // mostly for codegen development use
    /* istanbul ignore if */
    {
      if ((!compiled.errors || !compiled.errors.length) && fnGenErrors.length) {
        warn(
          "Failed to generate render function:\n\n" +
          fnGenErrors.map(function (ref) {
            var err = ref.err;
            var code = ref.code;

            return ((err.toString()) + " in\n\n" + code + "\n");
        }).join('\n'),
          vm
        );
      }
    }

    return (functionCompileCache[key] = res)
  }

  return {
    compile: compile,
    compileToFunctions: compileToFunctions
  }
}

/*  */

function transformNode (el, options) {
  var warn = options.warn || baseWarn;
  var staticClass = getAndRemoveAttr(el, 'class');
  if ("development" !== 'production' && staticClass) {
    var expression = parseText(staticClass, options.delimiters);
    if (expression) {
      warn(
        "class=\"" + staticClass + "\": " +
        'Interpolation inside attributes has been removed. ' +
        'Use v-bind or the colon shorthand instead. For example, ' +
        'instead of <div class="{{ val }}">, use <div :class="val">.'
      );
    }
  }
  if (staticClass) {
    el.staticClass = JSON.stringify(staticClass);
  }
  var classBinding = getBindingAttr(el, 'class', false /* getStatic */);
  if (classBinding) {
    el.classBinding = classBinding;
  }
}

function genData$1 (el) {
  var data = '';
  if (el.staticClass) {
    data += "staticClass:" + (el.staticClass) + ",";
  }
  if (el.classBinding) {
    data += "class:" + (el.classBinding) + ",";
  }
  return data
}

var klass$1 = {
  staticKeys: ['staticClass'],
  transformNode: transformNode,
  genData: genData$1
};

/*  */

function transformNode$1 (el, options) {
  var warn = options.warn || baseWarn;
  var staticStyle = getAndRemoveAttr(el, 'style');
  if (staticStyle) {
    /* istanbul ignore if */
    {
      var expression = parseText(staticStyle, options.delimiters);
      if (expression) {
        warn(
          "style=\"" + staticStyle + "\": " +
          'Interpolation inside attributes has been removed. ' +
          'Use v-bind or the colon shorthand instead. For example, ' +
          'instead of <div style="{{ val }}">, use <div :style="val">.'
        );
      }
    }
    el.staticStyle = JSON.stringify(parseStyleText(staticStyle));
  }

  var styleBinding = getBindingAttr(el, 'style', false /* getStatic */);
  if (styleBinding) {
    el.styleBinding = styleBinding;
  }
}

function genData$2 (el) {
  var data = '';
  if (el.staticStyle) {
    data += "staticStyle:" + (el.staticStyle) + ",";
  }
  if (el.styleBinding) {
    data += "style:(" + (el.styleBinding) + "),";
  }
  return data
}

var style$1 = {
  staticKeys: ['staticStyle'],
  transformNode: transformNode$1,
  genData: genData$2
};

var modules$1 = [
  klass$1,
  style$1
];

/*  */

function text (el, dir) {
  if (dir.value) {
    addProp(el, 'textContent', ("_s(" + (dir.value) + ")"));
  }
}

/*  */

function html (el, dir) {
  if (dir.value) {
    addProp(el, 'innerHTML', ("_s(" + (dir.value) + ")"));
  }
}

var directives$1 = {
  model: model,
  text: text,
  html: html
};

/*  */

var baseOptions = {
  expectHTML: true,
  modules: modules$1,
  directives: directives$1,
  isPreTag: isPreTag,
  isUnaryTag: isUnaryTag,
  mustUseProp: mustUseProp,
  canBeLeftOpenTag: canBeLeftOpenTag,
  isReservedTag: isReservedTag,
  getTagNamespace: getTagNamespace,
  staticKeys: genStaticKeys(modules$1)
};

var ref$1 = createCompiler(baseOptions);
var compileToFunctions = ref$1.compileToFunctions;

/*  */

var idToTemplate = cached(function (id) {
  var el = query(id);
  return el && el.innerHTML
});

var mount = Vue$3.prototype.$mount;
Vue$3.prototype.$mount = function (
  el,
  hydrating
) {
  el = el && query(el);

  /* istanbul ignore if */
  if (el === document.body || el === document.documentElement) {
    "development" !== 'production' && warn(
      "Do not mount Vue to <html> or <body> - mount to normal elements instead."
    );
    return this
  }

  var options = this.$options;
  // resolve template/el and convert to render function
  if (!options.render) {
    var template = options.template;
    if (template) {
      if (typeof template === 'string') {
        if (template.charAt(0) === '#') {
          template = idToTemplate(template);
          /* istanbul ignore if */
          if ("development" !== 'production' && !template) {
            warn(
              ("Template element not found or is empty: " + (options.template)),
              this
            );
          }
        }
      } else if (template.nodeType) {
        template = template.innerHTML;
      } else {
        {
          warn('invalid template option:' + template, this);
        }
        return this
      }
    } else if (el) {
      template = getOuterHTML(el);
    }
    if (template) {
      /* istanbul ignore if */
      if ("development" !== 'production' && config.performance && mark) {
        mark('compile');
      }

      var ref = compileToFunctions(template, {
        shouldDecodeNewlines: shouldDecodeNewlines,
        delimiters: options.delimiters
      }, this);
      var render = ref.render;
      var staticRenderFns = ref.staticRenderFns;
      options.render = render;
      options.staticRenderFns = staticRenderFns;

      /* istanbul ignore if */
      if ("development" !== 'production' && config.performance && mark) {
        mark('compile end');
        measure(((this._name) + " compile"), 'compile', 'compile end');
      }
    }
  }
  return mount.call(this, el, hydrating)
};

/**
 * Get outerHTML of elements, taking care
 * of SVG elements in IE as well.
 */
function getOuterHTML (el) {
  if (el.outerHTML) {
    return el.outerHTML
  } else {
    var container = document.createElement('div');
    container.appendChild(el.cloneNode(true));
    return container.innerHTML
  }
}

Vue$3.compile = compileToFunctions;

return Vue$3;

})));

}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{}],4:[function(require,module,exports){
'use strict';

// Vue Dev
window.Vue = require('vue/dist/vue.js');
//Vue Prod
//window.Vue = require('vue/dist/vue.min');

window.VeeValidate = require('vee-validate');
VeeValidate.Validator.addLocale({
    'es': require('vee-validate/dist/locale/es')
});
Vue.use(VeeValidate, { locale: 'es', errorBagName: 'validation_errors' });

if ($('#app').length) {
    new Vue({
        el: '#app',
        components: require('./vue-components')
    });
}

},{"./vue-components":5,"vee-validate":2,"vee-validate/dist/locale/es":1,"vue/dist/vue.js":3}],5:[function(require,module,exports){
'use strict';

require('./vue-components/global-errors');
require('./vue-components/errors');
require('./vue-components/select2');

/**
 * Contabilidad Components...
 */
require('./vue-components/Contabilidad/emails');

require('./vue-components/Contabilidad/poliza_tipo/poliza-tipo-create');
require('./vue-components/Contabilidad/tipo_cuenta_contable/tipo-cuenta-contable-create');
require('./vue-components/Contabilidad/tipo_cuenta_contable/tipo-cuenta-contable-update');
require('./vue-components/Contabilidad/cuenta_contable/index');
require('./vue-components/Contabilidad/poliza_generada/edit');
require('./vue-components/Contabilidad/poliza_generada/index');
require('./vue-components/Contabilidad/cuenta_concepto/index');
require('./vue-components/Contabilidad/cuenta_material/index');
require('./vue-components/Contabilidad/cuenta_empresa/cuenta-empresa-edit');
require('./vue-components/Contabilidad/cuenta_almacen/index');
require('./vue-components/Contabilidad/datos_contables/edit');
require('./vue-components/kardex_material/kardex-material-index');
require('./vue-components/Contabilidad/modulos/revaluacion/create');
require('./vue-components/Contabilidad/cuenta_fondo/index');
require('./vue-components/Contabilidad/cuenta_bancos/cuenta-bancaria-edit');
require('./vue-components/Contabilidad/cuenta_costo/index');
require('./vue-components/Contabilidad/cierre/index');

/**
 * Compras Components
 */
require('./vue-components/Compras/requisicion/create');
require('./vue-components/Compras/requisicion/edit');
require('./vue-components/Compras/material/index');

/**
 * Finanzas Components
 */
require('./vue-components/Finanzas/comprobante_fondo_fijo/index');
require('./vue-components/Finanzas/comprobante_fondo_fijo/create');
require('./vue-components/Finanzas/comprobante_fondo_fijo/edit');
/**
 * Formatos Components
 */
require('./vue-components/Formatos/subcontratos-estimacion');

/**
 * Tesoreria Components
 */
require('./vue-components/Tesoreria/traspaso_cuentas/index');
require('./vue-components/Tesoreria/movimientos_bancarios/index');

/**
 * Control de costos Components
 */
require('./vue-components/ControlCostos/solicitar_reclasificacion/index');
require('./vue-components/ControlCostos/solicitar_reclasificacion/items');
require('./vue-components/ControlCostos/reclasificacion_costos/index');

/**
 * Control de Presupuesto Components
 */
require('./vue-components/ControlPresupuesto/index');
require('./vue-components/ControlPresupuesto/cambio_presupuesto/create');
require('./vue-components/ControlPresupuesto/cambio_presupuesto/index');

//require('./vue-components/ControlPresupuesto/cambio_presupuesto/variacion_insumos');
//require('./vue-components/ControlPresupuesto/cambio_presupuesto/show/variacion_insumos');

/**
 * Variacion de Volúmen Components
 */
require('./vue-components/ControlPresupuesto/variacion_volumen/create');
require('./vue-components/ControlPresupuesto/variacion_volumen/show');

/**
 * Escalatoria Components
 */
require('./vue-components/ControlPresupuesto/escalatoria/show');
require('./vue-components/ControlPresupuesto/escalatoria/create');

/**
 * Cambio Insumos Components
 */
require('./vue-components/ControlPresupuesto/cambio_insumos/show');
require('./vue-components/ControlPresupuesto/cambio_insumos/create');
require('./vue-components/ControlPresupuesto/cambio_insumos/costo_indirecto/create');

/**
 * Configuración Components
 */
require('./vue-components/Configuracion/seguridad/index');

},{"./vue-components/Compras/material/index":6,"./vue-components/Compras/requisicion/create":8,"./vue-components/Compras/requisicion/edit":9,"./vue-components/Configuracion/seguridad/index":10,"./vue-components/Contabilidad/cierre/index":11,"./vue-components/Contabilidad/cuenta_almacen/index":12,"./vue-components/Contabilidad/cuenta_bancos/cuenta-bancaria-edit":13,"./vue-components/Contabilidad/cuenta_concepto/index":14,"./vue-components/Contabilidad/cuenta_contable/index":15,"./vue-components/Contabilidad/cuenta_costo/index":16,"./vue-components/Contabilidad/cuenta_empresa/cuenta-empresa-edit":17,"./vue-components/Contabilidad/cuenta_fondo/index":18,"./vue-components/Contabilidad/cuenta_material/index":19,"./vue-components/Contabilidad/datos_contables/edit":20,"./vue-components/Contabilidad/emails":21,"./vue-components/Contabilidad/modulos/revaluacion/create":22,"./vue-components/Contabilidad/poliza_generada/edit":23,"./vue-components/Contabilidad/poliza_generada/index":24,"./vue-components/Contabilidad/poliza_tipo/poliza-tipo-create":25,"./vue-components/Contabilidad/tipo_cuenta_contable/tipo-cuenta-contable-create":26,"./vue-components/Contabilidad/tipo_cuenta_contable/tipo-cuenta-contable-update":27,"./vue-components/ControlCostos/reclasificacion_costos/index":28,"./vue-components/ControlCostos/solicitar_reclasificacion/index":29,"./vue-components/ControlCostos/solicitar_reclasificacion/items":30,"./vue-components/ControlPresupuesto/cambio_insumos/costo_indirecto/create":31,"./vue-components/ControlPresupuesto/cambio_insumos/create":32,"./vue-components/ControlPresupuesto/cambio_insumos/show":33,"./vue-components/ControlPresupuesto/cambio_presupuesto/create":34,"./vue-components/ControlPresupuesto/cambio_presupuesto/index":35,"./vue-components/ControlPresupuesto/escalatoria/create":36,"./vue-components/ControlPresupuesto/escalatoria/show":37,"./vue-components/ControlPresupuesto/index":38,"./vue-components/ControlPresupuesto/variacion_volumen/create":39,"./vue-components/ControlPresupuesto/variacion_volumen/show":40,"./vue-components/Finanzas/comprobante_fondo_fijo/create":41,"./vue-components/Finanzas/comprobante_fondo_fijo/edit":42,"./vue-components/Finanzas/comprobante_fondo_fijo/index":43,"./vue-components/Formatos/subcontratos-estimacion":44,"./vue-components/Tesoreria/movimientos_bancarios/index":45,"./vue-components/Tesoreria/traspaso_cuentas/index":46,"./vue-components/errors":47,"./vue-components/global-errors":48,"./vue-components/kardex_material/kardex-material-index":49,"./vue-components/select2":50}],6:[function(require,module,exports){
'use strict';

Vue.component('material-index', {
    props: ['material_url'],
    data: function data() {
        return {
            'data': {
                'materiales': [],
                'items': [],
                'cuenta_material_edit': {}
            },
            'form': {
                'cuenta_material': {
                    'id': '',
                    'cuenta': '',
                    'id_tipo_cuenta_material': 0,
                    'id_material': ''
                }
            },
            'material': {
                'unidad': '',
                'nivel': '',
                'descripcion': '',
                'tipo_material': '',
                'unidad_compra': ''
            },
            valor: '0',
            guardando: false

        };
    },
    template: require('./template/modal_materiales_create.html'),

    mounted: function mounted() {
        var self = this;
        this.$parent.$on('abrirModalMateriales', function (tipoMaterial) {
            self.abrir_modal(tipoMaterial);
            self.material.tipo_material = tipoMaterial;
        });
    },

    methods: {
        cambio: function cambio() {
            var self = this;
            var id = self.valor;
            if (id != 0) {
                self.guardando = true;
                var urla = App.host + '/compras/material/';
                $.ajax({
                    type: 'GET',
                    url: urla + id + "/tipo",

                    success: function success(response) {
                        self.data.items = response;
                    },
                    complete: function complete() {
                        self.guardando = false;
                    },
                    error: function error(_error) {
                        alert(_error.responseText);
                        self.guardando = false;
                    }
                });
            }
        },
        get_materiales: function get_materiales(concepto) {
            var self = this;

            $.ajax({
                type: 'GET',
                url: self.material_url,
                data: {
                    attribute: 'nivel',
                    operator: 'like',
                    value: concepto.nivel_hijos,
                    with: 'cuentaConcepto'
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.data.materiales = data;
                }
            });
        },
        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_material') {
                    _this.confirmSave();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirmSave: function confirmSave() {
            var self = this;
            var message = 'Familia';
            if (self.material.unidad) {
                message = 'Insumo';
            }

            swal({
                title: 'Guardar ' + message,
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function (result) {
                if (result.value) {
                    self.save();
                }
            });
        },
        save: function save() {
            var self = this;

            var message = 'Familia Guardada';
            if (self.material.unidad) {
                message = 'Insumo Guardado';
            }
            $.each(self.material, function (key, value) {
                if ((value === '' || value === null) && key != 'nivel') {
                    delete self.material[key];
                }
            });

            if (typeof self.material.nivel == 'undefined') {
                self.material.nivel = '';
            }

            $.ajax({
                url: App.host + '/material',
                type: 'POST',
                data: self.material,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(response) {
                    swal({
                        type: 'success',
                        title: '¡Correcto!',
                        html: message + ' Exitosamente.'
                    }).then(function () {
                        $('#add_material_modal').modal('hide');
                    });
                    self.guardando = false;

                    self.material.unidad = '';
                    self.material.nivel = '';
                    self.material.descripcion = '';
                    self.material.tipo_material = '';
                    self.material.unidad_compra = '';
                },
                complete: function complete() {
                    self.guardando = false;
                    $('#add_material_modal').modal('hide');
                }
            });
        },
        cerrar_modal_material: function cerrar_modal_material() {
            var self = this;
            self.material.unidad = '';
            self.material.nivel = '';
            self.material.descripcion = '';
            self.material.tipo_material = '';
            self.material.unidad_compra = '';
            $('#add_material_modal').modal("hide");
        },
        abrir_modal: function abrir_modal(tipo) {
            var self = this;
            self.material.unidad = '';
            self.material.nivel = '';
            self.material.descripcion = '';
            self.material.tipo_material = '';
            self.material.unidad_compra = '';

            $('#sel_material_familias').select2({
                width: '100%',
                ajax: {
                    url: App.host + '/material/getFamiliasByTipoPadres',
                    dataType: 'json',
                    delay: 500,
                    data: function data(params) {
                        return {
                            descripcion: params.term,
                            tipo: tipo
                        };
                    },
                    processResults: function processResults(data) {
                        return {
                            results: $.map(data.data.materiales, function (item) {
                                return {
                                    text: item.descripcion,
                                    descripcion: item.descripcion,
                                    id: item.nivel

                                };
                            })
                        };
                    },
                    error: function error(_error2) {},
                    cache: true
                },
                escapeMarkup: function escapeMarkup(markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1
            }).on('select2:select', function (e) {
                var data = e.params.data;
                self.material.nivel = data.id;
            });

            $('#sel_unidades').select2({
                width: '100%',
                ajax: {
                    url: App.host + '/unidad/getUnidadesByDescripcion',
                    dataType: 'json',
                    delay: 500,
                    data: function data(params) {
                        return {
                            descripcion: params.term

                        };
                    },
                    processResults: function processResults(data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.descripcion,
                                    descripcion: item.descripcion,
                                    id: item.unidad
                                };
                            })
                        };
                    },
                    error: function error(_error3) {},
                    cache: true
                },
                escapeMarkup: function escapeMarkup(markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1
            }).on('select2:select', function (e) {
                var data = e.params.data;
                self.material.unidad = data.id;
                self.material.unidad_compra = data.id;
            });
            $('#add_material_modal').modal("show");
        }
    }
});

},{"./template/modal_materiales_create.html":7}],7:[function(require,module,exports){
module.exports = '<div id="add_material_modal" class="modal fade" role="dialog" aria-labelledby="addMaterialModal">\n    <div class="modal-dialog modal-lg">\n        <div class="modal-content">\n            <div class="modal-header">\n                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span\n                        aria-hidden="true">&times;</span></button>\n                <h4 class="modal-title">Nuevo Insumo</h4>\n            </div>\n\n            <form id="form_save_material" @submit.prevent="validateForm(\'form_save_material\', \'save_material\')"\n                  data-vv-scope="form_save_material">\n                <div class="box-body">\n                    <div class="row">\n                        <div class="col-md-12">\n                            <div class="callout callout-info">\n                                <p>Para crear una familia solo ingrese la descripción</p>\n                            </div>\n                        </div>\n                    </div>\n\n                    <div class="col-md-4">\n                        <div class="form-group" :class="{\'has-error\': validation_errors.has(\'form_save_material.Familia\') }">\n                            <label for="Familia"><b>Familia</b></label>\n                            <select class="form-control" name="Familia" data-placeholder="BUSCAR MATERIAL"\n                                    id="sel_material_familias" v-model="material.nivel"></select>\n                            <label class="help" v-show="validation_errors.has(\'form_save_material.Familia\')">{{ validation_errors.first(\'form_save_material.Familia\') }}</label>\n\n                        </div>\n                    </div>\n                    <div class="col-md-4">\n                        <div class="form-group" :class="{\'has-error\': validation_errors.has(\'form_save_material.Descripcion\') }">\n                            <label for="Descripcion"><b>Descripción</b></label>\n                            <input type="text" name="Descripcion" class="form-control" v-model="material.descripcion" v-validate="material.nivel||material.unidad?\'required\':\'\'"/>\n                            <label class="help" v-show="validation_errors.has(\'form_save_material.Descripcion\')">{{ validation_errors.first(\'form_save_material.Descripcion\') }}</label>\n\n                        </div>\n                    </div>\n                    <div class="col-md-4">\n                        <div class="form-group" :class="{\'has-error\': validation_errors.has(\'form_save_material.Unidad\') }">\n                            <label for="Unidad"><b>Unidad</b></label>\n                            <select class="form-control" name="Unidad" data-placeholder="BUSCAR UNIDAD"\n                                    id="sel_unidades" v-validate="material.nivel_padre?\'required\':\'\'" v-model="material.unidad"></select>\n                            <label class="help" v-show="validation_errors.has(\'form_save_material.Unidad\')">{{ validation_errors.first(\'form_save_material.Unidad\') }}</label>\n\n                        </div>\n                    </div>\n                </div>\n\n                <div class="modal-footer">\n                    <button type="button" class="btn btn-default"  v-on:click="cerrar_modal_material()">\n                        Cancelar\n                    </button>\n                    <button type="submit" class="btn btn-info pull-right" >\n                        <span v-if="guardando">\n                            <i class="fa fa-spin fa-spinner"></i> Guardando\n                        </span>\n                        <span v-else>\n                            <i class="fa fa-save"></i> Guardar\n                        </span>\n                    </button>\n                </div>\n\n            </form>\n        </div>\n    </div>\n</div>';
},{}],8:[function(require,module,exports){
'use strict';

Vue.component('requisicion-create', {

    props: ['departamentos_responsables', 'tipos_requisiciones', 'url_requisicion'],

    data: function data() {
        return {
            form: {
                id_departamento: '',
                id_tipo_requisicion: '',
                observaciones: ''
            },
            guardando: false
        };
    },
    methods: {

        confirm_save: function confirm_save() {
            var self = this;
            swal({
                title: "Guardar Requisición",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function () {
                self.save();
            }).catch(swal.noop);
        },

        save: function save() {
            var self = this;
            var url = this.url_requisicion;
            var data = this.form;

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: "Se ha creado la Requisición <br>" + "<b>" + data.data.requisicion.transaccion_ext.folio_adicional + "</b>",
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = self.url_requisicion + '/' + data.data.requisicion.id_transaccion + '/edit';
                    }).catch(swal.noop);
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function (result) {
                if (result) {
                    if (funcion == 'save') {
                        _this.confirm_save();
                    }
                } else {
                    swal({
                        type: 'warning',
                        title: 'Advertencia',
                        text: 'Por favor corrija los errores del formulario'
                    });
                }
            });
        }
    }
});

},{}],9:[function(require,module,exports){
'use strict';

Vue.component('requisicion-edit', {

    props: ['url_requisicion', 'requisicion', 'materiales', 'departamentos_responsables', 'tipos_requisiciones'],

    data: function data() {
        return {
            form: {
                requisicion: {
                    id_departamento: this.requisicion.transaccion_ext.id_departamento,
                    id_tipo_requisicion: this.requisicion.transaccion_ext.id_tipo_requisicion,
                    observaciones: this.requisicion.observaciones
                },
                item: {
                    'id_transaccion': this.requisicion.id_transaccion,
                    'id_material': '',
                    'observaciones': '',
                    'cantidad': '',
                    'unidad': this.unidad,
                    'id_item': ''
                }
            },
            data: {
                items: this.requisicion.items,
                guardando: false
            }
        };
    },
    computed: {
        materiales_list: function materiales_list() {
            var result = {};
            this.materiales.forEach(function (material) {
                result[material.id_material] = material.descripcion;
            });

            return result;
        },
        materiales_unidad_list: function materiales_unidad_list() {
            var result = {};
            this.materiales.forEach(function (material) {
                result[material.id_material] = material.unidad;
            });

            return result;
        },
        unidad: function unidad() {
            this.form.item.unidad = this.materiales_unidad_list[this.form.item.id_material];
            return this.materiales_unidad_list[this.form.item.id_material];
        }
    },

    methods: {
        show_add_item: function show_add_item() {

            $('#add_item_modal').removeAttr('tabindex');
            this.validation_errors.clear('form_add_item');
            $('#add_item_modal').modal('show');
            this.validation_errors.clear('form_add_item');
        },

        confirm_remove_item: function confirm_remove_item(item) {
            var self = this;
            swal({
                title: "Eliminar Partida",
                text: "¿Estás seguro de que deseas eliminar la partida?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function () {
                self.remove_item(item);
            }).catch(swal.noop);
        },

        remove_item: function remove_item(item) {
            var self = this;
            var url = App.host + '/item/' + item.id_item;
            var index = this.data.items.indexOf(item);

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'DELETE'
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        text: "Partida eliminada correctamente.",
                        type: "success",
                        confirmButtonText: "Ok"
                    });
                    Vue.delete(self.data.items, index);
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        show_edit_item: function show_edit_item(item) {
            this.form.item['index'] = this.data.items.indexOf(item);
            this.form.item.id_material = item.id_material;
            this.form.item.observaciones = item.item_ext.observaciones;
            this.form.item.unidad = item.unidad;
            this.form.item.cantidad = item.cantidad;
            this.form.item.id_item = item.id_item;
            $('#edit_item_modal').removeAttr('tabindex');
            this.validation_errors.clear('form_edit_item');
            $('#edit_item_modal').modal('show');
            this.validation_errors.clear('form_edit_item');
        },

        close_add_item: function close_add_item() {
            $('#add_item_modal').modal('hide');
            $('#edit_item_modal').modal('hide');
            this.form.item = {
                'id_transaccion': this.requisicion.id_transaccion,
                'id_material': '',
                'observaciones': '',
                'cantidad': '',
                'unidad': ''
            };
        },

        confirm_save: function confirm_save() {
            var self = this;
            swal({
                title: "Actualizar Requisición",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function () {
                self.save();
            }).catch(swal.noop);
        },

        save: function save() {
            var self = this;
            var url = this.url_requisicion;
            var data = this.form;

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        text: "Requisición actualizada correctamente.",
                        type: "success",
                        confirmButtonText: "Ok"
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        confirm_update_item: function confirm_update_item() {
            var self = this;
            swal({
                title: "Actualizar Partida",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function () {
                self.update_item();
            }).catch(swal.noop);
        },
        confirm_save_item: function confirm_save_item() {
            var self = this;
            swal({
                title: "Guardar Partida",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function () {
                self.save_item();
            }).catch(swal.noop);
        },
        confirm_update_requisicion: function confirm_update_requisicion() {
            var self = this;
            swal({
                title: "Actualizar Requisicion",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function () {
                self.update_requisicion();
            }).catch(swal.noop);
        },

        save_item: function save_item() {
            var self = this;
            var url = App.host + '/item';
            var data = this.form.item;

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.data.items.push(data.data.item);
                    $('#add_item_modal').modal('hide');
                    swal({
                        title: '¡Correcto!',
                        text: "Partida guardada correctamente.",
                        type: "success",
                        confirmButtonText: "Ok"
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        update_item: function update_item() {

            var self = this;
            var url = App.host + '/item/' + self.form.item.id_item;
            var data = this.form.item;
            data['_method'] = 'PATCH';
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.data.items[self.form.item.index] = data.data.item;
                    $('#edit_item_modal').modal('hide');
                    self.form.item = {
                        'id_transaccion': self.requisicion.id_transaccion,
                        'id_material': '',
                        'observaciones': '',
                        'cantidad': '',
                        'unidad': ''
                    };
                    swal({
                        title: '¡Correcto!',
                        text: "Partida actualizada correctamente.",
                        type: "success",
                        confirmButtonText: "Ok"
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        update_requisicion: function update_requisicion() {

            var self = this;
            var url = App.host + '/compras/requisicion/' + self.form.item.id_transaccion;
            var data = this.form.requisicion;
            data['_method'] = 'patch';
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        text: "Requisición actualizada correctamente.",
                        type: "success",
                        confirmButtonText: "Ok"
                    }).then(function () {
                        window.location = App.host + '/compras/requisicion/' + self.form.item.id_transaccion + '/edit';
                    }).catch(swal.noop);
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save') {
                    _this.confirm_save();
                } else if (funcion == 'save_item') {
                    _this.confirm_save_item();
                } else if (funcion == 'edit_item') {
                    _this.confirm_update_item();
                } else if (funcion == 'update_requisicion') {
                    _this.confirm_update_requisicion();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        }
    }
});

},{}],10:[function(require,module,exports){
'use strict';

var _methods;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

Vue.component('configuracion-seguridad-index', {
    data: function data() {
        return {
            permisos: [],
            permisos_alta: [],
            roles: [],
            rol_usuario_alta: [],
            role: {
                name: '',
                description: '',
                display_name: ''
            },
            usuario: [],
            guardando: false,
            cargando: false
        };
    },

    computed: {
        nombre_corto: function nombre_corto() {
            return this.role.display_name.replace(new RegExp(" ", 'g'), '_').toLowerCase();
        }
    },

    mounted: function mounted() {
        var self = this;
        this.getPermisos();

        $('#edit_role_modal').on('shown.bs.modal', function () {
            $('#nombre_edit').focus();
        });

        $('#create_role_modal').on('shown.bs.modal', function () {
            $('#nombre').focus();
        });

        $(document).on('click', '.btn_edit', function () {
            var id = $(this).attr('id');
            self.getRole(id);
        });

        $(document).on('click', '.btn_edit_rol_user', function () {
            var usuario = $(this).attr('id');
            self.getRoleUser(usuario);
        });

        $('#roles_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "order": [[2, "desc"]],
            "searching": true,
            "searchDelay": 750,
            "ajax": {
                "url": App.host + '/configuracion/seguridad/role/paginate',
                "type": "POST",
                "beforeSend": function beforeSend() {
                    self.guardando = true;
                },
                "complete": function complete() {
                    self.guardando = false;
                },
                "dataSrc": function dataSrc(json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                    }
                    return json.data;
                }
            },
            "columns": [{ data: 'display_name', 'name': 'Nombre', 'searchable': true }, { data: 'description', 'searchable': true }, { data: 'created_at', 'searchable': false }, {
                data: {},
                render: function render(data) {
                    var html = '';
                    data.perms.forEach(function (perm) {
                        html += perm.display_name + '<br>';
                    });
                    return html;
                },
                orderable: false
            }, {
                data: {},
                render: function render(data) {
                    return '<button class="btn btn-xs btn-default btn_edit" title="Editar" id="' + data.id + '"><i class="fa fa-pencil"></i></button>';
                },

                orderable: false
            }],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        $('#usuarios_roles_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "order": [[1, "ASC"]],
            "searching": true,
            "searchDelay": 750,
            "ajax": {
                "url": App.host + '/usuario/paginate',
                "type": "POST",
                "beforeSend": function beforeSend() {
                    self.guardando = true;
                },
                "complete": function complete() {
                    self.guardando = false;
                },
                "dataSrc": function dataSrc(json) {
                    return json.data;
                }
            },
            "columns": [{ data: 'usuario', 'name': 'Nombre', 'searchable': true }, { data: 'nombre', 'searchable': true }, {
                data: {},
                render: function render(data) {
                    var html = '';
                    if (data.user) {
                        data.user.roles.forEach(function (rol) {
                            html += rol.display_name + '<br>';
                        });
                    }
                    return html;
                },
                orderable: false, 'searchable': false, "width": "200px"
            }, {
                data: {},
                render: function render(data) {
                    return '<button class="btn btn-xs btn-default btn_edit_rol_user" title="Editar" id="' + data.usuario + '"><i class="fa fa-pencil"></i></button>';
                },

                orderable: false
            }],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    },

    methods: (_methods = {
        getRoleUser: function getRoleUser(usuario) {
            var self = this;
            $.ajax({
                url: App.host + '/usuario/' + usuario,
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.usuario = response.usuario;
                    self.roles = response.roles;
                    self.rol_usuario_alta = [];
                    if (self.usuario.user) {
                        self.usuario.user.roles.forEach(function (rol) {
                            self.rol_usuario_alta.push(rol.id);
                        });
                    }
                    self.validation_errors.clear('form_update_role_user');
                    $('#edit_role_user_modal').modal('show');
                    self.validation_errors.clear('form_update_role_user');
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        getRole: function getRole(id) {
            var self = this;
            $.ajax({
                url: App.host + '/configuracion/seguridad/role/' + id,
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.role = response;
                    self.permisos_alta = [];
                    self.role.perms.forEach(function (perm) {
                        self.permisos_alta.push(perm.id);
                    });

                    self.validation_errors.clear('form_update_role');
                    $('#edit_role_modal').modal('show');
                    self.validation_errors.clear('form_update_role');
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        getPermisos: function getPermisos() {
            var self = this;
            $.ajax({
                url: App.host + '/configuracion/seguridad/permission',
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.permisos = response;
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        updateRol: function updateRol() {
            var self = this;
            $.ajax({
                url: App.host + '/configuracion/seguridad/role/' + self.role.id,
                type: 'POST',
                data: {
                    _method: 'PATCH',
                    display_name: self.role.display_name,
                    description: self.role.description,
                    permissions: self.permisos_alta
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(response) {

                    swal({
                        type: 'success',
                        title: 'Rol ' + response.display_name + ' actualizado correctamente'
                    }).then(function () {
                        $('.modal').modal('hide');
                        self.closeModal();
                        $('#roles_table').DataTable().ajax.reload(null, false);
                    });
                },
                complete: function complete(response) {
                    self.guardando = false;
                }
            });
        },

        asignado: function asignado(permiso) {
            var found = this.role.perms.find(function (element) {
                return element.id == permiso.id;
            });
            return found != undefined;
        },

        closeModal: function closeModal() {
            this.permisos_alta = [];
            this.role = {
                name: '',
                description: '',
                display_name: ''
            };
        },

        saveRol: function saveRol() {
            var self = this;
            $.ajax({
                url: App.host + '/configuracion/seguridad/role',
                type: 'POST',
                data: {
                    name: self.nombre_corto,
                    display_name: self.role.display_name,
                    description: self.role.description,
                    permissions: self.permisos_alta
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(response) {
                    swal({
                        type: 'success',
                        title: 'Rol ' + response.display_name + ' registrado correctamente'
                    }).then(function () {
                        $('.modal').modal('hide');
                        self.closeModal();
                        $('#roles_table').DataTable().ajax.reload(null, false);
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        saveRolUsuario: function saveRolUsuario() {
            var self = this;
            $.ajax({
                url: App.host + '/usuario',
                type: 'POST',
                data: {
                    roles_alta: self.rol_usuario_alta,
                    usuario: self.usuario
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(response) {
                    swal({
                        type: 'success',
                        title: 'Roles asignados correctamente'
                    }).then(function () {
                        $('.modal').modal('hide');
                        self.closeModal();
                        $('#usuarios_roles_table').DataTable().ajax.reload(null, false);
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_role') {
                    _this.confirm_save_role();
                } else if (funcion == 'update_role') {
                    _this.confirm_update_role();
                } else if (funcion == 'update_role_user') {
                    _this.confirm_save_role_usuario();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirm_save_role: function confirm_save_role() {
            var self = this;
            swal({
                title: "Guardar Nuevo Rol",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.saveRol();
                }
            });
        },

        confirm_update_role: function confirm_update_role() {
            var self = this;
            swal({
                title: "Actualizar Rol",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.updateRol();
                }
            });
        }

    }, _defineProperty(_methods, 'confirm_save_role', function confirm_save_role() {
        var self = this;
        swal({
            title: "Guardar Nuevo Rol",
            text: "¿Estás seguro de que la información es correcta?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, Continuar",
            cancelButtonText: "No, Cancelar"
        }).then(function (result) {
            if (result.value) {
                self.saveRol();
            }
        });
    }), _defineProperty(_methods, 'confirm_save_role_usuario', function confirm_save_role_usuario() {
        var self = this;
        swal({
            title: "Asignar Rol a Usuario",
            text: "¿Estás seguro de que la información es correcta?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, Continuar",
            cancelButtonText: "No, Cancelar"
        }).then(function (result) {
            if (result.value) {
                self.saveRolUsuario();
            }
        });
    }), _methods)
});

},{}],11:[function(require,module,exports){
'use strict';

Vue.component('cierre-index', {
    props: ['editar_cierre_periodo'],
    data: function data() {
        return {
            cierre: {
                anio: '',
                mes: ''
            },
            cierre_edit: {
                id: '',
                anio: '',
                created_at: '',
                description: '',
                mes: '',
                registro: ''
            },
            tipos_tran: {},
            guardando: false
        };
    },

    mounted: function mounted() {
        var self = this;

        $(document).on('click', '.btn_open', function () {
            var id = $(this).attr('id');
            self.open(id);
        });
        $(document).on('click', '.btn_close', function () {
            var id = $(this).attr('id');
            self.close(id);
        });

        $('#fecha').datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'mm/yyyy',
            language: 'es'
        }).on('changeDate', function (selected) {
            self.cierre.anio = new Date(selected.date.valueOf()).getFullYear();
            self.cierre.mes = new Date(selected.date.valueOf()).getMonth() + 1;
        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "searching": false,
            "order": [[3, "desc"]],
            "ajax": {
                "url": App.host + '/sistema_contable/cierre/paginate',
                "type": "POST",
                "beforeSend": function beforeSend() {
                    self.guardando = true;
                },
                "complete": function complete() {
                    self.guardando = false;
                },
                "dataSrc": function dataSrc(json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].mes = parseInt(json.data[i].mes).getMes();
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                        json.data[i].registro = json.data[i].user_registro.nombre + ' ' + json.data[i].user_registro.apaterno + ' ' + json.data[i].user_registro.amaterno;
                    }
                    return json.data;
                }
            },
            "columns": [{ data: 'anio' }, { data: 'mes' }, { data: 'registro', orderable: false }, { data: 'created_at' }, {
                data: {},
                render: function render(data) {
                    return '<span class="label" style="background-color: ' + (data.abierto == true ? 'rgb(243, 156, 18)' : 'rgb(0, 166, 90)') + '">' + (data.abierto == true ? 'Abierto' : 'Cerrado') + '</span>';
                },
                orderable: false
            }],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        };

        if (self.editar_cierre_periodo) {
            data.columns.push({
                data: {},
                render: function render(data) {
                    return '<div class="btn-group">' + '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">' + '<span class="caret"></span>' + '</button>' + '<ul class="dropdown-menu">' + '<li>' + '<a href="#" id="' + data.id + '" class="btn_' + (data.abierto == true ? 'close' : 'open') + '">' + (data.abierto == true ? 'Cerrar ' : 'Abrir ') + '</a>' + '</li>' + '</ul>' + '</div>';
                },
                orderable: false
            });
        }

        $('#cierres_table').DataTable(data);
    },

    methods: {
        generar_cierre: function generar_cierre() {
            this.reset_cierre();
            this.validation_errors.clear('form_save_cierre');
            $('#create_cierre_modal').modal('show');
            this.validation_errors.clear('form_save_cierre');
        },

        reset_cierre: function reset_cierre() {
            $('#fecha').val('');
            Vue.set(this.cierre, 'mes', '');
            Vue.set(this.cierre, 'anio', '');
        },

        save_cierre: function save_cierre() {
            var self = this;

            $.ajax({
                url: App.host + '/sistema_contable/cierre',
                type: 'POST',
                data: self.cierre,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success() {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cierre de Periodo guardado correctamente',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        $('#create_cierre_modal').modal('hide');
                        $('#cierres_table').DataTable().ajax.reload();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        open: function open(id_cierre) {
            var self = this;

            swal({
                title: 'Abrir Periodo',
                text: 'Motivo de la Apertura',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Abrir ',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: false,
                preConfirm: function preConfirm(motivo) {
                    return new Promise(function (resolve) {
                        if (motivo.length === 0) {
                            swal.showValidationError('Por favor escriba un motivo para la apertura del periodo.');
                        }
                        resolve();
                    });
                },
                allowOutsideClick: function allowOutsideClick() {
                    !swal.isLoading();
                }
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        'url': App.host + '/sistema_contable/cierre/' + id_cierre + '/open',
                        'type': 'POST',
                        'data': {
                            '_method': 'PATCH',
                            'motivo': result.value
                        },
                        beforeSend: function beforeSend() {
                            self.guardando = true;
                        },
                        success: function success(response) {
                            swal({
                                type: 'success',
                                title: 'Periodo abierto correctamente',
                                html: '<p>Año : <b>' + response.anio + '</b> ' + 'Mes : <b>' + parseInt(response.mes).getMes() + '</b></p>',
                                confirmButtonText: "Ok",
                                closeOnConfirm: false
                            }).then(function () {
                                $('#cierres_table').DataTable().ajax.reload(null, false);
                            });
                        },
                        complete: function complete() {
                            self.guardando = false;
                        }
                    });
                }
            });
        },

        close: function close(id_cierre) {
            var self = this;
            swal({
                title: '¿Deseas volver a cerrar el periodo seleccionado?',
                text: "No se podrán realizar transacciones para el periodo seleccionado",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Cerrar',
                cancelButtonText: 'No, Cancelar'
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: App.host + '/sistema_contable/cierre/' + id_cierre + '/close',
                        type: 'POST',
                        data: {
                            _method: 'PATCH'
                        },
                        beforeSend: function beforeSend() {
                            self.guardando = true;
                        },
                        success: function success(response) {
                            swal({
                                type: 'success',
                                title: 'Periodo Cerrado Correctamente',
                                html: '<p>Año : <b>' + response.anio + '</b> ' + 'Mes : <b>' + parseInt(response.mes).getMes() + '</b></p>',
                                confirmButtonText: "Ok",
                                closeOnConfirm: false
                            }).then(function () {
                                $('#cierres_table').DataTable().ajax.reload(null, false);
                            });
                        },
                        complete: function complete() {
                            self.guardando = false;
                        }
                    });
                }
            });
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_cierre') {
                    _this.confirm_save_cierre();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirm_save_cierre: function confirm_save_cierre() {
            var self = this;
            swal({
                title: "Generar Cierre de Periodo",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cierre();
                }
            });
        }
    }
});

},{}],12:[function(require,module,exports){
'use strict';

Vue.component('cuenta-almacen-index', {
    props: ['datos_contables', 'editar_cuenta_almacen', 'registrar_cuenta_almacen'],
    data: function data() {
        return {
            'data': {
                'almacen_edit': {}
            },
            'form': {
                'cuenta_almacen': {
                    'id': '',
                    'id_almacen': '',
                    'cuenta': ''
                }
            },
            'guardando': false
        };
    },

    mounted: function mounted() {
        var self = this;

        $(document).on('click', '.btn_edit', function () {
            var id = $(this).attr('id');
            self.editar(id);
        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "searching": false,
            "order": [[1, "asc"]],
            "ajax": {
                "url": App.host + '/almacen/paginate',
                "type": "POST",
                "beforeSend": function beforeSend() {
                    self.guardando = true;
                },
                "complete": function complete() {
                    self.guardando = false;
                },
                "dataSrc": function dataSrc(json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].index = i + 1;
                    }
                    return json.data;
                }
            },
            "columns": [{ data: 'index', orderable: false }, { data: 'descripcion' }, { data: 'tipo_almacen' }, {
                data: {},
                render: function render(data) {
                    return data.cuenta_almacen != null && data.cuenta_almacen.cuenta != null ? data.cuenta_almacen.cuenta : '---';
                },
                orderable: false
            }, {
                data: {},
                render: function render(data) {
                    return '<div class="btn-group">' + '     <button id="' + data.id_almacen + '" title="' + (data.cuenta_almacen != null ? 'Editar' : 'Registrar') + '" class="btn btn-xs btn_edit btn-' + (data.cuenta_almacen != null ? 'info' : 'success') + '" type="button">' + '       <i class="fa fa-edit"></i>' + '     </button>' + '   </div>';
                }
            }],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        };

        $('#almacenes_table').DataTable(data);
    },

    methods: {
        editar: function editar(id_almacen) {

            var self = this;

            $.ajax({
                url: App.host + '/almacen/' + id_almacen,
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(response) {
                    self.data.almacen_edit = response;
                    Vue.set(self.form.cuenta_almacen, 'id_almacen', response.id_almacen);
                    if (response.cuenta_almacen != null) {
                        Vue.set(self.form.cuenta_almacen, 'cuenta', response.cuenta_almacen.cuenta);
                        Vue.set(self.form.cuenta_almacen, 'id', response.cuenta_almacen.id);
                    } else {
                        Vue.set(self.form.cuenta_almacen, 'cuenta', '');
                        Vue.set(self.form.cuenta_almacen, 'id', '');
                    }
                    self.validation_errors.clear('form_edit_cuenta');
                    $('#edit_cuenta_modal').modal('show');
                    $('#cuenta_contable').focus();
                    self.validation_errors.clear('form_edit_cuenta');
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_save_cuenta') {
                    _this.confirm_save_cuenta();
                } else if (funcion == 'confirm_update_cuenta') {
                    _this.confirm_update_cuenta();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },
        confirm_update_cuenta: function confirm_update_cuenta() {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.update_cuenta();
                }
            });
        },

        update_cuenta: function update_cuenta() {
            var self = this;
            var url = App.host + '/sistema_contable/cuenta_almacen/' + self.form.cuenta_almacen.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta_almacen.cuenta
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
                    }).then(function () {
                        $('#almacenes_table').DataTable().ajax.reload(null, false);
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        confirm_save_cuenta: function confirm_save_cuenta() {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cuenta();
                }
            }).catch(swal.noop);
        },

        save_cuenta: function save_cuenta() {
            var self = this;

            $.ajax({
                type: 'POST',
                url: App.host + '/sistema_contable/cuenta_almacen',
                data: {
                    cuenta: self.form.cuenta_almacen.cuenta,
                    id_almacen: self.form.cuenta_almacen.id_almacen
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
                    }).then(function () {
                        $('#almacenes_table').DataTable().ajax.reload(null, false);
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        close_edit_cuenta: function close_edit_cuenta() {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form.cuenta_almacen, 'cuenta', '');
            Vue.set(this.form.cuenta_almacen, 'id', '');
            Vue.set(this.form.cuenta_almacen, 'id_almacen', '');
        }
    }
});

},{}],13:[function(require,module,exports){
'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

Vue.component('cuenta-bancaria-edit', {
    props: ['cuenta', 'tipos', 'cuenta_store_url', 'cuentas_asociadas', 'datos_contables'],

    data: function data() {
        return {
            'asociadas': this.cuentas_asociadas,
            'form': {
                'id_tipo_cuenta_contable': '',
                'cuenta': ''
            },
            'cuenta_descripcion': '',
            'cuenta_edit_id': 0,
            'guardando': false,
            'nuevo_registro': false
        };
    },
    methods: {
        close_modal: function close_modal(modal) {
            $('#' + modal).modal('hide');
            this.form.id_tipo_cuenta_contable = '';
            this.form.cuenta = '';
        },
        confirm_elimina_cuenta: function confirm_elimina_cuenta(cuenta) {
            var self = this;
            this.cuenta_edit_id = cuenta.id_cuenta_contable_bancaria;
            this.form.id_tipo_cuenta_contable = cuenta.id_tipo_cuenta_contable;
            this.form.cuenta = cuenta.cuenta;

            swal({
                title: "Eliminar Cuenta Contable",
                html: "¿Estás seguro que desea eliminar la cuenta " + cuenta.cuenta + "?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.elimina_cuenta();
                }
            });
        },
        confirm_cuenta_update: function confirm_cuenta_update() {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro que desea actualizar la Cuenta Contable?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.update_cuenta_bancaria();
                }
            });
        },
        confirm_cuenta_create: function confirm_cuenta_create() {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro que desea registrar la Cuenta Contable?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cuenta_bancaria();
                }
            });
        },
        elimina_cuenta: function elimina_cuenta() {
            var self = this;
            var data = self.form;
            var url = App.host + '/sistema_contable/cuentas_contables_bancarias/' + this.cuenta_edit_id;
            var toRemove = this.cuenta_edit_id;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    data: data,
                    _method: 'DELETE'
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    $('#add_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: fué eliminada correctamente'
                    }).then(function () {
                        $.each(self.asociadas, function (index, tipo_cuenta) {
                            if (toRemove == tipo_cuenta.id_cuenta_contable_bancaria) {
                                self.asociadas.splice(index, 1);
                            }
                        });
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                    this.cuenta_descripcion = '';
                    this.cuenta_edit_id = 0;
                    this.form.id_tipo_cuenta_contable = '';
                    this.form.cuenta = '';
                }
            });
        },
        create_cuenta_bancaria: function create_cuenta_bancaria() {
            this.form.id_tipo_cuenta_contable = '';
            this.form.cuenta = '';
            this.nuevo_registro = true;
            this.obtener_tipos_disponibles();

            this.validation_errors.clear('form_create_cuenta');
            $('#add_movimiento_modal').modal('show');
            this.validation_errors.clear('form_create_cuenta');
        },
        edit_cuenta_bancaria: function edit_cuenta_bancaria(cuenta) {
            this.nuevo_registro = false;
            this.form.id_tipo_cuenta_contable = cuenta.id_tipo_cuenta_contable;
            this.form.cuenta = cuenta.cuenta;
            this.cuenta_descripcion = cuenta.tipo_cuenta_contable.descripcion;
            this.cuenta_edit_id = cuenta.id_cuenta_contable_bancaria;

            this.validation_errors.clear('form_update_cuenta');
            $('#edit_movimiento_modal').modal('show');
            this.validation_errors.clear('form_update_cuenta');
        },
        update_cuenta_bancaria: function update_cuenta_bancaria() {
            var self = this;
            var data = self.form;
            var url = App.host + '/sistema_contable/cuentas_contables_bancarias/' + this.cuenta_edit_id;
            var toRemove = this.cuenta_edit_id;

            data.id_cuenta = self.cuenta.id_cuenta;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    data: data,
                    _method: 'PATCH'
                },
                beforeSend: function beforeSend() {
                    self.validation_errors.clear('form_update_cuenta');
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta:' + data.data.cuenta + '</b> fué actualizada correctamente'
                    }).then(function () {
                        $.each(self.asociadas, function (index, tipo_cuenta) {
                            if (toRemove == tipo_cuenta.id_cuenta_contable_bancaria) {
                                self.asociadas.splice(index, 1, data.data);
                            }
                        });
                        $('#edit_movimiento_modal').modal('hide');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                    this.cuenta_descripcion = '';
                    this.cuenta_edit_id = 0;
                    this.form.id_tipo_cuenta_contable = '';
                    this.form.cuenta = '';
                }
            });
        },
        save_cuenta_bancaria: function save_cuenta_bancaria() {
            var self = this;
            var url = self.cuenta_store_url;
            var data = self.form;

            data.id_cuenta = self.cuenta.id_cuenta;
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.validation_errors.clear('form_create_cuenta');
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: <b>' + data.data.cuenta + '</b> fue registrada correctamente'
                    }).then(function () {
                        self.asociadas.push(data.data);
                        self.close_modal('add_movimiento_modal');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                    this.form.id_tipo_cuenta_contable = '';
                    this.form.cuenta = '';
                }
            });
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_edit_cuenta') {
                    _this.confirm_cuenta_update();
                } else if (funcion == 'confirm_create_cuenta') {
                    _this.confirm_cuenta_create();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },
        tipo_info: function tipo_info(id) {
            var self = this,
                info = {};

            $.each(self.tipos, function (index, tipo_cuenta) {
                if (id == tipo_cuenta.id_tipo_cuenta_contable) info = tipo_cuenta;
            });

            return info;
        },
        uniq: function uniq(a) {
            var prims = { "boolean": {}, "number": {}, "string": {} },
                objs = [];

            return a.filter(function (item) {
                var type = typeof item === 'undefined' ? 'undefined' : _typeof(item);
                if (type in prims) return prims[type].hasOwnProperty(item) ? false : prims[type][item] = true;else return objs.indexOf(item) >= 0 ? false : objs.push(item);
            });
        },
        obtener_tipos_disponibles: function obtener_tipos_disponibles() {
            var self = this,
                tipos = [],
                tipos_temp = [],
                asociadas_tipos = [],
                tipos_disponibles = [];

            // No existen cuentas asociadas
            if (self.asociadas.length == 0) {
                return self.tipos;
            }

            $.each(self.asociadas, function (index, aso) {
                asociadas_tipos.push(parseInt(aso.id_tipo_cuenta_contable));
            });

            $.each(self.tipos, function (indexTipo, tipo) {
                tipos.push(tipo.id_tipo_cuenta_contable);
            });

            tipos_temp = tipos.filter(function (v) {
                return !asociadas_tipos.includes(v);
            });

            tipos_temp = self.uniq(tipos_temp);

            $.each(tipos_temp, function (index, tipo) {
                tipos_disponibles.push(self.tipo_info(tipo));
            });

            return tipos_disponibles;
        }
    }
});

},{}],14:[function(require,module,exports){
'use strict';

Vue.component('cuenta-concepto-index', {
    props: ['conceptos', 'url_concepto_get_by', 'datos_contables', 'url_store_cuenta'],
    data: function data() {
        return {
            'data': {
                'conceptos': this.conceptos

            },
            'form': {
                'concepto_edit': {},
                'cuenta': '',
                'concepto': '',
                'id': '',
                'id_concepto': ''
            },
            'cargando': false
        };
    },

    directives: {
        treegrid: {
            inserted: function inserted(el) {
                $(el).treegrid({
                    saveState: true,
                    initialState: 'collapsed'
                });
            },
            componentUpdated: function componentUpdated(el) {
                $(el).treegrid({
                    saveState: true
                });
            }
        },
        select2: {
            inserted: function inserted(el) {
                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/sistema_contable/concepto/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function data(params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%'
                            };
                        },
                        processResults: function processResults(data) {
                            return {
                                results: $.map(data.data.conceptos, function (item) {
                                    return {
                                        text: item.descripcion,
                                        id: item.id_concepto
                                    };
                                })
                            };
                        },
                        error: function error(_error) {},
                        cache: true
                    },
                    escapeMarkup: function escapeMarkup(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                }).on('select2:select', function () {
                    $('#id_concepto').val($('#concepto_select option:selected').data().data.id);
                });
            }
        }
    },

    computed: {
        conceptos_ordenados: function conceptos_ordenados() {
            return this.data.conceptos.sort(function (a, b) {
                return a.nivel > b.nivel ? 1 : b.nivel > a.nivel ? -1 : 0;
            });
        }
    },

    methods: {
        tr_class: function tr_class(concepto) {
            var treegrid = "treegrid-" + concepto.id_concepto;
            var treegrid_parent = concepto.id_padre != null && concepto.id_concepto != parseInt($('#id_concepto').val()) ? " treegrid-parent-" + concepto.id_padre : "";
            return treegrid + treegrid_parent;
        },

        tr_id: function tr_id(concepto) {
            return concepto.id_padre == null || concepto.tiene_hijos > 0 ? "tnode-" + concepto.id_concepto : "";
        },

        get_hijos: function get_hijos(concepto) {
            var self = this;

            $.ajax({
                type: 'GET',
                url: self.url_concepto_get_by,
                data: {
                    attribute: 'nivel',
                    operator: 'like',
                    value: concepto.nivel_hijos,
                    with: 'cuentaConcepto'
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(data, textStatus, xhr) {
                    data.data.conceptos.forEach(function (concepto) {
                        self.data.conceptos.push(concepto);
                    });
                    concepto.cargado = true;
                },
                complete: function complete() {
                    self.cargando = false;
                    setTimeout(function () {
                        $('#tnode-' + concepto.id_concepto).treegrid('expand');
                    }, 500);
                }
            });
        },

        edit_cuenta: function edit_cuenta(concepto) {
            this.form.concepto_edit = concepto;
            Vue.set(this.form, 'concepto', concepto.descripcion);
            Vue.set(this.form, 'id_concepto', concepto.id_concepto);
            if (concepto.cuenta_concepto != null) {
                Vue.set(this.form, 'cuenta', concepto.cuenta_concepto.cuenta);
                Vue.set(this.form, 'id', concepto.cuenta_concepto.id);
            } else {
                Vue.set(this.form, 'cuenta', '');
                Vue.set(this.form, 'id', '');
            }
            this.validation_errors.clear('form_edit_cuenta');
            $('#edit_cuenta_modal').modal('show');
            $('#cuenta_contable').focus();
            this.validation_errors.clear('form_edit_cuenta');
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_save_cuenta') {
                    _this.confirm_save_cuenta();
                } else if (funcion == 'confirm_update_cuenta') {
                    _this.confirm_update_cuenta();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirm_update_cuenta: function confirm_update_cuenta() {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.update_cuenta();
                }
            });
        },

        update_cuenta: function update_cuenta() {
            var self = this;
            var url = this.url_store_cuenta + '/' + this.form.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
                    }).then(function () {
                        self.form.concepto_edit.cuenta_concepto = data.data.cuenta_concepto;
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        confirm_save_cuenta: function confirm_save_cuenta() {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cuenta();
                }
            });
        },

        save_cuenta: function save_cuenta() {
            var self = this;
            var url = this.url_store_cuenta;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta,
                    id_concepto: self.form.id_concepto
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
                    }).then(function () {
                        self.form.concepto_edit.cuenta_concepto = data.data.cuenta_concepto;
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        close_edit_cuenta: function close_edit_cuenta() {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form, 'cuenta', '');
            Vue.set(this.form, 'concepto', '');
            Vue.set(this.form, 'id', '');
            Vue.set(this.form, 'id_concepto', '');
        },

        buscar_nodos: function buscar_nodos() {
            var id_concepto = $('#id_concepto').val();

            var self = this;
            var url = App.host + '/sistema_contable/concepto/findBy';
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    attribute: 'id_concepto',
                    operator: '=',
                    value: id_concepto,
                    with: 'cuentaConcepto'
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.data.conceptos = [];
                    if (data.data.concepto != null) {
                        self.data.conceptos.push(data.data.concepto);
                    }
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        }
    }
});

},{}],15:[function(require,module,exports){
'use strict';

Vue.component('cuenta-contable-index', {
    props: ['datos_contables', 'cuenta_contable_url', 'tipos_cuentas_contables'],
    data: function data() {
        return {
            'data': {
                'tipos_cuentas_contables': this.tipos_cuentas_contables
            },
            'form': {
                'tipo_cuenta_contable_edit': {
                    'cuenta_contable': {
                        'con_prefijo': false
                    }
                }
            },
            'guardando': false
        };
    },

    methods: {
        confirm_cuenta_contable: function confirm_cuenta_contable() {
            var self = this;
            swal({
                title: "Configurar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cuenta_contable();
                }
            });
        },

        confirm_cuenta_contable_update: function confirm_cuenta_contable_update() {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.update_cuenta_contable();
                }
            });
        },

        save_cuenta_contable: function save_cuenta_contable() {
            var self = this;
            var url = self.cuenta_contable_url;
            var data = {
                id_int_tipo_cuenta_contable: self.form.tipo_cuenta_contable_edit.id_int_tipo_cuenta_contable,
                prefijo: self.form.tipo_cuenta_contable_edit.cuenta_contable.prefijo,
                cuenta_contable: self.form.tipo_cuenta_contable_edit.cuenta_contable.cuenta_contable,
                con_prefijo: self.form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo
            };

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.validation_errors.clear('form_save_cuenta');
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable <b>' + data.data.cuenta_contable.tipo_cuenta_contable.descripcion + '</b> configurada correctamente'
                    }).then(function () {
                        Vue.set(self.data, 'tipos_cuentas_contables', data.data.tipos_cuentas_contables);
                    });
                },
                complete: function complete() {
                    self.reset_form();
                    $('#modal-configurar-cuenta').modal('hide');
                    self.guardando = false;
                }
            });
        },
        update_cuenta_contable: function update_cuenta_contable() {
            var self = this;
            var data = {
                con_prefijo: this.form.tipo_cuenta_contable_edit.cuenta_contable.con_prefijo,
                prefijo: this.form.tipo_cuenta_contable_edit.cuenta_contable.prefijo,
                cuenta_contable: this.form.tipo_cuenta_contable_edit.cuenta_contable.cuenta_contable
            };
            var url = self.cuenta_contable_url + '/' + this.form.tipo_cuenta_contable_edit.cuenta_contable.id_int_cuenta_contable;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    data: data,
                    _method: 'PATCH'
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable <b>' + data.data.cuenta_contable.tipo_cuenta_contable.descripcion + '</b> actualizada correctamente'
                    }).then(function () {
                        Vue.set(self.data, 'tipos_cuentas_contables', data.data.tipos_cuentas_contables);
                    });
                },
                complete: function complete() {
                    self.reset_form();
                    $('#modal-editar-cuenta').modal('hide');
                    self.guardando = false;
                }
            });
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_cuenta') {
                    _this.confirm_cuenta_contable();
                } else if (funcion == 'update_cuenta') {
                    _this.confirm_cuenta_contable_update();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        editar: function editar(item) {
            Vue.set(this.form.tipo_cuenta_contable_edit, 'id_int_tipo_cuenta_contable', item.id_int_tipo_cuenta_contable);
            Vue.set(this.form.tipo_cuenta_contable_edit, 'descripcion', item.descripcion);

            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'id_int_cuenta_contable', item.cuenta_contable.id_int_cuenta_contable);
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'cuenta_contable', item.cuenta_contable.cuenta_contable);
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'prefijo', item.cuenta_contable.prefijo);
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'con_prefijo', item.cuenta_contable.prefijo ? true : false);
        },

        configurar: function configurar(item) {
            Vue.set(this.form.tipo_cuenta_contable_edit, 'id_int_tipo_cuenta_contable', item.id_tipo_cuenta_contable);
            Vue.set(this.form.tipo_cuenta_contable_edit, 'descripcion', item.descripcion);

            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'id_int_cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'prefijo', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'con_prefijo', false);
        },

        reset_form: function reset_form() {
            Vue.set(this.form.tipo_cuenta_contable_edit, 'id_int_tipo_cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit, 'descripcion', '');

            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'id_int_cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'cuenta_contable', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'prefijo', '');
            Vue.set(this.form.tipo_cuenta_contable_edit.cuenta_contable, 'con_prefijo', false);
        }
    }
});

},{}],16:[function(require,module,exports){
'use strict';

Vue.component('cuenta-costo-index', {
    props: ['costos', 'url_costo_get_by', 'url_costo_find_by', 'datos_contables', 'url_cuenta_costo_index'],
    data: function data() {
        return {
            'data': {
                'costos': this.costos

            },
            'form': {
                'costo_edit': {},
                'cuenta': '',
                'costo': '',
                'id_cuenta_costo': '',
                'id_costo': ''
            },
            'cargando': false
        };
    },

    directives: {
        treegrid: {
            inserted: function inserted(el) {
                $(el).treegrid({
                    saveState: true,
                    initialState: 'collapsed'
                });
            },
            componentUpdated: function componentUpdated(el) {
                $(el).treegrid({
                    saveState: true
                });
            }
        },
        select2: {
            inserted: function inserted(el) {

                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/sistema_contable/costo/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function data(params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%',
                                with: 'cuentaCosto'
                            };
                        },
                        processResults: function processResults(data) {
                            return {
                                results: $.map(data.data.costos, function (item) {
                                    return {
                                        text: item.descripcion,
                                        id: item.id_costo
                                    };
                                })
                            };
                        },
                        error: function error(_error) {},
                        cache: true
                    },
                    escapeMarkup: function escapeMarkup(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                }).on('select2:select', function () {
                    $('#id_costo').val($('#costo_select option:selected').data().data.id);
                });
            }
        }
    },

    computed: {
        costos_ordenados: function costos_ordenados() {
            return this.data.costos.sort(function (a, b) {
                return a.nivel > b.nivel ? 1 : b.nivel > a.nivel ? -1 : 0;
            });
        }
    },

    methods: {
        tr_class: function tr_class(costo) {
            var treegrid = "treegrid-" + costo.id_costo;
            var treegrid_parent = costo.id_padre != null && costo.id_costo != parseInt($('#id_costo').val()) ? " treegrid-parent-" + costo.id_padre : "";
            return treegrid + treegrid_parent;
        },

        tr_id: function tr_id(costo) {
            return costo.id_padre == null || costo.tiene_hijos > 0 ? "tnode-" + costo.id_costo : "";
        },

        get_hijos: function get_hijos(costo) {
            var self = this;

            $.ajax({
                type: 'GET',
                url: self.url_costo_get_by,
                data: {
                    attribute: 'nivel',
                    operator: 'like',
                    value: costo.nivel_hijos,
                    with: 'cuentaCosto'
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(data, textStatus, xhr) {
                    data.data.costos.forEach(function (costo) {
                        self.data.costos.push(costo);
                    });
                    costo.cargado = true;
                },
                complete: function complete() {
                    self.cargando = false;
                    setTimeout(function () {
                        $('#tnode-' + costo.id_costo).treegrid('expand');
                    }, 500);
                }
            });
        },

        edit_cuenta: function edit_cuenta(costo) {
            this.form.costo_edit = costo;
            Vue.set(this.form, 'costo', costo.descripcion);
            Vue.set(this.form, 'id_costo', costo.id_costo);
            if (costo.cuenta_costo != null) {
                Vue.set(this.form, 'cuenta', costo.cuenta_costo.cuenta);
                Vue.set(this.form, 'id_cuenta_costo', costo.cuenta_costo.id_cuenta_costo);
            } else {
                Vue.set(this.form, 'cuenta', '');
                Vue.set(this.form, 'id_cuenta_costo', '');
            }
            this.validation_errors.clear('form_edit_cuenta');
            $('#edit_cuenta_modal').modal('show');
            $('#cuenta_contable').focus();
            this.validation_errors.clear('form_edit_cuenta');
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_save_cuenta') {
                    _this.confirm_save_cuenta();
                } else if (funcion == 'confirm_update_cuenta') {
                    _this.confirm_update_cuenta();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirm_update_cuenta: function confirm_update_cuenta() {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.update_cuenta();
                }
            });
        },

        update_cuenta: function update_cuenta() {
            var self = this;
            var url = this.url_cuenta_costo_index + '/' + this.form.id_cuenta_costo;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    data: self.form
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
                    }).then(function () {
                        self.form.costo_edit.cuenta_costo = data.data.cuenta_costo;
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        confirm_save_cuenta: function confirm_save_cuenta() {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cuenta();
                }
            });
        },

        save_cuenta: function save_cuenta() {
            var self = this;
            var url = this.url_cuenta_costo_index;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta,
                    id_costo: self.form.id_costo
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
                    }).then(function () {
                        self.form.costo_edit.cuenta_costo = data.data.cuenta_costo;
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        confirm_delete_cuenta: function confirm_delete_cuenta(id_cuenta_costo) {
            var self = this;
            swal({
                title: "Eliminar Cuenta Contable",
                text: "¿Estás seguro que desea eliminar la cuenta contable?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.delete_cuenta(id_cuenta_costo);
                }
            });
        },
        delete_cuenta: function delete_cuenta(id_cuenta_costo) {
            var self = this,
                url = this.url_cuenta_costo_index + '/' + id_cuenta_costo;

            $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _method: 'DELETE'
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        text: 'Cuenta Contable eliminada correctamente'
                    }).then(function () {
                        self.data.costos.forEach(function (costo, i) {

                            if (costo.cuenta_costo == null) {
                                return;
                            }

                            if (id_cuenta_costo == costo.cuenta_costo.id_cuenta_costo) {
                                Vue.set(costo, 'cuenta_costo', null);
                                Vue.set(self.data.costos, i, costo);
                                return;
                            }
                        });
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        close_edit_cuenta: function close_edit_cuenta() {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form, 'cuenta', '');
            Vue.set(this.form, 'costo', '');
            Vue.set(this.form, 'id_cuenta_costo', '');
            Vue.set(this.form, 'id_costo', '');
        },

        buscar_nodos: function buscar_nodos() {
            var self = this;
            var url = self.url_costo_find_by,
                id_costo = $('#id_costo').val();

            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    attribute: 'id_costo',
                    value: id_costo,
                    with: 'cuentaCosto'
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(result) {
                    self.data.costos = [];
                    if (result.data.costo != null) {
                        self.data.costos.push(result.data.costo);
                    }
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        }
    }
});

},{}],17:[function(require,module,exports){
'use strict';

Vue.component('cuenta-empresa-edit', {
    props: ['empresa', 'tipo_cuenta_empresa', 'cuenta_store_url', 'datos_contables'],

    data: function data() {
        return {
            'data': {
                'empresa': this.empresa
            },
            'form': {
                'cuenta_empresa': '',
                'cuenta_empresa_create': {
                    'id': '',
                    'cuenta': '',
                    'id_empresa': '',
                    'id_tipo_cuenta_empresa': '',
                    'tipo_cuenta_empresa': {
                        'descripcion': ''
                    }
                }
            },
            'guardando': false,
            'nuevo_registro': false
        };
    },
    methods: {
        close_modal: function close_modal(modal) {
            $('#' + modal).modal('hide');
            this.form.cuenta_empresa_create.cuenta = '';
            this.form.cuenta_empresa_create.id_tipo_cuenta_empresa = '';
            this.form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion = '';
            this.form.cuenta_empresa_create.id = '';
            this.form.cuenta_empresa_create.id_empresa = '';
        },
        confirm_elimina_cuenta: function confirm_elimina_cuenta(cuenta) {
            var self = this;
            self.form.cuenta_empresa = cuenta;
            self.form.cuenta_empresa.id_empresa = cuenta.id_empresa;
            swal({
                title: "Eliminar Cuenta Contable",
                html: "¿Estás seguro que desea eliminar la cuenta: <b> " + cuenta.tipo_cuenta_empresa.descripcion + "</b>?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.elimina_cuenta();
                }
            });
        },
        confirm_cuenta_update: function confirm_cuenta_update() {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro que desea actualizar la Cuenta Contable?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.update_cuenta_empresa();
                }
            });
        },
        confirm_cuenta_create: function confirm_cuenta_create() {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro que desea registrar la Cuenta Contable?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cuenta_empresa();
                }
            });
        },
        elimina_cuenta: function elimina_cuenta() {
            var self = this;
            var data = self.form.cuenta_empresa;
            var url = App.host + '/sistema_contable/cuenta_empresa/' + self.form.cuenta_empresa.id;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    data: data,
                    _method: 'DELETE'
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: <b>' + self.form.cuenta_empresa.tipo_cuenta_empresa.descripcion + '</b> fue eliminada correctamente'
                    }).then(function () {
                        Vue.set(self.data, 'empresa', data.data.empresa);
                        $('#add_movimiento_modal').modal('hide');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        create_cuenta_empresa: function create_cuenta_empresa() {
            this.form.cuenta_empresa_create.cuenta = '';
            this.form.cuenta_empresa_create.id_tipo_cuenta_empresa = '';
            this.form.cuenta_empresa_create.id_empresa = this.data.empresa.id_empresa;
            this.form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion = '';
            this.nuevo_registro = true;

            this.validation_errors.clear('form_create_cuenta');
            $('#add_movimiento_modal').modal('show');
            this.validation_errors.clear('form_create_cuenta');
        },
        edit_cuenta_empresa: function edit_cuenta_empresa(cuenta) {
            this.nuevo_registro = false;
            this.form.cuenta_empresa_create.cuenta = cuenta.cuenta;
            this.form.cuenta_empresa_create.id_tipo_cuenta_empresa = cuenta.id_tipo_cuenta_empresa;
            this.form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion = cuenta.tipo_cuenta_empresa.descripcion;
            this.form.cuenta_empresa_create.id = cuenta.id;
            this.form.cuenta_empresa_create.id_empresa = cuenta.id_empresa;

            this.validation_errors.clear('form_update_cuenta');
            $('#edit_movimiento_modal').modal('show');
            this.validation_errors.clear('form_update_cuenta');
        },
        update_cuenta_empresa: function update_cuenta_empresa(cuenta) {
            var self = this;
            var data = self.form.cuenta_empresa_create;
            var url = App.host + '/sistema_contable/cuenta_empresa/' + self.form.cuenta_empresa_create.id;
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    data: data,
                    _method: 'PATCH'
                },
                beforeSend: function beforeSend() {
                    self.validation_errors.clear('form_update_cuenta');
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta:' + self.form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion + '</b> fue actualizada correctamente'
                    }).then(function () {
                        Vue.set(self.data, 'empresa', data.data.empresa);
                        $('#edit_movimiento_modal').modal('hide');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        save_cuenta_empresa: function save_cuenta_empresa() {
            var self = this;
            var url = self.cuenta_store_url;
            var data = self.form.cuenta_empresa_create;
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.validation_errors.clear('form_create_cuenta');
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: <b>' + data.data.cuenta_empresa.tipo_cuenta_empresa.descripcion + '</b> fue registrada correctamente'
                    }).then(function () {
                        self.data.empresa.cuentas_empresa.push(data.data.cuenta_empresa);
                        self.close_modal('add_movimiento_modal');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_edit_cuenta') {
                    _this.confirm_cuenta_update();
                } else if (funcion == 'confirm_create_cuenta') {
                    _this.confirm_cuenta_create();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        }
    },

    computed: {

        cuentas_empresa_disponibles: function cuentas_empresa_disponibles() {

            var self = this;
            var result = {};
            $.each(this.tipo_cuenta_empresa, function (index, tipo_cuenta_empresa) {
                var existe = false;
                self.data.empresa.cuentas_empresa.forEach(function (cuenta) {
                    if (cuenta.id_tipo_cuenta_empresa == tipo_cuenta_empresa.id) {
                        existe = true;
                    }
                });

                if (!existe) {
                    result[index] = tipo_cuenta_empresa;
                }
            });
            return result;
        }
    }
});

},{}],18:[function(require,module,exports){
'use strict';

Vue.component('cuenta-fondo-index', {
    props: ['datos_contables', 'url_cuenta_fondo_store', 'fondos'],
    data: function data() {
        return {
            'data': {
                'fondos': this.fondos,
                'fondo_edit': {}
            },
            'form': {
                'cuenta_fondo': {
                    'id': '',
                    'id_fondo': '',
                    'cuenta': ''
                }
            },
            'guardando': false
        };
    },
    methods: {
        editar: function editar(fondo) {
            this.data.fondo_edit = fondo;
            Vue.set(this.form.cuenta_fondo, 'id_fondo', fondo.id_fondo);
            if (fondo.cuenta_fondo != null) {
                Vue.set(this.form.cuenta_fondo, 'cuenta', fondo.cuenta_fondo.cuenta);
                Vue.set(this.form.cuenta_fondo, 'id', fondo.cuenta_fondo.id);
            } else {
                Vue.set(this.form.cuenta_fondo, 'cuenta', '');
                Vue.set(this.form.cuenta_fondo, 'id', '');
            }
            this.validation_errors.clear('form_edit_cuenta');
            $('#edit_cuenta_modal').modal('show');
            $('#cuenta_contable').focus();
            this.validation_errors.clear('form_edit_cuenta');
        },
        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_save_cuenta') {
                    _this.confirm_save_cuenta();
                } else if (funcion == 'confirm_update_cuenta') {
                    _this.confirm_update_cuenta();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },
        confirm_update_cuenta: function confirm_update_cuenta() {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.update_cuenta();
                }
            });
        },

        update_cuenta: function update_cuenta() {
            var self = this;
            var url = this.url_cuenta_fondo_store + '/' + this.form.cuenta_fondo.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta_fondo.cuenta
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
                    }).then(function () {
                        self.data.fondo_edit.cuenta_fondo = data.data.cuenta_fondo;
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        confirm_save_cuenta: function confirm_save_cuenta() {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cuenta();
                }
            }).catch(swal.noop);
        },

        save_cuenta: function save_cuenta() {
            var self = this;
            var url = this.url_cuenta_fondo_store;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta_fondo.cuenta,
                    id_fondo: self.form.cuenta_fondo.id_fondo
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
                    }).then(function () {
                        self.data.fondo_edit.cuenta_fondo = data.data.cuenta_fondo;
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        close_edit_cuenta: function close_edit_cuenta() {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form.cuenta_fondo, 'cuenta', '');
            Vue.set(this.form.cuenta_fondo, 'id', '');
            Vue.set(this.form.cuenta_fondo, 'id_fondo', '');
        }
    }
});

},{}],19:[function(require,module,exports){
'use strict';

Vue.component('cuenta-material-index', {
    props: ['material_url', 'url_store_cuenta', 'datos_contables', 'tipos_cuenta_material'],
    data: function data() {
        return {
            materiales: [],
            form: {
                id_tipo_cuenta_material: '',
                tipo_material: '',
                material_edit: {},
                cuenta: '',
                material: '',
                id: '',

                id_material: ''
            },
            cargando: false
        };
    },

    directives: {
        treegrid: {
            inserted: function inserted(el) {
                $(el).treegrid({
                    saveState: true,
                    initialState: 'collapsed'
                });
            },
            componentUpdated: function componentUpdated(el) {
                $(el).treegrid({
                    saveState: true,
                    initialState: 'collapsed'
                });
            }
        },

        select2: {
            inserted: function inserted(el) {
                $(el).select2({
                    width: '100%'
                });
            }
        }
    },

    computed: {
        materiales_ordenados: function materiales_ordenados() {
            return this.materiales.sort(function (a, b) {
                return a.nivel > b.nivel ? 1 : b.nivel > a.nivel ? -1 : 0;
            });
        }
    },

    methods: {
        fetch_materiales: function fetch_materiales() {
            var self = this;
            $.ajax({
                type: 'GET',
                url: self.material_url + '/getFamiliasByTipo',
                data: {
                    tipo_material: self.form.tipo_material
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.materiales = data.data.materiales;
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        tr_class: function tr_class(material) {
            var treegrid = "treegrid-" + material.id_material;
            var treegrid_parent = material.id_padre != null ? " treegrid-parent-" + material.id_padre : "";
            return treegrid + treegrid_parent;
        },

        tr_id: function tr_id(material) {
            return material.id_padre == null || material.tiene_hijos > 0 ? "tnode-" + material.id_material : "";
        },

        get_hijos: function get_hijos(material) {
            var self = this;

            $.ajax({
                type: 'GET',
                url: self.material_url + '/' + material.id_material + '/getHijos',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(data, textStatus, xhr) {
                    data.data.materiales.forEach(function (material) {
                        self.materiales.push(material);
                    });
                    material.cargado = true;
                },
                complete: function complete() {
                    self.cargando = false;
                    setTimeout(function () {
                        $('#tnode-' + material.id_material).treegrid('expandRecursive');
                    }, 500);
                }
            });
        },

        edit_cuenta: function edit_cuenta(material) {
            this.form.material_edit = material;
            Vue.set(this.form, 'material', material.descripcion);
            Vue.set(this.form, 'id_material', material.id_material);
            if (material.cuenta_material != null) {
                Vue.set(this.form, 'cuenta', material.cuenta_material.cuenta);
                Vue.set(this.form, 'id', material.cuenta_material.id);
                Vue.set(this.form, 'id_tipo_cuenta_material', material.cuenta_material.id_tipo_cuenta_material);
            } else {
                Vue.set(this.form, 'cuenta', '');
                Vue.set(this.form, 'id', '');
                Vue.set(this.form, 'id_tipo_cuenta_material', '');
            }
            this.validation_errors.clear('form_edit_cuenta');
            $('#edit_cuenta_modal').modal('show');
            $('#cuenta_contable').focus();
            this.validation_errors.clear('form_edit_cuenta');
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_save_cuenta') {
                    _this.confirm_save_cuenta();
                } else if (funcion == 'confirm_update_cuenta') {
                    _this.confirm_update_cuenta();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirm_update_cuenta: function confirm_update_cuenta() {
            var self = this;
            swal({
                title: "Actualizar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.update_cuenta();
                }
            });
        },

        update_cuenta: function update_cuenta() {
            var self = this;
            var url = this.url_store_cuenta + '/' + this.form.id;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    cuenta: self.form.cuenta,
                    id_tipo_cuenta_material: self.form.id_tipo_cuenta_material
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
                    }).then(function () {
                        self.form.material_edit.cuenta_material = data.data.cuenta_material;
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        confirm_save_cuenta: function confirm_save_cuenta() {
            var self = this;
            swal({
                title: "Registrar Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cuenta();
                }
            }).catch(swal.noop);
        },

        save_cuenta: function save_cuenta() {
            var self = this;
            var url = this.url_store_cuenta;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta,
                    id_material: self.form.id_material,
                    id_tipo_cuenta_material: self.form.id_tipo_cuenta_material
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
                    }).then(function () {
                        self.form.material_edit.cuenta_material = data.data.cuenta_material;
                        self.close_edit_cuenta();
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        close_edit_cuenta: function close_edit_cuenta() {
            $('#edit_cuenta_modal').modal('hide');
            Vue.set(this.form, 'cuenta', '');
            Vue.set(this.form, 'material', '');
            Vue.set(this.form, 'id', '');
            Vue.set(this.form, 'id_tipo_cuenta_material', '');
            Vue.set(this.form, 'id_material', '');
        }
    }
});

},{}],20:[function(require,module,exports){
'use strict';

Vue.component('datos-contables-edit', {
    props: ['datos_contables', 'datos_contables_update_url', 'referencia'],
    data: function data() {
        return {
            'data': {
                'datos_contables': this.datos_contables
            },
            'guardando': false
        };
    },
    mounted: function mounted() {
        var self = this;

        // Iniciar evento al dar clic en un radio button
        $('.checkboxes').on('ifClicked', function (e) {
            var elem = $(this),
                value = self.toBoolean(elem.data('value')),
                name = elem.data('name'),
                substring = "si",
                id = elem.attr('id'),
                reference = '';

            switch (name) {
                case 'manejo':
                    reference = 'manejo_almacenes';
                    break;
                case 'gasto':
                    reference = 'costo_en_tipo_gasto';
                    break;
                case 'retencion_antes_iva':
                    reference = 'retencion_antes_iva';
                    break;
                case 'amortizacion_antes_iva':
                    reference = 'amortizacion_antes_iva';
                    break;
                case 'deductiva_antes_iva':
                    reference = 'deductiva_antes_iva';
                    break;
                default:
                    reference = '';
            }

            var contraparte = "#" + (id.indexOf(substring) !== -1 ? name + "_no" : name + "_si");
            var parent_elem = elem.parent();
            var parent_contraparte = $(contraparte).parent();

            parent_elem.addClass('iradio_square-blue').removeClass('iradio_square-grey');
            parent_contraparte.addClass('iradio_square-grey').removeClass('iradio_square-blue');
            elem.iCheck('check');
            $(contraparte).iCheck('uncheck');
            Vue.set(self.data.datos_contables, reference, value);
        });

        // Cambia el estilo a los elementos previamente seleccionados
        $('.checkboxes').each(function (index) {
            var elem = $(this);
            var parent = elem.parent();

            if (elem.is(':checked')) {
                parent.addClass('iradio_square-blue').removeClass('iradio_square-grey');
            }
        });

        $("ul.list-unstyled li").css({
            'font-size': '1.3em'
        });
        $("div.box-body > .alert-danger").css({
            'font-size': '1.3em'
        });
        $("div.iradio_square-blue, div.iradio_square-grey").css({
            'padding-left': '20px'
        });
    },
    created: function created() {
        // Convierte "0" y "1" en false y true respectivamente
        Vue.set(this.data.datos_contables, 'manejo_almacenes', this.toBoolean(this.data.datos_contables.manejo_almacenes));
        Vue.set(this.data.datos_contables, 'costo_en_tipo_gasto', this.toBoolean(this.data.datos_contables.costo_en_tipo_gasto));
        Vue.set(this.data.datos_contables, 'retencion_antes_iva', this.toBoolean(this.data.datos_contables.retencion_antes_iva));
        Vue.set(this.data.datos_contables, 'amortizacion_antes_iva', this.toBoolean(this.data.datos_contables.amortizacion_antes_iva));
        Vue.set(this.data.datos_contables, 'deductiva_antes_iva', this.toBoolean(this.data.datos_contables.deductiva_antes_iva));
    },
    directives: {
        icheck: {
            inserted: function inserted(el, binding, vnode) {
                var elem = $(el),
                    label = elem.next(),
                    label_text = label.text(),
                    vm = vnode.context;

                label.remove();
                elem.iCheck({
                    checkboxClass: 'icheckbox_square',
                    radioClass: 'iradio_square-blue'
                });
            }
        }
    },
    methods: {
        confirm_datos_obra: function confirm_datos_obra() {
            var self = this;
            swal({
                title: "Guardar Datos Contables de la Obra",
                html: "<div class=\"alert alert-danger\">\n" + "  <strong>Atención</strong> Una vez guardados los datos no va a ser posible editarlos" + "</div>" + "<div class=\"alert alert-warning\">\n" + "¿Estás seguro de que la información es correcta? " + "</div>",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_datos_obra();
                }
            });
        },

        save_datos_obra: function save_datos_obra() {
            var self = this;
            $.ajax({
                type: 'POST',
                url: self.datos_contables_update_url,
                data: {
                    BDContPaq: self.data.datos_contables.BDContPaq,
                    FormatoCuenta: self.data.datos_contables.FormatoCuenta,
                    NumobraContPaq: self.data.datos_contables.NumobraContPaq,
                    costo_en_tipo_gasto: self.data.datos_contables.costo_en_tipo_gasto,
                    retencion_antes_iva: self.data.datos_contables.retencion_antes_iva,
                    deductiva_antes_iva: self.data.datos_contables.deductiva_antes_iva,
                    amortizacion_antes_iva: self.data.datos_contables.amortizacion_antes_iva,
                    manejo_almacenes: self.data.datos_contables.manejo_almacenes,
                    _method: 'PATCH'
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Datos Contables de la Obra actualizados correctamente'
                    }).then(function () {
                        self.data.datos_contables = data.data.datos_contables;
                        Vue.set(self.data.datos_contables, 'costo_en_tipo_gasto', data.data.datos_contables.costo_en_tipo_gasto == 'true' ? true : false);
                        Vue.set(self.data.datos_contables, 'manejo_almacenes', data.data.datos_contables.manejo_almacenes == 'true' ? true : false);
                        Vue.set(self.data.datos_contables, 'retencion_antes_iva', data.data.datos_contables.retencion_antes_iva == 'true' ? true : false);
                        Vue.set(self.data.datos_contables, 'amortizacion_antes_iva', data.data.datos_contables.amortizacion_antes_iva == 'true' ? true : false);
                        Vue.set(self.data.datos_contables, 'deductiva_antes_iva', data.data.datos_contables.deductiva_antes_iva == 'true' ? true : false);
                    });

                    self.referencia = "1";

                    $('.checkboxes').each(function (index) {
                        var elem = $(this);
                        elem.iCheck('disable');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_datos_obra') {
                    _this.confirm_datos_obra();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },
        toBoolean: function toBoolean(sVar) {
            return Boolean(Number(sVar));
        },
        checkBox: function checkBox(toCheck, bVar) {
            toCheck = toCheck == null ? false : toCheck;

            return toCheck === bVar;
        },
        editando: function editando() {
            return this.toBoolean(this.referencia);
        },
        mostrar_mensaje: function mostrar_mensaje() {
            return this.editando() ? 'Los datos no pueden ser modificados porque ya han sido guardados previamente' : 'Una vez guardados los datos no va a ser posible editarlos';
        }
    }
});

},{}],21:[function(require,module,exports){
'use strict';

Vue.component('emails', {
    props: ['user', 'emails', 'notificacion_url', 'db', 'id_obra'],
    data: function data() {
        return {
            data: {
                emails: this.emails
            }
        };
    },

    created: function created() {
        var socket = io(App.socket_host);

        socket.on('emails-channel:Ghi\\Events\\NewEmail', function (data) {
            if (data.email.id_usuario == this.user.idusuario && data.db == this.db && data.email.id_obra == this.id_obra) {
                this.data.emails.push(data.email);
                $.notify({
                    // options
                    icon: 'fa fa-envelope-o fa-2x ',
                    title: data.email.titulo,
                    message: new Date(data.email.created_at).dateFormat(),
                    url: App.host + '/sistema_contable/notificacion/' + data.email.id
                }, {
                    // settings
                    type: 'warning',
                    newest_on_top: true,
                    placement: {
                        from: "bottom",
                        align: "right"
                    }
                });
            }
        }.bind(this));
    }
});

},{}],22:[function(require,module,exports){
'use strict';

Vue.component('revaluacion-create', {
    props: ['facturas', 'tipo_cambio', 'url_revaluacion', 'monedas', 'moneda'],
    data: function data() {
        return {
            data: {
                facturas: this.facturas,
                monedas: this.monedas,
                moneda: this.moneda
            },
            guardando: false
        };
    },
    mounted: function mounted() {
        var self = this;

        $(document).ready(function () {
            $("#select_moneda").change(function () {
                var moneda = $(this).val();
                window.location = App.host + '/sistema_contable/revaluacion/create/?id_moneda=' + moneda;
            });
        });
    },
    directives: {
        icheck: {
            inserted: function inserted(el) {
                $(el).iCheck({
                    checkboxClass: 'icheckbox_minimal-grey'
                });
            }
        }
    },
    methods: {
        confirm_save_facturas: function confirm_save_facturas() {
            var self = this;
            swal({
                title: "Guardar Revaluación",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_facturas();
                }
            });
        },
        save_facturas: function save_facturas() {
            var self = this;
            var url = this.url_revaluacion;
            var data = $('#form_facturas').serialize();
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Revaluación guardada correctamente'
                    }).then(function () {
                        window.location = xhr.getResponseHeader('Location');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_save_facturas') {
                    _this.confirm_save_facturas();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        }
    }
});

},{}],23:[function(require,module,exports){
'use strict';

Vue.component('poliza-generada-edit', {
    props: ['poliza', 'poliza_edit', 'datos_contables', 'url_cuenta_contable_findby', 'url_poliza_generada_update', 'tipo_cuenta_contable', 'cuentas_contables', 'movimientos_cta'],
    data: function data() {
        return {
            'data': {
                'poliza': this.poliza,
                'poliza_edit': this.poliza_edit,
                'cuentas_contables': this.cuentas_contables,
                'movimientos': this.movimientos_cta,
                'empresa': ''
            },
            'form': {
                'movimiento': {
                    'id_int_poliza': this.poliza.id_int_poliza,
                    'cuenta_contable': '',
                    'id_tipo_movimiento_poliza': '',
                    'importe': '',
                    'referencia': '',
                    'concepto': '',
                    'id_tipo_cuenta_contable': ''
                },
                'movimiento_cuenta': {
                    'id_int_poliza_movimiento': '',
                    'cuenta': ''
                }
            },
            'guardando': false
        };
    },

    mounted: function mounted() {
        var self = this;
        $("#fecha").datepicker().on("changeDate", function () {
            Vue.set(self.data.poliza_edit, 'fecha', $('#fecha').val());
        });
    },

    directives: {
        datepicker: {
            inserted: function inserted(el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        }
    },

    computed: {
        color: function color() {
            if (this.data.poliza.cuadrado) {
                return "bg-gray";
            } else {
                return "bg-red";
            }
        },

        cambio: function cambio() {
            return JSON.stringify(this.data.poliza) !== JSON.stringify(this.data.poliza_edit);
        },

        suma_haber: function suma_haber() {
            var suma_haber = 0;
            this.data.poliza_edit.poliza_movimientos.forEach(function (movimiento) {
                if (movimiento.id_tipo_movimiento_poliza == 2) {
                    suma_haber += parseFloat(movimiento.importe);
                }
            });
            return parseFloat(Math.round(suma_haber * 100) / 100).toFixed(2);
        },

        suma_debe: function suma_debe() {
            var suma_debe = 0;
            this.data.poliza_edit.poliza_movimientos.forEach(function (movimiento) {
                if (movimiento.id_tipo_movimiento_poliza == 1) {
                    suma_debe += parseFloat(movimiento.importe);
                }
            });
            return (Math.round(suma_debe * 100) / 100).toFixed(2);
        }
    },

    methods: {

        obtener_numero_cuenta: function obtener_numero_cuenta(idTipoCuenta) {
            var self = this;
            this.data.cuentas_contables.forEach(function (cuenta) {
                if (cuenta.id_int_tipo_cuenta_contable == idTipoCuenta) {
                    self.form.movimiento.cuenta_contable = cuenta.cuenta_contable;
                }
            });
            if (self.form.movimiento.cuenta_contable == 'NULL') {
                self.form.movimiento.cuenta_contable = '';
            }
        },

        show_add_movimiento: function show_add_movimiento() {
            this.validation_errors.clear('form_add_movimiento');
            $('#add_movimiento_modal').modal('show');
            this.validation_errors.clear('form_add_movimiento');
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_add_movimiento') {
                    _this.confirm_add_movimiento();
                } else if (funcion == 'confirm_save') {
                    _this.confirm_save();
                } else if (funcion == 'confirm_save_cuenta') {
                    _this.confirm_save_cuenta();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        close_add_movimiento: function close_add_movimiento() {
            $('#add_movimiento_modal').modal('hide');
            this.form.movimiento = {
                'id_int_poliza': this.poliza.id_int_poliza,
                'cuenta_contable': '',
                'id_tipo_movimiento_poliza': '',
                'importe': ''
            };
        },

        confirm_add_movimiento: function confirm_add_movimiento() {
            var self = this;
            swal({
                title: "Agregar Movimiento",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.add_movimiento();
                }
            });
        },

        add_movimiento: function add_movimiento() {
            var self = this;
            var url = this.url_cuenta_contable_findby;

            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    attribute: 'cuenta_contable',
                    value: self.form.movimiento.cuenta_contable,
                    with: 'tipoCuentaContable'
                },
                success: function success(data, textStatus, xhr) {
                    if (data.data.cuenta_contable) {
                        self.form.movimiento.id_tipo_cuenta_contable = data.data.cuenta_contable.id_int_tipo_cuenta_contable;
                        self.form.movimiento.id_cuenta_contable = data.data.cuenta_contable.id_int_cuenta_contable;
                        self.form.movimiento.descripcion_cuenta_contable = data.data.cuenta_contable.tipo_cuenta_contable.descripcion;
                    }
                },
                complete: function complete() {
                    self.data.poliza_edit.poliza_movimientos.push(self.form.movimiento);
                    self.close_add_movimiento();
                }
            });
        },

        confirm_remove_movimiento: function confirm_remove_movimiento(index) {
            var self = this;
            swal({
                title: "Quitar Movimiento",
                text: "¿Estás seguro de que deseas quitar el movimiento de la Prepóliza?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.remove_movimiento(index);
                }
            });
        },

        remove_movimiento: function remove_movimiento(index) {
            Vue.delete(this.data.poliza_edit.poliza_movimientos, index);
        },

        confirm_save: function confirm_save() {
            var self = this;
            swal({
                title: "Guardar Cambios de la Prepóliza",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save();
                }
            });
        },
        confirm_save_cuenta: function confirm_save_cuenta() {
            var self = this;
            swal({
                title: "Guardar Cambios de las cuentas faltantes",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_cuenta();
                }
            });
        },

        save: function save() {
            var self = this;

            Vue.set(this.data.poliza_edit, 'suma_haber', this.suma_haber);
            Vue.set(this.data.poliza_edit, 'suma_debe', this.suma_debe);

            $.ajax({
                type: 'POST',
                url: self.url_poliza_generada_update,
                data: {
                    _method: 'PATCH',
                    poliza_generada: self.data.poliza_edit
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: 'Prepóliza  <b>' + self.data.poliza_edit.transaccion_interfaz.descripcion + '</b> actualizada correctamente',
                        type: 'success',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = xhr.getResponseHeader('Location');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        ingresarCuenta: function ingresarCuenta(idPoliza) {
            var self = this;
            $.ajax({
                type: 'GET',
                url: App.host + "/sistema_contable/poliza_movimientos/" + idPoliza,
                data: {
                    id_poliza: idPoliza
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    if (self.data.movimientos.length > 0) {
                        self.data.empresa = self.data.movimientos[0].empresa_cadeco;
                        $('#add_cuenta_modal').modal('show');
                    } else {
                        swal({
                            title: "¡Información!",
                            text: "Las cuentas están completas.",
                            type: "info",
                            confirmButtonText: "Aceptar"
                        });
                    }
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        save_cuenta: function save_cuenta() {
            var self = this;
            $.ajax({
                type: 'POST',
                url: App.host + "/sistema_contable/poliza_movimientos/" + self.data.poliza.id_int_poliza,
                data: {
                    _method: 'PATCH',
                    data: self.data.movimientos,
                    validar: true
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    if (data.data.cambio) {
                        var datos = "";
                        for (var i = 0; i < data.data.cambio.length; i++) {
                            data.data.cambio[i];
                            datos += "<tr><td>" + data.data.cambio[i].tipo_cuenta_empresa.descripcion + "</td>";
                            datos += "<td>" + data.data.cambio[i].cuenta + "</td>";
                            datos += "<td>" + data.data.cambio[i].nuevo + "</td></tr>";
                        }
                        swal({
                            title: "Advertencia",
                            html: "El numero de cuenta que trata de ingresar no corresponde al actual" + "<table class='table table-striped small'>" + "   <thead>" + "   <tr>" + "       <th style='text-align: center'>Tipo de Cuenta Contable</th>" + "       <th style='text-align: center'>Actual</th>" + "       <th style='text-align: center'>Nuevo</th>" + "   </tr>" + "   </thead>" + "   <tbody>" + datos + "   </tbody>" + "</table>" + "<b>¿Deseas reemplazar la cuenta contable?</b><br>",
                            type: "warning",
                            showCancelButton: true,
                            cancelButtonText: 'No, Cancelar',
                            confirmButtonText: 'Si, Continuar'
                        }).then(function (result) {
                            if (result.value) {

                                $.ajax({
                                    type: 'POST',
                                    url: App.host + "/sistema_contable/poliza_movimientos/" + self.data.poliza.id_int_poliza,
                                    data: {
                                        _method: 'PATCH',
                                        data: self.data.movimientos,
                                        validar: false
                                    },
                                    beforeSend: function beforeSend() {
                                        self.guardando = true;
                                    },
                                    success: function success(data, textStatus, xhr) {
                                        self.data.poliza = data.data.poliza;
                                        swal({
                                            title: '¡Correcto!',
                                            html: 'Las cuentas se configurarón exitosamente',
                                            type: 'success',
                                            confirmButtonText: "Ok",
                                            closeOnConfirm: false
                                        }).then(function () {}).catch(swal.noop);
                                        window.location.reload(true);
                                        $('#add_cuenta_modal').modal('hide');
                                    },
                                    complete: function complete() {
                                        self.guardando = false;
                                    }
                                });
                            }
                        });
                    } else {

                        swal({
                            title: '¡Correcto!',
                            html: 'Las cuentas se configurarón exitosamente',
                            type: 'success',
                            confirmButtonText: "Ok",
                            closeOnConfirm: false
                        }).then(function () {
                            $('#add_cuenta_modal').modal('hide');
                            window.location.reload(true);
                        });
                    }
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        close_cuenta_modal: function close_cuenta_modal() {
            $('#add_cuenta_modal').modal('hide');
        }
    }
});

},{}],24:[function(require,module,exports){
'use strict';

Vue.component('poliza-generada-index', {
    props: ['editar_prepolizas_generadas'],
    data: function data() {
        return {};
    },

    mounted: function mounted() {
        var self = this;

        $("#fechas").daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Cancelar',
                applyLabel: 'Aplicar'
            }
        }).val('');

        $('#prepolizas_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "searching": true,
            "order": [[4, "desc"]],
            "searchDelay": 750,
            "ajax": {
                "url": App.host + '/sistema_contable/poliza_generada/paginate',
                "type": "POST",
                "beforeSend": function beforeSend() {
                    self.guardando = true;
                },
                "complete": function complete() {
                    self.guardando = false;
                },
                "data": function data(d) {
                    if ($("#fechas").val() != '') d.fechas = $("#fechas").val();
                    if ($("#tipo").val() != '') d.tipo = $("#tipo").val();
                    if ($("#estatus").val() != '') d.estatus = $("#estatus").val();
                },
                "dataSrc": function dataSrc(json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].index = i + 1;
                        json.data[i].total = '$ ' + parseFloat(json.data[i].total).formatMoney(2, '.', ',');
                        json.data[i].cuadre = '$ ' + parseFloat(json.data[i].cuadre).formatMoney(2, '.', ',');
                    }
                    return json.data;
                }
            },
            "columns": [{ data: 'index', 'searchable': false, orderable: false }, { data: 'transaccion_interfaz.descripcion', searchable: true }, { data: 'tipo_poliza_contpaq.descripcion', searchable: true }, { data: 'concepto', searchable: true }, { data: 'fecha', searchable: true }, { data: 'total', searchable: true, className: 'text-right' }, { data: 'cuadre', searchable: true, className: 'text-right' }, {
                data: 'estatus_prepoliza.descripcion',
                render: function render(data, type, row) {
                    return '<span class="label" style="background-color:' + row.estatus_prepoliza.label + '">' + row.estatus_prepoliza.descripcion + '</span>';
                },
                searchable: true
            }, { data: 'poliza_contpaq', searchable: true }, {
                data: {},
                render: function render(data, type, row) {
                    return '<a href="' + App.host + '/sistema_contable/poliza_generada/' + data.id_int_poliza + '" title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>' + (self.editar_prepolizas_generadas == true ? '<a href="' + App.host + '/sistema_contable/poliza_generada/' + data.id_int_poliza + '/edit' + '" title="Editar" class="btn btn-xs btn-info ' + (data.estatus == 2 ? 'disabled' : '') + '"><i class="fa fa-pencil"></i></a>' : '') + '<a href="' + App.host + '/sistema_contable/poliza_generada/' + data.id_int_poliza + '/historico' + '" title="Histórico" class="btn btn-xs btn-success ' + (data.historicos.length > 0 ? '' : 'disabled') + '"><i class="fa fa-clock-o"></i></a>';
                },
                searchable: false,
                orderable: false
            }],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    },

    methods: {
        consultar: function consultar() {
            var table = $('#prepolizas_table').DataTable();
            table.ajax.reload();
        }
    }

});

},{}],25:[function(require,module,exports){
'use strict';

Vue.component('poliza-tipo-create', {
    props: ['tipos_cuentas_contables', 'tipos_movimiento', 'polizas_tipo_sao'],
    data: function data() {
        return {
            'form': {
                'poliza_tipo': {
                    'id_poliza_tipo_sao': '',
                    'movimientos': [],
                    'inicio_vigencia': ''
                },
                'movimiento': {
                    'id_tipo_cuenta_contable': '',
                    'id_tipo_movimiento': ''
                },
                'errors': []
            },
            'guardando': false
        };
    },

    mounted: function mounted() {
        var self = this;
        $("#inicio_vigencia").datepicker().on("changeDate", function () {
            Vue.set(self.form.poliza_tipo, 'inicio_vigencia', $('#inicio_vigencia').val());
        });
    },

    computed: {
        check_movimientos: function check_movimientos() {
            var a = false;
            var b = false;
            this.form.poliza_tipo.movimientos.forEach(function (movimiento) {
                if (movimiento.id_tipo_movimiento == '1') {
                    a = true;
                } else if (movimiento.id_tipo_movimiento == '2') {
                    b = true;
                }
            });

            return a && b;
        },

        tipos_cuentas_contables_disponibles: function tipos_cuentas_contables_disponibles() {
            return this.tipos_cuentas_contables;
        }
    },

    directives: {
        datepicker: {
            inserted: function inserted(el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        }
    },

    methods: {
        show_add_movimiento: function show_add_movimiento() {
            this.validation_errors.clear('form_save_cuenta');
            $('#modal-add-movimiento').modal('show');
            this.validation_errors.clear('form_save_cuenta');
        },

        close_add_movimiento: function close_add_movimiento() {
            $('#modal-add-movimiento').modal('hide');
            this.reset_movimiento();
        },

        add_movimiento: function add_movimiento() {
            var id_tipo_cuenta_contable = $('#id_tipo_cuenta_contable').val();
            var id_tipo_movimiento = $('#id_tipo_movimiento').val();

            this.form.poliza_tipo.movimientos.push({
                id_tipo_cuenta_contable: id_tipo_cuenta_contable,
                id_tipo_movimiento: id_tipo_movimiento
            });
            this.reset_movimiento();
            this.validation_errors.clear('form_save_cuenta');
            $('#modal-add-movimiento').modal('hide');
            this.validation_errors.clear('form_save_cuenta');
        },

        reset_movimiento: function reset_movimiento() {
            Vue.set(this.form.movimiento, 'id_tipo_cuenta_contable', '');
            Vue.set(this.form.movimiento, 'id_tipo_movimiento', '');
        },

        check_duplicity: function check_duplicity() {
            var self = this;
            var id = self.form.poliza_tipo.id_poliza_tipo_sao;
            var url = App.host + '/sistema_contable/poliza_tipo/findBy';
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    'attribute': 'id_poliza_tipo_sao',
                    'value': id,
                    'with': 'movimientos'
                },
                success: function success(response) {
                    if (response.data.poliza_tipo != null) {
                        var body = "";
                        $.each(response.data.poliza_tipo.movimientos, function (index, movimiento) {
                            body += "<tr><td>" + (index + 1) + "</td><td style='text-align: left'>" + self.getTipoCuentaDescription(movimiento.id_tipo_cuenta_contable) + "</td><td>" + self.tipos_movimiento[movimiento.id_tipo_movimiento] + "</td></tr>";
                        });

                        swal({
                            title: "Advertencia",
                            html: "Ya existe una Plantilla para el tipo de Póliza seleccionado con un estado <b>" + response.data.poliza_tipo.vigencia + "</b><br>" + "Con un inicio de vigencia el día <b>" + response.data.poliza_tipo.inicio_vigencia.split(" ")[0] + "</b><br><br>" + "<table class='table table-striped small'>" + "   <thead>" + "   <tr>" + "       <th style='text-align: center'>#</th>" + "       <th style='text-align: center'>Tipo de Cuenta Contable</th>" + "       <th style='text-align: center'>Tipo</th>" + "   </tr>" + "   </thead>" + "   <tbody>" + body + "   </tbody>" + "</table>" + "<b>¿Deseas continuar con el registro?</b><br>" + "<small><small>(Se establecerá el fin de vigencia para la plantilla existente)</small></small>",
                            type: "warning",
                            showCancelButton: true,
                            cancelButtonText: 'No, Cancelar',
                            confirmButtonText: 'Si, Continuar'

                        }).then(function (result) {
                            if (result.value) {
                                self.confirm_save();
                            }
                        });
                    } else {
                        self.confirm_save();
                    }
                }
            });
        },

        confirm_save: function confirm_save() {
            var self = this;
            swal({
                title: "Guardar Plantilla",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save();
                }
            });
        },

        save: function save() {
            var self = this;
            var url = App.host + '/sistema_contable/poliza_tipo';
            var data = self.form.poliza_tipo;

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: "Se ha creado la plantilla para el Tipo de Póliza<br>" + "<b>" + self.polizas_tipo_sao[self.form.poliza_tipo.id_poliza_tipo_sao] + "</b>",
                        type: "success"
                    }).then(function () {
                        window.location = xhr.getResponseHeader('Location');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        remove_movimiento: function remove_movimiento(e) {
            Vue.delete(this.form.poliza_tipo.movimientos, e);
        },

        getTipoCuentaDescription: function getTipoCuentaDescription(id) {
            var result = "";
            $.each(this.tipos_cuentas_contables, function (index, tipo_cuenta_contable) {
                if (tipo_cuenta_contable.id_tipo_cuenta_contable == id) {
                    result = tipo_cuenta_contable.descripcion;
                }
            });
            return result;
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_cuenta') {
                    _this.add_movimiento();
                } else if (funcion == 'save') {
                    _this.check_duplicity();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        }
    }
});

},{}],26:[function(require,module,exports){
'use strict';

/**
 * Created by LERDES2 on 23/06/2017.
 */

Vue.component('tipo-cuenta-contable-create', {
    data: function data() {
        return {
            'form': {
                'tipo_cuenta_contable': {
                    'descripcion': '',
                    'id_naturaleza_poliza': ''
                }
            },
            'guardando': false
        };
    },

    methods: {
        confirm_save: function confirm_save() {
            var self = this;
            swal({
                title: "Guardar Tipo Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save();
                }
            });
        },

        save: function save() {

            var self = this;
            var url = App.host + '/sistema_contable/tipo_cuenta_contable';
            var data = self.form.tipo_cuenta_contable;

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: "Se ha creado el Tipo de Cuenta Contable con éxito",
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = xhr.getResponseHeader('Location');
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        }
    }

});

},{}],27:[function(require,module,exports){
'use strict';

/**
 * Created by LERDES2 on 23/06/2017.
 */

Vue.component('tipo-cuenta-contable-update', {
    props: ['tipo_cuenta_contable'],
    data: function data() {
        return {
            'form': {
                'tipo_cuenta_contable': {
                    'id_tipo_cuenta_contable': this.tipo_cuenta_contable.id_tipo_cuenta_contable,
                    'descripcion': this.tipo_cuenta_contable.descripcion,
                    'id_naturaleza_poliza': this.tipo_cuenta_contable.id_naturaleza_poliza
                }
            },
            'guardando': false
        };
    },

    methods: {
        confirm_save: function confirm_save() {
            var self = this;
            swal({
                title: "Actualizar Tipo Cuenta Contable",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save();
                }
            });
        },

        save: function save() {

            var self = this;
            var url = App.host + '/sistema_contable/tipo_cuenta_contable/' + self.form.tipo_cuenta_contable.id_tipo_cuenta_contable;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _method: 'PATCH',
                    id_naturaleza_poliza: self.form.tipo_cuenta_contable.id_naturaleza_poliza
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: "Se ha actualizado el Tipo de Cuenta Contable con éxito",
                        type: "success",
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = App.host + '/sistema_contable/tipo_cuenta_contable/' + data.data.tipo_cuenta_contable.id_tipo_cuenta_contable;
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        }
    }

});

},{}],28:[function(require,module,exports){
'use strict';

Vue.component('reclasificacion_costos-index', {
    props: ['repetidas', 'solicitar_reclasificacion', 'consultar_reclasificacion', 'autorizar_reclasificacion'],
    data: function data() {
        return {
            'solicitudes': [],
            'partidas': [],
            'guardando': false,
            'editando': false,
            'item': { 'id': 0, 'created_at': '', 'estatus_desc': '', 'estatus_string': {}, 'estatus': {} },
            'rechazando': false,
            'rechazo_motivo': '',
            'dataTable': false,
            'show_pdf': false
        };
    },
    computed: {},
    mounted: function mounted() {
        var self = this;

        $(document).on('click', '.btn_abrir', function () {
            var _this = $(this),
                editando = !!parseInt(_this.data('editando')),
                item = self.solicitudes[_this.data('row')],
                partidas = item.partidas;

            self.item = { 'id': 0, 'created_at': '', 'estatus_desc': '', 'estatus_string': {}, 'estatus': {} };

            item.estatus_desc = item.estatus_string.descripcion;
            self.partidas = partidas;
            self.item = item;

            if (editando) {
                self.editando = item;
            }

            $('#solicitud_detalles_modal').modal('show');
        });

        self.dataTable = $('#solicitudes_table').DataTable({
            "createdRow": function createdRow(row, data, dataIndex) {

                var $row = $(row),
                    repetidas = self.repetidas.length > 0 ? JSON.parse(self.repetidas) : [];

                $row.attr('id', 'solicitud_' + data.id);
                console.log(repetidas.indexOf(data.id));

                if (repetidas.indexOf(data.id) > 0) {
                    $row.find('td:nth-child(5)').append(' <span class="label label-danger">Repetida</span>');
                }
            },
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "searching": false,
            "ajax": {
                "url": App.host + '/control_costos/solicitudes_reclasificacion/paginate',
                "type": "GET",
                "beforeSend": function beforeSend() {
                    self.guardando = true;
                },
                "complete": function complete() {
                    self.guardando = false;
                },
                "dataSrc": function dataSrc(json) {
                    self.solicitudes = json.data;
                    return json.data;
                }
            },
            "columns": [{
                data: {},
                render: function render(data, type, row, meta) {
                    return meta.row + 1;
                }
            }, {
                data: 'id',
                render: function render(data, type, row) {
                    return '#' + row.id;
                }
            }, {
                data: 'fecha',
                render: function render(data, type, row) {
                    return new Date(row.fecha ? row.fecha : row.created_at).dateShortFormat();
                }
            }, {
                data: 'motivo',
                render: function render(data, type, row) {
                    return row.motivo.replace(/'/g, "\\'");
                }
            }, {
                data: 'estatusString',
                render: function render(data, type, row) {
                    var _estatus = '';

                    if (row.estatus_string.estatus == 2) _estatus = '<span class="label bg-green">' + row.estatus_string.descripcion + '</span> ';else if (row.estatus_string.estatus == -1) _estatus = '<span class="label bg-red">' + row.estatus_string.descripcion + '</span> ';else _estatus = '<span class="label bg-blue">' + row.estatus_string.descripcion + '</span> ';

                    return _estatus;
                }
            }, {
                data: 'acciones',
                render: function render(data, type, row, meta) {
                    var _return = "<button type='button' title='Ver' class='btn btn-xs btn-success btn_abrir' data-row='" + meta.row + "' data-editando='0'><i class='fa fa-eye'></i></button>";

                    // Muestra el botón de editar si la solicitud aún no está autorizada/rechazada
                    if (row.estatus_string.id == 1 && self.autorizar_reclasificacion) {
                        _return = _return + " <button type='button' title='Editar' class='btn btn-xs btn-info btn_abrir' data-row='" + meta.row + "' data-editando='1'><i class='fa fa-pencil'></i></button>";
                    }

                    return _return;
                }
            }],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    },
    directives: {},
    methods: {
        close_modal_detalles: function close_modal_detalles() {
            var self = this;

            $('#solicitud_detalles_modal').modal('hide');

            // reset partidas
            self.partidas = [];
            self.editando = false;
            self.rechazando = false;
            self.rechazo_motivo = '';
            self.show_pdf = false;
        },
        confirm: function confirm(tipo) {
            var self = this;

            // Manda error si no hay una solicitud para aprobar/rechazar
            if (self.editando.length > 0) return swal({
                type: 'warning',
                title: 'Error',
                text: 'La solicitud está vacía'
            });

            // Al rechazar debe de haber un motivo
            if (tipo == 'rechazar' && self.rechazo_motivo == '') return swal({
                type: 'warning',
                title: 'Error',
                text: 'Debes de especificar un motivo para rechazar'
            });

            swal({
                title: tipo.mayusculaPrimerLetra(),
                text: "¿Estás seguro/a de que deseas " + tipo + " esta solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    if (tipo == "aprobar") {
                        self.aprobar();
                    } else if (tipo == "rechazar") {
                        self.rechazar();
                    }
                }
            }).catch(swal.noop);
        },
        aprobar: function aprobar() {
            var self = this,
                str = { 'data': JSON.stringify(self.editando), 'tipo': 'aprobar' };

            $.ajax({
                type: 'POST',
                url: App.host + '/control_costos/solicitudes_reclasificacion/store',
                data: str,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    if (data.resultado) self.dataTable.ajax.reload(function () {
                        swal({
                            type: 'success',
                            title: '',
                            html: 'La solicitud fué autorizada'
                        });
                    });else swal({
                        type: 'warning',
                        title: '',
                        html: 'La operación no pudo concretarse'
                    });

                    self.close_modal_detalles();
                },
                complete: function complete() {}
            });
        },
        rechazar: function rechazar() {
            var self = this,
                str = { 'data': JSON.stringify(self.editando), 'tipo': 'rechazar', 'motivo': self.rechazo_motivo };

            $.ajax({
                type: 'POST',
                url: App.host + '/control_costos/solicitudes_reclasificacion/store',
                data: str,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    if (data.resultado) self.dataTable.ajax.reload(function () {
                        swal({
                            type: 'success',
                            title: '',
                            html: 'La solicitud fué rechazada'
                        });
                    });else swal({
                        type: 'warning',
                        title: '',
                        html: 'La operación no pudo concretarse'
                    });

                    self.close_modal_detalles();
                },
                complete: function complete() {}
            });
        },
        rechazar_motivo: function rechazar_motivo() {

            var self = this;

            self.rechazando = true;
        },
        cancelar_rechazo: function cancelar_rechazo() {
            var self = this;

            self.rechazando = false;
            self.rechazo_motivo = '';
        },
        pdf: function pdf(id) {
            var self = this,
                url = App.host + '/control_costos/solicitudes_reclasificacion/generarpdf/' + id;

            self.show_pdf = url;
        },
        html_decode: function html_decode(input) {
            var e = document.createElement('div');
            e.innerHTML = input;

            return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
        }
    }
});

},{}],29:[function(require,module,exports){
'use strict';

Vue.component('solicitar_reclasificacion-index', {
    props: ['url_solicitar_reclasificacion_index', 'max_niveles', 'filtros', 'operadores', 'tipos_transacciones', 'solicitar_reclasificacion', 'consultar_reclasificacion', 'autorizar_reclasificacion'],
    data: function data() {
        return {
            'data': {
                'condicionante': '',
                'temp_filtro': '',
                'filtros': this.filtros,
                'operadores': this.operadores,
                'agrega': {
                    'nivel': '',
                    'operador': '',
                    'texto': ''
                },
                filtro_tran: {
                    'tipo': '',
                    'folio': ''
                },
                'resultados': [],
                'resumen': [],
                'detalles': [],
                'desglosar_descripcion': '',
                'subtotal': 0,
                'subimporte': 0,
                'total_resultados': 0,
                'desglosar': [],
                'loading': false
            }
        };
    },
    computed: {
        niveles: function niveles() {
            var self = this,
                niveles = [],
                paso = 1;

            for (paso; paso <= self.max_niveles; paso++) {
                niveles.push({ numero: paso, nombre: "Nivel " + paso });
            }

            return niveles;
        },
        niveles_n: function niveles_n() {
            var result = 0;
            this.data.resultados.forEach(function (t) {
                var cont = Object.keys(t).filter(function (t2) {
                    return t[t2] != null;
                });
                if (cont.length - 3 > result) {
                    result = cont.length - 3;
                }
            });

            return result;
        }
    },
    methods: {
        agregar_filtro: function agregar_filtro() {
            var self = this,
                vacios = [],
                temp = [];

            // Los campos  no puedene star vacios
            $.each(self.data.agrega, function (index, value) {
                if (value === "") {
                    vacios.push(index);
                }
            });

            // Manda error si están vacios
            if (vacios.length > 0) {
                return swal({
                    type: 'warning',
                    title: 'Los siguientes campos no pueden estar vacios:',
                    html: '<ul class="list-group"><li class="list-group-item list-group-item-danger">' + vacios.join("<li class=\"list-group-item list-group-item-danger\">") + '</ul>'
                });
            }

            if (self.data.condicionante.length > 0) {
                temp = self.data.temp_filtro;
                self.data.temp_filtro.condicionante = self.data.condicionante;
                Vue.set(self.data.filtros, self.data.filtros.indexOf(temp), self.data.temp_filtro);
            }

            self.filtros.push(self.data.agrega);

            self.close_modal_agregar();
        },
        eliminar_filtro: function eliminar_filtro(index) {
            var self = this,
                anterior_index = index - 1,
                anterior = self.data.filtros[anterior_index];

            if (anterior_index >= 0 && anterior.condicionante != null) {
                var anterior = self.data.filtros[anterior_index];

                delete anterior.condicionante;

                Vue.set(self.data.filtros, anterior_index, anterior);
            }

            self.data.filtros.splice(index, 1);
        },
        reset_agregar: function reset_agregar() {
            var self = this;

            Vue.set(self.data, 'agrega', {
                'nivel': '',
                'operador': '',
                'texto': ''
            });

            Vue.set(self.data, 'temp_filtro', '');
            Vue.set(self.data, 'condicionante', '');
        },
        open_modal_transaccion: function open_modal_transaccion() {

            $('#transaccion_filtro_modal').modal('show');
            $('#transaccion').focus();
        },
        close_modal_transaccion: function close_modal_transaccion() {

            var self = this;

            Vue.set(self.data, 'filtro_tran', {
                'tipo': '',
                'folio': ''
            });

            $('#transaccion_filtro_modal').modal('hide');
        },
        agregar_filtro_tran: function agregar_filtro_tran() {
            var self = this,
                str = { 'data': JSON.stringify(self.data.filtro_tran) },
                total_resultados = 0,
                subtotal = 0,
                subimporte = 0;

            if (self.data.filtro_tran.tipo.length == 0) {
                return swal({
                    type: 'warning',
                    title: 'Agrega un filtro',
                    html: 'Por favor agrega un filtro antes de buscar'
                });
            }

            $.ajax({
                type: 'GET',
                url: self.url_solicitar_reclasificacion_index + '/findtransaccion',
                data: str,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    if (data.detalles.length != 0) swal({
                        type: 'success',
                        title: '¡Se encontraron resultados!',
                        html: '',
                        onClose: function onClose() {

                            $.each(data.resumen, function (key, value) {
                                subtotal = subtotal + parseInt(value.cantidad);
                                subimporte = subimporte + parseInt(value.monto);
                            });

                            Vue.set(self.data, 'subtotal', subtotal);
                            Vue.set(self.data, 'subimporte', subimporte);
                            Vue.set(self.data, 'desglosar_descripcion', data.detalles[0].descripcion);
                            Vue.set(self.data, 'desglosar', data.detalles);
                            Vue.set(self.data, 'resumen', data.resumen);
                            Vue.set(self.data, 'detalles', data.detalles);
                            $('#tipos_transaccion').modal('show');
                            self.close_modal_transaccion();
                        }
                    });else swal({
                        type: 'warning',
                        title: 'No se encontraron resultados',
                        html: ''
                    });
                },
                complete: function complete() {}
            });
        },
        open_modal_agregar: function open_modal_agregar(condicionante, item) {
            var self = this;

            if (condicionante) {
                self.data.condicionante = condicionante;
                self.data.temp_filtro = item;
            }

            $('#agregar_filtro_modal').modal('show');
            $('#nivel').focus();
        },
        close_modal_agregar: function close_modal_agregar() {
            var self = this;

            $('#agregar_filtro_modal').modal('hide');
            self.close_modal_transaccion();
            self.reset_agregar();
        },
        buscar: function buscar() {
            var self = this,
                str = { 'data': JSON.stringify(self.data.filtros) },
                total_resultados = 0;

            Vue.set(self.data, 'total_resultados', 0);

            if (self.data.filtros.length == 0) {
                return swal({
                    type: 'warning',
                    title: 'Agrega un filtro',
                    html: 'Por favor agrega un filtro antes de buscar'
                });
            }

            $.ajax({
                type: 'GET',
                url: self.url_solicitar_reclasificacion_index + '/findmovimiento',
                data: str,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    if (data.data.resultados.length > 0) {
                        $.each(data.data.resultados, function (key, value) {
                            total_resultados = total_resultados + parseInt(value.total);
                        });

                        Vue.set(self.data, 'total_resultados', parseInt(total_resultados).formatMoney(2, '.', ','));
                        Vue.set(self.data, 'resultados', data.data.resultados);
                        swal({
                            type: 'success',
                            title: '',
                            html: 'Se encontraron resultados'
                        });
                    } else {
                        swal({
                            type: 'warning',
                            title: '',
                            html: 'No se encontraron resultados'
                        });
                    }
                },
                complete: function complete() {}
            });
        },
        confirm_eliminar: function confirm_eliminar(index, tipo) {
            var self = this;
            swal({
                title: "Eliminar " + tipo,
                text: "¿Estás seguro/a de que deseas eliminar este " + tipo + "?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    if (tipo == "resultado") {
                        self.eliminar_resultado(index);
                    } else if (tipo == "filtro") {
                        self.eliminar_filtro(index);
                    }
                }
            }).catch(swal.noop);
        },
        eliminar_resultado: function eliminar_resultado(index) {
            var self = this;

            self.data.resultados.splice(index, 1);
        },
        confirm_solicitar: function confirm_solicitar(item) {
            var self = this;
            swal({
                title: "Solicitar reclasificación",
                text: "¿Estás seguro/a de querer solicitar esta reclasificación?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.solicitar(item);
                }
            }).catch(swal.noop);
        },
        solicitar: function solicitar(item) {
            var self = this;

            $.ajax({
                type: 'POST',
                url: self.url_solicitar_reclasificacion_index,
                data: item,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {

                    var new_item = item;

                    // marcar el item como "enviado" y no dejar que se envie de nuevo
                    Vue.set(new_item, 'solicitado', 1);
                    Vue.set(self.data.resultados, self.data.resultados.indexOf(item), new_item);

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Solicitud enviada correctamente'
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        open_modal_tipos_transaccion: function open_modal_tipos_transaccion(id_concepto) {
            var self = this,
                subtotal = 0,
                subimporte = 0;

            Vue.set(self.data, 'subtotal', 0);
            Vue.set(self.data, 'subimporte', 0);
            Vue.set(self.data, 'resumen', []);
            Vue.set(self.data, 'detalles', []);

            $.ajax({
                type: 'GET',
                url: self.url_solicitar_reclasificacion_index + '/tipos',
                data: { id_concepto: id_concepto },
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {
                    if (data.resumen) {
                        $.each(data.resumen, function (key, value) {
                            subtotal = subtotal + parseInt(value.cantidad);
                            subimporte = subimporte + parseInt(value.monto);
                        });

                        Vue.set(self.data, 'subtotal', subtotal);
                        Vue.set(self.data, 'subimporte', subimporte);
                        Vue.set(self.data, 'resumen', data.resumen);
                        Vue.set(self.data, 'detalles', data.detalles);
                        $('#tipos_transaccion').modal('show');
                    } else {
                        swal({
                            type: 'warning',
                            title: '',
                            html: 'No se encontraron resultados'
                        });
                    }
                },
                complete: function complete() {}
            });
        },
        close_modal_tipos_transaccion: function close_modal_tipos_transaccion() {
            var self = this;

            Vue.set(self.data, 'desglosar', []);
            Vue.set(self.data, 'resumen', []);
            $('#tipos_transaccion').modal('hide');
        },
        clean_desglosar: function clean_desglosar() {
            var self = this;

            Vue.set(self.data, 'desglosar', []);
            Vue.set(self.data, 'desglosar_descripcion', '');
        },
        desglosar_tipos: function desglosar_tipos(tipo_transaccion, opciones) {
            var self = this,
                filtrado = [];

            self.clean_desglosar();

            // Muestra detalles de acuerdo al tipo de transaccion
            if (tipo_transaccion && opciones) {
                filtrado = self.data.detalles.filter(function (e) {
                    return e.descripcion == tipo_transaccion && e.opciones == opciones;
                });
            } else filtrado = self.data.detalles;

            Vue.set(self.data, 'desglosar', filtrado);
            Vue.set(self.data, 'desglosar_descripcion', tipo_transaccion);
        },
        mostrar_items: function mostrar_items(id_transaccion, id_concepto) {
            var self = this;

            swal({
                title: "Mostrar items",
                text: "¿Estás seguro/a de querer mostrar los items para esta transacción? Se abrirá una nueva pantalla",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    window.location.href = self.url_solicitar_reclasificacion_index + '/items/' + id_concepto + '/' + id_transaccion;
                }
            }).catch(swal.noop);
        }
    },
    directives: {}
});

},{}],30:[function(require,module,exports){
'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

Vue.component('solicitar_reclasificacion-items', {
    props: ['url_solicitar_reclasificacion_index', 'id_transaccion', 'id_concepto_antiguo', 'items', 'max_niveles', 'filtros', 'operadores', 'solicitar_reclasificacion', 'consultar_reclasificacion', 'autorizar_reclasificacion'],
    data: function data() {
        return {
            'data': {
                'items': this.items,
                'filtros': this.filtros,
                'operadores': this.operadores,
                'agrega': {
                    'nivel': '',
                    'operador': '',
                    'texto': ''
                },
                'resultados': [],
                'subtotal': 0,
                'subimporte': 0,
                'total_resultados': 0,
                'temp_index': false,
                'id_concepto_antiguo': false,
                'solicitudes': [],
                'motivo': '',
                'fecha': moment().format('YYYY-MM-DD'),
                'solicitud': {},
                'show_pdf': false,
                'editando': false,
                'rechazando': false,
                'rechazo_motivo': ''
            }
        };
    },
    computed: {
        niveles: function niveles() {
            var self = this,
                niveles = [],
                paso = 1;

            for (paso; paso <= self.max_niveles; paso++) {
                niveles.push({ numero: paso, nombre: "Nivel " + paso });
            }

            return niveles;
        },
        niveles_n: function niveles_n() {
            var result = 0;
            this.data.resultados.forEach(function (t) {
                var cont = Object.keys(t).filter(function (t2) {
                    return t[t2] != null;
                });
                if (cont.length - 2 > result) {
                    result = cont.length - 2;
                }
            });

            return result;
        }
    },
    mounted: function mounted() {
        var self = this;

        $("#Fecha").datepicker().on("changeDate", function () {
            var thisElement = $(this);

            Vue.set(self.data, 'fecha', thisElement.val());
        });

        $(document).on('click', '.mostrar_solicitud', function () {
            var _this = $(this);

            $.ajax({
                type: 'GET',
                url: App.host + '/control_costos/solicitar_reclasificacion/single/' + _this.data('id'),
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    if (data.solicitud) {
                        Vue.set(self.data, 'solicitud', data.solicitud);
                        $('#solicitud_detalles_modal').modal('show');
                    } else swal({
                        type: 'warning',
                        title: '',
                        html: 'No existe la solicitud'
                    });
                },
                complete: function complete() {}
            });
        });
    },
    directives: {
        datepicker: {
            inserted: function inserted(el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        }
    },
    methods: _defineProperty({
        agregar_filtro: function agregar_filtro() {
            var self = this,
                vacios = [],
                temp = [];

            // Los campos  no puedene star vacios
            $.each(self.data.agrega, function (index, value) {
                if (value === "") {
                    vacios.push(index);
                }
            });

            // Manda error si están vacios
            if (vacios.length > 0) return swal({
                type: 'warning',
                title: 'Los siguientes campos no pueden estar vacios:',
                html: '<ul class="list-group"><li class="list-group-item list-group-item-danger">' + vacios.join("<li class=\"list-group-item list-group-item-danger\">") + '</ul>'
            });

            self.data.filtros.push(self.data.agrega);

            self.data.agrega = {
                'nivel': '',
                'operador': '',
                'texto': ''
            };
        },
        buscar: function buscar() {
            var self = this,
                str = { 'data': JSON.stringify(self.data.filtros) },
                total_resultados = 0;

            Vue.set(self.data, 'total_resultados', 0);

            if (self.data.filtros.length == 0) {
                return swal({
                    type: 'warning',
                    title: 'Agrega un filtro',
                    html: 'Por favor agrega un filtro antes de buscar'
                });
            }

            $.ajax({
                type: 'GET',
                url: self.url_solicitar_reclasificacion_index + '/find',
                data: str,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    if (data.data.resultados.length > 0) {
                        $.each(data.data.resultados, function (key, value) {
                            total_resultados = total_resultados + parseInt(value.total);
                        });

                        Vue.set(self.data, 'total_resultados', parseInt(total_resultados).formatMoney(2, '.', ','));
                        Vue.set(self.data, 'resultados', data.data.resultados);
                        swal({
                            type: 'success',
                            title: '',
                            html: 'Se encontraron resultados'
                        });
                    } else {
                        swal({
                            type: 'warning',
                            title: '',
                            html: 'No se encontraron resultados'
                        });
                    }
                },
                complete: function complete() {}
            });
        },
        confirm_eliminar: function confirm_eliminar(index, tipo) {
            var self = this;
            swal({
                title: "Eliminar " + tipo,
                text: "¿Estás seguro/a de que deseas eliminar este " + tipo + "?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    if (tipo == "resultado") {
                        self.eliminar_resultado(index);
                    } else if (tipo == "filtro") {
                        self.eliminar_filtro(index);
                    }
                }
            }).catch(swal.noop);
        },
        eliminar_resultado: function eliminar_resultado(index) {
            var self = this;

            self.data.resultados.splice(index, 1);
        },
        eliminar_filtro: function eliminar_filtro(index) {
            var self = this;

            self.data.filtros.splice(index, 1);

            if (self.data.filtros.length == 0) {
                self.reset_agregar();
            }
        },
        reset_agregar: function reset_agregar() {
            var self = this;

            Vue.set(self.data, 'agrega', {
                'nivel': '',
                'operador': '',
                'texto': ''
            });

            self.active_item();
            Vue.set(self.data, 'resultados', []);
            Vue.set(self.data, 'filtros', []);
            Vue.set(self.data, 'total_resultados', 0);
            Vue.set(self.data, 'id_concepto_antiguo', false);
        },
        active_item: function active_item() {
            var self = this;
        },
        open_modal_agregar: function open_modal_agregar(item, index) {
            var self = this;

            Vue.set(self.data, 'temp_index', index);
            Vue.set(self.data, 'id_concepto_antiguo', item.id_concepto);

            $('#agregar_filtro_modal').modal('show');
            $('#nivel').focus();

            self.active_item();
        },
        close_modal_agregar: function close_modal_agregar() {
            var self = this;

            $('#agregar_filtro_modal').modal('hide');

            self.reset_agregar();
        },
        aplicar: function aplicar(item) {
            var self = this;

            Vue.set(self.data.items[self.data.temp_index], 'destino_final', item['filtro' + self.niveles_n]);
            Vue.set(self.data.items[self.data.temp_index], 'id_concepto_nuevo', item['id_concepto']);

            self.data.solicitudes.push(self.data.items[self.data.temp_index]);

            this.close_modal_agregar();
        },
        confirm_solicitar: function confirm_solicitar() {
            var self = this;

            // Se debe de haber seleccionado un nuevo concepto
            if (self.data.solicitudes.length == 0) return swal({
                type: 'warning',
                title: 'Agrega un nuevo concepto',
                html: 'Por favor agrega un nuevo concepto antes de solicitar'
            });

            if (self.data.motivo == '') return swal({
                type: 'warning',
                title: 'Especifica un motivo',
                html: 'Por favor especifica un motivo antes de solicitar'
            });

            swal({
                title: "Aplicar conceptos",
                text: "¿Estás seguro/a de que deseas aplicar estos conceptos?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.solicitar();
                }
            }).catch(swal.noop);
        },
        solicitar: function solicitar() {
            var self = this,
                temp_fecha = self.data.fecha;

            $.ajax({
                type: 'POST',
                url: self.url_solicitar_reclasificacion_index,
                data: {
                    'motivo': self.data.motivo,
                    'solicitudes': self.data.solicitudes,
                    'fecha': self.data.fecha
                },
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    var repetidas = [],
                        lista = [];

                    // Ya existe al menos una partida registrada
                    if (_typeof(data.repetidas) == 'object') {
                        $.each(data.repetidas, function (key, value) {
                            repetidas.push(value.id);
                            lista.push('<li class="list-group-item "><a href="#" onclick="swal.close();" class="mostrar_solicitud" data-id="' + value.id + '">#' + value.id + ' ' + (value.motivo.length >= 20 ? self.html_decode(value.motivo.substring(0, 30) + '...') : self.html_decode(value.motivo)) + '</a></li>');
                        });

                        var texto = data.repetidas.length > 1 ? 'Ya existen solicitudes pendientes de autorización' : 'Ya existe una solicitud pendiente de autorización';

                        swal({
                            title: texto + " con los items seleccionados",
                            html: '<ul class="list-group">' + lista.join(' ') + '</ul>',
                            type: "warning",
                            showCancelButton: true,
                            showConfirmButton: true,
                            cancelButtonText: "Cancelar"
                        });

                        return;
                    } else swal({
                        type: 'success',
                        title: '',
                        html: 'Solicitud elaborada con éxito',
                        onClose: function onClose() {
                            window.location.href = App.host + '/control_costos/solicitudes_reclasificacion';
                        }
                    });
                },
                complete: function complete(data) {

                    if (data.status == 400) {
                        $('#Fecha').datepicker('update', data.getResponseHeader('next-date'));
                        Vue.set(self.data, 'fecha', data.getResponseHeader('next-date'));
                    } else {
                        $('#Fecha').datepicker('update', temp_fecha);
                        Vue.set(self.data, 'fecha', temp_fecha);
                    }
                }
            });
        },
        ver_lista: function ver_lista(items) {
            window.location.href = App.host + '/control_costos/solicitudes_reclasificacion?repetidas=' + JSON.stringify(items);
        },
        pdf: function pdf(id) {
            var self = this,
                url = App.host + '/control_costos/solicitudes_reclasificacion/generarpdf/' + id;

            self.data.show_pdf = url;
        },
        html_decode: function html_decode(input) {
            var e = document.createElement('div');
            e.innerHTML = input;

            return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
        },
        close_modal_detalles: function close_modal_detalles() {
            var self = this;

            $('#solicitud_detalles_modal').modal('hide');

            // reset partidas
            self.data.editando = false;
            self.data.rechazando = false;
            self.data.rechazo_motivo = '';
            self.data.show_pdf = false;
        },
        allow_editar: function allow_editar() {
            var self = this;

            self.data.editando = self.data.solicitud;
        },
        confirm: function confirm(tipo) {
            var self = this;

            // Manda error si no hay una solicitud para aprobar/rechazar
            if (self.data.editando.length > 0) return swal({
                type: 'warning',
                title: 'Error',
                text: 'La solicitud está vacía'
            });

            // Al rechazar debe de haber un motivo
            if (tipo == 'rechazar' && self.data.rechazo_motivo == '') return swal({
                type: 'warning',
                title: 'Error',
                text: 'Debes de especificar un motivo para rechazar'
            });

            swal({
                title: tipo.mayusculaPrimerLetra(),
                text: "¿Estás seguro/a de que deseas " + tipo + " esta solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    if (tipo == "aprobar") {
                        self.aprobar();
                    } else if (tipo == "rechazar") {
                        self.rechazar();
                    }
                }
            }).catch(swal.noop);
        },
        aprobar: function aprobar() {
            var self = this,
                str = { 'data': JSON.stringify(self.data.editando), 'tipo': 'aprobar' };

            $.ajax({
                type: 'POST',
                url: App.host + '/control_costos/solicitudes_reclasificacion/store',
                data: str,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    if (data.resultado) swal({
                        type: 'success',
                        title: '',
                        html: 'La solicitud fué autorizada'
                    });else swal({
                        type: 'warning',
                        title: '',
                        html: 'La operación no pudo concretarse'
                    });

                    self.close_modal_detalles();
                },
                complete: function complete() {}
            });
        },
        rechazar: function rechazar() {
            var self = this,
                str = { 'data': JSON.stringify(self.data.editando), 'tipo': 'rechazar', 'motivo': self.data.rechazo_motivo };

            $.ajax({
                type: 'POST',
                url: App.host + '/control_costos/solicitudes_reclasificacion/store',
                data: str,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    if (data.resultado) swal({
                        type: 'success',
                        title: '',
                        html: 'La solicitud fué rechazada'
                    });else swal({
                        type: 'warning',
                        title: '',
                        html: 'La operación no pudo concretarse'
                    });

                    self.close_modal_detalles();
                },
                complete: function complete() {}
            });
        },
        rechazar_motivo: function rechazar_motivo() {

            var self = this;

            self.data.rechazando = true;
        },
        cancelar_rechazo: function cancelar_rechazo() {
            var self = this;

            self.data.rechazando = false;
            self.data.rechazo_motivo = '';
        }
    }, 'html_decode', function html_decode(input) {
        var e = document.createElement('div');
        e.innerHTML = input;

        return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
    })
});

},{}],31:[function(require,module,exports){
'use strict';

Vue.component('cambio-insumos-indirecto-create', {
    props: ['id_tipo_orden'],
    data: function data() {
        return {
            form: {
                partidas: [],
                insumos_eliminados: [],
                motivo: '',
                area_solicitante: '',
                concepto_seleccionado: [],
                id_tipo_orden: this.id_tipo_orden
            },
            concepto: {
                descripcion: '',
                id_material: '',
                monto_presupuestado: '',
                precio_unitario: '',
                cantidad_presupuestada: '',
                cantidad_presupuestada_nueva: '',
                precio_unitario_nuevo: '',
                unidad: '',
                rendimiento_nuevo: '',
                id_elemento: '',
                tipo_agrupador: 6
            },
            id_material_seleccionado: 0,
            material_seleccionado: [],
            guardar: false,
            id_concepto_indirecto: '',
            concepto_seleccionado: [],
            cargando: false,
            guardando: false,
            cargando_tarjetas: true,
            consultando: false
        };
    },
    mounted: function mounted() {
        var self = this;
        $('#sel_concepto_indirecto').select2({
            width: '100%',
            ajax: {
                url: App.host + '/conceptos/getPathsCostoIndirecto',
                dataType: 'json',
                delay: 500,
                data: function data(params) {
                    return {
                        descripcion: params.term
                    };
                },
                processResults: function processResults(data) {
                    return {
                        results: $.map(data.data.conceptos, function (item) {
                            return {
                                text: item.filtro6 + " -> " + item.filtro7,
                                id: item.id_concepto,
                                cantidad_presupuestada: item.cantidad_presupuestada,
                                monto_presupuestado: item.monto_presupuestado,
                                precio_unitario: item.precio_unitario,
                                id_concepto: item.id_concepto
                            };
                        })
                    };
                },
                error: function error(_error) {},
                cache: true
            },
            escapeMarkup: function escapeMarkup(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1
        }).on('select2:select', function (e) {
            var data = e.params.data;
            self.form.concepto_seleccionado = data;
            self.concepto_seleccionado = data;
            self.form.partidas = [];
            self.obtenerExplosion(data.id);
        });
        self.cargando_tarjetas = false;
    },
    methods: {

        obtenerExplosion: function obtenerExplosion(idConcepto) {
            var self = this;
            $.ajax({
                url: App.host + '/conceptos/' + idConcepto + '/getInsumos',
                type: 'GET',
                async: 'true',
                beforeSend: function beforeSend() {
                    self.consultando = true;
                },
                success: function success(response) {

                    $.each(response.conceptos.GASTOS.insumos, function (key, value) {
                        //console.log(key+"  -  "+value.descripcion);


                        self.concepto.id_material = value.id_material;
                        self.concepto.monto_presupuestado = value.monto_presupuestado;
                        self.concepto.precio_unitario = value.precio_unitario;
                        self.concepto.cantidad_presupuestada = value.cantidad_presupuestada;
                        self.concepto.descripcion = value.descripcion.toString();
                        self.concepto.unidad = value.unidad;
                        self.concepto.rendimiento_actual = value.cantidad_presupuestada / self.concepto_seleccionado.cantidad_presupuestada;
                        self.concepto.id_elemento = value.id_concepto;
                        self.concepto.id_concepto = value.id_concepto;
                        self.form.partidas.push(self.concepto);
                    });
                    self.concepto = [];
                    self.consultando = false;
                },
                complete: function complete() {
                    self.consultando = false;
                }
            });
        },
        insumoEliminado: function insumoEliminado(id_concepto) {
            return this.form.insumos_eliminados.indexOf(parseInt(id_concepto)) ? true : false;
        },
        recalcular: function recalcular(id_concepto, i, tipo) {
            var self = this;
            var cant_pres = $(".rendimiento" + id_concepto + '_' + i).val();
            var cant_concepto = self.concepto_seleccionado.cantidad_presupuestada;
            console.log(".rendimiento" + id_concepto + '_' + i);
            self.form.partidas[i].rendimiento_nuevo = cant_pres;
            var total = cant_concepto * self.form.partidas[i].rendimiento_nuevo;
            $("#r_p_" + id_concepto + '_' + i).val(total);
        },

        recalcular_monto: function recalcular_monto(id_concepto, i, tipo) {
            var self = this;
            var cant = $(".pre_unit" + id_concepto + '_' + i).val();
            self.form.partidas[i].precio_unitario_nuevo = cant;
        },

        recalcular_cantidad: function recalcular_cantidad(id_concepto, i, tipo) {
            var self = this;
            var cant_pres = $("#r_p_" + id_concepto + '_' + i).val();
            var cant_concepto = self.concepto_seleccionado.cantidad_presupuestada;
            var total = cant_pres / cant_concepto;
            $(".rendimiento" + id_concepto + '_' + i).val(total);
            self.form.partidas[i].rendimiento_nuevo = total;
        },
        agregar_insumo_nuevo: function agregar_insumo_nuevo() {
            var self = this;
            var existe = false;
            $.each(self.form.partidas, function (index, insumo) {
                if (insumo.id_material == self.material_seleccionado.id_material) {

                    existe = true;
                    swal({
                        type: 'warning',
                        title: 'Advertencia',
                        text: 'Ya Existe el Insumo Seleccionado'
                    });
                }
            });
            if (!existe) {
                self.form.partidas.push(self.material_seleccionado);
                $('#add_insumo_modal').modal('hide');
            }
        },
        removeRendimiento: function removeRendimiento(id_concepto, id, tipo) {
            var self = this;
            var index = self.form.insumos_eliminados.indexOf(parseInt(id_concepto));
            if (index > -1) {
                console.log('entro');
                self.form.insumos_eliminados.splice(index, 1);
                $("#c_p_" + id_concepto + '_' + id).prop('disabled', false);
                $("#m_p_" + id_concepto + '_' + id).prop('disabled', false);
                $("#r_p_" + id_concepto + '_' + id).prop('disabled', false);
            } else {
                self.form.insumos_eliminados.push(id_concepto);

                if (self.form.partidas[id].nuevo) {
                    self.form.partidas.splice(id, 1);
                }

                $("#c_p_" + id_concepto + '_' + id).prop('disabled', true);
                $("#m_p_" + id_concepto + '_' + id).prop('disabled', true);
                $("#r_p_" + id_concepto + '_' + id).prop('disabled', true);
            }
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_solicitud') {
                    _this.confirmSave();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirmSave: function confirmSave() {
            var self = this;
            swal({
                title: 'Guardar Solicitud de Cambio',
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function (result) {
                if (result.value) {
                    self.save();
                }
            });
        },

        save: function save() {
            var self = this;
            $.ajax({
                url: App.host + '/control_presupuesto/cambio_insumos_indirecto',
                type: 'POST',
                data: self.form,
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {

                    var lista = [];

                    // Ya existen solicitudes con las partidas seleccionadas
                    if (typeof response.repetidas != 'undefined') {

                        $.each(response.repetidas, function (key, value) {
                            lista.push('<li class="list-group-item "><a href="' + App.host + '/control_presupuesto/cambio_presupuesto" onclick="swal.close();">#' + value.solicitud.numero_folio + ' ' + (value.solicitud.motivo.length >= 20 ? value.solicitud.motivo.substring(0, 30) + '...' : value.solicitud.motivo) + '</a></li>');
                        });

                        var texto = response.repetidas.length > 1 ? 'Ya existen solicitudes' : 'Ya existe una solicitud';

                        swal({
                            title: texto + " con los items seleccionados",
                            html: '<ul class="list-group">' + lista.join(' ') + '</ul>',
                            type: "warning",
                            showCancelButton: true,
                            showConfirmButton: true,
                            cancelButtonText: "Cancelar"
                        });

                        return;
                    }

                    swal({
                        type: 'success',
                        title: '¡Correcto!',
                        //html : 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                        html: 'Solicitud Guardada Exitosamente.'
                    }).then(function () {
                        window.location.href = App.host + '/control_presupuesto/cambio_insumos/' + response.id;
                    });
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },
        addInsumoTipo: function addInsumoTipo(tipo) {
            var self = this;
            var aux_tipo = tipo;
            if (tipo == 5 || tipo == 6) {
                tipo = 2;
            }
            // self.tipo_insumo = tipo;

            self.guardar = true;

            $('#sel_material').select2({
                width: '100%',
                async: true,
                ajax: {
                    url: App.host + '/control_presupuesto/cambio_presupuesto/getDescripcionByTipo',
                    dataType: 'json',
                    delay: 500,
                    data: function data(params) {
                        return {
                            descripcion: params.term,
                            tipo: tipo
                        };
                    },
                    processResults: function processResults(data) {
                        return {
                            results: $.map(data.data.materiales, function (item) {

                                return {
                                    text: item.DescripcionPadre + " -> " + item.descripcion,
                                    descripcion: item.descripcion,
                                    id_material: item.id_material,
                                    unidad: item.unidad,
                                    cantidad_presupuestada: 0,
                                    variacion_cantidad_presupuestada: 0,
                                    cantidad_presupuestada_nueva: 0,
                                    variacion_precio_unitario: 0,
                                    precio_unitario: 0,
                                    id: item.id_material,
                                    nuevo: true,
                                    rendimiento_actual: 0
                                };
                            })
                        };
                    },
                    success: function success(data, textStatus, xhr) {
                        //  self.tipo_insumo = aux_tipo;
                    },
                    error: function error(_error2) {
                        //self.tipo_insumo = aux_tipo;
                    },
                    cache: true
                },
                escapeMarkup: function escapeMarkup(markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1
            }).on('select2:select', function (e) {
                var data = e.params.data;
                data.id_elemento = data.id_material;
                // console.log(data);
                self.guardar = false;
                self.material_seleccionado = data;
            });

            $('#add_insumo_modal').modal('show');
        }

    }
});

},{}],32:[function(require,module,exports){
'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

Vue.component('cambio-insumos-create', {
    props: ['id_tipo_orden'],
    data: function data() {
        return {
            form: {
                partidas: [],
                agrupadas: [],
                insumos_eliminados: [],
                motivo: '',
                area_solicitante: '',
                id_tipo_cobrabilidad: '',
                id_tipo_orden: '',
                id_tarjeta: '',
                filtro: {
                    nivel: '',
                    operador: '',
                    texto: ''
                }

            },
            tipo_insumo: 0,
            id_material_seleccionado: 0,
            material_seleccionado: [],
            tarjeta_actual: 0,
            cargando: false,
            guardando: false,
            guardar: true,
            filtros: [],
            id_tarjeta: '',
            tarjetas: [],
            bases_afectadas: [],
            niveles: [{ nombre: 'Nivel 1', numero: 1 }, { nombre: 'Nivel 2', numero: 2 }, { nombre: 'Nivel 3', numero: 3 }, { nombre: 'Sector', numero: 4 }, { nombre: 'Cuadrante', numero: 5 }, { nombre: 'Especialidad', numero: 6 }, { nombre: 'Partida', numero: 7 }, { nombre: 'Sub Partida o Centa de costo', numero: 8 }, { nombre: 'Concepto', numero: 9 }, { nombre: 'Nivel 10', numero: 10 }, { nombre: 'Nivel 11', numero: 11 }],
            cargando_tarjetas: true
        };
    },

    computed: {
        datos: function datos() {
            var res = {
                id_tipo_orden: this.id_tipo_orden,
                motivo: this.form.motivo,
                area_solicitante: this.form.area_solicitante,
                agrupadas: this.form.agrupadas,
                partidas: this.form.partidas,
                insumos_eliminados: this.form.insumos_eliminados
            };
            return res;
        }
    },
    watch: {
        id_tarjeta: function id_tarjeta() {
            var self = this;
            if (self.form.partidas.length > 0) {
                swal({
                    title: 'Cambiar Tarjeta',
                    text: "Si Cambia de Tarjeta se Descartarán los Conceptos Seleccionados\n¿Desea Cambiar de Tarjeta?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Cambiar',
                    cancelButtonText: 'No, Cancelar'
                }).then(function (value) {
                    if (value.value) {
                        self.get_conceptos();
                        self.form.partidas = [];
                        self.form.agrupadas = [];
                        self.tarjeta_actual = self.id_tarjeta;
                    } else {
                        // setear valor anterior en el select2
                    }
                });
            } else {
                self.get_conceptos();
                self.form.partidas = [];
                self.form.agrupadas = [];
                self.tarjeta_actual = self.id_tarjeta;
            }
        }
    },

    mounted: function mounted() {
        var self = this;

        self.fetchTarjetas().then(function () {
            self.cargando_tarjetas = false;
            $('#conceptos_table').DataTable({
                "processing": true,
                "serverSide": true,
                "paging": false,
                "ordering": true,
                "searching": false,
                "ajax": {
                    "url": App.host + '/conceptos/getPathsConceptos',
                    "type": "POST",
                    "beforeSend": function beforeSend() {
                        self.cargando = true;
                    },
                    "data": function data(d) {
                        d.filtros = self.filtros;
                        d.id_tarjeta = self.id_tarjeta;
                    },
                    "complete": function complete() {
                        self.cargando = false;
                    },
                    "dataSrc": function dataSrc(json) {
                        for (var i = 0; i < json.data.length; i++) {
                            json.data[i].monto_presupuestado = '$' + parseFloat(json.data[i].monto_presupuestado).formatMoney(2, ',', '.');
                            json.data[i].cantidad_presupuestada = parseFloat(json.data[i].cantidad_presupuestada).formatMoney(2, ',', '.');
                            json.data[i].precio_unitario = '$' + parseFloat(json.data[i].precio_unitario).formatMoney(2, ',', '.');
                            json.data[i].filtro9_sub = json.data[i].filtro9.length > 50 ? json.data[i].filtro9.substr(0, 50) + '...' : json.data[i].filtro9;
                        }
                        return json.data;
                    }
                },
                "columns": [{ data: 'filtro1' }, { data: 'filtro2' }, { data: 'filtro3' }, { data: 'filtro4' }, { data: 'filtro5' }, { data: 'filtro6' }, { data: 'filtro7' }, { data: 'filtro8' }, {
                    data: {},
                    render: function render(data) {
                        return '<span title="' + data.filtro9 + '">' + data.filtro9_sub + '</span>';
                    }
                }, { data: 'filtro10' }, { data: 'filtro11' }, { data: 'unidad' }, { data: 'cantidad_presupuestada', className: 'text-right' }, { data: 'precio_unitario', className: 'text-right' }, { data: 'monto_presupuestado', className: 'text-right' }, {
                    data: {},
                    render: function render(data) {
                        if (self.existe(data.id_concepto)) {
                            return '<button class="btn btn-xs btn-default btn_remove_concepto" id="' + data.id_concepto + '"><i class="fa fa-minus text-red"></i></button>';
                        }
                        return '<button class="btn btn-xs btn-default btn_add_concepto" id="' + data.id_concepto + '"><i class="fa fa-plus text-green"></i></button>';
                    }
                }],
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });

        self.fetchPresupuestos();

        $(document).on('click', '.btn_add_concepto', function () {
            var id = $(this).attr('id');
            self.addConcepto(id);
        }).on('click', '.btn_remove_concepto', function () {
            var id = $(this).attr('id');
            self.removeConcepto(id);
        });
    },

    methods: {

        fetchTarjetas: function fetchTarjetas() {
            var self = this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/control_presupuesto/tarjeta/lists',
                    type: 'GET',
                    beforeSend: function beforeSend() {
                        self.cargando = true;
                    },
                    success: function success(response) {
                        self.tarjetas = response;
                    },
                    complete: function complete() {
                        self.cargando = false;
                        resolve();
                    }
                });
            });
        },

        fetchPresupuestos: function fetchPresupuestos() {
            var self = this;

            var url = App.host + '/control_presupuesto/variacion_volumen/getBasesAfectadas';
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.bases_afectadas = data;
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        get_conceptos: function get_conceptos() {
            var table = $('#conceptos_table').DataTable();
            table.ajax.reload();
        },

        addConcepto: function addConcepto(id) {
            var self = this;
            $.ajax({
                url: App.host + '/conceptos/' + id + '/getInsumos',
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.guardando = true;
                    $('#' + id).html('<i class="fa fa-spin fa-spinner"></i>');
                    $('#' + id).attr('disabled', true);
                },
                success: function success(response) {
                    if (jQuery.isEmptyObject(self.form.partidas)) {
                        $.each(response.conceptos.MATERIALES.insumos, function (index, partida) {
                            response.conceptos.MATERIALES.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada;
                            response.conceptos.MATERIALES.insumos[index].id_elemento = response.conceptos.MATERIALES.insumos[index].id_concepto;
                            response.conceptos.MATERIALES.insumos[index].nuevo = false;
                        });
                        $.each(response.conceptos.HERRAMIENTAYEQUIPO.insumos, function (index, partida) {
                            response.conceptos.HERRAMIENTAYEQUIPO.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada;
                            response.conceptos.HERRAMIENTAYEQUIPO.insumos[index].id_elemento = response.conceptos.HERRAMIENTAYEQUIPO.insumos[index].id_concepto;
                            response.conceptos.HERRAMIENTAYEQUIPO.insumos[index].nuevo = false;
                        });
                        $.each(response.conceptos.MANOOBRA.insumos, function (index, partida) {
                            response.conceptos.MANOOBRA.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada;
                            response.conceptos.MANOOBRA.insumos[index].id_elemento = response.conceptos.MANOOBRA.insumos[index].id_concepto;
                            response.conceptos.MANOOBRA.insumos[index].nuevo = false;
                        });
                        $.each(response.conceptos.MAQUINARIA.insumos, function (index, partida) {
                            response.conceptos.MAQUINARIA.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada;
                            response.conceptos.MAQUINARIA.insumos[index].id_elemento = response.conceptos.MAQUINARIA.insumos[index].id_concepto;
                            response.conceptos.MAQUINARIA.insumos[index].nuevo = false;
                        });
                        $.each(response.conceptos.SUBCONTRATOS.insumos, function (index, partida) {
                            response.conceptos.SUBCONTRATOS.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada;
                            response.conceptos.SUBCONTRATOS.insumos[index].id_elemento = response.conceptos.SUBCONTRATOS.insumos[index].id_concepto;
                            response.conceptos.SUBCONTRATOS.insumos[index].nuevo = false;
                        });
                        $.each(response.conceptos.GASTOS.insumos, function (index, partida) {
                            response.conceptos.GASTOS.insumos[index].rendimiento_actual = partida.cantidad_presupuestada / response.cobrable.cantidad_presupuestada;
                            response.conceptos.GASTOS.insumos[index].id_elemento = response.conceptos.GASTOS.insumos[index].id_concepto;
                            response.conceptos.GASTOS.insumos[index].nuevo = false;
                        });
                        self.form.partidas.push(response);
                        self.form.agrupadas.push(response.cobrable.id_concepto);
                        $('#' + id).html('<i class="fa fa-minus text-red"></i>');
                        $('#' + id).removeClass('btn_add_concepto');
                        $('#' + id).addClass('btn_remove_concepto');
                    } else {
                        $.each(self.form.partidas, function (index, partida) {
                            var diferencias = false;
                            if (partida.conceptos.MATERIALES.insumos.length === response.conceptos.MATERIALES.insumos.length) {
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.MATERIALES.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.MATERIALES.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if ((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)) {
                                    diferencias = true;
                                }
                            } else {
                                diferencias = true;
                            }
                            if (partida.conceptos.HERRAMIENTAYEQUIPO.insumos.length === response.conceptos.HERRAMIENTAYEQUIPO.insumos.length) {
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.HERRAMIENTAYEQUIPO.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.HERRAMIENTAYEQUIPO.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if ((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)) {
                                    diferencias = true;
                                }
                            } else {
                                diferencias = true;
                            }
                            if (partida.conceptos.MANOOBRA.insumos.length === response.conceptos.MANOOBRA.insumos.length) {
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.MANOOBRA.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.MANOOBRA.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if ((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)) {
                                    diferencias = true;
                                }
                            } else {
                                diferencias = true;
                            }
                            if (partida.conceptos.MAQUINARIA.insumos.length === response.conceptos.MAQUINARIA.insumos.length) {
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.MAQUINARIA.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.MAQUINARIA.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if ((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)) {
                                    diferencias = true;
                                }
                            } else {
                                diferencias = true;
                            }

                            if (partida.conceptos.SUBCONTRATOS.insumos.length === response.conceptos.SUBCONTRATOS.insumos.length) {
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.SUBCONTRATOS.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.SUBCONTRATOS.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if ((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)) {
                                    diferencias = true;
                                }
                            } else {
                                diferencias = true;
                            }

                            if (partida.conceptos.GASTOS.insumos.length === response.conceptos.GASTOS.insumos.length) {
                                var total1 = 0;
                                var total2 = 0;
                                $.each(partida.conceptos.GASTOS.insumos, function () {
                                    total1 = total1 + parseFloat(this.cantidad_presupuestada);
                                });
                                $.each(response.conceptos.GASTOS.insumos, function () {
                                    total2 = total2 + parseFloat(this.cantidad_presupuestada);
                                });
                                if ((total1 / partida.cobrable.cantidad_presupuestada).toFixed(3) != (total2 / response.cobrable.cantidad_presupuestada).toFixed(3)) {
                                    diferencias = true;
                                }
                            } else {
                                diferencias = true;
                            }

                            self.cargando = false;
                            if (diferencias) {
                                $('#' + id).html('<i class="fa fa-plus text-green"></i>');
                                swal({
                                    type: 'warning',
                                    title: 'Advertencia',
                                    text: 'CONCEPTOS NO AGRUPABLES'
                                });
                            } else {
                                self.form.agrupadas.push(response.cobrable.id_concepto);
                                $('#' + id).html('<i class="fa fa-minus text-red"></i>');
                                $('#' + id).removeClass('btn_add_concepto');
                                $('#' + id).addClass('btn_remove_concepto');
                            }
                        });
                    }
                },
                complete: function complete() {
                    self.guardando = false;
                    $('#' + id).attr('disabled', false);
                },
                error: function error() {
                    $('#' + id).html('<i class="fa fa-plus text-green"></i>');
                }
            });
        },

        existe: function existe(id) {
            var found = this.form.partidas.find(function (partida) {
                return partida.id_concepto == id;
            });
            return found != undefined;
        },

        confirmSave: function confirmSave() {
            var self = this;
            swal({
                title: 'Guardar Solicitud de Cambio',
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function (result) {
                if (result.value) {
                    self.save();
                }
            });
        },

        save: function save() {
            var self = this;
            $.ajax({
                url: App.host + '/control_presupuesto/cambio_insumos',
                type: 'POST',
                data: self.datos,
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {

                    var lista = [];

                    // Ya existen solicitudes con las partidas seleccionadas
                    if (typeof response.repetidas != 'undefined') {

                        $.each(response.repetidas, function (key, value) {
                            lista.push('<li class="list-group-item "><a href="' + App.host + '/control_presupuesto/cambio_presupuesto" onclick="swal.close();">#' + value.solicitud.numero_folio + ' ' + (value.solicitud.motivo.length >= 20 ? value.solicitud.motivo.substring(0, 30) + '...' : value.solicitud.motivo) + '</a></li>');
                        });

                        var texto = response.repetidas.length > 1 ? 'Ya existen solicitudes' : 'Ya existe una solicitud';

                        swal({
                            title: texto + " con los items seleccionados",
                            html: '<ul class="list-group">' + lista.join(' ') + '</ul>',
                            type: "warning",
                            showCancelButton: true,
                            showConfirmButton: true,
                            cancelButtonText: "Cancelar"
                        });

                        return;
                    }

                    swal({
                        type: 'success',
                        title: '¡Correcto!',
                        //html : 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                        html: 'Solicitud Guardada Exitosamente.'
                    }).then(function () {
                        window.location.href = App.host + '/control_presupuesto/cambio_insumos/' + response.id;
                    });
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        removeConcepto: function removeConcepto(id) {
            //var index = this.form.agrupadas.map(function (partida) { return partida.id_concepto; }).indexOf(parseInt(id));
            var self = this;
            var ag = self.form.agrupadas;
            var index = ag.indexOf(parseInt(id));

            this.form.agrupadas.splice(index, 1);
            $('#' + id).html('<i class="fa fa-plus text-green"></i>');
            $('#' + id).addClass('btn_add_concepto');
            $('#' + id).removeClass('btn_remove_concepto');
            if (!this.form.agrupadas.length) {
                this.form.partidas = [];
                $('#conceptos_modal').modal('hide');
            }
        },

        addInsumoTipo: function addInsumoTipo(tipo) {
            var self = this;

            if (tipo == 5 || tipo == 6) {
                tipo = 2;
            }

            self.guardar = true;
            $('#sel_material').select2({
                width: '100%',
                ajax: {
                    url: App.host + '/control_presupuesto/cambio_presupuesto/getDescripcionByTipo',
                    dataType: 'json',
                    delay: 500,
                    data: function data(params) {
                        return {
                            descripcion: params.term,
                            tipo: tipo
                        };
                    },
                    processResults: function processResults(data) {
                        return {
                            results: $.map(data.data.materiales, function (item) {

                                return {
                                    text: item.DescripcionPadre + " -> " + item.descripcion,
                                    descripcion: item.descripcion,
                                    id_material: item.id_material,
                                    unidad: item.unidad,
                                    cantidad_presupuestada: 0,
                                    variacion_cantidad_presupuestada: 0,
                                    cantidad_presupuestada_nueva: 0,
                                    variacion_precio_unitario: 0,
                                    precio_unitario: 0,
                                    id: item.id_material,
                                    nuevo: true,
                                    rendimiento_actual: 0
                                };
                            })
                        };
                    },
                    error: function error(_error) {},
                    cache: true
                },
                escapeMarkup: function escapeMarkup(markup) {
                    return markup;
                }, // let our custom formatter work
                minimumInputLength: 1
            }).on('select2:select', function (e) {
                var data = e.params.data;
                self.guardar = false;
                data.id_elemento = data.id_material;
                self.material_seleccionado = data;
            });
            $('#add_insumo_modal').modal('show');
        },

        cancelar_add_insumo: function cancelar_add_insumo() {
            $('#add_insumo_modal').modal('hide');

            $('#insumos_modal').modal('show');
            $('#insumos_modal').focus();
        },

        agregar_insumo_nuevo: function agregar_insumo_nuevo() {
            var self = this;
            $.each(self.form.partidas, function (index, partida) {
                switch (self.tipo_insumo) {
                    case 1:
                        ///agregar a materiales
                        if (!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)) {
                            partida.conceptos.MATERIALES.insumos.push(self.material_seleccionado);
                        } else {
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 2:
                        //// agergar a mano obra
                        if (!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)) {
                            partida.conceptos.MANOOBRA.insumos.push(self.material_seleccionado);
                        } else {
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 4:
                        ////agregar a herram y equipo
                        if (!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)) {
                            partida.conceptos.HERRAMIENTAYEQUIPO.insumos.push(self.material_seleccionado);
                        } else {
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 8:
                        ///agregar a maquinaria
                        if (!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)) {
                            partida.conceptos.MAQUINARIA.insumos.push(self.material_seleccionado);
                        } else {
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 5:
                        ///agregar a maquinaria
                        if (!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)) {
                            partida.conceptos.SUBCONTRATOS.insumos.push(self.material_seleccionado);
                        } else {
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;
                    case 6:
                        ///agregar a maquinaria
                        if (!self.validarInsumo(self.material_seleccionado.id_material, self.tipo_insumo)) {
                            partida.conceptos.GASTOS.insumos.push(self.material_seleccionado);
                        } else {
                            swal({
                                type: 'warning',
                                title: 'Advertencia',
                                text: 'Ya Existe el Insumo Seleccionado'
                            });
                        }
                        break;

                }
            });

            $('#add_insumo_modal').modal('hide');
        },

        validarInsumo: function validarInsumo(id_material, agrupador) {
            var self = this;
            var validador = false;
            switch (agrupador) {
                case 1:
                    ///validar materiales
                    $.each(self.form.partidas[0].conceptos.MATERIALES.insumos, function (index, insumo) {
                        if (insumo.id_material == id_material) {
                            validador = true;
                        }
                    });
                    break;
                case 2:
                    //// agergar a mano obra
                    $.each(self.form.partidas[0].conceptos.MANOOBRA.insumos, function (index, insumo) {
                        if (insumo.id_material == id_material) {
                            validador = true;
                        }
                    });
                    break;
                case 4:
                    ////agregar a herram y equipo
                    $.each(self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos, function (index, insumo) {
                        if (insumo.id_material == id_material) {
                            validador = true;
                        }
                    });
                    break;
                case 8:
                    ///agregar a maquinaria
                    $.each(self.form.partidas[0].conceptos.MAQUINARIA.insumos, function (index, insumo) {
                        if (insumo.id_material == id_material) {
                            validador = true;
                        }
                    });
                    break;
                case 5:
                    ///agregar a maquinaria
                    $.each(self.form.partidas[0].conceptos.SUBCONTRATOS.insumos, function (index, insumo) {
                        if (insumo.id_material == id_material) {
                            validador = true;
                        }
                    });
                    break;
                case 6:
                    ///agregar a maquinaria
                    $.each(self.form.partidas[0].conceptos.GASTOS.insumos, function (index, insumo) {
                        if (insumo.id_material == id_material) {
                            validador = true;
                        }
                    });
                    break;

            }
            return validador;
        },

        removeRendimiento: function removeRendimiento(id_concepto, id, tipo) {
            var self = this;
            var index = self.form.insumos_eliminados.indexOf(parseInt(id_concepto));
            if (index > -1) {

                console.log('entro' + index + ' ' + (typeof index === 'undefined' ? 'undefined' : _typeof(index)));
                self.form.insumos_eliminados.splice(index, 1);
                $("#c_p_" + id_concepto + '_' + id).prop('disabled', false);
                $("#m_p_" + id_concepto + '_' + id).prop('disabled', false);
                $("#r_p_" + id_concepto + '_' + id).prop('disabled', false);
            } else {
                console.log('salio');
                $("#c_p_" + id_concepto + '_' + id).prop('disabled', true);
                $("#m_p_" + id_concepto + '_' + id).prop('disabled', true);
                $("#r_p_" + id_concepto + '_' + id).prop('disabled', true);
                switch (tipo) {
                    case 1:
                        ///agregar a materiales
                        if (self.form.partidas[0].conceptos.MATERIALES.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.MATERIALES.insumos.splice(id, 1);
                        } else {
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }

                        break;
                    case 2:
                        //// agergar a mano obra
                        if (self.form.partidas[0].conceptos.MANOOBRA.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.MANOOBRA.insumos.splice(id, 1);
                        } else {
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }
                        break;
                    case 4:
                        ////agregar a herram y equipo
                        if (self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos.splice(id, 1);
                        } else {
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }
                        break;
                    case 8:
                        ///agregar a maquinaria
                        if (self.form.partidas[0].conceptos.MAQUINARIA.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.MAQUINARIA.insumos.splice(id, 1);
                        } else {
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }
                    case 5:
                        ///agregar a maquinaria
                        if (self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[id].nuevo) {
                            self.form.partidas[0].conceptos.SUBCONTRATOS.insumos.splice(id, 1);
                        } else {
                            self.form.insumos_eliminados.push(parseInt(id_concepto));
                        }
                        break;
                }
            }
            this.recalcular(id_concepto, id);
        },

        insumoEliminado: function insumoEliminado(id_concepto) {
            return this.form.insumos_eliminados.indexOf(parseInt(id_concepto)) ? true : false;
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_solicitud') {
                    _this.confirmSave();
                }
                if (funcion == 'add_filtro') {
                    _this.set_filtro();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        recalcular: function recalcular(id_concepto, i, tipo) {
            var self = this;
            var cant_pres = $(".rendimiento" + id_concepto + '_' + i).val();
            var cant_concepto = self.form.partidas[0].cobrable.cantidad_presupuestada;
            switch (tipo) {
                case 1:
                    ///agregar a materiales

                    self.form.partidas[0].conceptos.MATERIALES.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.MATERIALES.insumos[i].rendimiento_nuevo;
                    $("#r_p_" + id_concepto + '_' + i).val(total);
                    break;
                case 2:
                    //// agergar a mano obra
                    self.form.partidas[0].conceptos.MANOOBRA.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.MANOOBRA.insumos[i].rendimiento_nuevo;
                    $("#r_p_" + id_concepto + '_' + i).val(total);
                    break;
                case 4:
                    ////agregar a herram y equipo
                    self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[i].rendimiento_nuevo;
                    $("#r_p_" + id_concepto + '_' + i).val(total);
                    break;
                case 8:
                    ///agregar a maquinaria
                    self.form.partidas[0].conceptos.MAQUINARIA.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.MAQUINARIA.insumos[i].rendimiento_nuevo;
                    $("#r_p_" + id_concepto + '_' + i).val(total);
                    break;
                case 5:
                    ///agregar a subcontratos
                    self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[i].rendimiento_nuevo;
                    $("#r_p_" + id_concepto + '_' + i).val(total);
                    break;
                case 6:
                    ///agregar a gastos
                    self.form.partidas[0].conceptos.GASTOS.insumos[i].rendimiento_nuevo = cant_pres;
                    var total = cant_concepto * self.form.partidas[0].conceptos.GASTOS.insumos[i].rendimiento_nuevo;
                    $("#r_p_" + id_concepto + '_' + i).val(total);
                    break;
            }
        },

        recalcular_monto: function recalcular_monto(id_concepto, i, tipo) {
            var self = this;
            var cant = $(".pre_unit" + id_concepto + '_' + i).val();
            switch (tipo) {
                case 1:
                    ///agregar a materiales
                    self.form.partidas[0].conceptos.MATERIALES.insumos[i].precio_unitario_nuevo = cant;
                    break;
                case 2:
                    //// agergar a mano obra
                    self.form.partidas[0].conceptos.MANOOBRA.insumos[i].precio_unitario_nuevo = cant;

                    break;
                case 4:
                    ////agregar a herram y equipo
                    self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[i].precio_unitario_nuevo = cant;
                    break;
                case 8:
                    ///agregar a maquinaria
                    self.form.partidas[0].conceptos.MAQUINARIA.insumos[i].precio_unitario_nuevo = cant;
                    break;
                case 5:
                    ///agregar a subcontratos
                    self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[i].precio_unitario_nuevo = cant;
                    break;
                case 6:
                    ///agregar a gastos
                    self.form.partidas[0].conceptos.GASTOS.insumos[i].precio_unitario_nuevo = cant;
                    break;
            }
        },

        recalcular_cantidad: function recalcular_cantidad(id_concepto, i, tipo) {
            var self = this;
            var cant_pres = $("#r_p_" + id_concepto + '_' + i).val();
            var cant_concepto = self.form.partidas[0].cobrable.cantidad_presupuestada;
            switch (tipo) {
                case 1:
                    ///agregar a materiales
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" + id_concepto + '_' + i).val(total);
                    self.form.partidas[0].conceptos.MATERIALES.insumos[i].rendimiento_nuevo = total;
                    break;
                case 2:
                    //// agergar a mano obra
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" + id_concepto + '_' + i).val(total);
                    self.form.partidas[0].conceptos.MANOOBRA.insumos[i].rendimiento_nuevo = total;

                    break;
                case 4:
                    ////agregar a herram y equipo
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" + id_concepto + '_' + i).val(total);
                    self.form.partidas[0].conceptos.HERRAMIENTAYEQUIPO.insumos[i].rendimiento_nuevo = total;
                    break;
                case 8:
                    ///agregar a maquinaria
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" + id_concepto + '_' + i).val(total);
                    self.form.partidas[0].conceptos.MAQUINARIA.insumos[i].rendimiento_nuevo = total;
                    break;
                case 5:
                    ///agregar a SUNCONTRATOS
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" + id_concepto + '_' + i).val(total);
                    self.form.partidas[0].conceptos.SUBCONTRATOS.insumos[i].rendimiento_nuevo = total;
                    break;
                case 6:
                    ///agregar a maquinaria
                    var total = cant_pres / cant_concepto;
                    $(".rendimiento" + id_concepto + '_' + i).val(total);
                    self.form.partidas[0].conceptos.GASTOS.insumos[i].rendimiento_nuevo = total;
                    break;
            }
        },

        set_filtro: function set_filtro() {
            var nivel = this.form.filtro.nivel;
            var result = this.filtros.filter(function (filtro) {
                return filtro.nivel == nivel;
            });

            if (result.length) {
                result[0].operadores.push({
                    sql: this.form.filtro.operador.replace('{texto}', this.form.filtro.texto),
                    operador: this.operadores[this.form.filtro.operador],
                    texto: this.form.filtro.texto
                });
            } else {
                this.filtros.push({
                    nivel: this.form.filtro.nivel,
                    operadores: [{
                        sql: this.form.filtro.operador.replace('{texto}', this.form.filtro.texto),
                        operador: this.operadores[this.form.filtro.operador],
                        texto: this.form.filtro.texto
                    }]
                });
            }

            this.close_modal();
        },

        close_modal: function close_modal() {
            $('#agregar_filtro_modal').modal('hide');
            Vue.set(this.form, 'filtro', { nivel: '', operador: '', texto: '' });
        },

        eliminar: function eliminar(filtro, operador) {
            Vue.delete(filtro.operadores, filtro.operadores.indexOf(operador));
            if (!filtro.operadores.length) {
                Vue.delete(this.filtros, this.filtros.indexOf(filtro));
            }
        },

        obtenerPresupuestos: function obtenerPresupuestos() {
            var self = this;

            var tipoOrden = self.form.id_tipo_orden;

            $('#divDetalle').fadeOut();

            var url = App.host + '/control_presupuesto/afectacion_presupuesto/getBasesAfectadas';
            $.ajax({
                type: 'POST',
                data: {
                    tipo_orden: tipoOrden
                },
                url: url,
                beforeSend: function beforeSend() {
                    self.consultando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.bases_afectadas = data.data;
                },
                complete: function complete() {
                    self.consultando = false;
                }
            });
        }
    }
});

},{}],33:[function(require,module,exports){
'use strict';

Vue.component('cambio-insumos-show', {
    props: ['solicitud', 'presupuestos', 'conceptos_agrupados', 'total_proforma_agrupados'],
    data: function data() {
        return {
            form: {
                solicitud: this.solicitud,
                cobrabilidad: ''
            },
            clasificacion: [],
            cargando: false,
            rechazando: false,
            autorizando: false,
            consultando: false,
            consultandoImportes: false,

            partidas: [],
            importes: [],
            partida_id: 0
        };
    },
    mounted: function mounted() {
        var self = this;

        $(function () {
            $(document).on('click', '.mostrar_pdf', function () {
                var _this = $(this),
                    id = _this.data('pdf_id'),
                    url = App.host + '/control_presupuesto/cambio_insumos/' + id + '/pdf';

                $('#formatoPDF').attr('src', url).hide();
                $('#spin_iframe').show();

                $('#pdf_modal').modal('show');

                $('#pdf_modal .modal-body').css({ height: '550px' });
                document.getElementById('formatoPDF').onload = function () {
                    $('#formatoPDF').show();
                    $('#spin_iframe').hide();
                };
            });
        });
    },
    computed: {},

    methods: {

        confirm_autorizar_solicitud: function confirm_autorizar_solicitud() {
            var self = this;
            var id = self.form.solicitud.id;
            swal({
                title: "Autorizar la Solicitud de Cambio",
                html: "¿Estás seguro que desea actualizar la solicitud? <br> <div id='detalle_sol_cop'></div>",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.autorizar_solicitud(id);
                }
            });

            $("#detalles_impactos").clone().appendTo("#detalle_sol_cop");
        },

        confirm_rechazar_solicitud: function confirm_rechazar_solicitud() {
            var self = this;
            var id = self.form.solicitud.id;

            swal({
                title: 'Rechazar Solicitud',
                text: 'Motivo del rechazo',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Rechazar ',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: false,
                preConfirm: function preConfirm(motivo) {
                    return new Promise(function (resolve) {
                        if (motivo.length === 0) {
                            swal.showValidationError('Por favor escriba un motivo para rechazar la solicitud.');
                        }
                        resolve();
                    });
                },
                allowOutsideClick: function allowOutsideClick() {
                    !swal.isLoading();
                }
            }).then(function (result) {
                if (result.value) {
                    self.rechazar_solicitud(id, result.value);
                }
            });
        },

        autorizar_solicitud: function autorizar_solicitud(id) {
            $('#btn_rechazar').prop('disabled', true);
            $('#btn_autorizar').prop('disabled', true);
            var self = this;
            var url = App.host + '/control_presupuesto/cambio_insumos/' + id + '/autorizar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id: id,
                    id_tipo_orden: self.form.solicitud.id_tipo_orden
                },
                beforeSend: function beforeSend() {
                    self.autorizando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud autorizada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {});
                    window.location.reload(true);
                },
                complete: function complete() {
                    self.autorizando = false;
                }
            });
        },

        rechazar_solicitud: function rechazar_solicitud(id, motivo) {
            $('#btn_rechazar').prop('disabled', true);
            $('#btn_autorizar').prop('disabled', true);

            var self = this;
            var url = App.host + '/control_presupuesto/cambio_insumos/' + id + '/rechazar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_solicitud_cambio: id,
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    motivo: motivo
                },
                beforeSend: function beforeSend() {
                    self.rechazando = true;
                },
                success: function success(data, textStatus, xhr) {

                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud rechazada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {});
                    window.location.reload(true);
                },
                complete: function complete() {
                    self.rechazando = false;
                }
            });
        },

        mostrarDetalleInsumos: function mostrarDetalleInsumos(index) {
            var self = this;
            var agrupado = self.conceptos_agrupados[index];
            $('#divDetalle').fadeOut();
            var url = App.host + '/control_presupuesto/cambio_presupuesto_partida/getClasificacionInsumos';
            $.ajax({
                type: 'POST',
                data: {
                    id_concepto: agrupado.id_concepto,
                    id_solicitud_cambio: agrupado.id_solicitud_cambio
                },
                url: url,
                beforeSend: function beforeSend() {
                    self.consultando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.clasificacion = data.data;
                    $.each(data.data, function (key, value) {
                        switch (value.id_tipo) {
                            case 1:
                                value.monto_original = agrupado.concepto.materiales_monto_original;
                                value.variacion = agrupado.concepto.materiales_variacion;
                                break;
                            case 2:
                                value.monto_original = agrupado.concepto.mano_obra_monto_original;
                                value.variacion = agrupado.concepto.mano_obra_variacion;
                                break;
                            case 4:
                                value.monto_original = agrupado.concepto.herramienta_monto_original;
                                value.variacion = agrupado.concepto.herramienta_variacion;
                                break;
                            case 8:
                                value.monto_original = agrupado.concepto.maquinaria_monto_original;
                                value.variacion = agrupado.concepto.maquinaria_variacion;
                                break;
                            case 5:
                                value.monto_original = agrupado.concepto.subcontratos_monto_original;
                                value.variacion = agrupado.concepto.subcontratos_variacion;
                                break;
                            case 6:
                                value.monto_original = agrupado.concepto.gastos_monto_original;
                                value.variacion = agrupado.concepto.gastos_variacion;
                                break;

                        }
                        value.monto_nuevo = parseFloat(value.monto_original) + parseFloat(value.variacion);
                    });

                    $('#divDetalle').fadeIn();
                },
                complete: function complete() {
                    self.consultando = false;
                }
            });
        }

    }
});

},{}],34:[function(require,module,exports){
'use strict';

Vue.component('cambio-presupuesto-create', {
    props: ['operadores'],
    data: function data() {
        return {
            form: {
                id_tipo_cobrabilidad: '',
                id_tipo_orden: '',
                id_tarjeta: '',
                filtro: {
                    nivel: '',
                    operador: '',
                    texto: ''
                }
            },
            filtros: [],
            tipos_cobrabilidad: [],
            tipos_orden: [],
            tarjetas: [],
            cargando: false,
            bases_afectadas: [],
            niveles: [{ nombre: 'Nivel 1', numero: 1 }, { nombre: 'Nivel 2', numero: 2 }, { nombre: 'Nivel 3', numero: 3 }, { nombre: 'Sector', numero: 4 }, { nombre: 'Cuadrante', numero: 5 }, { nombre: 'Especialidad', numero: 6 }, { nombre: 'Partida', numero: 7 }, { nombre: 'Sub Partida o Centa de costo', numero: 8 }, { nombre: 'Concepto', numero: 9 }, { nombre: 'Nivel 10', numero: 10 }, { nombre: 'Nivel 11', numero: 11 }]
        };
    },

    computed: {
        tipos_orden_filtered: function tipos_orden_filtered() {
            var self = this;
            return this.tipos_orden.filter(function (tipo_orden) {
                return tipo_orden.id_tipo_cobrabilidad == self.form.id_tipo_cobrabilidad;
            });
        }
    },

    mounted: function mounted() {
        this.fetchTiposCobrabilidad();
        this.fetchTiposOrden();
        this.fetchTarjetas();
    },

    methods: {
        fetchTiposCobrabilidad: function fetchTiposCobrabilidad() {
            var self = this;
            $.ajax({
                url: App.host + '/control_presupuesto/tipo_cobrabilidad',
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.tipos_cobrabilidad = response;
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        fetchTarjetas: function fetchTarjetas() {
            var self = this;
            $.ajax({
                url: App.host + '/control_presupuesto/tarjeta/lists',
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.tarjetas = response;
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        fetchTiposOrden: function fetchTiposOrden() {
            var self = this;
            $.ajax({
                url: App.host + '/control_presupuesto/tipo_orden',
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.tipos_orden = response;
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },
        set_filtro: function set_filtro() {
            var nivel = this.form.filtro.nivel;
            var result = this.filtros.filter(function (filtro) {
                return filtro.nivel == nivel;
            });

            if (result.length) {
                result[0].operadores.push({
                    sql: this.form.filtro.operador.replace('{texto}', this.form.filtro.texto),
                    operador: this.operadores[this.form.filtro.operador],
                    texto: this.form.filtro.texto
                });
            } else {
                this.filtros.push({
                    nivel: this.form.filtro.nivel,
                    operadores: [{
                        sql: this.form.filtro.operador.replace('{texto}', this.form.filtro.texto),
                        operador: this.operadores[this.form.filtro.operador],
                        texto: this.form.filtro.texto
                    }]
                });
            }

            this.close_modal();
        },

        close_modal: function close_modal() {
            $('#agregar_filtro_modal').modal('hide');
            Vue.set(this.form, 'filtro', { nivel: '', operador: '', texto: '' });
        },

        eliminar: function eliminar(filtro, operador) {
            Vue.delete(filtro.operadores, filtro.operadores.indexOf(operador));
            if (!filtro.operadores.length) {
                Vue.delete(this.filtros, this.filtros.indexOf(filtro));
            }
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'add_filtro') {
                    _this.set_filtro();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },
        obtenerPresupuestos: function obtenerPresupuestos() {
            var self = this;

            var tipoOrden = self.form.id_tipo_orden;

            $('#divDetalle').fadeOut();

            var url = App.host + '/control_presupuesto/afectacion_presupuesto/getBasesAfectadas';
            $.ajax({
                type: 'POST',
                data: {
                    tipo_orden: tipoOrden
                },
                url: url,
                beforeSend: function beforeSend() {
                    self.consultando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.bases_afectadas = data.data;
                },
                complete: function complete() {
                    self.consultando = false;
                }
            });
        }
    }
});

},{}],35:[function(require,module,exports){
'use strict';

Vue.component('cambio-presupuesto-index', {
    data: function data() {
        return {
            data: '',
            form: {
                id_tipo_cobrabilidad: '',
                id_tipo_orden: ''
            },
            tipos_cobrabilidad: [],
            tipos_orden: []
        };
    },
    computed: {
        tipos_orden_filtered: function tipos_orden_filtered() {
            var self = this;

            return self.tipos_orden.filter(function (tipo_orden) {
                return tipo_orden.id_tipo_cobrabilidad == self.form.id_tipo_cobrabilidad;
            });
        }
    },
    mounted: function mounted() {
        var self = this;

        this.fetchTiposCobrabilidad();
        this.fetchTiposOrden();

        $(function () {
            $(document).on('click', '.mostrar_pdf', function () {
                var _this = $(this),
                    id = _this.data('pdf_id'),
                    url = App.host + '/control_presupuesto/variacion_volumen/' + id + '/pdf';

                $('#formatoPDF').attr('src', url).hide();
                $('#spin_iframe').show();

                $('#pdf_modal').modal('show');

                $('#pdf_modal .modal-body').css({ height: '550px' });
                document.getElementById('formatoPDF').onload = function () {
                    $('#formatoPDF').show();
                    $('#spin_iframe').hide();
                };
            });
        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "searching": false,
            "ajax": {
                "url": App.host + '/control_presupuesto/cambio_presupuesto/paginate',
                "type": "POST",
                "beforeSend": function beforeSend() {
                    // self.guardando = true;
                },
                "complete": function complete() {
                    //self.guardando = false;
                },
                "dataSrc": function dataSrc(json) {

                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].created_at = new Date(json.data[i].created_at).dateFormat();
                        json.data[i].registro = json.data[i].user_registro.nombre + ' ' + json.data[i].user_registro.apaterno + ' ' + json.data[i].user_registro.amaterno;
                    }

                    return json.data;
                }
            },
            "columns": [{ data: 'numero_folio' }, { data: 'tipo_orden.descripcion' }, { data: 'created_at' }, { data: 'registro', orderable: false }, { data: 'estatus.descripcion' }, {
                data: {},
                render: function render(data, type, row, meta) {
                    var tipo_seleccionado = self.findTipoOrden(data.id_tipo_orden),
                        button = '<span class="label" ></span><button class="btn btn-xs btn-info mostrar_pdf" data-pdf_id="' + row.id + '" data-id_tipo_orden="' + data.id_tipo_orden + '" title="Formato"><i class="fa fa-file-pdf-o"></i></button>  ';

                    button += '<a title="Ver" href="' + App.host + '/control_presupuesto/' + tipo_seleccionado.name + '/' + data.id + '">';
                    button += '<button title="Ver" type="button" class="btn btn-xs btn-default" >';
                    button += '<i class="fa fa-eye"></i>';
                    button += '   </button>';
                    button += '  </a>';
                    return button;
                },
                orderable: false
            }],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        };

        $('#cierres_table').DataTable(data);
    },
    methods: {
        fetchTiposCobrabilidad: function fetchTiposCobrabilidad() {
            var self = this;
            $.ajax({
                url: App.host + '/control_presupuesto/tipo_cobrabilidad',
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.tipos_cobrabilidad = response;
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },
        fetchTiposOrden: function fetchTiposOrden() {
            var self = this;
            $.ajax({
                url: App.host + '/control_presupuesto/tipo_orden',
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.tipos_orden = response;
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },
        openSelectModal: function openSelectModal() {
            $('#select_modal').modal('show');
        },

        crearSolicitud: function crearSolicitud() {
            var self = this,
                tipo_seleccionado = self.findTipoOrden(self.form.id_tipo_orden);

            if (tipo_seleccionado === null) swal({
                title: 'Error',
                text: "El item seleccionado no es un tipo de solicitud válido",
                type: 'error'
            });

            // Redirecciona a la ruta correcta
            window.location.href = App.host + '/control_presupuesto/' + tipo_seleccionado.name + '/create';
        },
        findTipoOrden: function findTipoOrden(id) {
            var self = this;

            for (var i = 0; i < self.tipos_orden.length; i++) {
                if (self.tipos_orden[i]['id'] == id) return self.tipos_orden[i];
            }return null;
        }
    }

});

},{}],36:[function(require,module,exports){
'use strict';

Vue.component('escalatoria-create', {
    props: ['id_tipo_orden', 'bases_afectadas'],
    data: function data() {
        return {
            form: {
                partidas: [],
                motivo: ''
            },
            escalatoria: {
                monto: '',
                descripcion: ''
            },
            cargando: false,
            guardando: false
        };
    },

    computed: {
        datos: function datos() {
            var res = {
                id_tipo_orden: this.id_tipo_orden,
                motivo: this.form.motivo,
                partidas: []
            };
            this.form.partidas.forEach(function (value) {
                res.partidas.push({
                    monto_presupuestado: value.importe,
                    descripcion: value.descripcion
                });
            });
            return res;
        },
        subtotal: function subtotal() {
            var res = 0;

            this.form.partidas.forEach(function (partida) {
                res += parseFloat(partida.monto_presupuestado);
            });
            return res;
        }
    },
    mounted: function mounted() {
        var self = this;
    },

    methods: {

        removePartida: function removePartida(index) {
            Vue.delete(this.form.partidas, index);
        },

        addPartida: function addPartida() {
            var partida = _.clone(this.escalatoria);
            this.form.partidas.push(partida);
            this.escalatoria = {
                monto: '',
                descripcion: ''
            };
        },
        confirmSave: function confirmSave() {
            var self = this;
            swal({
                title: 'Guardar Solicitud de Cambio',
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function (result) {
                if (result.value) {
                    self.save();
                }
            });
        },

        save: function save() {
            var self = this;
            $.ajax({
                url: App.host + '/control_presupuesto/escalatoria',
                type: 'POST',
                data: self.datos,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(response) {
                    swal({
                        type: 'success',
                        title: '¡Correcto!',
                        html: 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                    }).then(function () {
                        window.location.href = App.host + '/control_presupuesto/escalatoria/' + response.id;
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_solicitud') {

                    _this.confirmSave();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        }
    }
});

},{}],37:[function(require,module,exports){
'use strict';

Vue.component('escalatoria-show', {
    props: ['solicitud', 'cobrabilidad', 'presupuestos'],
    data: function data() {
        return {
            form: {
                solicitud: this.solicitud,
                cobrabilidad: this.cobrabilidad
            },
            cargando: false,
            rechazando: false,
            autorizando: false,
            consultando: false,
            partidas: [],
            importes: [],
            partida_id: 0
        };
    },
    mounted: function mounted() {
        var self = this;

        $(function () {
            $(document).on('click', '.mostrar_pdf', function () {
                var _this = $(this),
                    id = _this.data('pdf_id'),
                    url = App.host + '/control_presupuesto/escalatoria/' + id + '/pdf';

                $('#formatoPDF').attr('src', url).hide();
                $('#spin_iframe').show();

                $('#pdf_modal').modal('show');

                $('#pdf_modal .modal-body').css({ height: '550px' });
                document.getElementById('formatoPDF').onload = function () {
                    $('#formatoPDF').show();
                    $('#spin_iframe').hide();
                };
            });
        });
    },
    methods: {
        confirm_autorizar_solicitud: function confirm_autorizar_solicitud() {
            var self = this;
            var id = self.form.solicitud.id;
            swal({
                title: "Autorizar la Solicitud de Cambio",
                html: "¿Estás seguro que desea actualizar la solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.autorizar_solicitud(id);
                }
            });
        },
        confirm_rechazar_solicitud: function confirm_rechazar_solicitud() {
            var self = this;
            var id = self.form.solicitud.id;
            swal({
                title: 'Rechazar Solicitud',
                text: 'Motivo del rechazo',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Rechazar ',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: false,
                preConfirm: function preConfirm(motivo) {
                    return new Promise(function (resolve) {
                        if (motivo.length === 0) {
                            swal.showValidationError('Por favor escriba un motivo para rechazar la solicitud.');
                        }
                        resolve();
                    });
                },
                allowOutsideClick: function allowOutsideClick() {
                    !swal.isLoading();
                }
            }).then(function (result) {
                if (result.value) {
                    self.rechazar_solicitud(id, result.value);
                }
            });
        },
        autorizar_solicitud: function autorizar_solicitud(id) {
            var self = this;
            var url = App.host + '/control_presupuesto/escalatoria/' + id + '/autorizar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id: id,
                    id_tipo_orden: self.form.solicitud.id_tipo_orden
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                    self.autorizando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud autorizada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location.reload(true);
                    });
                },
                complete: function complete() {
                    self.cargando = false;
                    self.autorizando = false;
                }
            });
        },
        rechazar_solicitud: function rechazar_solicitud(id, motivo) {
            var self = this;
            var url = App.host + '/control_presupuesto/escalatoria/' + id + '/rechazar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_solicitud_cambio: id,
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    motivo: motivo
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                    self.rechazando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud rechazada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location.reload(true);
                    });
                },
                complete: function complete() {
                    self.cargando = false;
                    self.rechazando = false;
                }
            });
        }
    }
});

},{}],38:[function(require,module,exports){
'use strict';

Vue.component('control-presupuesto-index', {
    data: function data() {
        return {};
    }
});

},{}],39:[function(require,module,exports){
'use strict';

Vue.component('variacion-volumen-create', {
    data: function data() {
        return {
            tarjetas: {},
            bases_afectadas: [],
            id_tarjeta: '',
            niveles: [{ nombre: 'Nivel 1', numero: 1 }, { nombre: 'Nivel 2', numero: 2 }, { nombre: 'Nivel 3', numero: 3 }, { nombre: 'Sector', numero: 4 }, { nombre: 'Cuadrante', numero: 5 }, { nombre: 'Especialidad', numero: 6 }, { nombre: 'Partida', numero: 7 }, { nombre: 'Sub Partida o Centa de costo', numero: 8 }, { nombre: 'Concepto', numero: 9 }, { nombre: 'Nivel 10', numero: 10 }, { nombre: 'Nivel 11', numero: 11 }],
            form: {
                partidas: [],
                motivo: '',
                area_solicitante: '',
                afectaciones: []
            },
            cargando: false,
            guardando: false,
            cargando_tarjetas: true
        };
    },

    computed: {
        datos: function datos() {
            var res = {
                motivo: this.form.motivo,
                afectaciones: this.form.afectaciones,
                area_solicitante: this.form.area_solicitante,
                partidas: []
            };
            this.form.partidas.forEach(function (value) {
                res.partidas.push({
                    id_concepto: value.id_concepto,
                    cantidad_presupuestada_original: value.cantidad_presupuestada,
                    variacion_volumen: value.variacion_volumen
                });
            });
            return res;
        },
        subtotal: function subtotal() {
            var res = 0;

            this.form.partidas.forEach(function (partida) {
                res += parseFloat(partida.monto_presupuestado);
            });
            return res;
        }
    },

    watch: {
        id_tarjeta: function id_tarjeta() {
            this.get_conceptos();
            this.form.partidas = [];
        }
    },

    mounted: function mounted() {
        var self = this;

        self.fetchTarjetas().then(function () {
            self.cargando_tarjetas = false;
            $('#conceptos_table').DataTable({
                "processing": true,
                "serverSide": true,
                "paging": false,
                "ordering": true,
                "searching": false,
                "ajax": {
                    "url": App.host + '/conceptos/getPathsConceptos',
                    "type": "POST",
                    "beforeSend": function beforeSend() {
                        self.cargando = true;
                    },
                    "data": function data(d) {
                        d.filtros = self.filtros;
                        d.id_tarjeta = self.id_tarjeta;
                    },
                    "complete": function complete() {
                        self.cargando = false;
                    },
                    "dataSrc": function dataSrc(json) {
                        for (var i = 0; i < json.data.length; i++) {
                            json.data[i].monto_presupuestado = '$' + parseFloat(json.data[i].monto_presupuestado).formatMoney(2, ',', '.');
                            json.data[i].cantidad_presupuestada = parseFloat(json.data[i].cantidad_presupuestada).formatMoney(2, ',', '.');
                            json.data[i].precio_unitario = '$' + parseFloat(json.data[i].precio_unitario).formatMoney(2, ',', '.');
                            json.data[i].filtro9_sub = json.data[i].filtro9.length > 50 ? json.data[i].filtro9.substr(0, 50) + '...' : json.data[i].filtro9;
                        }
                        return json.data;
                    }
                },
                "columns": [{ data: 'filtro1' }, { data: 'filtro2' }, { data: 'filtro3' }, { data: 'filtro4' }, { data: 'filtro5' }, { data: 'filtro6' }, { data: 'filtro7' }, { data: 'filtro8' }, {
                    data: {},
                    render: function render(data) {
                        return '<span title="' + data.filtro9 + '">' + data.filtro9_sub + '</span>';
                    }
                }, { data: 'filtro10' }, { data: 'filtro11' }, { data: 'unidad' }, { data: 'cantidad_presupuestada', className: 'text-right' }, { data: 'precio_unitario', className: 'text-right' }, { data: 'monto_presupuestado', className: 'text-right' }, {
                    data: {},
                    render: function render(data) {
                        if (self.existe(data.id_concepto)) {
                            return '<button class="btn btn-xs btn-default btn_remove_concepto" id="' + data.id_concepto + '"><i class="fa fa-minus text-red"></i></button>';
                        }
                        return '<button class="btn btn-xs btn-default btn_add_concepto" id="' + data.id_concepto + '"><i class="fa fa-plus text-green"></i></button>';
                    }
                }],
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        });
        self.fetchPresupuestos();

        $(document).on('click', '.btn_add_concepto', function () {
            var id = $(this).attr('id');
            self.addConcepto(id);
        }).on('click', '.btn_remove_concepto', function () {
            var id = $(this).attr('id');
            self.removeConcepto(id);
        });
    },

    methods: {
        fetchTarjetas: function fetchTarjetas() {
            var self = this;
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: App.host + '/control_presupuesto/tarjeta/lists',
                    type: 'GET',
                    beforeSend: function beforeSend() {
                        self.cargando = true;
                    },
                    success: function success(response) {
                        self.tarjetas = response;
                    },
                    complete: function complete() {
                        self.cargando = false;
                        resolve();
                    }
                });
            });
        },

        fetchPresupuestos: function fetchPresupuestos() {
            var self = this;

            var url = App.host + '/control_presupuesto/variacion_volumen/getBasesAfectadas';
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.bases_afectadas = data;
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        get_conceptos: function get_conceptos() {
            var table = $('#conceptos_table').DataTable();
            table.ajax.reload();
        },

        addConcepto: function addConcepto(id) {
            var self = this;
            $.ajax({
                url: App.host + '/conceptos/' + id,
                type: 'GET',
                beforeSend: function beforeSend() {
                    self.guardando = true;
                    $('#' + id).html('<i class="fa fa-spin fa-spinner"></i>');
                    $('#' + id).attr('disabled', true);
                },
                success: function success(response) {
                    self.form.partidas.push(response);
                    $('#' + id).html('<i class="fa fa-minus text-red"></i>');
                    $('#' + id).removeClass('btn_add_concepto');
                    $('#' + id).addClass('btn_remove_concepto');
                },
                complete: function complete() {
                    self.guardando = false;
                    $('#' + id).attr('disabled', false);
                },
                error: function error() {
                    $('#' + id).html('<i class="fa fa-plus text-green"></i>');
                }
            });
        },

        existe: function existe(id) {
            var found = this.form.partidas.find(function (partida) {
                return partida.id_concepto == id;
            });
            return found != undefined;
        },

        confirmSave: function confirmSave() {
            var self = this;
            swal({
                title: 'Guardar Solicitud de Cambio',
                text: "¿Está seguro de que la información es correcta?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Guardar',
                cancelButtonText: 'No, Cancelar'
            }).then(function (result) {
                if (result.value) {
                    self.save();
                }
            });
        },

        save: function save() {
            var self = this;
            $.ajax({
                url: App.host + '/control_presupuesto/variacion_volumen',
                type: 'POST',
                data: self.datos,
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {

                    var lista = [];

                    // Ya existen solicitudes con las partidas seleccionadas
                    if (typeof response.repetidas != 'undefined') {

                        $.each(response.repetidas, function (key, value) {
                            lista.push('<li class="list-group-item "><a href="' + App.host + '/control_presupuesto/variacion_volumen/' + value.id + '" onclick="swal.close();">#' + value.numero_folio + ' ' + (value.motivo.length >= 20 ? value.motivo.substring(0, 30) + '...' : value.motivo) + '</a></li>');
                        });

                        var texto = response.repetidas.length > 1 ? 'Ya existen solicitudes' : 'Ya existe una solicitud';

                        swal({
                            title: texto + " con los items seleccionados",
                            html: '<ul class="list-group">' + lista.join(' ') + '</ul>',
                            type: "warning",
                            showConfirmButton: true,
                            cancelButtonText: "Cancelar"
                        });
                        return;
                    }
                    swal({
                        type: 'success',
                        title: '¡Correcto!',
                        html: 'Solicitud Guardada con Número de Folio <b>' + response.numero_folio + '</b>'
                    }).then(function () {
                        window.location.href = App.host + '/control_presupuesto/variacion_volumen/' + response.id;
                    });
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        removeConcepto: function removeConcepto(id) {
            var index = this.form.partidas.map(function (partida) {
                return partida.id_concepto;
            }).indexOf(parseInt(id));
            this.form.partidas.splice(index, 1);
            $('#' + id).html('<i class="fa fa-plus text-green"></i>');
            $('#' + id).addClass('btn_add_concepto');
            $('#' + id).removeClass('btn_remove_concepto');
            if (!this.form.partidas.length) {
                $('#conceptos_modal').modal('hide');
            }
        },

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'save_solicitud') {
                    _this.confirmSave();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        }
    }
});

},{}],40:[function(require,module,exports){
'use strict';

Vue.component('variacion-volumen-show', {
    props: ['solicitud', 'cobrabilidad', 'presupuestos'],
    data: function data() {
        return {
            form: {
                solicitud: this.solicitud,
                cobrabilidad: this.cobrabilidad,
                afectaciones: []
            },
            cargando: false,
            rechazando: false,
            autorizando: false,
            consultando: false,
            partidas: [],
            importes: [],
            partida_id: 0
        };
    },

    mounted: function mounted() {

        this.fillAfectaciones();

        $(function () {
            $(document).on('click', '.mostrar_pdf', function () {
                var _this = $(this),
                    id = _this.data('pdf_id'),
                    url = App.host + '/control_presupuesto/variacion_volumen/' + id + '/pdf';

                $('#formatoPDF').attr('src', url).hide();
                $('#spin_iframe').show();

                $('#pdf_modal').modal('show');

                $('#pdf_modal .modal-body').css({ height: '550px' });
                document.getElementById('formatoPDF').onload = function () {
                    $('#formatoPDF').show();
                    $('#spin_iframe').hide();
                };
            });
        });
    },
    methods: {
        confirm_autorizar_solicitud: function confirm_autorizar_solicitud() {
            var self = this;
            var id = self.form.solicitud.id;

            swal({
                title: "Autorizar la Solicitud de Cambio",
                html: "¿Estás seguro que desea actualizar la solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.autorizar(id);
                }
            });
        },
        confirm_aplicar_solicitud: function confirm_aplicar_solicitud() {
            var self = this;
            var id = self.form.solicitud.id;

            swal({
                title: "Aplicar cambios a la Solicitud de Cambio",
                html: "¿Estás seguro que desea actualizar la solicitud?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.aplicar(id);
                }
            });
        },
        confirm_rechazar_solicitud: function confirm_rechazar_solicitud() {
            var self = this;
            var id = self.form.solicitud.id;

            $('.rechazar_solicitud').addClass('disabled');

            swal({
                title: 'Rechazar Solicitud',
                text: 'Motivo del rechazo',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Rechazar ',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: false,
                preConfirm: function preConfirm(motivo) {
                    return new Promise(function (resolve) {
                        if (motivo.length === 0) {
                            swal.showValidationError('Por favor escriba un motivo para rechazar la solicitud.');
                        }
                        resolve();
                    });
                },
                allowOutsideClick: function allowOutsideClick() {
                    !swal.isLoading();
                }
            }).then(function (result) {
                if (result.value) {
                    self.rechazar_solicitud(id, result.value);
                } else {
                    $('.rechazar_solicitud').removeClass('disabled');
                }
            });
        },
        autorizar: function autorizar(id) {
            var self = this;
            var url = App.host + '/control_presupuesto/variacion_volumen/' + id + '/autorizar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    afectaciones: self.form.afectaciones
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                    self.autorizando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud autorizada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location.reload(true);
                    });
                },
                complete: function complete() {
                    self.cargando = false;
                    self.autorizando = false;
                    $('.autorizar_solicitud').removeClass('disabled');
                }
            });
        },
        aplicar: function aplicar(id) {
            var self = this;
            var url = App.host + '/control_presupuesto/variacion_volumen/' + id + '/aplicar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    afectaciones: self.form.afectaciones
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                    self.autorizando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud aplicada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location.reload(true);
                    });
                },
                complete: function complete() {
                    self.cargando = false;
                    self.autorizando = false;
                }
            });
        },
        rechazar_solicitud: function rechazar_solicitud(id, motivo) {
            var self = this;
            var url = App.host + '/control_presupuesto/variacion_volumen/' + id + '/rechazar';
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    id_tipo_orden: self.form.solicitud.id_tipo_orden,
                    motivo: motivo
                },
                beforeSend: function beforeSend() {
                    self.cargando = true;
                    self.rechazando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        type: "success",
                        title: '¡Correcto!',
                        text: 'Solicitud rechazada correctamente.',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location.reload(true);
                    });
                },
                complete: function complete() {
                    self.cargando = false;
                    self.rechazando = false;
                    $('.rechazar_solicitud').removeClass('disabled');
                }
            });
        },
        mostrar_detalle_partida: function mostrar_detalle_partida(id) {
            var self = this;
            var partida = id;
            self.partida_id = id;
            var presupuesto = self.presupuestos[0].base_datos.id;
            $('#divDetalle').fadeOut();

            var url = App.host + '/control_presupuesto/cambio_presupuesto_partida/detallePresupuesto';
            $.ajax({
                type: 'POST',
                data: {
                    id_partida: partida,
                    presupuesto: presupuesto
                },
                url: url,
                beforeSend: function beforeSend() {
                    self.cargando = true;
                    self.consultando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.partidas = data.data;
                    $('#divDetalle').fadeIn();
                },
                complete: function complete() {
                    self.cargando = false;
                    self.consultando = false;
                }
            });
        },
        mostrar_detalle_presupuesto: function mostrar_detalle_presupuesto(idPresupuesto) {
            var self = this;
            var partida = self.partida_id;
            var presupuesto = idPresupuesto;
            $('#divDetalle').fadeOut();

            var url = App.host + '/control_presupuesto/cambio_presupuesto_partida/detallePresupuesto';
            $.ajax({
                type: 'POST',
                data: {
                    id_partida: partida,
                    presupuesto: presupuesto
                },
                url: url,
                beforeSend: function beforeSend() {
                    self.cargando = true;
                    self.consultando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.partidas = data.data;
                    $('#divDetalle').fadeIn();
                },
                complete: function complete() {
                    self.cargando = false;
                    self.consultando = false;
                }
            });
        },
        fillAfectaciones: function fillAfectaciones() {
            var self = this;
            self.form.afectaciones = [];
            self.solicitud.aplicaciones.forEach(function (value) {
                if (!self.aplicada(value.id)) {
                    self.form.afectaciones.push(value.id);
                }
            });
        },
        aplicada: function aplicada(id) {
            var res = false;
            this.solicitud.aplicaciones.forEach(function (value) {
                if (id == value.id && value.pivot.aplicada == 1) {
                    res = true;
                }
            });
            return res;
        },
        validateForm: function validateForm(scope, funcion) {
            var _this2 = this;

            this.$validator.validateAll(scope).then(function () {
                switch (funcion) {
                    case 'autorizar_solicitud':
                        _this2.confirm_autorizar_solicitud();
                        break;
                    case 'aplicar_solicitud':
                        _this2.confirm_aplicar_solicitud();
                        break;
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        }
    }
});

},{}],41:[function(require,module,exports){
'use strict';

Vue.component('comprobante-fondo-fijo-create', {
    props: ['url_comprobante_fondo_fijo_create'],

    data: function data() {
        return {
            'form': {
                'comprobante': {
                    'id_referente': '',
                    'referencia': '',
                    'cumplimiento': '',
                    'fecha': '',
                    'id_naturaleza': '',
                    'id_concepto': '',
                    'id_transaccion': '',
                    'observaciones': ''
                },
                'items': [],
                'total': '',
                'subtotal': '',
                'iva': '',
                'cambio_iva': false
            },
            current_item: {},
            guardando: false
        };
    },

    computed: {

        total: function total() {

            var self = this;
            var impuesto = 0;
            if (self.form.iva > 0) {
                impuesto = parseFloat(self.form.iva);
            }

            var subtotal = parseFloat(this.subtotal);
            var total = impuesto + subtotal;

            if (total > 0) {
                self.form.total = total.toFixed(2);
                total = total.toFixed(2);

                return total;
            } else {
                return 0;
            }
        },
        subtotal: function subtotal() {
            var self = this;
            var total = 0;

            if (self.form.comprobante.id_naturaleza == 0) {
                if (this.form.items) {
                    this.form.items.forEach(function (item) {
                        total += parseFloat(item.importe);
                    });
                }
            } else {
                if (this.form.items) {
                    this.form.items.forEach(function (item) {
                        total += parseFloat(item.cantidad * item.precio_unitario);
                    });
                }
            }

            if (total > 0) {
                total = total.toFixed(2);
                return parseFloat(total);
            } else {
                return 0;
            }
        }

    },

    mounted: function mounted() {
        var self = this;
        var jstree = "";
        var jstree2 = "";
        var auxiliar = 0;

        $('#concepto_select').on('select2:select', function () {

            if (auxiliar == 1) {
                jstree.destroy();
                jstree2.destroy();
            }
            carga_arbol();
            $('#id_concepto').val($('#concepto_select option:selected').data().data.id);
            self.form.comprobante.id_concepto = $('#concepto_select option:selected').data().data.id;
            $.each(self.form.items, function (key, item) {
                item.destino = '';
            });
        });

        $("#cumplimiento").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'cumplimiento', $('#cumplimiento').val());
        });

        $("#fecha").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'fecha', $('#fecha').val());
        });

        function carga_arbol() {
            // JsTree Configuration
            auxiliar = 1;
            var jstreeConf = {
                'core': {
                    'multiple': false,
                    'data': {
                        "url": function url(node) {

                            var conceptos = "";
                            var materiales = "";

                            if (node.id === "#") {
                                return App.host + '/conceptos/' + $('#id_concepto').val() + '/jstree';
                            }

                            return App.host + '/conceptos/' + node.id + '/jstree';
                        },
                        "data": function data(node) {
                            return {
                                "id": node.id
                            };
                        }
                    }
                },
                'types': {
                    'default': {
                        'icon': 'fa fa-folder-o text-success'
                    },
                    'medible': {
                        'icon': 'fa fa-file-text'
                    },
                    'material': {
                        'icon': 'fa fa-briefcase'
                    },
                    'opened': {
                        'icon': 'fa fa-folder-open-o text-success'
                    },
                    'inactivo': {
                        'icon': 'fa fa-exclamation-triangle'
                    }
                },
                'plugins': ['types']
            };

            $('#jstree').on("after_open.jstree", function (e, data) {

                var $item = $('#' + data.node.a_attr.id),
                    $ul = $item.next('ul'),
                    $anchor = $ul.find('a'),
                    $i = $anchor.find('i');

                // Revisa si el padre puede ser seleccionable
                if ($i.attr('class').indexOf('fa-briefcase') >= 0) {
                    $item.data('material_padre', true);

                    $item.css({
                        'color': 'black',
                        'cursor': 'pointer'
                    });
                } else {
                    $item.data('material_padre', false);
                }

                if (data.instance.get_type(data.node) == 'default') {
                    data.instance.set_type(data.node, 'opened');
                }
            }).on("after_close.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'opened') {
                    data.instance.set_type(data.node, 'default');
                }
                estilos_nodos();
            });

            /////////Arbol Materiales

            // JsTree Configuration
            var jstreeConfM = {
                'core': {
                    'multiple': false,
                    'data': {
                        "url": function url(node) {
                            if (node.id === "#") {
                                return App.host + '/almacen/jstree';
                            }
                            return App.host + '/almacen/' + node.id + '/jstree';
                        },
                        "data": function data(node) {
                            return {
                                "id": node.id
                            };
                        }
                    }
                },
                'types': {
                    'folder': {
                        'icon': 'fa fa-folder-o text-success'
                    },
                    'almacen': {
                        'icon': 'fa fa-briefcase'
                    },
                    'inactivo': {
                        'icon': 'fa fa-exclamation-triangle'
                    }

                },
                'plugins': ['types']
            };

            $('#jstreeM').on("select_node.jstree", function (e, data) {
                var jstreeD = $('#jstree').jstree(true);
                var node = jstreeD.get_selected(true)[0];
                $('#jstree').jstree(true).deselect_node(node);
                if (data.node.original.type == 'concepto' || data.node.original.type == 'inactivo') {
                    $('#jstreeM').jstree(true).deselect_node(data.node);
                }
            });

            $('#jstree').on("select_node.jstree", function (e, data) {

                // Material padre?
                var $item = $('#' + data.node.a_attr.id);

                var jstreeM = $('#jstreeM').jstree(true);
                var node = jstreeM.get_selected(true)[0];
                $('#jstreeM').jstree(true).deselect_node(node);

                if ($item.data('material_padre') === false && (data.node.original.type == 'concepto' || data.node.original.type == 'inactivo')) {
                    $('#jstree').jstree(true).deselect_node(data.node);
                }
            });

            $('#jstreeM').on("after_open.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'default') {
                    data.instance.set_type(data.node, 'opened');
                }
                estilos_nodos();
            }).on("after_close.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'opened') {
                    data.instance.set_type(data.node, 'default');
                }
            });

            $('#jstreeM').on("loaded.jstree", function (e, data) {
                estilos_nodos();
            });

            $('#jstree').on("loaded.jstree", function (e, data) {
                estilos_nodos();
            });

            // On hide the BS modal, get the selected node and destroy the jstree
            $('#myModal').on('shown.bs.modal', function (e) {
                $('#jstreeM').jstree(jstreeConfM);
                $('#jstree').jstree(jstreeConf);
            }).on('hidden.bs.modal', function (e) {

                jstree = $('#jstree').jstree(true);
                var node = jstree.get_selected(true)[0];
                jstree2 = $('#jstreeM').jstree(true);
                var node2 = jstree2.get_selected(true)[0];

                if (node) {
                    self.current_item.id_concepto = node.id;
                    self.current_item.tipo_concepto = "";
                    self.current_item.destino = node.text;
                } else {

                    if (node2) {
                        if (node2.type == 'almacen') self.current_item.id_concepto = node2.id;
                        self.current_item.tipo_concepto = node2.type;
                        self.current_item.destino = node2.text;
                    }
                }
            });
        }
        function estilos_nodos() {
            $(".fa-folder-o").parent("a").css("color", "gray");
            $(".fa-folder-o").parent("a").css("cursor", "not-allowed");
            $(".fa-folder-open-o").parent("a").css("color", "gray");
            $(".fa-folder-open-o").parent("a").css("cursor", "not-allowed");
            $(".fa-exclamation-triangle").parent("a").css("color", "gray");
            $(".fa-exclamation-triangle").parent("a").css("text-decoration", "line-through");
            $(".fa-exclamation-triangle").parent("a").css("cursor", "not-allowed");
        }
    },

    directives: {
        datepicker: {
            inserted: function inserted(el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        },
        select2: {
            inserted: function inserted(el) {
                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/sistema_contable/concepto/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function data(params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%'
                            };
                        },
                        processResults: function processResults(data) {
                            return {
                                results: $.map(data.data.conceptos, function (item) {
                                    return {
                                        text: item.path,
                                        id: item.id_concepto
                                    };
                                })
                            };
                        },
                        error: function error(_error) {},
                        cache: true
                    },
                    escapeMarkup: function escapeMarkup(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                });
            }
        },
        select_material: {

            inserted: function inserted(el) {
                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/finanzas/material/getBySinFamilias',
                        dataType: 'json',
                        delay: 500,
                        data: function data(params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%'
                            };
                        },
                        processResults: function processResults(data) {
                            return {
                                results: $.map(data.data.materiales, function (item) {
                                    return {
                                        text: item.descripcion,
                                        id: item.id_material,
                                        unidad: item.unidad
                                    };
                                })
                            };
                        },
                        error: function error(_error2) {},
                        cache: true
                    },
                    escapeMarkup: function escapeMarkup(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                }).on('select2:select', function () {
                    var id = el.id;

                    $('#I' + id).val($('#' + id + ' option:selected').data().data.id);
                    $('#L' + id).text($('#' + id + ' option:selected').data().data.unidad);
                    $('#UL' + id).text($('#' + id + ' option:selected').data().data.unidad);

                    $('#btn' + id).click();
                });
            }
        }
    },
    methods: {

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_save_fondo') {
                    _this.confirm_add_movimiento();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirm_add_movimiento: function confirm_add_movimiento() {
            var self = this;
            swal({
                title: "Guardar Comprobante de Fondo Fijo",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_comprobante_fondo_fijo();
                }
            });
        },

        add_item: function add_item() {
            var self = this;
            self.form.items.push({
                'id_transaccion': '',
                'id_concepto': '',
                'id_material': '',
                'cantidad': '',
                'precio_unitario': '',
                'importe': '',
                'destino': '',
                'unidad': '',
                'gastos_varios': '',
                'tipo_concepto': ''
            });
        },

        item_material: function item_material(id, item) {
            var idELemnt = id + 1;
            this.current_item = item;
            this.current_item.id_material = $('#I' + idELemnt).val();
        },

        curent_item: function curent_item(item) {
            this.current_item = item;
        },

        confirm_remove_item: function confirm_remove_item(index) {
            var self = this;
            swal({
                title: "Quitar Item",
                text: "¿Estás seguro de que deseas quitar el Item del comprobante?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.remove_item(index);
                }
            });
        },
        remove_item: function remove_item(index) {
            Vue.delete(this.form.items, index);
        },
        habilitaIva: function habilitaIva() {
            var self = this;
            self.form.iva = self.subtotal * .16;
        },
        save_comprobante_fondo_fijo: function save_comprobante_fondo_fijo() {
            var self = this;
            var url = this.url_comprobante_fondo_fijo_create;
            var data = self.form;
            console.log(url);
            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: 'Comprobante de Fondo Fijo guardado correctamente',
                        type: 'success',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = App.host + "/finanzas/comprobante_fondo_fijo/" + data.data.comprobante.id_transaccion;
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        }
    }
});

},{}],42:[function(require,module,exports){
'use strict';

Vue.component('comprobante-fondo-fijo-edit', {
    props: ['url_comprobante_fondo_fijo_update', 'url_comprobante_fondo_fijo_show', 'comprobante_items', 'comprobante'],

    data: function data() {
        return {
            'form': {
                'comprobante': this.comprobante,
                'items': this.comprobante_items,
                'total': '',
                'subtotal': '',
                'iva': this.comprobante.impuesto,
                'cambio_iva': false
            },
            current_item: {},
            guardando: false
        };
    },

    computed: {

        total: function total() {
            var self = this;
            var impuesto = parseFloat(self.form.iva);
            var subtotal = parseFloat(this.subtotal);
            var total = impuesto + subtotal;
            self.form.total = total.toFixed(2);

            total = total.toFixed(2);
            return total;
        },
        subtotal: function subtotal() {
            var self = this;
            var total = 0;
            if (this.form.items) {
                this.form.items.forEach(function (item) {

                    if (self.form.comprobante.id_naturaleza == 1) {
                        total += parseFloat(item.cantidad * item.precio_unitario);
                    } else {
                        total += parseFloat(item.importe);
                    }
                });
            }
            total = total.toFixed(2);
            return parseFloat(total);
        }

    },

    mounted: function mounted() {
        var self = this;
        var jstree = "";
        var jstree2 = "";

        $('#id_concepto').val(self.form.comprobante.id_concepto);
        $.each(self.form.items, function (key, item) {
            $('#I' + (key + 1)).val(item.id_material);
            $('#L' + (key + 1)).text(item.unidad);
        });

        $('#concepto_select').on('select2:select', function () {
            jstree.destroy();
            jstree2.destroy();
            carga_arbol();

            $('#id_concepto').val($('#concepto_select option:selected').data().data.id);
            self.form.comprobante.id_concepto = $('#concepto_select option:selected').data().data.id;
            $.each(self.form.items, function (key, item) {
                item.destino = '';
            });
        });

        $("#cumplimiento").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'cumplimiento', $('#cumplimiento').val());
        });

        $("#fecha").datepicker().on("changeDate", function () {
            Vue.set(self.form.comprobante, 'fecha', $('#fecha').val());
        });

        function carga_arbol() {
            // JsTree Configuration
            var jstreeConf = {
                'core': {
                    'multiple': false,
                    'data': {
                        "url": function url(node) {

                            var conceptos = "";
                            var materiales = "";

                            if (node.id === "#") {
                                return App.host + '/conceptos/' + $('#id_concepto').val() + '/jstree';
                            }

                            return App.host + '/conceptos/' + node.id + '/jstree';
                        },
                        "data": function data(node) {
                            return {
                                "id": node.id
                            };
                        }
                    }
                },
                'types': {
                    'default': {
                        'icon': 'fa fa-folder-o text-success'
                    },
                    'medible': {
                        'icon': 'fa fa-file-text'
                    },
                    'material': {
                        'icon': 'fa fa-briefcase'
                    },
                    'opened': {
                        'icon': 'fa fa-folder-open-o text-success'
                    },
                    'inactivo': {
                        'icon': 'fa fa-exclamation-triangle'
                    }
                },
                'plugins': ['types']
            };

            $('#jstreeM').on("select_node.jstree", function (e, data) {
                if (data.node.original.type == 'folder') {
                    $('#jstreeM').jstree(true).deselect_node(data.node);
                }
            });

            $('#jstree').on("after_open.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'default') {
                    data.instance.set_type(data.node, 'opened');
                }
            }).on("after_close.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'opened') {
                    data.instance.set_type(data.node, 'default');
                }
            });

            /////////Arbol Materiales

            // JsTree Configuration
            var jstreeConfM = {
                'core': {
                    'multiple': false,
                    'data': {
                        "url": function url(node) {
                            if (node.id === "#") {
                                return App.host + '/almacen/jstree';
                            }
                            return App.host + '/almacen/' + node.id + '/jstree';
                        },
                        "data": function data(node) {
                            return {
                                "id": node.id
                            };
                        }
                    }
                },
                'types': {
                    'folder': {
                        'icon': 'fa fa-folder-o text-success'
                    },
                    'almacen': {
                        'icon': 'fa fa-briefcase'
                    },
                    'inactivo': {
                        'icon': 'fa fa-exclamation-triangle'
                    }

                },
                'plugins': ['types']
            };

            $('#jstreeM').on("select_node.jstree", function (e, data) {
                var jstreeD = $('#jstree').jstree(true);
                var node = jstreeD.get_selected(true)[0];
                $('#jstree').jstree(true).deselect_node(node);
                if (data.node.original.type == 'concepto' || data.node.original.type == 'inactivo') {
                    $('#jstreeM').jstree(true).deselect_node(data.node);
                }
            });

            $('#jstree').on("select_node.jstree", function (e, data) {

                var jstreeM = $('#jstreeM').jstree(true);
                var node = jstreeM.get_selected(true)[0];
                $('#jstreeM').jstree(true).deselect_node(node);

                if (data.node.original.type == 'concepto' || data.node.original.type == 'inactivo') {
                    $('#jstree').jstree(true).deselect_node(data.node);
                }
            });
            $('#jstree').on("after_open.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'default') {
                    data.instance.set_type(data.node, 'opened');
                }
                estilos_nodos();
            }).on("after_close.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'opened') {
                    data.instance.set_type(data.node, 'default');
                }
            });

            $('#jstreeM').on("loaded.jstree", function (e, data) {
                estilos_nodos();
            });

            $('#jstree').on("loaded.jstree", function (e, data) {
                estilos_nodos();
            });

            $('#jstreeM').on("after_open.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'default') {
                    data.instance.set_type(data.node, 'opened');
                }
                estilos_nodos();
            }).on("after_close.jstree", function (e, data) {
                if (data.instance.get_type(data.node) == 'opened') {
                    data.instance.set_type(data.node, 'default');
                }
            });

            // On hide the BS modal, get the selected node and destroy the jstree
            $('#myModal').on('shown.bs.modal', function (e) {
                $('#jstreeM').jstree(jstreeConfM);
                $('#jstree').jstree(jstreeConf);
            }).on('hidden.bs.modal', function (e) {

                jstree = $('#jstree').jstree(true);
                var node = jstree.get_selected(true)[0];
                jstree2 = $('#jstreeM').jstree(true);
                var node2 = jstree2.get_selected(true)[0];

                if (node) {
                    self.current_item.id_concepto = node.id;
                    self.current_item.tipo_concepto = "";
                    self.current_item.destino = node.text;
                } else {
                    if (node2) {
                        if (node2.type == 'almacen') self.current_item.id_concepto = node2.id;
                        self.current_item.tipo_concepto = node2.type;
                        self.current_item.destino = node2.text;
                    }
                }
                //   jstree.destroy();
                //  jstree2.destroy();
            });
        }

        function estilos_nodos() {
            $(".fa-folder-o").parent("a").css("color", "gray");
            $(".fa-folder-o").parent("a").css("cursor", "not-allowed");
            $(".fa-folder-open-o").parent("a").css("color", "gray");
            $(".fa-folder-open-o").parent("a").css("cursor", "not-allowed");
            $(".fa-exclamation-triangle").parent("a").css("color", "gray");
            $(".fa-exclamation-triangle").parent("a").css("text-decoration", "line-through");
            $(".fa-exclamation-triangle").parent("a").css("cursor", "not-allowed");
            $(".fa-folder-o").parent("a").unbind("click");
        }
        carga_arbol();
    },

    directives: {
        datepicker: {
            inserted: function inserted(el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        },
        select2: {
            inserted: function inserted(el) {
                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/sistema_contable/concepto/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function data(params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%'
                            };
                        },
                        processResults: function processResults(data) {
                            return {
                                results: $.map(data.data.conceptos, function (item) {
                                    return {
                                        text: item.path,
                                        id: item.id_concepto
                                    };
                                })
                            };
                        },
                        error: function error(_error) {},
                        cache: true
                    },
                    escapeMarkup: function escapeMarkup(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                });
            }
        },
        select_material: {

            inserted: function inserted(el) {
                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/finanzas/material/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function data(params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%'
                            };
                        },
                        processResults: function processResults(data) {
                            return {
                                results: $.map(data.data.materiales, function (item) {
                                    return {
                                        text: item.descripcion,
                                        id: item.id_material,
                                        unidad: item.unidad
                                    };
                                })
                            };
                        },
                        error: function error(_error2) {},
                        cache: true
                    },
                    escapeMarkup: function escapeMarkup(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                }).on('select2:select', function () {
                    var id = el.id;

                    $('#I' + id).val($('#' + id + ' option:selected').data().data.id);
                    $('#L' + id).text($('#' + id + ' option:selected').data().data.unidad);
                    $('#UL' + id).text($('#' + id + ' option:selected').data().data.unidad);

                    $('#btn' + id).click();
                });
            }
        }
    },
    methods: {

        validateForm: function validateForm(scope, funcion) {
            var _this = this;

            this.$validator.validateAll(scope).then(function () {
                if (funcion == 'confirm_save_fondo') {
                    _this.confirm_add_movimiento();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },

        confirm_add_movimiento: function confirm_add_movimiento() {
            var self = this;
            swal({
                title: "Actualizar Comprobante de Fondo Fijo",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.save_comprobante_fondo_fijo();
                }
            });
        },

        add_item: function add_item() {
            var self = this;
            self.form.items.push({
                'id_transaccion': '',
                'id_concepto': '',
                'id_material': '',
                'cantidad': '',
                'precio_unitario': '',
                'importe': '',
                'destino': '',
                'unidad': '',

                'gastos_varios': ''
            });
        },

        item_material: function item_material(id, item) {
            var idELemnt = id + 1;
            this.current_item = item;
            this.current_item.id_material = $('#I' + idELemnt).val();
        },

        curent_item: function curent_item(item) {
            this.current_item = item;
        },

        habilitaIva: function habilitaIva() {
            var self = this;
            self.form.iva = self.subtotal * .16;
        },
        save_comprobante_fondo_fijo: function save_comprobante_fondo_fijo() {
            var self = this;
            var url = this.url_comprobante_fondo_fijo_update;
            var data = self.form;
            data['_method'] = 'PATCH';

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    swal({
                        title: '¡Correcto!',
                        html: 'Comprobante de Fondo Fijo actualizado correctamente',
                        type: 'success',
                        confirmButtonText: "Ok",
                        closeOnConfirm: false
                    }).then(function () {
                        window.location = self.url_comprobante_fondo_fijo_show;
                    });
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        }
    }
});

},{}],43:[function(require,module,exports){
'use strict';

Vue.component('comprobante-fondo-fijo-index', {
    props: ['consultar_comprobante_fondo_fijo', 'editar_comprobante_fondo_fijo', 'eliminar_comprobante_fondo_fijo'],
    data: function data() {
        return {};
    },

    mounted: function mounted() {
        var self = this;

        $(document).on('click', '.btn_delete', function () {
            var id = $(this).attr('id');
            self.delete_comprobante(id);
        });

        var data = {
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "searching": false,
            "order": [[5, "desc"]],
            "ajax": {
                "url": App.host + '/finanzas/comprobante_fondo_fijo/paginate',
                "type": "POST",
                "beforeSend": function beforeSend() {
                    self.guardando = true;
                },
                "complete": function complete() {
                    self.guardando = false;
                },
                "dataSrc": function dataSrc(json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].monto = '$' + parseFloat(json.data[i].monto).formatMoney(2, ',', '.');
                        json.data[i].fecha = new Date(json.data[i].fecha).dateFormat();
                        json.data[i].FechaHoraRegistro = new Date(json.data[i].FechaHoraRegistro).dateFormat();
                    }
                    return json.data;
                }
            },
            "columns": [{ data: 'numero_folio' }, { data: 'FondoFijo' }, { data: 'monto', className: 'text-right' }, { data: 'fecha' }, { data: 'referencia' }, { data: 'FechaHoraRegistro' }, {
                data: {},
                render: function render(data) {
                    return (self.consultar_comprobante_fondo_fijo ? '<a href="' + App.host + '/finanzas/comprobante_fondo_fijo/' + data.id_transaccion + '" title="Ver" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>' : '') + (self.editar_comprobante_fondo_fijo ? '<a href="' + App.host + '/finanzas/comprobante_fondo_fijo/' + data.id_transaccion + '/edit' + '" title="Editar" class="btn btn-xs btn-info"> <i class="fa fa-pencil"></i></a>' : '') + (self.eliminar_comprobante_fondo_fijo ? '<button title="Eliminar" type="button" class="btn btn-xs btn-danger btn_delete" id="' + data.id_transaccion + '"><i class="fa fa-trash"></i></button>' : '');
                },
                orderable: false
            }],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        };

        $('#comprobantes_table').DataTable(data);
    },

    methods: {
        delete_comprobante: function delete_comprobante(id) {
            var url = App.host + "/finanzas/comprobante_fondo_fijo/" + id;

            swal({
                title: "Eliminar Comprobante de Fondo Fijo",
                text: "¿Estás seguro que desea eliminar el comprobante de fondo fijo?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _method: 'DELETE'
                        },
                        success: function success(data, textStatus, xhr) {
                            swal({
                                type: "success",
                                title: '¡Correcto!',
                                text: 'Comprobante de Fondo Fijo Eliminado con éxito'
                            });
                        },
                        complete: function complete() {
                            $('#comprobantes_table').DataTable().ajax.reload();
                        }
                    });
                }
            });
        }
    }
});

},{}],44:[function(require,module,exports){
'use strict';

Vue.component('subcontratos-estimacion', {
    props: ['subcontratos_url', 'estimaciones_url'],
    data: function data() {
        return {
            'form': {
                id_empresa: '',
                id_subcontrato: '',
                id_estimacion: ''
            },
            'empresas': [],
            'subcontratos': [],
            'estimaciones': [],
            'cargando': false
        };
    },

    methods: {
        fetchSubcontratos: function fetchSubcontratos(id_empresa) {
            var self = this;

            $.ajax({
                type: 'GET',
                data: {
                    attribute: 'id_empresa',
                    operator: '=',
                    value: id_empresa
                },
                url: self.subcontratos_url + '/getBy',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.subcontratos = response.data.subcontratos;
                    self.estimaciones = [];

                    Vue.set(self.form, 'id_subcontrato', '');
                    Vue.set(self.form, 'id_estimacion', '');
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        fetchEstimaciones: function fetchEstimaciones(id_subcontrato) {
            var self = this;

            $.ajax({
                type: 'GET',
                data: {
                    attribute: 'id_antecedente',
                    operator: '=',
                    value: id_subcontrato
                },
                url: self.estimaciones_url + '/getBy',
                beforeSend: function beforeSend() {
                    self.cargando = true;
                },
                success: function success(response) {
                    self.estimaciones = response.data.estimaciones;
                    Vue.set(self.form, 'id_estimacion', '');
                },
                complete: function complete() {
                    self.cargando = false;
                }
            });
        },

        pdf: function pdf(id_estimacion) {
            var url = App.host + '/formatos/subcontratos/estimacion/' + id_estimacion;
            $("#PDFModal .modal-body").html('<iframe src="' + url + '"  frameborder="0" height="100%" width="99.6%">d</iframe>');
            $("#PDFModal").modal("show");
        }
    }
});

},{}],45:[function(require,module,exports){
'use strict';

Vue.component('movimientos_bancarios-index', {
    props: ['url_movimientos_bancarios_index', 'cuentas', 'tipos', 'movimientos'],
    data: function data() {
        return {
            'data': {
                'cuentas': this.cuentas,
                'tipos': this.tipos,
                'movimientos': this.movimientos,
                'ver': []
            },
            'form': {
                'id_tipo_movimiento': '',
                'estatus': '',
                'id_cuenta': '',
                'impuesto': '0',
                'importe': '',
                'observaciones': '',
                'fecha': moment().format('YYYY-MM-DD'),
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'movimiento_edit': {
                'id_movimiento_bancario': '',
                'id_tipo_movimiento': '',
                'estatus': '',
                'id_cuenta': '',
                'impuesto': 0,
                'importe': 0,
                'observaciones': '',
                'fecha': '',
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'movimiento_ver': {
                'id_movimiento_bancario': '',
                'id_tipo_movimiento': '',
                'estatus': '',
                'id_cuenta': '',
                'impuesto': 0,
                'importe': 0,
                'observaciones': '',
                'fecha': '',
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'guardando': false
        };
    },
    computed: {},
    mounted: function mounted() {
        var self = this;

        $("#Cumplimiento").datepicker().on("changeDate", function () {
            Vue.set(self.form, 'vencimiento', $('#Cumplimiento').val());
            Vue.set(self.form, 'cumplimiento', $('#Cumplimiento').val());
        });
        $("#edit_cumplimiento").datepicker().on("changeDate", function () {
            Vue.set(self.movimiento_edit, 'vencimiento', $('#edit_cumplimiento').val());
            Vue.set(self.movimiento_edit, 'cumplimiento', $('#edit_cumplimiento').val());
        });
        $("#Fecha").datepicker().on("changeDate", function () {
            var thisElement = $(this);

            Vue.set(self.form, 'fecha', thisElement.val());
            thisElement.datepicker('hide');
            thisElement.blur();
            self.$validator.validate('required', self.form.fecha);
        });
        $(".fechas_edit").datepicker().on("changeDate", function () {
            var thisElement = $(this);
            var id = thisElement.attr('id').replace('edit_', '');

            Vue.set(self.traspaso_edit, id, thisElement.val());
        });
    },
    directives: {
        datepicker: {
            inserted: function inserted(el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        }
    },
    methods: {
        datos_cuenta: function datos_cuenta(id) {
            return this.cuentas[id];
        },
        modal_movimiento_ver: function modal_movimiento_ver(item) {
            Vue.set(this.data, 'ver', item);
            Vue.set(this.data.ver, 'tipo_texto', item.tipo.descripcion);
            Vue.set(this.data.ver, 'importe', this.comma_format(item.importe));
            Vue.set(this.data.ver, 'impuesto', this.comma_format(item.impuesto));
            Vue.set(this.data.ver, 'cuenta_texto', item.cuenta.numero + ' ' + item.cuenta.abreviatura + ' (' + item.cuenta.empresa.razon_social + ')');
            Vue.set(this.data.ver, 'referencia', item.movimiento_transaccion.transaccion.referencia);
            Vue.set(this.data.ver, 'cumplimiento', this.trim_fecha(item.movimiento_transaccion.transaccion.cumplimiento));
            Vue.set(this.data.ver, 'vencimiento', this.trim_fecha(item.movimiento_transaccion.transaccion.vencimiento));

            $('#ver_movimiento_modal').modal('show');
        },
        close_modal_movimiento_ver: function close_modal_movimiento_ver() {

            $('#ver_movimiento_modal').modal('hide');
            Vue.set(this.data, 'ver', {});
        },
        confirm_guardar: function confirm_guardar() {
            var self = this;
            swal({
                title: "Guardar movimiento",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.guardar();
                }
            }).catch(swal.noop);
        },
        guardar: function guardar() {
            var self = this;

            $.ajax({
                type: 'POST',
                url: self.url_movimientos_bancarios_index,
                data: self.form,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    if (typeof data.data.movimiento === 'string') {
                        swal({
                            type: 'warning',
                            title: 'Error',
                            html: data.data.movimiento
                        });
                    } else {
                        self.data.movimientos.push(data.data.movimiento);
                        swal({
                            type: 'success',
                            title: 'Correcto',
                            html: 'Movimiento guardado correctamente'
                        });
                    }
                },
                complete: function complete() {
                    self.guardando = false;
                    self.close_modal_movimiento();
                }
            });
        },
        modal_movimiento: function modal_movimiento() {
            $('#movimiento_modal').modal('show');
            $('#id_tipo_movimiento').focus();
        },
        close_modal_movimiento: function close_modal_movimiento() {
            this.reset_form();
            $('#movimiento_modal').modal('hide');
        },
        confirm_eliminar: function confirm_eliminar(id_movimiento_bancario) {
            var self = this;
            swal({
                title: "Eliminar movimiento",
                text: "¿Estás seguro/a de que deseas eliminar este movimiento?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.eliminar(id_movimiento_bancario);
                }
            }).catch(swal.noop);
        },
        eliminar: function eliminar(id_movimiento_bancario) {
            var self = this;
            $.ajax({
                type: 'GET',
                url: self.url_movimientos_bancarios_index + '/' + id_movimiento_bancario,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {
                    self.data.movimientos.forEach(function (movimiento) {
                        if (movimiento.id_movimiento_bancario == data.data.id_movimiento_bancario) {
                            self.data.movimientos.splice(self.data.movimientos.indexOf(movimiento), 1);
                        }
                    });

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Movimiento eliminado'
                    });
                },
                complete: function complete() {}
            });
        },
        modal_editar: function modal_editar(movimiento) {
            Vue.set(this.movimiento_edit, 'id_movimiento_bancario', movimiento.id_movimiento_bancario);
            Vue.set(this.movimiento_edit, 'id_tipo_movimiento', movimiento.id_tipo_movimiento);
            Vue.set(this.movimiento_edit, 'estatus', movimiento.estatus);
            Vue.set(this.movimiento_edit, 'id_cuenta', movimiento.id_cuenta);
            Vue.set(this.movimiento_edit, 'impuesto', movimiento.impuesto);
            Vue.set(this.movimiento_edit, 'importe', movimiento.importe);
            Vue.set(this.movimiento_edit, 'observaciones', movimiento.observaciones);
            Vue.set(this.movimiento_edit, 'fecha', this.trim_fecha(movimiento.movimiento_transaccion.transaccion.fecha));
            Vue.set(this.movimiento_edit, 'cumplimiento', this.trim_fecha(movimiento.movimiento_transaccion.transaccion.cumplimiento));
            Vue.set(this.movimiento_edit, 'vencimiento', this.trim_fecha(movimiento.movimiento_transaccion.transaccion.vencimiento));
            Vue.set(this.movimiento_edit, 'referencia', movimiento.movimiento_transaccion.transaccion.referencia);

            this.validation_errors.clear('form_editar_movimiento');
            $('#edit_movimiento_modal').modal('show');
            $('#edit_id_cuenta').focus();
        },
        confirm_editar: function confirm_editar() {
            var self = this;
            swal({
                title: "Editar movimiento",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.editar();
                }
            }).catch(swal.noop);
        },
        editar: function editar() {
            var self = this;

            self.movimiento_edit._method = 'PATCH';
            $.ajax({
                type: 'POST',
                url: self.url_movimientos_bancarios_index + '/' + self.movimiento_edit.id_movimiento_bancario,
                data: self.movimiento_edit,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {
                    if (typeof data.data.movimiento === 'string') {
                        swal({
                            type: 'warning',
                            title: 'Error',
                            html: data.data.movimiento
                        });
                    } else {
                        self.data.movimientos.forEach(function (movimiento) {
                            if (movimiento.id_movimiento_bancario === data.data.movimiento.id_movimiento_bancario) {
                                Vue.set(self.data.movimientos, self.data.movimientos.indexOf(movimiento), data.data.movimiento);
                            }
                        });
                        swal({
                            type: 'success',
                            title: 'Correcto',
                            html: 'movimiento guardado correctamente'
                        });
                    }

                    self.close_edit_movimiento();
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        close_edit_movimiento: function close_edit_movimiento() {
            $('#edit_movimiento_modal').modal('hide');
        },
        validateForm: function validateForm(scope, funcion) {
            self = this;
            this.$validator.validateAll(scope).then(function () {
                if (funcion === 'confirm_guardar') {
                    self.confirm_guardar();
                } else if (funcion === 'confirm_editar') {
                    self.confirm_editar();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },
        trim_fecha: function trim_fecha(fecha) {
            return fecha.substring(0, 10);
        },
        reset_form: function reset_form() {
            Vue.set(this.form, 'id_tipo_movimiento', '');
            Vue.set(this.form, 'estatus', '');
            Vue.set(this.form, 'id_cuenta', '');
            Vue.set(this.form, 'impuesto', '');
            Vue.set(this.form, 'observaciones', '');
            Vue.set(this.form, 'importe', '');
            Vue.set(this.form, 'fecha', '');
            Vue.set(this.form, 'cumplimiento', '');
            Vue.set(this.form, 'vencimiento', '');
            Vue.set(this.form, 'referencia', '');
        },
        total_edit: function total_edit() {
            var importe = this.movimiento_edit.importe == null ? 0 : this.movimiento_edit.importe,
                impuesto = this.movimiento_edit.impuesto == null ? 0 : this.movimiento_edit.impuesto;

            return impuesto > 0 ? parseFloat(importe) + parseFloat(impuesto) : importe;
        },
        total_create: function total_create() {
            var importe = this.form.importe == null ? 0 : this.form.importe,
                impuesto = this.form.impuesto == null ? 0 : this.form.impuesto;

            return impuesto > 0 ? parseFloat(importe) + parseFloat(impuesto) : importe;
        },
        total: function total(importe, impuesto) {
            var importe = importe == null ? 0 : importe,
                impuesto = impuesto == null ? 0 : impuesto;

            return impuesto > 0 ? parseFloat(importe) + parseFloat(impuesto) : importe;
        },
        comma_format: function comma_format(number) {
            var n = !isFinite(+number) ? 0 : +number,
                decimals = 4,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
                dec = typeof dec_point === 'undefined' ? '.' : dec_point,
                toFixedFix = function toFixedFix(n, prec) {
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                var k = Math.pow(10, prec);
                return Math.round(n * k) / k;
            },
                s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    }
});

},{}],46:[function(require,module,exports){
'use strict';

Vue.component('traspaso-cuentas-index', {
    props: ['url_traspaso_cuentas_index', 'cuentas', 'traspasos', 'monedas'],
    data: function data() {
        return {
            'data': {
                'traspasos': this.traspasos,
                'cuentas': this.cuentas,
                'monedas': this.monedas,
                'ver': []
            },
            'form': {
                'id_cuenta_origen': '',
                'id_cuenta_destino': '',
                'observaciones': '',
                'importe': '',
                'fecha': moment().format('YYYY-MM-DD'),
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'traspaso_edit': {
                'id_traspaso': '',
                'id_cuenta_origen': '',
                'id_cuenta_destino': '',
                'observaciones': '',
                'importe': '',
                'fecha': '',
                'cumplimiento': '',
                'vencimiento': '',
                'referencia': ''
            },
            'guardando': false
        };
    },
    computed: {
        cuentas_disponibles: function cuentas_disponibles() {
            var self = this;
            return this.cuentas.filter(function (cuenta) {
                return cuenta.id_cuenta != self.form.id_cuenta_origen;
            });
        }
    },
    mounted: function mounted() {
        var self = this;

        $("#cumplimiento").datepicker().on("changeDate", function () {
            Vue.set(self.form, 'vencimiento', $('#cumplimiento').val());
            Vue.set(self.form, 'cumplimiento', $('#cumplimiento').val());
        });
        $("#Fecha").datepicker().on("changeDate", function () {
            var thisElement = $(this);

            Vue.set(self.form, 'fecha', thisElement.val());
            thisElement.datepicker('hide');
            thisElement.blur();
            self.$validator.validate('required', self.form.fecha);
        });
        $(".fechas_edit").datepicker().on("changeDate", function () {
            var thisElement = $(this);
            var id = thisElement.attr('id').replace('edit_', '');

            Vue.set(self.traspaso_edit, id, thisElement.val());
        });
    },
    directives: {
        datepicker: {
            inserted: function inserted(el) {
                $(el).datepicker({
                    autoclose: true,
                    language: 'es',
                    todayHighlight: true,
                    clearBtn: true,
                    format: 'yyyy-mm-dd'
                });
            }
        }
    },
    methods: {
        datos_cuenta: function datos_cuenta(id) {
            return this.cuentas[id];
        },
        confirm_guardar: function confirm_guardar() {
            var self = this;
            swal({
                title: "Guardar traspaso",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.guardar();
                }
            }).catch(swal.noop);
        },
        guardar: function guardar() {
            var self = this;

            $.ajax({
                type: 'POST',
                url: self.url_traspaso_cuentas_index,
                data: self.form,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {

                    // Si data.traspaso es un string hubo un error al guardar el traspaso
                    if (typeof data.data.traspaso === 'string') {
                        swal({
                            type: 'warning',
                            title: 'Error',
                            html: data.data.traspaso
                        });
                    } else {
                        self.data.traspasos.push(data.data.traspaso);
                        swal({
                            type: 'success',
                            title: 'Correcto',
                            html: 'Traspaso guardado correctamente'
                        });
                    }
                },
                complete: function complete() {
                    self.guardando = false;
                    self.close_traspaso();
                }
            });
        },
        confirm_eliminar: function confirm_eliminar(id_traspaso) {
            var self = this;
            swal({
                title: "Eliminar traspaso",
                text: "¿Estás seguro/a de que deseas eliminar este traspaso?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.eliminar(id_traspaso);
                }
            }).catch(swal.noop);
        },
        eliminar: function eliminar(id_traspaso) {
            var self = this;
            $.ajax({
                type: 'GET',
                url: self.url_traspaso_cuentas_index + '/' + id_traspaso,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {
                    self.data.traspasos.forEach(function (traspaso) {
                        if (traspaso.id_traspaso === id_traspaso) {
                            self.data.traspasos.splice(self.data.traspasos.indexOf(traspaso), 1);
                        }
                    });

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso eliminado'
                    });
                },
                complete: function complete() {}
            });
        },
        modal_ver_traspaso: function modal_ver_traspaso(item) {
            Vue.set(this.data, 'ver', item);
            Vue.set(this.data.ver, 'fecha', this.trim_fecha(item.traspaso_transaccion.transaccion_debito.fecha));
            Vue.set(this.data.ver, 'importe', this.comma_format(item.importe));
            Vue.set(this.data.ver, 'cumplimiento', this.trim_fecha(item.traspaso_transaccion.transaccion_debito.cumplimiento));
            Vue.set(this.data.ver, 'vencimiento', this.trim_fecha(item.traspaso_transaccion.transaccion_debito.vencimiento));
            Vue.set(this.data.ver, 'referencia', item.traspaso_transaccion.transaccion_debito.referencia);
            Vue.set(this.data.ver, 'cuenta_origen_texto', item.cuenta_origen.numero + ' ' + item.cuenta_origen.abreviatura + ' (' + item.cuenta_origen.empresa.razon_social + ')');
            Vue.set(this.data.ver, 'cuenta_destino_texto', item.cuenta_destino.numero + ' ' + item.cuenta_destino.abreviatura + ' (' + item.cuenta_destino.empresa.razon_social + ')');

            $('#ver_traspaso_modal').modal('show');
        },
        close_modal_ver_traspaso: function close_modal_ver_traspaso() {
            $('#ver_traspaso_modal').modal('hide');
            Vue.set(this.data, 'ver', []);
        },
        modal_traspaso: function modal_traspaso() {
            this.validation_errors.clear('form_guardar_traspaso');
            this.$validator.clean();
            $('#traspaso_modal').modal('show');
            $('#id_cuenta_origen').focus();
        },
        close_traspaso: function close_traspaso() {
            this.reset_form();
            $('#traspaso_modal').modal('hide');
        },
        modal_editar: function modal_editar(traspaso) {

            Vue.set(this.traspaso_edit, 'id_traspaso', traspaso.id_traspaso);
            Vue.set(this.traspaso_edit, 'id_cuenta_origen', traspaso.id_cuenta_origen);
            Vue.set(this.traspaso_edit, 'id_cuenta_destino', traspaso.id_cuenta_destino);
            Vue.set(this.traspaso_edit, 'observaciones', traspaso.observaciones);
            Vue.set(this.traspaso_edit, 'importe', traspaso.importe);
            Vue.set(this.traspaso_edit, 'fecha', this.trim_fecha(traspaso.traspaso_transaccion.transaccion_debito.fecha));
            Vue.set(this.traspaso_edit, 'cumplimiento', this.trim_fecha(traspaso.traspaso_transaccion.transaccion_debito.cumplimiento));
            Vue.set(this.traspaso_edit, 'vencimiento', this.trim_fecha(traspaso.traspaso_transaccion.transaccion_debito.vencimiento));
            Vue.set(this.traspaso_edit, 'referencia', traspaso.traspaso_transaccion.transaccion_debito.referencia);

            this.validation_errors.clear('form_editar_traspaso');
            $('#edit_traspaso_modal').modal('show');
            $('#edit_id_cuenta_origen').focus();
        },
        confirm_editar: function confirm_editar() {
            var self = this;
            swal({
                title: "Editar traspaso",
                text: "¿Estás seguro/a de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function (result) {
                if (result.value) {
                    self.editar();
                }
            }).catch(swal.noop);
        },
        editar: function editar() {
            var self = this;

            self.traspaso_edit._method = 'PATCH';
            $.ajax({
                type: 'POST',
                url: self.url_traspaso_cuentas_index + '/' + self.traspaso_edit.id_traspaso,
                data: self.traspaso_edit,
                beforeSend: function beforeSend() {},
                success: function success(data, textStatus, xhr) {

                    self.data.traspasos.forEach(function (traspaso) {
                        if (traspaso.id_traspaso === data.data.traspaso.id_traspaso) {
                            Vue.set(self.data.traspasos, self.data.traspasos.indexOf(traspaso), data.data.traspaso);
                        }
                    });
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Traspaso guardado correctamente'
                    });

                    self.close_edit_traspaso();
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        },
        close_edit_traspaso: function close_edit_traspaso() {
            $('#edit_traspaso_modal').modal('hide');
        },
        validateForm: function validateForm(scope, funcion) {
            self = this;
            this.$validator.validateAll(scope).then(function () {
                if (funcion === 'confirm_guardar') {
                    self.confirm_guardar();
                } else if (funcion === 'confirm_editar') {
                    self.confirm_editar();
                }
            }).catch(function () {
                swal({
                    type: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor corrija los errores del formulario'
                });
            });
        },
        trim_fecha: function trim_fecha(fecha) {
            return fecha.substring(0, 10);
        },
        reset_form: function reset_form() {
            Vue.set(this.form, 'id_traspaso', '');
            Vue.set(this.form, 'id_cuenta_origen', '');
            Vue.set(this.form, 'id_cuenta_destino', '');
            Vue.set(this.form, 'observaciones', '');
            Vue.set(this.form, 'importe', '');
            Vue.set(this.form, 'fecha', '');
            Vue.set(this.form, 'cumplimiento', '');
            Vue.set(this.form, 'vencimiento', '');
            Vue.set(this.form, 'referencia', '');
        },
        comma_format: function comma_format(number) {
            var n = !isFinite(+number) ? 0 : +number,
                decimals = 4,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
                dec = typeof dec_point === 'undefined' ? '.' : dec_point,
                toFixedFix = function toFixedFix(n, prec) {
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                var k = Math.pow(10, prec);
                return Math.round(n * k) / k;
            },
                s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    }
});

},{}],47:[function(require,module,exports){
'use strict';

Vue.component('app-errors', {
    props: ['form'],

    template: require('./templates/errors.html')
});

},{"./templates/errors.html":51}],48:[function(require,module,exports){
'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

Vue.component('global-errors', {

  data: function data() {
    return {
      errors: []
    };
  },

  template: require('./templates/global-errors.html'),

  events: {
    displayGlobalErrors: function displayGlobalErrors(errors) {
      if ((typeof errors === 'undefined' ? 'undefined' : _typeof(errors)) === 'object') {
        this.errors = _.flatten(_.toArray(errors));
      } else {
        this.errors.push('Un error grave ocurrio. Por favor intente otra vez.');
      }
    }
  }
});

},{"./templates/global-errors.html":52}],49:[function(require,module,exports){
'use strict';

Vue.component('kardex-material-index', {
    props: ['materiales'],
    data: function data() {
        return {
            'data': {
                'items': [],
                'materiales': ''
            },
            'form': {
                'material': {
                    'id_material': '',
                    'nivel': '',
                    'descripcion': '',
                    'unidad': '',
                    'n_padre': '',
                    'd_padre': '',
                    'usuario_registro': ''
                },
                'totales': {
                    'entrada_material': '',
                    'entrada_valor': '',
                    'salida_material': '',
                    'salida_valor': '',
                    'existencia': ''
                }
            },
            valor: -1,
            'cargando': false
        };
    },
    directives: {
        select2: {

            inserted: function inserted(el) {

                $(el).select2({
                    width: '100%',
                    ajax: {
                        url: App.host + '/sistema_contable/kardex_material/getBy',
                        dataType: 'json',
                        delay: 500,
                        data: function data(params) {
                            return {
                                attribute: 'descripcion',
                                operator: 'like',
                                value: '%' + params.term + '%'
                            };
                        },

                        processResults: function processResults(data) {

                            return {

                                results: $.map(data.data.materiales, function (item) {
                                    return {
                                        text: item.descripcion,
                                        id: item.id_material
                                    };
                                })
                            };
                        },
                        error: function error(_error) {},
                        cache: true
                    },
                    escapeMarkup: function escapeMarkup(markup) {
                        return markup;
                    }, // let our custom formatter work
                    minimumInputLength: 1
                }).on('select2:select', function () {
                    $('#material_select').val($('#material_select option:selected').data().data.id);
                });
            }
        }
    },
    methods: {

        datos: function datos() {
            var self = this;
            var material = self.valor;
            var url = App.host + '/sistema_contable/kardex_material/';
            var ematerial = 0;
            var evalor = 0;
            var smaterial = 0;
            var svalor = 0;
            // Consulta de datos de kardex por material
            if (self.valor >= 0) {
                url = url + material;
                $.ajax({
                    type: 'GET',
                    url: url,
                    beforeSend: function beforeSend() {
                        self.cargando = true;
                    },
                    success: function success(response) {

                        material = response.data.material;
                        // Asignación de datos para vista de detalle
                        self.form.material.id_material = material.id_material;
                        self.form.material.nivel = material.nivel;
                        self.form.material.n_padre = self.form.material.nivel.substr(0, 4);
                        self.form.material.descripcion = material.descripcion;
                        self.form.material.unidad = material.unidad;
                        self.form.material.d_padre = response.data.padre.descripcion;
                        self.form.material.usuario_registro = material.UsuarioRegistro;

                        self.data.items = response.data.items;

                        response.data.items.forEach(function (item) {
                            if (item.transaccion.tipo_transaccion == 33) {
                                ematerial += parseFloat(item.cantidad);
                                evalor += parseFloat(item.precio_unitario);
                            }
                            if (item.transaccion.tipo_transaccion == 34) {
                                smaterial += parseFloat(item.cantidad);
                                svalor += parseFloat(item.precio_unitario);
                            }
                        });
                        // Asignacion de valores totales de Transacciones
                        self.form.totales.entrada_material = ematerial;
                        self.form.totales.entrada_valor = evalor;
                        self.form.totales.salida_material = smaterial;
                        self.form.totales.salida_valor = svalor;
                        self.form.totales.existencia = ematerial - smaterial;
                    },
                    complete: function complete() {
                        self.cargando = false;
                    }
                });
            } else {
                self.form.material.id_material = '';
                self.form.material.nivel = '';
                self.form.material.n_padre = '';
                self.form.material.descripcion = '';
                self.form.material.unidad = '';
                self.form.material.d_padre = '';
                self.form.totales.existencia = '';
                self.form.totales.entrada_material = '';
                self.form.totales.entrada_valor = '';
                self.form.totales.salida_material = '';
                self.form.totales.salida_valor = '';
                self.form.totales.existencia = '';
            }
        }
    }

});

},{}],50:[function(require,module,exports){
'use strict';

Vue.component('select2', {
    props: ['options', 'value', 'name', 'placeholder'],
    template: '<select><slot></slot></select>',
    mounted: function mounted() {
        var vm = this;
        var data = [];

        $.each(this.options, function (id, text) {
            data.push({ id: id, text: text });
        });

        function SortByName(a, b) {
            var aName = a.text.toLowerCase();
            var bName = b.text.toLowerCase();
            return aName < bName ? -1 : aName > bName ? 1 : 0;
        }

        data = data.sort(SortByName);
        $(this.$el).attr('name', this.name);
        $(this.$el).select2({
            data: data,
            width: '100%',
            allowClear: true,
            placeholder: {
                id: ''
            }
        }).val(this.value).trigger('change')
        // emit event on change.
        .on('change', function () {
            vm.$emit('input', this.value);
        });
    },
    watch: {
        value: function value(_value) {
            // update value
            $(this.$el).val(_value).trigger('change');
        },
        options: function options(_options) {
            // update options
            $(this.$el).select2({
                data: _options,
                width: '100%',
                placeholder: {
                    id: ""
                }
            });
        }
    },
    destroyed: function destroyed() {
        $(this.$el).off().select2('destroy');
    }
});

},{}],51:[function(require,module,exports){
module.exports = '<div id="form-errors" v-cloak>\n  <div class="alert alert-danger" v-if="form.errors.length">\n    <ul>\n      <li v-for="error in form.errors">{{ error }}</li>\n    </ul>\n  </div>\n</div>';
},{}],52:[function(require,module,exports){
module.exports = '<div class="alert alert-danger" v-show="errors.length">\n  <ul>\n    <li v-for="error in errors">{{ error }}</li>\n  </ul>\n</div>';
},{}]},{},[4]);

//# sourceMappingURL=app-vue.js.map
