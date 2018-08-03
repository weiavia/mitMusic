/**
 * Created by weiai on 2018/3/15.
 */
import jsonp from 'common/js/jsonp'
import {ERR_OK, commonParam} from 'api/config'
import {getLyric} from 'api/song'
import Base64 from 'js-base64'

class Song {
  constructor({id, mid, singer, name, album, duration, image}) {
      this.id = id
      this.mid = mid
      this.singer = singer
      this.name = name
      this.album = album
      this.duration = duration
      this.image = image
      this.url = ''
      this.vkey = ''

      getVkey(this.mid).then((res) => {
        if(res.code === ERR_OK) {
          this.vkey =  res.data.items[0].vkey
          this.url = `http://dl.stream.qqmusic.qq.com/C400${this.mid}.m4a?fromtag=999&guid=5640016016&vkey=${this.vkey}&uin=0`
        }
      })
  }
  getLyric() {
    if (this.lyric) {
      return Promise.resolve(this.lyric)
    }
    return new Promise((resolve, reject) => {
      getLyric(this.mid).then((res) => {
        if (res.errorCode === ERR_OK) {
          this.lyric = Base64.Base64.decode(res.data.lyric)
          resolve(this.lyric)
        } else {
          reject('no lyric')
        }
      })
    })
  }
}

function getVkey(songmid) {
  const url = 'https://c.y.qq.com/base/fcgi-bin/fcg_music_express_mobile3.fcg?'
  const data = Object.assign({}, commonParam, {
    filename: 'c400' + songmid + '.m4a',
    songmid: songmid,
    platform: 'h5',
    cid: 205361747,
    guid: 5640016016,
    uin: 0,
    needNewCode: 0
  })

  return jsonp(url, data, {})
}

function filterSinger(singer) {
  let ret = []
  if (!singer) {
    return ''
  }
  singer.forEach((s) => {
    ret.push(s.name)
  })
  return ret.join('/')
}

export function createSong(musicData) {
  return new Song ({
    id: musicData.songid,
    mid: musicData.songmid,
    singer: filterSinger(musicData.singer),
    name: musicData.songname,
    album: musicData.albumname,
    duration: musicData.interval,
    image: `https://y.gtimg.cn/music/photo_new/T002R300x300M000${musicData.albummid}.jpg?max_age=2592000`,
  })
}

export function createSong2(musicData) {
  return new Song ({
    id: musicData.mid,
    mid: musicData.mid,
    singer:musicData.singer,
    name: musicData.name,
    album: '------',
    duration: 0,
    image: musicData.avatar,
  })
}
