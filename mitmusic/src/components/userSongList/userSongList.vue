<template>
    <div class="musicList" v-show="show">
        <span class="back" @click="back">Back</span>
        <h2 class="title">我的歌单</h2>
        <p class="create" @click="create">
            创建新歌单
        </p>
        <scroll class="scroll">
            <ul class="list">

                <li class="item" v-for="(item, index) in list" @click="selectItem(item)">
                    <img src="./favorite.png" alt="" class="avatar" v-if="index === 0">
                    <img :src="item.avatar" alt="" class="avatar" v-else-if="item.avatar">
                    <img src="./6.png" alt="" class="avatar" v-else>
                    <span class="name">{{item.name}}</span>
                </li>
            </ul>
        </scroll>
    </div>
</template>

<script>
  import Scroll from 'base/scroll/scroll'
  import {mapGetters, mapMutations, mapActions} from 'vuex'
  import {MessageBox } from 'element-ui'
  import {createSongList, getMyList} from 'api/songList'
  import {ERR_OK} from 'api/config'

  export default {
    data() {
      return {
        list: []
      }
    },
    props: {
        show: {
          type: Boolean
        }
    },
    created() {
      // 防止一进来就请求数据
      if(!this.show)
        return
      this._getList()
    },
    methods: {
      selectItem(item) {
        this.setUList(item)
        this.$router.replace('/')
        this.$router.replace({
          path: `userListDetail/${item.id}`
        })

      },
      create() {
        MessageBox.prompt('请输入歌单名称', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
        }).then(({value}) => {
          createSongList(value).then((res) => {
            if(res.data.errorCode === ERR_OK) {
                this.list.push(res.data.data)
                this.setUserSongList(this.list)
            }
          })
        }).catch((res) => {

        })
      },
      _getList() {
        getMyList().then((res) => {
          if(res.data.errorCode === ERR_OK) {
            this.list = this.normalizeList(res.data.data)
            this.setUserSongList(this.list)
          }
        })
      },
      normalizeList(list) {
        let index = list.findIndex((item) => {
            return item.type === 3
        })
        if(index === 0) return
        let favorite = list[index]
        list.splice(index, 1)
        list.unshift(favorite)
        return list
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
        'setUserSongList': 'SET_USER_SONG_LIST',
        'setUList': 'SET_U_LIST'
      }),
      ...mapActions([
        'deleteItem'
      ])
    },
    components: {
      Scroll
    },
    watch: {
      show() {
        this._getList()
      }
    },
    computed: {
      ...mapGetters([
        'playlist',
        'currentIndex',
        'playing'
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
        .create
            padding: 0 10px
            height: 40px
            line-height 40px
            background: #FBFBFD;
            cursor: pointer
            margin-bottom: 10px
        .scroll
            height: calc(100% - 70px)
            overflow: hidden
            position: relative
        .title
            font-size: 18px
            margin-bottom: 20px
            text-align: right
        .list
            .item
                height: 50px
                display: flex
                background: #FBFBFD;
                cursor: pointer
                margin-bottom: 10px
                font-size: 14px
                align-items center
                .name
                    width: 100%
                    overflow: hidden
                    text-overflow:ellipsis
                    white-space: nowrap
                    margin-left: 10px
                    color: #777
                .avatar
                    width: 50px
                    height: 50px
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