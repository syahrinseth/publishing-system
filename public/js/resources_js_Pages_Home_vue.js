"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Home_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Table.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Table.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Link: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.Link
  },
  setup: function setup() {
    return {};
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Home.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Home.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Layout__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../Layout */ "./resources/js/Layout.vue");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var _Components_Table_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../Components/Table.vue */ "./resources/js/Components/Table.vue");




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Head: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.Head,
    Layout: _Layout__WEBPACK_IMPORTED_MODULE_0__["default"],
    Table: _Components_Table_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    Link: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.Link
  },
  props: {
    auth: Object,
    manuscript_overview: Object,
    activities: Object,
    nextSteps: Object
  },
  setup: function setup(props) {
    var overviewCards = [{
      name: 'Draft Manuscripts',
      value: props.manuscript_overview.total_draft,
      color: 'text-gray-700',
      icon: 'fa-file-lines'
    }, {
      name: 'In Review Manuscripts',
      value: props.manuscript_overview.total_review,
      color: 'text-blue-700',
      icon: 'fa-magnifying-glass'
    }, {
      name: 'Rejected Manuscripts',
      value: props.manuscript_overview.total_rejected,
      color: 'text-red-700',
      icon: 'fa-thumbs-down'
    }, {
      name: 'Approved Manuscripts',
      value: props.manuscript_overview.total_approved,
      color: 'text-green-700',
      icon: 'fa-thumbs-up'
    }, {
      name: 'Published Manuscripts',
      value: props.manuscript_overview.total_published,
      color: 'text-teal-700',
      icon: 'fa-upload'
    }];
    return {
      overviewCards: overviewCards
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Table.vue?vue&type=template&id=67955193":
/*!***************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Table.vue?vue&type=template&id=67955193 ***!
  \***************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "flex flex-col"
};
var _hoisted_2 = {
  "class": "-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"
};
var _hoisted_3 = {
  "class": "py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
};
var _hoisted_4 = {
  "class": "shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
};
var _hoisted_5 = {
  "class": "min-w-full divide-y divide-gray-200 table-fixed"
};
var _hoisted_6 = {
  "class": "bg-gray-50"
};
var _hoisted_7 = {
  "class": "bg-white divide-y divide-gray-200"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.renderSlot)(_ctx.$slots, "header")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.renderSlot)(_ctx.$slots, "body")])])])])])]);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Home.vue?vue&type=template&id=6a63e488":
/*!*********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Home.vue?vue&type=template&id=6a63e488 ***!
  \*********************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("title", null, "Home", -1
/* HOISTED */
);

var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", {
  "class": "text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"
}, " Dashboard ", -1
/* HOISTED */
);

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
  "class": "font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate mb-4"
}, "Overview", -1
/* HOISTED */
);

var _hoisted_4 = {
  "class": "grid grid-cols-4 gap-3 mb-5"
};
var _hoisted_5 = {
  "class": "flex-shrink-0 self-center"
};
var _hoisted_6 = {
  "class": "ml-6 pt-1"
};
var _hoisted_7 = {
  "class": "text-md text-gray-700"
};
var _hoisted_8 = {
  "class": "text-xl text-gray-500"
};

var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
  "class": "font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate my-4"
}, "Next Step", -1
/* HOISTED */
);

var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  "class": "px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
}, " Description "), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  "class": "px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
}, " Actions ")], -1
/* HOISTED */
);

var _hoisted_11 = {
  "class": "px-6 py-4 whitespace-nowrap"
};
var _hoisted_12 = {
  "class": "px-6 py-4 whitespace-nowrap"
};

var _hoisted_13 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Review");

var _hoisted_14 = {
  "class": "px-6 py-4 whitespace-nowrap"
};
var _hoisted_15 = {
  "class": "px-6 py-4 whitespace-nowrap"
};

var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Review");

