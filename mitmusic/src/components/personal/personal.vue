<template>
    <div>
        <div class="face">
            <img :src="userInfo.avatar" alt="face" v-show="isLogin" @mouseover="showDetail" @mouseout="hideDetail"/>
            <i class="iconfont icon-icon" v-show="!isLogin" @click="login"></i>
        </div>
        <div class="message" v-if="message > 0">
            <span>3</span>
        </div>
        <transition name="detail">
            <div class="detail" @mouseover="clearCloseTime" @mouseout="setCloseTime" v-show="showDetailFlag">
            <div class="face">
                <img :src="userInfo.avatar" alt="face">
            </div>
            <p class="account">{{userInfo.account}}</p>
            <p class="name">{{userInfo.username}}<i class="iconfont icon-xiugaimima edit"></i></p>
            <div class="exit">
                <i class="iconfont icon-denglulogin10" @click="exit"></i>
            </div>
        </div>
        </transition>
    </div>
</template>

<script>
    import {mapGetters, mapActions, mapMutations} from 'vuex'
    import {clearToken, getToken} from 'common/js/token'
    import {isExpire} from 'common/js/check'
    import {MessageBox} from 'element-ui'
    import {getUserInfo} from 'api/user'
    import {ERR_OK} from 'api/config'
    import {getFavorites} from 'api/songList'

    export default {
      name: 'personal',
      data() {
        return {
          message: 0,
          showDetailFlag: false
        }
      },
      created() {
        // 1.判断用户是否登录过
        // 2.检查token是否过期然后在获取用户信息
        if(getToken()) {
          isExpire().then(() => {
            getUserInfo().then((res) => {
              if(res.data.errorCode === ERR_OK) {
                this.setUserInfo(res.data.data)
                this.setIsLogin(true)
              }
            })
            getFavorites()
          }).catch((msg) => {
            MessageBox.alert(msg).then(() => {
              this.setShowLogin(true)
              clearToken()
            })
          })
        }
        this.timer = null
      },
      methods: {
        login() {
            this.setShowLogin(true)
        },
        exit() {
          MessageBox.confirm('确定要退出登录吗?', '提示').then(() => {
            this.$notify('已安全退出~~~~~')
            clearToken()
            this.userExit();
          }).catch(() => {
            //todo 取消退出
          })
        },
        showDetail() {
          this.clearCloseTime()
          this.showDetailFlag = true
        },
        hideDetail() {
          this.setCloseTime()
        },
        clearCloseTime() {
          clearTimeout(this.timer)
        },
        setCloseTime() {
          this.timer = setTimeout(() => {
            this.showDetailFlag = false
          },100)
        },
        ...mapActions([
          'userExit'
        ]),
        ...mapMutations({
          'setShowLogin': 'SET_SHOW_LOGIN',
          'setUserInfo': 'SET_USER_INFO',
          'setIsLogin': 'SET_IS_LOGIN'
        })
      },
      computed: {
        ...mapGetters([
          'userInfo',
          'isLogin'
        ])
      }

    }
</script>

<style lang="stylus" scoped>
    @import "~common/stylus/variable.styl"
    .face
        width: 38px
        height: 38px
        line-height: 22px
        cursor pointer
        img
            border: 1px solid $borderColor
            width: 100%
            height: 100%
        .icon-icon
            color: #777
            font-size: 38px
    .message
        width: 20px
        height: 20px
        line-height 20px
        text-align: center
        box-sizing border-box
        border: 1px solid $borderColor
        position absolute
        font-size: 14px
        font-weight bold
        top: 0
        left: -19px
    .detail
        position: absolute
        right: -440px;
        top: -20px
        padding:20px;
        width: 280px;
        min-height: 2000px;
        background: #fff;
        border-left: 1px solid #eee;
        z-index: 999
        &.detail-enter-active, &.detail-leave-active
            transition: all 0.4s
        &.detail-enter, &.detail-leave-to
            transform: translateX(320px)
        .face
            width: 200px
            height: 200px
            margin: 0 auto
            img
                width: 100%
                height: 100%
        .account
            font-size: 20px;
            text-align: center
            line-height: 50px;
            color: #777
        .name
            text-align center
            color: #333
        .edit
            padding-left: 10px
            color: #444
            cursor: pointer
        .exit
            margin-top: 40px
            text-align center
            i
                cursor: pointer
                font-size: 40px;
                color: #444
</style>