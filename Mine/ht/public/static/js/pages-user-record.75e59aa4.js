(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-record"],{"29d6":function(t,a,e){var i=e("ab93");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=e("4f06").default;n("4cfe89c8",i,!0,{sourceMap:!1,shadowMode:!1})},"2cd3":function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-uni-view",{staticStyle:{height:"100%",overflow:"hidden"}},[e("v-uni-image",{attrs:{src:"../../static/8.png"}}),e("v-uni-view",{staticStyle:{position:"absolute",top:"0",left:"0",height:"100%",width:"100%","overflow-x":"scroll",background:"rgba(0,0,0,0.4)"}},[e("v-uni-view",{staticStyle:{display:"flex","text-align":"center",padding:"3% 0"}},[e("v-uni-view",{class:0==t.tabs?"tab":"",staticStyle:{flex:"1",padding:"3%"},on:{click:function(a){a=t.$handleEvent(a),t.tab(0)}}},[t._v("转让中")]),e("v-uni-view",{class:1==t.tabs?"tab":"",staticStyle:{flex:"1",padding:"3%"},on:{click:function(a){a=t.$handleEvent(a),t.tab(1)}}},[t._v("已完成")])],1),0==t.tabs?e("v-uni-view",t._l(t.array,function(a,i){return e("v-uni-view",{key:i,staticStyle:{display:"flex",padding:"2% 5%","border-bottom":"1px solid#ccc",background:"rgba(0,0,0,0.6)"}},[e("v-uni-view",{staticStyle:{flex:"1"}},[e("v-uni-view",[t._v("级别："+t._s(a.c_name))]),e("v-uni-view",[t._v("金额："+t._s(a.money))])],1),e("v-uni-view",{staticStyle:{flex:"2","text-align":"right"}},[e("v-uni-view",[t._v("转让时间："+t._s(a.create_time))]),e("v-uni-view",[t._v("转让中")])],1)],1)}),1):t._e(),1==t.tabs?e("v-uni-view",t._l(t.array,function(a,i){return e("v-uni-view",{key:i,staticStyle:{display:"flex",padding:"2% 5%","border-bottom":"1px solid#ccc",background:"rgba(0,0,0,0.6)"}},[e("v-uni-view",{staticStyle:{flex:"1"}},[e("v-uni-view",[t._v("级别："+t._s(a.c_name))]),e("v-uni-view",[t._v("金额："+t._s(a.money))])],1),e("v-uni-view",{staticStyle:{flex:"2","text-align":"right"}},[e("v-uni-view",[t._v("完成时间："+t._s(a.shou_time))]),e("v-uni-view",[t._v("已完成")])],1)],1)}),1):t._e()],1)],1)},n=[];e.d(a,"a",function(){return i}),e.d(a,"b",function(){return n})},"2d80":function(t,a,e){"use strict";var i=e("29d6"),n=e.n(i);n.a},"36b2":function(t,a,e){"use strict";e.r(a);var i=e("8336"),n=e.n(i);for(var r in i)"default"!==r&&function(t){e.d(a,t,function(){return i[t]})}(r);a["default"]=n.a},3769:function(t,a,e){"use strict";e.r(a);var i=e("2cd3"),n=e("36b2");for(var r in n)"default"!==r&&function(t){e.d(a,t,function(){return n[t]})}(r);e("2d80");var u=e("2877"),c=Object(u["a"])(n["default"],i["a"],i["b"],!1,null,"ddab10e4",null);a["default"]=c.exports},8336:function(t,a,e){"use strict";Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0;var i=uni.getStorageSync("token")||"",n={data:function(){return{tabs:0,array:[],page:1,is_pay:0}},onLoad:function(){var t=this;this.request("api/Match/match_zhuanrang",{token:i,page:t.page,is_pay:t.is_pay},function(a,e){t.array=a.data})},methods:{tab:function(t){if(this.tabs=t,0==t){var a=this;a.array=[],this.request("api/Match/match_zhuanrang",{token:i,page:a.page,is_pay:0},function(t,e){a.array=t.data})}else{a=this;a.array=[],this.request("api/Match/match_zhuanrang",{token:i,page:a.page,is_pay:1},function(t,e){a.array=t.data})}}}};a.default=n},ab93:function(t,a,e){a=t.exports=e("2350")(!1),a.push([t.i,"uni-page-body[data-v-ddab10e4]{height:100%;color:#fff}.tab[data-v-ddab10e4]{border-bottom:2px solid#40fd2b;color:#40fd2b}",""])}}]);