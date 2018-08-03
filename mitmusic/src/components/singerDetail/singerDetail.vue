<template>
    <div class="detail">
        <span class="back" @click="back">Back</span>
        <detail-list :title="title" :avatar="avatar" :songs="songs"></detail-list>
    </div>
</template>

<script>
    import DetailList from 'base/detail-list/detail-list'
    import {mapGetters} from 'vuex'
    import {getSingerDetail} from 'api/singer'
    import {ERR_OK} from 'api/config'
    import {createSong} from 'common/js/song'

    export default {
        created() {
          if(!this.singer.id) {
            this.$router.push({
              path: '/singer'
            })
          }
          this._getSingerDetail()
        },
        data() {
          return {
            songs: []
          }
        },
        methods: {
          _getSingerDetail() {
            getSingerDetail(this.singer.id).then((res) => {
              if(res.code ===  ERR_OK) {
                this.songs = this.formatList(res.data.list)
              }
            })
          },
          back() {
            this.$router.back()
          },
          formatList(list) {
            let songs = []
            list.forEach((e) => {
              songs.push(createSong(e.musicData))
            })
            return songs;
          }
        },
        components: {
          DetailList
        },
        computed: {
          title() {
            return this.singer.name
          },
          avatar() {
            return this.singer.avatar
          },
          ...mapGetters([
            'singer'
          ])
        }
    }
</script>

<style lang="stylus" scoped>
    .detail
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