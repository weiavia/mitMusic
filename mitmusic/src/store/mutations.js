/**
 * Created by weiai on 2018/3/15.
 */
import * as types from './mutation-types'

const mutations = {
  [types.SET_SINGER](state,singer) {
    state.singer = singer
  },
  [types.SET_RANK](state,rank) {
    state.rank = rank
  },
  [types.SET_PLAYING_STATE](state, flag) {
    state.playing = flag
  },
  [types.SET_PLAYLIST](state, list) {
    state.playlist = list
  },
  [types.SET_SEQUENCE_LIST](state, list) {
    state.sequenceList = list
  },
  [types.SET_PLAY_MODE](state, mode) {
    state.mode = mode
  },
  [types.SET_CURRENT_INDEX](state, index) {
    state.currentIndex = index
  },

  // USER
  [types.SET_IS_LOGIN](state, isLogin) {
    state.isLogin = isLogin
  },

  [types.SET_USER_INFO](state, info) {
    state.userInfo = info
  },

  [types.SET_MSG](state, msg) {
    state.msg = msg
  },

  [types.SET_SINGER](state, singer) {
    state.singer = singer
  },

  [types.SET_RECOMMEND](state, recommend) {
    state.recommend = recommend
  },

  [types.SET_IS_ADD_SONG](state, isAddSong) {
    state.isAddSong = isAddSong
  },

  [types.SET_USER_SONG_LIST](state, userSongList) {
    state.userSongList = userSongList
  },

  [types.SET_READY_ADD_SONG](state, song) {
    state.readyAddSong = song
  },

  [types.SET_SHOW_LOGIN](state, booelan) {
    state.showLogin = booelan
  },

  [types.SET_U_LIST](state, list) {
    state.uList = list
  },

  [types.SET_FAVORITES](state, list) {
    state.favorites = list
  }
}

export default mutations