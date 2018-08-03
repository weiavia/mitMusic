<template>
    <scroll class="scroll">
        <div>
            <div class="list-item clearfix" @click="showDetail" v-for="item in list">
                <img :src="avatar(item.user.avatar)" alt="">
                <h3 class="title">{{item.title}}</h3>
                <p class="describe">
                    {{item.content}}
                </p>
            </div>

        </div>
    </scroll>
</template>

<script>
  import Scroll from "base/scroll/scroll";
  import {Dialog} from 'element-ui'
  import {getForum} from 'api/forum'
  import {ERR_OK} from 'api/config'

  export default {
    data() {
      return {
        list: [],
        num: 10,
        limit: 0,
      }
    },
    created() {
      this.getList()
    },
    methods: {
      getList() {
        let param = {
            'limit': this.limit,
            'num': this.num
        }
        getForum(param).then((res) => {
            if(res.data.errorCode === ERR_OK) {
              this.list = res.data.data
            }
        })
      },
      showDetail() {
        this.$router.push({
          path: '/forum/1'
        })
      },
      avatar($a) {
        return 'http://mit.api.com/uploads/face/'+$a;
      },
      addToList(item) {
        console.log(item)
      }
    },
    components: {Scroll}
  }
</script>

<style lang="stylus" scoped>
    .scroll
        height: 100%

        overflow: hidden
        .list-item
            padding: 10px
            cursor: pointer
            transition: all 0.2s
            border: 1px dashed #e4e7ed
            margin-bottom: 10px
            img
                width: 80px
                height: 80px
                float: left
                margin-right: 10px
            .title
                font-size: 15px
                color: #333
                margin-bottom: 10px
            .describe
                line-height: 1.5
                font-size: 14px
                color: #666
        .list-item:hover
            background: #e4e7ed


</style>