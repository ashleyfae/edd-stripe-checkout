/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/src/js/cart.js":
/*!*******************************!*\
  !*** ./assets/src/js/cart.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_apiRequest__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers/apiRequest */ "./assets/src/js/helpers/apiRequest.js");

var cartItems = document.querySelectorAll('.cart-item');

if (cartItems) {
  cartItems.forEach(function (item) {
    var removeButton = item.querySelector('.cart-item--remove');

    if (!removeButton) {
      return;
    }

    removeButton.addEventListener('click', function (e) {
      e.preventDefault();
      var cartKey = item.getAttribute('data-id');

      if (!cartKey) {
        console.log('Missing cart key.');
        return;
      }

      removeButton.classList.add('loading');
      removeButton.disabled = true;
      (0,_helpers_apiRequest__WEBPACK_IMPORTED_MODULE_0__["default"])('cart/' + cartKey, 'DELETE').then(function (response) {
        item.remove();
      })["catch"](function (error) {
        console.log('Error removing from cart', error);
      });
    });
  });
}

/***/ }),

/***/ "./assets/src/js/helpers/apiRequest.js":
/*!*********************************************!*\
  !*** ./assets/src/js/helpers/apiRequest.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ apiRequest)
/* harmony export */ });
/* global restBase */

/**
 * Makes an API request.
 *
 * @param {string} endpoint
 * @param {string} method
 * @param {object} body
 */
function apiRequest(endpoint, method) {
  var body = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
  var args = {
    method: method,
    credentials: 'same-origin',
    headers: {
      'Content-Type': 'application/json'
    }
  };

  if (Object.keys(body).length) {
    args.body = JSON.stringify(body);
  }

  return fetch(restBase + '/' + endpoint, args).then(function (response) {
    if (!response.ok) {
      return Promiose.reject(response);
    }

    return response.json();
  });
}

/***/ }),

/***/ "./assets/src/js/helpers/toggleDisplay.js":
/*!************************************************!*\
  !*** ./assets/src/js/helpers/toggleDisplay.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "show": () => (/* binding */ show),
/* harmony export */   "hide": () => (/* binding */ hide)
/* harmony export */ });
/**
 * @param {HTMLElement} element
 */
function show(element) {
  element.classList.remove('display-none');
  element.classList.add('display-block');
}
/**
 * @param {HTMLElement} element
 */

function hide(element) {
  element.classList.remove('display-block');
  element.classList.add('display-none');
}

/***/ }),

/***/ "./assets/src/js/index.js":
/*!********************************!*\
  !*** ./assets/src/js/index.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! ./cart */ "./assets/src/js/cart.js");

__webpack_require__(/*! ./login-register-form */ "./assets/src/js/login-register-form.js");

/***/ }),

/***/ "./assets/src/js/login-register-form.js":
/*!**********************************************!*\
  !*** ./assets/src/js/login-register-form.js ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers_toggleDisplay__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers/toggleDisplay */ "./assets/src/js/helpers/toggleDisplay.js");

var loginToggles = document.querySelectorAll('.register-login-toggle');

if (loginToggles) {
  loginToggles.forEach(function (toggle) {
    toggle.addEventListener('click', toggleLoginRegister);
  });
}

function toggleLoginRegister(e) {
  var button = this,
      registerHeading = document.getElementById('register-heading'),
      registerForm = document.getElementById('register'),
      loginHeading = document.getElementById('login-heading'),
      loginForm = document.getElementById('login');

  if (button.getAttribute('data-id') === 'register') {
    // They want to log in.
    (0,_helpers_toggleDisplay__WEBPACK_IMPORTED_MODULE_0__.hide)(registerHeading);
    (0,_helpers_toggleDisplay__WEBPACK_IMPORTED_MODULE_0__.hide)(registerForm);
    (0,_helpers_toggleDisplay__WEBPACK_IMPORTED_MODULE_0__.show)(loginHeading);
    (0,_helpers_toggleDisplay__WEBPACK_IMPORTED_MODULE_0__.show)(loginForm);
    var loginEmail = loginForm.querySelector('input[type="email"]');

    if (loginEmail) {
      loginEmail.focus();
    }
  } else {
    // They want to register.
    (0,_helpers_toggleDisplay__WEBPACK_IMPORTED_MODULE_0__.hide)(loginHeading);
    (0,_helpers_toggleDisplay__WEBPACK_IMPORTED_MODULE_0__.hide)(loginForm);
    (0,_helpers_toggleDisplay__WEBPACK_IMPORTED_MODULE_0__.show)(registerHeading);
    (0,_helpers_toggleDisplay__WEBPACK_IMPORTED_MODULE_0__.show)(registerForm);
    var registerEmail = registerForm.querySelector('input[type="email"]');

    if (registerEmail) {
      registerEmail.focus();
    }
  }
}

/***/ }),

/***/ "./assets/src/sass/index.scss":
/*!************************************!*\
  !*** ./assets/src/sass/index.scss ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/dist/js/index": 0,
/******/ 			"assets/dist/css/index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkedd_stripe_checkout"] = self["webpackChunkedd_stripe_checkout"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["assets/dist/css/index"], () => (__webpack_require__("./assets/src/js/index.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["assets/dist/css/index"], () => (__webpack_require__("./assets/src/sass/index.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;