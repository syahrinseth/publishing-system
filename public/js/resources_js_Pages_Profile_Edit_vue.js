"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_Pages_Profile_Edit_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Profile/Edit.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Profile/Edit.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Layout__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../Layout */ "./resources/js/Layout.vue");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "./node_modules/@inertiajs/inertia-vue3/dist/index.js");
/* harmony import */ var _Components_Toast__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../Components/Toast */ "./resources/js/Components/Toast.vue");
/* harmony import */ var _inertiajs_inertia__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @inertiajs/inertia */ "./node_modules/@inertiajs/inertia/dist/index.js");




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    Layout: _Layout__WEBPACK_IMPORTED_MODULE_0__["default"],
    useForm: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.useForm,
    Link: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.Link,
    Toast: _Components_Toast__WEBPACK_IMPORTED_MODULE_2__["default"],
    Inertia: _inertiajs_inertia__WEBPACK_IMPORTED_MODULE_3__.Inertia
  },
  props: {
    user: Object,
    roles: Array,
    auth: Object
  },
  data: function data() {
    return {
      userPhoto: null
    };
  },
  methods: {
    notification: function notification(message) {
      var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'success';
      this.$toast.open({
        message: message,
        type: type,
        duration: 5000,
        dismissible: true
      });
    },
    onSubmit: function onSubmit() {
      var _this = this;

      this.userForm.post("/admin/profile", {
        preserveScroll: true,
        onError: function onError(errors) {
          Object.keys(errors).forEach(function (value, index) {
            _this.notification(errors[value], 'error');
          });
        },
        onSuccess: function onSuccess() {
          _this.notification('Saved', 'success');
        }
      });
    },
    onChangeProfileImage: function onChangeProfileImage(e) {
      this.userPhoto = URL.createObjectURL(e.target.files[0]);
      this.userForm.photo = e.target.files[0];
    },
    canEditRoleAndPermission: function canEditRoleAndPermission() {
      var _this$auth$user$data, _this$auth$user$data$, _this$auth$user$data$2;

      return (_this$auth$user$data = this.auth.user.data) === null || _this$auth$user$data === void 0 ? void 0 : (_this$auth$user$data$ = _this$auth$user$data.permissions_attribute) === null || _this$auth$user$data$ === void 0 ? void 0 : (_this$auth$user$data$2 = _this$auth$user$data$.roles_and_permissions) === null || _this$auth$user$data$2 === void 0 ? void 0 : _this$auth$user$data$2.edit;
    }
  },
  setup: function setup(props) {
    var user = props.user.data;
    var userForm = (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.useForm)({
      _method: 'PUT',
      first_name: user.first_name,
      last_name: user.last_name,
      email: user.email,
      address_1: user.address_1,
      address_2: user.address_2,
      postcode: user.postcode,
      field: user.field,
      city: user.city,
      state: user.state,
      fax_no: user.fax_no,
      country: user.country,
      website_url: user.website_url,
      about: user.about,
      photo: user.photo,
      affiliation: user.affiliation,
      roles: user.roles.length > 0 ? user.roles.map(function (e) {
        return e.id;
      }) : []
    });
    return {
      userForm: userForm
    };
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Profile/Edit.vue?vue&type=template&id=af868e0e":
/*!*****************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Profile/Edit.vue?vue&type=template&id=af868e0e ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");


var _hoisted_1 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "lg:flex lg:items-center lg:justify-between"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "flex-1 min-w-0"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h2", {
  "class": "text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"
}, " User Profile ")])], -1
/* HOISTED */
);

var _hoisted_2 = {
  "class": "md:grid md:grid-cols-3 md:gap-6"
};

var _hoisted_3 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "md:col-span-1"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "px-4 sm:px-0"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
  "class": "text-lg font-medium leading-6 text-gray-900"
}, "Profile"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "mt-1 text-sm text-gray-600"
}, "This information will be displayed publicly so be careful what you share.")])], -1
/* HOISTED */
);

