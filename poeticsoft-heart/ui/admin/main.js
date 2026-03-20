/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/admin/js/main.js"
/*!******************************!*\
  !*** ./src/admin/js/main.js ***!
  \******************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _portals_dashboards_main__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./portals/dashboards/main */ "./src/admin/js/portals/dashboards/main.js");


/***/ },

/***/ "./src/admin/js/portals/dashboards/aiagent/main.js"
/*!*********************************************************!*\
  !*** ./src/admin/js/portals/dashboards/aiagent/main.js ***!
  \*********************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function (props) {
  var SectionField = window.poeticsoft_heart.comps.SectionField;
  var sections = props.data;
  var onChange = function onChange(value) {
    console.log(value);
  };
  var errorMsg = 'Error';
  return /*#__PURE__*/React.createElement("div", {
    className: "Dashboard aiagent"
  }, sections.map(function (section) {
    return /*#__PURE__*/React.createElement(SectionField, {
      item: section,
      onChange: onChange,
      errorMsg: errorMsg
    });
  }));
});

/***/ },

/***/ "./src/admin/js/portals/dashboards/main.js"
/*!*************************************************!*\
  !*** ./src/admin/js/portals/dashboards/main.js ***!
  \*************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var common_js_config__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! common/js/config */ "./src/common/js/config.js");
/* harmony import */ var _aiagent_main__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./aiagent/main */ "./src/admin/js/portals/dashboards/aiagent/main.js");
var dispatch = wp.data.dispatch;


dispatch(common_js_config__WEBPACK_IMPORTED_MODULE_0__["default"].store_key).addPortal({
  selector: '.postbox .DashboardWidget.poeticsoft_heart_gemini',
  target: '.Portal',
  comp: /*#__PURE__*/React.createElement(_aiagent_main__WEBPACK_IMPORTED_MODULE_1__["default"], null)
});

/***/ },

/***/ "./src/common/js/config.js"
/*!*********************************!*\
  !*** ./src/common/js/config.js ***!
  \*********************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  store_key: 'poeticsoft_heart/store'
});

/***/ },

/***/ "./src/admin/scss/main.scss"
/*!**********************************!*\
  !*** ./src/admin/scss/main.scss ***!
  \**********************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }

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
/******/ 		if (!(moduleId in __webpack_modules__)) {
/******/ 			delete __webpack_module_cache__[moduleId];
/******/ 			var e = new Error("Cannot find module '" + moduleId + "'");
/******/ 			e.code = 'MODULE_NOT_FOUND';
/******/ 			throw e;
/******/ 		}
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
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
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!***************************!*\
  !*** ./src/admin/main.js ***!
  \***************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _js_main__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js/main */ "./src/admin/js/main.js");
/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scss/main.scss */ "./src/admin/scss/main.scss");


})();

/******/ })()
;
//# sourceMappingURL=main.js.map