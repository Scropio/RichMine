(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-auth-login"],{"010e":function(t,n,i){"use strict";var a=i("76f8"),e=i.n(a);e.a},"09b1":function(t,n,i){"use strict";i.r(n);var a=i("b333"),e=i.n(a);for(var o in a)"default"!==o&&function(t){i.d(n,t,function(){return a[t]})}(o);n["default"]=e.a},"1db5":function(t,n,i){"use strict";i.r(n);var a=i("7342"),e=i("09b1");for(var o in e)"default"!==o&&function(t){i.d(n,t,function(){return e[t]})}(o);i("010e");var s=i("2877"),u=Object(s["a"])(e["default"],a["a"],a["b"],!1,null,"12b5d2a1",null);n["default"]=u.exports},"4f84":function(t,n,i){n=t.exports=i("2350")(!1),n.push([t.i,"uni-page-body[data-v-12b5d2a1]{height:100%;overflow:hidden}.uni-page-foot[data-v-12b5d2a1]{color:#7a7e83;padding:%?10?%;text-align:center;margin-top:%?10?%}.with-fun[data-v-12b5d2a1]{opacity:.7}.logo[data-v-12b5d2a1]{margin:%?40?% 0;width:%?200?%;height:%?200?%}.unibot[data-v-12b5d2a1]{background:-webkit-gradient(linear,left top,left bottom,from(#a9ff02),to(#69c108));background:-o-linear-gradient(#a9ff02,#69c108);background:linear-gradient(#a9ff02,#69c108);height:%?80?%;width:70%;margin:20% auto;overflow:hidden;text-align:center;border-radius:50px;color:#fff;line-height:0;font-size:%?32?%}.unibott[data-v-12b5d2a1]{height:%?75?%;background:#fff;border-radius:50%;margin-top:%?-35?%;opacity:.4}",""])},7342:function(t,n,i){"use strict";var a=function(){var t=this,n=t.$createElement,i=t._self._c||n;return i("v-uni-view",{staticStyle:{width:"100%",height:"100%"}},[i("v-uni-view",{staticStyle:{width:"100%",height:"100%"}},[i("v-uni-image",{attrs:{src:"../../static/login.png"}})],1),i("v-uni-view",{staticStyle:{position:"absolute",top:"0%",width:"100%"}},[i("v-uni-view",{staticClass:"uni-center",staticStyle:{"padding-top":"200upx"}},[i("v-uni-view",{staticStyle:{height:"280upx"}})],1),i("v-uni-view",{staticClass:"uni-common-mt",staticStyle:{padding:"0 10%"}},[i("v-uni-view",{staticClass:"uni-form-item uni-column"},[i("v-uni-view",{staticClass:"with-fun",staticStyle:{background:"none",color:"#fff"}},[i("v-uni-text",{staticStyle:{"font-size":"32upx"}},[t._v("账号：")]),i("v-uni-input",{staticClass:"uni-input",staticStyle:{padding:"0 5%",background:"none","border-bottom":"1px solid#fff"},model:{value:t.username,callback:function(n){t.username=n},expression:"username"}})],1)],1),i("v-uni-view",{staticClass:"uni-form-item uni-column",staticStyle:{"margin-top":"5%"}},[i("v-uni-view",{staticClass:"with-fun",staticStyle:{background:"none",color:"#fff"}},[i("v-uni-text",{staticStyle:{"font-size":"32upx"}},[t._v("密码：")]),i("v-uni-input",{staticClass:"uni-input",staticStyle:{padding:"0 5%",background:"none","border-bottom":"1px solid#fff"},attrs:{type:"password"},model:{value:t.password,callback:function(n){t.password=n},expression:"password"}})],1)],1),i("v-uni-view",{staticClass:"unibot",staticStyle:{margin:"8% auto"},on:{click:function(n){n=t.$handleEvent(n),t.loginAC(n)}}},[i("v-uni-view",{staticClass:"unibott"}),t._v("登陆")],1),i("v-uni-view",{staticClass:"uni-page-foot"},[i("v-uni-navigator",{staticStyle:{display:"inline-block","margin-right":"5px",color:"#FFFFFF"},attrs:{url:"forgetpwd"}},[t._v("找回密码")]),i("v-uni-navigator",{staticStyle:{display:"inline-block","margin-left":"5px",color:"#FFFFFF"},attrs:{url:"register?type=0"}},[t._v("| 立即注册")])],1)],1)],1)],1)},e=[];i.d(n,"a",function(){return a}),i.d(n,"b",function(){return e})},"76f8":function(t,n,i){var a=i("4f84");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var e=i("4f06").default;e("1eeb008f",a,!0,{sourceMap:!1,shadowMode:!1})},b333:function(t,n,i){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var a={data:function(){return{username:"",password:"",mask:!1,opacity:"",num:5,msg:[]}},methods:{masks:function(){this.opacity="opacity: 0;z-index:-1;"},loginAC:function(){if(""==this.username)return uni.reLaunch({url:"../index/index"}),void uni.showToast({title:"请输入账号",icon:"none",duration:1500,mask:!0});this.password.length<6?uni.showToast({title:"密码不能少于6个字符",icon:"none",duration:1500,mask:!0}):(uni.showLoading({title:"正在登陆..",icon:"none",mask:!0}),this.request("api/Login/login",{username:this.username,password:this.password},function(t,n){uni.showToast({title:n.msg,icon:"none",duration:1500,mask:!0,success:function(){1==n.code&&(uni.setStorageSync("token",n.data.data.token),uni.setStorageSync("username",n.data.data.username),setTimeout(function(){uni.redirectTo({url:"../index/index"})},1500))}})},function(t,n){uni.showToast({title:n.msg,icon:"none",duration:1500,mask:!0})}))}},onLoad:function(){uni.getStorageSync("token");var t=this;t.request("api/Login/roll_info",{},function(n,i){1==i.code&&(t.msg=i.data.data,t.msg.length>0?t.mask=!0:t.mask=!1)},function(t,n){}),setTimeout(function(){t.masks()},5e3),setTimeout(function(){t.mask=!1},8e3);setInterval(function(){n()},1e3);function n(){t.num--,t.num}}};n.default=a}}]);