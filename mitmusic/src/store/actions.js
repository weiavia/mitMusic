/**
 * Created by weiai on 2018/3/15.
 */
import * as types from './mutation-types'
import {playMode} from 'common/js/playMode'
import {shuffle} from 'common/js/utils'


export const selectPlay = function ({commit, state}, {list, index, isPlay = true}) {
  commit(types.SET_SEQUENCE_LIST,list)
  commit(types.SET_PLAYLIST, list)
  commit(types.SET_CURRENT_INDEX, index)
  commit(types.SET_PLAYING_STATE, true)
  if(!isPlay) {
    commit(types.SET_PLAYING_STATE, false)
  }
}

export const randomPlay = function({commit, state}) {
  let playList = state.playlist
  let oldSong = playList[state.currentIndex]
  let shuffleList = shuffle(playList)
  let index = shuffleList.findIndex((e) => {
    return e.id === oldSong.id
  })
  commit(types.SET_CURRENT_INDEX, index)
  commit(types.SET_PLAYLIST, shuffleList)
}

export const playOne = function ({commit, state}, song) {
  // 1.如果歌曲存在于播放列表 更改索引
  // 2.否则 push 并更改索引
  let playList = state.playlist.slice();
  let sequenceList = state.sequenceList.slice();

  let index = playList.findIndex((e) => {
    return e.id === song.id
  })

  if(index === -1) {
    playList.unshift(song)
    sequenceList.unshift(song)
    index = 0
    commit(types.SET_SEQUENCE_LIST, sequenceList)
    commit(types.SET_PLAYLIST, playList)
  }

  commit(types.SET_CURRENT_INDEX, index)
  commit(types.SET_PLAYING_STATE, true)
}

export const deleteItem = function ({commit, state}, index) {
  let oPlayList = state.playlist.slice()
  let oSequentList = state.sequenceList.slice()
  let currentIndex = state.currentIndex
  let currentSong = oPlayList[currentIndex]


  // 删除顺序列表中的歌曲
  let sequentIndex = oSequentList.findIndex((e) => {
    return e.id === currentSong.id
  })

  oSequentList.splice(sequentIndex, 1)
  // 如果删除的歌曲在当前播放的后面或等于当前播放的歌曲 直接删除
  if(index >= currentIndex) {
    // 如果是最后一首 让 index -- 跳到上一首

    if(index === oPlayList.length) {
      oPlayList.splice(index, 1)
      currentIndex --
    } else {
      oPlayList.splice(index, 1)
    }

  } else if(index < currentIndex) {
    oPlayList.splice(index, 1)
    currentIndex --
  }

  commit(types.SET_SEQUENCE_LIST,oSequentList)
  commit(types.SET_PLAYLIST, oPlayList)
  commit(types.SET_CURRENT_INDEX, currentIndex)

}

export const userLogin = function ({commit, state}, userInfo) {
  commit(types.SET_USER_INFO, userInfo)
  commit(types.SET_IS_LOGIN, true)
}

export const userExit= function ({commit, state}) {
  commit(types.SET_USER_INFO, [])
  commit(types.SET_IS_LOGIN, false)
}