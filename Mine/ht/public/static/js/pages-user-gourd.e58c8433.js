(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-gourd"],{"06ef":function(t,e,i){"use strict";var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticStyle:{height:"100%",overflow:"hidden"}},[i("v-uni-image",{attrs:{src:"../../static/8.png"}}),i("v-uni-view",{staticStyle:{position:"absolute",top:"0",left:"0",height:"100%",width:"100%","overflow-x":"scroll",background:"rgba(0,0,0,0.4)"}},[i("v-uni-view",{staticStyle:{width:"250upx",height:"250upx",margin:"5% auto 0 auto"}},[i("v-uni-image",{attrs:{src:"../../static/yeye.png"}})],1),i("v-uni-view",{staticStyle:{"text-align":"center"}},[t._v("ID:"+t._s(t.info.username))]),i("v-uni-view",{staticStyle:{"text-align":"center"}},[t._v("普通用户："+t._s(t.info.staticmoney))]),i("v-uni-view",{staticStyle:{height:"70%","overflow-x":"scroll"}},t._l(t.array,function(e,n){return i("v-uni-view",{key:n,staticStyle:{display:"flex",padding:"2% 5%","border-bottom":"1px solid#ccc",background:"rgba(0,0,0,0.6)"}},[i("v-uni-view",{staticStyle:{flex:"1.5"}},[i("v-uni-view",[t._v(t._s(e.money))]),i("v-uni-view",[t._v(t._s(e.remark))])],1),i("v-uni-view",{staticStyle:{flex:"2","text-align":"right"}},[i("v-uni-view",[t._v("时间："+t._s(e.createtime))]),i("v-uni-view")],1)],1)}),1)],1),i("v-uni-view",{staticStyle:{background:"none",height:"10upx",width:"100%",position:"absolute",bottom:"-10upx"}})],1)},a=[];i.d(e,"a",function(){return n}),i.d(e,"b",function(){return a})},1663:function(t,e,i){"use strict";i.r(e);var n=i("64a5"),a=i.n(n);for(var o in n)"default"!==o&&function(t){i.d(e,t,function(){return n[t]})}(o);e["default"]=a.a},"2a3b":function(t,e,i){"use strict";var n=i("bc75"),a=i.n(n);a.a},"64a5":function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=uni.getStorageSync("token")||"",a={data:function(){return{array:[],page:1,type:"staticmoney",info:[]}},onLoad:function(){var t=this;this.request("api/User/queryhistory",{token:n,page:t.page,type:t.type},function(e,i){t.array=e.data}),this.request("api/User/get_user_info",{token:n},function(e,i){t.info=e.data})},methods:{},onReachBottom:function(){console.log("加载...")}};e.default=a},"8f3f":function(t,e,i){"use strict";i.r(e);var n=i("06ef"),a=i("1663");for(var o in a)"default"!==o&&function(t){i.d(e,t,function(){return a[t]})}(o);i("2a3b");var r=i("2877"),u=Object(r["a"])(a["default"],n["a"],n["b"],!1,null,"e4dfb966",null);e["default"]=u.exports},bc75:function(t,e,i){var n=i("cf55");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("8342f264",n,!0,{sourceMap:!1,shadowMode:!1})},cf55:function(t,e,i){e=t.exports=i("2350")(!1),e.push([t.i,"uni-page-body[data-v-e4dfb966]{height:100%;color:#fff}.tab[data-v-e4dfb966]{border-bottom:2px solid#40fd2b;color:#40fd2b}",""])}}]);