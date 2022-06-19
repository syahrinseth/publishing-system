"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[673],{8673:(e,t,n)=>{n.r(t),n.d(t,{default:()=>E});var s=n(821),o=(0,s.createElementVNode)("div",{class:"lg:flex lg:items-center lg:justify-between"},[(0,s.createElementVNode)("div",{class:"flex-1 min-w-0"},[(0,s.createElementVNode)("h2",{class:"text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"}," System Settings ")]),(0,s.createElementVNode)("div",{class:"mt-5 flex lg:mt-0 lg:ml-4"})],-1),a={class:"md:grid md:grid-cols-3 md:gap-6"},r=(0,s.createElementVNode)("div",{class:"md:col-span-1"},[(0,s.createElementVNode)("div",{class:"px-4 sm:px-0"},[(0,s.createElementVNode)("h3",{class:"text-lg font-medium leading-6 text-gray-900"},"Manuscript"),(0,s.createElementVNode)("p",{class:"mt-1 text-sm text-gray-600"},"Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, fugit odit incidunt tempora placeat repudiandae voluptatum corporis. Ut quo natus nostrum. Alias voluptas laboriosam obcaecati eum deserunt nesciunt beatae repellendus?")])],-1),i={class:"mt-5 md:mt-0 md:col-span-2"},l={class:"shadow sm:rounded-md sm:overflow-hidden"},d={class:"px-4 py-5 bg-white space-y-6 sm:p-6"},c={class:"col-span-3 sm:col-span-2"},m=["for"],u={class:"mt-1 flex rounded-md shadow-sm"},p=["name","id","onUpdate:modelValue","placeholder"],g=(0,s.createElementVNode)("div",{class:"px-4 py-3 bg-gray-50 text-right sm:px-6"},[(0,s.createElementVNode)("button",{type:"submit",class:"inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},"Save")],-1),f=(0,s.createElementVNode)("div",{class:"hidden sm:block","aria-hidden":"true"},[(0,s.createElementVNode)("div",{class:"py-5"},[(0,s.createElementVNode)("div",{class:"border-t border-gray-200"})])],-1);var v=n(9038),h=n(8590),b=n(2386);const x={components:{Layout:h.Z,Toast:b.Z},methods:{notification:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"success";this.$toast.open({message:e,type:t,duration:5e3,dismissible:!0})},submit:function(){var e=this;this.settingForm.post("/admin/settings",{preserveScroll:!0,onError:function(t){Object.keys(t).forEach((function(n,s){e.notification(t[n],"error")}))},onSuccess:function(t){e.notification("Manuscript Imported.","success")}})}},setup:function(e){for(var t={},n=0;n<e.settings.data.length;n++){var s=e.settings.data[n];t[s.name]=s.value}return{settingForm:(0,v.cI)(t)}},props:{auth:Object,settings:Object}};const E=(0,n(3744).Z)(x,[["render",function(e,t,n,v,h,b){var x=(0,s.resolveComponent)("Layout");return(0,s.openBlock)(),(0,s.createElementBlock)("div",null,[(0,s.createVNode)(x,{auth:n.auth.user.data},{header:(0,s.withCtx)((function(){return[o]})),default:(0,s.withCtx)((function(){return[(0,s.createElementVNode)("div",null,[(0,s.createElementVNode)("div",a,[r,(0,s.createElementVNode)("div",i,[(0,s.createElementVNode)("form",{onSubmit:t[0]||(t[0]=(0,s.withModifiers)((function(){return b.submit&&b.submit.apply(b,arguments)}),["prevent"]))},[(0,s.createElementVNode)("div",l,[(0,s.createElementVNode)("div",d,[((0,s.openBlock)(!0),(0,s.createElementBlock)(s.Fragment,null,(0,s.renderList)(n.settings.data,(function(e){return(0,s.openBlock)(),(0,s.createElementBlock)("div",{key:e.name,class:"grid grid-cols-3 gap-6"},[(0,s.createElementVNode)("div",c,[(0,s.createElementVNode)("label",{for:e.name,class:"block text-sm font-medium text-gray-700"},(0,s.toDisplayString)(e.label),9,m),(0,s.createElementVNode)("div",u,[(0,s.withDirectives)((0,s.createElementVNode)("input",{type:"text",name:e.name,id:e.name,"onUpdate:modelValue":function(t){return v.settingForm[e.name]=t},class:"focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300",placeholder:e.note},null,8,p),[[s.vModelText,v.settingForm[e.name]]])])])])})),128))]),g])],32)])])]),f]})),_:1},8,["auth"])])}]])}}]);