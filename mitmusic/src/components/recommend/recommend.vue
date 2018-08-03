<template>
    <div class="recommend">
        <avatar-list :list="list" @selectItem="selectItem"></avatar-list>
        <router-view></router-view>
    </div>
</template>

<script>
    import {getRecommend} from 'api/recommend'
    import {ERR_OK} from 'api/config'
    import avatarList from 'base/avatar-list/avatar-list'
    import {mapMutations} from 'vuex'

    export default {
      data() {
        return {
          list: []
        }
      },
      created() {
        this._getRecommend()
      },
      methods: {
        selectItem(item) {
            this.setRecommend(item)
            this.$router.push({
              path: `/recommend/${item.id}`,
            })
        },
        _getRecommend() {
          getRecommend().then((res) => {
            if(res.data.errorCode === ERR_OK) {
                this.list = this.normalizelist(res.data.data)
            }
          })
        },
        normalizelist(list) {
            return list;
        },
        ...mapMutations({
          'setRecommend': 'SET_RECOMMEND'
        })
      },
      components: {
        avatarList,

      }
    }
</script>

<style scoped lang="stylus">
    .recommend
        height: 100%
        position: relative
</style>