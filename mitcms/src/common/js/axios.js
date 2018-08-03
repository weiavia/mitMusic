/**
 * Created by weiai on 2018/4/3.
 */
import axios from 'axios'
import store from '../../store'
import { Message, MessageBox } from 'element-ui'
import { getToken } from 'common/js/token'
import Login from 'components/login/login'

// 创建axios实例
const service = axios.create({
  timeout: 5000 // 请求超时时间
})

service.interceptors.response.use( response => {
  return response
}, error => {

    let errorCode = error.response.data.errorCode
    if(errorCode === 100002) {
      MessageBox('身份过期').then(() => {
        store.commit('SET_LOGIN_SHOW', true)
      })
    }

    return Promise.reject(error)
  })


export default service