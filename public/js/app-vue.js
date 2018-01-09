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
 * Vue.js v2.5.3
 * (c) 2014-2017 Evan You
 * Released under the MIT License.
 */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):e.Vue=t()}(this,function(){"use strict";function e(e){return void 0===e||null===e}function t(e){return void 0!==e&&null!==e}function n(e){return!0===e}function r(e){return!1===e}function i(e){return"string"==typeof e||"number"==typeof e||"boolean"==typeof e}function o(e){return null!==e&&"object"==typeof e}function a(e){return"[object Object]"===Oi.call(e)}function s(e){return"[object RegExp]"===Oi.call(e)}function c(e){var t=parseFloat(String(e));return t>=0&&Math.floor(t)===t&&isFinite(e)}function u(e){return null==e?"":"object"==typeof e?JSON.stringify(e,null,2):String(e)}function l(e){var t=parseFloat(e);return isNaN(t)?e:t}function f(e,t){for(var n=Object.create(null),r=e.split(","),i=0;i<r.length;i++)n[r[i]]=!0;return t?function(e){return n[e.toLowerCase()]}:function(e){return n[e]}}function d(e,t){if(e.length){var n=e.indexOf(t);if(n>-1)return e.splice(n,1)}}function p(e,t){return Ei.call(e,t)}function v(e){var t=Object.create(null);return function(n){return t[n]||(t[n]=e(n))}}function h(e,t){function n(n){var r=arguments.length;return r?r>1?e.apply(t,arguments):e.call(t,n):e.call(t)}return n._length=e.length,n}function m(e,t){t=t||0;for(var n=e.length-t,r=new Array(n);n--;)r[n]=e[n+t];return r}function y(e,t){for(var n in t)e[n]=t[n];return e}function g(e){for(var t={},n=0;n<e.length;n++)e[n]&&y(t,e[n]);return t}function _(e,t,n){}function b(e,t){if(e===t)return!0;var n=o(e),r=o(t);if(!n||!r)return!n&&!r&&String(e)===String(t);try{var i=Array.isArray(e),a=Array.isArray(t);if(i&&a)return e.length===t.length&&e.every(function(e,n){return b(e,t[n])});if(i||a)return!1;var s=Object.keys(e),c=Object.keys(t);return s.length===c.length&&s.every(function(n){return b(e[n],t[n])})}catch(e){return!1}}function $(e,t){for(var n=0;n<e.length;n++)if(b(e[n],t))return n;return-1}function C(e){var t=!1;return function(){t||(t=!0,e.apply(this,arguments))}}function w(e){var t=(e+"").charCodeAt(0);return 36===t||95===t}function x(e,t,n,r){Object.defineProperty(e,t,{value:n,enumerable:!!r,writable:!0,configurable:!0})}function k(e){if(!Vi.test(e)){var t=e.split(".");return function(e){for(var n=0;n<t.length;n++){if(!e)return;e=e[t[n]]}return e}}}function A(e){return"function"==typeof e&&/native code/.test(e.toString())}function O(e){co.target&&uo.push(co.target),co.target=e}function S(){co.target=uo.pop()}function T(e){return new lo(void 0,void 0,void 0,String(e))}function E(e,t){var n=e.componentOptions,r=new lo(e.tag,e.data,e.children,e.text,e.elm,e.context,n,e.asyncFactory);return r.ns=e.ns,r.isStatic=e.isStatic,r.key=e.key,r.isComment=e.isComment,r.isCloned=!0,t&&(e.children&&(r.children=j(e.children,!0)),n&&n.children&&(n.children=j(n.children,!0))),r}function j(e,t){for(var n=e.length,r=new Array(n),i=0;i<n;i++)r[i]=E(e[i],t);return r}function N(e,t,n){e.__proto__=t}function L(e,t,n){for(var r=0,i=n.length;r<i;r++){var o=n[r];x(e,o,t[o])}}function I(e,t){if(o(e)&&!(e instanceof lo)){var n;return p(e,"__ob__")&&e.__ob__ instanceof go?n=e.__ob__:yo.shouldConvert&&!ro()&&(Array.isArray(e)||a(e))&&Object.isExtensible(e)&&!e._isVue&&(n=new go(e)),t&&n&&n.vmCount++,n}}function M(e,t,n,r,i){var o=new co,a=Object.getOwnPropertyDescriptor(e,t);if(!a||!1!==a.configurable){var s=a&&a.get,c=a&&a.set,u=!i&&I(n);Object.defineProperty(e,t,{enumerable:!0,configurable:!0,get:function(){var t=s?s.call(e):n;return co.target&&(o.depend(),u&&(u.dep.depend(),Array.isArray(t)&&F(t))),t},set:function(t){var r=s?s.call(e):n;t===r||t!==t&&r!==r||(c?c.call(e,t):n=t,u=!i&&I(t),o.notify())}})}}function D(e,t,n){if(Array.isArray(e)&&c(t))return e.length=Math.max(e.length,t),e.splice(t,1,n),n;if(t in e&&!(t in Object.prototype))return e[t]=n,n;var r=e.__ob__;return e._isVue||r&&r.vmCount?n:r?(M(r.value,t,n),r.dep.notify(),n):(e[t]=n,n)}function P(e,t){if(Array.isArray(e)&&c(t))e.splice(t,1);else{var n=e.__ob__;e._isVue||n&&n.vmCount||p(e,t)&&(delete e[t],n&&n.dep.notify())}}function F(e){for(var t=void 0,n=0,r=e.length;n<r;n++)(t=e[n])&&t.__ob__&&t.__ob__.dep.depend(),Array.isArray(t)&&F(t)}function R(e,t){if(!t)return e;for(var n,r,i,o=Object.keys(t),s=0;s<o.length;s++)r=e[n=o[s]],i=t[n],p(e,n)?a(r)&&a(i)&&R(r,i):D(e,n,i);return e}function H(e,t,n){return n?function(){var r="function"==typeof t?t.call(n):t,i="function"==typeof e?e.call(n):e;return r?R(r,i):i}:t?e?function(){return R("function"==typeof t?t.call(this):t,"function"==typeof e?e.call(this):e)}:t:e}function B(e,t){return t?e?e.concat(t):Array.isArray(t)?t:[t]:e}function U(e,t,n,r){var i=Object.create(e||null);return t?y(i,t):i}function V(e,t){var n=e.props;if(n){var r,i,o={};if(Array.isArray(n))for(r=n.length;r--;)"string"==typeof(i=n[r])&&(o[Ni(i)]={type:null});else if(a(n))for(var s in n)i=n[s],o[Ni(s)]=a(i)?i:{type:i};e.props=o}}function z(e,t){var n=e.inject,r=e.inject={};if(Array.isArray(n))for(var i=0;i<n.length;i++)r[n[i]]={from:n[i]};else if(a(n))for(var o in n){var s=n[o];r[o]=a(s)?y({from:o},s):{from:s}}}function K(e){var t=e.directives;if(t)for(var n in t){var r=t[n];"function"==typeof r&&(t[n]={bind:r,update:r})}}function J(e,t,n){function r(r){var i=_o[r]||Co;c[r]=i(e[r],t[r],n,r)}"function"==typeof t&&(t=t.options),V(t,n),z(t,n),K(t);var i=t.extends;if(i&&(e=J(e,i,n)),t.mixins)for(var o=0,a=t.mixins.length;o<a;o++)e=J(e,t.mixins[o],n);var s,c={};for(s in e)r(s);for(s in t)p(e,s)||r(s);return c}function q(e,t,n,r){if("string"==typeof n){var i=e[t];if(p(i,n))return i[n];var o=Ni(n);if(p(i,o))return i[o];var a=Li(o);if(p(i,a))return i[a];var s=i[n]||i[o]||i[a];return s}}function W(e,t,n,r){var i=t[e],o=!p(n,e),a=n[e];if(Y(Boolean,i.type)&&(o&&!p(i,"default")?a=!1:Y(String,i.type)||""!==a&&a!==Mi(e)||(a=!0)),void 0===a){a=G(r,i,e);var s=yo.shouldConvert;yo.shouldConvert=!0,I(a),yo.shouldConvert=s}return a}function G(e,t,n){if(p(t,"default")){var r=t.default;return e&&e.$options.propsData&&void 0===e.$options.propsData[n]&&void 0!==e._props[n]?e._props[n]:"function"==typeof r&&"Function"!==Z(t.type)?r.call(e):r}}function Z(e){var t=e&&e.toString().match(/^\s*function (\w+)/);return t?t[1]:""}function Y(e,t){if(!Array.isArray(t))return Z(t)===Z(e);for(var n=0,r=t.length;n<r;n++)if(Z(t[n])===Z(e))return!0;return!1}function Q(e,t,n){if(t)for(var r=t;r=r.$parent;){var i=r.$options.errorCaptured;if(i)for(var o=0;o<i.length;o++)try{if(!1===i[o].call(r,e,t,n))return}catch(e){X(e,r,"errorCaptured hook")}}X(e,t,n)}function X(e,t,n){if(Bi.errorHandler)try{return Bi.errorHandler.call(null,e,t,n)}catch(e){ee(e,null,"config.errorHandler")}ee(e,t,n)}function ee(e,t,n){if(!Ki||"undefined"==typeof console)throw e;console.error(e)}function te(){xo=!1;var e=wo.slice(0);wo.length=0;for(var t=0;t<e.length;t++)e[t]()}function ne(e){return e._withTask||(e._withTask=function(){ko=!0;var t=e.apply(null,arguments);return ko=!1,t})}function re(e,t){var n;if(wo.push(function(){if(e)try{e.call(t)}catch(e){Q(e,t,"nextTick")}else n&&n(t)}),xo||(xo=!0,ko?$o():bo()),!e&&"undefined"!=typeof Promise)return new Promise(function(e){n=e})}function ie(e){function t(){var e=arguments,n=t.fns;if(!Array.isArray(n))return n.apply(null,arguments);for(var r=n.slice(),i=0;i<r.length;i++)r[i].apply(null,e)}return t.fns=e,t}function oe(t,n,r,i,o){var a,s,c,u;for(a in t)s=t[a],c=n[a],u=Eo(a),e(s)||(e(c)?(e(s.fns)&&(s=t[a]=ie(s)),r(u.name,s,u.once,u.capture,u.passive)):s!==c&&(c.fns=s,t[a]=c));for(a in n)e(t[a])&&i((u=Eo(a)).name,n[a],u.capture)}function ae(r,i,o){function a(){o.apply(this,arguments),d(s.fns,a)}r instanceof lo&&(r=r.data.hook||(r.data.hook={}));var s,c=r[i];e(c)?s=ie([a]):t(c.fns)&&n(c.merged)?(s=c).fns.push(a):s=ie([c,a]),s.merged=!0,r[i]=s}function se(n,r,i){var o=r.options.props;if(!e(o)){var a={},s=n.attrs,c=n.props;if(t(s)||t(c))for(var u in o){var l=Mi(u);ce(a,c,u,l,!0)||ce(a,s,u,l,!1)}return a}}function ce(e,n,r,i,o){if(t(n)){if(p(n,r))return e[r]=n[r],o||delete n[r],!0;if(p(n,i))return e[r]=n[i],o||delete n[i],!0}return!1}function ue(e){for(var t=0;t<e.length;t++)if(Array.isArray(e[t]))return Array.prototype.concat.apply([],e);return e}function le(e){return i(e)?[T(e)]:Array.isArray(e)?de(e):void 0}function fe(e){return t(e)&&t(e.text)&&r(e.isComment)}function de(r,o){var a,s,c,u,l=[];for(a=0;a<r.length;a++)e(s=r[a])||"boolean"==typeof s||(u=l[c=l.length-1],Array.isArray(s)?s.length>0&&(fe((s=de(s,(o||"")+"_"+a))[0])&&fe(u)&&(l[c]=T(u.text+s[0].text),s.shift()),l.push.apply(l,s)):i(s)?fe(u)?l[c]=T(u.text+s):""!==s&&l.push(T(s)):fe(s)&&fe(u)?l[c]=T(u.text+s.text):(n(r._isVList)&&t(s.tag)&&e(s.key)&&t(o)&&(s.key="__vlist"+o+"_"+a+"__"),l.push(s)));return l}function pe(e,t){return(e.__esModule||oo&&"Module"===e[Symbol.toStringTag])&&(e=e.default),o(e)?t.extend(e):e}function ve(e,t,n,r,i){var o=po();return o.asyncFactory=e,o.asyncMeta={data:t,context:n,children:r,tag:i},o}function he(r,i,a){if(n(r.error)&&t(r.errorComp))return r.errorComp;if(t(r.resolved))return r.resolved;if(n(r.loading)&&t(r.loadingComp))return r.loadingComp;if(!t(r.contexts)){var s=r.contexts=[a],c=!0,u=function(){for(var e=0,t=s.length;e<t;e++)s[e].$forceUpdate()},l=C(function(e){r.resolved=pe(e,i),c||u()}),f=C(function(e){t(r.errorComp)&&(r.error=!0,u())}),d=r(l,f);return o(d)&&("function"==typeof d.then?e(r.resolved)&&d.then(l,f):t(d.component)&&"function"==typeof d.component.then&&(d.component.then(l,f),t(d.error)&&(r.errorComp=pe(d.error,i)),t(d.loading)&&(r.loadingComp=pe(d.loading,i),0===d.delay?r.loading=!0:setTimeout(function(){e(r.resolved)&&e(r.error)&&(r.loading=!0,u())},d.delay||200)),t(d.timeout)&&setTimeout(function(){e(r.resolved)&&f(null)},d.timeout))),c=!1,r.loading?r.loadingComp:r.resolved}r.contexts.push(a)}function me(e){return e.isComment&&e.asyncFactory}function ye(e){if(Array.isArray(e))for(var n=0;n<e.length;n++){var r=e[n];if(t(r)&&(t(r.componentOptions)||me(r)))return r}}function ge(e){e._events=Object.create(null),e._hasHookEvent=!1;var t=e.$options._parentListeners;t&&$e(e,t)}function _e(e,t,n){n?To.$once(e,t):To.$on(e,t)}function be(e,t){To.$off(e,t)}function $e(e,t,n){To=e,oe(t,n||{},_e,be,e),To=void 0}function Ce(e,t){var n={};if(!e)return n;for(var r=0,i=e.length;r<i;r++){var o=e[r],a=o.data;if(a&&a.attrs&&a.attrs.slot&&delete a.attrs.slot,o.context!==t&&o.functionalContext!==t||!a||null==a.slot)(n.default||(n.default=[])).push(o);else{var s=o.data.slot,c=n[s]||(n[s]=[]);"template"===o.tag?c.push.apply(c,o.children):c.push(o)}}for(var u in n)n[u].every(we)&&delete n[u];return n}function we(e){return e.isComment||" "===e.text}function xe(e,t){t=t||{};for(var n=0;n<e.length;n++)Array.isArray(e[n])?xe(e[n],t):t[e[n].key]=e[n].fn;return t}function ke(e){var t=e.$options,n=t.parent;if(n&&!t.abstract){for(;n.$options.abstract&&n.$parent;)n=n.$parent;n.$children.push(e)}e.$parent=n,e.$root=n?n.$root:e,e.$children=[],e.$refs={},e._watcher=null,e._inactive=null,e._directInactive=!1,e._isMounted=!1,e._isDestroyed=!1,e._isBeingDestroyed=!1}function Ae(e,t,n){e.$el=t,e.$options.render||(e.$options.render=po),je(e,"beforeMount");var r;return r=function(){e._update(e._render(),n)},e._watcher=new Ro(e,r,_),n=!1,null==e.$vnode&&(e._isMounted=!0,je(e,"mounted")),e}function Oe(e,t,n,r,i){var o=!!(i||e.$options._renderChildren||r.data.scopedSlots||e.$scopedSlots!==Ui);if(e.$options._parentVnode=r,e.$vnode=r,e._vnode&&(e._vnode.parent=r),e.$options._renderChildren=i,e.$attrs=r.data&&r.data.attrs||Ui,e.$listeners=n||Ui,t&&e.$options.props){yo.shouldConvert=!1;for(var a=e._props,s=e.$options._propKeys||[],c=0;c<s.length;c++){var u=s[c];a[u]=W(u,e.$options.props,t,e)}yo.shouldConvert=!0,e.$options.propsData=t}if(n){var l=e.$options._parentListeners;e.$options._parentListeners=n,$e(e,n,l)}o&&(e.$slots=Ce(i,r.context),e.$forceUpdate())}function Se(e){for(;e&&(e=e.$parent);)if(e._inactive)return!0;return!1}function Te(e,t){if(t){if(e._directInactive=!1,Se(e))return}else if(e._directInactive)return;if(e._inactive||null===e._inactive){e._inactive=!1;for(var n=0;n<e.$children.length;n++)Te(e.$children[n]);je(e,"activated")}}function Ee(e,t){if(!(t&&(e._directInactive=!0,Se(e))||e._inactive)){e._inactive=!0;for(var n=0;n<e.$children.length;n++)Ee(e.$children[n]);je(e,"deactivated")}}function je(e,t){var n=e.$options[t];if(n)for(var r=0,i=n.length;r<i;r++)try{n[r].call(e)}catch(n){Q(n,e,t+" hook")}e._hasHookEvent&&e.$emit("hook:"+t)}function Ne(){Po=No.length=Lo.length=0,Io={},Mo=Do=!1}function Le(){Do=!0;var e,t;for(No.sort(function(e,t){return e.id-t.id}),Po=0;Po<No.length;Po++)t=(e=No[Po]).id,Io[t]=null,e.run();var n=Lo.slice(),r=No.slice();Ne(),De(n),Ie(r),io&&Bi.devtools&&io.emit("flush")}function Ie(e){for(var t=e.length;t--;){var n=e[t],r=n.vm;r._watcher===n&&r._isMounted&&je(r,"updated")}}function Me(e){e._inactive=!1,Lo.push(e)}function De(e){for(var t=0;t<e.length;t++)e[t]._inactive=!0,Te(e[t],!0)}function Pe(e){var t=e.id;if(null==Io[t]){if(Io[t]=!0,Do){for(var n=No.length-1;n>Po&&No[n].id>e.id;)n--;No.splice(n+1,0,e)}else No.push(e);Mo||(Mo=!0,re(Le))}}function Fe(e){Ho.clear(),Re(e,Ho)}function Re(e,t){var n,r,i=Array.isArray(e);if((i||o(e))&&Object.isExtensible(e)){if(e.__ob__){var a=e.__ob__.dep.id;if(t.has(a))return;t.add(a)}if(i)for(n=e.length;n--;)Re(e[n],t);else for(n=(r=Object.keys(e)).length;n--;)Re(e[r[n]],t)}}function He(e,t,n){Bo.get=function(){return this[t][n]},Bo.set=function(e){this[t][n]=e},Object.defineProperty(e,n,Bo)}function Be(e){e._watchers=[];var t=e.$options;t.props&&Ue(e,t.props),t.methods&&We(e,t.methods),t.data?Ve(e):I(e._data={},!0),t.computed&&Ke(e,t.computed),t.watch&&t.watch!==Qi&&Ge(e,t.watch)}function Ue(e,t){var n=e.$options.propsData||{},r=e._props={},i=e.$options._propKeys=[],o=!e.$parent;yo.shouldConvert=o;for(var a in t)!function(o){i.push(o);var a=W(o,t,n,e);M(r,o,a),o in e||He(e,"_props",o)}(a);yo.shouldConvert=!0}function Ve(e){var t=e.$options.data;a(t=e._data="function"==typeof t?ze(t,e):t||{})||(t={});for(var n=Object.keys(t),r=e.$options.props,i=n.length;i--;){var o=n[i];r&&p(r,o)||w(o)||He(e,"_data",o)}I(t,!0)}function ze(e,t){try{return e.call(t,t)}catch(e){return Q(e,t,"data()"),{}}}function Ke(e,t){var n=e._computedWatchers=Object.create(null),r=ro();for(var i in t){var o=t[i],a="function"==typeof o?o:o.get;r||(n[i]=new Ro(e,a||_,_,Uo)),i in e||Je(e,i,o)}}function Je(e,t,n){var r=!ro();"function"==typeof n?(Bo.get=r?qe(t):n,Bo.set=_):(Bo.get=n.get?r&&!1!==n.cache?qe(t):n.get:_,Bo.set=n.set?n.set:_),Object.defineProperty(e,t,Bo)}function qe(e){return function(){var t=this._computedWatchers&&this._computedWatchers[e];if(t)return t.dirty&&t.evaluate(),co.target&&t.depend(),t.value}}function We(e,t){for(var n in t)e[n]=null==t[n]?_:h(t[n],e)}function Ge(e,t){for(var n in t){var r=t[n];if(Array.isArray(r))for(var i=0;i<r.length;i++)Ze(e,n,r[i]);else Ze(e,n,r)}}function Ze(e,t,n,r){return a(n)&&(r=n,n=n.handler),"string"==typeof n&&(n=e[n]),e.$watch(t,n,r)}function Ye(e){var t=e.$options.provide;t&&(e._provided="function"==typeof t?t.call(e):t)}function Qe(e){var t=Xe(e.$options.inject,e);t&&(yo.shouldConvert=!1,Object.keys(t).forEach(function(n){M(e,n,t[n])}),yo.shouldConvert=!0)}function Xe(e,t){if(e){for(var n=Object.create(null),r=oo?Reflect.ownKeys(e).filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}):Object.keys(e),i=0;i<r.length;i++){for(var o=r[i],a=e[o].from,s=t;s;){if(s._provided&&a in s._provided){n[o]=s._provided[a];break}s=s.$parent}if(!s&&"default"in e[o]){var c=e[o].default;n[o]="function"==typeof c?c.call(t):c}}return n}}function et(e,n){var r,i,a,s,c;if(Array.isArray(e)||"string"==typeof e)for(r=new Array(e.length),i=0,a=e.length;i<a;i++)r[i]=n(e[i],i);else if("number"==typeof e)for(r=new Array(e),i=0;i<e;i++)r[i]=n(i+1,i);else if(o(e))for(s=Object.keys(e),r=new Array(s.length),i=0,a=s.length;i<a;i++)c=s[i],r[i]=n(e[c],c,i);return t(r)&&(r._isVList=!0),r}function tt(e,t,n,r){var i,o=this.$scopedSlots[e];if(o)n=n||{},r&&(n=y(y({},r),n)),i=o(n)||t;else{var a=this.$slots[e];a&&(a._rendered=!0),i=a||t}var s=n&&n.slot;return s?this.$createElement("template",{slot:s},i):i}function nt(e){return q(this.$options,"filters",e,!0)||Pi}function rt(e,t,n,r){var i=Bi.keyCodes[t]||n;return i?Array.isArray(i)?-1===i.indexOf(e):i!==e:r?Mi(r)!==t:void 0}function it(e,t,n,r,i){if(n)if(o(n)){Array.isArray(n)&&(n=g(n));var a;for(var s in n)!function(o){if("class"===o||"style"===o||Ti(o))a=e;else{var s=e.attrs&&e.attrs.type;a=r||Bi.mustUseProp(t,s,o)?e.domProps||(e.domProps={}):e.attrs||(e.attrs={})}o in a||(a[o]=n[o],i&&((e.on||(e.on={}))["update:"+o]=function(e){n[o]=e}))}(s)}else;return e}function ot(e,t){var n=this.$options,r=n.cached||(n.cached=[]),i=r[e];return i&&!t?Array.isArray(i)?j(i):E(i):(i=r[e]=n.staticRenderFns[e].call(this._renderProxy,null,this),st(i,"__static__"+e,!1),i)}function at(e,t,n){return st(e,"__once__"+t+(n?"_"+n:""),!0),e}function st(e,t,n){if(Array.isArray(e))for(var r=0;r<e.length;r++)e[r]&&"string"!=typeof e[r]&&ct(e[r],t+"_"+r,n);else ct(e,t,n)}function ct(e,t,n){e.isStatic=!0,e.key=t,e.isOnce=n}function ut(e,t){if(t)if(a(t)){var n=e.on=e.on?y({},e.on):{};for(var r in t){var i=n[r],o=t[r];n[r]=i?[].concat(i,o):o}}else;return e}function lt(e){e._o=at,e._n=l,e._s=u,e._l=et,e._t=tt,e._q=b,e._i=$,e._m=ot,e._f=nt,e._k=rt,e._b=it,e._v=T,e._e=po,e._u=xe,e._g=ut}function ft(e,t,r,i,o){var a=o.options;this.data=e,this.props=t,this.children=r,this.parent=i,this.listeners=e.on||Ui,this.injections=Xe(a.inject,i),this.slots=function(){return Ce(r,i)};var s=Object.create(i),c=n(a._compiled),u=!c;c&&(this.$options=a,this.$slots=this.slots(),this.$scopedSlots=e.scopedSlots||Ui),a._scopeId?this._c=function(e,t,n,r){var o=_t(s,e,t,n,r,u);return o&&(o.functionalScopeId=a._scopeId,o.functionalContext=i),o}:this._c=function(e,t,n,r){return _t(s,e,t,n,r,u)}}function dt(e,n,r,i,o){var a=e.options,s={},c=a.props;if(t(c))for(var u in c)s[u]=W(u,c,n||Ui);else t(r.attrs)&&pt(s,r.attrs),t(r.props)&&pt(s,r.props);var l=new ft(r,s,o,i,e),f=a.render.call(null,l._c,l);return f instanceof lo&&(f.functionalContext=i,f.functionalOptions=a,r.slot&&((f.data||(f.data={})).slot=r.slot)),f}function pt(e,t){for(var n in t)e[Ni(n)]=t[n]}function vt(r,i,a,s,c){if(!e(r)){var u=a.$options._base;if(o(r)&&(r=u.extend(r)),"function"==typeof r){var l;if(e(r.cid)&&(l=r,void 0===(r=he(l,u,a))))return ve(l,i,a,s,c);i=i||{},xt(r),t(i.model)&&gt(r.options,i);var f=se(i,r,c);if(n(r.options.functional))return dt(r,f,i,a,s);var d=i.on;if(i.on=i.nativeOn,n(r.options.abstract)){var p=i.slot;i={},p&&(i.slot=p)}mt(i);var v=r.options.name||c;return new lo("vue-component-"+r.cid+(v?"-"+v:""),i,void 0,void 0,void 0,a,{Ctor:r,propsData:f,listeners:d,tag:c,children:s},l)}}}function ht(e,n,r,i){var o=e.componentOptions,a={_isComponent:!0,parent:n,propsData:o.propsData,_componentTag:o.tag,_parentVnode:e,_parentListeners:o.listeners,_renderChildren:o.children,_parentElm:r||null,_refElm:i||null},s=e.data.inlineTemplate;return t(s)&&(a.render=s.render,a.staticRenderFns=s.staticRenderFns),new o.Ctor(a)}function mt(e){e.hook||(e.hook={});for(var t=0;t<zo.length;t++){var n=zo[t],r=e.hook[n],i=Vo[n];e.hook[n]=r?yt(i,r):i}}function yt(e,t){return function(n,r,i,o){e(n,r,i,o),t(n,r,i,o)}}function gt(e,n){var r=e.model&&e.model.prop||"value",i=e.model&&e.model.event||"input";(n.props||(n.props={}))[r]=n.model.value;var o=n.on||(n.on={});t(o[i])?o[i]=[n.model.callback].concat(o[i]):o[i]=n.model.callback}function _t(e,t,r,o,a,s){return(Array.isArray(r)||i(r))&&(a=o,o=r,r=void 0),n(s)&&(a=Jo),bt(e,t,r,o,a)}function bt(e,n,r,i,o){if(t(r)&&t(r.__ob__))return po();if(t(r)&&t(r.is)&&(n=r.is),!n)return po();Array.isArray(i)&&"function"==typeof i[0]&&((r=r||{}).scopedSlots={default:i[0]},i.length=0),o===Jo?i=le(i):o===Ko&&(i=ue(i));var a,s;if("string"==typeof n){var c;s=e.$vnode&&e.$vnode.ns||Bi.getTagNamespace(n),a=Bi.isReservedTag(n)?new lo(Bi.parsePlatformTagName(n),r,i,void 0,void 0,e):t(c=q(e.$options,"components",n))?vt(c,r,e,i,n):new lo(n,r,i,void 0,void 0,e)}else a=vt(n,r,e,i);return t(a)?(s&&$t(a,s),a):po()}function $t(r,i,o){if(r.ns=i,"foreignObject"===r.tag&&(i=void 0,o=!0),t(r.children))for(var a=0,s=r.children.length;a<s;a++){var c=r.children[a];t(c.tag)&&(e(c.ns)||n(o))&&$t(c,i,o)}}function Ct(e){e._vnode=null;var t=e.$options,n=e.$vnode=t._parentVnode,r=n&&n.context;e.$slots=Ce(t._renderChildren,r),e.$scopedSlots=Ui,e._c=function(t,n,r,i){return _t(e,t,n,r,i,!1)},e.$createElement=function(t,n,r,i){return _t(e,t,n,r,i,!0)};var i=n&&n.data;M(e,"$attrs",i&&i.attrs||Ui,null,!0),M(e,"$listeners",t._parentListeners||Ui,null,!0)}function wt(e,t){var n=e.$options=Object.create(e.constructor.options);n.parent=t.parent,n.propsData=t.propsData,n._parentVnode=t._parentVnode,n._parentListeners=t._parentListeners,n._renderChildren=t._renderChildren,n._componentTag=t._componentTag,n._parentElm=t._parentElm,n._refElm=t._refElm,t.render&&(n.render=t.render,n.staticRenderFns=t.staticRenderFns)}function xt(e){var t=e.options;if(e.super){var n=xt(e.super);if(n!==e.superOptions){e.superOptions=n;var r=kt(e);r&&y(e.extendOptions,r),(t=e.options=J(n,e.extendOptions)).name&&(t.components[t.name]=e)}}return t}function kt(e){var t,n=e.options,r=e.extendOptions,i=e.sealedOptions;for(var o in n)n[o]!==i[o]&&(t||(t={}),t[o]=At(n[o],r[o],i[o]));return t}function At(e,t,n){if(Array.isArray(e)){var r=[];n=Array.isArray(n)?n:[n],t=Array.isArray(t)?t:[t];for(var i=0;i<e.length;i++)(t.indexOf(e[i])>=0||n.indexOf(e[i])<0)&&r.push(e[i]);return r}return e}function Ot(e){this._init(e)}function St(e){e.use=function(e){var t=this._installedPlugins||(this._installedPlugins=[]);if(t.indexOf(e)>-1)return this;var n=m(arguments,1);return n.unshift(this),"function"==typeof e.install?e.install.apply(e,n):"function"==typeof e&&e.apply(null,n),t.push(e),this}}function Tt(e){e.mixin=function(e){return this.options=J(this.options,e),this}}function Et(e){e.cid=0;var t=1;e.extend=function(e){e=e||{};var n=this,r=n.cid,i=e._Ctor||(e._Ctor={});if(i[r])return i[r];var o=e.name||n.options.name,a=function(e){this._init(e)};return a.prototype=Object.create(n.prototype),a.prototype.constructor=a,a.cid=t++,a.options=J(n.options,e),a.super=n,a.options.props&&jt(a),a.options.computed&&Nt(a),a.extend=n.extend,a.mixin=n.mixin,a.use=n.use,Ri.forEach(function(e){a[e]=n[e]}),o&&(a.options.components[o]=a),a.superOptions=n.options,a.extendOptions=e,a.sealedOptions=y({},a.options),i[r]=a,a}}function jt(e){var t=e.options.props;for(var n in t)He(e.prototype,"_props",n)}function Nt(e){var t=e.options.computed;for(var n in t)Je(e.prototype,n,t[n])}function Lt(e){Ri.forEach(function(t){e[t]=function(e,n){return n?("component"===t&&a(n)&&(n.name=n.name||e,n=this.options._base.extend(n)),"directive"===t&&"function"==typeof n&&(n={bind:n,update:n}),this.options[t+"s"][e]=n,n):this.options[t+"s"][e]}})}function It(e){return e&&(e.Ctor.options.name||e.tag)}function Mt(e,t){return Array.isArray(e)?e.indexOf(t)>-1:"string"==typeof e?e.split(",").indexOf(t)>-1:!!s(e)&&e.test(t)}function Dt(e,t){var n=e.cache,r=e.keys,i=e._vnode;for(var o in n){var a=n[o];if(a){var s=It(a.componentOptions);s&&!t(s)&&Pt(n,o,r,i)}}}function Pt(e,t,n,r){var i=e[t];i&&i!==r&&i.componentInstance.$destroy(),e[t]=null,d(n,t)}function Ft(e){for(var n=e.data,r=e,i=e;t(i.componentInstance);)(i=i.componentInstance._vnode).data&&(n=Rt(i.data,n));for(;t(r=r.parent);)r.data&&(n=Rt(n,r.data));return Ht(n.staticClass,n.class)}function Rt(e,n){return{staticClass:Bt(e.staticClass,n.staticClass),class:t(e.class)?[e.class,n.class]:n.class}}function Ht(e,n){return t(e)||t(n)?Bt(e,Ut(n)):""}function Bt(e,t){return e?t?e+" "+t:e:t||""}function Ut(e){return Array.isArray(e)?Vt(e):o(e)?zt(e):"string"==typeof e?e:""}function Vt(e){for(var n,r="",i=0,o=e.length;i<o;i++)t(n=Ut(e[i]))&&""!==n&&(r&&(r+=" "),r+=n);return r}function zt(e){var t="";for(var n in e)e[n]&&(t&&(t+=" "),t+=n);return t}function Kt(e){return ha(e)?"svg":"math"===e?"math":void 0}function Jt(e){if("string"==typeof e){var t=document.querySelector(e);return t||document.createElement("div")}return e}function qt(e,t){var n=e.data.ref;if(n){var r=e.context,i=e.componentInstance||e.elm,o=r.$refs;t?Array.isArray(o[n])?d(o[n],i):o[n]===i&&(o[n]=void 0):e.data.refInFor?Array.isArray(o[n])?o[n].indexOf(i)<0&&o[n].push(i):o[n]=[i]:o[n]=i}}function Wt(r,i){return r.key===i.key&&(r.tag===i.tag&&r.isComment===i.isComment&&t(r.data)===t(i.data)&&Gt(r,i)||n(r.isAsyncPlaceholder)&&r.asyncFactory===i.asyncFactory&&e(i.asyncFactory.error))}function Gt(e,n){if("input"!==e.tag)return!0;var r,i=t(r=e.data)&&t(r=r.attrs)&&r.type,o=t(r=n.data)&&t(r=r.attrs)&&r.type;return i===o||ga(i)&&ga(o)}function Zt(e,n,r){var i,o,a={};for(i=n;i<=r;++i)t(o=e[i].key)&&(a[o]=i);return a}function Yt(e,t){(e.data.directives||t.data.directives)&&Qt(e,t)}function Qt(e,t){var n,r,i,o=e===$a,a=t===$a,s=Xt(e.data.directives,e.context),c=Xt(t.data.directives,t.context),u=[],l=[];for(n in c)r=s[n],i=c[n],r?(i.oldValue=r.value,tn(i,"update",t,e),i.def&&i.def.componentUpdated&&l.push(i)):(tn(i,"bind",t,e),i.def&&i.def.inserted&&u.push(i));if(u.length){var f=function(){for(var n=0;n<u.length;n++)tn(u[n],"inserted",t,e)};o?ae(t,"insert",f):f()}if(l.length&&ae(t,"postpatch",function(){for(var n=0;n<l.length;n++)tn(l[n],"componentUpdated",t,e)}),!o)for(n in s)c[n]||tn(s[n],"unbind",e,e,a)}function Xt(e,t){var n=Object.create(null);if(!e)return n;var r,i;for(r=0;r<e.length;r++)(i=e[r]).modifiers||(i.modifiers=xa),n[en(i)]=i,i.def=q(t.$options,"directives",i.name,!0);return n}function en(e){return e.rawName||e.name+"."+Object.keys(e.modifiers||{}).join(".")}function tn(e,t,n,r,i){var o=e.def&&e.def[t];if(o)try{o(n.elm,e,n,r,i)}catch(r){Q(r,n.context,"directive "+e.name+" "+t+" hook")}}function nn(n,r){var i=r.componentOptions;if(!(t(i)&&!1===i.Ctor.options.inheritAttrs||e(n.data.attrs)&&e(r.data.attrs))){var o,a,s=r.elm,c=n.data.attrs||{},u=r.data.attrs||{};t(u.__ob__)&&(u=r.data.attrs=y({},u));for(o in u)a=u[o],c[o]!==a&&rn(s,o,a);(Wi||Gi)&&u.value!==c.value&&rn(s,"value",u.value);for(o in c)e(u[o])&&(la(o)?s.removeAttributeNS(ua,fa(o)):sa(o)||s.removeAttribute(o))}}function rn(e,t,n){ca(t)?da(n)?e.removeAttribute(t):(n="allowfullscreen"===t&&"EMBED"===e.tagName?"true":t,e.setAttribute(t,n)):sa(t)?e.setAttribute(t,da(n)||"false"===n?"false":"true"):la(t)?da(n)?e.removeAttributeNS(ua,fa(t)):e.setAttributeNS(ua,t,n):da(n)?e.removeAttribute(t):e.setAttribute(t,n)}function on(n,r){var i=r.elm,o=r.data,a=n.data;if(!(e(o.staticClass)&&e(o.class)&&(e(a)||e(a.staticClass)&&e(a.class)))){var s=Ft(r),c=i._transitionClasses;t(c)&&(s=Bt(s,Ut(c))),s!==i._prevClass&&(i.setAttribute("class",s),i._prevClass=s)}}function an(e){function t(){(a||(a=[])).push(e.slice(v,i).trim()),v=i+1}var n,r,i,o,a,s=!1,c=!1,u=!1,l=!1,f=0,d=0,p=0,v=0;for(i=0;i<e.length;i++)if(r=n,n=e.charCodeAt(i),s)39===n&&92!==r&&(s=!1);else if(c)34===n&&92!==r&&(c=!1);else if(u)96===n&&92!==r&&(u=!1);else if(l)47===n&&92!==r&&(l=!1);else if(124!==n||124===e.charCodeAt(i+1)||124===e.charCodeAt(i-1)||f||d||p){switch(n){case 34:c=!0;break;case 39:s=!0;break;case 96:u=!0;break;case 40:p++;break;case 41:p--;break;case 91:d++;break;case 93:d--;break;case 123:f++;break;case 125:f--}if(47===n){for(var h=i-1,m=void 0;h>=0&&" "===(m=e.charAt(h));h--);m&&Sa.test(m)||(l=!0)}}else void 0===o?(v=i+1,o=e.slice(0,i).trim()):t();if(void 0===o?o=e.slice(0,i).trim():0!==v&&t(),a)for(i=0;i<a.length;i++)o=sn(o,a[i]);return o}function sn(e,t){var n=t.indexOf("(");return n<0?'_f("'+t+'")('+e+")":'_f("'+t.slice(0,n)+'")('+e+","+t.slice(n+1)}function cn(e){console.error("[Vue compiler]: "+e)}function un(e,t){return e?e.map(function(e){return e[t]}).filter(function(e){return e}):[]}function ln(e,t,n){(e.props||(e.props=[])).push({name:t,value:n})}function fn(e,t,n){(e.attrs||(e.attrs=[])).push({name:t,value:n})}function dn(e,t,n,r,i,o){(e.directives||(e.directives=[])).push({name:t,rawName:n,value:r,arg:i,modifiers:o})}function pn(e,t,n,r,i,o){r&&r.capture&&(delete r.capture,t="!"+t),r&&r.once&&(delete r.once,t="~"+t),r&&r.passive&&(delete r.passive,t="&"+t);var a;r&&r.native?(delete r.native,a=e.nativeEvents||(e.nativeEvents={})):a=e.events||(e.events={});var s={value:n,modifiers:r},c=a[t];Array.isArray(c)?i?c.unshift(s):c.push(s):a[t]=c?i?[s,c]:[c,s]:s}function vn(e,t,n){var r=hn(e,":"+t)||hn(e,"v-bind:"+t);if(null!=r)return an(r);if(!1!==n){var i=hn(e,t);if(null!=i)return JSON.stringify(i)}}function hn(e,t,n){var r;if(null!=(r=e.attrsMap[t]))for(var i=e.attrsList,o=0,a=i.length;o<a;o++)if(i[o].name===t){i.splice(o,1);break}return n&&delete e.attrsMap[t],r}function mn(e,t,n){var r=n||{},i=r.number,o="$$v";r.trim&&(o="(typeof $$v === 'string'? $$v.trim(): $$v)"),i&&(o="_n("+o+")");var a=yn(t,o);e.model={value:"("+t+")",expression:'"'+t+'"',callback:"function ($$v) {"+a+"}"}}function yn(e,t){var n=gn(e);return null===n.key?e+"="+t:"$set("+n.exp+", "+n.key+", "+t+")"}function gn(e){if(Zo=e.length,e.indexOf("[")<0||e.lastIndexOf("]")<Zo-1)return(Xo=e.lastIndexOf("."))>-1?{exp:e.slice(0,Xo),key:'"'+e.slice(Xo+1)+'"'}:{exp:e,key:null};for(Yo=e,Xo=ea=ta=0;!bn();)$n(Qo=_n())?wn(Qo):91===Qo&&Cn(Qo);return{exp:e.slice(0,ea),key:e.slice(ea+1,ta)}}function _n(){return Yo.charCodeAt(++Xo)}function bn(){return Xo>=Zo}function $n(e){return 34===e||39===e}function Cn(e){var t=1;for(ea=Xo;!bn();)if(e=_n(),$n(e))wn(e);else if(91===e&&t++,93===e&&t--,0===t){ta=Xo;break}}function wn(e){for(var t=e;!bn()&&(e=_n())!==t;);}function xn(e,t,n){var r=n&&n.number,i=vn(e,"value")||"null",o=vn(e,"true-value")||"true",a=vn(e,"false-value")||"false";ln(e,"checked","Array.isArray("+t+")?_i("+t+","+i+")>-1"+("true"===o?":("+t+")":":_q("+t+","+o+")")),pn(e,"change","var $$a="+t+",$$el=$event.target,$$c=$$el.checked?("+o+"):("+a+");if(Array.isArray($$a)){var $$v="+(r?"_n("+i+")":i)+",$$i=_i($$a,$$v);if($$el.checked){$$i<0&&("+t+"=$$a.concat([$$v]))}else{$$i>-1&&("+t+"=$$a.slice(0,$$i).concat($$a.slice($$i+1)))}}else{"+yn(t,"$$c")+"}",null,!0)}function kn(e,t,n){var r=n&&n.number,i=vn(e,"value")||"null";ln(e,"checked","_q("+t+","+(i=r?"_n("+i+")":i)+")"),pn(e,"change",yn(t,i),null,!0)}function An(e,t,n){var r="var $$selectedVal = "+('Array.prototype.filter.call($event.target.options,function(o){return o.selected}).map(function(o){var val = "_value" in o ? o._value : o.value;return '+(n&&n.number?"_n(val)":"val")+"})")+";";pn(e,"change",r=r+" "+yn(t,"$event.target.multiple ? $$selectedVal : $$selectedVal[0]"),null,!0)}function On(e,t,n){var r=e.attrsMap.type,i=n||{},o=i.lazy,a=i.number,s=i.trim,c=!o&&"range"!==r,u=o?"change":"range"===r?Ta:"input",l="$event.target.value";s&&(l="$event.target.value.trim()"),a&&(l="_n("+l+")");var f=yn(t,l);c&&(f="if($event.target.composing)return;"+f),ln(e,"value","("+t+")"),pn(e,u,f,null,!0),(s||a)&&pn(e,"blur","$forceUpdate()")}function Sn(e){if(t(e[Ta])){var n=qi?"change":"input";e[n]=[].concat(e[Ta],e[n]||[]),delete e[Ta]}t(e[Ea])&&(e.change=[].concat(e[Ea],e.change||[]),delete e[Ea])}function Tn(e,t,n){var r=na;return function i(){null!==e.apply(null,arguments)&&jn(t,i,n,r)}}function En(e,t,n,r,i){t=ne(t),n&&(t=Tn(t,e,r)),na.addEventListener(e,t,Xi?{capture:r,passive:i}:r)}function jn(e,t,n,r){(r||na).removeEventListener(e,t._withTask||t,n)}function Nn(t,n){if(!e(t.data.on)||!e(n.data.on)){var r=n.data.on||{},i=t.data.on||{};na=n.elm,Sn(r),oe(r,i,En,jn,n.context),na=void 0}}function Ln(n,r){if(!e(n.data.domProps)||!e(r.data.domProps)){var i,o,a=r.elm,s=n.data.domProps||{},c=r.data.domProps||{};t(c.__ob__)&&(c=r.data.domProps=y({},c));for(i in s)e(c[i])&&(a[i]="");for(i in c){if(o=c[i],"textContent"===i||"innerHTML"===i){if(r.children&&(r.children.length=0),o===s[i])continue;1===a.childNodes.length&&a.removeChild(a.childNodes[0])}if("value"===i){a._value=o;var u=e(o)?"":String(o);In(a,u)&&(a.value=u)}else a[i]=o}}}function In(e,t){return!e.composing&&("OPTION"===e.tagName||Mn(e,t)||Dn(e,t))}function Mn(e,t){var n=!0;try{n=document.activeElement!==e}catch(e){}return n&&e.value!==t}function Dn(e,n){var r=e.value,i=e._vModifiers;return t(i)&&i.number?l(r)!==l(n):t(i)&&i.trim?r.trim()!==n.trim():r!==n}function Pn(e){var t=Fn(e.style);return e.staticStyle?y(e.staticStyle,t):t}function Fn(e){return Array.isArray(e)?g(e):"string"==typeof e?La(e):e}function Rn(e,t){var n,r={};if(t)for(var i=e;i.componentInstance;)(i=i.componentInstance._vnode).data&&(n=Pn(i.data))&&y(r,n);(n=Pn(e.data))&&y(r,n);for(var o=e;o=o.parent;)o.data&&(n=Pn(o.data))&&y(r,n);return r}function Hn(n,r){var i=r.data,o=n.data;if(!(e(i.staticStyle)&&e(i.style)&&e(o.staticStyle)&&e(o.style))){var a,s,c=r.elm,u=o.staticStyle,l=o.normalizedStyle||o.style||{},f=u||l,d=Fn(r.data.style)||{};r.data.normalizedStyle=t(d.__ob__)?y({},d):d;var p=Rn(r,!0);for(s in f)e(p[s])&&Da(c,s,"");for(s in p)(a=p[s])!==f[s]&&Da(c,s,null==a?"":a)}}function Bn(e,t){if(t&&(t=t.trim()))if(e.classList)t.indexOf(" ")>-1?t.split(/\s+/).forEach(function(t){return e.classList.add(t)}):e.classList.add(t);else{var n=" "+(e.getAttribute("class")||"")+" ";n.indexOf(" "+t+" ")<0&&e.setAttribute("class",(n+t).trim())}}function Un(e,t){if(t&&(t=t.trim()))if(e.classList)t.indexOf(" ")>-1?t.split(/\s+/).forEach(function(t){return e.classList.remove(t)}):e.classList.remove(t),e.classList.length||e.removeAttribute("class");else{for(var n=" "+(e.getAttribute("class")||"")+" ",r=" "+t+" ";n.indexOf(r)>=0;)n=n.replace(r," ");(n=n.trim())?e.setAttribute("class",n):e.removeAttribute("class")}}function Vn(e){if(e){if("object"==typeof e){var t={};return!1!==e.css&&y(t,Ha(e.name||"v")),y(t,e),t}return"string"==typeof e?Ha(e):void 0}}function zn(e){Wa(function(){Wa(e)})}function Kn(e,t){var n=e._transitionClasses||(e._transitionClasses=[]);n.indexOf(t)<0&&(n.push(t),Bn(e,t))}function Jn(e,t){e._transitionClasses&&d(e._transitionClasses,t),Un(e,t)}function qn(e,t,n){var r=Wn(e,t),i=r.type,o=r.timeout,a=r.propCount;if(!i)return n();var s=i===Ua?Ka:qa,c=0,u=function(){e.removeEventListener(s,l),n()},l=function(t){t.target===e&&++c>=a&&u()};setTimeout(function(){c<a&&u()},o+1),e.addEventListener(s,l)}function Wn(e,t){var n,r=window.getComputedStyle(e),i=r[za+"Delay"].split(", "),o=r[za+"Duration"].split(", "),a=Gn(i,o),s=r[Ja+"Delay"].split(", "),c=r[Ja+"Duration"].split(", "),u=Gn(s,c),l=0,f=0;return t===Ua?a>0&&(n=Ua,l=a,f=o.length):t===Va?u>0&&(n=Va,l=u,f=c.length):f=(n=(l=Math.max(a,u))>0?a>u?Ua:Va:null)?n===Ua?o.length:c.length:0,{type:n,timeout:l,propCount:f,hasTransform:n===Ua&&Ga.test(r[za+"Property"])}}function Gn(e,t){for(;e.length<t.length;)e=e.concat(e);return Math.max.apply(null,t.map(function(t,n){return Zn(t)+Zn(e[n])}))}function Zn(e){return 1e3*Number(e.slice(0,-1))}function Yn(n,r){var i=n.elm;t(i._leaveCb)&&(i._leaveCb.cancelled=!0,i._leaveCb());var a=Vn(n.data.transition);if(!e(a)&&!t(i._enterCb)&&1===i.nodeType){for(var s=a.css,c=a.type,u=a.enterClass,f=a.enterToClass,d=a.enterActiveClass,p=a.appearClass,v=a.appearToClass,h=a.appearActiveClass,m=a.beforeEnter,y=a.enter,g=a.afterEnter,_=a.enterCancelled,b=a.beforeAppear,$=a.appear,w=a.afterAppear,x=a.appearCancelled,k=a.duration,A=jo,O=jo.$vnode;O&&O.parent;)A=(O=O.parent).context;var S=!A._isMounted||!n.isRootInsert;if(!S||$||""===$){var T=S&&p?p:u,E=S&&h?h:d,j=S&&v?v:f,N=S?b||m:m,L=S&&"function"==typeof $?$:y,I=S?w||g:g,M=S?x||_:_,D=l(o(k)?k.enter:k),P=!1!==s&&!Wi,F=er(L),R=i._enterCb=C(function(){P&&(Jn(i,j),Jn(i,E)),R.cancelled?(P&&Jn(i,T),M&&M(i)):I&&I(i),i._enterCb=null});n.data.show||ae(n,"insert",function(){var e=i.parentNode,t=e&&e._pending&&e._pending[n.key];t&&t.tag===n.tag&&t.elm._leaveCb&&t.elm._leaveCb(),L&&L(i,R)}),N&&N(i),P&&(Kn(i,T),Kn(i,E),zn(function(){Kn(i,j),Jn(i,T),R.cancelled||F||(Xn(D)?setTimeout(R,D):qn(i,c,R))})),n.data.show&&(r&&r(),L&&L(i,R)),P||F||R()}}}function Qn(n,r){function i(){x.cancelled||(n.data.show||((a.parentNode._pending||(a.parentNode._pending={}))[n.key]=n),v&&v(a),b&&(Kn(a,f),Kn(a,p),zn(function(){Kn(a,d),Jn(a,f),x.cancelled||$||(Xn(w)?setTimeout(x,w):qn(a,u,x))})),h&&h(a,x),b||$||x())}var a=n.elm;t(a._enterCb)&&(a._enterCb.cancelled=!0,a._enterCb());var s=Vn(n.data.transition);if(e(s))return r();if(!t(a._leaveCb)&&1===a.nodeType){var c=s.css,u=s.type,f=s.leaveClass,d=s.leaveToClass,p=s.leaveActiveClass,v=s.beforeLeave,h=s.leave,m=s.afterLeave,y=s.leaveCancelled,g=s.delayLeave,_=s.duration,b=!1!==c&&!Wi,$=er(h),w=l(o(_)?_.leave:_),x=a._leaveCb=C(function(){a.parentNode&&a.parentNode._pending&&(a.parentNode._pending[n.key]=null),b&&(Jn(a,d),Jn(a,p)),x.cancelled?(b&&Jn(a,f),y&&y(a)):(r(),m&&m(a)),a._leaveCb=null});g?g(i):i()}}function Xn(e){return"number"==typeof e&&!isNaN(e)}function er(n){if(e(n))return!1;var r=n.fns;return t(r)?er(Array.isArray(r)?r[0]:r):(n._length||n.length)>1}function tr(e,t){!0!==t.data.show&&Yn(t)}function nr(e,t,n){rr(e,t,n),(qi||Gi)&&setTimeout(function(){rr(e,t,n)},0)}function rr(e,t,n){var r=t.value,i=e.multiple;if(!i||Array.isArray(r)){for(var o,a,s=0,c=e.options.length;s<c;s++)if(a=e.options[s],i)o=$(r,or(a))>-1,a.selected!==o&&(a.selected=o);else if(b(or(a),r))return void(e.selectedIndex!==s&&(e.selectedIndex=s));i||(e.selectedIndex=-1)}}function ir(e,t){return t.every(function(t){return!b(t,e)})}function or(e){return"_value"in e?e._value:e.value}function ar(e){e.target.composing=!0}function sr(e){e.target.composing&&(e.target.composing=!1,cr(e.target,"input"))}function cr(e,t){var n=document.createEvent("HTMLEvents");n.initEvent(t,!0,!0),e.dispatchEvent(n)}function ur(e){return!e.componentInstance||e.data&&e.data.transition?e:ur(e.componentInstance._vnode)}function lr(e){var t=e&&e.componentOptions;return t&&t.Ctor.options.abstract?lr(ye(t.children)):e}function fr(e){var t={},n=e.$options;for(var r in n.propsData)t[r]=e[r];var i=n._parentListeners;for(var o in i)t[Ni(o)]=i[o];return t}function dr(e,t){if(/\d-keep-alive$/.test(t.tag))return e("keep-alive",{props:t.componentOptions.propsData})}function pr(e){for(;e=e.parent;)if(e.data.transition)return!0}function vr(e,t){return t.key===e.key&&t.tag===e.tag}function hr(e){e.elm._moveCb&&e.elm._moveCb(),e.elm._enterCb&&e.elm._enterCb()}function mr(e){e.data.newPos=e.elm.getBoundingClientRect()}function yr(e){var t=e.data.pos,n=e.data.newPos,r=t.left-n.left,i=t.top-n.top;if(r||i){e.data.moved=!0;var o=e.elm.style;o.transform=o.WebkitTransform="translate("+r+"px,"+i+"px)",o.transitionDuration="0s"}}function gr(e,t){var n=t?as(t):is;if(n.test(e)){for(var r,i,o=[],a=n.lastIndex=0;r=n.exec(e);){(i=r.index)>a&&o.push(JSON.stringify(e.slice(a,i)));var s=an(r[1].trim());o.push("_s("+s+")"),a=i+r[0].length}return a<e.length&&o.push(JSON.stringify(e.slice(a))),o.join("+")}}function _r(e,t){var n=t?Fs:Ps;return e.replace(n,function(e){return Ds[e]})}function br(e,t){function n(t){l+=t,e=e.substring(t)}function r(e,n,r){var i,s;if(null==n&&(n=l),null==r&&(r=l),e&&(s=e.toLowerCase()),e)for(i=a.length-1;i>=0&&a[i].lowerCasedTag!==s;i--);else i=0;if(i>=0){for(var c=a.length-1;c>=i;c--)t.end&&t.end(a[c].tag,n,r);a.length=i,o=i&&a[i-1].tag}else"br"===s?t.start&&t.start(e,[],!0,n,r):"p"===s&&(t.start&&t.start(e,[],!1,n,r),t.end&&t.end(e,n,r))}for(var i,o,a=[],s=t.expectHTML,c=t.isUnaryTag||Di,u=t.canBeLeftOpenTag||Di,l=0;e;){if(i=e,o&&Is(o)){var f=0,d=o.toLowerCase(),p=Ms[d]||(Ms[d]=new RegExp("([\\s\\S]*?)(</"+d+"[^>]*>)","i")),v=e.replace(p,function(e,n,r){return f=r.length,Is(d)||"noscript"===d||(n=n.replace(/<!--([\s\S]*?)-->/g,"$1").replace(/<!\[CDATA\[([\s\S]*?)]]>/g,"$1")),Hs(d,n)&&(n=n.slice(1)),t.chars&&t.chars(n),""});l+=e.length-v.length,e=v,r(d,l-f,l)}else{var h=e.indexOf("<");if(0===h){if(bs.test(e)){var m=e.indexOf("--\x3e");if(m>=0){t.shouldKeepComment&&t.comment(e.substring(4,m)),n(m+3);continue}}if($s.test(e)){var y=e.indexOf("]>");if(y>=0){n(y+2);continue}}var g=e.match(_s);if(g){n(g[0].length);continue}var _=e.match(gs);if(_){var b=l;n(_[0].length),r(_[1],b,l);continue}var $=function(){var t=e.match(ms);if(t){var r={tagName:t[1],attrs:[],start:l};n(t[0].length);for(var i,o;!(i=e.match(ys))&&(o=e.match(ps));)n(o[0].length),r.attrs.push(o);if(i)return r.unarySlash=i[1],n(i[0].length),r.end=l,r}}();if($){!function(e){var n=e.tagName,i=e.unarySlash;s&&("p"===o&&ds(n)&&r(o),u(n)&&o===n&&r(n));for(var l=c(n)||!!i,f=e.attrs.length,d=new Array(f),p=0;p<f;p++){var v=e.attrs[p];Cs&&-1===v[0].indexOf('""')&&(""===v[3]&&delete v[3],""===v[4]&&delete v[4],""===v[5]&&delete v[5]);var h=v[3]||v[4]||v[5]||"",m="a"===n&&"href"===v[1]?t.shouldDecodeNewlinesForHref:t.shouldDecodeNewlines;d[p]={name:v[1],value:_r(h,m)}}l||(a.push({tag:n,lowerCasedTag:n.toLowerCase(),attrs:d}),o=n),t.start&&t.start(n,d,l,e.start,e.end)}($),Hs(o,e)&&n(1);continue}}var C=void 0,w=void 0,x=void 0;if(h>=0){for(w=e.slice(h);!(gs.test(w)||ms.test(w)||bs.test(w)||$s.test(w)||(x=w.indexOf("<",1))<0);)h+=x,w=e.slice(h);C=e.substring(0,h),n(h)}h<0&&(C=e,e=""),t.chars&&C&&t.chars(C)}if(e===i){t.chars&&t.chars(e);break}}r()}function $r(e,t,n){return{type:1,tag:e,attrsList:t,attrsMap:Rr(t),parent:n,children:[]}}function Cr(e,t){function n(e){e.pre&&(s=!1),Ss(e.tag)&&(c=!1)}ws=t.warn||cn,Ss=t.isPreTag||Di,Ts=t.mustUseProp||Di,Es=t.getTagNamespace||Di,ks=un(t.modules,"transformNode"),As=un(t.modules,"preTransformNode"),Os=un(t.modules,"postTransformNode"),xs=t.delimiters;var r,i,o=[],a=!1!==t.preserveWhitespace,s=!1,c=!1;return br(e,{warn:ws,expectHTML:t.expectHTML,isUnaryTag:t.isUnaryTag,canBeLeftOpenTag:t.canBeLeftOpenTag,shouldDecodeNewlines:t.shouldDecodeNewlines,shouldDecodeNewlinesForHref:t.shouldDecodeNewlinesForHref,shouldKeepComment:t.comments,start:function(e,a,u){var l=i&&i.ns||Es(e);qi&&"svg"===l&&(a=Ur(a));var f=$r(e,a,i);l&&(f.ns=l),Br(f)&&!ro()&&(f.forbidden=!0);for(var d=0;d<As.length;d++)f=As[d](f,t)||f;if(s||(wr(f),f.pre&&(s=!0)),Ss(f.tag)&&(c=!0),s?xr(f):f.processed||(Sr(f),Tr(f),Lr(f),kr(f,t)),r?o.length||r.if&&(f.elseif||f.else)&&Nr(r,{exp:f.elseif,block:f}):r=f,i&&!f.forbidden)if(f.elseif||f.else)Er(f,i);else if(f.slotScope){i.plain=!1;var p=f.slotTarget||'"default"';(i.scopedSlots||(i.scopedSlots={}))[p]=f}else i.children.push(f),f.parent=i;u?n(f):(i=f,o.push(f));for(var v=0;v<Os.length;v++)Os[v](f,t)},end:function(){var e=o[o.length-1],t=e.children[e.children.length-1];t&&3===t.type&&" "===t.text&&!c&&e.children.pop(),o.length-=1,i=o[o.length-1],n(e)},chars:function(e){if(i&&(!qi||"textarea"!==i.tag||i.attrsMap.placeholder!==e)){var t=i.children;if(e=c||e.trim()?Hr(i)?e:Ws(e):a&&t.length?" ":""){var n;!s&&" "!==e&&(n=gr(e,xs))?t.push({type:2,expression:n,text:e}):" "===e&&t.length&&" "===t[t.length-1].text||t.push({type:3,text:e})}}},comment:function(e){i.children.push({type:3,text:e,isComment:!0})}}),r}function wr(e){null!=hn(e,"v-pre")&&(e.pre=!0)}function xr(e){var t=e.attrsList.length;if(t)for(var n=e.attrs=new Array(t),r=0;r<t;r++)n[r]={name:e.attrsList[r].name,value:JSON.stringify(e.attrsList[r].value)};else e.pre||(e.plain=!0)}function kr(e,t){Ar(e),e.plain=!e.key&&!e.attrsList.length,Or(e),Ir(e),Mr(e);for(var n=0;n<ks.length;n++)e=ks[n](e,t)||e;Dr(e)}function Ar(e){var t=vn(e,"key");t&&(e.key=t)}function Or(e){var t=vn(e,"ref");t&&(e.ref=t,e.refInFor=Pr(e))}function Sr(e){var t;if(t=hn(e,"v-for")){var n=t.match(Vs);if(!n)return;e.for=n[2].trim();var r=n[1].trim(),i=r.match(zs);i?(e.alias=i[1].trim(),e.iterator1=i[2].trim(),i[3]&&(e.iterator2=i[3].trim())):e.alias=r}}function Tr(e){var t=hn(e,"v-if");if(t)e.if=t,Nr(e,{exp:t,block:e});else{null!=hn(e,"v-else")&&(e.else=!0);var n=hn(e,"v-else-if");n&&(e.elseif=n)}}function Er(e,t){var n=jr(t.children);n&&n.if&&Nr(n,{exp:e.elseif,block:e})}function jr(e){for(var t=e.length;t--;){if(1===e[t].type)return e[t];e.pop()}}function Nr(e,t){e.ifConditions||(e.ifConditions=[]),e.ifConditions.push(t)}function Lr(e){null!=hn(e,"v-once")&&(e.once=!0)}function Ir(e){if("slot"===e.tag)e.slotName=vn(e,"name");else{var t;"template"===e.tag?(t=hn(e,"scope"),e.slotScope=t||hn(e,"slot-scope")):(t=hn(e,"slot-scope"))&&(e.slotScope=t);var n=vn(e,"slot");n&&(e.slotTarget='""'===n?'"default"':n,"template"===e.tag||e.slotScope||fn(e,"slot",n))}}function Mr(e){var t;(t=vn(e,"is"))&&(e.component=t),null!=hn(e,"inline-template")&&(e.inlineTemplate=!0)}function Dr(e){var t,n,r,i,o,a,s,c=e.attrsList;for(t=0,n=c.length;t<n;t++)if(r=i=c[t].name,o=c[t].value,Us.test(r))if(e.hasBindings=!0,(a=Fr(r))&&(r=r.replace(qs,"")),Js.test(r))r=r.replace(Js,""),o=an(o),s=!1,a&&(a.prop&&(s=!0,"innerHtml"===(r=Ni(r))&&(r="innerHTML")),a.camel&&(r=Ni(r)),a.sync&&pn(e,"update:"+Ni(r),yn(o,"$event"))),s||!e.component&&Ts(e.tag,e.attrsMap.type,r)?ln(e,r,o):fn(e,r,o);else if(Bs.test(r))pn(e,r=r.replace(Bs,""),o,a,!1,ws);else{var u=(r=r.replace(Us,"")).match(Ks),l=u&&u[1];l&&(r=r.slice(0,-(l.length+1))),dn(e,r,i,o,l,a)}else fn(e,r,JSON.stringify(o)),!e.component&&"muted"===r&&Ts(e.tag,e.attrsMap.type,r)&&ln(e,r,"true")}function Pr(e){for(var t=e;t;){if(void 0!==t.for)return!0;t=t.parent}return!1}function Fr(e){var t=e.match(qs);if(t){var n={};return t.forEach(function(e){n[e.slice(1)]=!0}),n}}function Rr(e){for(var t={},n=0,r=e.length;n<r;n++)t[e[n].name]=e[n].value;return t}function Hr(e){return"script"===e.tag||"style"===e.tag}function Br(e){return"style"===e.tag||"script"===e.tag&&(!e.attrsMap.type||"text/javascript"===e.attrsMap.type)}function Ur(e){for(var t=[],n=0;n<e.length;n++){var r=e[n];Gs.test(r.name)||(r.name=r.name.replace(Zs,""),t.push(r))}return t}function Vr(e){return $r(e.tag,e.attrsList.slice(),e.parent)}function zr(e,t,n){e.attrsMap[t]=n,e.attrsList.push({name:t,value:n})}function Kr(e,t){e&&(js=Xs(t.staticKeys||""),Ns=t.isReservedTag||Di,Jr(e),qr(e,!1))}function Jr(e){if(e.static=Wr(e),1===e.type){if(!Ns(e.tag)&&"slot"!==e.tag&&null==e.attrsMap["inline-template"])return;for(var t=0,n=e.children.length;t<n;t++){var r=e.children[t];Jr(r),r.static||(e.static=!1)}if(e.ifConditions)for(var i=1,o=e.ifConditions.length;i<o;i++){var a=e.ifConditions[i].block;Jr(a),a.static||(e.static=!1)}}}function qr(e,t){if(1===e.type){if((e.static||e.once)&&(e.staticInFor=t),e.static&&e.children.length&&(1!==e.children.length||3!==e.children[0].type))return void(e.staticRoot=!0);if(e.staticRoot=!1,e.children)for(var n=0,r=e.children.length;n<r;n++)qr(e.children[n],t||!!e.for);if(e.ifConditions)for(var i=1,o=e.ifConditions.length;i<o;i++)qr(e.ifConditions[i].block,t)}}function Wr(e){return 2!==e.type&&(3===e.type||!(!e.pre&&(e.hasBindings||e.if||e.for||Si(e.tag)||!Ns(e.tag)||Gr(e)||!Object.keys(e).every(js))))}function Gr(e){for(;e.parent;){if("template"!==(e=e.parent).tag)return!1;if(e.for)return!0}return!1}function Zr(e,t,n){var r=t?"nativeOn:{":"on:{";for(var i in e){var o=e[i];r+='"'+i+'":'+Yr(i,o)+","}return r.slice(0,-1)+"}"}function Yr(e,t){if(!t)return"function(){}";if(Array.isArray(t))return"["+t.map(function(t){return Yr(e,t)}).join(",")+"]";var n=tc.test(t.value),r=ec.test(t.value);if(t.modifiers){var i="",o="",a=[];for(var s in t.modifiers)if(ic[s])o+=ic[s],nc[s]&&a.push(s);else if("exact"===s){var c=t.modifiers;o+=rc(["ctrl","shift","alt","meta"].filter(function(e){return!c[e]}).map(function(e){return"$event."+e+"Key"}).join("||"))}else a.push(s);return a.length&&(i+=Qr(a)),o&&(i+=o),"function($event){"+i+(n?t.value+"($event)":r?"("+t.value+")($event)":t.value)+"}"}return n||r?t.value:"function($event){"+t.value+"}"}function Qr(e){return"if(!('button' in $event)&&"+e.map(Xr).join("&&")+")return null;"}function Xr(e){var t=parseInt(e,10);if(t)return"$event.keyCode!=="+t;var n=nc[e];return"_k($event.keyCode,"+JSON.stringify(e)+","+JSON.stringify(n)+",$event.key)"}function ei(e,t){var n=new ac(t);return{render:"with(this){return "+(e?ti(e,n):'_c("div")')+"}",staticRenderFns:n.staticRenderFns}}function ti(e,t){if(e.staticRoot&&!e.staticProcessed)return ni(e,t);if(e.once&&!e.onceProcessed)return ri(e,t);if(e.for&&!e.forProcessed)return ai(e,t);if(e.if&&!e.ifProcessed)return ii(e,t);if("template"!==e.tag||e.slotTarget){if("slot"===e.tag)return _i(e,t);var n;if(e.component)n=bi(e.component,e,t);else{var r=e.plain?void 0:si(e,t),i=e.inlineTemplate?null:pi(e,t,!0);n="_c('"+e.tag+"'"+(r?","+r:"")+(i?","+i:"")+")"}for(var o=0;o<t.transforms.length;o++)n=t.transforms[o](e,n);return n}return pi(e,t)||"void 0"}function ni(e,t){return e.staticProcessed=!0,t.staticRenderFns.push("with(this){return "+ti(e,t)+"}"),"_m("+(t.staticRenderFns.length-1)+(e.staticInFor?",true":"")+")"}function ri(e,t){if(e.onceProcessed=!0,e.if&&!e.ifProcessed)return ii(e,t);if(e.staticInFor){for(var n="",r=e.parent;r;){if(r.for){n=r.key;break}r=r.parent}return n?"_o("+ti(e,t)+","+t.onceId+++","+n+")":ti(e,t)}return ni(e,t)}function ii(e,t,n,r){return e.ifProcessed=!0,oi(e.ifConditions.slice(),t,n,r)}function oi(e,t,n,r){function i(e){return n?n(e,t):e.once?ri(e,t):ti(e,t)}if(!e.length)return r||"_e()";var o=e.shift();return o.exp?"("+o.exp+")?"+i(o.block)+":"+oi(e,t,n,r):""+i(o.block)}function ai(e,t,n,r){var i=e.for,o=e.alias,a=e.iterator1?","+e.iterator1:"",s=e.iterator2?","+e.iterator2:"";return e.forProcessed=!0,(r||"_l")+"(("+i+"),function("+o+a+s+"){return "+(n||ti)(e,t)+"})"}function si(e,t){var n="{",r=ci(e,t);r&&(n+=r+","),e.key&&(n+="key:"+e.key+","),e.ref&&(n+="ref:"+e.ref+","),e.refInFor&&(n+="refInFor:true,"),e.pre&&(n+="pre:true,"),e.component&&(n+='tag:"'+e.tag+'",');for(var i=0;i<t.dataGenFns.length;i++)n+=t.dataGenFns[i](e);if(e.attrs&&(n+="attrs:{"+$i(e.attrs)+"},"),e.props&&(n+="domProps:{"+$i(e.props)+"},"),e.events&&(n+=Zr(e.events,!1,t.warn)+","),e.nativeEvents&&(n+=Zr(e.nativeEvents,!0,t.warn)+","),e.slotTarget&&!e.slotScope&&(n+="slot:"+e.slotTarget+","),e.scopedSlots&&(n+=li(e.scopedSlots,t)+","),e.model&&(n+="model:{value:"+e.model.value+",callback:"+e.model.callback+",expression:"+e.model.expression+"},"),e.inlineTemplate){var o=ui(e,t);o&&(n+=o+",")}return n=n.replace(/,$/,"")+"}",e.wrapData&&(n=e.wrapData(n)),e.wrapListeners&&(n=e.wrapListeners(n)),n}function ci(e,t){var n=e.directives;if(n){var r,i,o,a,s="directives:[",c=!1;for(r=0,i=n.length;r<i;r++){o=n[r],a=!0;var u=t.directives[o.name];u&&(a=!!u(e,o,t.warn)),a&&(c=!0,s+='{name:"'+o.name+'",rawName:"'+o.rawName+'"'+(o.value?",value:("+o.value+"),expression:"+JSON.stringify(o.value):"")+(o.arg?',arg:"'+o.arg+'"':"")+(o.modifiers?",modifiers:"+JSON.stringify(o.modifiers):"")+"},")}return c?s.slice(0,-1)+"]":void 0}}function ui(e,t){var n=e.children[0];if(1===n.type){var r=ei(n,t.options);return"inlineTemplate:{render:function(){"+r.render+"},staticRenderFns:["+r.staticRenderFns.map(function(e){return"function(){"+e+"}"}).join(",")+"]}"}}function li(e,t){return"scopedSlots:_u(["+Object.keys(e).map(function(n){return fi(n,e[n],t)}).join(",")+"])"}function fi(e,t,n){return t.for&&!t.forProcessed?di(e,t,n):"{key:"+e+",fn:"+("function("+String(t.slotScope)+"){return "+("template"===t.tag?t.if?t.if+"?"+(pi(t,n)||"undefined")+":undefined":pi(t,n)||"undefined":ti(t,n))+"}")+"}"}function di(e,t,n){var r=t.for,i=t.alias,o=t.iterator1?","+t.iterator1:"",a=t.iterator2?","+t.iterator2:"";return t.forProcessed=!0,"_l(("+r+"),function("+i+o+a+"){return "+fi(e,t,n)+"})"}function pi(e,t,n,r,i){var o=e.children;if(o.length){var a=o[0];if(1===o.length&&a.for&&"template"!==a.tag&&"slot"!==a.tag)return(r||ti)(a,t);var s=n?vi(o,t.maybeComponent):0,c=i||mi;return"["+o.map(function(e){return c(e,t)}).join(",")+"]"+(s?","+s:"")}}function vi(e,t){for(var n=0,r=0;r<e.length;r++){var i=e[r];if(1===i.type){if(hi(i)||i.ifConditions&&i.ifConditions.some(function(e){return hi(e.block)})){n=2;break}(t(i)||i.ifConditions&&i.ifConditions.some(function(e){return t(e.block)}))&&(n=1)}}return n}function hi(e){return void 0!==e.for||"template"===e.tag||"slot"===e.tag}function mi(e,t){return 1===e.type?ti(e,t):3===e.type&&e.isComment?gi(e):yi(e)}function yi(e){return"_v("+(2===e.type?e.expression:Ci(JSON.stringify(e.text)))+")"}function gi(e){return"_e("+JSON.stringify(e.text)+")"}function _i(e,t){var n=e.slotName||'"default"',r=pi(e,t),i="_t("+n+(r?","+r:""),o=e.attrs&&"{"+e.attrs.map(function(e){return Ni(e.name)+":"+e.value}).join(",")+"}",a=e.attrsMap["v-bind"];return!o&&!a||r||(i+=",null"),o&&(i+=","+o),a&&(i+=(o?"":",null")+","+a),i+")"}function bi(e,t,n){var r=t.inlineTemplate?null:pi(t,n,!0);return"_c("+e+","+si(t,n)+(r?","+r:"")+")"}function $i(e){for(var t="",n=0;n<e.length;n++){var r=e[n];t+='"'+r.name+'":'+Ci(r.value)+","}return t.slice(0,-1)}function Ci(e){return e.replace(/\u2028/g,"\\u2028").replace(/\u2029/g,"\\u2029")}function wi(e,t){try{return new Function(e)}catch(n){return t.push({err:n,code:e}),_}}function xi(e){var t=Object.create(null);return function(n,r,i){delete(r=y({},r)).warn;var o=r.delimiters?String(r.delimiters)+n:n;if(t[o])return t[o];var a=e(n,r),s={},c=[];return s.render=wi(a.render,c),s.staticRenderFns=a.staticRenderFns.map(function(e){return wi(e,c)}),t[o]=s}}function ki(e){return Ls=Ls||document.createElement("div"),Ls.innerHTML=e?'<a href="\n"/>':'<div a="\n"/>',Ls.innerHTML.indexOf("&#10;")>0}function Ai(e){if(e.outerHTML)return e.outerHTML;var t=document.createElement("div");return t.appendChild(e.cloneNode(!0)),t.innerHTML}var Oi=Object.prototype.toString,Si=f("slot,component",!0),Ti=f("key,ref,slot,slot-scope,is"),Ei=Object.prototype.hasOwnProperty,ji=/-(\w)/g,Ni=v(function(e){return e.replace(ji,function(e,t){return t?t.toUpperCase():""})}),Li=v(function(e){return e.charAt(0).toUpperCase()+e.slice(1)}),Ii=/\B([A-Z])/g,Mi=v(function(e){return e.replace(Ii,"-$1").toLowerCase()}),Di=function(e,t,n){return!1},Pi=function(e){return e},Fi="data-server-rendered",Ri=["component","directive","filter"],Hi=["beforeCreate","created","beforeMount","mounted","beforeUpdate","updated","beforeDestroy","destroyed","activated","deactivated","errorCaptured"],Bi={optionMergeStrategies:Object.create(null),silent:!1,productionTip:!1,devtools:!1,performance:!1,errorHandler:null,warnHandler:null,ignoredElements:[],keyCodes:Object.create(null),isReservedTag:Di,isReservedAttr:Di,isUnknownElement:Di,getTagNamespace:_,parsePlatformTagName:Pi,mustUseProp:Di,_lifecycleHooks:Hi},Ui=Object.freeze({}),Vi=/[^\w.$]/,zi="__proto__"in{},Ki="undefined"!=typeof window,Ji=Ki&&window.navigator.userAgent.toLowerCase(),qi=Ji&&/msie|trident/.test(Ji),Wi=Ji&&Ji.indexOf("msie 9.0")>0,Gi=Ji&&Ji.indexOf("edge/")>0,Zi=Ji&&Ji.indexOf("android")>0,Yi=Ji&&/iphone|ipad|ipod|ios/.test(Ji),Qi=(Ji&&/chrome\/\d+/.test(Ji),{}.watch),Xi=!1;if(Ki)try{var eo={};Object.defineProperty(eo,"passive",{get:function(){Xi=!0}}),window.addEventListener("test-passive",null,eo)}catch(e){}var to,no,ro=function(){return void 0===to&&(to=!Ki&&"undefined"!=typeof global&&"server"===global.process.env.VUE_ENV),to},io=Ki&&window.__VUE_DEVTOOLS_GLOBAL_HOOK__,oo="undefined"!=typeof Symbol&&A(Symbol)&&"undefined"!=typeof Reflect&&A(Reflect.ownKeys);no="undefined"!=typeof Set&&A(Set)?Set:function(){function e(){this.set=Object.create(null)}return e.prototype.has=function(e){return!0===this.set[e]},e.prototype.add=function(e){this.set[e]=!0},e.prototype.clear=function(){this.set=Object.create(null)},e}();var ao=_,so=0,co=function(){this.id=so++,this.subs=[]};co.prototype.addSub=function(e){this.subs.push(e)},co.prototype.removeSub=function(e){d(this.subs,e)},co.prototype.depend=function(){co.target&&co.target.addDep(this)},co.prototype.notify=function(){for(var e=this.subs.slice(),t=0,n=e.length;t<n;t++)e[t].update()},co.target=null;var uo=[],lo=function(e,t,n,r,i,o,a,s){this.tag=e,this.data=t,this.children=n,this.text=r,this.elm=i,this.ns=void 0,this.context=o,this.functionalContext=void 0,this.functionalOptions=void 0,this.functionalScopeId=void 0,this.key=t&&t.key,this.componentOptions=a,this.componentInstance=void 0,this.parent=void 0,this.raw=!1,this.isStatic=!1,this.isRootInsert=!0,this.isComment=!1,this.isCloned=!1,this.isOnce=!1,this.asyncFactory=s,this.asyncMeta=void 0,this.isAsyncPlaceholder=!1},fo={child:{configurable:!0}};fo.child.get=function(){return this.componentInstance},Object.defineProperties(lo.prototype,fo);var po=function(e){void 0===e&&(e="");var t=new lo;return t.text=e,t.isComment=!0,t},vo=Array.prototype,ho=Object.create(vo);["push","pop","shift","unshift","splice","sort","reverse"].forEach(function(e){var t=vo[e];x(ho,e,function(){for(var n=[],r=arguments.length;r--;)n[r]=arguments[r];var i,o=t.apply(this,n),a=this.__ob__;switch(e){case"push":case"unshift":i=n;break;case"splice":i=n.slice(2)}return i&&a.observeArray(i),a.dep.notify(),o})});var mo=Object.getOwnPropertyNames(ho),yo={shouldConvert:!0},go=function(e){this.value=e,this.dep=new co,this.vmCount=0,x(e,"__ob__",this),Array.isArray(e)?((zi?N:L)(e,ho,mo),this.observeArray(e)):this.walk(e)};go.prototype.walk=function(e){for(var t=Object.keys(e),n=0;n<t.length;n++)M(e,t[n],e[t[n]])},go.prototype.observeArray=function(e){for(var t=0,n=e.length;t<n;t++)I(e[t])};var _o=Bi.optionMergeStrategies;_o.data=function(e,t,n){return n?H(e,t,n):t&&"function"!=typeof t?e:H(e,t)},Hi.forEach(function(e){_o[e]=B}),Ri.forEach(function(e){_o[e+"s"]=U}),_o.watch=function(e,t,n,r){if(e===Qi&&(e=void 0),t===Qi&&(t=void 0),!t)return Object.create(e||null);if(!e)return t;var i={};y(i,e);for(var o in t){var a=i[o],s=t[o];a&&!Array.isArray(a)&&(a=[a]),i[o]=a?a.concat(s):Array.isArray(s)?s:[s]}return i},_o.props=_o.methods=_o.inject=_o.computed=function(e,t,n,r){if(!e)return t;var i=Object.create(null);return y(i,e),t&&y(i,t),i},_o.provide=H;var bo,$o,Co=function(e,t){return void 0===t?e:t},wo=[],xo=!1,ko=!1;if("undefined"!=typeof setImmediate&&A(setImmediate))$o=function(){setImmediate(te)};else if("undefined"==typeof MessageChannel||!A(MessageChannel)&&"[object MessageChannelConstructor]"!==MessageChannel.toString())$o=function(){setTimeout(te,0)};else{var Ao=new MessageChannel,Oo=Ao.port2;Ao.port1.onmessage=te,$o=function(){Oo.postMessage(1)}}if("undefined"!=typeof Promise&&A(Promise)){var So=Promise.resolve();bo=function(){So.then(te),Yi&&setTimeout(_)}}else bo=$o;var To,Eo=v(function(e){var t="&"===e.charAt(0),n="~"===(e=t?e.slice(1):e).charAt(0),r="!"===(e=n?e.slice(1):e).charAt(0);return e=r?e.slice(1):e,{name:e,once:n,capture:r,passive:t}}),jo=null,No=[],Lo=[],Io={},Mo=!1,Do=!1,Po=0,Fo=0,Ro=function(e,t,n,r){this.vm=e,e._watchers.push(this),r?(this.deep=!!r.deep,this.user=!!r.user,this.lazy=!!r.lazy,this.sync=!!r.sync):this.deep=this.user=this.lazy=this.sync=!1,this.cb=n,this.id=++Fo,this.active=!0,this.dirty=this.lazy,this.deps=[],this.newDeps=[],this.depIds=new no,this.newDepIds=new no,this.expression="","function"==typeof t?this.getter=t:(this.getter=k(t),this.getter||(this.getter=function(){})),this.value=this.lazy?void 0:this.get()};Ro.prototype.get=function(){O(this);var e,t=this.vm;try{e=this.getter.call(t,t)}catch(e){if(!this.user)throw e;Q(e,t,'getter for watcher "'+this.expression+'"')}finally{this.deep&&Fe(e),S(),this.cleanupDeps()}return e},Ro.prototype.addDep=function(e){var t=e.id;this.newDepIds.has(t)||(this.newDepIds.add(t),this.newDeps.push(e),this.depIds.has(t)||e.addSub(this))},Ro.prototype.cleanupDeps=function(){for(var e=this,t=this.deps.length;t--;){var n=e.deps[t];e.newDepIds.has(n.id)||n.removeSub(e)}var r=this.depIds;this.depIds=this.newDepIds,this.newDepIds=r,this.newDepIds.clear(),r=this.deps,this.deps=this.newDeps,this.newDeps=r,this.newDeps.length=0},Ro.prototype.update=function(){this.lazy?this.dirty=!0:this.sync?this.run():Pe(this)},Ro.prototype.run=function(){if(this.active){var e=this.get();if(e!==this.value||o(e)||this.deep){var t=this.value;if(this.value=e,this.user)try{this.cb.call(this.vm,e,t)}catch(e){Q(e,this.vm,'callback for watcher "'+this.expression+'"')}else this.cb.call(this.vm,e,t)}}},Ro.prototype.evaluate=function(){this.value=this.get(),this.dirty=!1},Ro.prototype.depend=function(){for(var e=this,t=this.deps.length;t--;)e.deps[t].depend()},Ro.prototype.teardown=function(){var e=this;if(this.active){this.vm._isBeingDestroyed||d(this.vm._watchers,this);for(var t=this.deps.length;t--;)e.deps[t].removeSub(e);this.active=!1}};var Ho=new no,Bo={enumerable:!0,configurable:!0,get:_,set:_},Uo={lazy:!0};lt(ft.prototype);var Vo={init:function(e,t,n,r){if(!e.componentInstance||e.componentInstance._isDestroyed)(e.componentInstance=ht(e,jo,n,r)).$mount(t?e.elm:void 0,t);else if(e.data.keepAlive){var i=e;Vo.prepatch(i,i)}},prepatch:function(e,t){var n=t.componentOptions;Oe(t.componentInstance=e.componentInstance,n.propsData,n.listeners,t,n.children)},insert:function(e){var t=e.context,n=e.componentInstance;n._isMounted||(n._isMounted=!0,je(n,"mounted")),e.data.keepAlive&&(t._isMounted?Me(n):Te(n,!0))},destroy:function(e){var t=e.componentInstance;t._isDestroyed||(e.data.keepAlive?Ee(t,!0):t.$destroy())}},zo=Object.keys(Vo),Ko=1,Jo=2,qo=0;!function(e){e.prototype._init=function(e){var t=this;t._uid=qo++,t._isVue=!0,e&&e._isComponent?wt(t,e):t.$options=J(xt(t.constructor),e||{},t),t._renderProxy=t,t._self=t,ke(t),ge(t),Ct(t),je(t,"beforeCreate"),Qe(t),Be(t),Ye(t),je(t,"created"),t.$options.el&&t.$mount(t.$options.el)}}(Ot),function(e){var t={};t.get=function(){return this._data};var n={};n.get=function(){return this._props},Object.defineProperty(e.prototype,"$data",t),Object.defineProperty(e.prototype,"$props",n),e.prototype.$set=D,e.prototype.$delete=P,e.prototype.$watch=function(e,t,n){var r=this;if(a(t))return Ze(r,e,t,n);(n=n||{}).user=!0;var i=new Ro(r,e,t,n);return n.immediate&&t.call(r,i.value),function(){i.teardown()}}}(Ot),function(e){var t=/^hook:/;e.prototype.$on=function(e,n){var r=this,i=this;if(Array.isArray(e))for(var o=0,a=e.length;o<a;o++)r.$on(e[o],n);else(i._events[e]||(i._events[e]=[])).push(n),t.test(e)&&(i._hasHookEvent=!0);return i},e.prototype.$once=function(e,t){function n(){r.$off(e,n),t.apply(r,arguments)}var r=this;return n.fn=t,r.$on(e,n),r},e.prototype.$off=function(e,t){var n=this,r=this;if(!arguments.length)return r._events=Object.create(null),r;if(Array.isArray(e)){for(var i=0,o=e.length;i<o;i++)n.$off(e[i],t);return r}var a=r._events[e];if(!a)return r;if(!t)return r._events[e]=null,r;if(t)for(var s,c=a.length;c--;)if((s=a[c])===t||s.fn===t){a.splice(c,1);break}return r},e.prototype.$emit=function(e){var t=this,n=t._events[e];if(n){n=n.length>1?m(n):n;for(var r=m(arguments,1),i=0,o=n.length;i<o;i++)try{n[i].apply(t,r)}catch(n){Q(n,t,'event handler for "'+e+'"')}}return t}}(Ot),function(e){e.prototype._update=function(e,t){var n=this;n._isMounted&&je(n,"beforeUpdate");var r=n.$el,i=n._vnode,o=jo;jo=n,n._vnode=e,i?n.$el=n.__patch__(i,e):(n.$el=n.__patch__(n.$el,e,t,!1,n.$options._parentElm,n.$options._refElm),n.$options._parentElm=n.$options._refElm=null),jo=o,r&&(r.__vue__=null),n.$el&&(n.$el.__vue__=n),n.$vnode&&n.$parent&&n.$vnode===n.$parent._vnode&&(n.$parent.$el=n.$el)},e.prototype.$forceUpdate=function(){var e=this;e._watcher&&e._watcher.update()},e.prototype.$destroy=function(){var e=this;if(!e._isBeingDestroyed){je(e,"beforeDestroy"),e._isBeingDestroyed=!0;var t=e.$parent;!t||t._isBeingDestroyed||e.$options.abstract||d(t.$children,e),e._watcher&&e._watcher.teardown();for(var n=e._watchers.length;n--;)e._watchers[n].teardown();e._data.__ob__&&e._data.__ob__.vmCount--,e._isDestroyed=!0,e.__patch__(e._vnode,null),je(e,"destroyed"),e.$off(),e.$el&&(e.$el.__vue__=null),e.$vnode&&(e.$vnode.parent=null)}}}(Ot),function(e){lt(e.prototype),e.prototype.$nextTick=function(e){return re(e,this)},e.prototype._render=function(){var e=this,t=e.$options,n=t.render,r=t._parentVnode;if(e._isMounted)for(var i in e.$slots){var o=e.$slots[i];o._rendered&&(e.$slots[i]=j(o,!0))}e.$scopedSlots=r&&r.data.scopedSlots||Ui,e.$vnode=r;var a;try{a=n.call(e._renderProxy,e.$createElement)}catch(t){Q(t,e,"render"),a=e._vnode}return a instanceof lo||(a=po()),a.parent=r,a}}(Ot);var Wo=[String,RegExp,Array],Go={KeepAlive:{name:"keep-alive",abstract:!0,props:{include:Wo,exclude:Wo,max:[String,Number]},created:function(){this.cache=Object.create(null),this.keys=[]},destroyed:function(){var e=this;for(var t in e.cache)Pt(e.cache,t,e.keys)},watch:{include:function(e){Dt(this,function(t){return Mt(e,t)})},exclude:function(e){Dt(this,function(t){return!Mt(e,t)})}},render:function(){var e=ye(this.$slots.default),t=e&&e.componentOptions;if(t){var n=It(t);if(n&&(this.exclude&&Mt(this.exclude,n)||this.include&&!Mt(this.include,n)))return e;var r=this,i=r.cache,o=r.keys,a=null==e.key?t.Ctor.cid+(t.tag?"::"+t.tag:""):e.key;i[a]?(e.componentInstance=i[a].componentInstance,d(o,a),o.push(a)):(i[a]=e,o.push(a),this.max&&o.length>parseInt(this.max)&&Pt(i,o[0],o,this._vnode)),e.data.keepAlive=!0}return e}}};!function(e){var t={};t.get=function(){return Bi},Object.defineProperty(e,"config",t),e.util={warn:ao,extend:y,mergeOptions:J,defineReactive:M},e.set=D,e.delete=P,e.nextTick=re,e.options=Object.create(null),Ri.forEach(function(t){e.options[t+"s"]=Object.create(null)}),e.options._base=e,y(e.options.components,Go),St(e),Tt(e),Et(e),Lt(e)}(Ot),Object.defineProperty(Ot.prototype,"$isServer",{get:ro}),Object.defineProperty(Ot.prototype,"$ssrContext",{get:function(){return this.$vnode&&this.$vnode.ssrContext}}),Ot.version="2.5.3";var Zo,Yo,Qo,Xo,ea,ta,na,ra,ia=f("style,class"),oa=f("input,textarea,option,select,progress"),aa=function(e,t,n){return"value"===n&&oa(e)&&"button"!==t||"selected"===n&&"option"===e||"checked"===n&&"input"===e||"muted"===n&&"video"===e},sa=f("contenteditable,draggable,spellcheck"),ca=f("allowfullscreen,async,autofocus,autoplay,checked,compact,controls,declare,default,defaultchecked,defaultmuted,defaultselected,defer,disabled,enabled,formnovalidate,hidden,indeterminate,inert,ismap,itemscope,loop,multiple,muted,nohref,noresize,noshade,novalidate,nowrap,open,pauseonexit,readonly,required,reversed,scoped,seamless,selected,sortable,translate,truespeed,typemustmatch,visible"),ua="http://www.w3.org/1999/xlink",la=function(e){return":"===e.charAt(5)&&"xlink"===e.slice(0,5)},fa=function(e){return la(e)?e.slice(6,e.length):""},da=function(e){return null==e||!1===e},pa={svg:"http://www.w3.org/2000/svg",math:"http://www.w3.org/1998/Math/MathML"},va=f("html,body,base,head,link,meta,style,title,address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,hgroup,nav,section,div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,rtc,ruby,s,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,embed,object,param,source,canvas,script,noscript,del,ins,caption,col,colgroup,table,thead,tbody,td,th,tr,button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,output,progress,select,textarea,details,dialog,menu,menuitem,summary,content,element,shadow,template,blockquote,iframe,tfoot"),ha=f("svg,animate,circle,clippath,cursor,defs,desc,ellipse,filter,font-face,foreignObject,g,glyph,image,line,marker,mask,missing-glyph,path,pattern,polygon,polyline,rect,switch,symbol,text,textpath,tspan,use,view",!0),ma=function(e){return va(e)||ha(e)},ya=Object.create(null),ga=f("text,number,password,search,email,tel,url"),_a=Object.freeze({createElement:function(e,t){var n=document.createElement(e);return"select"!==e?n:(t.data&&t.data.attrs&&void 0!==t.data.attrs.multiple&&n.setAttribute("multiple","multiple"),n)},createElementNS:function(e,t){return document.createElementNS(pa[e],t)},createTextNode:function(e){return document.createTextNode(e)},createComment:function(e){return document.createComment(e)},insertBefore:function(e,t,n){e.insertBefore(t,n)},removeChild:function(e,t){e.removeChild(t)},appendChild:function(e,t){e.appendChild(t)},parentNode:function(e){return e.parentNode},nextSibling:function(e){return e.nextSibling},tagName:function(e){return e.tagName},setTextContent:function(e,t){e.textContent=t},setAttribute:function(e,t,n){e.setAttribute(t,n)}}),ba={create:function(e,t){qt(t)},update:function(e,t){e.data.ref!==t.data.ref&&(qt(e,!0),qt(t))},destroy:function(e){qt(e,!0)}},$a=new lo("",{},[]),Ca=["create","activate","update","remove","destroy"],wa={create:Yt,update:Yt,destroy:function(e){Yt(e,$a)}},xa=Object.create(null),ka=[ba,wa],Aa={create:nn,update:nn},Oa={create:on,update:on},Sa=/[\w).+\-_$\]]/,Ta="__r",Ea="__c",ja={create:Nn,update:Nn},Na={create:Ln,update:Ln},La=v(function(e){var t={},n=/;(?![^(]*\))/g,r=/:(.+)/;return e.split(n).forEach(function(e){if(e){var n=e.split(r);n.length>1&&(t[n[0].trim()]=n[1].trim())}}),t}),Ia=/^--/,Ma=/\s*!important$/,Da=function(e,t,n){if(Ia.test(t))e.style.setProperty(t,n);else if(Ma.test(n))e.style.setProperty(t,n.replace(Ma,""),"important");else{var r=Fa(t);if(Array.isArray(n))for(var i=0,o=n.length;i<o;i++)e.style[r]=n[i];else e.style[r]=n}},Pa=["Webkit","Moz","ms"],Fa=v(function(e){if(ra=ra||document.createElement("div").style,"filter"!==(e=Ni(e))&&e in ra)return e;for(var t=e.charAt(0).toUpperCase()+e.slice(1),n=0;n<Pa.length;n++){var r=Pa[n]+t;if(r in ra)return r}}),Ra={create:Hn,update:Hn},Ha=v(function(e){return{enterClass:e+"-enter",enterToClass:e+"-enter-to",enterActiveClass:e+"-enter-active",leaveClass:e+"-leave",leaveToClass:e+"-leave-to",leaveActiveClass:e+"-leave-active"}}),Ba=Ki&&!Wi,Ua="transition",Va="animation",za="transition",Ka="transitionend",Ja="animation",qa="animationend";Ba&&(void 0===window.ontransitionend&&void 0!==window.onwebkittransitionend&&(za="WebkitTransition",Ka="webkitTransitionEnd"),void 0===window.onanimationend&&void 0!==window.onwebkitanimationend&&(Ja="WebkitAnimation",qa="webkitAnimationEnd"));var Wa=Ki?window.requestAnimationFrame?window.requestAnimationFrame.bind(window):setTimeout:function(e){return e()},Ga=/\b(transform|all)(,|$)/,Za=function(r){function o(e){return new lo(j.tagName(e).toLowerCase(),{},[],void 0,e)}function a(e,t){function n(){0==--n.listeners&&s(e)}return n.listeners=t,n}function s(e){var n=j.parentNode(e);t(n)&&j.removeChild(n,e)}function c(e,r,i,o,a){if(e.isRootInsert=!a,!u(e,r,i,o)){var s=e.data,c=e.children,l=e.tag;t(l)?(e.elm=e.ns?j.createElementNS(e.ns,l):j.createElement(l,e),y(e),v(e,c,r),t(s)&&m(e,r),p(i,e.elm,o)):n(e.isComment)?(e.elm=j.createComment(e.text),p(i,e.elm,o)):(e.elm=j.createTextNode(e.text),p(i,e.elm,o))}}function u(e,r,i,o){var a=e.data;if(t(a)){var s=t(e.componentInstance)&&a.keepAlive;if(t(a=a.hook)&&t(a=a.init)&&a(e,!1,i,o),t(e.componentInstance))return l(e,r),n(s)&&d(e,r,i,o),!0}}function l(e,n){t(e.data.pendingInsert)&&(n.push.apply(n,e.data.pendingInsert),e.data.pendingInsert=null),e.elm=e.componentInstance.$el,h(e)?(m(e,n),y(e)):(qt(e),n.push(e))}function d(e,n,r,i){for(var o,a=e;a.componentInstance;)if(a=a.componentInstance._vnode,t(o=a.data)&&t(o=o.transition)){for(o=0;o<T.activate.length;++o)T.activate[o]($a,a);n.push(a);break}p(r,e.elm,i)}function p(e,n,r){t(e)&&(t(r)?r.parentNode===e&&j.insertBefore(e,n,r):j.appendChild(e,n))}function v(e,t,n){if(Array.isArray(t))for(var r=0;r<t.length;++r)c(t[r],n,e.elm,null,!0);else i(e.text)&&j.appendChild(e.elm,j.createTextNode(e.text))}function h(e){for(;e.componentInstance;)e=e.componentInstance._vnode;return t(e.tag)}function m(e,n){for(var r=0;r<T.create.length;++r)T.create[r]($a,e);t(O=e.data.hook)&&(t(O.create)&&O.create($a,e),t(O.insert)&&n.push(e))}function y(e){var n;if(t(n=e.functionalScopeId))j.setAttribute(e.elm,n,"");else for(var r=e;r;)t(n=r.context)&&t(n=n.$options._scopeId)&&j.setAttribute(e.elm,n,""),r=r.parent;t(n=jo)&&n!==e.context&&n!==e.functionalContext&&t(n=n.$options._scopeId)&&j.setAttribute(e.elm,n,"")}function g(e,t,n,r,i,o){for(;r<=i;++r)c(n[r],o,e,t)}function _(e){var n,r,i=e.data;if(t(i))for(t(n=i.hook)&&t(n=n.destroy)&&n(e),n=0;n<T.destroy.length;++n)T.destroy[n](e);if(t(n=e.children))for(r=0;r<e.children.length;++r)_(e.children[r])}function b(e,n,r,i){for(;r<=i;++r){var o=n[r];t(o)&&(t(o.tag)?($(o),_(o)):s(o.elm))}}function $(e,n){if(t(n)||t(e.data)){var r,i=T.remove.length+1;for(t(n)?n.listeners+=i:n=a(e.elm,i),t(r=e.componentInstance)&&t(r=r._vnode)&&t(r.data)&&$(r,n),r=0;r<T.remove.length;++r)T.remove[r](e,n);t(r=e.data.hook)&&t(r=r.remove)?r(e,n):n()}else s(e.elm)}function C(n,r,i,o,a){for(var s,u,l,f=0,d=0,p=r.length-1,v=r[0],h=r[p],m=i.length-1,y=i[0],_=i[m],$=!a;f<=p&&d<=m;)e(v)?v=r[++f]:e(h)?h=r[--p]:Wt(v,y)?(x(v,y,o),v=r[++f],y=i[++d]):Wt(h,_)?(x(h,_,o),h=r[--p],_=i[--m]):Wt(v,_)?(x(v,_,o),$&&j.insertBefore(n,v.elm,j.nextSibling(h.elm)),v=r[++f],_=i[--m]):Wt(h,y)?(x(h,y,o),$&&j.insertBefore(n,h.elm,v.elm),h=r[--p],y=i[++d]):(e(s)&&(s=Zt(r,f,p)),e(u=t(y.key)?s[y.key]:w(y,r,f,p))?c(y,o,n,v.elm):Wt(l=r[u],y)?(x(l,y,o),r[u]=void 0,$&&j.insertBefore(n,l.elm,v.elm)):c(y,o,n,v.elm),y=i[++d]);f>p?g(n,e(i[m+1])?null:i[m+1].elm,i,d,m,o):d>m&&b(n,r,f,p)}function w(e,n,r,i){for(var o=r;o<i;o++){var a=n[o];if(t(a)&&Wt(e,a))return o}}function x(r,i,o,a){if(r!==i){var s=i.elm=r.elm;if(n(r.isAsyncPlaceholder))t(i.asyncFactory.resolved)?A(r.elm,i,o):i.isAsyncPlaceholder=!0;else if(n(i.isStatic)&&n(r.isStatic)&&i.key===r.key&&(n(i.isCloned)||n(i.isOnce)))i.componentInstance=r.componentInstance;else{var c,u=i.data;t(u)&&t(c=u.hook)&&t(c=c.prepatch)&&c(r,i);var l=r.children,f=i.children;if(t(u)&&h(i)){for(c=0;c<T.update.length;++c)T.update[c](r,i);t(c=u.hook)&&t(c=c.update)&&c(r,i)}e(i.text)?t(l)&&t(f)?l!==f&&C(s,l,f,o,a):t(f)?(t(r.text)&&j.setTextContent(s,""),g(s,null,f,0,f.length-1,o)):t(l)?b(s,l,0,l.length-1):t(r.text)&&j.setTextContent(s,""):r.text!==i.text&&j.setTextContent(s,i.text),t(u)&&t(c=u.hook)&&t(c=c.postpatch)&&c(r,i)}}}function k(e,r,i){if(n(i)&&t(e.parent))e.parent.data.pendingInsert=r;else for(var o=0;o<r.length;++o)r[o].data.hook.insert(r[o])}function A(e,r,i){if(n(r.isComment)&&t(r.asyncFactory))return r.elm=e,r.isAsyncPlaceholder=!0,!0;r.elm=e;var o=r.tag,a=r.data,s=r.children;if(t(a)&&(t(O=a.hook)&&t(O=O.init)&&O(r,!0),t(O=r.componentInstance)))return l(r,i),!0;if(t(o)){if(t(s))if(e.hasChildNodes())if(t(O=a)&&t(O=O.domProps)&&t(O=O.innerHTML)){if(O!==e.innerHTML)return!1}else{for(var c=!0,u=e.firstChild,f=0;f<s.length;f++){if(!u||!A(u,s[f],i)){c=!1;break}u=u.nextSibling}if(!c||u)return!1}else v(r,s,i);if(t(a))for(var d in a)if(!N(d)){m(r,i);break}}else e.data!==r.text&&(e.data=r.text);return!0}var O,S,T={},E=r.modules,j=r.nodeOps;for(O=0;O<Ca.length;++O)for(T[Ca[O]]=[],S=0;S<E.length;++S)t(E[S][Ca[O]])&&T[Ca[O]].push(E[S][Ca[O]]);var N=f("attrs,style,class,staticClass,staticStyle,key");return function(r,i,a,s,u,l){if(!e(i)){var f=!1,d=[];if(e(r))f=!0,c(i,d,u,l);else{var p=t(r.nodeType);if(!p&&Wt(r,i))x(r,i,d,s);else{if(p){if(1===r.nodeType&&r.hasAttribute(Fi)&&(r.removeAttribute(Fi),a=!0),n(a)&&A(r,i,d))return k(i,d,!0),r;r=o(r)}var v=r.elm,m=j.parentNode(v);if(c(i,d,v._leaveCb?null:m,j.nextSibling(v)),t(i.parent))for(var y=i.parent,g=h(i);y;){for(var $=0;$<T.destroy.length;++$)T.destroy[$](y);if(y.elm=i.elm,g){for(var C=0;C<T.create.length;++C)T.create[C]($a,y);var w=y.data.hook.insert;if(w.merged)for(var O=1;O<w.fns.length;O++)w.fns[O]()}else qt(y);y=y.parent}t(m)?b(m,[r],0,0):t(r.tag)&&_(r)}}return k(i,d,f),i.elm}t(r)&&_(r)}}({nodeOps:_a,modules:[Aa,Oa,ja,Na,Ra,Ki?{create:tr,activate:tr,remove:function(e,t){!0!==e.data.show?Qn(e,t):t()}}:{}].concat(ka)});Wi&&document.addEventListener("selectionchange",function(){var e=document.activeElement;e&&e.vmodel&&cr(e,"input")});var Ya={inserted:function(e,t,n,r){"select"===n.tag?(r.elm&&!r.elm._vOptions?ae(n,"postpatch",function(){Ya.componentUpdated(e,t,n)}):nr(e,t,n.context),e._vOptions=[].map.call(e.options,or)):("textarea"===n.tag||ga(e.type))&&(e._vModifiers=t.modifiers,t.modifiers.lazy||(e.addEventListener("change",sr),Zi||(e.addEventListener("compositionstart",ar),e.addEventListener("compositionend",sr)),Wi&&(e.vmodel=!0)))},componentUpdated:function(e,t,n){if("select"===n.tag){nr(e,t,n.context);var r=e._vOptions,i=e._vOptions=[].map.call(e.options,or);i.some(function(e,t){return!b(e,r[t])})&&(e.multiple?t.value.some(function(e){return ir(e,i)}):t.value!==t.oldValue&&ir(t.value,i))&&cr(e,"change")}}},Qa={model:Ya,show:{bind:function(e,t,n){var r=t.value,i=(n=ur(n)).data&&n.data.transition,o=e.__vOriginalDisplay="none"===e.style.display?"":e.style.display;r&&i?(n.data.show=!0,Yn(n,function(){e.style.display=o})):e.style.display=r?o:"none"},update:function(e,t,n){var r=t.value;r!==t.oldValue&&((n=ur(n)).data&&n.data.transition?(n.data.show=!0,r?Yn(n,function(){e.style.display=e.__vOriginalDisplay}):Qn(n,function(){e.style.display="none"})):e.style.display=r?e.__vOriginalDisplay:"none")},unbind:function(e,t,n,r,i){i||(e.style.display=e.__vOriginalDisplay)}}},Xa={name:String,appear:Boolean,css:Boolean,mode:String,type:String,enterClass:String,leaveClass:String,enterToClass:String,leaveToClass:String,enterActiveClass:String,leaveActiveClass:String,appearClass:String,appearActiveClass:String,appearToClass:String,duration:[Number,String,Object]},es={name:"transition",props:Xa,abstract:!0,render:function(e){var t=this,n=this.$options._renderChildren;if(n&&(n=n.filter(function(e){return e.tag||me(e)})).length){var r=this.mode,o=n[0];if(pr(this.$vnode))return o;var a=lr(o);if(!a)return o;if(this._leaving)return dr(e,o);var s="__transition-"+this._uid+"-";a.key=null==a.key?a.isComment?s+"comment":s+a.tag:i(a.key)?0===String(a.key).indexOf(s)?a.key:s+a.key:a.key;var c=(a.data||(a.data={})).transition=fr(this),u=this._vnode,l=lr(u);if(a.data.directives&&a.data.directives.some(function(e){return"show"===e.name})&&(a.data.show=!0),l&&l.data&&!vr(a,l)&&!me(l)){var f=l.data.transition=y({},c);if("out-in"===r)return this._leaving=!0,ae(f,"afterLeave",function(){t._leaving=!1,t.$forceUpdate()}),dr(e,o);if("in-out"===r){if(me(a))return u;var d,p=function(){d()};ae(c,"afterEnter",p),ae(c,"enterCancelled",p),ae(f,"delayLeave",function(e){d=e})}}return o}}},ts=y({tag:String,moveClass:String},Xa);delete ts.mode;var ns={Transition:es,TransitionGroup:{props:ts,render:function(e){for(var t=this.tag||this.$vnode.data.tag||"span",n=Object.create(null),r=this.prevChildren=this.children,i=this.$slots.default||[],o=this.children=[],a=fr(this),s=0;s<i.length;s++){var c=i[s];c.tag&&null!=c.key&&0!==String(c.key).indexOf("__vlist")&&(o.push(c),n[c.key]=c,(c.data||(c.data={})).transition=a)}if(r){for(var u=[],l=[],f=0;f<r.length;f++){var d=r[f];d.data.transition=a,d.data.pos=d.elm.getBoundingClientRect(),n[d.key]?u.push(d):l.push(d)}this.kept=e(t,null,u),this.removed=l}return e(t,null,o)},beforeUpdate:function(){this.__patch__(this._vnode,this.kept,!1,!0),this._vnode=this.kept},updated:function(){var e=this.prevChildren,t=this.moveClass||(this.name||"v")+"-move";e.length&&this.hasMove(e[0].elm,t)&&(e.forEach(hr),e.forEach(mr),e.forEach(yr),this._reflow=document.body.offsetHeight,e.forEach(function(e){if(e.data.moved){var n=e.elm,r=n.style;Kn(n,t),r.transform=r.WebkitTransform=r.transitionDuration="",n.addEventListener(Ka,n._moveCb=function e(r){r&&!/transform$/.test(r.propertyName)||(n.removeEventListener(Ka,e),n._moveCb=null,Jn(n,t))})}}))},methods:{hasMove:function(e,t){if(!Ba)return!1;if(this._hasMove)return this._hasMove;var n=e.cloneNode();e._transitionClasses&&e._transitionClasses.forEach(function(e){Un(n,e)}),Bn(n,t),n.style.display="none",this.$el.appendChild(n);var r=Wn(n);return this.$el.removeChild(n),this._hasMove=r.hasTransform}}}};Ot.config.mustUseProp=aa,Ot.config.isReservedTag=ma,Ot.config.isReservedAttr=ia,Ot.config.getTagNamespace=Kt,Ot.config.isUnknownElement=function(e){if(!Ki)return!0;if(ma(e))return!1;if(e=e.toLowerCase(),null!=ya[e])return ya[e];var t=document.createElement(e);return e.indexOf("-")>-1?ya[e]=t.constructor===window.HTMLUnknownElement||t.constructor===window.HTMLElement:ya[e]=/HTMLUnknownElement/.test(t.toString())},y(Ot.options.directives,Qa),y(Ot.options.components,ns),Ot.prototype.__patch__=Ki?Za:_,Ot.prototype.$mount=function(e,t){return e=e&&Ki?Jt(e):void 0,Ae(this,e,t)},Ot.nextTick(function(){Bi.devtools&&io&&io.emit("init",Ot)},0);var rs,is=/\{\{((?:.|\n)+?)\}\}/g,os=/[-.*+?^${}()|[\]\/\\]/g,as=v(function(e){var t=e[0].replace(os,"\\$&"),n=e[1].replace(os,"\\$&");return new RegExp(t+"((?:.|\\n)+?)"+n,"g")}),ss={staticKeys:["staticClass"],transformNode:function(e,t){t.warn;var n=hn(e,"class");n&&(e.staticClass=JSON.stringify(n));var r=vn(e,"class",!1);r&&(e.classBinding=r)},genData:function(e){var t="";return e.staticClass&&(t+="staticClass:"+e.staticClass+","),e.classBinding&&(t+="class:"+e.classBinding+","),t}},cs={staticKeys:["staticStyle"],transformNode:function(e,t){var n=hn(e,"style");n&&(e.staticStyle=JSON.stringify(La(n)));var r=vn(e,"style",!1);r&&(e.styleBinding=r)},genData:function(e){var t="";return e.staticStyle&&(t+="staticStyle:"+e.staticStyle+","),e.styleBinding&&(t+="style:("+e.styleBinding+"),"),t}},us={decode:function(e){return rs=rs||document.createElement("div"),rs.innerHTML=e,rs.textContent}},ls=f("area,base,br,col,embed,frame,hr,img,input,isindex,keygen,link,meta,param,source,track,wbr"),fs=f("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr,source"),ds=f("address,article,aside,base,blockquote,body,caption,col,colgroup,dd,details,dialog,div,dl,dt,fieldset,figcaption,figure,footer,form,h1,h2,h3,h4,h5,h6,head,header,hgroup,hr,html,legend,li,menuitem,meta,optgroup,option,param,rp,rt,source,style,summary,tbody,td,tfoot,th,thead,title,tr,track"),ps=/^\s*([^\s"'<>\/=]+)(?:\s*(=)\s*(?:"([^"]*)"+|'([^']*)'+|([^\s"'=<>`]+)))?/,vs="[a-zA-Z_][\\w\\-\\.]*",hs="((?:"+vs+"\\:)?"+vs+")",ms=new RegExp("^<"+hs),ys=/^\s*(\/?)>/,gs=new RegExp("^<\\/"+hs+"[^>]*>"),_s=/^<!DOCTYPE [^>]+>/i,bs=/^<!--/,$s=/^<!\[/,Cs=!1;"x".replace(/x(.)?/g,function(e,t){Cs=""===t});var ws,xs,ks,As,Os,Ss,Ts,Es,js,Ns,Ls,Is=f("script,style,textarea",!0),Ms={},Ds={"&lt;":"<","&gt;":">","&quot;":'"',"&amp;":"&","&#10;":"\n","&#9;":"\t"},Ps=/&(?:lt|gt|quot|amp);/g,Fs=/&(?:lt|gt|quot|amp|#10|#9);/g,Rs=f("pre,textarea",!0),Hs=function(e,t){return e&&Rs(e)&&"\n"===t[0]},Bs=/^@|^v-on:/,Us=/^v-|^@|^:/,Vs=/(.*?)\s+(?:in|of)\s+(.*)/,zs=/\((\{[^}]*\}|[^,]*),([^,]*)(?:,([^,]*))?\)/,Ks=/:(.*)$/,Js=/^:|^v-bind:/,qs=/\.[^.]+/g,Ws=v(us.decode),Gs=/^xmlns:NS\d+/,Zs=/^NS\d+:/,Ys=[ss,cs,{preTransformNode:function(e,t){if("input"===e.tag){var n=e.attrsMap;if(n["v-model"]&&(n["v-bind:type"]||n[":type"])){var r=vn(e,"type"),i=hn(e,"v-if",!0),o=i?"&&("+i+")":"",a=null!=hn(e,"v-else",!0),s=hn(e,"v-else-if",!0),c=Vr(e);Sr(c),zr(c,"type","checkbox"),kr(c,t),c.processed=!0,c.if="("+r+")==='checkbox'"+o,Nr(c,{exp:c.if,block:c});var u=Vr(e);hn(u,"v-for",!0),zr(u,"type","radio"),kr(u,t),Nr(c,{exp:"("+r+")==='radio'"+o,block:u});var l=Vr(e);return hn(l,"v-for",!0),zr(l,":type",r),kr(l,t),Nr(c,{exp:i,block:l}),a?c.else=!0:s&&(c.elseif=s),c}}}}],Qs={expectHTML:!0,modules:Ys,directives:{model:function(e,t,n){var r=t.value,i=t.modifiers,o=e.tag,a=e.attrsMap.type;if(e.component)return mn(e,r,i),!1;if("select"===o)An(e,r,i);else if("input"===o&&"checkbox"===a)xn(e,r,i);else if("input"===o&&"radio"===a)kn(e,r,i);else if("input"===o||"textarea"===o)On(e,r,i);else if(!Bi.isReservedTag(o))return mn(e,r,i),!1;return!0},text:function(e,t){t.value&&ln(e,"textContent","_s("+t.value+")")},html:function(e,t){t.value&&ln(e,"innerHTML","_s("+t.value+")")}},isPreTag:function(e){return"pre"===e},isUnaryTag:ls,mustUseProp:aa,canBeLeftOpenTag:fs,isReservedTag:ma,getTagNamespace:Kt,staticKeys:function(e){return e.reduce(function(e,t){return e.concat(t.staticKeys||[])},[]).join(",")}(Ys)},Xs=v(function(e){return f("type,tag,attrsList,attrsMap,plain,parent,children,attrs"+(e?","+e:""))}),ec=/^\s*([\w$_]+|\([^)]*?\))\s*=>|^function\s*\(/,tc=/^\s*[A-Za-z_$][\w$]*(?:\.[A-Za-z_$][\w$]*|\['.*?']|\[".*?"]|\[\d+]|\[[A-Za-z_$][\w$]*])*\s*$/,nc={esc:27,tab:9,enter:13,space:32,up:38,left:37,right:39,down:40,delete:[8,46]},rc=function(e){return"if("+e+")return null;"},ic={stop:"$event.stopPropagation();",prevent:"$event.preventDefault();",self:rc("$event.target !== $event.currentTarget"),ctrl:rc("!$event.ctrlKey"),shift:rc("!$event.shiftKey"),alt:rc("!$event.altKey"),meta:rc("!$event.metaKey"),left:rc("'button' in $event && $event.button !== 0"),middle:rc("'button' in $event && $event.button !== 1"),right:rc("'button' in $event && $event.button !== 2")},oc={on:function(e,t){e.wrapListeners=function(e){return"_g("+e+","+t.value+")"}},bind:function(e,t){e.wrapData=function(n){return"_b("+n+",'"+e.tag+"',"+t.value+","+(t.modifiers&&t.modifiers.prop?"true":"false")+(t.modifiers&&t.modifiers.sync?",true":"")+")"}},cloak:_},ac=function(e){this.options=e,this.warn=e.warn||cn,this.transforms=un(e.modules,"transformCode"),this.dataGenFns=un(e.modules,"genData"),this.directives=y(y({},oc),e.directives);var t=e.isReservedTag||Di;this.maybeComponent=function(e){return!t(e.tag)},this.onceId=0,this.staticRenderFns=[]},sc=(new RegExp("\\b"+"do,if,for,let,new,try,var,case,else,with,await,break,catch,class,const,super,throw,while,yield,delete,export,import,return,switch,default,extends,finally,continue,debugger,function,arguments".split(",").join("\\b|\\b")+"\\b"),new RegExp("\\b"+"delete,typeof,void".split(",").join("\\s*\\([^\\)]*\\)|\\b")+"\\s*\\([^\\)]*\\)"),function(e){return function(t){function n(n,r){var i=Object.create(t),o=[],a=[];if(i.warn=function(e,t){(t?a:o).push(e)},r){r.modules&&(i.modules=(t.modules||[]).concat(r.modules)),r.directives&&(i.directives=y(Object.create(t.directives),r.directives));for(var s in r)"modules"!==s&&"directives"!==s&&(i[s]=r[s])}var c=e(n,i);return c.errors=o,c.tips=a,c}return{compile:n,compileToFunctions:xi(n)}}}(function(e,t){var n=Cr(e.trim(),t);Kr(n,t);var r=ei(n,t);return{ast:n,render:r.render,staticRenderFns:r.staticRenderFns}})(Qs).compileToFunctions),cc=!!Ki&&ki(!1),uc=!!Ki&&ki(!0),lc=v(function(e){var t=Jt(e);return t&&t.innerHTML}),fc=Ot.prototype.$mount;return Ot.prototype.$mount=function(e,t){if((e=e&&Jt(e))===document.body||e===document.documentElement)return this;var n=this.$options;if(!n.render){var r=n.template;if(r)if("string"==typeof r)"#"===r.charAt(0)&&(r=lc(r));else{if(!r.nodeType)return this;r=r.innerHTML}else e&&(r=Ai(e));if(r){var i=sc(r,{shouldDecodeNewlines:cc,shouldDecodeNewlinesForHref:uc,delimiters:n.delimiters,comments:n.comments},this),o=i.render,a=i.staticRenderFns;n.render=o,n.staticRenderFns=a}}return fc.call(this,e,t)},Ot.compile=sc,Ot});
}).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
},{}],4:[function(require,module,exports){
'use strict';

// Vue Dev
// window.Vue = require('vue/dist/vue.js');
//Vue Prod
window.Vue = require('vue/dist/vue.min');

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

},{"./vue-components":5,"vee-validate":2,"vee-validate/dist/locale/es":1,"vue/dist/vue.min":3}],5:[function(require,module,exports){
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

/**
 * Compras Components
 */
require('./vue-components/Compras/requisicion/create');
require('./vue-components/Compras/requisicion/edit');
require('./vue-components/Compras/material/index');

/**
 * Finanzas Components
 */
require('./vue-components/Finanzas/comprobante_fondo_fijo/create');
require('./vue-components/Finanzas/comprobante_fondo_fijo/edit');
/**
 * Reportes Components
 */
require('./vue-components/Reportes/subcontratos-estimacion');

/**
 * Tesoreria Components
 */
require('./vue-components/Tesoreria/traspaso_cuentas/index');
require('./vue-components/Tesoreria/movimientos_bancarios/index');

/**
 * Control de costos Components
 */
require('./vue-components/Control_Costos/solicitar_reclasificacion/index');
require('./vue-components/Control_Costos/solicitar_reclasificacion/items');
require('./vue-components/Control_Costos/reclasificacion_costos/index');

/**
 * Control de Presupuesto Components
 */
require('./vue-components/Control_Presupuesto/presupuesto/index');

/**
 * Configuración Components
 */
require('./vue-components/Configuracion/Cierre/index');

/**
 * Control de cambios al presupuesto Components
 */
require('./vue-components/Control_Presupuesto/cambios_presupuesto/create');

},{"./vue-components/Compras/material/index":6,"./vue-components/Compras/requisicion/create":7,"./vue-components/Compras/requisicion/edit":8,"./vue-components/Configuracion/Cierre/index":9,"./vue-components/Contabilidad/cuenta_almacen/index":10,"./vue-components/Contabilidad/cuenta_bancos/cuenta-bancaria-edit":11,"./vue-components/Contabilidad/cuenta_concepto/index":12,"./vue-components/Contabilidad/cuenta_contable/index":13,"./vue-components/Contabilidad/cuenta_costo/index":14,"./vue-components/Contabilidad/cuenta_empresa/cuenta-empresa-edit":15,"./vue-components/Contabilidad/cuenta_fondo/index":16,"./vue-components/Contabilidad/cuenta_material/index":17,"./vue-components/Contabilidad/datos_contables/edit":18,"./vue-components/Contabilidad/emails":19,"./vue-components/Contabilidad/modulos/revaluacion/create":20,"./vue-components/Contabilidad/poliza_generada/edit":21,"./vue-components/Contabilidad/poliza_tipo/poliza-tipo-create":22,"./vue-components/Contabilidad/tipo_cuenta_contable/tipo-cuenta-contable-create":23,"./vue-components/Contabilidad/tipo_cuenta_contable/tipo-cuenta-contable-update":24,"./vue-components/Control_Costos/reclasificacion_costos/index":25,"./vue-components/Control_Costos/solicitar_reclasificacion/index":26,"./vue-components/Control_Costos/solicitar_reclasificacion/items":27,"./vue-components/Control_Presupuesto/cambios_presupuesto/create":28,"./vue-components/Control_Presupuesto/presupuesto/index":29,"./vue-components/Finanzas/comprobante_fondo_fijo/create":30,"./vue-components/Finanzas/comprobante_fondo_fijo/edit":31,"./vue-components/Reportes/subcontratos-estimacion":32,"./vue-components/Tesoreria/movimientos_bancarios/index":33,"./vue-components/Tesoreria/traspaso_cuentas/index":34,"./vue-components/errors":35,"./vue-components/global-errors":36,"./vue-components/kardex_material/kardex-material-index":37,"./vue-components/select2":38}],6:[function(require,module,exports){
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
            valor: '0',
            guardando: false

        };
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
        }
    }
});

},{}],7:[function(require,module,exports){
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

},{}],8:[function(require,module,exports){
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

},{}],9:[function(require,module,exports){
'use strict';

Vue.component('cierre-index', {
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

        $('#cierres_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "searching": false,
            "ajax": {
                "url": App.host + '/configuracion/cierre/paginate',
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
            "columns": [{ data: 'anio' }, { data: 'mes' }, { data: 'registro' }, { data: 'created_at' }, {
                data: {},
                render: function render(data) {
                    return '<span class="label" style="background-color: ' + (data.abierto == true ? 'rgb(243, 156, 18)' : 'rgb(0, 166, 90)') + '">' + (data.abierto == true ? 'Abierto' : 'Cerrado') + '</span>';
                }
            }, {
                data: {},
                render: function render(data) {
                    return '<div class="btn-group">' + '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="true">' + '<span class="caret"></span>' + '</button>' + '<ul class="dropdown-menu">' + '<li>' + '<a href="#" id="' + data.id + '" class="btn_' + (data.abierto == true ? 'close' : 'open') + '">' + (data.abierto == true ? 'Cerrar ' : 'Abrir ') + '<?php echo (Auth::id()) ?></a>' + '</li>' + '</ul>' + '</div>';
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

    methods: {
        generar_cierre: function generar_cierre() {
            $('#create_cierre_modal').modal('show');
        },

        save_cierre: function save_cierre() {
            var self = this;

            $.ajax({
                url: App.host + '/configuracion/cierre',
                type: 'POST',
                data: self.cierre,
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success() {
                    $('#cierres_table').DataTable().ajax.reload();

                    $('#create_cierre_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cierre de Periodo guardado correctamente'
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
                text: 'Escriba el motivo de la apertura del Periodo : ',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Abrir',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: function preConfirm(motivo) {
                    return new Promise(function (resolve) {
                        $.ajax({
                            'url': App.host + '/configuracion/cierre/' + id_cierre + '/open',
                            'type': 'POST',
                            'data': {
                                '_method': 'PATCH',
                                'motivo': motivo
                            },
                            beforeSend: function beforeSend() {
                                self.guardando = true;
                            },
                            success: function success(response) {
                                $('#cierres_table').DataTable().ajax.reload(null, false);
                                swal({
                                    type: 'success',
                                    title: 'Periodo abierto correctamente',
                                    html: '<p>Año : <b>' + response.anio + '</b> ' + 'Mes : <b>' + parseInt(response.mes).getMes() + '</b></p>'
                                });
                            },
                            complete: function complete() {
                                self.guardando = false;
                            }
                        });
                    });
                },
                allowOutsideClick: function allowOutsideClick() {
                    return !swal.isLoading();
                }
            }).then(function (result) {}).catch(swal.noop);
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

                $.ajax({
                    url: App.host + '/configuracion/cierre/' + id_cierre + '/close',
                    type: 'POST',
                    data: {
                        _method: 'PATCH'
                    },
                    beforeSend: function beforeSend() {
                        self.guardando = true;
                    },
                    success: function success(response) {
                        $('#cierres_table').DataTable().ajax.reload(null, false);
                        swal({
                            type: 'success',
                            title: 'Periodo Cerrado Correctamente',
                            html: '<p>Año : <b>' + response.anio + '</b> ' + 'Mes : <b>' + parseInt(response.mes).getMes() + '</b></p>'
                        });
                    },
                    complete: function complete() {
                        self.guardando = false;
                    }
                });
            }).catch(swal.noop);
        }
    }
});

},{}],10:[function(require,module,exports){
'use strict';

Vue.component('cuenta-almacen-index', {
    props: ['datos_contables', 'url_cuenta_almacen_store', 'almacenes'],
    data: function data() {
        return {
            'data': {
                'almacenes': this.almacenes,
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
    methods: {
        editar: function editar(almacen) {
            this.data.almacen_edit = almacen;
            Vue.set(this.form.cuenta_almacen, 'id_almacen', almacen.id_almacen);
            if (almacen.cuenta_almacen != null) {
                Vue.set(this.form.cuenta_almacen, 'cuenta', almacen.cuenta_almacen.cuenta);
                Vue.set(this.form.cuenta_almacen, 'id', almacen.cuenta_almacen.id);
            } else {
                Vue.set(this.form.cuenta_almacen, 'cuenta', '');
                Vue.set(this.form.cuenta_almacen, 'id', '');
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
            }).then(function () {
                self.update_cuenta();
            }).catch(swal.noop);
        },

        update_cuenta: function update_cuenta() {
            var self = this;
            var url = this.url_cuenta_almacen_store + '/' + this.form.cuenta_almacen.id;

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
                    self.data.almacen_edit.cuenta_almacen = data.data.cuenta_almacen;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
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
            }).then(function () {
                self.save_cuenta();
            }).catch(swal.noop);
        },

        save_cuenta: function save_cuenta() {
            var self = this;
            var url = this.url_cuenta_almacen_store;

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    cuenta: self.form.cuenta_almacen.cuenta,
                    id_almacen: self.form.cuenta_almacen.id_almacen
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.data.almacen_edit.cuenta_almacen = data.data.cuenta_almacen;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
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

},{}],11:[function(require,module,exports){
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
            }).then(function () {

                self.elimina_cuenta();
            }).catch(swal.noop);
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
            }).then(function () {

                self.update_cuenta_bancaria();
            }).catch(swal.noop);
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
            }).then(function () {
                self.save_cuenta_bancaria();
            }).catch(swal.noop);
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
                    $.each(self.asociadas, function (index, tipo_cuenta) {
                        if (toRemove == tipo_cuenta.id_cuenta_contable_bancaria) {
                            self.asociadas.splice(index, 1);
                        }
                    });

                    $('#add_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: fué eliminada correctamente'
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
                    $.each(self.asociadas, function (index, tipo_cuenta) {
                        if (toRemove == tipo_cuenta.id_cuenta_contable_bancaria) {
                            self.asociadas.splice(index, 1, data.data);
                        }
                    });

                    $('#edit_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta:' + data.data.cuenta + '</b> fué actualizada correctamente'
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
                    self.asociadas.push(data.data);
                    self.close_modal('add_movimiento_modal');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: <b>' + data.data.cuenta + '</b> fue registrada correctamente'
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

},{}],12:[function(require,module,exports){
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
            }).then(function () {
                self.update_cuenta();
            }).catch(swal.noop);
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
                    self.form.concepto_edit.cuenta_concepto = data.data.cuenta_concepto;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
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
            }).then(function () {
                self.save_cuenta();
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
                    id_concepto: self.form.id_concepto
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.form.concepto_edit.cuenta_concepto = data.data.cuenta_concepto;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
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

},{}],13:[function(require,module,exports){
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
            }).then(function () {
                self.save_cuenta_contable();
            }).catch(swal.noop);
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
            }).then(function () {
                self.update_cuenta_contable();
            }).catch(swal.noop);
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
                    Vue.set(self.data, 'tipos_cuentas_contables', data.data.tipos_cuentas_contables);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable <b>' + data.data.cuenta_contable.tipo_cuenta_contable.descripcion + '</b> configurada correctamente'
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
                    Vue.set(self.data, 'tipos_cuentas_contables', data.data.tipos_cuentas_contables);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable <b>' + data.data.cuenta_contable.tipo_cuenta_contable.descripcion + '</b> actualizada correctamente'
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

},{}],14:[function(require,module,exports){
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
            }).then(function () {
                self.update_cuenta();
            }).catch(swal.noop);
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
                    self.form.costo_edit.cuenta_costo = data.data.cuenta_costo;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
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
            }).then(function () {
                self.save_cuenta();
            }).catch(swal.noop);
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
                    self.form.costo_edit.cuenta_costo = data.data.cuenta_costo;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
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
            }).then(function () {
                self.delete_cuenta(id_cuenta_costo);
            }).catch(swal.noop);
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

                    swal({
                        type: 'success',
                        title: 'Correcto',
                        text: 'Cuenta Contable eliminada correctamente'
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

},{}],15:[function(require,module,exports){
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
            }).then(function () {

                self.elimina_cuenta();
            }).catch(swal.noop);
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
            }).then(function () {

                self.update_cuenta_empresa();
            }).catch(swal.noop);
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
            }).then(function () {
                self.save_cuenta_empresa();
            }).catch(swal.noop);
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
                    Vue.set(self.data, 'empresa', data.data.empresa);
                    $('#add_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: <b>' + self.form.cuenta_empresa.tipo_cuenta_empresa.descripcion + '</b> fue eliminada correctamente'
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
                    Vue.set(self.data, 'empresa', data.data.empresa);
                    $('#edit_movimiento_modal').modal('hide');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta:' + self.form.cuenta_empresa_create.tipo_cuenta_empresa.descripcion + '</b> fue actualizada correctamente'
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
                    self.data.empresa.cuentas_empresa.push(data.data.cuenta_empresa);
                    self.close_modal('add_movimiento_modal');
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'La cuenta: <b>' + data.data.cuenta_empresa.tipo_cuenta_empresa.descripcion + '</b> fue registrada correctamente'
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

},{}],16:[function(require,module,exports){
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
            }).then(function () {
                self.update_cuenta();
            }).catch(swal.noop);
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
                    self.data.fondo_edit.cuenta_fondo = data.data.cuenta_fondo;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
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
            }).then(function () {
                self.save_cuenta();
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
                    self.data.fondo_edit.cuenta_fondo = data.data.cuenta_fondo;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
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

},{}],17:[function(require,module,exports){
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
            }).then(function () {
                self.update_cuenta();
            }).catch(swal.noop);
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
                    self.form.material_edit.cuenta_material = data.data.cuenta_material;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable actualizada correctamente'
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
            }).then(function () {
                self.save_cuenta();
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
                    self.form.material_edit.cuenta_material = data.data.cuenta_material;
                    self.close_edit_cuenta();
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Cuenta Contable registrada correctamente'
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

},{}],18:[function(require,module,exports){
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
                substring = "si";

            var id = elem.attr('id');
            var reference = name === 'manejo' ? 'manejo_almacenes' : 'costo_en_tipo_gasto';
            var contraparte = "#" + (id.indexOf(substring) !== -1 ? name + "_no" : name + "_si");
            var parent_elem = elem.parent();
            var parent_contraparte = $(contraparte).parent();

            parent_elem.addClass('iradio_line-green').removeClass('iradio_line-grey');
            parent_contraparte.addClass('iradio_line-grey').removeClass('iradio_line-green');
            elem.iCheck('check');
            $(contraparte).iCheck('uncheck');
            Vue.set(self.data.datos_contables, reference, value);
        });

        // Cambia el estilo a los elementos previamente seleccionados
        $('.checkboxes').each(function (index) {
            var elem = $(this);
            var parent = elem.parent();

            if (elem.is(':checked')) {
                parent.addClass('iradio_line-green').removeClass('iradio_line-grey');console.log(parent);
            }
        });

        $("label.control-label").css({
            'font-size': '1.5em'
        });
        $("div.box-body > .alert-danger").css({
            'font-size': '1.3em'
        });
        $("div.iradio_line-grey").css({
            'margin': '4px'
        });
    },
    created: function created() {
        // Convierte "0" y "1" en false y true respectivamente
        Vue.set(this.data.datos_contables, 'manejo_almacenes', this.toBoolean(this.data.datos_contables.manejo_almacenes));
        Vue.set(this.data.datos_contables, 'costo_en_tipo_gasto', this.toBoolean(this.data.datos_contables.costo_en_tipo_gasto));
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
                    checkboxClass: 'icheckbox_line-grey',
                    radioClass: 'iradio_line-grey',
                    insert: '<div class="icheck_line-icon"></div>' + label_text
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
            }).then(function () {
                self.save_datos_obra();
            }).catch(swal.noop);
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
                    manejo_almacenes: self.data.datos_contables.manejo_almacenes,
                    _method: 'PATCH'
                },
                beforeSend: function beforeSend() {
                    self.guardando = true;
                },
                success: function success(data, textStatus, xhr) {
                    self.data.datos_contables = data.data.datos_contables;
                    var costo_en_tipo_gasto = Vue.set(self.data.datos_contables, 'costo_en_tipo_gasto', data.data.datos_contables.costo_en_tipo_gasto == 'true' ? true : false);
                    var manejo_almacenes = Vue.set(self.data.datos_contables, 'manejo_almacenes', data.data.datos_contables.manejo_almacenes == 'true' ? true : false);
                    swal({
                        type: 'success',
                        title: 'Correcto',
                        html: 'Datos Contables de la Obra actualizados correctamente'
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

},{}],19:[function(require,module,exports){
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
            console.log(data);
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

},{}],20:[function(require,module,exports){
'use strict';

Vue.component('revaluacion-create', {
    props: ['facturas', 'tipo_cambio', 'url_revaluacion'],
    data: function data() {
        return {
            data: {
                facturas: this.facturas
            },
            guardando: false
        };
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
            }).then(function () {
                self.save_facturas();
            }).catch(swal.noop);
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
                    });
                    window.location = xhr.getResponseHeader('Location');
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

},{}],21:[function(require,module,exports){
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
            }).then(function () {
                self.add_movimiento();
            }).catch(swal.noop);
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
            }).then(function () {
                self.remove_movimiento(index);
            }).catch(swal.noop);
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
            }).then(function () {
                self.save();
            }).catch(swal.noop);
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
            }).then(function () {
                self.save_cuenta();
            }).catch(swal.noop);
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
                    }).catch(swal.noop);
                    window.location = xhr.getResponseHeader('Location');
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
                        }).then(function () {

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
                        }).catch(swal.noop);
                    } else {

                        swal({
                            title: '¡Correcto!',
                            html: 'Las cuentas se configurarón exitosamente',
                            type: 'success',
                            confirmButtonText: "Ok",
                            closeOnConfirm: false
                        }).then(function () {}).catch(swal.noop);
                        $('#add_cuenta_modal').modal('hide');
                        window.location.reload(true);
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

},{}],22:[function(require,module,exports){
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

                        }).then(function () {
                            self.confirm_save();
                        }).catch(swal.noop);
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
            }).then(function () {
                self.save();
            }).catch(swal.noop);
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
                    });
                    window.location = xhr.getResponseHeader('Location');
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

},{}],23:[function(require,module,exports){
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
            }).then(function () {
                self.save();
            }).catch(swal.noop);
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
                    }).catch(swal.noop);
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        }
    }

});

},{}],24:[function(require,module,exports){
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
            }).then(function () {
                self.save();
            }).catch(swal.noop);
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
                    }).catch(swal.noop);
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        }
    }

});

},{}],25:[function(require,module,exports){
'use strict';

Vue.component('reclasificacion_costos-index', {
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

            item.estatus_desc = item.estatus_string.descripcion;
            self.partidas = partidas;
            self.item = item;

            if (editando) {
                self.editando = item;
            }

            $('#solicitud_detalles_modal').modal('show');
        });

        self.dataTable = $('#solicitudes_table').DataTable({
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
                    if (row.estatus_string.id == 1) {
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
            }).then(function () {
                if (tipo == "aprobar") {
                    self.aprobar();
                } else if (tipo == "rechazar") {
                    self.rechazar();
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
                complete: function complete() {
                    self.dataTable.ajax.reload();
                }
            });

            self.close_modal_detalles();
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

                    swal({
                        type: 'success',
                        title: '',
                        html: 'La solicitud fué rechazada'
                    });
                },
                complete: function complete() {}
            });

            self.close_modal_detalles();
            self.dataTable.ajax.reload();
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
                url = App.host + '/control_costos/solicitudes_reclasificacion/generarpdf?item=' + id;

            self.show_pdf = url;
        },
        html_decode: function html_decode(input) {
            var e = document.createElement('div');
            e.innerHTML = input;

            return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
        }
    }
});

},{}],26:[function(require,module,exports){
'use strict';

Vue.component('solicitar_reclasificacion-index', {
    props: ['url_solicitar_reclasificacion_index', 'max_niveles', 'filtros', 'operadores', 'tipos_transacciones'],
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
            }).then(function () {
                if (tipo == "resultado") {
                    self.eliminar_resultado(index);
                } else if (tipo == "filtro") {
                    self.eliminar_filtro(index);
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
            }).then(function () {
                self.solicitar(item);
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
            }).then(function () {
                window.location.href = self.url_solicitar_reclasificacion_index + '/items/' + id_concepto + '/' + id_transaccion;
            }).catch(swal.noop);
        }
    },
    directives: {}
});

},{}],27:[function(require,module,exports){
'use strict';

Vue.component('solicitar_reclasificacion-items', {
    props: ['url_solicitar_reclasificacion_index', 'id_transaccion', 'id_concepto_antiguo', 'items', 'max_niveles', 'filtros', 'operadores'],
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
                'fecha': moment().format('YYYY-MM-DD')
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
            }).then(function () {
                if (tipo == "resultado") {
                    self.eliminar_resultado(index);
                } else if (tipo == "filtro") {
                    self.eliminar_filtro(index);
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
            }).then(function () {
                self.solicitar();
            }).catch(swal.noop);
        },
        solicitar: function solicitar() {
            var self = this;

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

                    swal({
                        type: 'success',
                        title: '',
                        html: 'Solicitud elaborada con éxito',
                        onClose: function onClose() {
                            window.location.href = App.host + '/control_costos/solicitudes_reclasificacion';
                        }
                    });
                },
                complete: function complete() {}
            });
        }
    }
});

},{}],28:[function(require,module,exports){
'use strict';

Vue.component('control_cambio_presupuesto-create', {
    props: ['max_niveles', 'operadores'],
    data: function data() {
        return {
            conceptos: [],
            filtros: [],
            form: {
                filtro: {
                    nivel: '',
                    operador: '',
                    texto: ''
                }
            },
            cargando: false
        };
    },
    computed: {
        niveles: function niveles() {
            var niveles = [],
                paso = 1;
            for (paso; paso <= this.max_niveles; paso++) {
                niveles.push({ numero: paso, nombre: "Nivel " + paso });
            }
            return niveles;
        }
    },
    mounted: function mounted() {
        var self = this;
        $('#conceptos_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "ajax": {
                "url": App.host + '/conceptos/getPaths',
                "type": "POST",
                "beforeSend": function beforeSend() {
                    self.cargando = true;
                },
                "data": function data(d) {
                    d.filtros = self.filtros;
                },
                "complete": function complete() {
                    self.cargando = false;
                },
                "dataSrc": function dataSrc(json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].monto_presupuestado = '$' + parseInt(json.data[i].monto_presupuestado).formatMoney(2, ',', '.');
                        json.data[i].monto = '$' + parseInt(json.data[i].monto).formatMoney(2, ',', '.');
                        json.data[i].precio_unitario = '$' + parseInt(json.data[i].precio_unitario).formatMoney(2, ',', '.');
                    }
                    return json.data;
                }
            },
            "columns": [{ data: 'filtro1' }, { data: 'filtro2' }, { data: 'filtro3' }, { data: 'filtro4' }, { data: 'filtro5' }, { data: 'filtro6' }, { data: 'filtro7' }, { data: 'filtro8' }, { data: 'filtro9' }, { data: 'filtro10' }, { data: 'filtro11' }, { data: 'unidad' }, { data: 'cantidad_presupuestada', className: 'text-right' }, { data: 'precio_unitario', className: 'text-right' }, { data: 'monto', className: 'text-right' }, { data: 'monto_presupuestado', className: 'text-right' }],
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
    methods: {
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

            if (!this.filtros.length) {
                var table = $('#conceptos_table').DataTable();
                table.ajax.reload();
            }
        },

        get_conceptos: function get_conceptos() {
            var table = $('#conceptos_table').DataTable();
            table.ajax.reload();
        }
    }
});

},{}],29:[function(require,module,exports){
'use strict';

Vue.component('control_presupuesto-index', {
    props: ['max_niveles', 'operadores'],
    data: function data() {
        return {
            conceptos: [],
            filtros: [],
            form: {
                filtro: {
                    nivel: '',
                    operador: '',
                    texto: ''
                }
            },
            cargando: false
        };
    },
    computed: {
        niveles: function niveles() {
            var niveles = [],
                paso = 1;
            for (paso; paso <= this.max_niveles; paso++) {
                niveles.push({ numero: paso, nombre: "Nivel " + paso });
            }
            return niveles;
        }
    },
    mounted: function mounted() {
        var self = this;
        $('#conceptos_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "ajax": {
                "url": App.host + '/conceptos/getPaths',
                "type": "POST",
                "beforeSend": function beforeSend() {
                    self.cargando = true;
                },
                "data": function data(d) {
                    d.filtros = self.filtros;
                },
                "complete": function complete() {
                    self.cargando = false;
                },
                "dataSrc": function dataSrc(json) {
                    for (var i = 0; i < json.data.length; i++) {
                        json.data[i].monto_presupuestado = '$' + parseInt(json.data[i].monto_presupuestado).formatMoney(2, ',', '.');
                        json.data[i].monto = '$' + parseInt(json.data[i].monto).formatMoney(2, ',', '.');
                        json.data[i].precio_unitario = '$' + parseInt(json.data[i].precio_unitario).formatMoney(2, ',', '.');
                    }
                    return json.data;
                }
            },
            "columns": [{ data: 'filtro1' }, { data: 'filtro2' }, { data: 'filtro3' }, { data: 'filtro4' }, { data: 'filtro5' }, { data: 'filtro6' }, { data: 'filtro7' }, { data: 'filtro8' }, { data: 'filtro9' }, { data: 'filtro10' }, { data: 'filtro11' }, { data: 'unidad' }, { data: 'cantidad_presupuestada', className: 'text-right' }, { data: 'precio_unitario', className: 'text-right' }, { data: 'monto', className: 'text-right' }, { data: 'monto_presupuestado', className: 'text-right' }],
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
    methods: {
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

            if (!this.filtros.length) {
                var table = $('#conceptos_table').DataTable();
                table.ajax.reload();
            }
        },

        get_conceptos: function get_conceptos() {
            var table = $('#conceptos_table').DataTable();
            table.ajax.reload();
        }
    }
});

},{}],30:[function(require,module,exports){
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

                var jstreeM = $('#jstreeM').jstree(true);
                var node = jstreeM.get_selected(true)[0];
                $('#jstreeM').jstree(true).deselect_node(node);

                if (data.node.original.type == 'concepto' || data.node.original.type == 'inactivo') {
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
                title: "Guardar Comprobante de Fondo Fijo",
                text: "¿Estás seguro de que la información es correcta?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Continuar",
                cancelButtonText: "No, Cancelar"
            }).then(function () {
                self.save_comprobante_fondo_fijo();
            }).catch(swal.noop);
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
            }).then(function () {
                self.remove_item(index);
            }).catch(swal.noop);
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
                    }).catch(swal.noop);
                    window.location = App.host + "/finanzas/comprobante_fondo_fijo/" + data.data.comprobante.id_transaccion;
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        }

    }
});

},{}],31:[function(require,module,exports){
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
            }).then(function () {
                self.save_comprobante_fondo_fijo();
            }).catch(swal.noop);
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
                    }).catch(swal.noop);
                    window.location = self.url_comprobante_fondo_fijo_show;
                },
                complete: function complete() {
                    self.guardando = false;
                }
            });
        }

    }
});

},{}],32:[function(require,module,exports){
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
            var url = App.host + '/reportes/subcontratos/estimacion/' + id_estimacion;
            $("#PDFModal .modal-body").html('<iframe src="' + url + '"  frameborder="0" height="100%" width="99.6%">d</iframe>');
            $("#PDFModal").modal("show");
        }
    }
});

},{}],33:[function(require,module,exports){
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
            }).then(function () {
                self.guardar();
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
            }).then(function () {
                self.eliminar(id_movimiento_bancario);
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
            }).then(function () {
                self.editar();
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

},{}],34:[function(require,module,exports){
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
            }).then(function () {
                self.guardar();
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
            }).then(function () {
                self.eliminar(id_traspaso);
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
            }).then(function () {
                self.editar();
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

},{}],35:[function(require,module,exports){
'use strict';

Vue.component('app-errors', {
    props: ['form'],

    template: require('./templates/errors.html')
});

},{"./templates/errors.html":39}],36:[function(require,module,exports){
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

},{"./templates/global-errors.html":40}],37:[function(require,module,exports){
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

},{}],38:[function(require,module,exports){
'use strict';

Vue.component('select2', {
    props: ['options', 'value', 'name'],
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
            width: '100%'
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
                width: '100%'
            });
        }
    },
    destroyed: function destroyed() {
        $(this.$el).off().select2('destroy');
    }
});

},{}],39:[function(require,module,exports){
module.exports = '<div id="form-errors" v-cloak>\n  <div class="alert alert-danger" v-if="form.errors.length">\n    <ul>\n      <li v-for="error in form.errors">{{ error }}</li>\n    </ul>\n  </div>\n</div>';
},{}],40:[function(require,module,exports){
module.exports = '<div class="alert alert-danger" v-show="errors.length">\n  <ul>\n    <li v-for="error in errors">{{ error }}</li>\n  </ul>\n</div>';
},{}]},{},[4]);

//# sourceMappingURL=app-vue.js.map
