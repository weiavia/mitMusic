/**
 * Created by weiai on 2018/3/15.
 */
import axios from 'axios'
import config from 'config'

export function getLyric (mid) {
  return new Promise((resolve, reject) => {
    const url = `${config.domain}/v1/song/lyric`

    const data = Object.assign({}, {
      songmid: mid
    })

    return axios.get(url, {
      params: data
    }).then((res) => {
      return resolve(res.data)
    })
  })
}