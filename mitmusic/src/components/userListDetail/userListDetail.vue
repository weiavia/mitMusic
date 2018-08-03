<template>
    <div class="rank">
        <span class="back" @click="back">Back</span>
        <detail-list :title="uList.name" :avatar="avatar" :songs="songs"></detail-list>
    </div>
</template>
<script>
  import Scroll from 'base/scroll/scroll'
  import DetailList from 'base/detail-list/detail-list'
  import {mapGetters, mapMutations, mapActions} from 'vuex'
  import {MessageBox } from 'element-ui'
  import {getListSongs} from 'api/songList'
  import {createSongList, getMyList} from 'api/songList'
  import {ERR_OK} from 'api/config'
  import {createSong2} from 'common/js/song'

  export default {
    data() {
      return {
        songs: []
      }
    },
    beforeRouteEnter  (to, from, next) {
      next((vm) => {
        vm._getUserSongList()
      });
    },
    created() {

      this._getUserSongList()
    },
    methods: {
      _getUserSongList() {
        console.log(this.uList)
        this.listid = this.$route.params.id;
        if(!this.listid) {
          this.$router.push({
            path: '/'
          })
        }

        getListSongs(this.listid).then((res) => {
          if(res.data.errorCode ===  ERR_OK) {
            this.songs = this.formatList(res.data.data)
          }
        })
      },
      back() {
        this.$router.back()
      },
      formatList(list) {
        let songs = []
        list.forEach((e) => {
          songs.push(createSong2(e))
        })
        return songs;
      }
    },
    components: {
      DetailList
    },
    computed: {
      avatar() {
        return this.songs[0] ? this.songs[0].image : ''
      },
      ...mapGetters([
        'uList'
      ])
    }
  }
</script>

<style lang="stylus" scoped>
    .rank
        position: absolute
        z-index: 10000
        top: 0
        left: 0
        width: 100%
        height: 100%
        background: #fff;
        .back
            position: absolute
            z-index: 9999
            right: 4px
            top: -40px
            font-size 19px
            cursor: pointer
</style>