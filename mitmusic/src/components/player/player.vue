<template>
    <div class="player">
        <div class="controllerWrapper">
            <ul>
                <li><i class="iconfont icon-caidanmoshi" @click="showSongList"></i></li>
                <li><i class="iconfont" :class="volumeIcon" @click="showVolume"></i></li>
                <li><i class="iconfont" :class="modeIcon" @click="changeMode"></i></li>
                <li><i class="iconfont icon-icon1" @click="showPlayList"></i></li>
            </ul>
        </div>
        <div class="playerWrapper">
            <div class="cover">
                <p class="songName">{{currentSong.name}}</p>
                <div class="shade">
                    <i class="iconfont" :class="playicon" @click="togglePlaying"></i>
                </div>
                <img :src="currentSong.image" alt="">
                <progress-bar ref="bar" class="progressBar" :currentTime="currentTime" :duration="duration"
                              @changeTime="changeTime"></progress-bar>
            </div>
            <scroll class="lyricWrapper" ref="lyricList" :hasBar="lyricBar">
                <div v-show="lyric">
                    <p class="line-item" ref="lyricLine" v-for="(item, index) in lines"
                       :class="{'line-active':index ===currentLine}">{{item.txt}}</p>
                </div>
            </scroll>
            <div class="controller">
                <i class="iconfont icon-weibiaoti-yihuifu-" @click="pre"></i>
                <i class="iconfont icon-xihuan" :class="favoriteClass" @click="favorite"></i>
                <i class="iconfont icon-wei-" @click="next"></i>
            </div>
        </div>
        <audio :src="currentSong.url" ref="audio"
               @loadeddata="play"
               @timeupdate="updateTime"
               @ended="end"
        >
        </audio>
        <transition name="volume">
            <volume class="volume" @changeVolume="changeVolume" v-show="showLayer === 'volume'"></volume>
        </transition>
        <music-list :showList="showLayer === 'pList'" @back="hideLayer"></music-list>
        <user-song-list :show="showLayer === 'uList'" @back="hideLayer"></user-song-list>
    </div>
</template>

