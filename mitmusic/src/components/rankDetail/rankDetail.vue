<template>
    <div class="rank">
        <span class="back" @click="back">Back</span>
        <detail-list :title="title" :avatar="avatar" :songs="songs"></detail-list>
    </div>
</template>

<script>
    import DetailList from 'base/detail-list/detail-list'
    import {mapGetters} from 'vuex'
    import {getMusicList} from 'api/rank'
    import {ERR_OK} from 'api/config'
    import {createSong} from 'common/js/song'

    export default {
        created() {
          if(!this.rank.id) {
            this.$router.push({
              path: '/rank'
            })
          }
          this._getRankDetail()
        },
        data() {
          return {
            songs: []
          }
        },
        methods: {
          _getRankDetail() {
            getMusicList(this.rank.id).then((res) => {
              if(res.code ===  ERR_OK) {
                this.songs = this.formatList(res.songlist)
              }
            })
          },
          back() {
            this.$router.back()
          },
          formatList(list) {
            let songs = []
            list.forEach((e) => {
              songs.push(createSong(e.data))
            })
            return songs;
          }
        },
        components: {
          DetailList
        },
        computed: {
          title() {
            return this.rank.name
          },
          avatar() {
            return this.rank.avatar
          },
          ...mapGetters([
            'rank'
          ])
        }
    }
</script>

<style lang="stylus" scoped>
    .rank
        position: absolute
        z-index: 1000
        top: 0
        left: 0
        width: 100%
        height: 100%
        background: #fff;
        .back
            position: absolute
            z-index: 1000
            right: 4px
            top: -40px
            font-size 19px
            cursor: pointer

</style>