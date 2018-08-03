/**
 * Created by weiai on 2018/3/17.
 */
import {createSong2} from 'common/js/song'

function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min)
}

export function shuffle(arr) {
  let _arr = arr.slice()
  for(let i=0; i<_arr.length; i++) {
    let j = getRandomInt(0, i)
    let t = _arr[i]
    _arr[i] = _arr[j]
    _arr[j] = t
  }
  return _arr
}

export function debounce(func, delay) {
  let timer

  return function (...args) {
    if (timer) {
      clearTimeout(timer)
    }
    timer = setTimeout(() => {
      func.apply(this, args)
    }, delay)
  }
}

export function normalizeSong(songs) {
  let res = []
  songs.forEach((e) => {
    res.push(createSong2(e))
  })
  return res
}