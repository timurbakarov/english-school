/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./resources/themes/inspinia/js/groups-list.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/themes/inspinia/js/components/actions.js":
/*!************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/actions.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _actions_delete__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./actions/delete */ \"./resources/themes/inspinia/js/components/actions/delete.js\");\n/* harmony import */ var _actions_edit__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./actions/edit */ \"./resources/themes/inspinia/js/components/actions/edit.js\");\n/* harmony import */ var _actions_view__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./actions/view */ \"./resources/themes/inspinia/js/components/actions/view.js\");\n\n\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    'c-action-delete': _actions_delete__WEBPACK_IMPORTED_MODULE_0__[\"default\"],\n    'c-action-edit': _actions_edit__WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n    'c-action-view': _actions_view__WEBPACK_IMPORTED_MODULE_2__[\"default\"]\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/actions.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/actions/delete.js":
/*!*******************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/actions/delete.js ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    props: ['url'],\n    template: '<a :href=\"url\" @click=\"confirmation($event)\" class=\"btn btn-white btn-sm\"><i class=\"fa fa-trash\" style=\"color: red;\"></i></a>',\n    methods: {\n        confirmation: function (event) {\n            event.preventDefault();\n\n            let component = this;\n\n            if (confirm('Удалить?')) {\n                let form = $('<form></form>');\n                form.attr('action', component.url);\n                form.attr('method', 'POST');\n                form.append('<input type=\"hidden\" name=\"_token\" value=\"' + APP.csrf.token + '\" />');\n                $('body').append(form);\n                form.submit();\n            }\n        }\n    }\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/actions/delete.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/actions/edit.js":
/*!*****************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/actions/edit.js ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    props: ['url'],\n    template: '<a :href=\"url\" class=\"btn btn-white btn-sm\"><i class=\"fa fa-pencil\"></i></a>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/actions/edit.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/actions/view.js":
/*!*****************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/actions/view.js ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    props: ['url'],\n    template: '<a :href=\"url\" class=\"btn btn-white btn-sm\"><i class=\"fa fa-eye\"></i></a>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/actions/view.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/box.js":
/*!********************************************************!*\
  !*** ./resources/themes/inspinia/js/components/box.js ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _box_box__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./box/box */ \"./resources/themes/inspinia/js/components/box/box.js\");\n/* harmony import */ var _box_box_content__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./box/box-content */ \"./resources/themes/inspinia/js/components/box/box-content.js\");\n/* harmony import */ var _box_box_title__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./box/box-title */ \"./resources/themes/inspinia/js/components/box/box-title.js\");\n/* harmony import */ var _box_box_title_link__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./box/box-title-link */ \"./resources/themes/inspinia/js/components/box/box-title-link.js\");\n\n\n\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    'c-box': _box_box__WEBPACK_IMPORTED_MODULE_0__[\"default\"],\n    'c-box-content': _box_box_content__WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n    'c-box-title': _box_box_title__WEBPACK_IMPORTED_MODULE_2__[\"default\"],\n    'c-box-title-link': _box_box_title_link__WEBPACK_IMPORTED_MODULE_3__[\"default\"]\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/box.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/box/box-content.js":
/*!********************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/box/box-content.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    template: '<div class=\"ibox-content\"><slot></slot></div>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/box/box-content.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/box/box-title-link.js":
/*!***********************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/box/box-title-link.js ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    props: ['link'],\n    template: '<a class=\"btn btn-primary btn-xs\" :href=\"link.url\" v-text=\"link.label\"></a>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/box/box-title-link.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/box/box-title.js":
/*!******************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/box/box-title.js ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    props: {\n        title: {\n            type: String\n        },\n        size: {\n            default: 5,\n            type: Number\n        }\n    },\n    template: '<div class=\"ibox-title\"><div v-html=\"content\"></div><div class=\"ibox-tools\"><slot></slot></div></div>',\n    computed: {\n        content: function () {\n            return '<h' + this.size + '>' + this.title + '</h' + this.size + '>';\n        }\n    }\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/box/box-title.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/box/box.js":
/*!************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/box/box.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    template: '<div class=\"ibox\"><slot></slot></div>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/box/box.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/grid.js":
/*!*********************************************************!*\
  !*** ./resources/themes/inspinia/js/components/grid.js ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _grid_grid__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./grid/grid */ \"./resources/themes/inspinia/js/components/grid/grid.js\");\n/* harmony import */ var _grid_row__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./grid/row */ \"./resources/themes/inspinia/js/components/grid/row.js\");\n\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    'c-grid': _grid_grid__WEBPACK_IMPORTED_MODULE_0__[\"default\"],\n    'c-row': _grid_row__WEBPACK_IMPORTED_MODULE_1__[\"default\"]\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/grid.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/grid/grid.js":
