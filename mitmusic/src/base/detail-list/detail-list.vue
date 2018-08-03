<template>
    <div class="detailList">
        <div class="info">
            <img :src="avatar" alt="" width="250" height="250">
            <h3 class="name">{{title}}</h3>
            <button class="playButton" @click="play">
                <i class="iconfont icon-bofang"></i>
            </button>
        </div>
        <scroll class="listWrapper" v-if="songs.length">
            <ul class="list">
                <li class="item clearfix" v-for="item in songs">
                    <span class="name" >{{item.name}}</span>
                    <span class="icons">
                        <i class="iconfont icon-bofang"  @click="playItem(item)"></i>
                        <i class="iconfont icon-wei-1"></i>
                    </span>
                    <time>02:30</time>
                    <span class="special">{{item.album}}</span>
                </li>
            </ul>
        </scroll>
    </div>
</template>

<script>
  import Scroll from 'base/scroll/scroll'
  import {mapActions, mapMutations} from 'vuex'
  export default {
    props: {
      songs: {
        type: Array,
        default: []
      },
      avatar: {
        type: String,
        default: ''
      },
      title: {
        type: String,
        default: ''
      }

    },
    created() {


    },
    methods: {
      play() {
        this.selectPlay({
          list: this.songs,
          index: 0
        })
        this.$notify('播放'+this.title+'热门歌曲')
      },
      playItem(song) {
        this.playOne(song)
      },
      ...mapActions([
        'selectPlay',
        'playOne'
      ])
    },
    components: {
      Scroll
    }
  }
</script>

<style lang="stylus" scoped>
    .detailList
        display: flex
        height: 100%
        .info
            width: 250px
            height: 100%
            margin-right: 10px
            .name
                text-align center
                font-size: 18px
                line-height 50px
                text-overflow: ellipsis
                white-space: nowrap
                overflow: hidden
            .playButton
                border: none
                background: #fff;
                width: 100px
                height: 100px
                border-radius 50%
                box-shadow: 10px 1px #eee
                margin: 10px auto 0
                display: block
                text-align center
                cursor: pointer
                outline: none
                .iconfont
                    font-size: 30px
                    color: #333

        .listWrapper
            width: 100%
            overflow: hidden
            .list
                .item
                    height: 40px
                    line-height 40px
                    background: #f4f4f5
                    font-size: 14px
                    padding: 0 10px
                    margin-bottom: 10px
                    .name
                        display: inline-block
                        width: 25%
                        text-overflow: ellipsis
                        white-space: nowrap
                        overflow: hidden
                        float: left
                    .icons
                        display: inline-block
                        width: 20%
                        i
                          color: #777
                          cursor: pointer
                          padding: 0 5px
                    time
                        float: right
                    .special
                        display: inline-block
                        float: right
                        width: 25%
                        margin-right: 10%
                        text-overflow: ellipsis
                        white-space: nowrap
                        overflow: hidden
                .item:nth-child(odd)
                    background: #FBFBFD;
</style>