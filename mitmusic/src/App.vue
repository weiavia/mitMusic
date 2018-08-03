<template>
    <div id="app">
        <m-header class="header"></m-header>
        <m-nav class="nav"></m-nav>
        <personal class="personal" @showLogin="showUser=true"></personal>
        <player class="player"></player>

        <div class="mainWrapper">
            <keep-alive>
                <router-view class="wei"></router-view>
            </keep-alive>
        </div>

        <search-box class="searchBox" @searchFocus="searchShow" ></search-box>
        <search :isShow="showSearch" @close="hideSearch"></search>
        <transition name="user">
            <user class="user"></user>
        </transition>
        <add-to-list></add-to-list>
    </div>
</template>

<script>
  import MHeader from 'components/m-header/m-header.vue'
  import MNav from 'components/m-nav/m-nav.vue'
  import Player from 'components/player/player.vue'
  import Scroll from 'base/scroll/scroll.vue'
  import Search from 'components/search/search.vue'
  import searchBox from 'base/search-box/search-box'

  import Personal from "components/personal/personal"
  import User from 'components/user/user'

  import AddToList from 'components/addToList/addToList.vue'

  import {getIndexList} from 'api/songList'
  import {normalizeSong} from 'common/js/utils'
  import {mapMutations, mapActions, mapGetters} from 'vuex'

  export default {
    name: 'App',
    data() {
      return {
        showSearch: false
      }
    },
    created() {
        this._getIndexPlayList()
    },
    methods: {
      searchShow() {
        this.showSearch = true
      },
      hideSearch() {
        this.showSearch = false
      },
      _getIndexPlayList() {
        getIndexList().then((res) => {
          let list = normalizeSong(res.data.data)
          this.selectPlay({
            list: list,
            index: 0,
            isPlay: false
          })
        })
      },
      ...mapActions(['selectPlay'])
    },
    components: {
      Personal,
      MHeader,
      MNav,
      Scroll,
      Player,
      searchBox,
      User,
      Search,
      AddToList
    }
  }
</script>

<style scoped lang="stylus" rel="stylesheet/stylus">
    #app
        overflow: hidden
        position: absolute
        top: 20px
        bottom: 20px
        left: 5%
        padding 20px
        width: calc(90% - 40px)
        min-width: 900px
        background: #fff;
        .header
            margin-bottom: 30px
            width: calc(100% - 410px)
        .nav
            margin-bottom 20px
        .personal
            position absolute
            top: 20px
            right: 440px
        .mainWrapper
            position relative
            float left
            width: calc(100% - 410px)
            height: calc(100% - 110px)
        .player
            float right
            height: calc(100% - 110px)
        .searchBox
            position absolute
            top 20px
            right 20px
        .user-enter-active, .user-leave-active
            transition: all 0.5s
        .user-enter, .user-leave-to
            transform: translateY(-100%);
</style>