<script>
  import {mapGetters, mapMutations, mapActions} from 'vuex'
  import {playMode} from 'common/js/playMode'
  import volume from 'base/volume/volume'
  import progressBar from 'base/progress-bar/progress-bar'
  import Lyric from 'lyric-parser'
  import Scroll from 'base/scroll/scroll'
  import MusicList from 'base/music-list/music-list'
  import UserSongList from 'components/userSongList/userSongList'
  import {isLogin} from 'common/js/check'
  import {addToSongList, getFavourites, removeSong} from 'api/songList'
  import {MessageBox} from 'element-ui'
  import {ERR_OK} from 'api/config'

  export default {
    name: 'player',
    data() {
      return {
        loadFlag: false,
        duration: 0,
        currentTime: 0,
        volume: 1,
        lyric: {},
        lyricBar: false,
        currentLine: -1,
        nextTime: 0,
        lines: [],
        showLayer: ''
      }
    },
    created() {
    },
    methods: {
      play() {
        this.loadFlag = true
        this.duration = this.$refs.audio.duration
        if(this.playing) {
            this.$refs.audio.play()
        }
      },
      togglePlaying() {
        this.setPlayingState(!this.playing)
      },
      changeMode() {
        let mode = (this.mode + 1) % 3
        // 如果是随机播放，那么打乱播放列表
        if (mode === playMode.random) {
          this.randomPlay()
        }
        this.setPlayMode(mode)
      },
      pre() {
        let curIndex = this.currentIndex - 1
        if(this.playlist.length === 1) {
          this.$notify('列表里只有一首歌')
        }
        if (curIndex < 0) {
          curIndex = this.playlist.length - 1
        }
        this.setCurrentIndex(curIndex)
      },
      next() {
        let curIndex = this.currentIndex + 1
        if(this.playlist.length === 1) {
          this.$notify('没有下一首了')
        }
        if (curIndex === this.playlist.length) {
          curIndex = 0
        }
        this.setCurrentIndex(curIndex)
      },
      end() {
        // 判断当前播放模式
        if (this.mode === playMode.loop) {
          // 继续播放
          this.$refs.audio.play()
        } else {
          // 没有下一首歌曲了 自动暂停
          if(this.currentIndex === this.playlist.length - 1) {
            this.setPlayingState(false)
          }
          // 跳到下一首
          this.next()
        }
      },
      updateTime(e) {
        this.currentTime = e.target.currentTime
      },
      changeTime(scale) {
        this.$refs.audio.currentTime = scale * this.duration
        if (this.lyric.seek) {
          this.lyric.seek((scale * this.duration) * 1000)
        }
      },
      changeVolume(scale) {
        this.volume = scale
        this.$refs.audio.volume = this.volume
      },
      showVolume() {
        this.showLayer = this.showLayer === 'volume' ? '' : 'volume'
      },
      lyricHandler({lineNum, txt}) {
        this.currentLine = lineNum
        if (lineNum > 3) {
          let lineEl = this.$refs.lyricLine[lineNum - 2]
          this.$refs.lyricList.scrollToElement(lineEl, 1000)
        }
      },
      showPlayList() {
        this.songListShow = false
        this.showLayer = 'pList'
      },
      showSongList() {
        isLogin().then(() => {
            this.showLayer = 'uList'
        }).catch((msg) => {
          MessageBox.alert(msg).then(() => {
            this.setLoginShow(true)
          })
        })
      },
      hideLayer() {
        this.showLayer = ''
      },
      // 添加歌曲到我喜欢
      favorite() {
        if(this.favoriteClass === 'active') {
          this.removeFavorite()
          return
        }

        let params =  {
            'avatar': this.currentSong.image,
            'mid': this.currentSong.mid,
            'name': this.currentSong.name,
            'singer': this.currentSong.singer,
        }
        isLogin().then(() => {
          addToSongList(params).then((res) => {
            let list = this.favorites.slice();
            list.push(this.currentSong)
            this.setFavorites(list)
            this.$notify(this.currentSong.name + '~已添加到我喜欢的')
          })
        }).catch((msg) => {
          MessageBox.alert(msg).then(() => {
            this.setLoginShow(true)
          })
        })
      },
      // 从我喜欢删除歌曲
      removeFavorite() {
        let param  = {
          'songid': this.currentSong.mid
        }
        removeSong(param).then((res) => {
          if(res.data.errorCode === ERR_OK) {
            this.$notify(this.currentSong.name + '从我喜欢删除~')
            let fList = this.favorites.slice()
            let index = fList.findIndex((e) => {
              return e.mid === this.currentSong.mid
            })
            fList.splice(index, 1)
            this.setFavorites(fList)
          }
        })
      },
      ...mapMutations({
        'setPlayingState': 'SET_PLAYING_STATE',
        'setCurrentIndex': 'SET_CURRENT_INDEX',
        'setPlayMode': 'SET_PLAY_MODE',
        'setLoginShow': 'SET_SHOW_LOGIN',
        'setFavorites': 'SET_FAVORITES'
      }),
      ...mapActions([
        'randomPlay'
      ])
    },
    computed: {
      playicon() {
        return this.playing ? 'icon-zanting' : 'icon-bofang'
      },
      modeIcon() {
        return this.mode === playMode.random ? 'icon-suijibofang' : this.mode === playMode.loop ? 'icon-danquxunhuan' : 'icon-shunxubofang'
      },
      volumeIcon() {
        return this.volume === 0 ? 'icon-52jingyin' : 'icon-yinliang'
      },
      favoriteClass() {
        let index = -1

        if(this.favorites){
            index = this.favorites.findIndex((song) => {
              return song.mid === this.currentSong.mid
            })
        }
        return index === -1 ?  '' : 'active'
      },
      ...mapGetters([
        'currentSong',
        'playing',
        'playlist',
        'currentIndex',
        'mode',
        'favorites'
      ])
    },
    watch: {
      playing(state) {
        if (this.loadFlag) {
          let audio = this.$refs.audio
          state ? audio.play() : audio.pause()
          if(state) {
            this.lyric.play(this.nextTime)
          } else {
            this.lyric.stop()
            this.nextTime = +new Date() - this.lyric.startStamp
          }
        }
      },
      currentSong(song, oldSong) {
        if(song.id === oldSong.id && oldSong) {
          return
        }

        if(!song.id) {
          // 没有歌曲了
          this.setPlayingState(false)
          return
        }

        if (this.lyric.stop) {
          // 如果存在lyric对象 将歌词滚动到顶部
          this.$refs.lyricList.scrollToElement(this.$refs.lyricLine[0], 1000)
          this.lyric.stop()
          this.lyric = null
          this.currentLine = 0
          this.nextTime = 0
        }

        song.getLyric().then((lyric) => {

          // 获取歌词
          this.lyric = new Lyric(lyric, this.lyricHandler)
          this.lines = this.lyric.lines
          if (this.playing) {
            this.lyric.play()
          }
        })
      }
    },
    components: {
      progressBar,
      volume,
      Scroll,
      MusicList,
      UserSongList
    }
  }
</script>

<style lang="stylus" scoped>
    .controllerWrapper
        float: left
        li
            cursor pointer
            margin-bottom: 8px
            text-align: center
            .iconfont
                color: #555
                font-size 40px
            .icon-yinliang
                font-size: 34px
            .icon-icon1
                font-size: 34px
    .playerWrapper
        position: relative
        float: right
        margin-left: 10px
        width 300px
        height: 100%
        .cover
            position: relative
            width: 300px
            height: 300px
            .songName
                position: absolute
                top: -45px
                font-size: 16px
                font-weight: bold
                text-align: center
                width: 100%
            img
                width: 100%
            .shade
                position: absolute
                width: 100%
                height: 100%
                background: rgba(255, 255, 255, 0.4)
                cursor: pointer
                display: flex
                justify-content: center
                align-items: center
                transition: all 0.5s
                i
                    font-size: 70px
                    color: rgba(0, 0, 0, 0.7)
                    opacity: 0
                    transition: 0.5s all
                    &.icon-bofang
                        opacity: 1
            .shade:hover
                i
                    opacity: 1
        .progressBar
            position: absolute
            bottom: 0
            width: 100%
        .lyricWrapper
            width: 300px
            height: calc(100% - 360px)
            margin: 10px 0
            overflow: hidden
            cursor: move
            .line-item
                color: #555
                font-size 12px
                font-family "新宋体"
                text-align center
                line-height 1.6
                &.line-active
                    font-size 14px
                    color: #333
        .controller
            text-align: center
            height: 40px
            width: 300px
            i
                font-size: 40px
                cursor: pointer
                &.icon-xihuan
                    margin: 0 20px
                    color: #888
                &.icon-xihuan.active
                    color: red
    .volume
        height: 50px
        background: #fff;
        position absolute
        top: 20px
        z-index 999
        right: 20px
        width: 300px
        opacity: 1
        &.volume-enter-active, &.volume-leave-active
            transition: all 0.5s
        &.volume-enter, &.volume-leave-to
            transform: translateY(-70px);
</style>