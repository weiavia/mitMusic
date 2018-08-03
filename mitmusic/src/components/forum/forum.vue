<template>
    <div class="forum">
        <forum-list ref="list"></forum-list>
        <i class="askButton iconfont icon-wei-1" @click="askVisible = true"></i>
        <el-dialog title="发表问题" :visible.sync="askVisible" class="askBox">
            <el-input placeholder="输入你的标题" v-model="title"  class="title">
                <template slot="prepend">标题</template>
            </el-input>
            <el-input
                    type="textarea"
                    :rows="5"
                    placeholder="输入你的问题"
                    v-model="desc"
                    class="text"
            >

            </el-input>
            <el-button type="primary" @click="ask">发表</el-button>
        </el-dialog>
        <router-view></router-view>
    </div>
</template>

<script>
  import ForumList from 'components/forumList/forumList'
  import ElDialog from "../../../node_modules/element-ui/packages/dialog/src/component";
  import {addForum} from 'api/forum'
  import {ERR_OK} from 'api/config'

  export default {
    created() {
      this.$msgbox.alert('还在建设中~~~~~~~~~~~~~~~~~~~~')
    },
    data() {
      return {
        askVisible: false,
        title: '',
        desc: ''
      }
    },
    methods: {
      ask() {
        let param = {
          'title': this.title,
          'content': this.desc
        }
        addForum(param).then((res) => {
            if(res.data.errorCode === ERR_OK) {

              this.askVisible = false
              this.title = ''
              this.desc = ''

            }
        })
      }
    },
    components: {
      ForumList
    }
  }
</script>

<style lang="stylus" scoped>
    .forum
        position: relative
        height: 100%

    .askButton
        position: absolute
        width: 40px
        height: 40px
        line-height: 40px
        font-size: 20px
        cursor: pointer
        right: 20px
        bottom: 20px
        border: 1px solid #777
        border-radius: 50%
        text-align center
        background: rgba(200, 200, 200, 0.6);
    .askBox
        .title
            margin-bottom: 10px
        .text
            margin-bottom: 10px
</style>