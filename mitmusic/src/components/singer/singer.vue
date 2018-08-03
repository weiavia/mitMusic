<template>
    <div class="singer" :data="singerList">
        <avatar-list :list="singerList" @selectItem="selectItem"></avatar-list>
        <router-view></router-view>
    </div>
</template>
<script>
  import Scroll from 'base/scroll/scroll'
  import {getSingerList} from 'api/singer'
  import {ERR_OK} from 'api/config'
  import Singer from 'common/js/singer'
  import avatarList from 'base/avatar-list/avatar-list'
  import {mapMutations} from 'vuex'


  export default {
    data() {
      return {
        singerList: []
      };
    },
    created() {
        this._getSingerList()
    },
    methods: {
      selectItem(singer) {
        this.$router.push({
          path: `/singer/${singer.id}`
        })
        this.setSinger(singer)
      },
      _getSingerList() {
        getSingerList().then((res) => {
          if(res.code ===  ERR_OK) {
            this.singerList = this.normalizeSinger(res.data.list)
          }
        })
      },
      normalizeSinger(singers) {
        let res = []
        singers.forEach((e) => {
          res.push(new Singer(e))
        })
        return res
      },
      ...mapMutations({
        'setSinger': 'SET_SINGER'
      })
    },
    components: {
      Scroll,
      avatarList
    }
  };
</script>
<style lang="stylus" scope>
    .singer
        height: 100%
        position: relative

</style>