var _hoisted_17 = {
  "class": "px-6 py-4 whitespace-nowrap"
};
var _hoisted_18 = {
  "class": "px-6 py-4 whitespace-nowrap"
};

var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Review");

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Head = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Head");

  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  var _component_Table = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Table");

  var _component_Layout = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Layout");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Head, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_1];
    }),
    _: 1
    /* STABLE */

  }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Layout, {
    auth: $props.auth.user.data
  }, {
    header: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_2];
    }),
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.overviewCards, function (overview) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          key: "overview-".concat(overview.name),
          "class": "max-w-sm flex p-6 bg-gray-100 rounded-lg shadow"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
          "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)([[overview.icon, overview.color], "fa fa-2xl"])
        }, null, 2
        /* CLASS */
        )]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(overview.name), 1
        /* TEXT */
        ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(overview.value), 1
        /* TEXT */
        )])]);
      }), 128
      /* KEYED_FRAGMENT */
      ))]), _hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Table, null, {
        header: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [_hoisted_10];
        }),
        body: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.nextSteps.publisher.data, function (step, index) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
              key: "step-author-".concat(index)
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Manuscript \"".concat(step.title || step.type['name'], "\" is ready to be publish by you. Please review the manuscript.")), 1
            /* TEXT */
            ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_12, [$props.auth.user.data.permissions_attribute.manuscripts.edit == true ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
              key: 0,
              href: "/admin/manuscripts/".concat(step.id, "/edit"),
              "class": "text-indigo-600 hover:text-indigo-900 px-2"
            }, {
              "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                return [_hoisted_13];
              }),
              _: 2
              /* DYNAMIC */

            }, 1032
            /* PROPS, DYNAMIC_SLOTS */
            , ["href"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]);
          }), 128
          /* KEYED_FRAGMENT */
          )), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.nextSteps.reviewer.data, function (step, index) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
              key: "step-author-".concat(index)
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Manuscript \"".concat(step.title || step.type['name'], "\" is ready to be review by you. Please review the manuscript.")), 1
            /* TEXT */
            ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_15, [$props.auth.user.data.permissions_attribute.manuscripts.edit == true ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
              key: 0,
              href: "/admin/manuscripts/".concat(step.id, "/edit"),
              "class": "text-indigo-600 hover:text-indigo-900 px-2"
            }, {
              "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                return [_hoisted_16];
              }),
              _: 2
              /* DYNAMIC */

            }, 1032
            /* PROPS, DYNAMIC_SLOTS */
            , ["href"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]);
          }), 128
          /* KEYED_FRAGMENT */
          )), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.nextSteps.author.data, function (step, index) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
              key: "step-author-".concat(index)
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)("Manuscript \"".concat(step.title || step.type['name'], "\" is in status \"").concat(step.status, "\". Please review the manuscript.")), 1
            /* TEXT */
            ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_18, [$props.auth.user.data.permissions_attribute.manuscripts.edit == true ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_Link, {
              key: 0,
              href: "/admin/manuscripts/".concat(step.id, "/edit"),
              "class": "text-indigo-600 hover:text-indigo-900 px-2"
            }, {
              "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                return [_hoisted_19];
              }),
              _: 2
              /* DYNAMIC */

            }, 1032
            /* PROPS, DYNAMIC_SLOTS */
            , ["href"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])]);
          }), 128
          /* KEYED_FRAGMENT */
          ))];
        }),
        _: 1
        /* STABLE */

      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <h4 class=\"font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate my-4\">Recent Activities</h4>\n          <Table>\n            <template v-slot:header>\n              <tr>\n                <th class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">\n                  Time\n                </th>\n                <th class=\"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider\">\n                  Activity\n                </th>\n              </tr>\n            </template>\n            <template v-slot:body>\n              <tr v-for=\"activity in activities.data\" :key=\"`activity-${activity.id}`\">\n                <td class=\"px-6 py-4 whitespace-nowrap\">\n                  {{ activity.created_at }}\n                </td>\n                <td class=\"px-6 py-4 whitespace-nowrap\">\n                  <h4 class=\"text-gray-700\">{{ activity.subject_type }}</h4>\n                  <span v-if=\"activity.description == 'updated'\">\n                    <div class=\"grid grid-cols-3 justify-items-stretch\" v-if=\"activity.properties['attributes'].length != 0\">\n                      <div>\n                        <p v-for=\"(value, name) in activity.properties['old'] || []\" :key=\"`prop-${value}`\">\n                          {{ name }}: <span class=\"text-red-700\">{{ value }}</span>\n                        </p>\n                      </div>\n                      <div class=\"justify-self-center\">\n                        ->\n                      </div>\n                      <div>\n                        <p v-for=\"(value, name) in activity.properties['attributes']\" :key=\"`prop-${value}`\">\n                          {{ name }}: <span class=\"text-green-700\">{{ value }}</span>\n                        </p>\n                      </div>\n                    </div>\n                    <div v-else>\n                      N/a\n                    </div>\n                  </span>\n                </td>\n              </tr>\n            </template>\n          </Table> ")];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["auth"])]);
}