var _hoisted_4 = {
  "class": "mt-5 md:mt-0 md:col-span-2"
};
var _hoisted_5 = {
  "class": "shadow sm:rounded-md sm:overflow-hidden"
};
var _hoisted_6 = {
  "class": "px-4 py-5 bg-white space-y-6 sm:p-6"
};
var _hoisted_7 = {
  "class": "col-span-6 sm:col-span-6"
};

var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "first-name",
  "class": "block text-sm font-medium text-gray-700"
}, "First Name", -1
/* HOISTED */
);

var _hoisted_9 = {
  "class": "col-span-6 sm:col-span-6"
};

var _hoisted_10 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "last-name",
  "class": "block text-sm font-medium text-gray-700"
}, "Last Name", -1
/* HOISTED */
);

var _hoisted_11 = {
  "class": "col-span-8 sm:col-span-8"
};

var _hoisted_12 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "field",
  "class": "block text-sm font-medium text-gray-700"
}, "Field", -1
/* HOISTED */
);

var _hoisted_13 = {
  "class": "col-span-8 sm:col-span-8"
};

var _hoisted_14 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "affiliation",
  "class": "block text-sm font-medium text-gray-700"
}, "Affiliation", -1
/* HOISTED */
);

var _hoisted_15 = {
  "class": "grid grid-cols-3 gap-6"
};
var _hoisted_16 = {
  "class": "col-span-3 sm:col-span-2"
};

var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "company-website",
  "class": "block text-sm font-medium text-gray-700"
}, " Website ", -1
/* HOISTED */
);

var _hoisted_18 = {
  "class": "mt-1 flex rounded-md shadow-sm"
};

var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"
}, " http:// ", -1
/* HOISTED */
);

var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "about",
  "class": "block text-sm font-medium text-gray-700"
}, " About ", -1
/* HOISTED */
);

var _hoisted_21 = {
  "class": "mt-1"
};

var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "mt-2 text-sm text-gray-500"
}, "Brief description for your profile. URLs are hyperlinked.", -1
/* HOISTED */
);

var _hoisted_23 = {
  "for": "file-upload",
  "class": "relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
};
var _hoisted_24 = {
  "class": "mt-1 flex items-center"
};
var _hoisted_25 = {
  "class": "inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100"
};
var _hoisted_26 = {
  key: 0,
  "class": "h-full w-full text-gray-300",
  fill: "currentColor",
  viewBox: "0 0 24 24"
};

var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  d: "M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
}, null, -1
/* HOISTED */
);

var _hoisted_28 = [_hoisted_27];
var _hoisted_29 = ["src"];
var _hoisted_30 = ["src"];

var _hoisted_31 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
}, " Change ", -1
/* HOISTED */
);

var _hoisted_32 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "px-4 py-3 bg-gray-50 text-right sm:px-6"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
}, "Save")], -1
/* HOISTED */
);

var _hoisted_33 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "hidden sm:block",
  "aria-hidden": "true"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "py-5"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "border-t border-gray-200"
})])], -1
/* HOISTED */
);

var _hoisted_34 = {
  "class": "mt-10 sm:mt-0"
};
var _hoisted_35 = {
  "class": "md:grid md:grid-cols-3 md:gap-6"
};

var _hoisted_36 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "md:col-span-1"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "px-4 sm:px-0"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
  "class": "text-lg font-medium leading-6 text-gray-900"
}, "Personal Information"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "mt-1 text-sm text-gray-600"
}, "Use a permanent address where you can receive mail.")])], -1
/* HOISTED */
);

var _hoisted_37 = {
  "class": "mt-5 md:mt-0 md:col-span-2"
};
var _hoisted_38 = {
  "class": "shadow overflow-hidden sm:rounded-md"
};
var _hoisted_39 = {
  "class": "px-4 py-5 bg-white sm:p-6"
};
var _hoisted_40 = {
  "class": "grid grid-cols-12 gap-6"
};
var _hoisted_41 = {
  "class": "col-span-4 sm:col-span-4"
};

