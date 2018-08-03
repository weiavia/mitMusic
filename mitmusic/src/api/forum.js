/**
 * Created by weiai on 2018/4/12.
 */
import axios from 'axios'
import {getToken} from 'common/js/token'
import config from 'config'

export function addForum(params) {
  const url = `${config.domain}/v1/forum`
  return axios({
    method: 'post',
    url,
    data: params,
    headers: {
      'Access-Token': getToken()
    }
  })
}

export function getForum(params) {
  const url = `${config.domain}/v1/forum?limit=${params.limit}&num=${params.num}`
  return axios({
    method: 'get',
    url,
    headers: {
      'Access-Token': getToken()
    }
  })
}

