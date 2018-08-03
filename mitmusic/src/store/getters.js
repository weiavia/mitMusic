/**
 * Created by weiai on 2018/3/15.
 */
import {playMode} from 'common/js/playMode'

export const singer = state => state.singer

export const playing = state => state.playing

export const playlist = state => state.playlist

export const sequenceList = state => state.sequenceList

export const mode = state => state.mode

export const currentIndex = state => state.currentIndex

export const currentSong = (state) => {
  return state.playlist[state.currentIndex] || {}
}

export const isLogin = state => state.isLogin

export const userInfo = state => state.userInfo

export const rank = state => state.rank

export const recommend = state => state.recommend

export const isAddSong = state => state.isAddSong

export const userSongList = state => state.userSongList

export const readyAddSong = state => state.readyAddSong

export const showLogin = state => state.showLogin

export const uList = state => state.uList

export const favorites = state => state.favorites