var _hoisted_42 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "email-address",
  "class": "block text-sm font-medium text-gray-700"
}, "Email address", -1
/* HOISTED */
);

var _hoisted_43 = {
  "class": "col-span-4 sm:col-span-4"
};

var _hoisted_44 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "fax-number",
  "class": "block text-sm font-medium text-gray-700"
}, "Fax Number", -1
/* HOISTED */
);

var _hoisted_45 = {
  "class": "col-span-4 sm:col-span-4"
};

var _hoisted_46 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "country",
  "class": "block text-sm font-medium text-gray-700"
}, "Country", -1
/* HOISTED */
);

var _hoisted_47 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", null, "Malaysia", -1
/* HOISTED */
);

var _hoisted_48 = [_hoisted_47];
var _hoisted_49 = {
  "class": "col-span-12"
};

var _hoisted_50 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "street-address",
  "class": "block text-sm font-medium text-gray-700"
}, "Street address", -1
/* HOISTED */
);

var _hoisted_51 = {
  "class": "col-span-4"
};

var _hoisted_52 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "city",
  "class": "block text-sm font-medium text-gray-700"
}, "City", -1
/* HOISTED */
);

var _hoisted_53 = {
  "class": "col-span-4"
};

var _hoisted_54 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "region",
  "class": "block text-sm font-medium text-gray-700"
}, "State / Province", -1
/* HOISTED */
);

var _hoisted_55 = {
  "class": "col-span-4"
};

var _hoisted_56 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "postal-code",
  "class": "block text-sm font-medium text-gray-700"
}, "ZIP / Postal code", -1
/* HOISTED */
);

var _hoisted_57 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "px-4 py-3 bg-gray-50 text-right sm:px-6"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  type: "submit",
  "class": "inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
}, "Save")], -1
/* HOISTED */
);

var _hoisted_58 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "hidden sm:block",
  "aria-hidden": "true"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "py-5"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "border-t border-gray-200"
})])], -1
/* HOISTED */
);

var _hoisted_59 = {
  "class": "mt-10 sm:mt-0"
};
var _hoisted_60 = {
  "class": "md:grid md:grid-cols-3 md:gap-6"
};

var _hoisted_61 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "md:col-span-1"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "px-4 sm:px-0"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h3", {
  "class": "text-lg font-medium leading-6 text-gray-900"
}, "Roles"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
  "class": "mt-1 text-sm text-gray-600"
}, "Assign role to the user..")])], -1
/* HOISTED */
);

var _hoisted_62 = {
  "class": "mt-5 md:mt-0 md:col-span-2"
};
var _hoisted_63 = {
  "class": "shadow overflow-hidden sm:rounded-md"
};
var _hoisted_64 = {
  "class": "px-4 py-5 bg-white space-y-6 sm:p-6"
};

var _hoisted_65 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("legend", {
  "class": "text-base font-medium text-gray-900"
}, "Roles", -1
/* HOISTED */
);