/***/ }),

/***/ "./resources/js/Components/Table.vue":
/*!*******************************************!*\
  !*** ./resources/js/Components/Table.vue ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Table_vue_vue_type_template_id_67955193__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Table.vue?vue&type=template&id=67955193 */ "./resources/js/Components/Table.vue?vue&type=template&id=67955193");
/* harmony import */ var _Table_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Table.vue?vue&type=script&lang=js */ "./resources/js/Components/Table.vue?vue&type=script&lang=js");
/* harmony import */ var _Users_muhammadnorsyahrinseth_Documents_projects_publishing_system_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_Users_muhammadnorsyahrinseth_Documents_projects_publishing_system_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Table_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Table_vue_vue_type_template_id_67955193__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Components/Table.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/Home.vue":
/*!*************************************!*\
  !*** ./resources/js/Pages/Home.vue ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Home_vue_vue_type_template_id_6a63e488__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Home.vue?vue&type=template&id=6a63e488 */ "./resources/js/Pages/Home.vue?vue&type=template&id=6a63e488");
/* harmony import */ var _Home_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Home.vue?vue&type=script&lang=js */ "./resources/js/Pages/Home.vue?vue&type=script&lang=js");
/* harmony import */ var _Users_muhammadnorsyahrinseth_Documents_projects_publishing_system_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_Users_muhammadnorsyahrinseth_Documents_projects_publishing_system_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Home_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Home_vue_vue_type_template_id_6a63e488__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Home.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Components/Table.vue?vue&type=script&lang=js":
/*!*******************************************************************!*\
  !*** ./resources/js/Components/Table.vue?vue&type=script&lang=js ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Table_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Table_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Table.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Table.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/Home.vue?vue&type=script&lang=js":
/*!*************************************************************!*\
  !*** ./resources/js/Pages/Home.vue?vue&type=script&lang=js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Home_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Home_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Home.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Home.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Components/Table.vue?vue&type=template&id=67955193":
/*!*************************************************************************!*\
  !*** ./resources/js/Components/Table.vue?vue&type=template&id=67955193 ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Table_vue_vue_type_template_id_67955193__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Table_vue_vue_type_template_id_67955193__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Table.vue?vue&type=template&id=67955193 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Components/Table.vue?vue&type=template&id=67955193");


/***/ }),

/***/ "./resources/js/Pages/Home.vue?vue&type=template&id=6a63e488":
/*!*******************************************************************!*\
  !*** ./resources/js/Pages/Home.vue?vue&type=template&id=6a63e488 ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Home_vue_vue_type_template_id_6a63e488__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Home_vue_vue_type_template_id_6a63e488__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Home.vue?vue&type=template&id=6a63e488 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Home.vue?vue&type=template&id=6a63e488");


/***/ })

}]);