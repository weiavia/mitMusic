/**
 * Created by weiai on 2018/3/26.
 */
import Vue from 'vue'
import Notify from './notify.vue'
const NotifyConstruct = Vue.extend(Notify)


const NotifyInstance = new NotifyConstruct()
NotifyInstance.vm = NotifyInstance.$mount()
document.body.appendChild(NotifyInstance.vm.$el)


const notify = (msg) => {
  NotifyInstance.run(msg)
}

export default (Vue) => {
  Vue.prototype.$notify = notify
}
