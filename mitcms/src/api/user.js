/**
 * Created by weiai on 2018/3/29.
 */
/**
 * Created by weiai on 2018/3/20.
 */
import axios from 'axios'
import {getToken} from 'common/js/token'
import require from 'common/js/axios'
import config from 'config'

export function login(params) {
  let url = `${config.domain}/v1/token`
  params.cmsFlag = 'mit'

  return require({
    method: 'post',
    data: params,
    url
  })
}

export function getUserInfo() {
  let url = `${config.domain}/v1/user/info`
  return axios({
    method: 'get',
    url,
    headers: {
      'Access-Token': getToken()
    }
  })
}

export function ansyAvatar(data) {
  let url = `${config.domain}/v1/user/avatar`
  url += (url.indexOf('?') < 0 ? '?' : '&') + param(data)

  return axios.get(url, data)
}


