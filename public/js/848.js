(self.webpackChunk=self.webpackChunk||[]).push([[848],{7757:(t,e,r)=>{t.exports=r(5666)},5666:t=>{var e=function(t){"use strict";var e,r=Object.prototype,n=r.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},i=o.iterator||"@@iterator",a=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag";function u(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{u({},"")}catch(t){u=function(t,e,r){return t[e]=r}}function s(t,e,r,n){var o=e&&e.prototype instanceof y?e:y,i=Object.create(o.prototype),a=new j(n||[]);return i._invoke=function(t,e,r){var n=f;return function(o,i){if(n===p)throw new Error("Generator is already running");if(n===d){if("throw"===o)throw i;return T()}for(r.method=o,r.arg=i;;){var a=r.delegate;if(a){var c=N(a,r);if(c){if(c===m)continue;return c}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===f)throw n=d,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=p;var u=l(t,e,r);if("normal"===u.type){if(n=r.done?d:h,u.arg===m)continue;return{value:u.arg,done:r.done}}"throw"===u.type&&(n=d,r.method="throw",r.arg=u.arg)}}}(t,r,a),i}function l(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}t.wrap=s;var f="suspendedStart",h="suspendedYield",p="executing",d="completed",m={};function y(){}function v(){}function g(){}var w={};u(w,i,(function(){return this}));var x=Object.getPrototypeOf,b=x&&x(x(O([])));b&&b!==r&&n.call(b,i)&&(w=b);var E=g.prototype=y.prototype=Object.create(w);function L(t){["next","throw","return"].forEach((function(e){u(t,e,(function(t){return this._invoke(e,t)}))}))}function k(t,e){function r(o,i,a,c){var u=l(t[o],t,i);if("throw"!==u.type){var s=u.arg,f=s.value;return f&&"object"==typeof f&&n.call(f,"__await")?e.resolve(f.__await).then((function(t){r("next",t,a,c)}),(function(t){r("throw",t,a,c)})):e.resolve(f).then((function(t){s.value=t,a(s)}),(function(t){return r("throw",t,a,c)}))}c(u.arg)}var o;this._invoke=function(t,n){function i(){return new e((function(e,o){r(t,n,e,o)}))}return o=o?o.then(i,i):i()}}function N(t,r){var n=t.iterator[r.method];if(n===e){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=e,N(t,r),"throw"===r.method))return m;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return m}var o=l(n,t.iterator,r.arg);if("throw"===o.type)return r.method="throw",r.arg=o.arg,r.delegate=null,m;var i=o.arg;return i?i.done?(r[t.resultName]=i.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=e),r.delegate=null,m):i:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,m)}function V(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function _(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function j(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(V,this),this.reset(!0)}function O(t){if(t){var r=t[i];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var o=-1,a=function r(){for(;++o<t.length;)if(n.call(t,o))return r.value=t[o],r.done=!1,r;return r.value=e,r.done=!0,r};return a.next=a}}return{next:T}}function T(){return{value:e,done:!0}}return v.prototype=g,u(E,"constructor",g),u(g,"constructor",v),v.displayName=u(g,c,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===v||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,g):(t.__proto__=g,u(t,c,"GeneratorFunction")),t.prototype=Object.create(E),t},t.awrap=function(t){return{__await:t}},L(k.prototype),u(k.prototype,a,(function(){return this})),t.AsyncIterator=k,t.async=function(e,r,n,o,i){void 0===i&&(i=Promise);var a=new k(s(e,r,n,o),i);return t.isGeneratorFunction(r)?a:a.next().then((function(t){return t.done?t.value:a.next()}))},L(E),u(E,c,"Generator"),u(E,i,(function(){return this})),u(E,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){for(;e.length;){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},t.values=O,j.prototype={constructor:j,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(_),!t)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function o(n,o){return c.type="throw",c.arg=t,r.next=n,o&&(r.method="next",r.arg=e),!!o}for(var i=this.tryEntries.length-1;i>=0;--i){var a=this.tryEntries[i],c=a.completion;if("root"===a.tryLoc)return o("end");if(a.tryLoc<=this.prev){var u=n.call(a,"catchLoc"),s=n.call(a,"finallyLoc");if(u&&s){if(this.prev<a.catchLoc)return o(a.catchLoc,!0);if(this.prev<a.finallyLoc)return o(a.finallyLoc)}else if(u){if(this.prev<a.catchLoc)return o(a.catchLoc,!0)}else{if(!s)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return o(a.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var i=o;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=e&&e<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=t,a.arg=e,i?(this.method="next",this.next=i.finallyLoc,m):this.complete(a)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),m},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),_(r),m}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var o=n.arg;_(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,n){return this.delegate={iterator:O(t),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=e),m}},t}(t.exports);try{regeneratorRuntime=e}catch(t){"object"==typeof globalThis?globalThis.regeneratorRuntime=e:Function("r","regeneratorRuntime = r")(e)}},8848:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>k});var n=r(821),o=(0,n.createElementVNode)("h2",{class:"text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"}," Submit Manuscript ",-1),i={class:"md:grid md:grid-cols-3 md:gap-6"},a=(0,n.createElementVNode)("div",{class:"md:col-span-1"},[(0,n.createElementVNode)("div",{class:"px-4 sm:px-0"},[(0,n.createElementVNode)("h3",{class:"text-lg font-medium leading-6 text-gray-900"},"General Information"),(0,n.createElementVNode)("p",{class:"mt-1 text-sm text-gray-600"}," This information will be displayed publicly so be careful what you share. ")])],-1),c={class:"mt-5 md:mt-0 md:col-span-2"},u={class:"shadow sm:rounded-md sm:overflow-hidden"},s={class:"px-4 py-5 bg-white space-y-6 sm:p-6"},l={class:"grid grid-cols-3 gap-6"},f={class:"col-span-3 sm:col-span-2"},h=(0,n.createElementVNode)("label",{for:"company-website",class:"block text-sm font-medium text-gray-700"}," Article Type ",-1),p=(0,n.createElementVNode)("option",{value:"",selected:""},"Select",-1),d=["value"],m=(0,n.createElementVNode)("div",{class:"px-4 py-3 bg-gray-50 text-right sm:px-6"},[(0,n.createElementVNode)("button",{class:"inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500",type:"submit"}," Proceed ")],-1);var y=r(7757),v=r.n(y),g=r(6729),w=r(9038),x=r(9680);function b(t,e,r,n,o,i,a){try{var c=t[i](a),u=c.value}catch(t){return void r(t)}c.done?e(u):Promise.resolve(u).then(n,o)}function E(t){return function(){var e=this,r=arguments;return new Promise((function(n,o){var i=t.apply(e,r);function a(t){b(i,n,o,a,c,"next",t)}function c(t){b(i,n,o,a,c,"throw",t)}a(void 0)}))}}const L={components:{Layout:g.Z,Link:w.rU},data:function(){return{input:{type:""},types:[]}},methods:{submit:function(){var t=this;return E(v().mark((function e(){return v().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:if(""==t.input.type){e.next=6;break}return e.next=3,window.axios.post("/api/manuscripts",{type:t.input.type}).then((function(t){var e=t.data;x.Inertia.get("/admin/manuscripts/".concat(e.id,"/edit"))})).catch((function(t){alert(t)}));case 3:e.sent,e.next=7;break;case 6:alert("Article Type is required.");case 7:case"end":return e.stop()}}),e)})))()},fetchTypes:function(){return E(v().mark((function t(){var e;return v().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,window.axios.get("/api/manuscript-types");case 2:if(200!=(e=t.sent).status){t.next=5;break}return t.abrupt("return",e.data);case 5:return t.abrupt("return",[]);case 6:case"end":return t.stop()}}),t)})))()}},mounted:function(){var t=this;return E(v().mark((function e(){return v().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.fetchTypes();case 2:t.types=e.sent;case 3:case"end":return e.stop()}}),e)})))()},props:{auth:Object}};const k=(0,r(3744).Z)(L,[["render",function(t,e,r,y,v,g){var w=(0,n.resolveComponent)("Layout");return(0,n.openBlock)(),(0,n.createElementBlock)("div",null,[(0,n.createVNode)(w,{auth:r.auth.user.data},{header:(0,n.withCtx)((function(){return[o]})),default:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("form",{onSubmit:e[1]||(e[1]=(0,n.withModifiers)((function(){return g.submit&&g.submit.apply(g,arguments)}),["prevent"]))},[(0,n.createElementVNode)("div",null,[(0,n.createElementVNode)("div",i,[a,(0,n.createElementVNode)("div",c,[(0,n.createElementVNode)("div",u,[(0,n.createElementVNode)("div",s,[(0,n.createElementVNode)("div",l,[(0,n.createElementVNode)("div",f,[h,(0,n.withDirectives)((0,n.createElementVNode)("select",{name:"company-website",id:"company-website",class:"mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md",placeholder:"www.example.com","onUpdate:modelValue":e[0]||(e[0]=function(t){return v.input.type=t})},[p,((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(v.types,(function(t){return(0,n.openBlock)(),(0,n.createElementBlock)("option",{key:t.id,value:t.id},(0,n.toDisplayString)(t.name),9,d)})),128))],512),[[n.vModelSelect,v.input.type]])])])]),m])])])])],32)]})),_:1},8,["auth"])])}]])}}]);