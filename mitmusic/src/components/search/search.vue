<template>
    <div class="search" v-show="isShow">


        <transition name="shade">
            <div class="shade" v-show="isShow"></div>
        </transition>
        <transition name="txt">
            <div>
                <input type="text" class="txt" ref="txt" v-show="isShow" v-model="query" />
                <i class="iconfont icon-guanbi" @click="close"></i>
            </div>
        </transition>

        <scroll class="searchList">
            <ul class="list">
                <li class="searchSinger" v-if="singer" @click="toSinger">
                    <img :src="singer.avatar" alt="">
                    <span class="name">{{singer.name}}</span>
                </li>
                <li class="item" v-for="song in songs" @click="play(song)">
                    <span class="name">{{song.name}}</span>
                    <span class="singer">{{song.singer}}</span>
                </li>
            </ul>
        </scroll>

    </div>
</template>

<script>

  import {search} from 'api/search'
  import {ERR_OK} from 'api/config'
  import Singer from 'common/js/singer'
  import {createSong} from 'common/js/song'
  import Scroll from 'base/scroll/scroll'
  import {debounce} from 'common/js/utils'
  import {mapMutations, mapActions} from 'vuex'

  export default {
    name: 'search',
    props: {
      isShow: {
        type: Boolean,
        default: true
      }
    },
    data() {
      return {
        query: '',
        currentPage: 0,
        num: 30,
        showSinger: true,
        singer: null,
        songs: []
      }
    },
    created() {

    },
    methods: {
      search() {
        search(this.query, this.currentPage, this.showSinger, this.num).then((res) => {
            if(res.code === ERR_OK) {
              this.normalizeSearch(res.data)
            }
        })
      },
      normalizeSearch(data) {
        if(this.showSinger) {
          this.singer = null
        }
        // 搜索到了歌手
        if(data.zhida && data.zhida.type === 2) {
          this.singer = new Singer({
            'Fsinger_mid': data.zhida.singermid,
            'Fsinger_name': data.zhida.singername
          })
        }

        let resSongs = []
        let songs = data.song.list
        songs.forEach((e) => {
          resSongs.push(createSong(e))
        })
        this.songs = resSongs
      },
      toSinger() {
        this.setSinger(this.singer)
        this.$router.push({
          path: `/singer/${this.singer.id}`
        })
        this.close()
      },
      play(song) {
        this.playOne(song)
        this.close()
      },
      close() {
        this.original()
        this.$emit('close')
      },
      original() {
        this.songs = []
        this.singer = null
        this.query = ''
      },
      ...mapMutations({
        'setSinger': 'SET_SINGER'
      }),
      ...mapActions([
        'playOne'
      ])
    },
    components: {
      Scroll
    },
    watch: {
      query() {
        debounce(this.search(), 100)
      },
      isShow(b) {
        if (b) {
          this.$nextTick(() => {
            this.$refs.txt.focus()
          })
        }
      }
    }
  }
</script>

<style lang="stylus" scoped>
    .search
        width: 100%
        height: 100%
        position: absolute
        left: 0
        top: 0
        padding: 20px
        z-index: 10000
        .shade
            width: 100%
            height: 100%
            position: absolute
            left: 0
            top: 0
            background: rgba(0, 0, 0, .8);
        .txt
            position: absolute
            z-index: 999
            width: calc(100% - 500px)
            height: 50px
            border: none
            font-size: 30px
            text-indent: 10px
            box-shadow: 0 0 2px #777
        .icon-guanbi
            position: absolute
            z-index: 9999
            color: #fff
            top: 25px
            font-size: 40px
            left: calc(100% - 470px)
            cursor: pointer
        .searchList
            overflow: hidden
            position: absolute
            top: 80px
            width: calc(100% - 500px)
            height: calc(100% - 140px)
            .list
                .item
                    height: 50px
                    line-height: 50px
                    border-bottom: 1px solid #ccc
                    cursor: pointer
                    padding: 0 10px
                    background: rgba(0,0,0 ,0.4)
                    color: #fff
                    .name
                        float: left
                    .singer
                        float: right
                .item:hover
                    background: rgba(0,0,0 ,0.7)
                .searchSinger
                    height: 60px
                    line-height: 60px
                    cursor: pointer
                    padding-bottom: 10px
                    img
                        border-radius: 50px
                        width: 50px
                        height: 50px
                        vertical-align: middle
                    .name
                        font-size: 20px
                        vertical-align: middle
                        color: #fff
                        margin-left: 20px
    .shade-enter-active, .shade-leave-active
        transition: opacity 0.4s

    .shade-enter, .shade-leave-to
        opacity: 0

</style>