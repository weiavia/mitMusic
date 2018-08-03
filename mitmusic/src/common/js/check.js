/**
 * Created by weiai on 2018/4/4.
 */
import {getToken} from './token'
import {checkToken} from 'api/user'
import {ERR_OK} from 'api/config'

export function isLogin() {
  return new Promise((resolve, reject) => {
    if(getToken()) {
      isExpire().then(() => {
        resolve()
      }).catch((err) => {
        reject(err)
      })
    } else {
      reject('请先登录')
    }
  })
}

export function isExpire() {
  return new Promise((resolve, reject) => {
    checkToken().then((res) => {
      if(res.data.errorCode === ERR_OK) {
        if(!res.data.token) {
          reject('身份过期了 请重新登录~')
        }
        resolve()
      }
    })
  })
}