/*!**************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/grid/grid.js ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    props: {\n        lg: {\n            default: 12,\n            type: Number\n        },\n        md: {\n            default: 12,\n            type: Number\n        },\n        sm: {\n            default: 12,\n            type: Number\n        }\n    },\n    template: '<div :class=\"[lgClass, mdClass, smClass]\"><slot></slot></div>',\n    computed: {\n        lgClass: function () {\n            return 'col-lg-' + this.lg;\n        },\n        mdClass: function () {\n            return 'col-md-' + this.md;\n        },\n        smClass: function () {\n            return 'col-sm-' + this.sm;\n        }\n    }\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/grid/grid.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/grid/row.js":
/*!*************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/grid/row.js ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    template: '<div class=\"wrapper wrapper-content\">' + '   <div class=\"row\">' + '       <slot></slot>' + '   </div>' + '</div>'\n\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/grid/row.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/student-group/schedules-compact.js":
/*!************************************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/student-group/schedules-compact.js ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    props: ['schedules'],\n    template: '<div><div v-for=\"schedule in schedules\">{{ schedule.day + \" \" + schedule.hour + \":\" + schedule.minutes }}</div></div>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/student-group/schedules-compact.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/table.js":
/*!**********************************************************!*\
  !*** ./resources/themes/inspinia/js/components/table.js ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _table_table__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./table/table */ \"./resources/themes/inspinia/js/components/table/table.js\");\n/* harmony import */ var _table_head__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./table/head */ \"./resources/themes/inspinia/js/components/table/head.js\");\n/* harmony import */ var _table_head_data__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./table/head-data */ \"./resources/themes/inspinia/js/components/table/head-data.js\");\n/* harmony import */ var _table_body__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./table/body */ \"./resources/themes/inspinia/js/components/table/body.js\");\n/* harmony import */ var _table_body_row__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./table/body-row */ \"./resources/themes/inspinia/js/components/table/body-row.js\");\n/* harmony import */ var _table_body_data__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./table/body-data */ \"./resources/themes/inspinia/js/components/table/body-data.js\");\n\n\n\n\n\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    'c-table': _table_table__WEBPACK_IMPORTED_MODULE_0__[\"default\"],\n    'c-table-head': _table_head__WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n    'c-table-head-data': _table_head_data__WEBPACK_IMPORTED_MODULE_2__[\"default\"],\n    'c-table-body': _table_body__WEBPACK_IMPORTED_MODULE_3__[\"default\"],\n    'c-table-body-row': _table_body_row__WEBPACK_IMPORTED_MODULE_4__[\"default\"],\n    'c-table-body-data': _table_body_data__WEBPACK_IMPORTED_MODULE_5__[\"default\"]\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/table.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/table/body-data.js":
/*!********************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/table/body-data.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    template: '<td><slot></slot></td>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/table/body-data.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/table/body-row.js":
/*!*******************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/table/body-row.js ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    template: '<tr><slot></slot></tr>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/table/body-row.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/table/body.js":
/*!***************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/table/body.js ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    template: '<tbody><slot></slot></tbody>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/table/body.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/table/head-data.js":
/*!********************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/table/head-data.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    props: {\n        width: {\n            type: String,\n            default: null\n        }\n    },\n    template: '<th :width=\"width\"><slot></slot></th>',\n    computed: {}\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/table/head-data.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/table/head.js":
/*!***************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/table/head.js ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    template: '<thead><tr><slot></slot></tr></thead>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/table/head.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/components/table/table.js":
/*!****************************************************************!*\
  !*** ./resources/themes/inspinia/js/components/table/table.js ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n    // props: {\n    //     table: {\n    //         type: Object\n    //     },\n    //     showHead: {\n    //         default: true,\n    //         type: Boolean\n    //     }\n    // },\n    template: '<div class=\"full-height-scroll\">' + '        <div class=\"table-responsive\">' + '            <table class=\"table table-striped table-hover\">' + '<slot></slot>' + '            </table>' + '        </div>' + '    </div>'\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/components/table/table.js?");

/***/ }),

/***/ "./resources/themes/inspinia/js/groups-list.js":
/*!*****************************************************!*\
  !*** ./resources/themes/inspinia/js/groups-list.js ***!
  \*****************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _components_grid__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/grid */ \"./resources/themes/inspinia/js/components/grid.js\");\n/* harmony import */ var _components_box__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/box */ \"./resources/themes/inspinia/js/components/box.js\");\n/* harmony import */ var _components_table__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/table */ \"./resources/themes/inspinia/js/components/table.js\");\n/* harmony import */ var _components_student_group_schedules_compact__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/student-group/schedules-compact */ \"./resources/themes/inspinia/js/components/student-group/schedules-compact.js\");\n/* harmony import */ var _components_actions__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/actions */ \"./resources/themes/inspinia/js/components/actions.js\");\n\n\n\n\n\n\nlet components = Object.assign(_components_grid__WEBPACK_IMPORTED_MODULE_0__[\"default\"], _components_box__WEBPACK_IMPORTED_MODULE_1__[\"default\"], _components_table__WEBPACK_IMPORTED_MODULE_2__[\"default\"], _components_actions__WEBPACK_IMPORTED_MODULE_4__[\"default\"], {\n    'c-schedule-compact': _components_student_group_schedules_compact__WEBPACK_IMPORTED_MODULE_3__[\"default\"]\n});\n\nnew Vue({\n    el: '#app-groups-list',\n    components: components,\n    data: data\n});\n\n//# sourceURL=webpack:///./resources/themes/inspinia/js/groups-list.js?");

/***/ })

/******/ });