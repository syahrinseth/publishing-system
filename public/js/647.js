"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[647],{1293:(e,t,r)=>{r.d(t,{Z:()=>m});var a=r(821),n={class:"flex flex-col"},o={class:"-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"},c={class:"py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"},l={class:"shadow overflow-auto border-b border-gray-200 sm:rounded-lg"},i={class:"w-full divide-y divide-gray-200"},s={class:"bg-gray-50"},d={class:"bg-white divide-y divide-gray-200"};const u={components:{Link:r(9038).rU},setup:function(){return{}}};const m=(0,r(3744).Z)(u,[["render",function(e,t,r,u,m,p){return(0,a.openBlock)(),(0,a.createElementBlock)("div",n,[(0,a.createElementVNode)("div",o,[(0,a.createElementVNode)("div",c,[(0,a.createElementVNode)("div",l,[(0,a.createElementVNode)("table",i,[(0,a.createElementVNode)("thead",s,[(0,a.renderSlot)(e.$slots,"header")]),(0,a.createElementVNode)("tbody",d,[(0,a.renderSlot)(e.$slots,"body")])])])])])])}]])},8647:(e,t,r)=>{r.r(t),r.d(t,{default:()=>M});var a=r(821),n=(0,a.createElementVNode)("title",null,"Home",-1),o=(0,a.createElementVNode)("h2",{class:"text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"}," Dashboard ",-1),c=(0,a.createElementVNode)("h4",{class:"font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate mb-4"},"Overview",-1),l={class:"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-5"},i={class:"flex-shrink-0 self-center"},s={class:"ml-6 pt-1"},d={class:"text-md text-gray-700"},u={class:"text-xl text-gray-500"},m=(0,a.createElementVNode)("h4",{class:"font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate my-4"},"Actions",-1),p=(0,a.createElementVNode)("tr",null,[(0,a.createElementVNode)("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"}," Description "),(0,a.createElementVNode)("th",{class:"px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"})],-1),x={class:"px-6 py-4 word-break"},v={class:"px-6 py-4 word-break"},k=(0,a.createTextVNode)("View"),h={class:"px-6 py-4 word-break"},f={class:"px-6 py-4 word-break"},w=(0,a.createTextVNode)("View"),y={class:"px-6 py-4 word-break"},g={class:"px-6 py-4 word-break"},b=(0,a.createTextVNode)("View"),_={class:"px-6 py-4 word-break"},V={class:"px-6 py-4 word-break"},E=(0,a.createTextVNode)("View"),N={key:0},B=[(0,a.createElementVNode)("td",{colspan:"2",class:"text-center text-gray-600 px-6 py-4"}," No Data ",-1)];var C=r(7518),S=r(9038),D=r(1293);const L={components:{Head:S.Fb,Layout:C.Z,Table:D.Z,Link:S.rU},props:{auth:Object,manuscript_overview:Object,nextSteps:Object},setup:function(e){return{overviewCards:[{name:"Draft Manuscripts",value:e.manuscript_overview.total_draft,link:e.manuscript_overview.total_draft_link,color:"text-gray-700",icon:"fa-file-lines"},{name:"Submit to Editor Manuscripts",value:e.manuscript_overview.total_submit_to_editor,link:e.manuscript_overview.total_submit_to_editor_link,color:"text-blue-700",icon:"fa-file-lines"},{name:"In Review Manuscripts",value:e.manuscript_overview.total_review,link:e.manuscript_overview.total_review_link,color:"text-blue-700",icon:"fa-magnifying-glass"},{name:"Rejected Manuscripts",value:e.manuscript_overview.total_rejected,link:e.manuscript_overview.total_rejected_link,color:"text-red-700",icon:"fa-thumbs-down"},{name:"Approved Manuscripts",value:e.manuscript_overview.total_approved,link:e.manuscript_overview.total_approved_link,color:"text-green-700",icon:"fa-thumbs-up"}]}}};const M=(0,r(3744).Z)(L,[["render",function(e,t,r,C,S,D){var L=(0,a.resolveComponent)("Head"),M=(0,a.resolveComponent)("Link"),j=(0,a.resolveComponent)("Table"),F=(0,a.resolveComponent)("Layout");return(0,a.openBlock)(),(0,a.createElementBlock)("div",null,[(0,a.createVNode)(L,null,{default:(0,a.withCtx)((function(){return[n]})),_:1}),(0,a.createVNode)(F,{auth:r.auth.user.data},{header:(0,a.withCtx)((function(){return[o]})),default:(0,a.withCtx)((function(){return[c,(0,a.createElementVNode)("div",l,[((0,a.openBlock)(!0),(0,a.createElementBlock)(a.Fragment,null,(0,a.renderList)(C.overviewCards,(function(e){return(0,a.openBlock)(),(0,a.createElementBlock)("div",{key:"overview-".concat(e.name),class:"max-w-sm flex p-6 bg-white rounded-lg shadow"},[(0,a.createElementVNode)("div",i,[(0,a.createElementVNode)("i",{class:(0,a.normalizeClass)([[e.icon,e.color],"fa fa-2xl"])},null,2)]),(0,a.createElementVNode)("div",s,[(0,a.createVNode)(M,{href:""==e.link?"#":"/admin/manuscripts?".concat(e.link)},{default:(0,a.withCtx)((function(){return[(0,a.createElementVNode)("h4",d,(0,a.toDisplayString)(e.name),1),(0,a.createElementVNode)("p",u,(0,a.toDisplayString)(e.value),1)]})),_:2},1032,["href"])])])})),128))]),m,(0,a.createVNode)(j,null,{header:(0,a.withCtx)((function(){return[p]})),body:(0,a.withCtx)((function(){return[((0,a.openBlock)(!0),(0,a.createElementBlock)(a.Fragment,null,(0,a.renderList)(r.nextSteps.publisher.data,(function(e,t){return(0,a.openBlock)(),(0,a.createElementBlock)("tr",{key:"step-author-".concat(t)},[(0,a.createElementVNode)("td",x,(0,a.toDisplayString)('Manuscript "'.concat(e.manuscript_no," - ").concat(e.title||e.type.name,'" has been reviewed by reviewers. Please review the manuscript.')),1),(0,a.createElementVNode)("td",v,[1==r.auth.user.data.permissions_attribute.manuscripts.edit?((0,a.openBlock)(),(0,a.createBlock)(M,{key:0,href:"/admin/manuscripts/".concat(e.id,"/edit"),class:"text-indigo-600 hover:text-indigo-900 px-2"},{default:(0,a.withCtx)((function(){return[k]})),_:2},1032,["href"])):(0,a.createCommentVNode)("",!0)])])})),128)),((0,a.openBlock)(!0),(0,a.createElementBlock)(a.Fragment,null,(0,a.renderList)(r.nextSteps.editor.data,(function(e,t){return(0,a.openBlock)(),(0,a.createElementBlock)("tr",{key:"step-author-".concat(t)},[(0,a.createElementVNode)("td",h,(0,a.toDisplayString)('Manuscript "'.concat(e.manuscript_no," - ").concat(e.title||e.type.name,'" is ready to be edit by you. Please review the manuscript.')),1),(0,a.createElementVNode)("td",f,[1==r.auth.user.data.permissions_attribute.manuscripts.edit?((0,a.openBlock)(),(0,a.createBlock)(M,{key:0,href:"/admin/manuscripts/".concat(e.id,"/edit"),class:"text-indigo-600 hover:text-indigo-900 px-2"},{default:(0,a.withCtx)((function(){return[w]})),_:2},1032,["href"])):(0,a.createCommentVNode)("",!0)])])})),128)),((0,a.openBlock)(!0),(0,a.createElementBlock)(a.Fragment,null,(0,a.renderList)(r.nextSteps.reviewer.data,(function(e,t){return(0,a.openBlock)(),(0,a.createElementBlock)("tr",{key:"step-author-".concat(t)},[(0,a.createElementVNode)("td",y,(0,a.toDisplayString)('Manuscript "'.concat(e.manuscript_no," - ").concat(e.title||e.type.name,'" is ready to be review by you. Please review the manuscript.')),1),(0,a.createElementVNode)("td",g,[1==r.auth.user.data.permissions_attribute.manuscripts.edit?((0,a.openBlock)(),(0,a.createBlock)(M,{key:0,href:"/admin/manuscripts/".concat(e.id,"/edit"),class:"text-indigo-600 hover:text-indigo-900 px-2"},{default:(0,a.withCtx)((function(){return[b]})),_:2},1032,["href"])):(0,a.createCommentVNode)("",!0)])])})),128)),((0,a.openBlock)(!0),(0,a.createElementBlock)(a.Fragment,null,(0,a.renderList)(r.nextSteps.author.data,(function(e,t){return(0,a.openBlock)(),(0,a.createElementBlock)("tr",{key:"step-author-".concat(t)},[(0,a.createElementVNode)("td",_,(0,a.toDisplayString)('Manuscript "'.concat(e.manuscript_no," - ").concat(e.title||e.type.name,'" is in status "').concat(e.status,'". Please review the manuscript.')),1),(0,a.createElementVNode)("td",V,[1==r.auth.user.data.permissions_attribute.manuscripts.edit?((0,a.openBlock)(),(0,a.createBlock)(M,{key:0,href:"/admin/manuscripts/".concat(e.id,"/edit"),class:"text-indigo-600 hover:text-indigo-900 px-2"},{default:(0,a.withCtx)((function(){return[E]})),_:2},1032,["href"])):(0,a.createCommentVNode)("",!0)])])})),128)),0==r.nextSteps.author.data.length&&0==r.nextSteps.reviewer.data.length&&0==r.nextSteps.editor.data.length&&0==r.nextSteps.publisher.data.length?((0,a.openBlock)(),(0,a.createElementBlock)("tr",N,B)):(0,a.createCommentVNode)("",!0)]})),_:1})]})),_:1},8,["auth"])])}]])}}]);