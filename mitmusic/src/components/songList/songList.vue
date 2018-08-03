<template>
    <scroll class="songList"
            :data="songList"
            :pullup="pullup"
            @scrollToEnd="loadMore"
    >
        <div class="list" v-show="songList.length > 0">
            <div class="list-item" v-for="item in this.songList">
                <div class="imgWrapper">
                    <div class="playButton" @click="playList(item)">
                        <i class="iconfont icon-bofang"></i>
                    </div>
                    <img :src="item.imgurl" alt="">
                </div>
                <p>{{item.dissname}}</p>
            </div>
            <div class="loadingWrapper" v-show="loading">
                <loading></loading>
            </div>
        </div>
    </scroll>
</template>

<script>
  import {getSongList, getListInfo} from 'api/songList'
  import {ERR_OK} from 'api/config'
  import Scroll from 'base/scroll/scroll'
  import Loading from 'base/loading/loading'
  import {createSong} from 'common/js/song'
  import {mapActions} from 'vuex'

  export default {
    name: 'songList',
    data() {
      return {
        curPage: 0,
        songList: [],
        pullup: true,
        loading: false,
        sin: 0,
        ein: 20,
        songs: []
      }
    },
    created() {
      this._getSongList()
    },
    methods: {
      _getSongList() {
        if (this.loading)
          return false
        this.loading = true

        getSongList({ein: this.ein, sin: this.sin}).then((res) => {

          if (res.data.errorCode === ERR_OK) {
            this.songList = this.songList.concat(res.data.data.data.list)
            this.sin = this.ein + 1
            this.ein = this.ein + 20
            this.loading = false
          }
        })

      },
      loadMore() {
        this._getSongList()
      },
      playList(item) {

        getListInfo({dissid: item.dissid}).then((res) => {
          let data = res.data;
          if (data.errorCode === ERR_OK) {
            this.songs = this.formatList(data.data.cdlist[0].songlist)
            this.selectPlay({
              list: this.songs,
              index: 0
            })
          }
        })
      },
      formatList(list) {
        let songs = []
        list.forEach((e) => {
          songs.push(createSong(e))
        })
        return songs;
      },
      ...mapActions([
        'selectPlay'
      ])
    },
    components: {
      Scroll,
      Loading
    }
  }
</script>

<style lang="stylus" scoped>
    @import "~common/stylus/variable.styl"
    .songList
        height: 100%
        overflow: hidden
        .list
            padding-bottom: 60px
            font-size 0
            .list-item
                display: inline-block
                margin-right: 10px
                margin-bottom: 10px
                width: calc(25% - 10px)
                cursor: pointer
                .imgWrapper
                    overflow: hidden
                    width 100%
                    box-sizing: border-box
                    border: 1px solid $borderColor
                    position: relative
                    img
                        width 100%
                        transition: all 1s
                    .playButton
                        position: absolute
                        left: 50%
                        top: 50%
                        margin-left: -15%
                        margin-top: -15%
                        z-index: 1000
                        width: 30%
                        height: 30%
                        border-radius: 50%
                        transform: scale(0.5)
                        transition: all 1s
                        background: rgba(255, 255, 255, 0.6)
                        display: flex
                        justify-content: center
                        align-items: center
                        color: #fff
                        opacity: 0
                        i
                            font-size: 15px
                .imgWrapper:hover
                    img
                        transform: scale(1.1)
                    .playButton
                        transform: scale(1)
                        opacity: 1
                        i
                            font-size: 20px
                p
                    color: #666
                    font-family "新宋体"
                    font-size: 12px
                    height: 30px
                    line-height: 30px
                    overflow: hidden
                    text-overflow: ellipsis
                    white-space: nowrap

        .loadingWrapper
            width: 100%
            display: flex
            justify-content: center
            maring: 20px 0
</style>