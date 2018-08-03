import Vue from 'vue'
import store from './store'
import App from './App'
import router from './router'
import lazyLoad from 'vue-lazyload'
import notify from 'base/notify'

// 引入初始化、共用的样式
import "common/stylus/index.styl"

// 注册element-ui
import {Dialog, Input, Button, MessageBox} from 'element-ui'
Vue.use(Dialog)
Vue.use(Input)
Vue.use(Button)
Vue.prototype.$msgbox = MessageBox;

// 注册懒加载插件
Vue.use(lazyLoad, {
  loading: require('common/images/luoyei.jpg')
})
Vue.use(notify)

Vue.config.productionTip = false
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})

