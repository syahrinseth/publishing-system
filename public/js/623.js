"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[623],{9623:(e,r,o)=>{o.r(r),o.d(r,{default:()=>z});var t=o(821),a=(0,t.createElementVNode)("title",null,"Register",-1),l={class:"h-full"},n={class:"min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"},d={class:"max-w-md w-full space-y-8"},i=(0,t.createStaticVNode)('<div><a href="/"><img class="mx-auto h-16 w-auto" src="/img/logo.png" alt="Workflow"></a><h2 class="text-center text-3xl font-extrabold text-gray-900"> Journal of Smart Sensor and Materials (JSSM) </h2><div class="hidden sm:block" aria-hidden="true"><div class="py-5"><div class="border-t border-gray-200"></div></div></div><h2 class="text-center text-2xl font-extrabold text-gray-900">Sign Up</h2></div>',1),c=(0,t.createElementVNode)("input",{type:"hidden",name:"remember",value:"true"},null,-1),s={class:"rounded-md shadow-sm -space-y-px"},u=(0,t.createElementVNode)("label",{for:"name-address",class:"sr-only"},"Name",-1),v=(0,t.createElementVNode)("label",{for:"email-address",class:"sr-only"},"Email address",-1),p=(0,t.createElementVNode)("label",{for:"password",class:"sr-only"},"Password",-1),f=(0,t.createElementVNode)("label",{for:"confirm-password",class:"sr-only"},"Confirm Password",-1),m=(0,t.createStaticVNode)('<button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"><span class="absolute left-0 inset-y-0 flex items-center pl-3"></span> Sign Up </button><div class="flex justify-center items-center"><div class="border-t flex-1"></div><div class="p-2 text-gray-400">or</div><div class="border-t flex-1"></div></div>',2),w={class:"absolute left-0 inset-y-0 flex items-center pl-3"},h=(0,t.createTextVNode)(" Login ");var g=o(4031),x=o(9038),V=o(3724),B=o(2386);const k={components:{LockClosedIcon:V.khe,Head:x.Fb,Layout:g.Z,useForm:x.cI,Link:x.rU,Toast:B.Z},methods:{notification:function(e){var r=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"success";this.$toast.open({message:e,type:r,duration:5e3,dismissible:!0})},onSubmit:function(){var e=this;this.registerForm.post("register",{preserveScroll:!0,onError:function(r){Object.keys(r).forEach((function(o,t){e.notification(r[o],"error")}))},onSuccess:function(r){e.notification("Registered.")}})}},setup:function(e){return{registerForm:(0,x.cI)({name:null,email:null,password:null,password_confirmation:null})}},props:{auth:Object}};const z=(0,o(3744).Z)(k,[["render",function(e,r,o,g,x,V){var B=(0,t.resolveComponent)("Head"),k=(0,t.resolveComponent)("LockClosedIcon"),z=(0,t.resolveComponent)("Link");return(0,t.openBlock)(),(0,t.createElementBlock)("div",null,[(0,t.createVNode)(B,null,{default:(0,t.withCtx)((function(){return[a]})),_:1}),(0,t.createElementVNode)("div",l,[(0,t.createElementVNode)("div",n,[(0,t.createElementVNode)("div",d,[i,(0,t.createElementVNode)("form",{class:"mt-8 space-y-6",onSubmit:r[4]||(r[4]=(0,t.withModifiers)((function(e){return V.onSubmit()}),["prevent"]))},[c,(0,t.createElementVNode)("div",s,[(0,t.createElementVNode)("div",null,[u,(0,t.withDirectives)((0,t.createElementVNode)("input",{"onUpdate:modelValue":r[0]||(r[0]=function(e){return g.registerForm.name=e}),id:"name-address",name:"name",type:"name",autocomplete:"name",required:"",class:"appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm",placeholder:"Name"},null,512),[[t.vModelText,g.registerForm.name]])]),(0,t.createElementVNode)("div",null,[v,(0,t.withDirectives)((0,t.createElementVNode)("input",{"onUpdate:modelValue":r[1]||(r[1]=function(e){return g.registerForm.email=e}),id:"email-address",name:"email",type:"email",autocomplete:"email",required:"",class:"appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm",placeholder:"Email address"},null,512),[[t.vModelText,g.registerForm.email]])]),(0,t.createElementVNode)("div",null,[p,(0,t.withDirectives)((0,t.createElementVNode)("input",{"onUpdate:modelValue":r[2]||(r[2]=function(e){return g.registerForm.password=e}),id:"password",name:"password",type:"password",autocomplete:"current-password",required:"",class:"appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm",placeholder:"Password"},null,512),[[t.vModelText,g.registerForm.password]])]),(0,t.createElementVNode)("div",null,[f,(0,t.withDirectives)((0,t.createElementVNode)("input",{"onUpdate:modelValue":r[3]||(r[3]=function(e){return g.registerForm.password_confirmation=e}),id:"confirm-password",name:"password_confirmation",type:"password",autocomplete:"current-confirm-password",required:"",class:"appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm",placeholder:"Confirm Password"},null,512),[[t.vModelText,g.registerForm.password_confirmation]])])]),(0,t.createElementVNode)("div",null,[m,(0,t.createVNode)(z,{href:"/login",class:"group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"},{default:(0,t.withCtx)((function(){return[(0,t.createElementVNode)("span",w,[(0,t.createVNode)(k,{class:"h-5 w-5 text-gray-500 group-hover:text-gray-400","aria-hidden":"true"})]),h]})),_:1})])],32)])])])])}]])},3724:(e,r,o)=>{o.d(r,{js$:()=>a,VpB:()=>l,Que:()=>n,rE2:()=>d,nQG:()=>i,v4q:()=>c,s68:()=>s,UK3:()=>u,j1T:()=>v,YUj:()=>p,YHR:()=>f,_8t:()=>m,SI8:()=>w,xPt:()=>h,IS8:()=>g,khe:()=>x,Oqj:()=>V,fS1:()=>B,Rdq:()=>k,FKb:()=>z,vdY:()=>N,pOD:()=>b,gV:()=>y,tBG:()=>M,oOx:()=>C});var t=o(821);function a(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z","clip-rule":"evenodd"})])}function l(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z","clip-rule":"evenodd"}),(0,t.createVNode)("path",{d:"M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"})])}function n(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z","clip-rule":"evenodd"})])}function d(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z","clip-rule":"evenodd"})])}function i(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z","clip-rule":"evenodd"})])}function c(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z","clip-rule":"evenodd"})])}function s(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{d:"M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"}),(0,t.createVNode)("path",{d:"M9 13h2v5a1 1 0 11-2 0v-5z"})])}function u(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{d:"M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"}),(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z","clip-rule":"evenodd"})])}function v(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z","clip-rule":"evenodd"})])}function p(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{d:"M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2h-1.528A6 6 0 004 9.528V4z"}),(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M8 10a4 4 0 00-3.446 6.032l-1.261 1.26a1 1 0 101.414 1.415l1.261-1.261A4 4 0 108 10zm-2 4a2 2 0 114 0 2 2 0 01-4 0z","clip-rule":"evenodd"})])}function f(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z","clip-rule":"evenodd"})])}function m(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z","clip-rule":"evenodd"})])}function w(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z","clip-rule":"evenodd"})])}function h(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z","clip-rule":"evenodd"})])}function g(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z","clip-rule":"evenodd"})])}function x(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z","clip-rule":"evenodd"})])}function V(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z","clip-rule":"evenodd"})])}function B(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z","clip-rule":"evenodd"}),(0,t.createVNode)("path",{d:"M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"})])}function k(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{d:"M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"})])}function z(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z","clip-rule":"evenodd"})])}function N(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{d:"M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"})])}function b(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z","clip-rule":"evenodd"})])}function y(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M5.05 3.636a1 1 0 010 1.414 7 7 0 000 9.9 1 1 0 11-1.414 1.414 9 9 0 010-12.728 1 1 0 011.414 0zm9.9 0a1 1 0 011.414 0 9 9 0 010 12.728 1 1 0 11-1.414-1.414 7 7 0 000-9.9 1 1 0 010-1.414zM7.879 6.464a1 1 0 010 1.414 3 3 0 000 4.243 1 1 0 11-1.415 1.414 5 5 0 010-7.07 1 1 0 011.415 0zm4.242 0a1 1 0 011.415 0 5 5 0 010 7.072 1 1 0 01-1.415-1.415 3 3 0 000-4.242 1 1 0 010-1.415zM10 9a1 1 0 011 1v.01a1 1 0 11-2 0V10a1 1 0 011-1z","clip-rule":"evenodd"})])}function M(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z","clip-rule":"evenodd"})])}function C(e,r){return(0,t.openBlock)(),(0,t.createBlock)("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[(0,t.createVNode)("path",{"fill-rule":"evenodd",d:"M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z","clip-rule":"evenodd"})])}}}]);