/**
 * Created by weiai on 2018/3/20.
 */
import axios from 'axios'
import {param} from 'common/js/jsonp'
import {getToken} from 'common/js/token'
import config from 'config'

export function register(params) {
  const url = `${config.domain}/v1/user/register`
  return axios({
    method: 'post',
    url,
    data: params
  })
}

export function login(params) {
  let url = `${config.domain}/v1/token`
  return axios({
    method: 'post',
    data: params,
    url
  })
}

export function ansyAvatar(data) {
  let url = `${config.domain}/v1/user/avatar`
  url += (url.indexOf('?') < 0 ? '?' : '&') + param(data)

  return axios.get(url, data)
}

export function verify(params) {
  const url = `${config.domain}/v1/verify/check`
  return axios({
    method: 'post',
    url,
    data: params
  })
}

export function getUserInfo() {
  const url = `${config.domain}/v1/user/info`
  return axios({
    method: 'get',
    url,
    headers: {
      'Access-Token': getToken()
    }
  })
}

export function checkToken() {
  const url = `${config.domain}/v1/token/verify`
  return axios({
    method: 'get',
    url,
    headers: {
      'Access-Token': getToken()
    }
  })
}
