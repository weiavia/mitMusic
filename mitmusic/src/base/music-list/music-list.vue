<template>
    <div class="musicList" v-show="showList">
        <span class="back" @click="back">Back</span>
        <h2 class="title">播放列表</h2>
        <scroll class="scroll" :data="playlist">
            <ul class="list">
                <li class="item"  v-for="(item, index) in playlist" :class="{active: currentIndex === index}" @click="playCurrent(index)">
                    <span class="name">{{item.name}}</span>
                    <span class="singer">{{item.singer}}</span>
                    <span class="icons">
                        <i class="iconfont icon-wei-1" @click="showAdd(item)"></i>
                        <i class="iconfont icon-iconfontshanchu1" @click.stop="deleteOne(index)"></i>
                    </span>
                </li>
            </ul>
        </scroll>
    </div>
</template>

<script>
    import Scroll from 'base/scroll/scroll'
    import {mapGetters, mapMutations, mapActions} from 'vuex'
    export default {
        props: {
          showList: {
            type: Boolean,
            default: false
          }
        },
        methods: {
          showAdd(song) {
            this.setIsAdd(true)
            this.setReadyAddSong(song)
          },
          playIcon(index) {
            if(this.playing && this.currentIndex === index){
              return  'icon-bofang'
            }
            return 'icon-zhanting'
          },
          playCurrent(index) {
            this.setCurrentIndex(index)
          },
          deleteOne(index) {
            this.deleteItem(index)
          },
          back() {
            this.$emit('back')
          },
          ...mapMutations({
            'setCurrentIndex': 'SET_CURRENT_INDEX',
            'setIsAdd': 'SET_IS_ADD_SONG',
            'setReadyAddSong': 'SET_READY_ADD_SONG'
          }),
          ...mapActions([
            'deleteItem'
          ])
        },
        components: {
          Scroll
        },
        computed: {
          ...mapGetters([
            'playlist',
            'currentIndex',
            'playing',
          ])
        }
    }
</script>

<style lang="stylus" scoped>
    .musicList
        position: absolute
        right: 0
        top: 0
        width: 320px
        height: 100%
        border-left: 1px solid #eee
        box-sizing: border-box
        padding: 20px 10px
        background: #fff
        z-index: 9999
        .scroll
            height: calc(100% - 50px)
            overflow: hidden
            position: relative
        .title
            font-size: 18px
            margin-bottom: 20px
            text-align: right
        .list
            .item
                padding: 0 10px
                height: 40px
                line-height 40px
                background: #FBFBFD;
                cursor: pointer
                margin-bottom: 10px
                font-size: 14px
                .name
                    width: 100px
                    overflow: hidden
                    text-overflow:ellipsis
                    white-space: nowrap
                    float: left
                    margin-right: 10px
                .singer
                    width: 80px
                    overflow: hidden
                    text-overflow:ellipsis
                    white-space: nowrap
                    float: left
                .icons
                    float: right
                    .iconfont
                        color #777
                        cursor: pointer
                        margin-left: 6px
            .item:nth-child(odd)
                background: #f4f4f5;
            .item.active
                border-left: 4px solid #b3e19d
        .back
            position: absolute
            z-index: 9999
            left: 10px
            color: #333
            font-size 19px
            cursor: pointer
</style>