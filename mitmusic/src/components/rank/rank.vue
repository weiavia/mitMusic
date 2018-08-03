<template>
    <div class="avatar">
        <avatar-list :list="rankList" @selectItem="selectItem"></avatar-list>
        <router-view></router-view>
    </div>
</template>

<script>
    import {getTopList} from 'api/rank'
    import {ERR_OK} from 'api/config'
    import Rank from 'common/js/rank'
    import AvatarList from 'base/avatar-list/avatar-list'
    import {mapMutations} from 'vuex'

    export default {
        name: 'rank',
        components: {
          AvatarList
        },
        data() {
          return {
            rankList: []
          }
        },
        created() {
          this._getRanks()
        },
        methods: {
          selectItem(rank) {
            this.$router.push({
              path: `/rank/${rank.id}`
            })
            this.setRank(rank)
          },
          _getRanks() {
            getTopList().then((res) => {
              if(res.code ===  ERR_OK) {
                this.rankList = this.normalizeRank(res.data.topList)
              }
            })
          },
          normalizeRank(list) {
            let res = []
            list.forEach((e) => {
              res.push(new Rank(e))
            })
            return res
          },
          ...mapMutations({
            'setRank': 'SET_RANK'
          })
        }

    }
</script>

<style lang="stylus" scope>
    .avatar
        height: 100%
        position: relative
</style>