<template>
    <div class="userWrapper" v-show="showLogin">
        <i class="iconfont icon-guanbi" @click="close"></i>

        <div class="login" v-show="curPage">
            <div class="faceWrapper">
                <img src="./default.png" alt="" v-show="!loginFace">
                <img :src="loginFace" alt="" v-show="loginFace">
            </div>
            <div class="formWrapper">
                <input type="text" placeholder="账号" ref="account" v-model="account" @input="getAvatar"/>
                <input type="password" placeholder="密码" ref="password"/>
                <div class="loginBtn" @click="login">登录</div>
            </div>
        </div>

        <div class="register" v-show="!curPage">
            <div class="faceWrapper">
                <upload
                        class="avatar-uploader"
                        action="http://mit.api.com/v1/avatar/upload"
                        name="image"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload"
                >
                    <img :src="imageSrc" class="avatar" v-if="imageSrc">
                    <i class="el-icon-plus avatar-uploader-icon" v-else></i>
                </upload>
            </div>
            <div class="formWrapper">
                <input type="text" placeholder="用户名称" ref="Rusername"/>
                <input type="text" placeholder="mit号 - 只能是数字" ref="Raccount"/>
                <input type="password" placeholder="mit号的密码" ref="Rpassword"/>
                <input type="password" placeholder="确认密码" ref="Rcpassword"/>

                <button id="TencentCaptcha"
                        data-appid="2018832834"
                        data-cbfn="captchaCallback"
                        class="verifyButton"
                        v-show="!verifyOk"
                >点击验证</button>

                <button class="verifyButton verifyOk" v-show="verifyOk">验证完成</button>

                <div class="registerBtn" @click="register">注册</div>
            </div>
        </div>

        <div class="changeBtn">
            <span v-show="curPage" @click="curPage=false">注册</span>
            <span v-show="!curPage" @click="curPage=true">登录</span>
        </div>
    </div>
</template>

<script>
  import {mapMutations, mapActions, mapGetters} from 'vuex'
  import {MessageBox, Upload} from 'element-ui'
  import {register, verify, serverVerify, login} from 'api/user'
  import {saveToken} from 'common/js/token'
  import {ERR_OK} from 'api/config'
  import Loading from 'base/loading/loading'
  import {ansyAvatar} from 'api/user'
  import "../../TCaptcha.js"

  export default {
    name: 'user',
    data() {
      return {
        curPage: true,
        verifyOk: false,
        imageSrc: '',
        fromImg: '',
        ing: false,
        account: '',
        loginFace: ''
      }
    },
    mounted() {
      window.captchaCallback = this.captchaCallback

    },
    components: {
      Upload,
      Loading
    },
    methods: {
      close() {
        this.setShowLogin(false)
      },
      register() {
        let param = this.registerParam()
        // todo 数据的验证
        if (!this.verifyOk) {
          MessageBox.alert('请先完成验证')
        } else {
          this.ing = true
          register(param).then((res) => {
            if(res.data.errorCode === ERR_OK) {
              this.userLogin(res.data.userInfo)
              saveToken(res.data.token)
              this.imgSrc = ''
              this.showLogin = true
              this.point('注册成功，已自动登录')
            }
          })
        }
      },
      registerParam() {
        let param = {
          username: this.$refs.Rusername.value,
          account: this.$refs.Raccount.value,
          password: this.$refs.Rpassword.value,
          cpassword: this.$refs.Rcpassword.value,
          avatar: this.fromImg
        }
        return param;
      },
      captchaCallback(res) {
        if (res.ret === 0) {
          this.verifyOk = true
          /*verify({ticket: res.ticket, randStr: res.randstr}).then((res) => {

          })*/
        } else {
        }
      },
      handleAvatarSuccess(res, file) {
        if(res.errorCode === ERR_OK) {
          this.imageSrc = res.data.url
          this.fromImg = res.data.filename
        }
      },
      beforeAvatarUpload(file) {
        const isJPG = file.type === 'image/jpeg';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPG) {
          this.$message.error('上传头像图片只能是 JPG 格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return isJPG && isLt2M;
      },
      getAvatar() {
        ansyAvatar({account: this.account}).then((res) => {
            if(res.data.errorCode === ERR_OK) {
              this.loginFace = res.data.avatar
            }
        }).catch(() => {
              this.loginFace = ''
        })
      },
      login() {
        let params = this.loginParam()
        login(params).then((res) => {
          if(res.data.errorCode === ERR_OK) {
            this.userLogin(res.data.userInfo)
            saveToken(res.data.token)
            this.$notify('登录成功')
            this.setShowLogin(false)
          }

        }).catch(() => {
          MessageBox('登录失败，用户名式密码错误', '提示')
        })
      },
      loginParam() {
        return {
          account: this.$refs.account.value,
          password: this.$refs.password.value
        }
      },
      ...mapActions(['userLogin']),
      ...mapMutations({
        'setIsLogin': 'SET_IS_LOGIN',
        'setShowLogin': 'SET_SHOW_LOGIN',
      })
    },
    watch: {
      showLogin() {
        this.verifyOk = false
      },
      curPage() {
        this.verifyOk = false
      }
    },
    computed: {
      ...mapGetters([
        'isLogin',
        'showLogin'
      ])
    }
  }
</script>

<style lang="stylus" scoped>
    .userWrapper
        height: 100%
        width: 320px
        background: #fff;
        border-left: 1px solid #eee
        position: absolute
        top: 0
        right: 0
        .icon-guanbi
            position: absolute
            font-size: 34px
            left: -44px
            top: 20px
            color: #777
            cursor: pointer
    .changeBtn
        text-align: center
        cursor: pointer
        color: #666
        margin-top: 20px
        font-size: 14px
    .register
        .formWrapper
            text-align: center
            input
                text-indent: 1em
                border: 1px solid #eee
                width: 260px
                height: 40px
                margin-top: 20px
            .verify
                margin-top: 20px
                cursor: pointer
                border: 1px solid #eee
            .registerBtn
                font-size: 30px
                margin-top: 20px
                color: #666
                cursor: pointer
            .loading
                display: flex
                justify-content center
                margin-top: 20px
            .verifyButton
                width: 260px
                height: 40px
                line-height: 40px
                border: 1px solid #eee
                background: #fff;
                outline: none
                margin-top: 20px
                cursor: pointer

                &.verifyOk
                    display: inline-block
                    border: 1px solid green
        .faceWrapper
            margin: 10px auto
            width: 150px
            height: 150px
            .avatar-uploader
                width: 100%
                height: 100%
                border: 1px dashed #d9d9d9
                border-radius: 6px
                cursor: pointer
                text-align: center
                position: relative
                overflow: hidden
            .avatar-uploader:hover
                border-color: #409EFF
            .avatar-uploader-icon
                font-size: 28px
                color: #8c939d
                width: 150px
                height: 150px
                line-height: 150px
                text-align: center
            .avatar
                width: 150px
                height: 150px
                display: block
    .login
        .faceWrapper
            width: 200px
            height: 200px
            text-align: center
            line-height: 100px
            border: 1px solid #eee
            margin: 20px auto 0
            img
                width: 100%
                height: 100%
        .formWrapper
            text-align: center
            input
                text-indent: 1em
                border: 1px solid #eee
                width: 260px
                height: 40px
                margin-top: 20px
            .verify
                margin-top: 20px
                cursor: pointer
                border: 1px solid #eee
            .loginBtn
                font-size: 30px
                margin-top: 20px
                color: #666
                cursor: pointer

</style>