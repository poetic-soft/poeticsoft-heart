/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/common/js/components/main.js"
/*!******************************************!*\
  !*** ./src/common/js/components/main.js ***!
  \******************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   SectionField: () => (/* reexport safe */ _section_field__WEBPACK_IMPORTED_MODULE_0__.SectionField)
/* harmony export */ });
/* harmony import */ var _section_field__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./section-field */ "./src/common/js/components/section-field.js");


/***/ },

/***/ "./src/common/js/components/section-field.js"
/*!***************************************************!*\
  !*** ./src/common/js/components/section-field.js ***!
  \***************************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   SectionField: () => (/* binding */ SectionField)
/* harmony export */ });
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/**
 * Componente de campo dinámico (field.js)
 */
var memo = wp.element.memo;
var _wp$components = wp.components,
  TextControl = _wp$components.TextControl,
  TextareaControl = _wp$components.TextareaControl,
  CheckboxControl = _wp$components.CheckboxControl,
  ToggleControl = _wp$components.ToggleControl,
  SelectControl = _wp$components.SelectControl,
  RadioControl = _wp$components.RadioControl;
var SectionField = memo(function (_ref) {
  var item = _ref.item,
    _onChange = _ref.onChange,
    errorMsg = _ref.errorMsg;
  var type = item.type,
    title = item.title,
    description = item.description,
    value = item.value,
    key = item.key,
    options = item.options;

  // Props comunes
  var commonProps = {
    label: title,
    help: errorMsg || description,
    value: value,
    onChange: function onChange(val) {
      return _onChange(key, val);
    },
    className: errorMsg ? 'is-error' : ''
  };

  /**
   * Renderizado según el tipo definido en el esquema
   */
  switch (type) {
    case 'textarea':
      return /*#__PURE__*/React.createElement(TextareaControl, _extends({}, commonProps, {
        rows: 8
      }));
    case 'checkbox':
      return /*#__PURE__*/React.createElement(CheckboxControl, _extends({}, commonProps, {
        checked: !!value,
        onChange: function onChange(val) {
          return _onChange(key, val);
        }
      }));
    case 'toggle':
      return /*#__PURE__*/React.createElement(ToggleControl, _extends({}, commonProps, {
        checked: !!value,
        onChange: function onChange(val) {
          return _onChange(key, val);
        }
      }));
    case 'select':
      return /*#__PURE__*/React.createElement(SelectControl, _extends({}, commonProps, {
        options: options || []
      }));
    case 'radio':
      return /*#__PURE__*/React.createElement(RadioControl, _extends({}, commonProps, {
        options: options || [],
        onChange: function onChange(val) {
          return _onChange(key, val);
        }
      }));
    case 'email':
    case 'number':
    case 'tel':
    case 'url':
      return /*#__PURE__*/React.createElement(TextControl, _extends({}, commonProps, {
        type: type
      }));
    case 'text':
    default:
      return /*#__PURE__*/React.createElement(TextControl, commonProps);
  }
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

/***/ "./src/common/js/main.js"
/*!*******************************!*\
  !*** ./src/common/js/main.js ***!
  \*******************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _store_main__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./store/main */ "./src/common/js/store/main.js");
/* harmony import */ var _portals_main__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./portals/main */ "./src/common/js/portals/main.js");



/***/ },

/***/ "./src/common/js/portals/main.js"
/*!***************************************!*\
  !*** ./src/common/js/portals/main.js ***!
  \***************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _manager__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./manager */ "./src/common/js/portals/manager.js");
var render = wp.element.render;

var setup = function setup() {
  var container = document.createElement('div');
  container.id = 'poeticsoft-heart-portal-root';
  container.style.display = 'none';
  document.body.appendChild(container);
  render(/*#__PURE__*/React.createElement(_manager__WEBPACK_IMPORTED_MODULE_0__["default"], null), container);
};
if (document.readyState === 'complete' || document.readyState === 'interactive') {
  setup();
} else {
  document.addEventListener('DOMContentLoaded', setup);
}

/***/ },

/***/ "./src/common/js/portals/manager.js"
/*!******************************************!*\
  !*** ./src/common/js/portals/manager.js ***!
  \******************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var common_js_config__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! common/js/config */ "./src/common/js/config.js");
