/**
 * Created by weiai on 2018/3/15.
 */
import {playMode} from 'common/js/playMode'

const state = {
  playing: false,
  playlist: [],
  sequenceList: [],
  mode: playMode.sequence,
  currentIndex: -1,
  isLogin: false,
  showLogin: false,
  userInfo: {},
  singer: {},
  rank: {},
  isAddSong: false,
  userSongList: [],
  readyAddSong: {},

  recommend: {},
  uList: {},

  favorites: []
}

export default state;