(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-auth-register"],{"117f":function(e,t,i){"use strict";i.r(t);var a=i("b582"),n=i.n(a);for(var s in a)"default"!==s&&function(e){i.d(t,e,function(){return a[e]})}(s);t["default"]=n.a},"6d23":function(e,t,i){"use strict";var a=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-uni-view",[i("v-uni-view",{staticStyle:{width:"130upx",height:"130upx",margin:"5% auto"}},[i("v-uni-image",{staticStyle:{"border-radius":"25upx"},attrs:{src:"../../static/logo_07.png"}})],1),i("v-uni-view",{staticClass:"per"},[i("v-uni-view",{staticStyle:{width:"30%"}},[e._v("手机号码")]),i("v-uni-view",{staticStyle:{width:"60%"}},[i("v-uni-input",{attrs:{placeholder:"请输入手机号",maxlength:"11"},model:{value:e.username,callback:function(t){e.username=t},expression:"username"}})],1),i("v-uni-view",{staticStyle:{width:"10%"}})],1),i("v-uni-view",{staticClass:"per"},[i("v-uni-view",{staticStyle:{width:"30%"}},[e._v("登录密码")]),i("v-uni-view",{staticStyle:{width:"60%"}},[i("v-uni-input",{attrs:{placeholder:"密码为数字、英文的组合",type:"password",maxlength:"18"},model:{value:e.password,callback:function(t){e.password=t},expression:"password"}})],1),i("v-uni-view",{staticStyle:{width:"10%"}})],1),i("v-uni-view",{staticClass:"per"},[i("v-uni-view",{staticStyle:{width:"30%"}},[e._v("确认密码")]),i("v-uni-view",{staticStyle:{width:"60%"}},[i("v-uni-input",{attrs:{placeholder:"请再次输入密码",type:"password",maxlength:"18"},model:{value:e.repassword,callback:function(t){e.repassword=t},expression:"repassword"}})],1),i("v-uni-view",{staticStyle:{width:"10%"}})],1),i("v-uni-view",{staticClass:"per"},[i("v-uni-view",{staticStyle:{width:"30%"}},[e._v("验证码")]),i("v-uni-view",{staticStyle:{width:"40%"}},[i("v-uni-input",{attrs:{placeholder:"请输入验证码",maxlength:"6"},model:{value:e.code,callback:function(t){e.code=t},expression:"code"}})],1),i("v-uni-view",{staticStyle:{width:"30%"}},[i("v-uni-button",{staticClass:"mini-btn",staticStyle:{"line-height":"70upx","margin-top":"12upx",width:"100%",height:"70upx",padding:"0"},attrs:{type:"primary",size:"mini"},on:{click:function(t){t=e.$handleEvent(t),e.sendCode()}}},[e._v(e._s(e.vcodeBtnName))])],1)],1),i("v-uni-view",{staticClass:"per"},[i("v-uni-view",{staticStyle:{width:"30%"}},[e._v("二级密码")]),i("v-uni-view",{staticStyle:{width:"60%"}},[i("v-uni-input",{attrs:{placeholder:"密码为数字、英文的组合",type:"password",maxlength:"18"},model:{value:e.paypassword,callback:function(t){e.paypassword=t},expression:"paypassword"}})],1),i("v-uni-view",{staticStyle:{width:"10%"}})],1),i("v-uni-view",{staticClass:"per"},[i("v-uni-view",{staticStyle:{width:"30%"}},[e._v("确认二级密码")]),i("v-uni-view",{staticStyle:{width:"60%"}},[i("v-uni-input",{attrs:{placeholder:"请再次输入二级密码",type:"password",maxlength:"18"},model:{value:e.repaypassword,callback:function(t){e.repaypassword=t},expression:"repaypassword"}})],1),i("v-uni-view",{staticStyle:{width:"10%"}})],1),i("v-uni-view",{staticClass:"per"},[i("v-uni-view",{staticStyle:{width:"30%"}},[e._v("推荐人账号:")]),i("v-uni-view",{staticStyle:{width:"60%"}},[i("v-uni-input",{attrs:{placeholder:"请输入手机号"},model:{value:e.rename,callback:function(t){e.rename=t},expression:"rename"}})],1),i("v-uni-view",{staticStyle:{width:"10%"}})],1),i("v-uni-button",{staticStyle:{width:"80%",background:"linear-gradient(#fe2e63,#fe583d)",color:"#fff","margin-top":"10%","border-radius":"40upx"},on:{click:function(t){t=e.$handleEvent(t),e.submitRegister()}}},[e._v("立即注册")])],1)},n=[];i.d(t,"a",function(){return a}),i.d(t,"b",function(){return n})},"6eec":function(e,t,i){"use strict";var a=i("9d1d"),n=i.n(a);n.a},"890f":function(e,t,i){"use strict";i.r(t);var a=i("6d23"),n=i("117f");for(var s in n)"default"!==s&&function(e){i.d(t,e,function(){return n[e]})}(s);i("6eec");var o=i("2877"),u=Object(o["a"])(n["default"],a["a"],a["b"],!1,null,"e097cb10",null);t["default"]=u.exports},"9d1d":function(e,t,i){var a=i("c017");"string"===typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);var n=i("4f06").default;n("6e89a632",a,!0,{sourceMap:!1,shadowMode:!1})},b582:function(e,t,i){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var a={data:function(){return{username:"",password:"",repassword:"",paypassword:"",repaypassword:"",rename:"",source:0,code:"",vcodeBtnName:"获取验证码",countNum:30,countDownTimer:null,canSendStatus:!0}},methods:{submitRegister:function(){var e=this;e.password==e.repassword?e.paypassword==e.repaypassword?(e.request("api/Login/register",{username:e.username,password:e.password,paypassword:e.paypassword,rename:e.rename,code:e.code},function(t,i){uni.showToast({title:i.msg,duration:1e3,mask:!0,success:function(){1==i.code&&(1!==e.source&&(uni.setStorageSync("token",i.data.data.token),uni.setStorageSync("username",i.data.data.username)),setTimeout(function(){uni.switchTab({url:"../index/index"})},1e3))}})},function(e,t){uni.showToast({title:t.msg,icon:"none",duration:1500,mask:!0})}),setTimeout(function(){uni.switchTab({url:"../index/index"})},1e3)):uni.showToast({title:"两次二级密码输入不一致",icon:"none",duration:1500,mask:!0}):uni.showToast({title:"两次密码输入不一致",icon:"none",duration:1500,mask:!0})},countDown:function(){if(this.countNum<1)return clearInterval(this.countDownTimer),this.vcodeBtnName="重新发送",void(this.canSendStatus=!0);this.countNum--,this.vcodeBtnName=this.countNum+"秒重发"},sendCode:function(){var e=this;1==e.canSendStatus&&(e.canSendStatus=!1,e.request("api/User/send_mobile_code",{username:e.username,codeType:"register"},function(t,i){i.code&&(uni.hideLoading(),uni.showToast({title:i.msg,duration:1e3,mask:!0,success:function(){e.vcodeBtnName=i.msg,e.countNum=30,e.countDownTimer=setInterval(function(){e.countDown()}.bind(e),1e3)}}))},function(t,i){uni.hideLoading(),uni.showToast({title:i.msg,icon:"none",mask:!0}),e.vcodeBtnName="获取验证码",e.canSendStatus=!0}))}},onLoad:function(e){1==e.type&&(this.source=1),e.code&&(this.rename=e.code)}};t.default=a},c017:function(e,t,i){t=e.exports=i("2350")(!1),t.push([e.i,"uni-page-body[data-v-e097cb10]{overflow:hidden;height:100%;background:#eceaea}.per1[data-v-e097cb10]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;width:90%;margin:3% auto;background:rgba(245,133,133,.82);color:#fff}.per1 uni-view[data-v-e097cb10]{-webkit-box-flex:1;-webkit-flex-grow:1;-ms-flex-positive:1;flex-grow:1}.per[data-v-e097cb10]{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;width:90%;margin:3% auto;background:#fff;height:%?80?%;-webkit-border-radius:%?20?%;border-radius:%?20?%}.per uni-view[data-v-e097cb10]{-webkit-box-flex:1;-webkit-flex-grow:1;-ms-flex-positive:1;flex-grow:1;line-height:%?80?%}.per uni-view[data-v-e097cb10]:first-child{text-align:center}body.?%PAGE?%[data-v-e097cb10]{background:#eceaea}",""])}}]);