function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
var useState = wp.element.useState;
var useSelect = wp.data.useSelect;
var _wp$element = wp.element,
  createPortal = _wp$element.createPortal,
  cloneElement = _wp$element.cloneElement;

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function () {
  var _useState = useState([]),
    _useState2 = _slicedToArray(_useState, 2),
    portalList = _useState2[0],
    setPortalList = _useState2[1];
  useSelect(function (select) {
    var detected = [];
    var portals = select(common_js_config__WEBPACK_IMPORTED_MODULE_0__["default"].store_key).portalsGet();
    portals.forEach(function (portal) {
      var selector = portal.selector;
      var elements = document.querySelectorAll(selector);
      elements.forEach(function (el) {
        var target = el.querySelector(portal.target);
        if (target) {
          if (!target.dataset.portalInitialized) {
            target.innerHTML = '';
            target.dataset.portalInitialized = 'true';
          }
          var id = target.id;
          var targetData = el.querySelector('script.data');
          var data = null;
          try {
            data = targetData ? JSON.parse(targetData.textContent) : null;
          } catch (e) {
            console.warn("JSON corrupto en ".concat(id));
          }
          detected.push({
            id: id,
            target: target,
            component: cloneElement(portal.comp, {
              data: data,
              rootElement: el,
              boxId: id
            })
          });
        }
      });
    });
    setPortalList(function (prevPortals) {
      if (prevPortals.length !== detected.length) return detected;
      var hasChanges = detected.some(function (p, i) {
        return p.id !== prevPortals[i].id || p.target !== prevPortals[i].target;
      });
      return hasChanges ? detected : prevPortals;
    });
  }, []);
  return /*#__PURE__*/React.createElement(React.Fragment, null, portalList.map(function (p) {
    return createPortal(p.component, p.target, p.id);
  }));
});

/***/ },

/***/ "./src/common/js/store/actions.js"
/*!****************************************!*\
  !*** ./src/common/js/store/actions.js ***!
  \****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  addPortal: function addPortal(portal) {
    return {
      type: 'PORTAL_ADD',
      payload: portal
    };
  }
});

/***/ },

/***/ "./src/common/js/store/main.js"
/*!*************************************!*\
  !*** ./src/common/js/store/main.js ***!
  \*************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var common_js_config__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! common/js/config */ "./src/common/js/config.js");
/* harmony import */ var _actions__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./actions */ "./src/common/js/store/actions.js");
/* harmony import */ var _selectors__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./selectors */ "./src/common/js/store/selectors.js");
/* harmony import */ var _reducer__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./reducer */ "./src/common/js/store/reducer.js");
var registerStore = wp.data.registerStore;




var store = registerStore(common_js_config__WEBPACK_IMPORTED_MODULE_0__["default"].store_key, {
  reducer: _reducer__WEBPACK_IMPORTED_MODULE_3__["default"],
  actions: _actions__WEBPACK_IMPORTED_MODULE_1__["default"],
  selectors: _selectors__WEBPACK_IMPORTED_MODULE_2__["default"]
});

/***/ },

/***/ "./src/common/js/store/reducer.js"
/*!****************************************!*\
  !*** ./src/common/js/store/reducer.js ***!
  \****************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _state__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./state */ "./src/common/js/store/state.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function () {
  var state = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : _state__WEBPACK_IMPORTED_MODULE_0__["default"];
  var action = arguments.length > 1 ? arguments[1] : undefined;
  switch (action.type) {
    case 'PORTAL_ADD':
      return _objectSpread(_objectSpread({}, state), {}, {
        portals: [].concat(_toConsumableArray(state.portals), [action.payload])
      });
    default:
      return state;
  }
});

/***/ },

/***/ "./src/common/js/store/selectors.js"
/*!******************************************!*\
  !*** ./src/common/js/store/selectors.js ***!
  \******************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  portalsGet: function portalsGet(state) {
    return state.portals;
  }
});

/***/ },

/***/ "./src/common/js/store/state.js"
/*!**************************************!*\
  !*** ./src/common/js/store/state.js ***!
  \**************************************/
(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  portals: []
});

/***/ },

/***/ "./src/common/scss/main.scss"
/*!***********************************!*\
  !*** ./src/common/scss/main.scss ***!
  \***********************************/
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
/*!****************************!*\
  !*** ./src/common/main.js ***!
  \****************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _js_main__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js/main */ "./src/common/js/main.js");
/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scss/main.scss */ "./src/common/scss/main.scss");
/* harmony import */ var _js_components_main__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./js/components/main */ "./src/common/js/components/main.js");



window.poeticsoft_heart = {
  id: 'poeticsoft_heart',
  store_key: 'poeticsoft_heart/store',
  comps: _js_components_main__WEBPACK_IMPORTED_MODULE_2__
};
})();

/******/ })()
;
//# sourceMappingURL=main.js.map