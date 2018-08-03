<template>
    <div class="shade" v-if="isAddSong">
        <div class="addToList">
            <div class="title">
                <h2>添加歌曲到歌单</h2>
                <i class="close iconfont icon-guanbi" @click="close"></i>
            </div>
            <scroll class="list">
                <ul>
                    <li v-for="item in userSongList" class="list-item" @click="selectItem(item)">{{item.name}}</li>
                </ul>
            </scroll>
        </div>
    </div>
</template>

<script>
  import {mapGetters, mapActions, mapMutations} from 'vuex'
  import {clearToken} from 'common/js/token'
  import {MessageBox} from 'element-ui'
  import Scroll from 'base/scroll/scroll'
  import {addToSongList} from 'api/songList'
  import {ERR_OK} from 'api/config'

  export default {
    name: 'addToList',
    data() {
      return {

      }
    },
    created() {

    },
    methods: {
      selectItem(item) {
        let params = this.getParams()
        params.listid = item.id
        addToSongList(params).then((res) => {
            if(res.data.errorCode === ERR_OK) {
              MessageBox.alert('添加成功').then(() => {
                this.close()
              })
            }
        })
      },
      getParams() {
        return {
          'avatar': this.readyAddSong.image,
          'mid': this.readyAddSong.mid,
          'name': this.readyAddSong.name,
          'singer': this.readyAddSong.singer
        }
      },
      close() {
        this.setIsAdd(false)
      },
      ...mapActions([
        'userExit'
      ]),
      ...mapMutations({
        'setIsAdd': 'SET_IS_ADD_SONG'
      })
    },
    computed: {
      ...mapGetters([
        'isAddSong',
        'userSongList',
        'readyAddSong'
      ])
    },
    components: {
      Scroll
    }

  }
</script>

<style lang="stylus" scoped>
    .shade
        width: 100%
        height: 100%
        position: fixed
        left: 0;
        top: 0;
        background: rgba(0,0,0, 0.5)
        z-index: 9997
    .addToList
        width: 300px;
        height: 400px;
        background: #fff;
        margin: 60px auto;
        position: relative
        .title
            height: 40px
            line-height: 40px
            text-indent: 1em
            font-size: 18px
            border-bottom: 1px solid #eee
            .close
                position: absolute;
                font-size: 30px
                right: -40px
                top: 0
                color: #fff
                cursor: pointer
        .list
            overflow: hidden
            height: 360px
            position: relative
            .list-item
                height: 40px
                line-height: 40px
                border-bottom: 1px solid #eee
                text-indent: 1em
                cursor: pointer
</style>