/**
 * Created by weiai on 2018/3/29.
 */
import axios from 'axios'
import {getToken} from 'common/js/token'
import require from 'common/js/axios'

export function createSongList(params) {
  let url = `${config.domain}/v1/songlist`
  return axios({
    method: 'post',
    url: url,
    data: params,
    headers: {
      'Access-Token': getToken()
    }
  })
}

export function getSongList() {
  let url = `${config.domain}/v1/songlist2`
  return require({
    method: 'get',
    url: url,
    headers: {
      'Access-Token': getToken()
    }
  })
}

export function addToSongList(params) {
  let url = `${config.domain}/v1/songandlist`
  return axios({
    method: 'post',
    data: params,
    url,
    headers: {
      'Access-Token': getToken()
    }
  })
}

export function getSongs(params) {
  let url = `${config.domain}/v1/songlist/songs?listid=` + params.listid
  return axios({
    method: 'get',
    url,
    headers: {
      'Access-Token': getToken()
    }
  })
}