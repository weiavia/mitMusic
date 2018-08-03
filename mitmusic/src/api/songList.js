/**
 * Created by weiai on 2018/3/12.
 */
import {commonParam, jsonpOptions} from 'api/config'
import store from '../store'
import {getToken} from 'common/js/token'
import {ERR_OK} from 'api/config'
import axios from 'axios'
import config from 'config'

export function getSongList(param) {
  let data = Object.assign({}, param)
  return axios.get(`${config.domain}/v1/songlist`, {params: data})
}

export function getUserSongList(param) {

}

export function getListInfo(param) {
  let data = Object.assign({}, param)
  return axios.get(`${config.domain}/v1/listinfo`, {params: data})
}

export function createSongList(name) {
  let url = `${config.domain}/v1/songlist`
  return axios({
    method: 'post',
    url: url,
    data: {
      type: 2,
      name: name
    },
    headers: {
      'Access-Token': getToken()
    }
  })
}

export function getMyList(){
  return axios.get(`${config.domain}/v1/songlist2`, {
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

export function getIndexList() {
  return axios.get(`${config.domain}/v1/songlist/index`)
}

export function getListSongs(listid) {
  let url = `${config.domain}/v1/SongList/Songs?listid=` + listid;
  return axios.get(url)
}

export function getFavorites() {
  let url = `${config.domain}/v1/songlist/favorites`
  axios({
    method: 'get',
    url,
    headers: {
      'Access-Token': getToken()
    }
  }).then((res) => {
    if(res.data.errorCode === ERR_OK) {
      console.log(res.data.data)
      store.commit('SET_FAVORITES',res.data.data)
    }
  })
}

export function removeSong(param) {
  let url = `${config.domain}/v1/songlist/song`
  return axios({
    method: 'delete',
    url,
    data: param,
    headers: {
      'Access-Token': getToken()
    }
  })
}