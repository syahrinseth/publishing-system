(self.webpackChunk=self.webpackChunk||[]).push([[513],{7757:(e,t,r)=>{e.exports=r(5666)},5666:e=>{var t=function(e){"use strict";var t,r=Object.prototype,n=r.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",l=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag";function i(e,t,r){return Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}),e[t]}try{i({},"")}catch(e){i=function(e,t,r){return e[t]=r}}function s(e,t,r,n){var o=t&&t.prototype instanceof v?t:v,a=Object.create(o.prototype),l=new z(n||[]);return a._invoke=function(e,t,r){var n=u;return function(o,a){if(n===m)throw new Error("Generator is already running");if(n===h){if("throw"===o)throw a;return L()}for(r.method=o,r.arg=a;;){var l=r.delegate;if(l){var c=C(l,r);if(c){if(c===f)continue;return c}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===u)throw n=h,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=m;var i=d(e,t,r);if("normal"===i.type){if(n=r.done?h:p,i.arg===f)continue;return{value:i.arg,done:r.done}}"throw"===i.type&&(n=h,r.method="throw",r.arg=i.arg)}}}(e,r,l),a}function d(e,t,r){try{return{type:"normal",arg:e.call(t,r)}}catch(e){return{type:"throw",arg:e}}}e.wrap=s;var u="suspendedStart",p="suspendedYield",m="executing",h="completed",f={};function v(){}function w(){}function g(){}var x={};i(x,a,(function(){return this}));var y=Object.getPrototypeOf,k=y&&y(y(M([])));k&&k!==r&&n.call(k,a)&&(x=k);var V=g.prototype=v.prototype=Object.create(x);function B(e){["next","throw","return"].forEach((function(t){i(e,t,(function(e){return this._invoke(t,e)}))}))}function N(e,t){function r(o,a,l,c){var i=d(e[o],e,a);if("throw"!==i.type){var s=i.arg,u=s.value;return u&&"object"==typeof u&&n.call(u,"__await")?t.resolve(u.__await).then((function(e){r("next",e,l,c)}),(function(e){r("throw",e,l,c)})):t.resolve(u).then((function(e){s.value=e,l(s)}),(function(e){return r("throw",e,l,c)}))}c(i.arg)}var o;this._invoke=function(e,n){function a(){return new t((function(t,o){r(e,n,t,o)}))}return o=o?o.then(a,a):a()}}function C(e,r){var n=e.iterator[r.method];if(n===t){if(r.delegate=null,"throw"===r.method){if(e.iterator.return&&(r.method="return",r.arg=t,C(e,r),"throw"===r.method))return f;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return f}var o=d(n,e.iterator,r.arg);if("throw"===o.type)return r.method="throw",r.arg=o.arg,r.delegate=null,f;var a=o.arg;return a?a.done?(r[e.resultName]=a.value,r.next=e.nextLoc,"return"!==r.method&&(r.method="next",r.arg=t),r.delegate=null,f):a:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,f)}function b(e){var t={tryLoc:e[0]};1 in e&&(t.catchLoc=e[1]),2 in e&&(t.finallyLoc=e[2],t.afterLoc=e[3]),this.tryEntries.push(t)}function E(e){var t=e.completion||{};t.type="normal",delete t.arg,e.completion=t}function z(e){this.tryEntries=[{tryLoc:"root"}],e.forEach(b,this),this.reset(!0)}function M(e){if(e){var r=e[a];if(r)return r.call(e);if("function"==typeof e.next)return e;if(!isNaN(e.length)){var o=-1,l=function r(){for(;++o<e.length;)if(n.call(e,o))return r.value=e[o],r.done=!1,r;return r.value=t,r.done=!0,r};return l.next=l}}return{next:L}}function L(){return{value:t,done:!0}}return w.prototype=g,i(V,"constructor",g),i(g,"constructor",w),w.displayName=i(g,c,"GeneratorFunction"),e.isGeneratorFunction=function(e){var t="function"==typeof e&&e.constructor;return!!t&&(t===w||"GeneratorFunction"===(t.displayName||t.name))},e.mark=function(e){return Object.setPrototypeOf?Object.setPrototypeOf(e,g):(e.__proto__=g,i(e,c,"GeneratorFunction")),e.prototype=Object.create(V),e},e.awrap=function(e){return{__await:e}},B(N.prototype),i(N.prototype,l,(function(){return this})),e.AsyncIterator=N,e.async=function(t,r,n,o,a){void 0===a&&(a=Promise);var l=new N(s(t,r,n,o),a);return e.isGeneratorFunction(r)?l:l.next().then((function(e){return e.done?e.value:l.next()}))},B(V),i(V,c,"Generator"),i(V,a,(function(){return this})),i(V,"toString",(function(){return"[object Generator]"})),e.keys=function(e){var t=[];for(var r in e)t.push(r);return t.reverse(),function r(){for(;t.length;){var n=t.pop();if(n in e)return r.value=n,r.done=!1,r}return r.done=!0,r}},e.values=M,z.prototype={constructor:z,reset:function(e){if(this.prev=0,this.next=0,this.sent=this._sent=t,this.done=!1,this.delegate=null,this.method="next",this.arg=t,this.tryEntries.forEach(E),!e)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=t)},stop:function(){this.done=!0;var e=this.tryEntries[0].completion;if("throw"===e.type)throw e.arg;return this.rval},dispatchException:function(e){if(this.done)throw e;var r=this;function o(n,o){return c.type="throw",c.arg=e,r.next=n,o&&(r.method="next",r.arg=t),!!o}for(var a=this.tryEntries.length-1;a>=0;--a){var l=this.tryEntries[a],c=l.completion;if("root"===l.tryLoc)return o("end");if(l.tryLoc<=this.prev){var i=n.call(l,"catchLoc"),s=n.call(l,"finallyLoc");if(i&&s){if(this.prev<l.catchLoc)return o(l.catchLoc,!0);if(this.prev<l.finallyLoc)return o(l.finallyLoc)}else if(i){if(this.prev<l.catchLoc)return o(l.catchLoc,!0)}else{if(!s)throw new Error("try statement without catch or finally");if(this.prev<l.finallyLoc)return o(l.finallyLoc)}}}},abrupt:function(e,t){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var a=o;break}}a&&("break"===e||"continue"===e)&&a.tryLoc<=t&&t<=a.finallyLoc&&(a=null);var l=a?a.completion:{};return l.type=e,l.arg=t,a?(this.method="next",this.next=a.finallyLoc,f):this.complete(l)},complete:function(e,t){if("throw"===e.type)throw e.arg;return"break"===e.type||"continue"===e.type?this.next=e.arg:"return"===e.type?(this.rval=this.arg=e.arg,this.method="return",this.next="end"):"normal"===e.type&&t&&(this.next=t),f},finish:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.finallyLoc===e)return this.complete(r.completion,r.afterLoc),E(r),f}},catch:function(e){for(var t=this.tryEntries.length-1;t>=0;--t){var r=this.tryEntries[t];if(r.tryLoc===e){var n=r.completion;if("throw"===n.type){var o=n.arg;E(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(e,r,n){return this.delegate={iterator:M(e),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=t),f}},e}(e.exports);try{regeneratorRuntime=t}catch(e){"object"==typeof globalThis?globalThis.regeneratorRuntime=t:Function("r","regeneratorRuntime = r")(t)}},6288:(e,t,r)=>{"use strict";r.d(t,{Z:()=>d});var n=r(821),o={key:0,class:"flex flex-wrap -mb-1"},a=["innerHTML"],l={class:"my-2 flex justify-end"},c={class:"text-gray-600"};var i=r(9038);const s={props:{links:Array,meta:Object},components:{InertiaLink:i.ZQ}};const d=(0,r(3744).Z)(s,[["render",function(e,t,r,i,s,d){var u=(0,n.resolveComponent)("inertia-link");return(0,n.openBlock)(),(0,n.createElementBlock)("div",null,[r.links.length>3?((0,n.openBlock)(),(0,n.createElementBlock)("div",o,[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(r.links,(function(e,t){return(0,n.openBlock)(),(0,n.createElementBlock)(n.Fragment,null,[null===e.url?((0,n.openBlock)(),(0,n.createElementBlock)("div",{key:t,class:"mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded",innerHTML:e.label,"preserve-scroll":""},null,8,a)):((0,n.openBlock)(),(0,n.createBlock)(u,{key:e,class:(0,n.normalizeClass)(["mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500",{"bg-white":e.active}]),href:e.url,innerHTML:e.label,"preserve-scroll":""},null,8,["class","href","innerHTML"]))],64)})),256))])):(0,n.createCommentVNode)("",!0),(0,n.createElementVNode)("div",l,[(0,n.createElementVNode)("small",c,"Showing "+(0,n.toDisplayString)(r.meta.from)+" to "+(0,n.toDisplayString)(r.meta.to)+" of "+(0,n.toDisplayString)(r.meta.total)+" results.",1)])])}]])},1293:(e,t,r)=>{"use strict";r.d(t,{Z:()=>p});var n=r(821),o={class:"flex flex-col"},a={class:"-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"},l={class:"py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"},c={class:"shadow overflow-auto border-b border-gray-200 sm:rounded-lg"},i={class:"w-full divide-y divide-gray-200"},s={class:"bg-gray-50"},d={class:"bg-white divide-y divide-gray-200"};const u={components:{Link:r(9038).rU},setup:function(){return{}}};const p=(0,r(3744).Z)(u,[["render",function(e,t,r,u,p,m){return(0,n.openBlock)(),(0,n.createElementBlock)("div",o,[(0,n.createElementVNode)("div",a,[(0,n.createElementVNode)("div",l,[(0,n.createElementVNode)("div",c,[(0,n.createElementVNode)("table",i,[(0,n.createElementVNode)("thead",s,[(0,n.renderSlot)(e.$slots,"header")]),(0,n.createElementVNode)("tbody",d,[(0,n.renderSlot)(e.$slots,"body")])])])])])])}]])},9513:(e,t,r)=>{"use strict";r.r(t),r.d(t,{default:()=>W});var n=r(821),o={class:"lg:flex lg:items-center lg:justify-between"},a=(0,n.createElementVNode)("div",{class:"flex-1 min-w-0"},[(0,n.createElementVNode)("h2",{class:"text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"}," Manuscript Overview ")],-1),l={class:"mt-5 flex lg:mt-0 lg:ml-4"},c={class:"hidden sm:block ml-3"},i=(0,n.createTextVNode)(" Submit Manuscript "),s=(0,n.createTextVNode)(" More "),d=(0,n.createTextVNode)(" Submit Manuscript "),u={class:"w-full flex"},p={class:"w-64 my-3"},m=(0,n.createElementVNode)("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24"}," # ",-1),h={class:"columns-2"},f=(0,n.createElementVNode)("div",null," Title ",-1),v={class:"columns-2"},w=(0,n.createElementVNode)("div",null," Status ",-1),g={class:"columns-2"},x=(0,n.createElementVNode)("div",null," Modified ",-1),y={class:"columns-2"},k=(0,n.createElementVNode)("div",null," Created ",-1),V=(0,n.createElementVNode)("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"},null,-1),B={class:"px-6 py-4 word-break"},N={class:"flex items-center"},C={class:"ml-4"},b={class:"text-sm font-medium text-gray-900"},E=(0,n.createElementVNode)("div",{class:"text-sm text-gray-500"},null,-1),z={class:"px-6 py-4 word-break text-sm"},M={class:"text-sm text-gray-500"},L={class:"text-gray-900"},S={class:"text-sm text-gray-500"},H={class:"px-6 py-4 word-break text-sm"},I={class:"px-6 py-4 word-break text-sm text-gray-500"},j={class:"px-6 py-4 word-break text-sm text-gray-500"},T={class:"px-6 py-4 word-break text-right text-sm font-medium"},A=(0,n.createTextVNode)("View"),O=["onClick"],D={class:"my-2 flex justify-end"};var P=r(7757),G=r.n(P),F=r(2437),Z=r(1293),U=r(9038),Y=r(3724),Q=r(3789),R=r(6288),q=r(9680);function K(e,t,r,n,o,a,l){try{var c=e[a](l),i=c.value}catch(e){return void r(e)}c.done?t(i):Promise.resolve(i).then(n,o)}function $(e){return function(){var t=this,r=arguments;return new Promise((function(n,o){var a=e.apply(t,r);function l(e){K(a,n,o,l,c,"next",e)}function c(e){K(a,n,o,l,c,"throw",e)}l(void 0)}))}}const J={components:{Pagination:R.Z,Layout:F.Z,Table:Z.Z,Menu:Q.v2,MenuButton:Q.j2,MenuItem:Q.sN,MenuItems:Q.sd,BriefcaseIcon:Y.VpB,CalendarIcon:Y.Que,CheckIcon:Y.nQG,ChevronDownIcon:Y.v4q,CurrencyDollarIcon:Y.UK3,LinkIcon:Y.xPt,LocationMarkerIcon:Y.IS8,PencilIcon:Y.vdY,PlusIcon:Y.pOD,Link:U.rU,SortAscendingIcon:Y.TV4,SortDescendingIcon:Y.mcG},props:{manuscripts:Object,filters:Object,auth:Object,manuscriptStatus:Array},data:function(){return{params:{search:this.filters.search,field:this.filters.field,direction:this.filters.direction}}},watch:{params:{handler:_.debounce($(G().mark((function e(){var t;return G().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:t=_.pickBy(this.params),q.Inertia.get("/admin/manuscripts",t,{replace:!0,preserveState:!0});case 2:case"end":return e.stop()}}),e,this)}))),300),deep:!0}},methods:{sort:function(e){this.params.field=e,this.params.direction="asc"===this.params.direction?"desc":"asc"},deleteManuscript:function(e){return $(G().mark((function t(){var r;return G().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:r=(0,U.cI)({_method:"post"}),confirm('Are you sure to delete "'+e.type.name+'"?')&&r.post("/admin/manuscripts/".concat(e.id,"/destroy"),{preserveScroll:!0});case 2:case"end":return t.stop()}}),t)})))()}},created:function(){var e=this;return $(G().mark((function t(){return G().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:console.log(e.manuscripts);case 1:case"end":return t.stop()}}),t)})))()}};const W=(0,r(3744).Z)(J,[["render",function(e,t,r,_,P,G){var F=(0,n.resolveComponent)("PlusIcon"),Z=(0,n.resolveComponent)("Link"),U=(0,n.resolveComponent)("ChevronDownIcon"),Y=(0,n.resolveComponent)("MenuButton"),Q=(0,n.resolveComponent)("MenuItem"),R=(0,n.resolveComponent)("MenuItems"),q=(0,n.resolveComponent)("Menu"),K=(0,n.resolveComponent)("SortDescendingIcon"),$=(0,n.resolveComponent)("SortAscendingIcon"),J=(0,n.resolveComponent)("Table"),W=(0,n.resolveComponent)("Pagination"),X=(0,n.resolveComponent)("Layout");return(0,n.openBlock)(),(0,n.createBlock)(X,{auth:r.auth.user.data},{header:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",o,[a,(0,n.createElementVNode)("div",l,[(0,n.createElementVNode)("span",c,[(0,n.createVNode)(Z,{href:"/admin/manuscript-create",class:"inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500","preserve-scroll":""},{default:(0,n.withCtx)((function(){return[(0,n.createVNode)(F,{class:"-ml-1 mr-2 h-5 w-5 text-white","aria-hidden":"true"}),i]})),_:1})]),(0,n.createVNode)(q,{as:"span",class:"ml-3 relative sm:hidden"},{default:(0,n.withCtx)((function(){return[(0,n.createVNode)(Y,{class:"inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:(0,n.withCtx)((function(){return[s,(0,n.createVNode)(U,{class:"-mr-1 ml-2 h-5 w-5 text-gray-500","aria-hidden":"true"})]})),_:1}),(0,n.createVNode)(n.Transition,{"enter-active-class":"transition ease-out duration-200","enter-from-class":"transform opacity-0 scale-95","enter-to-class":"transform opacity-100 scale-100","leave-active-class":"transition ease-in duration-75","leave-from-class":"transform opacity-100 scale-100","leave-to-class":"transform opacity-0 scale-95"},{default:(0,n.withCtx)((function(){return[(0,n.createVNode)(R,{class:"origin-top-right absolute mt-2 -mr-1 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"},{default:(0,n.withCtx)((function(){return[(0,n.createVNode)(Q,null,{default:(0,n.withCtx)((function(e){var t=e.active;return[(0,n.createVNode)(Z,{href:"/admin/manuscript-create",class:(0,n.normalizeClass)([t?"bg-gray-100":"","block px-4 py-2 text-sm text-gray-700"]),"preserve-scroll":""},{default:(0,n.withCtx)((function(){return[(0,n.createVNode)(F,{class:"-ml-1 mr-2 h-5 w-5 text-gray-700","aria-hidden":"true"}),d]})),_:2},1032,["class"])]})),_:1})]})),_:1})]})),_:1})]})),_:1})])])]})),default:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",u,[(0,n.createElementVNode)("div",p,[(0,n.withDirectives)((0,n.createElementVNode)("input",{type:"text",name:"search","onUpdate:modelValue":t[0]||(t[0]=function(e){return P.params.search=e}),id:"search",placeholder:"Search",class:"mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"},null,512),[[n.vModelText,P.params.search]])])]),(0,n.createVNode)(J,null,{header:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("tr",null,[m,(0,n.createElementVNode)("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-64 cursor-pointer",onClick:t[1]||(t[1]=function(e){return G.sort("title")})},[(0,n.createElementVNode)("div",h,[f,(0,n.createElementVNode)("div",null,["desc"===P.params.direction&&"title"===P.params.field?((0,n.openBlock)(),(0,n.createBlock)(K,{key:0,class:"-ml-1 mr-2 h-5 w-5 text-gray-500","aria-hidden":"true"})):(0,n.createCommentVNode)("",!0),"asc"===P.params.direction&&"title"===P.params.field?((0,n.openBlock)(),(0,n.createBlock)($,{key:1,class:"-ml-1 mr-2 h-5 w-5 text-gray-500","aria-hidden":"true"})):(0,n.createCommentVNode)("",!0)])])]),(0,n.createElementVNode)("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer",onClick:t[2]||(t[2]=function(e){return G.sort("status")})},[(0,n.createElementVNode)("div",v,[w,(0,n.createElementVNode)("div",null,["desc"===P.params.direction&&"status"===P.params.field?((0,n.openBlock)(),(0,n.createBlock)(K,{key:0,class:"-ml-1 mr-2 h-5 w-5 text-gray-500","aria-hidden":"true"})):(0,n.createCommentVNode)("",!0),"asc"===P.params.direction&&"status"===P.params.field?((0,n.openBlock)(),(0,n.createBlock)($,{key:1,class:"-ml-1 mr-2 h-5 w-5 text-gray-500","aria-hidden":"true"})):(0,n.createCommentVNode)("",!0)])])]),(0,n.createElementVNode)("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer",onClick:t[3]||(t[3]=function(e){return G.sort("updated_at")})},[(0,n.createElementVNode)("div",g,[x,(0,n.createElementVNode)("div",null,["desc"===P.params.direction&&"updated_at"===P.params.field?((0,n.openBlock)(),(0,n.createBlock)(K,{key:0,class:"-ml-1 mr-2 h-5 w-5 text-gray-500","aria-hidden":"true"})):(0,n.createCommentVNode)("",!0),"asc"===P.params.direction&&"updated_at"===P.params.field?((0,n.openBlock)(),(0,n.createBlock)($,{key:1,class:"-ml-1 mr-2 h-5 w-5 text-gray-500","aria-hidden":"true"})):(0,n.createCommentVNode)("",!0)])])]),(0,n.createElementVNode)("th",{scope:"col",class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer",onClick:t[4]||(t[4]=function(e){return G.sort("created_at")})},[(0,n.createElementVNode)("div",y,[k,(0,n.createElementVNode)("div",null,["desc"===P.params.direction&&"created_at"===P.params.field?((0,n.openBlock)(),(0,n.createBlock)(K,{key:0,class:"-ml-1 mr-2 h-5 w-5 text-gray-500","aria-hidden":"true"})):(0,n.createCommentVNode)("",!0),"asc"===P.params.direction&&"created_at"===P.params.field?((0,n.openBlock)(),(0,n.createBlock)($,{key:1,class:"-ml-1 mr-2 h-5 w-5 text-gray-500","aria-hidden":"true"})):(0,n.createCommentVNode)("",!0)])])]),V])]})),body:(0,n.withCtx)((function(){return[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(r.manuscripts.data,(function(e,t){return(0,n.openBlock)(),(0,n.createElementBlock)("tr",{key:e.id},[(0,n.createElementVNode)("td",B,[(0,n.createElementVNode)("div",N,[(0,n.createElementVNode)("div",C,[(0,n.createElementVNode)("div",b,(0,n.toDisplayString)(r.manuscripts.meta.from+t),1),E])])]),(0,n.createElementVNode)("td",z,[(0,n.createElementVNode)("div",M,(0,n.toDisplayString)(e.manuscript_no),1),(0,n.createElementVNode)("p",L,(0,n.toDisplayString)(e.title||"N/a"),1),(0,n.createElementVNode)("div",S,(0,n.toDisplayString)(e.type.name),1)]),(0,n.createElementVNode)("td",H,[(0,n.createElementVNode)("span",{class:(0,n.normalizeClass)(["bg-"+r.manuscriptStatus.filter((function(t){return t.name==e.status}))[0].color+"-600","inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white rounded-full"])},(0,n.toDisplayString)(e.status),3)]),(0,n.createElementVNode)("td",I,(0,n.toDisplayString)(e.updated_at),1),(0,n.createElementVNode)("td",j,(0,n.toDisplayString)(e.created_at_date),1),(0,n.createElementVNode)("td",T,[1==r.auth.user.data.permissions_attribute.manuscripts.edit?((0,n.openBlock)(),(0,n.createBlock)(Z,{key:0,href:"/admin/manuscripts/".concat(e.id,"/edit"),class:"text-indigo-600 hover:text-indigo-900 px-2"},{default:(0,n.withCtx)((function(){return[A]})),_:2},1032,["href"])):(0,n.createCommentVNode)("",!0),1==r.auth.user.data.permissions_attribute.manuscripts.destroy?((0,n.openBlock)(),(0,n.createElementBlock)("a",{key:1,href:"#",onClick:function(t){return G.deleteManuscript(e)},class:"text-indigo-600 hover:text-indigo-900 px-2"},"Delete",8,O)):(0,n.createCommentVNode)("",!0)])])})),128))]})),_:1}),(0,n.createElementVNode)("div",D,[(0,n.createVNode)(W,{links:r.manuscripts.meta.links,meta:r.manuscripts.meta},null,8,["links","meta"])])]})),_:1},8,["auth"])}]])},3724:(e,t,r)=>{"use strict";r.d(t,{js$:()=>o,VpB:()=>a,Que:()=>l,rE2:()=>c,nQG:()=>i,v4q:()=>s,wyc:()=>d,s68:()=>u,UK3:()=>p,j1T:()=>m,YUj:()=>h,YHR:()=>f,_8t:()=>v,SI8:()=>w,xPt:()=>g,IS8:()=>x,khe:()=>y,Oqj:()=>k,fS1:()=>V,Rdq:()=>B,FKb:()=>N,vdY:()=>C,pOD:()=>b,Ta4:()=>E,TV4:()=>z,mcG:()=>M,gV:()=>L,uSF:()=>_,tBG:()=>S,oOx:()=>H});var n=r(821);function o(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z","clip-rule":"evenodd"})])}function a(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z","clip-rule":"evenodd"}),(0,n.createVNode)("path",{d:"M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"})])}function l(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z","clip-rule":"evenodd"})])}function c(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z","clip-rule":"evenodd"})])}function i(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z","clip-rule":"evenodd"})])}function s(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z","clip-rule":"evenodd"})])}function d(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z","clip-rule":"evenodd"})])}function u(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{d:"M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"}),(0,n.createVNode)("path",{d:"M9 13h2v5a1 1 0 11-2 0v-5z"})])}function p(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{d:"M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"}),(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z","clip-rule":"evenodd"})])}function m(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z","clip-rule":"evenodd"})])}function h(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{d:"M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2h-1.528A6 6 0 004 9.528V4z"}),(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M8 10a4 4 0 00-3.446 6.032l-1.261 1.26a1 1 0 101.414 1.415l1.261-1.261A4 4 0 108 10zm-2 4a2 2 0 114 0 2 2 0 01-4 0z","clip-rule":"evenodd"})])}function f(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z","clip-rule":"evenodd"})])}function v(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z","clip-rule":"evenodd"})])}function w(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z","clip-rule":"evenodd"})])}function g(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z","clip-rule":"evenodd"})])}function x(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z","clip-rule":"evenodd"})])}function y(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z","clip-rule":"evenodd"})])}function k(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z","clip-rule":"evenodd"})])}function V(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z","clip-rule":"evenodd"}),(0,n.createVNode)("path",{d:"M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"})])}function B(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{d:"M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"})])}function N(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z","clip-rule":"evenodd"})])}function C(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{d:"M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"})])}function b(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z","clip-rule":"evenodd"})])}function E(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z","clip-rule":"evenodd"})])}function z(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{d:"M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"})])}function M(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{d:"M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"})])}function L(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M5.05 3.636a1 1 0 010 1.414 7 7 0 000 9.9 1 1 0 11-1.414 1.414 9 9 0 010-12.728 1 1 0 011.414 0zm9.9 0a1 1 0 011.414 0 9 9 0 010 12.728 1 1 0 11-1.414-1.414 7 7 0 000-9.9 1 1 0 010-1.414zM7.879 6.464a1 1 0 010 1.414 3 3 0 000 4.243 1 1 0 11-1.415 1.414 5 5 0 010-7.07 1 1 0 011.415 0zm4.242 0a1 1 0 011.415 0 5 5 0 010 7.072 1 1 0 01-1.415-1.415 3 3 0 000-4.242 1 1 0 010-1.415zM10 9a1 1 0 011 1v.01a1 1 0 11-2 0V10a1 1 0 011-1z","clip-rule":"evenodd"})])}function _(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{d:"M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"})])}function S(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z","clip-rule":"evenodd"})])}function H(e,t){return(0,n.openBlock)(),(0,n.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,n.createVNode)("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z","clip-rule":"evenodd"})])}}}]);