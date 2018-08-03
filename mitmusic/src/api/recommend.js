/**
 * Created by weiai on 2018/3/12.
 */
import {commonParam, jsonpOptions} from 'api/config'
import axios from 'axios'
import config from 'config'

export function getRecommend() {
  let url = `${config.domain}/v1/songlist/recommend`;
  return axios.get(url)
}