var _hoisted_66 = {
  "class": "mt-4 space-y-4"
};
var _hoisted_67 = {
  "class": "flex items-center h-5"
};
var _hoisted_68 = ["id", "value", "disabled"];
var _hoisted_69 = {
  "class": "ml-3 text-sm"
};
var _hoisted_70 = ["for"];
var _hoisted_71 = {
  "class": "px-4 py-3 bg-gray-50 text-right sm:px-6"
};
var _hoisted_72 = ["disabled"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_Layout = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Layout");

  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Layout, {
    auth: $props.auth.user.data
  }, {
    header: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [_hoisted_1];
    }),
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [_hoisted_3, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
        onSubmit: _cache[7] || (_cache[7] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
          return $options.onSubmit();
        }, ["prevent"])),
        method: "POST"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [_hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
          return $setup.userForm.first_name = $event;
        }),
        type: "text",
        name: "first-name",
        id: "first-name",
        autocomplete: "given-name",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.first_name]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_9, [_hoisted_10, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
          return $setup.userForm.last_name = $event;
        }),
        type: "text",
        name: "last-name",
        id: "last-name",
        autocomplete: "given-name",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.last_name]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [_hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
          return $setup.userForm.field = $event;
        }),
        type: "text",
        name: "field",
        id: "field",
        autocomplete: "given-name",
        placeholder: "eg: Optical Sensors",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.field]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_13, [_hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
          return $setup.userForm.affiliation = $event;
        }),
        type: "text",
        name: "affiliation",
        id: "affiliation",
        autocomplete: "given-name",
        placeholder: "eg: University of Malaya",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.affiliation]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [_hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_18, [_hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[4] || (_cache[4] = function ($event) {
          return $setup.userForm.website_url = $event;
        }),
        type: "text",
        name: "company-website",
        id: "company-website",
        "class": "focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300",
        placeholder: "www.example.com"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.website_url]])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [_hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
        "onUpdate:modelValue": _cache[5] || (_cache[5] = function ($event) {
          return $setup.userForm.about = $event;
        }),
        id: "about",
        name: "about",
        rows: "3",
        "class": "shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md",
        placeholder: "you@example.com"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.about]])]), _hoisted_22]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_25, [$data.userPhoto == null && $setup.userForm.photo == null ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("svg", _hoisted_26, _hoisted_28)) : $data.userPhoto != null ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("img", {
        key: 1,
        src: $data.userPhoto,
        alt: ""
      }, null, 8
      /* PROPS */
      , _hoisted_29)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("img", {
        key: 2,
        src: "/storage/".concat($setup.userForm.photo),
        alt: ""
      }, null, 8
      /* PROPS */
      , _hoisted_30))]), _hoisted_31]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        onChange: _cache[6] || (_cache[6] = function () {
          return $options.onChangeProfileImage && $options.onChangeProfileImage.apply($options, arguments);
        }),
        id: "file-upload",
        ref: "file",
        type: "file",
        "class": "sr-only"
      }, null, 544
      /* HYDRATE_EVENTS, NEED_PATCH */
      )])])]), _hoisted_32])], 32
      /* HYDRATE_EVENTS */
      )])])]), _hoisted_33, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_34, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [_hoisted_36, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
        onSubmit: _cache[16] || (_cache[16] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
          return $options.onSubmit();
        }, ["prevent"])),
        method: "POST"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_39, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_40, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_41, [_hoisted_42, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[8] || (_cache[8] = function ($event) {
          return $setup.userForm.email = $event;
        }),
        type: "text",
        name: "email-address",
        id: "email-address",
        autocomplete: "email",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.email]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_43, [_hoisted_44, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[9] || (_cache[9] = function ($event) {
          return $setup.userForm.fax_no = $event;
        }),
        type: "text",
        name: "fax-number",
        id: "fax-number",
        autocomplete: "fax-number",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.fax_no]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [_hoisted_46, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
        "onUpdate:modelValue": _cache[10] || (_cache[10] = function ($event) {
          return $setup.userForm.country = $event;
        }),
        id: "country",
        name: "country",
        autocomplete: "country-name",
        "class": "mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
      }, _hoisted_48, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $setup.userForm.country]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_49, [_hoisted_50, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[11] || (_cache[11] = function ($event) {
          return $setup.userForm.address_1 = $event;
        }),
        type: "text",
        name: "street-address",
        id: "street-address",
        autocomplete: "street-address",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.address_1]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[12] || (_cache[12] = function ($event) {
          return $setup.userForm.address_2 = $event;
        }),
        type: "text",
        name: "street-address-2",
        id: "street-address-2",
        autocomplete: "street-address-2",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.address_2]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [_hoisted_52, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[13] || (_cache[13] = function ($event) {
          return $setup.userForm.city = $event;
        }),
        type: "text",
        name: "city",
        id: "city",
        autocomplete: "address-level1",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.city]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_53, [_hoisted_54, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[14] || (_cache[14] = function ($event) {
          return $setup.userForm.state = $event;
        }),
        type: "text",
        name: "region",
        id: "region",
        autocomplete: "address-level1",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.state]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_55, [_hoisted_56, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
        "onUpdate:modelValue": _cache[15] || (_cache[15] = function ($event) {
          return $setup.userForm.postcode = $event;
        }),
        type: "text",
        name: "postal-code",
        id: "postal-code",
        autocomplete: "postal-code",
        "class": "mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
      }, null, 512
      /* NEED_PATCH */
      ), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $setup.userForm.postcode]])])])]), _hoisted_57])], 32
      /* HYDRATE_EVENTS */
      )])])]), _hoisted_58, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_59, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_60, [_hoisted_61, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_62, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
        onSubmit: _cache[18] || (_cache[18] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
          return $options.onSubmit();
        }, ["prevent"])),
        method: "POST"
      }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_63, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_64, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("fieldset", null, [_hoisted_65, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_66, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.roles, function (role) {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
          key: "role-".concat(role.id),
          "class": "flex items-start"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_67, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
          id: "role-input-".concat(role.id),
          "onUpdate:modelValue": _cache[17] || (_cache[17] = function ($event) {
            return $setup.userForm.roles = $event;
          }),
          value: role.id,
          type: "checkbox",
          "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded", {
            'cursor-not-allowed bg-slate-500': !$options.canEditRoleAndPermission()
          }]),
          disabled: !$options.canEditRoleAndPermission()
        }, null, 10
        /* CLASS, PROPS */
        , _hoisted_68), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $setup.userForm.roles]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_69, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
          "for": "role-input-".concat(role.id),
          "class": "font-medium text-gray-700"
        }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(role.name), 9
        /* TEXT, PROPS */
        , _hoisted_70), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <p class=\"text-gray-500\">Get notified when someones posts a comment on a posting.</p> ")])]);
      }), 128
      /* KEYED_FRAGMENT */
      ))])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_71, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
        type: "submit",
        "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(["inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500", {
          'cursor-not-allowed bg-slate-500': !$options.canEditRoleAndPermission()
        }]),
        disabled: !$options.canEditRoleAndPermission()
      }, "Save", 10
      /* CLASS, PROPS */
      , _hoisted_72)])])], 32
      /* HYDRATE_EVENTS */
      )])])])];
    }),
    _: 1
    /* STABLE */

  }, 8
  /* PROPS */
  , ["auth"])]);
}

