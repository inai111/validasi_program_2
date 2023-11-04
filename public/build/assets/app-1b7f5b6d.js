var Ce=(l,c)=>()=>(c||l((c={exports:{}}).exports,c),c.exports);import{a as Ne}from"./axios-82afda87.js";var we=Ce((T,J)=>{window.axios=Ne;window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";/*!
 * AdminLTE v4.0.0-alpha3 (https://adminlte.io)
 * Copyright 2014-2023 Colorlib <https://colorlib.com>
 * Licensed under MIT (https://github.com/ColorlibHQ/AdminLTE/blob/master/LICENSE)
 */(function(l,c){typeof T=="object"&&typeof J<"u"?c(T):typeof define=="function"&&define.amd?define(["exports"],c):(l=typeof globalThis<"u"?globalThis:l||self,c(l.adminlte={}))})(globalThis,function(l){const c=[],d=t=>{document.readyState==="loading"?(c.length||document.addEventListener("DOMContentLoaded",()=>{for(const e of c)e()}),c.push(t)):t()},h=(t,e=500)=>{t.style.transitionProperty="height, margin, padding",t.style.transitionDuration=`${e}ms`,t.style.boxSizing="border-box",t.style.height=`${t.offsetHeight}px`,t.style.overflow="hidden",window.setTimeout(()=>{t.style.height="0",t.style.paddingTop="0",t.style.paddingBottom="0",t.style.marginTop="0",t.style.marginBottom="0"},1),window.setTimeout(()=>{t.style.display="none",t.style.removeProperty("height"),t.style.removeProperty("padding-top"),t.style.removeProperty("padding-bottom"),t.style.removeProperty("margin-top"),t.style.removeProperty("margin-bottom"),t.style.removeProperty("overflow"),t.style.removeProperty("transition-duration"),t.style.removeProperty("transition-property")},e)},b=(t,e=500)=>{t.style.removeProperty("display");let{display:n}=window.getComputedStyle(t);n==="none"&&(n="block"),t.style.display=n;const s=t.offsetHeight;t.style.overflow="hidden",t.style.height="0",t.style.paddingTop="0",t.style.paddingBottom="0",t.style.marginTop="0",t.style.marginBottom="0",window.setTimeout(()=>{t.style.boxSizing="border-box",t.style.transitionProperty="height, margin, padding",t.style.transitionDuration=`${e}ms`,t.style.height=`${s}px`,t.style.removeProperty("padding-top"),t.style.removeProperty("padding-bottom"),t.style.removeProperty("margin-top"),t.style.removeProperty("margin-bottom")},1),window.setTimeout(()=>{t.style.removeProperty("height"),t.style.removeProperty("overflow"),t.style.removeProperty("transition-duration"),t.style.removeProperty("transition-property")},e)};/**
 * --------------------------------------------
 * @file AdminLTE layout.ts
 * @description Layout for AdminLTE.
 * @license MIT
 * --------------------------------------------
 */const D="hold-transition",Q="app-loaded";class C{constructor(e){this._element=e}holdTransition(){let e;window.addEventListener("resize",()=>{document.body.classList.add(D),clearTimeout(e),e=setTimeout(()=>{document.body.classList.remove(D)},400)})}}d(()=>{new C(document.body).holdTransition(),setTimeout(()=>{document.body.classList.add(Q)},400)});/**
 * --------------------------------------------
 * @file AdminLTE push-menu.ts
 * @description Push menu for AdminLTE.
 * @license MIT
 * --------------------------------------------
 */const N=".lte.push-menu",ee=`open${N}`,te=`collapse${N}`,w="sidebar-mini",v="sidebar-collapse",O="sidebar-open",P="sidebar-expand",ne="sidebar-overlay",se="menu-open",oe=".app-sidebar",ie=".sidebar-menu",ae=".nav-item",le=".nav-treeview",ce=".app-wrapper",de=`[class*="${P}"]`,$='[data-lte-toggle="sidebar"]',r={sidebarBreakpoint:992};class E{constructor(e,n){this._element=e,this._config=Object.assign(Object.assign({},r),n)}menusClose(){document.querySelectorAll(le).forEach(o=>{o.style.removeProperty("display"),o.style.removeProperty("height")});const n=document.querySelector(ie),s=n==null?void 0:n.querySelectorAll(ae);s&&s.forEach(o=>{o.classList.remove(se)})}expand(){const e=new Event(ee);document.body.classList.remove(v),document.body.classList.add(O),this._element.dispatchEvent(e)}collapse(){const e=new Event(te);document.body.classList.remove(O),document.body.classList.add(v),this._element.dispatchEvent(e)}addSidebarBreakPoint(){var e,n,s;const o=(n=(e=document.querySelector(de))===null||e===void 0?void 0:e.classList)!==null&&n!==void 0?n:[],i=(s=Array.from(o).find(De=>De.startsWith(P)))!==null&&s!==void 0?s:"",a=document.getElementsByClassName(i)[0],u=window.getComputedStyle(a,"::before").getPropertyValue("content");this._config=Object.assign(Object.assign({},this._config),{sidebarBreakpoint:Number(u.replace(/[^\d.-]/g,""))}),window.innerWidth<=this._config.sidebarBreakpoint?this.collapse():(document.body.classList.contains(w)||this.expand(),document.body.classList.contains(w)&&document.body.classList.contains(v)&&this.collapse())}toggle(){document.body.classList.contains(v)?this.expand():this.collapse()}init(){this.addSidebarBreakPoint()}}d(()=>{var t;const e=document==null?void 0:document.querySelector(oe);if(e){const o=new E(e,r);o.init(),window.addEventListener("resize",()=>{o.init()})}const n=document.createElement("div");n.className=ne,(t=document.querySelector(ce))===null||t===void 0||t.append(n),n.addEventListener("touchstart",o=>{o.preventDefault();const i=o.currentTarget;new E(i,r).collapse()}),n.addEventListener("click",o=>{o.preventDefault();const i=o.currentTarget;new E(i,r).collapse()}),document.querySelectorAll($).forEach(o=>{o.addEventListener("click",i=>{i.preventDefault();let a=i.currentTarget;(a==null?void 0:a.dataset.lteToggle)!=="sidebar"&&(a=a==null?void 0:a.closest($)),a&&(i==null||i.preventDefault(),new E(a,r).toggle())})})});/**
 * --------------------------------------------
 * @file AdminLTE treeview.ts
 * @description Treeview plugin for AdminLTE.
 * @license MIT
 * --------------------------------------------
 */const M=".lte.treeview",re=`expanded${M}`,Ee=`collapsed${M}`,m="menu-open",R=".nav-item",me=".nav-link",S=".nav-treeview",_e='[data-lte-toggle="treeview"]',I={animationSpeed:300,accordion:!0};class x{constructor(e,n){this._element=e,this._config=Object.assign(Object.assign({},I),n)}open(){var e,n;const s=new Event(re);if(this._config.accordion){const i=(e=this._element.parentElement)===null||e===void 0?void 0:e.querySelectorAll(`${R}.${m}`);i==null||i.forEach(a=>{if(a!==this._element.parentElement){a.classList.remove(m);const u=a==null?void 0:a.querySelector(S);u&&h(u,this._config.animationSpeed)}})}this._element.classList.add(m);const o=(n=this._element)===null||n===void 0?void 0:n.querySelector(S);o&&b(o,this._config.animationSpeed),this._element.dispatchEvent(s)}close(){var e;const n=new Event(Ee);this._element.classList.remove(m);const s=(e=this._element)===null||e===void 0?void 0:e.querySelector(S);s&&h(s,this._config.animationSpeed),this._element.dispatchEvent(n)}toggle(){this._element.classList.contains(m)?this.close():this.open()}}d(()=>{document.querySelectorAll(_e).forEach(e=>{e.addEventListener("click",n=>{const s=n.target,o=s.closest(R),i=s.closest(me);((s==null?void 0:s.getAttribute("href"))==="#"||(i==null?void 0:i.getAttribute("href"))==="#")&&n.preventDefault(),o&&new x(o,I).toggle()})})});/**
 * --------------------------------------------
 * @file AdminLTE direct-chat.ts
 * @description Direct chat for AdminLTE.
 * @license MIT
 * --------------------------------------------
 */const q=".lte.direct-chat",pe=`expanded${q}`,ue=`collapsed${q}`,he='[data-lte-toggle="chat-pane"]',ve=".direct-chat",A="direct-chat-contacts-open";class B{constructor(e){this._element=e}toggle(){if(this._element.classList.contains(A)){const e=new Event(ue);this._element.classList.remove(A),this._element.dispatchEvent(e)}else{const e=new Event(pe);this._element.classList.add(A),this._element.dispatchEvent(e)}}}d(()=>{document.querySelectorAll(he).forEach(e=>{e.addEventListener("click",n=>{n.preventDefault();const o=n.target.closest(ve);o&&new B(o).toggle()})})});/**
 * --------------------------------------------
 * @file AdminLTE card-widget.ts
 * @description Card widget for AdminLTE.
 * @license MIT
 * --------------------------------------------
 */const _=".lte.card-widget",ye=`collapsed${_}`,fe=`expanded${_}`,Le=`remove${_}`,Se=`maximized${_}`,Ae=`minimized${_}`,V="card",y="collapsed-card",z="collapsing-card",k="expanding-card",g="was-collapsed",p="maximized-card",Y='[data-lte-toggle="card-remove"]',K='[data-lte-toggle="card-collapse"]',X='[data-lte-toggle="card-maximize"]',ge=`.${V}`,F=".card-body",G=".card-footer",f={animationSpeed:500,collapseTrigger:K,removeTrigger:Y,maximizeTrigger:X};class L{constructor(e,n){this._element=e,this._parent=e.closest(ge),e.classList.contains(V)&&(this._parent=e),this._config=Object.assign(Object.assign({},f),n)}collapse(){var e,n;const s=new Event(ye);this._parent&&(this._parent.classList.add(z),((e=this._parent)===null||e===void 0?void 0:e.querySelectorAll(`${F}, ${G}`)).forEach(i=>{i instanceof HTMLElement&&h(i,this._config.animationSpeed)}),setTimeout(()=>{this._parent&&(this._parent.classList.add(y),this._parent.classList.remove(z))},this._config.animationSpeed)),(n=this._element)===null||n===void 0||n.dispatchEvent(s)}expand(){var e,n;const s=new Event(fe);this._parent&&(this._parent.classList.add(k),((e=this._parent)===null||e===void 0?void 0:e.querySelectorAll(`${F}, ${G}`)).forEach(i=>{i instanceof HTMLElement&&b(i,this._config.animationSpeed)}),setTimeout(()=>{this._parent&&(this._parent.classList.remove(y),this._parent.classList.remove(k))},this._config.animationSpeed)),(n=this._element)===null||n===void 0||n.dispatchEvent(s)}remove(){var e;const n=new Event(Le);this._parent&&h(this._parent,this._config.animationSpeed),(e=this._element)===null||e===void 0||e.dispatchEvent(n)}toggle(){var e;if(!((e=this._parent)===null||e===void 0)&&e.classList.contains(y)){this.expand();return}this.collapse()}maximize(){var e;const n=new Event(Se);this._parent&&(this._parent.style.height=`${this._parent.offsetHeight}px`,this._parent.style.width=`${this._parent.offsetWidth}px`,this._parent.style.transition="all .15s",setTimeout(()=>{const s=document.querySelector("html");s&&s.classList.add(p),this._parent&&(this._parent.classList.add(p),this._parent.classList.contains(y)&&this._parent.classList.add(g))},150)),(e=this._element)===null||e===void 0||e.dispatchEvent(n)}minimize(){var e;const n=new Event(Ae);this._parent&&(this._parent.style.height="auto",this._parent.style.width="auto",this._parent.style.transition="all .15s",setTimeout(()=>{var s;const o=document.querySelector("html");o&&o.classList.remove(p),this._parent&&(this._parent.classList.remove(p),!((s=this._parent)===null||s===void 0)&&s.classList.contains(g)&&this._parent.classList.remove(g))},10)),(e=this._element)===null||e===void 0||e.dispatchEvent(n)}toggleMaximize(){var e;if(!((e=this._parent)===null||e===void 0)&&e.classList.contains(p)){this.minimize();return}this.maximize()}}d(()=>{document.querySelectorAll(K).forEach(s=>{s.addEventListener("click",o=>{o.preventDefault();const i=o.target;new L(i,f).toggle()})}),document.querySelectorAll(Y).forEach(s=>{s.addEventListener("click",o=>{o.preventDefault();const i=o.target;new L(i,f).remove()})}),document.querySelectorAll(X).forEach(s=>{s.addEventListener("click",o=>{o.preventDefault();const i=o.target;new L(i,f).toggleMaximize()})})});/**
 * --------------------------------------------
 * @file AdminLTE fullscreen.ts
 * @description Fullscreen plugin for AdminLTE.
 * @license MIT
 * --------------------------------------------
 */const W=".lte.fullscreen",Te=`maximized${W}`,be=`minimized${W}`,j='[data-lte-toggle="fullscreen"]',H='[data-lte-icon="maximize"]',Z='[data-lte-icon="minimize"]';class U{constructor(e,n){this._element=e,this._config=n}inFullScreen(){const e=new Event(Te),n=document.querySelector(H),s=document.querySelector(Z);document.documentElement.requestFullscreen(),n&&(n.style.display="none"),s&&(s.style.display="block"),this._element.dispatchEvent(e)}outFullscreen(){const e=new Event(be),n=document.querySelector(H),s=document.querySelector(Z);document.exitFullscreen(),n&&(n.style.display="block"),s&&(s.style.display="none"),this._element.dispatchEvent(e)}toggleFullScreen(){document.fullscreenEnabled&&(document.fullscreenElement?this.outFullscreen():this.inFullScreen())}}d(()=>{document.querySelectorAll(j).forEach(e=>{e.addEventListener("click",n=>{n.preventDefault();const o=n.target.closest(j);o&&new U(o,void 0).toggleFullScreen()})})}),l.CardWidget=L,l.DirectChat=B,l.FullScreen=U,l.Layout=C,l.PushMenu=E,l.Treeview=x})});export default we();