/***/ }),

/***/ "./resources/js/Pages/Profile/Edit.vue":
/*!*********************************************!*\
  !*** ./resources/js/Pages/Profile/Edit.vue ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Edit_vue_vue_type_template_id_af868e0e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Edit.vue?vue&type=template&id=af868e0e */ "./resources/js/Pages/Profile/Edit.vue?vue&type=template&id=af868e0e");
/* harmony import */ var _Edit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Edit.vue?vue&type=script&lang=js */ "./resources/js/Pages/Profile/Edit.vue?vue&type=script&lang=js");
/* harmony import */ var _Users_muhammadnorsyahrinseth_Documents_projects_publishing_system_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_Users_muhammadnorsyahrinseth_Documents_projects_publishing_system_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Edit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Edit_vue_vue_type_template_id_af868e0e__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/Pages/Profile/Edit.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/Pages/Profile/Edit.vue?vue&type=script&lang=js":
/*!*********************************************************************!*\
  !*** ./resources/js/Pages/Profile/Edit.vue?vue&type=script&lang=js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Edit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Edit_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Edit.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Profile/Edit.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/Pages/Profile/Edit.vue?vue&type=template&id=af868e0e":
/*!***************************************************************************!*\
  !*** ./resources/js/Pages/Profile/Edit.vue?vue&type=template&id=af868e0e ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Edit_vue_vue_type_template_id_af868e0e__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Edit_vue_vue_type_template_id_af868e0e__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Edit.vue?vue&type=template&id=af868e0e */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/Pages/Profile/Edit.vue?vue&type=template&id=af868e0e");


/***/ })

}]);